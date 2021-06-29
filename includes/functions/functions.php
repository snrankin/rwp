<?php
/** ============================================================================
 * functions
 *
 * @package   RWP\functions
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

/**
 * Grab the RWP object and return it.
 * Wrapper for RWP::get_instance().
 *
 * @since  1.0.0
 * @return RWP\Engine\Base  Singleton instance of plugin class.
 */
function rwp() {
	$plugin = RWP\Engine\Base::instance();
	return $plugin;
}

/**
 * Creates Notice.
 *
 * @param string $notice_content Notice content.
 * @param string $notice_type Notice type.
 * @param bool $dismissible Dismissible notice.
 * @param int $priority Notice priority,
 *
 * @return RWP\Vendor\WPDesk\Notice\Notice
 */
function rwp_admin_notice( $notice_content, $notice_type = 'info', $dismissible = false, $priority = 10 ) {
	return WPDeskWpNotice( $notice_content, $notice_type, $dismissible, $priority );
}

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
function rwp_get_options() {
	return apply_filters( 'rwp_get_options', get_option( RWP_PLUGIN_TEXTDOMAIN . '_options' ) );
}


/**
 *
 * @param mixed $option
 * @param mixed $default
 * @return mixed
 */
function rwp_get_option( $option, $default ) {
	$options = rwp_get_options();
	$option = data_get( $options, $option, $default );
	return apply_filters( "rwp_get_option_{$option}", $option );
}


/**
 * Hooks a single callback to multiple tags
 *
 * @param array    $tags            An array of filter tags to add the function to
 * @param callable $function        The callback to be run when the filter is applied.
 * @param int      $priority        Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action. Default 10.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 *
 * @return void
 */
function rwp_add_filters( $tags, $function, $priority = 10, $accepted_args = 1 ) {
	foreach ( (array) $tags as $tag ) {
		add_filter( $tag, $function, $priority, $accepted_args );
	}
}

/**
 * Check if a variable had value
 *
 * @param mixed $input
 *
 * @return bool
 */

function rwp_has_value( $input ) {
	return filled( $input );
}
