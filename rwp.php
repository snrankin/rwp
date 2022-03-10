<?php
/** ============================================================================
 * Plugin Name: RIESTERWP Core
 * Plugin URI: @TODO
 * Description: @TODO
 * Version: 1.0.0
 * Author: RIESTER Advertising Agency
 * Author URI: https://www.riester.com
 * Text Domain: rwp
 * Domain Path: /languages
 * License: GPL 2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires PHP: 7.0
 * Requires at least: 5.6
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
define( 'RWP_PLUGIN_FILE', __FILE__ );
define( 'RWP_PLUGIN_VENDOR_PATH', RWP_PLUGIN_ROOT . 'includes/dependencies/' );

function rwp_meets_requirements() {
	$meta = get_plugin_data(__FILE__);

	$name = ($meta['Name'] && !empty($meta['Name'])) ? $meta['Name'] : 'RWP';

	$meets_requirements = true;

	/**
	 * Ensure compatible version of PHP is used
	 */

	if(isset($meta['RequiresPHP']) && !empty($meta['RequiresPHP'])){

		$php_min = $meta['RequiresPHP'];
		$php_ver = phpversion();

		if (version_compare($php_min, $php_ver, '>')) {
            add_action('admin_notices', static function() use ($php_min, $php_ver, $name){
				echo wp_sprintf( '<div class="notice notice-error is-dismissible"><p><strong>%s requires php to be a minimum of version %s.</strong><br/>The current installed version is %s. Please contact your hosting provider if you need to upgrade your version of php.</p></div>', $name, $php_min, $php_ver );
			});
			$meets_requirements = false;
        }

	}

	/**
	 * Ensure compatible version of WordPress is used
	 */

	if(isset($meta['RequiresWP']) && !empty($meta['RequiresWP'])){

		$wp_min = $meta['RequiresWP'];
		$wp_ver = get_bloginfo('version');

		if (version_compare($wp_min, $wp_ver, '>')) {
            add_action('admin_notices', static function() use ($wp_min, $wp_ver, $name){
				echo wp_sprintf( '<div class="notice notice-error is-dismissible"><p><strong>%s requires WordPress to be a minimum of version %s.</strong><br/>The current installed version is %s. Please upgrade WordPress and try activating %s again.</p></div>', $name, $wp_min, $wp_ver );
			});
			$meets_requirements = false;
        }

	}


	return $meets_requirements;
}


if ( !rwp_meets_requirements() ) {

	// Return early to prevent loading the plugin.
	return;
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
			'name'               => 'Advanced Custom Fields Pro',
			'slug'               => 'advanced-custom-fields-pro',
			'source'             => 'http://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=b3JkZXJfaWQ9ODYzMzN8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE2LTA3LTI1IDIyOjE4OjI3',
			'required'           => true,
		),
		array(
			'name'      => 'Advanced Custom Fields: Extended',
			'slug'      => 'acf-extended',
			'required'  => true,
		),
		array(
			'name'               => 'Gravity Forms',
			'slug'               => 'gravityforms',
			'source'             => 'https://s3.amazonaws.com/gravityforms/releases/gravityforms_2.5.14.1.zip?AWSAccessKeyId=AKIA5U3GBHC5WDRZA6NK&Expires=1635541160&Signature=9UeHBET48Uc8nEE2opQoi%2FtSvXc%3D',
			'required'           => false,
		),
		array(
			'name'               => 'Gravity Forms reCAPTCHA',
			'slug'               => 'gravityformsrecaptcha',
			'source'             => 'https://s3.amazonaws.com/gravityforms/addons/recaptcha/gravityformsrecaptcha_1.1.zip?AWSAccessKeyId=AKIA5U3GBHC5WDRZA6NK&Expires=1635541160&Signature=G9YrzAAQFhL1wbJlKrWeX5jM41I%3D',
			'required'           => false,
		)
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
		'default_path' => plugin_dir_path( __FILE__ ) . '/includes/dependencies/externals/plugins/',                      // Default absolute path to bundled plugins.
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

require_once RWP_PLUGIN_VENDOR_PATH . 'vendor/scoper-autoload.php';
$rwp_libraries =  require RWP_PLUGIN_ROOT . '/vendor/autoload.php';

require_once RWP_PLUGIN_ROOT . 'includes/functions/functions.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/utils.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/filters.php';
require_once RWP_PLUGIN_ROOT . 'includes/functions/components.php';

if ( ! wp_installing() ) {
	add_action(
		'plugins_loaded',
		static function () use ( $rwp_libraries ) {
			$rwp = \RWP\Engine\Base::instance();
			new \RWP\Engine\Initialize( $rwp_libraries );
		}
	);
}
