#!/bin/bash
# Create module library pages grouped like the Figma Module List (74:27).
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
# shellcheck disable=SC1091
source ./.env

CONTAINER="${CLIENT_NAME}-wordpress"
WP="wp --allow-root --path=/var/www/web/wp"
BASE="https://${DOCKER_HOSTNAME}"
LIB_DIR="${ROOT}/scripts/module-library"

if ! docker exec "$CONTAINER" test -x /usr/local/bin/wp 2>/dev/null; then
  docker exec "$CONTAINER" bash -c \
    'curl -fsSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x /usr/local/bin/wp'
fi

SKEWED_ID="${SKEWED_IMAGE_ID:-2438}"
FG0="${FEATURED_ITEM_0:-33}"
FG1="${FEATURED_ITEM_1:-32}"
FG2="${FEATURED_ITEM_2:-2018}"
FG3="${FEATURED_ITEM_3:-2086}"
FG4="${FEATURED_ITEM_4:-34}"
FG5="${FEATURED_ITEM_5:-31}"
AGENCY_HERO="${AGENCY_HERO_ID:-}"
AGENCY_TEAM="${AGENCY_TEAM_ID:-}"
CS_LEGO_MEDIA="${CASE_STUDY_LEGO_MEDIA_ID:-}"

if [[ -f "${ROOT}/.build-assets/media-ids.env" ]]; then
  # shellcheck disable=SC1091
  source "${ROOT}/.build-assets/media-ids.env"
  SKEWED_ID="${skewed_reveal_image_id:-$SKEWED_ID}"
  FG0="${featured_item_0_id:-$FG0}"
  FG1="${featured_item_1_id:-$FG1}"
  FG2="${featured_item_2_id:-$FG2}"
  FG3="${featured_item_3_id:-$FG3}"
  FG4="${featured_item_4_id:-$FG4}"
  FG5="${featured_item_5_id:-$FG5}"
  AGENCY_HERO="${agency_hero_id:-$AGENCY_HERO}"
  AGENCY_TEAM="${agency_team_id:-$AGENCY_TEAM}"
  CS_LEGO_MEDIA="${case_study_lego_media_id:-$CS_LEGO_MEDIA}"
fi

substitute_placeholders() {
  local src="$1"
  local dest="$2"
  perl -pe "
    s|SKEWED_IMAGE_PLACEHOLDER|${SKEWED_ID}|g;
    s|FEATURED_ITEM_0|${FG0}|g;
    s|FEATURED_ITEM_1|${FG1}|g;
    s|FEATURED_ITEM_2|${FG2}|g;
    s|FEATURED_ITEM_3|${FG3}|g;
    s|FEATURED_ITEM_4|${FG4}|g;
    s|FEATURED_ITEM_5|${FG5}|g;
    s|AGENCY_HERO_PLACEHOLDER|${AGENCY_HERO}|g;
    s|AGENCY_TEAM_PLACEHOLDER|${AGENCY_TEAM}|g;
    s|CS_LEGO_MEDIA_PLACEHOLDER|${CS_LEGO_MEDIA}|g;
    s|HOSTNAME_PLACEHOLDER|${BASE}|g;
    s|auto-build-test.ssl.localhost|${DOCKER_HOSTNAME}|g;
  " "$src" > "$dest"
}

get_page_id_by_slug() {
  local slug="$1"
  local parent="${2:-0}"
  docker exec "$CONTAINER" bash -c \
    "${WP} post list --post_type=page --name='${slug}' --post_parent=${parent} --field=ID --format=ids 2>/dev/null" \
    | tr -d '[:space:]'
}

create_or_update_page() {
  local title="$1"
  local slug="$2"
  local parent_id="$3"
  local content_src="$4"

  local post_id
  post_id="$(get_page_id_by_slug "$slug" "$parent_id")"

  if [[ -z "$post_id" ]]; then
    post_id="$(docker exec "$CONTAINER" bash -c \
      "${WP} post create --post_type=page --post_status=publish --post_title='${title}' --post_name='${slug}' --post_parent=${parent_id} --porcelain")"
  else
    docker exec "$CONTAINER" bash -c \
      "${WP} post update ${post_id} --post_title='${title}' --post_status=publish --post_parent=${parent_id}"
  fi

  local tmp="/tmp/module-library-${slug}.txt"
  substitute_placeholders "$content_src" "$tmp"
  docker cp "$tmp" "${CONTAINER}:/tmp/module-library-content.txt"
  docker exec "$CONTAINER" bash -c "${WP} post update ${post_id} --post_content=\"\$(cat /tmp/module-library-content.txt)\""
  echo "${slug} -> ${BASE}/modules/${slug}/ (ID ${post_id})"
}

PARENT_ID="$(get_page_id_by_slug "modules" "0")"
if [[ -z "$PARENT_ID" ]]; then
  PARENT_ID="$(docker exec "$CONTAINER" bash -c \
    "${WP} post create --post_type=page --post_status=publish --post_title='Module Library' --post_name='modules' --porcelain")"
fi

substitute_placeholders "${LIB_DIR}/index.txt" /tmp/module-library-index.txt
docker cp /tmp/module-library-index.txt "${CONTAINER}:/tmp/module-library-index.txt"
docker exec "$CONTAINER" bash -c "${WP} post update ${PARENT_ID} --post_title='Module Library' --post_content=\"\$(cat /tmp/module-library-index.txt)\""

create_or_update_page "Global" "global" "$PARENT_ID" "${LIB_DIR}/global.txt"
create_or_update_page "1.0 Headers" "1-0-headers" "$PARENT_ID" "${LIB_DIR}/1-0-headers.txt"
create_or_update_page "2.0 Cards" "2-0-cards" "$PARENT_ID" "${LIB_DIR}/2-0-cards.txt"
create_or_update_page "3.0 Features" "3-0-features" "$PARENT_ID" "${LIB_DIR}/3-0-features.txt"
create_or_update_page "4.0 Carousel" "4-0-carousel" "$PARENT_ID" "${LIB_DIR}/4-0-carousel.txt"
create_or_update_page "5.0 Automatic" "5-0-automatic" "$PARENT_ID" "${LIB_DIR}/5-0-automatic.txt"
create_or_update_page "6.0 Banner" "6-0-banner" "$PARENT_ID" "${LIB_DIR}/6-0-banner.txt"
create_or_update_page "7.0 Text Layouts" "7-0-text-layouts" "$PARENT_ID" "${LIB_DIR}/7-0-text-layouts.txt"
create_or_update_page "8.0 Media" "8-0-media" "$PARENT_ID" "${LIB_DIR}/8-0-media.txt"

docker exec "$CONTAINER" bash -c "${WP} cache flush" 2>/dev/null || true
echo "Module library ready at ${BASE}/modules/"
