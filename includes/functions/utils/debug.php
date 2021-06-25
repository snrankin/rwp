<?php

/** ============================================================================
 * RWP Debug
 *
 * @package RWP\functions\debug
 * @since   1.0.0
 * ========================================================================== */

use RWP\Vendor\WPBP\Debug\Debug;
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
function rwp_dump($var) {
	return VarDumper::dump($var);
}

/**
 * Add a variable to Query Monitor
 *
 * Only visible to admins if WP_DEBUG is on
 *
 * @param mixed $var
 * @param bool $die
 * @param string $function
 * @return void
 */
function rwp_debug($var, $die = false, $function = 'rwp_dump') {
	$rwp_qm = Debug::instance('RWP');
	$rwp_qm->log($var, $die, $function);
}
