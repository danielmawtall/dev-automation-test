<?php
# Database Configuration
define( 'DB_NAME', 'wp_talldevstg' );
define( 'DB_USER', 'talldevstg' );
define( 'DB_PASSWORD', 'd0fRJfkpBFs12kWApZW1' );
define( 'DB_HOST', '127.0.0.1:3306' );
define( 'DB_HOST_SLAVE', '127.0.0.1:3306' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'Y0(TvG@f8cd?Vl5rdjs591lOGxxx65FYG$*1Zh6i)8ZgE4l#$Gam2ZZxy,M?KsK0');
define('SECURE_AUTH_KEY',  'eF8j0cC?MB$Bk@F5+bbc!RRqdHI~4z#9yGt&.DkuvX&ST#0FMYw,^ZT(4B==&Nk5');
define('LOGGED_IN_KEY',    '&E+-bmDC7Cm.GiDh55StaNKMFl(9_--dyZlpO=T@yT9h.?P=,v.1s*7G0b2%&hBt');
define('NONCE_KEY',        'tjxyy+1+5cR.1p~oIT(N@LP#5HDCy7ttBDRrsU^3r9GKEaBGx8=-ZQZZy4=PqRAo');
define('AUTH_SALT',        '60lkUb2Cawo2?5EWE=z1cNpjenO%K$QyQXnHZ,7JxvS7_Kqh07JmM!b66oqv1!_^');
define('SECURE_AUTH_SALT', 'r,Kh%,gX!wu)21ylx9v+pEL^fVug++lE7gBNrVZW#d$$wNX33~YzaA-G+Qx@dmog');
define('LOGGED_IN_SALT',   'uprYGgJV?=Z3KB4zr!EClL+1^d5MPc^jZ1xrL^tJ~GYUjnF^(-+ntDS&iy1HZSPJ');
define('NONCE_SALT',       '7%E_F4h%O3~GB5t5%M_LPzKc3-E.Mw3dCAKYP(=G4P&dlx7L,Rn-I(++Ot?jE2Ge');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'talldevstg' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'WPE_APIKEY', '555c5bd77f0e0348ee2fc81d9d996a21aa787909' );

define( 'WPE_CLUSTER_ID', '215322' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_SFTP_ENDPOINT', '35.242.161.108' );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', 250 );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'talldevstg.wpengine.com', 1 => 'talldevstg.wpenginepowered.com', );

$wpe_varnish_servers=array ( 0 => '127.0.0.1', );

$wpe_special_ips=array ( 0 => '34.89.75.223', 1 => 'pod-215322-utility.pod-215322.svc.cluster.local', );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', __DIR__ . '/');
require_once(ABSPATH . 'wp-settings.php');
