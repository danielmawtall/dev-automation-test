#!/bin/sh
# Structural homepage QA gates — run before Phase 4/5 sign-off.
# Browser overflow: paste scripts/qa-homepage-overflow.js in Chrome DevTools.
set -eu

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
# shellcheck disable=SC1091
[ -f "$ROOT/.env" ] && . "$ROOT/.env"

WP_HOME="${WP_HOME:-https://auto-build-test.ssl.localhost}"
THEME_SLUG="${THEME_SLUG:-ai-dev}"
CSS_URL="${WP_HOME}/app/themes/${THEME_SLUG}/dist/css/styles.css"

FAILURES=0
CYCLE="${QA_CYCLE:-next}"

pass() {
  printf '  PASS  %s\n' "$1"
}

fail() {
  printf '  FAIL  %s\n' "$1"
  FAILURES=$((FAILURES + 1))
}

check_html() {
  pattern="$1"
  label="$2"
  if printf '%s' "$HTML" | grep -q "$pattern"; then
    pass "$label"
  else
    fail "$label"
  fi
}

check_html_absent() {
  pattern="$1"
  label="$2"
  if printf '%s' "$HTML" | grep -q "$pattern"; then
    fail "$label"
  else
    pass "$label"
  fi
}

check_count_min() {
  pattern="$1"
  min="$2"
  label="$3"
  count=$(printf '%s' "$HTML" | grep -oE "$pattern" | wc -l | tr -d ' ')
  if [ "$count" -ge "$min" ]; then
    pass "$label ($count >= $min)"
  else
    fail "$label ($count < $min)"
  fi
}

echo "Homepage QA — structural gates"
echo "URL: $WP_HOME"
echo "Cycle: $CYCLE"
echo ""

HTML="$(curl -skL -o /dev/null -w '%{http_code}' "$WP_HOME/")"
if [ "$HTML" = "200" ]; then
  pass "Homepage HTTP 200"
else
  fail "Homepage HTTP $HTML (expected 200)"
fi

HTML="$(curl -skL "$WP_HOME/")"
CSS="$(curl -skL "$CSS_URL" 2>/dev/null || true)"

echo ""
echo "Markup"
check_html 'name="description"' 'Meta description present'
check_html 'id="site-header"' 'Site header present'
check_html 'site-header__cta button button--underline' 'Header CTA is underline variant'
check_html_absent 'site-header__cta button button--solid' 'Header CTA is not solid variant'
check_html 'class="homepage-header' 'Homepage header block present'
check_html 'text-block--intro' 'Intro text block (style intro) present'
check_html 'class="skewed-reveal' 'Skewed reveal block present'
check_html 'class="case-study-grid' 'Case study grid block present'
check_html 'class="scrolling-logos' 'Scrolling logos block present'
check_html 'class="featured-grid' 'Featured grid block present'
check_count_min '<article class="featured-card' 8 'Featured grid has 8 cards'
check_html 'id="site-footer"' 'Site footer present'
check_html 'site-footer__top-links' 'Footer top links row present'
check_html 'site-footer__main' 'Footer main columns present'
check_html 'site-footer__reshape' 'Footer reshape panel present'
check_html 'site-footer__reshape-image' 'Footer reshape image present'
check_html 'site-footer__bar' 'Footer copyright bar present'
check_html_absent 'site-footer__scroll-text' 'No legacy footer scroll-text hack'

echo ""
echo "Stylesheet ($CSS_URL)"
if [ -z "$CSS" ]; then
  fail "Could not fetch theme stylesheet"
else
  if printf '%s' "$CSS" | grep -q 'overflow-x:clip'; then
    pass 'overflow-x: clip in built CSS'
  else
    fail 'overflow-x: clip missing from built CSS'
  fi

  if printf '%s' "$CSS" | grep -q 'site-header.*mix-blend-mode\|mix-blend-mode:difference'; then
    fail 'mix-blend-mode on site header (forbidden on ivory nav)'
  else
    pass 'No mix-blend-mode on site header'
  fi
fi

echo ""
echo "Browser gates (manual — High severity)"
echo "  1. Open $WP_HOME at 1440px and 390px"
echo "  2. DevTools Console → paste scripts/qa-homepage-overflow.js"
echo "  3. Save screenshots per docs/build/QA_CHECKLIST.md"
echo "  4. Compare modules to Figma nodes in QA_CHECKLIST module matrix"
echo ""

if [ "$FAILURES" -eq 0 ]; then
  echo "RESULT: PASS ($FAILURES structural failures)"
  echo "Next: complete browser + module matrix in docs/build/QA_CHECKLIST.md"
  exit 0
fi

echo "RESULT: FAIL ($FAILURES structural failures)"
echo "Fix failures before marking Phase 4/5 done. See docs/build/QA_CHECKLIST.md"
exit 1
