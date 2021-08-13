<?php

/** ============================================================================
 * RWP nice-search
 *
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 * You can enable/disable this feature in functions.php
 * add_theme_support('rwp-nice-search');
 *
 * @package RWP\Modules\NiceSearch
 * @link    http://txfx.net/wordpress-plugins/nice-search/
 * @since   0.1.0
 * ========================================================================== */


namespace RWP\Modules\NiceSearch;

if (\is_admin() || ! \rwp_get_option( 'modules.enable_nice_search', false ) ) {
	return;
}

function redirect() {
    global $wp_rewrite;
    if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->get_search_permastruct() ) {
        return;
    }

    $search_base = $wp_rewrite->search_base;
    if ( is_search() && ! is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false && strpos( $_SERVER['REQUEST_URI'], '&' ) === false ) { //phpcs:ignore
        wp_redirect( get_search_link() );
        exit();
    }
}
add_action( 'template_redirect', __NAMESPACE__ . '\\redirect' );

function rewrite( $url ) {
    return str_replace( '/?s=', '/search/', $url );
}
add_filter( 'wpseo_json_ld_search_url', __NAMESPACE__ . '\\rewrite' );
