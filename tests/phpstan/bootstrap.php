<?php

define( 'RWP_PLUGIN_VERSION', '0.2.0' );
define( 'RWP_PLUGIN_TEXTDOMAIN', 'rwp' );
define( 'RWP_PLUGIN_NAME', 'RIESTERWP Core' );
define( 'RWP_PLUGIN_ABSOLUTE', dirname( __DIR__, 2 ) . '/rwp.php' );
define( 'RWP_PLUGIN_ROOT', plugin_dir_path( RWP_PLUGIN_ABSOLUTE ) );
define( 'RWP_PLUGIN_URI', plugin_dir_url( RWP_PLUGIN_ABSOLUTE ) );
define( 'RWP_PLUGIN_VENDOR_PATH', RWP_PLUGIN_ROOT . 'includes/dependencies/' );
define( 'RWP_PLUGIN_WP_VERSION', '5.6' );
define( 'RWP_PLUGIN_PHP_VERSION', '7.0.0' );


require_once dirname( __DIR__, 3 ) . '/advanced-custom-fields-pro/acf.php';
require_once dirname( __DIR__, 3 ) . '/acf-extended/acf-extended.php';
