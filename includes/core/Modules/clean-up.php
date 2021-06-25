<?php

/** ============================================================================
 * RWP clean-up
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS and JS from WP emoji support
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag
 *
 * You can enable/disable this feature in functions.php with add_theme_support('rwp-clean-up');
 *
 * @package RWP\Modules\CleanUp
 * @since   0.1.0
 * ========================================================================== */


namespace RWP\Modules\CleanUp;

if (!defined('ABSPATH')) {
	die();
}

if (is_admin()) {
	return;
}

if (!get_theme_support('rwp-clean-up')) {
	return;
}

/**
 * Clean up WordPress head
 *
 * @link http://wpengineer.com/1438/wordpress-header/
 *
 * @return void
 */

function head_cleanup() {

	remove_action('wp_head', 'feed_links_extra', 3);
	add_action('wp_head', 'ob_start', 1, 0);
	add_action('wp_head', function () {
		$pattern = '/.*' . preg_quote(esc_url(get_feed_link('comments_' . get_default_feed())), '/') . '.*[\r\n]+/';
		$content = ob_get_clean();
		if ($content) {
			$content = preg_replace($pattern, '', $content);
			if (!empty($content) && is_string($content)) {
				echo wp_kses_post($content);
			}
		}
	}, 3, 0);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('use_default_gallery_style', '__return_false');
	add_filter('emoji_svg_url', '__return_false');
	add_filter('show_recent_comments_widget_style', '__return_false');
}
add_action('init', __NAMESPACE__ . '\\head_cleanup', 999);

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');


/**
 * Clean up language_attributes() used in <html> tag
 *
 * Remove dir="ltr"
 *
 * @return string
 */
function language_attributes() {
	$attributes = array();

	if (is_rtl()) {
		$attributes[] = 'dir="rtl"';
	}

	$lang = get_bloginfo('language');

	if ($lang) {
		$attributes[] = "lang=\"$lang\"";
	}

	$output = implode(' ', $attributes);
	$output = apply_filters('rwp/language_attributes', $output);

	return $output;
}
add_filter('language_attributes', __NAMESPACE__ . '\\language_attributes');

/**
 * Clean up output of stylesheet <link> tags
 *
 * @param string $input
 *
 * @return string
 */
function clean_style_tag($input) {
	preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches); //phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
	if (empty($matches[2])) {
		return $input;
	}
	// Only display media if it is meaningful
	$media = '' !== $matches[3][0] && 'all' !== $matches[3][0] ? ' media="' . $matches[3][0] . '"' : '';
	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n"; //phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
}
add_filter('style_loader_tag', __NAMESPACE__ . '\\clean_style_tag');


/**
 * Clean up output of <script> tags
 * @param mixed $input
 * @return string|string[]
 */
function clean_script_tag($input) {
	$input = str_replace("type='text/javascript' ", '', $input);
	return str_replace("'", '"', $input);
}
add_filter('script_loader_tag', __NAMESPACE__ . '\\clean_script_tag');

/**
 * Add and remove body_class() classes
 *
 * @param array $classes
 *
 * @return array
 */
function body_class($classes) {
	// Add post/page slug if not present
	if (is_single() || is_page() && !is_front_page()) {
		$url = get_permalink();
		if ($url) {
			$basename = basename($url);

			if (!in_array($basename, $classes, true)) {
				$classes[] = $basename;
			}
		}
	}

	// Remove unnecessary classes
	$home_id_class  = 'page-id-' . get_option('page_on_front');
	$remove_classes = array(
		'page-template-default',
		$home_id_class,
	);
	$classes        = array_diff($classes, $remove_classes);

	return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');


/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 * @param string $cache
 * @return string
 */
function embed_wrap($cache) {
	return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', __NAMESPACE__ . '\\embed_wrap');

/**
 * Remove unnecessary self-closing tags
 *
 * @param string $input
 * @return string
 */
function remove_self_closing_tags($input) {
	return str_replace(' />', '>', $input);
}
rwp_add_filters(array('get_avatar', 'comment_id_fields', 'post_thumbnail_html'), __NAMESPACE__ . '\\remove_self_closing_tags');

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 *
 * @param string $bloginfo
 *
 * @return string
 */
function remove_default_description($bloginfo) {
	$default_tagline = 'Just another WordPress site';
	return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', __NAMESPACE__ . '\\remove_default_description');
