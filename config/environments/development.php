<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;
use function Env\env;

/*
 * WP Engine mu-plugins expect PWP_NAME and WPE_APIKEY when running WPE-specific code locally.
 */
Config::define('PWP_NAME', env('PWP_NAME') ?: 'binder-local');
Config::define('WPE_APIKEY', env('WPE_APIKEY') ?: 'local-dev-not-used');
Config::define('WPE_DISABLE_CACHE_PURGING', true);
Config::define('WPE_NO_HTML_FILTER', true);

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', false);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', false);
Config::define('DISALLOW_INDEXING', true);

ini_set('display_errors', '0');

Config::define('DISALLOW_FILE_MODS', false);
