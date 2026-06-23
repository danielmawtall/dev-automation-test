#!/bin/bash
# Footer menus, theme options, and homepage import.
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

# Custom menu items store URL in post meta (wp menu item update --url is unreliable).
docker exec "$CONTAINER" bash -c "${WP} post meta update 38 _menu_item_url '${BASE}/featured/'"
docker exec "$CONTAINER" bash -c "${WP} post meta update 44 _menu_item_url '${BASE}/'"
docker exec "$CONTAINER" bash -c "${WP} post meta update 45 _menu_item_url '${BASE}/agency/'"
docker exec "$CONTAINER" bash -c "${WP} post meta update 46 _menu_item_url '${BASE}/work/'"
docker exec "$CONTAINER" bash -c "${WP} post meta update 39 _menu_item_url 'https://www.instagram.com/tallagency/'"
docker exec "$CONTAINER" bash -c "${WP} post meta update 40 _menu_item_url 'https://www.linkedin.com/company/tall-agency/'"

docker exec "$CONTAINER" bash -c "${WP} option update blogdescription 'Brand, digital and design agency in Leeds'"

# Footer theme settings (ACF options)
docker exec "$CONTAINER" bash -c "${WP} option update options_footer_address \$'Address\n\nTall Agency Ltd\n5A Brewery Place\nLeeds\nLS10 1NE'"
docker exec "$CONTAINER" bash -c "${WP} option update options_footer_info \$'Info\n\nCompany No. 10616180\nVAT No. 262 1974 96\n0113 519 7773\nhello@tall.agency'"
docker exec "$CONTAINER" bash -c "${WP} option update options_footer_copyright 'Copyright © 2025 Tall Agency Ltd'"
docker exec "$CONTAINER" bash -c "${WP} option update options_agency_email 'hello@tall.agency'"

SKEWED_ID="${SKEWED_IMAGE_ID:-2438}"
FG0="${FEATURED_ITEM_0:-33}"
FG1="${FEATURED_ITEM_1:-32}"
FG2="${FEATURED_ITEM_2:-2018}"
FG3="${FEATURED_ITEM_3:-2086}"
FG4="${FEATURED_ITEM_4:-34}"
FG5="${FEATURED_ITEM_5:-31}"
FG6="${FEATURED_ITEM_6:-35}"
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
  FG6="${featured_item_6_id:-$FG6}"
fi

export SKEWED_ID FG0 FG1 FG2 FG3 FG4 FG5 FG6
perl -pe '
  s/SKEWED_IMAGE_PLACEHOLDER/$ENV{SKEWED_ID}/g;
  s/FEATURED_ITEM_0/$ENV{FG0}/g;
  s/FEATURED_ITEM_1/$ENV{FG1}/g;
  s/FEATURED_ITEM_2/$ENV{FG2}/g;
  s/FEATURED_ITEM_3/$ENV{FG3}/g;
  s/FEATURED_ITEM_4/$ENV{FG4}/g;
  s/FEATURED_ITEM_5/$ENV{FG5}/g;
  s/FEATURED_ITEM_6/$ENV{FG6}/g;
' scripts/homepage-content.txt > /tmp/homepage-content-live.txt
docker cp /tmp/homepage-content-live.txt "${CONTAINER}:/tmp/homepage-content.txt"
docker exec "$CONTAINER" bash -c "${WP} post update 7 --post_content=\"\$(cat /tmp/homepage-content.txt)\""
docker exec "$CONTAINER" bash -c "${WP} cache flush" 2>/dev/null || true

echo "Homepage menus, meta tagline, and content applied."
