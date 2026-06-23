<?php
/**
 * Configuration overrides for WP_ENV === 'staging'
 */

use Roots\WPConfig\Config;

Config::define('DISALLOW_INDEXING', true);

// WPE maps web/app to the public /wp-content URL (not /app).
Config::define('WP_CONTENT_URL', env('WP_HOME') . '/wp-content');
