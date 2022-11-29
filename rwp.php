<?php

/** ============================================================================
 * RIESTERWP Core
 *
 * @package     RWP
 * @author      RIESTER Advertising Agency
 * @copyright   2020 RIESTER Advertising Agency
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: RIESTERWP Core
 * Plugin URI: https://bitbucket.org/riester/rwp/src/master/README.md
 * Description: An internal plugin for websites created by RIESTER to enhance functionality
 * Version: 0.12.0
 * Tested up to: 6.0.1
 * Author: RIESTER Advertising Agency
 * Author URI: https://www.riester.com
 * Text Domain: rwp
 * Domain Path: /languages
 * Update URI: https://digital.riester.com/plugin/?action=download&slug=rwp
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires PHP: 7.0
 * Requires at least: 5.6
 * ========================================================================== */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

define( 'RWP_PLUGIN_TEXTDOMAIN', 'rwp' );
define( 'RWP_PLUGIN_NAME', 'RIESTERWP Core' );
define( 'RWP_PLUGIN_WP_VERSION', '5.6' );
define( 'RWP_PLUGIN_PHP_VERSION', '7.0.0' );
define( 'RWP_PLUGIN_ROOT', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'RWP_PLUGIN_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'RWP_PLUGIN_FILE', __FILE__ );
define( 'RWP_PLUGIN_VENDOR_PATH', RWP_PLUGIN_ROOT . 'dependencies/' );

/**
 * Load rwp textdomain.
 *
 * Load gettext translate for rwp text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function rwp_load_plugin_textdomain() {
	load_plugin_textdomain( 'rwp' );
}
add_action( 'plugins_loaded', 'rwp_load_plugin_textdomain' );

/**
 * rwp admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function rwp_fail_php_version() {
	/* translators: %s: PHP version. */
	$message = sprintf( esc_html__( 'rwp requires PHP version %s+, plugin is currently NOT RUNNING.', 'rwp' ), '5.6' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * rwp admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since 1.5.0
 *
 * @return void
 */
function rwp_fail_wp_version() {
	/* translators: %s: WordPress version. */
	$message = sprintf( esc_html__( 'rwp requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'rwp' ), '5.6' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
require_once RWP_PLUGIN_VENDOR_PATH . 'vendor/scoper-autoload.php';

if ( ! version_compare( PHP_VERSION, '7.0', '>=' ) ) {
	add_action( 'admin_notices', 'rwp_fail_php_version' );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '5.6', '>=' ) ) {
	add_action( 'admin_notices', 'rwp_fail_wp_version' );
} else {
	require RWP_PLUGIN_ROOT . '/includes/autoloader.php';
	\RWP\Autoloader::run( RWP_PLUGIN_ROOT . '/includes/core' );


	require_once RWP_PLUGIN_ROOT . 'includes/functions/utils.php';
	require_once RWP_PLUGIN_ROOT . 'includes/functions/filters.php';
	require RWP_PLUGIN_ROOT . 'includes/plugin.php';
	require_once RWP_PLUGIN_ROOT . 'includes/functions/helpers.php';
}


/**
 * Register the required plugins for this plugin
 */
function rwp_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     => 'Advanced Custom Fields Pro',
			'slug'     => 'advanced-custom-fields-pro',
			'source'   => 'http://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=b3JkZXJfaWQ9ODYzMzN8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE2LTA3LTI1IDIyOjE4OjI3',
			'required' => true,
		),
		array(
			'name'     => 'Advanced Custom Fields: Extended',
			'slug'     => 'acf-extended',
			'required' => true,
		),
		array(
			'name'     => 'Gravity Forms',
			'slug'     => 'gravityforms',
			'source'   => 'https://s3.amazonaws.com/gravityforms/releases/gravityforms_2.5.14.1.zip?AWSAccessKeyId=AKIA5U3GBHC5WDRZA6NK&Expires=1635541160&Signature=9UeHBET48Uc8nEE2opQoi%2FtSvXc%3D',
			'required' => false,
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
		'default_path' => plugin_dir_path( __FILE__ ) . 'dependencies/externals/plugins/',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => add_query_arg( 'page', 'rwp-options', 'admin.php' ),            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'rwp_register_required_plugins' );
