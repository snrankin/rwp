<?php

/** ============================================================================
 * RWP Utilities
 *
 * @package RWP\/includes/functions/rwp-utils.php
 * @since   0.1.0
 * ========================================================================== */


if (!function_exists('rwp_get_file')) {
	require_once __DIR__ . '/utils/file.php';
}

if (function_exists('rwp_get_plugin_file')) {
	rwp_get_plugin_file(array(
		'debug.php',
		'string.php',
		'url.php',
		'array.php',
		'object.php',
		'html.php',
		'post.php',
		'rest.php',
		'acf.php',
		'image.php',
		'menu.php',
		'blocks.php',

	), 'includes/functions/utils/', true, true);
}
