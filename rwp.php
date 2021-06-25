<?php
/** ============================================================================
 * Plugin Name:     RIESTERWP Core
 * Plugin URI:      @TODO
 * Description:     @TODO
 * Version:         1.0.0
 * Author:          RIESTER Advertising Agency
 * Author URI:      https://www.riester.com
 * Text Domain:     rwp
 * License:         GPL 2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.0
 * WordPress-Plugin-Boilerplate-Powered: v3.2.0
 * ========================================================================== */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'RWP_PLUGIN_VERSION', '1.0.0' );
define( 'RWP_PLUGIN_TEXTDOMAIN', 'rwp' );
define( 'RWP_PLUGIN_NAME', 'RIESTERWP Core' );
define( 'RWP_PLUGIN_WP_VERSION', '5.6' );
define( 'RWP_PLUGIN_PHP_VERSION', '7.0.0' );
define( 'RWP_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'RWP_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'RWP_PLUGIN_ABSOLUTE', __FILE__ );
define( 'RWP_PLUGIN_VENDOR_PATH', RWP_PLUGIN_ROOT . 'includes/dependencies/' );

add_action(
	'init',
	static function () {
		load_plugin_textdomain( RWP_PLUGIN_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
);

if ( version_compare( PHP_VERSION, '7.0.0', '<=' ) ) {
	add_action(
		'admin_init',
		static function() {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	);
	add_action(
		'admin_notices',
		static function() {
			echo wp_kses_post(
                sprintf(
                    '<div class="notice notice-error"><p>%s</p></div>',
                    __( '"RWP" requires PHP 7.0.0 or newer.', 'rwp' )
                )
			);
		}
	);

	// Return early to prevent loading the plugin.
	return;
}


$rwp_libraries = require __DIR__ . '/vendor/autoload.php';

require_once RWP_PLUGIN_VENDOR_PATH . 'vendor/scoper-autoload.php';

// $rwp_requirements = new RWP\Vendor\Micropackage\Requirements\Requirements(
// 	RWP_PLUGIN_NAME,
// 	array(
// 		'php'            => RWP_PLUGIN_PHP_VERSION,
// 		'php_extensions' => array( 'mbstring' ),
// 		'wp'             => RWP_PLUGIN_WP_VERSION,
//     )
// );

// if ( ! $rwp_requirements->satisfied() ) {
// 	$rwp_requirements->print_notice();

// 	return;
// }


require_once RWP_PLUGIN_ROOT . 'includes/functions/functions.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/utils.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/filters.php';


// Documentation to integrate GitHub, GitLab or BitBucket https://github.com/YahnisElsts/plugin-update-checker/blob/master/README.md
// Puc_v4_Factory::buildUpdateChecker(
// 	'https://github.com/user-name/repo-name/',
// 	__FILE__,
// 	'unique-plugin-or-theme-slug'
// );

if ( ! wp_installing() ) {
	add_action(
		'plugins_loaded',
		static function () use ( $rwp_libraries ) {
			new \RWP\Engine\Initialize( $rwp_libraries );
		}
	);
}
