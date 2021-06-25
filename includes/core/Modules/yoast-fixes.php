<?php

/** ============================================================================
 * yoast-fixes
 *
 * @package RIESTERWP Plugin\/includes/core/Modules/yoast-fixes.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Modules\YoastFixes;

if (!defined('ABSPATH')) {
	die();
}

if (is_admin()) {
	return;
}

if (!is_plugin_active('wordpress-seo/wp-seo.php') || !get_theme_support('rwp-yoast-fixes')) {
	return;
}

$options = get_theme_support('rwp-yoast-fixes')[0];

if (wp_get_environment_type() !== 'production') {
	add_filter('yoast_seo_development_mode', '__return_true');
}
/**
 * Updating Yoast breadcrumbs to include full path
 * @link http://plugins.svn.wordpress.org/wordpress-seo/trunk/frontend/class-breadcrumbs.php
 * @see http://wordpress.stackexchange.com/questions/100012/how-to-add-a-page-to-the-yoast-breadcrumbs
 */

function full_path($links) {

	$post_type = get_post_type();
	$post = get_the_ID();
	if (is_post_type_archive() || is_home()) {
		$post_type_parents = get_option('sage_post_type_parents');
		if (array_key_exists($post_type, $post_type_parents)) {
			$post = $post_type_parents[$post_type];
		}
	}

	$ancestors = get_post_meta($post, 'ancestors', true);
	if (empty($ancestors)) {
		$ancestors = rwp_ancestors($post);
	}

	if (!empty($ancestors)) {
		if (rwp_is_collection($ancestors)) {
			$ancestors = $ancestors->transform(function ($item) {
				if (rwp_array_has('title', $item)) {
					$item['text'] = $item['title'];
				}
				return $item;
			})->all();
		}
		$links = $ancestors;
	}

	return $links;
}

function bootstrap_breadcrumbs($link_output, $link) {


	$title = '';
	$href = '';
	$active = false;

	if (rwp_array_has('text', $link)) {
		$title = $link['text'];
	}

	if (rwp_array_has('url', $link)) {
		$href = rwp_relative_url($link['url']);
	}

	if (preg_match('/aria-current/', $link_output)) {
		$active = true;
	}

	if ($active) {
		$link_output = '<li class="breadcrumb-item active" aria-current="page">' . $title . '</li>';
	} else {
		$link_output = '<li class="breadcrumb-item"><a href="' . $href . '">' . $title . '</a></li>';
	}

	return $link_output;
};
if (in_array('breadcrumbs', $options)) {
	//add_theme_support('yoast-seo-breadcrumbs');
	add_filter('wpseo_breadcrumb_links', __NAMESPACE__ . '\\full_path', 5, 1);
	add_filter('wpseo_breadcrumb_output_wrapper', function () {
		return 'ol';
	});
	add_filter('wpseo_breadcrumb_single_link_wrapper', function () {
		return 'li';
	});
	add_filter('wpseo_breadcrumb_output_class', function () {
		return 'breadcrumb';
	});
	add_filter('wpseo_breadcrumb_separator', function () {
		return '';
	});
	add_filter('wpseo_breadcrumb_single_link', __NAMESPACE__ . '\\bootstrap_breadcrumbs', 20, 2);
}


function page_type($data) {
	$slug       = get_permalink();
	$schemaType = $data;
	if (strpos($slug, 'faq') !== false) {
		if (!is_singular()) {
			$schemaType = 'FAQPage';
		}
	} elseif (strpos($slug, 'people') !== false || strpos($slug, 'team') !== false) {
		if (is_singular()) {
			$schemaType = 'ProfilePage';
		} else {
			$schemaType = 'CollectionPage';
		}
	} elseif (is_page()) {
		if (strpos($slug, 'about') !== false) {
			$schemaType = 'AboutPage';
		} elseif (strpos($slug, 'contact') !== false) {
			$schemaType = 'ContactPage';
		} else {
			$schemaType = 'WebPage';
		}
	} elseif (is_post_type_archive()) {
		$schemaType = 'CollectionPage';
	} elseif (is_singular()) {
		if (is_singular('post')) {
			$schemaType = 'BlogPosting';
		} else if (is_singular('press')) {
			$schemaType = 'NewsArticle';
		} else {
			$schemaType = 'ItemPage';
		}
	} elseif (is_search()) {
		$schemaType = 'SearchResultsPage';
	} else {
		$schemaType = 'WebPage';
	}
	$data = [$schemaType];
	return $data;
}
if (in_array('page-type', $options)) {
	add_filter('wpseo_schema_webpage_type', __NAMESPACE__ . '\\page_type', 2, 1);
}

function faq_block($block_content = '', $block = []) {
	if ('yoast/faq-block' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {

		$questions = $block['attrs']['questions'];


		$panels = '';

		if (!empty($questions)) {
			$content = '';
			foreach ($questions as $i => $question) {
				$panel = rwp_html([
					'atts' => [
						'tag' => 'div',
						'class' => [
							'rwp-toggle'
						]
					]
				]);

				$panel_bar = rwp_html([
					'content' => [
						'button' => rwp_button([
							'target' => $question['id'] . '-answer',
							'toggle' => 'collapse',
							'icon_opened' => rwp_icon([
								'atts' => [
									'tag' => 'i',
									'class' => [
										'glaza',
										'glaza-minus'
									]
								]
							]),
							'icon_closed' => rwp_icon([
								'atts' => [
									'tag' => 'i',
									'class' => [
										'glaza',
										'glaza-plus'
									]
								]
							]),
							'atts' => [
								'class' => [
									'btn-outline-primary'
								]
							]
						])->__toString(),
						'text' => rwp_text([
							'content' => $question['question'][0],
							'atts' => [
								'tag' => 'h3'
							]
						])->__toString()
					],
					'atts' => [
						'tag' => 'div',
						'class' => [
							'rwp-toggle-bar'
						]
					]
				]);

				$panel_bar = $panel_bar->__toString();

				$panel_body = rwp_html([
					'content' => $question['answer'][0],
					'atts' => [
						'tag' => 'div',
						'id' => $question['id'] . '-answer',
						'class' => [
							'rwp-toggle-body',
							'collapse'
						],
						'aria-labelledby' => $question['id'] . '-answer-btn'
					]
				]);
				$panel_body = $panel_body->__toString();
				$panel->addContent($panel_bar);
				$panel->addContent($panel_body);
				$content .= $panel->__toString();
			}
			$block_content = rwp_render_block($block, $content);
		}
		return $block_content;
	}
}
if (in_array('faqs', $options)) {
	add_filter('render_block', __NAMESPACE__ . '\\faq_block', 20, 2);
}
