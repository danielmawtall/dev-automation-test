<?php
/**
 * WP Engine serves login from the web root, not /wp/wp-login.php.
 */
require __DIR__ . '/app/wpe-cookie-bootstrap.php';
require __DIR__ . '/wp/wp-login.php';
