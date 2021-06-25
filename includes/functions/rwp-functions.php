<?php

/** ============================================================================
 * rwp-functions
 *
 * @package RIESTERWP Plugin\/includes/functions/rwp-functions.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

/**
 * Grab the RWP object and return it.
 * Wrapper for RWP::get_instance().
 *
 * @since  1.0.0
 * @return RWP  Singleton instance of plugin class.
 */
function rwp() {
	$plugin = RWP::instance();
	return $plugin;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rwp-activator.php
 */
function rwp_activate() {
	rwp()->activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rwp-deactivator.php
 */
function rwp_deactivate() {
	rwp()->deactivate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rwp-deactivator.php
 */
function rwp_uninstall() {
	rwp()->uninstall();
}

function rwp_plugin_asset_dir($asset, $folder = '', $prefix = true) {
	return rwp()->asset_dir($asset, $folder, $prefix);
}

function rwp_plugin_asset_uri($asset, $folder = '', $prefix = true) {
	return rwp()->asset_uri($asset, $folder, $prefix);
}

/**
 * Print to the in Query Monitor Log panel
 *
 * @link https://querymonitor.com/blog/2018/07/profiling-and-logging/
 *
 * @param mixed  $message  The message. Can also be a WP_Error or Exception
 *                         object
 *
 * @param string  $level   The log level for Query Monitor. A log level of
 *                         warning or higher will trigger a notification in
 *                         Query Monitor’s admin toolbar. Can be one of:
 *                         * emergency
 *                         * alert
 *                         * critical
 *                         * error
 *                         * warning
 *                         * notice
 *                         * info
 *                         * debug
 *
 * @param array  $context  Contextual interpolation can be used via the curly
 *                         brace syntax: `do_action( 'qm/warning', 'Unexpected
 *                         value of {foo} encountered', [ 'foo' => $foo, ] );`
 *
 * @return void
 */

function rwp_error($message, $level = 'error', $context = array()) {
	do_action("qm/$level", $message, $context); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function rwp_init() {
	rwp()->run();
}
