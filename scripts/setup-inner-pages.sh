#!/bin/bash
# Import inner page block content (Work, Featured, Agency, LEGO case study).
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
# shellcheck disable=SC1091
source ./.env

CONTAINER="${CLIENT_NAME}-wordpress"
WP="wp --allow-root --path=/var/www/web/wp"
BASE="https://${DOCKER_HOSTNAME}"

if ! docker exec "$CONTAINER" test -x /usr/local/bin/wp 2>/dev/null; then
  docker exec "$CONTAINER" bash -c \
    'curl -fsSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x /usr/local/bin/wp'
fi

FG0="${FEATURED_ITEM_0:-33}"
FG1="${FEATURED_ITEM_1:-32}"
FG2="${FEATURED_ITEM_2:-2018}"
FG3="${FEATURED_ITEM_3:-2086}"
FG4="${FEATURED_ITEM_4:-34}"
FG5="${FEATURED_ITEM_5:-31}"
AGENCY_HERO="${AGENCY_HERO_ID:-}"
AGENCY_TEAM="${AGENCY_TEAM_ID:-}"
CS_LEGO_HERO="${CASE_STUDY_LEGO_HERO_ID:-}"
CS_LEGO_MEDIA="${CASE_STUDY_LEGO_MEDIA_ID:-}"

if [[ -f "${ROOT}/.build-assets/media-ids.env" ]]; then
  # shellcheck disable=SC1091
  source "${ROOT}/.build-assets/media-ids.env"
  FG0="${featured_item_0_id:-$FG0}"
  FG1="${featured_item_1_id:-$FG1}"
  FG2="${featured_item_2_id:-$FG2}"
  FG3="${featured_item_3_id:-$FG3}"
  FG4="${featured_item_4_id:-$FG4}"
  FG5="${featured_item_5_id:-$FG5}"
  AGENCY_HERO="${agency_hero_id:-$AGENCY_HERO}"
  AGENCY_TEAM="${agency_team_id:-$AGENCY_TEAM}"
  CS_LEGO_HERO="${case_study_lego_hero_id:-$CS_LEGO_HERO}"
  CS_LEGO_MEDIA="${case_study_lego_media_id:-$CS_LEGO_MEDIA}"
fi

apply_content() {
  local src="$1"
  local post_id="$2"
  local tmp="/tmp/inner-page-${post_id}.txt"
  perl -pe "
    s|FEATURED_ITEM_0|$FG0|g;
    s|FEATURED_ITEM_1|$FG1|g;
    s|FEATURED_ITEM_2|$FG2|g;
    s|FEATURED_ITEM_3|$FG3|g;
    s|FEATURED_ITEM_4|$FG4|g;
    s|FEATURED_ITEM_5|$FG5|g;
    s|AGENCY_HERO_PLACEHOLDER|$AGENCY_HERO|g;
    s|AGENCY_TEAM_PLACEHOLDER|$AGENCY_TEAM|g;
    s|CS_LEGO_HERO_PLACEHOLDER|$CS_LEGO_HERO|g;
    s|CS_LEGO_MEDIA_PLACEHOLDER|$CS_LEGO_MEDIA|g;
    s|auto-build-test.ssl.localhost|${DOCKER_HOSTNAME}|g;
  " "$src" > "$tmp"
  docker cp "$tmp" "${CONTAINER}:/tmp/inner-page-content.txt"
  docker exec "$CONTAINER" bash -c "${WP} post update ${post_id} --post_content=\"\$(cat /tmp/inner-page-content.txt)\""
}

apply_content scripts/work-page-content.txt 28
apply_content scripts/featured-page-content.txt 11
apply_content scripts/agency-page-content.txt 9
apply_content scripts/case-study-lego-content.txt 342

docker exec "$CONTAINER" bash -c "${WP} cache flush" 2>/dev/null || true
echo "Inner pages content applied (Work 28, Featured 11, Agency 9, Case study 342)."
