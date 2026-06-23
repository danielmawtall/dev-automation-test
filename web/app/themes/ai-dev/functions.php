<?php
/**
 * AI Dev theme bootstrap.
 */

$wpe_url_fix = dirname(__DIR__, 2) . '/wpe-url-fix.php';

if (is_readable($wpe_url_fix)) {
  require_once $wpe_url_fix;
}

include_once 'includes/utils.php';
include_once 'includes/block-helpers.php';
include_once 'includes/acf-bootstrap.php';
include_once 'includes/acf-blocks.php';
include_once 'includes/acf-options.php';
include_once 'includes/clean-up.php';
include_once 'includes/custom-post-types.php';
include_once 'includes/taxonomies.php';
include_once 'includes/enqueue.php';
include_once 'includes/images.php';
include_once 'includes/menus.php';
include_once 'includes/admin-styles.php';
include_once 'includes/gravity-forms.php';
include_once 'includes/seo.php';
