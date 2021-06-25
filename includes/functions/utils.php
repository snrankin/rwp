<?php

/** ============================================================================
 * RWP utils
 *
 * @package RWP\/functions/utils.php
 * @since   0.1.0
 * ========================================================================== */

if ( ! function_exists( 'rwp_get_file' ) ) {
	require_once __DIR__ . '/functions.php';
}


rwp_get_file(array(
	'debug',
	'string',
	'url',
	'array',
	'object',
	'html',
), 'includes/functions/utils', true, true);
