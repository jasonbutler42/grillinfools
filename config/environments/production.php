<?php
/* Production */
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');

define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);

define('FTP_PUBKEY',getenv('FTP_PUBKEY'));
define('FTP_PRIKEY',getenv('FTP_PRIKEY'));
define('FTP_USER',getenv('FTP_USER'));
define('FTP_PASS',getenv('FTP_PASS'));
define('FTP_HOST',getenv('FTP_HOST'));