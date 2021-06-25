<?php

/** ============================================================================
 * @wordpress-plugin
 *
 * Plugin Name:        RIESTERWP Core
 * Plugin URI:         https://riester.com
 * Description:        RIESTERWP plugin to extend functionality of custom RIESTER themes
 * Version:            0.1.0
 * Author:             RIESTER Advertising Agency
 * Author URI:         https://riester.com
 * License:            UNLICENSED
 * Text Domain:        rwp
 * Domain Path:        /i18n/languages/
 * Requires at least:  5.3
 * Requires PHP:       7.0
 * ========================================================================== */


/**
 * If this file is called directly, abort.
 */
if (!defined('ABSPATH')) exit;

/**
 * Current plugin version.
 * Start at version 0.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if (!defined('RWP_PLUGIN_VERSION')) {
	define('RWP_PLUGIN_VERSION', '0.1.0');
}

/**
 * Minimum required php
 */
if (!defined('RWP_PLUGIN_MIN_PHP_VERSION')) {
	define('RWP_PLUGIN_MIN_PHP_VERSION', '7.0');
}


/**
 * Minimum required WordPress version
 */
if (!defined('RWP_PLUGIN_MIN_WP_VERSION')) {
	define('RWP_PLUGIN_MIN_WP_VERSION', '5.6');
}

/**
 * Plugin directory path
 */
if (!defined('RWP_PLUGIN_PATH')) {
	define('RWP_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
}

/**
 * Plugin directory URL
 */
if (!defined('RWP_PLUGIN_URL')) {
	define('RWP_PLUGIN_URL', wp_make_link_relative(plugin_dir_url(__FILE__)));
}

/**
 * Plugin prefix
 */
if (!defined('RWP_PLUGIN_PREFIX')) {
	define('RWP_PLUGIN_PREFIX', basename(__FILE__, '.php'));
}

/**
 * Plugin display name
 */
if (!defined('RWP_PLUGIN_NAME')) {
	define('RWP_PLUGIN_NAME', 'RIESTERWP Core Plugin');
}

/**
 * Plugin base file
 */
if (!defined('RWP_PLUGIN_FILE')) {
	define('RWP_PLUGIN_FILE', __FILE__);
}

/**
 * Plugin base directory
 */

if (!defined('RWP_PLUGIN_DIR')) {
	define('RWP_PLUGIN_DIR', __DIR__);
}

if (!defined('RWP_VENDOR_PREFIX')) {
	define('RWP_VENDOR_PREFIX', 'RWP\Vendor');
}

require_once RWP_PLUGIN_PATH . '/vendor/autoload.php';

register_activation_hook(RWP_PLUGIN_FILE, 'rwp_activate');
register_deactivation_hook(RWP_PLUGIN_FILE, 'rwp_deactivate');
add_action('plugins_loaded', ['RWP', 'instance']);
rwp_init();
