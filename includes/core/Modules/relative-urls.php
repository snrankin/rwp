<?php

/** ============================================================================
 * RWP relative-urls
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in functions.php
 * add_theme_support('rwp-relative-urls');
 *
 * @package RWP\Modules\RelativeURLs
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Modules\RelativeURLs;

if (!defined('ABSPATH')) {
	die();
}

if (is_admin() || isset($_GET['sitemap']) || in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']) || !get_theme_support('rwp-relative-urls')) {
	return;
}

/**
 * Make a URL relative
 */
function root_relative_url($input) {
	if (is_feed()) {
		return $input;
	}

	$url = parse_url($input);
	if (!isset($url['host']) || !isset($url['path'])) {
		return $input;
	}
	$site_url = parse_url(network_home_url());  // falls back to home_url

	if (!isset($url['scheme'])) {
		$url['scheme'] = $site_url['scheme'];
	}
	$hosts_match = $site_url['host'] === $url['host'];
	$schemes_match = $site_url['scheme'] === $url['scheme'];
	$ports_exist = isset($site_url['port']) && isset($url['port']);
	$ports_match = ($ports_exist) ? $site_url['port'] === $url['port'] : true;

	if ($hosts_match && $schemes_match && $ports_match) {
		return wp_make_link_relative($input);
	}
	return $input;
}

/**
 * Compare URL against relative URL
 */
function url_compare($url, $rel) {
	$url = trailingslashit($url);
	$rel = trailingslashit($rel);
	return ((strcasecmp($url, $rel) === 0) || root_relative_url($url) == $rel);
}


$root_rel_filters = apply_filters('rwp/relative-url-filters', [
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
	'wp_get_original_image_url'
]);
rwp_add_filters($root_rel_filters, __NAMESPACE__ . '\\root_relative_url');


$post_types = get_post_types(array('show_ui' => true, 'public' => true), 'names');

foreach ($post_types as $type) {
	add_filter($type . '_link', function ($url, $post_id) use ($type) {
		return apply_filters('wpse_link', $url, $post_id, $type);
	}, 9999, 2);
}

add_filter('wpse_link', function ($url, $post_id, $type) {
	return root_relative_url($url);
}, 10, 3);

add_filter('wp_calculate_image_srcset', function ($sources) {
	foreach ((array) $sources as $source => $src) {
		$sources[$source]['url'] = root_relative_url($src['url']);
	}
	return $sources;
});

/**
 * Compatibility with The SEO Framework
 */
add_action('the_seo_framework_do_before_output', function () {
	remove_filter('wp_get_attachment_url', 'rwp_relative_url');
});
add_action('the_seo_framework_do_after_output', function () {
	add_filter('wp_get_attachment_url', 'rwp_relative_url');
});
