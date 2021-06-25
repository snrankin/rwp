<?php

/** ============================================================================
 * Convert all modules to easily callable functions
 *
 * @package RIESTERWP Plugin\/includes/functions/rwp-components.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */



if (!function_exists('rwp_html')) {
	function rwp_html($args = []) {
		return new \RWP\Components\Html($args);
	}
}
function rwp_html2($html) {
	return new \RWP\Vendor\Wa72\HtmlPageDom\HtmlPageCrawler($html);
}
if (!function_exists('rwp_text')) {
	function rwp_text($args = []) {
		return \RWP\Components\Html::text($args);
	}
}
if (!function_exists('rwp_icon')) {
	function rwp_icon($args = []) {
		return \RWP\Components\Html::icon($args);
	}
}
if (!function_exists('rwp_link')) {
	function rwp_link($args = []) {
		return \RWP\Components\Html::link($args);
	}
}
if (!function_exists('rwp_htmllist')) {
	function rwp_htmllist($args = []) {
		$args = apply_filters('rwp_htmllist_args', $args);
		return new \RWP\Components\HtmlList($args);
	}
}
if (!function_exists('rwp_column')) {
	function rwp_column($args = []) {
		$args = apply_filters('rwp_column_args', $args);
		return new \RWP\Components\Column($args);
	}
}
if (!function_exists('rwp_row')) {
	function rwp_row($args = []) {
		$args = apply_filters('rwp_row_args', $args);
		return new \RWP\Components\Row($args);
	}
}
if (!function_exists('rwp_section')) {
	function rwp_section($args = []) {
		$args = apply_filters('rwp_section_args', $args);
		return new \RWP\Components\Section($args);
	}
}
if (!function_exists('rwp_grid')) {
	function rwp_grid($args = []) {
		$args = apply_filters('rwp_grid_args', $args);
		return new \RWP\Components\Grid($args);
	}
}
if (!function_exists('rwp_button')) {
	function rwp_button($args = []) {
		$args = apply_filters('rwp_button_args', $args);
		return new \RWP\Components\Button($args);
	}
}
if (!function_exists('rwp_button_group')) {
	function rwp_button_group($args = []) {
		$args = apply_filters('rwp_button_group_args', $args);
		return \RWP\Components\Button::buttonGroup($args);
	}
}
if (!function_exists('rwp_media')) {
	function rwp_media($args = []) {
		$args = apply_filters('rwp_media_args', $args);
		return new \RWP\Components\Media($args);
	}
}
if (!function_exists('rwp_image')) {
	function rwp_image($src, $args = []) {
		$args['src'] = $src;
		$args = apply_filters('rwp_media_args', $args);

		return new \RWP\Components\Media($args);
	}
}

if (!function_exists('rwp_field')) {
	function rwp_field($args = []) {
		$args = apply_filters('rwp_field_args', $args);
		return new \RWP\Components\Field($args);
	}
}
if (!function_exists('rwp_form')) {
	function rwp_form($args = []) {
		$args = apply_filters('rwp_form_args', $args);
		return new \RWP\Components\Form($args);
	}
}

if (!function_exists('rwp_nav')) {
	function rwp_nav($args = []) {
		$args = apply_filters('rwp_nav_args', $args);
		return new \RWP\Components\Nav($args);
	}
}

if (!function_exists('rwp_nav_item')) {
	function rwp_nav_item($args = []) {
		$args = apply_filters('rwp_nav_item_args', $args);
		return new \RWP\Components\NavItem($args);
	}
}

if (!function_exists('rwp_pagination')) {
	function rwp_pagination($args = []) {
		global $post;
		$post_type = rwp_item_type();
		$args = apply_filters('rwp_pagination_args', $args);
		$args = apply_filters("rwp_{$post_type}_pagination_args", $args, $post);
		if (is_singular()) {
			$args['type'] = 'singular';
		}
		return new \RWP\Components\Pagination($args);
	}
}

if (!function_exists('rwp_breadcrumb')) {
	function rwp_breadcrumb($args = []) {
		$args = apply_filters('rwp_breadcrumb_args', $args);
		return new \RWP\Components\Breadcrumb($args);
	}
}

if (!function_exists('rwp_schema')) {
	function rwp_schema($args = []) {
		$args = apply_filters('rwp_schema_args', $args);
		return new \RWP\Components\SchemaItem($args);
	}
}

if (!function_exists('rwp_company_info')) {
	function rwp_company_info($args = []) {
		$args = apply_filters('rwp_company_info_args', $args);
		return new \RWP\Components\CompanyInfo($args);
	}
}

if (!function_exists('rwp_card')) {
	function rwp_card($args = []) {
		$args = apply_filters('rwp_card_args', $args);
		return new \RWP\Components\Card($args);
	}
}
if (!function_exists('rwp_post_card')) {
	function rwp_post_card($post = null, $args = []) {

		$args = rwp_card_args($post, $args);

		return new \RWP\Components\Card($args);
	}
}

if (!function_exists('rwp_blog')) {
	function rwp_blog($args = []) {
		$args = apply_filters('rwp_blog_args', $args);
		return new \RWP\Components\Blog($args);
	}
}

if (!function_exists('rwp_collection')) {
	function rwp_collection($args = []) {
		return new \RWP\Vendor\Illuminate\Support\Collection($args);
	}
}

if (!function_exists('rwp_config')) {
	function rwp_config($args = []) {
		return new \RWP\Vendor\Illuminate\Config\Repository($args);
	}
}

if (!function_exists('rwp_container')) {
	function rwp_container($args = []) {
		return new \RWP\Vendor\Illuminate\Container\Container($args);
	}
}

if (!function_exists('rwp_hierarchy')) {
	function rwp_hierarchy($args = []) {
		return new \RWP\Vendor\Brain\Hierarchy\Hierarchy($args);
	}
}
