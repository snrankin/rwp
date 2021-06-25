<?php

/** ============================================================================
 * RWP Bootstrap
 *
 * @package RWP\Modules\Bootstrap
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Modules\Bootstrap;

if (!defined('ABSPATH')) {
	die();
}

if (is_admin()) {
	return;
}

if (!get_theme_support('rwp-bootstrap')) {
	return;
}
$options = get_theme_support('rwp-bootstrap')[0];

function bootstrap_search($form) {

	$form = rwp_extract_search_args($form);
	$form = rwp_form($form);
	$form = $form->__toString();


	return $form;
}

if (in_array('search', $options)) {
	add_filter('get_search_form', __NAMESPACE__ . '\\bootstrap_search', 10, 1);
}


function button_block($block_content, $block) {
	if ('core/button' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {


		$classes = [];
		$button_wrapper = rwp_extract_html_atts($block_content);
		$button_args = rwp_extract_html_atts($button_wrapper['content']);
		if (rwp_array_has('content', $button_args)) {
			$text = trim($button_args['content']);
			$button_args['text']['content'] = $text;
			unset($button_args['content']);
		}
		if (rwp_array_has('href', $button_args['atts'])) {
			$button_args['atts']['href'] = rwp_relative_url($button_args['atts']['href']);
		}

		if (rwp_array_has('className', $block['attrs'])) {
			$classes = rwp_parse_classes($block['attrs']['className']);
		}

		if (!empty($classes)) {
			foreach ($classes as $class) {
				if (in_array($class, $button_wrapper['atts']['class'])) {
					$class_key = array_search($class, $button_wrapper['atts']['class']);
					unset($button_wrapper['atts']['class'][$class_key]);
				}
				if (!in_array($class, $button_args['atts']['class'])) {

					$button_args['atts']['class'][] = $class;
				}
			}
		}
		if (preg_grep('/is-style-/', $button_args['atts']['class'])) {
			$button_args['atts']['class'] = preg_replace('/is-style-/', '', $button_args['atts']['class']);
		}

		$button = rwp_button($button_args);

		$button->removeClass('wp-block-button__link');

		$block_content = $button->__toString();
	}
	return $block_content;
}

add_filter('render_block', __NAMESPACE__ . '\\button_block', 10, 2);

function buttons_block($block_content, $block) {
	if ('core/buttons' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {


		$wrapper = rwp_extract_html_atts($block_content);

		unset($wrapper['atts']['tag']);
		$btns = [
			'inline' => true,
			'items' => [],
			'atts' => $wrapper['atts']
		];

		if (rwp_array_has('id', $wrapper['atts'])) {
			unset($wrapper['atts']['id']);
		}



		$buttons_regex = '/<a[^<]+>(\s|\S)*?<\/a>/';
		preg_match_all($buttons_regex, $wrapper['content'], $buttons);

		if (!empty($buttons)) {
			$buttons = $buttons[0];
			foreach ($buttons as $button) {
				$btns['items'][] = $button;
			}
		}
		$buttons = rwp_button_group($btns);

		$block_content = $buttons->__toString();

		$block_content = rwp_render_block($block, $block_content);
	}
	return $block_content;
}

add_filter('render_block', __NAMESPACE__ . '\\buttons_block', 20, 2);

function file_block($block_content, $block) {
	if ('core/file' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {


		$wrapper = rwp_extract_html_atts($block_content);

		$btn_re = '/<(?\'tag\'[\w|\-]+)[^<]+(?=wp-block-file__button)wp-block-file__button(?<=wp-block-file__button)[^>]*+>((\s|\S)*?(?=<\/(?P=tag)))<\/(?P=tag)>/';

		if (preg_match($btn_re, $wrapper['content'], $btn)) {
			$content = $wrapper['content'];
			unset($wrapper['content']);
			$wrapper['inline'] = true;
			$wrapper = rwp_htmllist($wrapper);
			$wrapper->setAttr('tag', 'ul');
			$btn = reset($btn);
			$content = str_replace($btn, '', $content);
			$wrapper->addItem($content);
			$btn = rwp_extract_html_atts($btn);
			if (rwp_array_has('content', $btn)) {
				$btn['text'] = [
					'content' => $btn['content']
				];
				unset($btn['content']);
			}
			if (preg_grep('/is-style-/', $btn['atts']['class'])) {
				$btn['atts']['class'] = preg_replace('/is-style-/', '', $btn['atts']['class']);
			} else {
				$btn['atts']['class'][] = 'btn-outline-primary';
			}
			$btn = rwp_button($btn);
			$btn->removeClass('wp-block-file__button');
			$btn = $btn->__toString();
			$wrapper->addItem($btn);

			$block_content = $wrapper->__toString();
		}


		return $block_content;
	}
}

add_filter('render_block', __NAMESPACE__ . '\\file_block', 20, 2);


function bootstrap_column($block_content, $block) {
	if ('core/column' !== $block['blockName']) {
		return $block_content;
	} else {
		if (!empty($block_content)) {

			if (!empty($block['innerBlocks'])) {
				$col = rwp_extract_html_atts($block_content);

				$column = rwp_column($col);
				if ($column->hasStyle('flex-basis')) {
					$column->removeStyle('flex-basis');
				}
				$column->removeClass('wp-block-column');
				$block_content = $column->__toString();
			} else {
				$block_content = '';
			}
		}
	}
	return $block_content;
}

add_filter('render_block', __NAMESPACE__ . '\\bootstrap_column', 20, 2);
