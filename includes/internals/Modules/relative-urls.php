<?php
/** ============================================================================
 * relative-urls
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * @package   RWP\Internals\Modules
 * @since     1.0.0
 * ========================================================================== */

namespace RWP\Internals\Modules\RelativeURLs;

if ( \is_admin() || isset( $_GET['sitemap'] ) || in_array( $GLOBALS['pagenow'], [ 'wp-login.php', 'wp-register.php' ] ) || ! \rwp_get_option( 'modules.relative_urls', false ) ) {
	return;
}

/**
 * Make a URL relative
 */
function root_relative_url( $input ) {
	if ( \is_feed() ) {
		return $input;
	}

	$url = parse_url( $input );
	if ( ! isset( $url['host'] ) || ! isset( $url['path'] ) ) {
		return $input;
	}
	$site_url = parse_url( \network_home_url() );  // falls back to home_url

	if ( ! isset( $url['scheme'] ) ) {
		$url['scheme'] = $site_url['scheme'];
	}
	$hosts_match = $site_url['host'] === $url['host'];
	$schemes_match = $site_url['scheme'] === $url['scheme'];
	$ports_exist = isset( $site_url['port'] ) && isset( $url['port'] );
	$ports_match = ( $ports_exist ) ? $site_url['port'] === $url['port'] : true;

	if ( $hosts_match && $schemes_match && $ports_match ) {
		return \wp_make_link_relative( $input );
	}
	return $input;
}

/**
 * Compare URL against relative URL
 */
function url_compare( $url, $rel ) {
	$url = \trailingslashit( $url );
	$rel = \trailingslashit( $rel );
	return ( ( strcasecmp( $url, $rel ) === 0 ) || root_relative_url( $url ) == $rel );
}

$rwp_root_rel_filters = \apply_filters('rwp/relative-url-filters', [
	'bloginfo_url',
	'the_permalink',
	'wp_list_pages',
	'wp_list_categories',
	'wp_get_attachment_url',
	'the_content_more_link',
	'the_tags',
	'get_pagenum_link',
	'get_comment_link',
	'month_link',
	'day_link',
	'year_link',
	'term_link',
	'the_author_posts_link',
	'script_loader_src',
	'style_loader_src',
	'theme_file_uri',
	'parent_theme_file_uri',
]);
\rwp_add_filters( $rwp_root_rel_filters, __NAMESPACE__ . '\\root_relative_url' );

add_filter('wp_calculate_image_srcset', function ( $sources ) {
	foreach ( (array) $sources as $source => $src ) {
		$sources[ $source ]['url'] = root_relative_url( $src['url'] );
	}
	return $sources;
});

/**
 * Compatibility with The SEO Framework
 */
add_action('the_seo_framework_do_before_output', function () {
	remove_filter( 'wp_get_attachment_url', __NAMESPACE__ . '\\root_relative_url' );
});
add_action('the_seo_framework_do_after_output', function () {
	add_filter( 'wp_get_attachment_url', __NAMESPACE__ . '\\root_relative_url' );
});
