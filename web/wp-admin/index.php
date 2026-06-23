<?php
/**
 * WP Engine serves admin from the web root, not /wp/wp-admin/.
 */
require dirname(__DIR__) . '/app/wpe-cookie-bootstrap.php';
require dirname(__DIR__) . '/wp/wp-admin/index.php';
