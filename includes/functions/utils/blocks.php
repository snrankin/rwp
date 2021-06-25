<?php

/** ============================================================================
 * RIESTER blocks [@TODO Fill out summary for blocks.php (no period for file headers)]
 *
 * [@TODO Fill out description for blocks.php. (use period)]
 *
 * @link [@TODO Fill out url]
 *
 * @package WordPress
 * @subpackage RIESTER
 * @since RIESTER 0.1.0
 * ========================================================================== */

use \RWP\Vendor\Illuminate\Support\Str;

function rwp_get_block_types($post = null) {
	$post = rwp_post_object($post);

	$block_names = array();

	if (has_blocks($post->post_content)) {
		$blocks = parse_blocks($post->post_content);

		foreach ($blocks as $block) {
			if (rwp_array_has('blockName', $block)) {
				$block_names[] = $block['blockName'];
			}
		}
	}
	$block_names = array_unique($block_names);

	return $block_names;
}

function rwp_has_block_type($name = '', $post = null) {
	$post = rwp_post_object($post);

	$blocks = rwp_get_block_types($post);

	if (!empty($name)) {
		return in_array($name, $blocks, true);
	} else {
		return false;
	}
}

function rwp_setup_block($block, $content = '', $block_args = []) {

	$block_type = data_get($block, 'name');

	if (empty($block_type)) {
		$block_type = data_get($block, 'blockName');
	}

	if (!empty($block_type)) {
		$block_type = Str::after($block_type, '/');
	}

	$id = '';

	if (rwp_array_has('id', $block)) {
		$id = rwp_change_case($block_type . '-' . $block['id']);
	}


	if (rwp_array_has('anchor', $block)) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$class = [];
	if (rwp_array_has('className', $block)) {
		$class = rwp_parse_classes($block['className']);
	}

	$class[] = $block_type;

	if (rwp_array_has('align', $block)) {
		$class[] = 'align' . $block['align'];
	}

	if (rwp_array_has('alignContent', $block)) {
		$class[] = 'align' . $block['alignContent'];
	}

	$block_atts = [
		'content' => $content,
		'atts' => [
			'tag' => 'div',
			'class' => $class
		]
	];

	if (!empty($id)) {
		$block_atts['atts']['id'] = $id;
	}

	$block_atts = rwp_merge_args($block_atts, $block_args);

	return $block_atts;
}

function rwp_render_block($block, $content = '', $block_args = []) {
	$block_atts = rwp_setup_block($block, $content, $block_args);

	$content = rwp_html($block_atts);

	return $content->__toString();
}



function rwp_extract_img_block($block_content = '', $block = [], $args = []) {
	$wrapper = rwp_extract_html_atts($block_content);
	$content = '';
	if ($wrapper) {
		if (rwp_array_has('content', $wrapper)) {
			$content = $wrapper['content'];
		}
	}

	$image = '/<img[^>]*+>/';

	$image = rwp_extract_html_tag($content, 'img');

	if (rwp_array_has('data-link', $image['atts'])) {
		$image['atts']['data-link'] = rwp_relative_url($image['atts']['data-link']);
	}

	if (rwp_array_has('data-full-url', $image['atts'])) {
		$image['atts']['data-full-url'] = rwp_relative_url($image['atts']['data-full-url']);
	}

	$link = rwp_extract_html_tag($content, 'a');

	$caption = rwp_extract_html_tag($content, 'figcaption');

	$figure = [
		'image' => $image,
		'atts'  => $wrapper['atts'],
	];

	if (!empty($link)) {
		$figure['media'] = $link;
	}
	if (!empty($caption)) {
		$figure['caption'] = $caption;
	}

	if (rwp_array_has('sizeSlug', $block['attrs'])) {
		$figure['size'] = $block['attrs']['sizeSlug'];
	}

	if (rwp_array_has('id', $block['attrs'])) {
		$figure['src'] = $block['attrs']['id'];
	} else {
		$figure['src'] = $image['atts']['src'];
	}

	if (rwp_array_has('className', $block['attrs'])) {
		$classes = explode(' ', $block['attrs']['className']);
		if (in_array('inline-svg', $classes)) {
			$figure['image']['inline'] = true;
		}
	}

	if ($block['attrs']['id'] == 70285) {
		$test = true;
	}

	$img_id = $block['attrs']['id'];

	$custom_link = get_post_meta($img_id, '_gallery_link_url', true);
	$custom_link_target = get_post_meta($img_id, '_gallery_link_target', true);
	$custom_link_rel = get_post_meta($img_id, '_gallery_link_rel', true);

	$custom_link_atts = array(
		'tag' => 'a',
		'href' => $custom_link,
		'target' => $custom_link_target,
		'rel' => $custom_link_rel,
	);

	if (rwp_array_has('linkTo', $block['attrs'])) {
		if ('file' === $block['attrs']['linkTo']) {
			$figure['zoom'] = true;
		} elseif ($custom_link) {
			$figure['media']['atts'] = $custom_link_atts;
		}
	} elseif ($custom_link) {
		$figure['media']['atts'] = $custom_link_atts;
	}

	$figure = rwp_merge_args($figure, $args);

	$figure = rwp_media($figure);

	return $figure;
}

function rwp_global_block($slug = '') {
	if (empty($slug)) return;

	$slug = rwp_change_case($slug);

	$post = get_page_by_path($slug, OBJECT, 'rwp_global_block');

	if ($post instanceof WP_Post) {
		return rwp_get_content($post);
	} else {
		return '';
	}
}


function rwp_parse_blocks($content) {
	if (empty($content) || !is_string($content)) return $content;
	$blocks = parse_blocks($content);

	if ($blocks) {
		$block_content = '';
		foreach ($blocks as $block) {
			if (!empty($block['blockName'])) {
				$block_content .= render_block($block);
			}
		}
		if (!empty($block_content)) {
			$content = $block_content;
		}
	}

	return $content;
}
