#!/bin/bash
# Download Figma MCP assets and import into WordPress media library.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
# shellcheck disable=SC1091
source ./.env

CONTAINER="${CLIENT_NAME}-wordpress"
ASSETS_DIR="${ROOT}/.build-assets"
WP="wp --allow-root --path=/var/www/web/wp"

mkdir -p "$ASSETS_DIR"

download() {
  local name="$1"
  local url="$2"
  local out="${ASSETS_DIR}/${name}"
  if [[ ! -f "$out" ]]; then
    curl -fsSL "$url" -o "$out"
  fi
  echo "$out"
}

# Skewed reveal centre portrait (Figma 76:3992)
SKEWED_IMG=$(download "skewed-reveal-portrait.jpg" "https://www.figma.com/api/mcp/asset/23fba8f6-8e97-40b1-912e-5280165e2ac3")
RESHAPE_IMG=$(download "footer-reshape-possible.svg" "https://www.figma.com/api/mcp/asset/988c298b-2b79-4dc1-84ba-31935c34d332")
CASE_LEGO="${ROOT}/web/app/themes/ai-dev/assets/img/lego-creative-quests.jpg"
CASE_TOFOO=$(download "case-study-tofoo.png" "https://www.figma.com/api/mcp/asset/884b628b-225b-42e7-bd78-ffcee463b387")
FG_LEADERSHIP=$(download "featured-leadership.jpg" "https://www.figma.com/api/mcp/asset/89942264-ac1a-48e4-a3f0-5f265572a6e0")
FG_TOFOO=$(download "featured-tofoo.png" "https://www.figma.com/api/mcp/asset/108c8cb7-9f19-454d-bfb8-c4669c9525d9")
FG_TSHIRT=$(download "featured-tshirt.jpg" "https://www.figma.com/api/mcp/asset/8421d0f0-121c-4b05-a255-299637d63daf")
FG_LEGO_CAT=$(download "featured-lego-cat.jpg" "https://www.figma.com/api/mcp/asset/49f3ec0d-ea86-4135-8211-14b6e24ea168")
FG_POTATO=$(download "featured-potato.jpg" "https://www.figma.com/api/mcp/asset/19f0b521-beb2-438f-b9f7-f8e60790cd40")
FG_NANNA=$(download "featured-nanna.jpg" "https://www.figma.com/api/mcp/asset/87a72b2f-8e34-41bf-8d76-d5ec09b682f3")
mkdir -p "${ROOT}/web/app/themes/ai-dev/assets/img"
cp "$RESHAPE_IMG" "${ROOT}/web/app/themes/ai-dev/assets/img/footer-reshape-possible.svg"

if ! docker exec "$CONTAINER" test -x /usr/local/bin/wp 2>/dev/null; then
  docker exec "$CONTAINER" bash -c \
    'curl -fsSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x /usr/local/bin/wp'
fi

import_media() {
  local file="$1"
  local title="$2"
  local ext="${file##*.}"
  docker cp "$file" "${CONTAINER}:/tmp/import-asset.${ext}"
  docker exec "$CONTAINER" bash -c "${WP} media import /tmp/import-asset.${ext} --title='${title}' --porcelain"
}

SKEWED_ID=$(import_media "$SKEWED_IMG" "Skewed reveal portrait")
LEGO_THUMB_ID=$(import_media "$CASE_LEGO" "Case study LEGO grid")
TOFOO_THUMB_ID=$(import_media "$CASE_TOFOO" "Case study Tofoo grid")
FG0_ID=$(import_media "$FG_LEADERSHIP" "Featured leadership")
FG1_ID=$(import_media "$FG_TOFOO" "Featured Tofoo campaign")
FG2_ID=$(import_media "$FG_TSHIRT" "Featured t-shirt")
FG3_ID=$(import_media "$FG_LEGO_CAT" "Featured LEGO cat")
FG4_ID=$(import_media "$FG_NANNA" "Featured Nanna Tate")
FG5_ID=$(import_media "$FG_POTATO" "Featured potato branding")
FG_PROLIFIC="${ASSETS_DIR}/featured-prolific.png"
if [[ ! -f "$FG_PROLIFIC" ]] && [[ -f "${ASSETS_DIR}/featured-prolific.svg" ]]; then
  sips -s format png "${ASSETS_DIR}/featured-prolific.svg" --out "$FG_PROLIFIC" >/dev/null 2>&1 || true
fi
FG6_ID=""
if [[ -f "$FG_PROLIFIC" ]]; then
  FG6_ID=$(import_media "$FG_PROLIFIC" "Featured Prolific North badge")
fi
AGENCY_HERO=$(download "agency-hero.jpg" "https://www.figma.com/api/mcp/asset/defce707-60eb-4c5e-a1ec-c8b956f97d3b")
AGENCY_TEAM=$(download "agency-team.jpg" "https://www.figma.com/api/mcp/asset/b9bc9d58-4491-4cb4-a8bf-6fc6ae75a023")
CS_LEGO_HERO=$(download "case-study-lego-hero.jpg" "https://www.figma.com/api/mcp/asset/458f5304-a45d-4132-a2ae-3f127b0a3c8b")
CS_LEGO_MEDIA=$(download "case-study-lego-media.jpg" "https://www.figma.com/api/mcp/asset/888e7eae-bcac-499e-b867-085fd32ee003")

AGENCY_HERO_ID=$(import_media "$AGENCY_HERO" "Agency hero")
AGENCY_TEAM_ID=$(import_media "$AGENCY_TEAM" "Agency team")
CS_LEGO_HERO_ID=$(import_media "$CS_LEGO_HERO" "Case study LEGO hero")
CS_LEGO_MEDIA_ID=$(import_media "$CS_LEGO_MEDIA" "Case study LEGO media")

docker exec "$CONTAINER" bash -c "${WP} post meta update 342 _thumbnail_id ${LEGO_THUMB_ID}"
docker exec "$CONTAINER" bash -c "${WP} post meta update 344 _thumbnail_id ${TOFOO_THUMB_ID}"

cat > "${ASSETS_DIR}/media-ids.env" <<EOF
skewed_reveal_image_id=${SKEWED_ID}
case_study_lego_thumb_id=${LEGO_THUMB_ID}
case_study_tofoo_thumb_id=${TOFOO_THUMB_ID}
featured_item_0_id=${FG0_ID}
featured_item_1_id=${FG1_ID}
featured_item_2_id=${FG2_ID}
featured_item_3_id=${FG3_ID}
featured_item_4_id=${FG4_ID}
featured_item_5_id=${FG5_ID}
featured_item_6_id=${FG6_ID}
agency_hero_id=${AGENCY_HERO_ID}
agency_team_id=${AGENCY_TEAM_ID}
case_study_lego_hero_id=${CS_LEGO_HERO_ID}
case_study_lego_media_id=${CS_LEGO_MEDIA_ID}
EOF

echo "Imported Figma assets to media-ids.env"
cat "${ASSETS_DIR}/media-ids.env"
