<?php

/** ============================================================================
 * RWP JsToFooter
 *
 * Moves all scripts to wp_footer action
 *
 * You can enable/disable this feature in functions.php (or app/setup.php if you're using Sage):
 * add_theme_support('rwp-js-to-footer');
 *
 * @package RWP\Modules\JsToFooter
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Internals\Modules\JsToFooter;

if ( \is_admin() || ! \rwp_get_option( 'modules.enable_js_to_footer', false ) ) {
	return;
}

function js_to_footer() {
    remove_action( 'wp_head', 'wp_print_scripts' );
    remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
    remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\js_to_footer' );
