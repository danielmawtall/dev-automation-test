#!/bin/sh
# Typography structural QA — token presence in built CSS.
set -eu

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
# shellcheck disable=SC1091
[ -f "$ROOT/.env" ] && . "$ROOT/.env"

WP_HOME="${WP_HOME:-https://auto-build-test.ssl.localhost}"
THEME_SLUG="${THEME_SLUG:-ai-dev}"
CSS_URL="${WP_HOME}/app/themes/${THEME_SLUG}/dist/css/styles.css"
FAILURES=0

pass() { printf '  PASS  %s\n' "$1"; }
fail() { printf '  FAIL  %s\n' "$1"; FAILURES=$((FAILURES + 1)); }

check_css() {
  pattern="$1"
  label="$2"
  if printf '%s' "$CSS" | grep -q "$pattern"; then
    pass "$label"
  else
    fail "$label"
  fi
}

echo "Typography QA — compiled CSS tokens"
echo "CSS: $CSS_URL"
echo ""

CSS="$(curl -skL "$CSS_URL" 2>/dev/null || true)"
if [ -z "$CSS" ]; then
  fail "Could not load styles.css"
  exit 1
fi

check_css 'Anton' 'Font stack includes Anton (display)'
check_css 'IBM Plex Mono' 'Font stack includes IBM Plex Mono (caption)'
check_css 'Uncut Sans' 'Font stack names Uncut Sans (body primary)'
check_css 'text-display-l:10rem' 'Token --text-display-l (160px)'
check_css 'text-heading-l:2.5rem' 'Token --text-heading-l (40px)'
check_css 'text-body-l:1.5rem' 'Token --text-body-l (24px)'
check_css 'text-body-s:1rem' 'Token --text-body-s (16px footer)'
check_css 'text-caption' 'Token --text-caption (12px)'
check_css 'text-marquee-max:18.75rem' 'Token --text-marquee-max (300px)'

echo ""
if [ "$FAILURES" -eq 0 ]; then
  echo "Typography CSS gates passed."
  echo "Run scripts/qa-typography-audit.js in Chrome DevTools @ 1440px for live computed values."
  exit 0
fi
echo "$FAILURES typography gate(s) failed."
exit 1
