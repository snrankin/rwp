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
define( 'RWP_PLUGIN_ROOT',  trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'RWP_PLUGIN_URI',  trailingslashit( plugin_dir_url( __FILE__ ) ) );
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

/**
 * Register the required plugins for this plugin
 */
function rwp_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'Advanced Custom Fields Pro', // The plugin name.
			'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
			'source'             => dirname( __FILE__ ) . '/includes/dependencies/externals/plugins/advanced-custom-fields-pro.zip', // The plugin source.
			'required'           => true,
		),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Advanced Custom Fields: Extended',
			'slug'      => 'acf-extended',
			'required'  => true,
		),
		array(
			'name'        => 'WordPress SEO by Yoast',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'rwp',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'rwp_register_required_plugins' );


require_once RWP_PLUGIN_ROOT . 'includes/functions/functions.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/utils.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/filters.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/components.php';

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
