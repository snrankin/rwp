<?php
/** ============================================================================
 * debug
 *
 * @package   RWP\functions\debug
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

use RWP\Integrations\QM;
use RWP\Vendor\Symfony\Component\VarDumper\VarDumper;

/**
 * A wrapper for Symfony VarDumper
 *
 * @see https://symfony.com/doc/current/components/var_dumper.html
 *
 * @param mixed $var The variable to dump
 *
 * @return VarDumper
 */
function rwp_dump( $var ) {
	ob_start();

	VarDumper::dump( $var );

    return ob_get_clean();
}

/**
 * Add a variable to Query Monitor
 *
 * Only visible to admins if WP_DEBUG is on
 *
 * @param  mixed  $var
 * @param  bool   $die
 * @param  string $function
 * @return void
 */
function rwp_log( $var, $die = false, $function = 'rwp_dump' ) {
	QM::instance()->log( $var, $die, $function );
}



/**
 * Print to the in Query Monitor Log panel
 *
 * @link https://querymonitor.com/blog/2018/07/profiling-and-logging/
 *
 * @param mixed  $message The message. Can also be a WP_Error or Exception
 *                        object
 *
 * @param string $level   The log level for Query Monitor. A log level of
 *                        warning or higher will trigger a notification
 *                        in Query Monitor’s admin toolbar. Can be one
 *                        of: * emergency * alert * critical * error *
 *                        warning * notice * info * debug
 *
 * @param array  $context Contextual interpolation can be used via the curly
 *                        brace syntax: `do_action( 'qm/warning',
 *                        'Unexpected value of {foo} encountered', [ 'foo'
 *                        => $foo, ] );`
 *
 * @return void
 */

function rwp_error( $message, $level = 'error', $context = array() ) {
    do_action( "qm/$level", $message, $context ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
}
