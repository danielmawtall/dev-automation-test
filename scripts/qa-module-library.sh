#!/bin/sh
# Structural QA for module library pages (Figma Module List groups).
set -eu

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
# shellcheck disable=SC1091
[ -f "$ROOT/.env" ] && . "$ROOT/.env"

WP_HOME="${WP_HOME:-https://auto-build-test.ssl.localhost}"
FAILURES=0

pass() { printf '  PASS  %s\n' "$1"; }
fail() { printf '  FAIL  %s\n' "$1"; FAILURES=$((FAILURES + 1)); }

check_page() {
  slug="$1"
  label="$2"
  url="${WP_HOME}/${slug}/"
  code=$(curl -skL -o /dev/null -w '%{http_code}' "$url")
  if [ "$code" = "200" ]; then
    pass "${label} HTTP 200"
  else
    fail "${label} HTTP $code"
    return
  fi
  HTML=$(curl -skL "$url")
  safe_slug=$(printf '%s' "$slug" | tr '/' '-')
  printf '%s' "$HTML" > "/tmp/qa-${safe_slug}.html"
}

check_pattern() {
  slug="$1"
  pattern="$2"
  label="$3"
  safe_slug=$(printf '%s' "$slug" | tr '/' '-')
  HTML=$(cat "/tmp/qa-${safe_slug}.html" 2>/dev/null || true)
  if printf '%s' "$HTML" | grep -q "$pattern"; then
    pass "$label"
  else
    fail "$label"
  fi
}

check_absent() {
  slug="$1"
  pattern="$2"
  label="$3"
  safe_slug=$(printf '%s' "$slug" | tr '/' '-')
  HTML=$(cat "/tmp/qa-${safe_slug}.html" 2>/dev/null || true)
  if printf '%s' "$HTML" | grep -q "$pattern"; then
    fail "$label"
  else
    pass "$label"
  fi
}

echo "Module library QA — structural gates"
echo "Base: $WP_HOME"
echo ""

check_page modules "Module library index"
check_pattern modules 'modules/1-0-headers/' 'Index: links to all groups'
check_pattern modules 'Figma Module List' 'Index: intro copy present'

check_page modules/global "Global"
check_pattern modules/global 'form-block' 'Global: form-block present'
check_pattern modules/global 'gform_wrapper\|gform_body\|gfield' 'Global: Gravity Form markup present'

check_page modules/1-0-headers "1.0 Headers"
check_pattern modules/1-0-headers 'homepage-header' 'Headers: homepage-header present'
check_pattern modules/1-0-headers 'media-header' 'Headers: media-header present'
check_pattern modules/1-0-headers 'event-header' 'Headers: 1B event-header present'
check_absent modules/1-0-headers 'Deferred — events' 'Headers: no deferred event stub'

check_page modules/2-0-cards "2.0 Cards"
check_pattern modules/2-0-cards 'event-card' 'Cards: 2A event-card present'
check_pattern modules/2-0-cards 'case-study-grid' 'Cards: case-study-grid present'
check_pattern modules/2-0-cards 'work-grid' 'Cards: work-grid present'
check_pattern modules/2-0-cards 'featured-grid' 'Cards: featured-grid present'

check_page modules/3-0-features "3.0 Features"
check_pattern modules/3-0-features 'skewed-reveal' 'Features: skewed-reveal present'
check_pattern modules/3-0-features 'featured-grid' 'Features: featured-grid present'
check_pattern modules/3-0-features 'centered-list' 'Features: centered-list present'
check_pattern modules/3-0-features 'centered-list--black' 'Features: centered-list black variant'
check_pattern modules/3-0-features 'case-study-grid' 'Features: 3I case-study-grid present'
check_pattern modules/3-0-features 'work-grid' 'Features: 3J work-grid present'
check_pattern modules/3-0-features 'two-column-list' 'Features: 3A two-column-list present'
check_pattern modules/3-0-features 'text-media' 'Features: 3E text-media present'
check_pattern modules/3-0-features 'sticky-scroll-media' 'Features: 3H sticky-scroll-media present'
check_pattern modules/3-0-features 'event-grid' 'Features: 3F event-grid present'
check_pattern modules/3-0-features 'form-block' 'Features: 3D form-block present'
check_pattern modules/3-0-features 'form-block--centered' 'Features: 3D centered form layout'
check_pattern modules/3-0-features 'two-column-list--orange' 'Features: 3A orange variant'
check_pattern modules/3-0-features 'two-column-list--black' 'Features: 3A black variant'
check_absent modules/3-0-features 'Deferred — events' 'Features: no deferred event stub'

check_page modules/4-0-carousel "4.0 Carousel"
check_pattern modules/4-0-carousel 'text-media-carousel__slide' 'Carousel: 4A text-media-carousel slides'
check_pattern modules/4-0-carousel 'mobile-case-study-carousel' 'Carousel: 4B mobile-case-study-carousel present'
check_pattern modules/4-0-carousel 'review-carousel' 'Carousel: 4C review-carousel present'

check_page modules/5-0-automatic "5.0 Automatic"
check_pattern modules/5-0-automatic 'scrolling-logos' 'Automatic: scrolling-logos present'
check_pattern modules/5-0-automatic 'scrolling-text' 'Automatic: scrolling-text present'

check_page modules/6-0-banner "6.0 Banner"
check_pattern modules/6-0-banner 'cta-banner' 'Banner: cta-banner present'
check_count=$(curl -skL "${WP_HOME}/modules/6-0-banner/" | grep -o 'cta-banner--' | wc -l | tr -d ' ')
if [ "$check_count" -ge 5 ]; then
  pass "Banner: 5 background variants ($check_count)"
else
  fail "Banner: expected 5 variants, found $check_count"
fi
check_pattern modules/6-0-banner 'cta-banner--forest' 'Banner: forest variant present'

check_page modules/7-0-text-layouts "7.0 Text layouts"
check_pattern modules/7-0-text-layouts 'text-block--intro' 'Text: intro variant present'
check_pattern modules/7-0-text-layouts 'two-columns' 'Text: two-columns present'
check_pattern modules/7-0-text-layouts 'heading-block' 'Text: 7B heading-block present'
check_pattern modules/7-0-text-layouts 'three-columns' 'Text: 7D three-columns present'

check_page modules/8-0-media "8.0 Media"
check_pattern modules/8-0-media 'full-width-media' 'Media: full-width-media present'
check_pattern modules/8-0-media 'full-container-media' 'Media: full-container-media present'
check_pattern modules/8-0-media 'media-grid' 'Media: media-grid present'
check_pattern modules/8-0-media 'three-quarter-media' 'Media: 8C three-quarter-media present'
check_pattern modules/8-0-media 'half-container-media' 'Media: 8D half-container-media present'
check_pattern modules/8-0-media 'quarter-container-media' 'Media: 8E quarter-container-media present'

check_absent modules/1-0-headers 'SKEWED_IMAGE_PLACEHOLDER' 'No unresolved content placeholders'
check_absent modules/3-0-features 'FEATURED_ITEM_0' 'No unresolved featured placeholders'

echo ""
if [ "$FAILURES" -eq 0 ]; then
  echo "All module library gates passed."
  exit 0
fi
echo "$FAILURES gate(s) failed."
exit 1
