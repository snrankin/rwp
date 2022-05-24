<?php

/** ============================================================================
 * RWP utils
 *
 * @package RWP\/functions/utils.php
 * @since   0.1.0
 * ========================================================================== */

if ( ! function_exists( 'rwp_get_plugin_file' ) ) {
	require_once __DIR__ . '/utils/file.php';
}

if ( function_exists( 'rwp_get_plugin_file' ) ) {
	rwp_get_plugin_file(array(
		'debug.php',
		'cache.php',
		'string.php',
		'url.php',
		'array.php',
		'object.php',
		'html.php',
		'image.php',
		'acf.php',
		'post.php',
		'menu.php',
		'rest.php',
		'theme.php',
		'company.php',
	), 'includes/functions/utils/', true, true);
}
