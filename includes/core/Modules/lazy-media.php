<?php

/** ============================================================================
 * RWP LazyMedia
 *
 * @package RWP\Modules\LazyMedia
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Modules\LazyMedia;

if (!defined('ABSPATH')) {
	die();
}


if (!get_theme_support('rwp-lazy-media')) {
	return;
}

function enqueue_lazysizes() {
	if (!wp_style_is('rwp-lazysizes', 'registered')) {
		rwp()->register_styles('lazysizes');
	}

	if (!wp_script_is('rwp-lazysizes', 'registered')) {
		rwp()->register_scripts('lazysizes');
	}

	rwp()->enqueue_assets('lazysizes');
}
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_lazysizes');
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_lazysizes');



/**
 * Let plugins pre-filter the image meta to be able to fix inconsistencies in the stored data.
 *
 * @since 4.5.0
 *
 * @param array  $image_meta    The image meta data as returned by 'wp_get_attachment_metadata()'.
 * @param int[]  $size_array    {
 *     An array of requested width and height values.
 *
 *     @type int $0 The width in pixels.
 *     @type int $1 The height in pixels.
 * }
 * @param string $image_src     The 'src' of the image.
 * @param int    $attachment_id The image attachment ID or 0 if not supplied.
 */

function image_sizes($image_meta = [], $size_array = [], $image_src = '', $attachment_id = 0) {
	$type = pathinfo($image_src, PATHINFO_EXTENSION);

	if ('svg' === $type) {
		if (!rwp_array_has('width', $image_meta) || !rwp_array_has('height', $image_meta)) {
			$file = wp_get_original_image_path($attachment_id);
			$svg_file = simplexml_load_file($file);
			if ($svg_file) {
				$svg_file = rwp_xml_to_array($svg_file);
				$viewBox = null;

				if (rwp_array_has('viewBox', $svg_file['atts'])) {
					$viewBox = $svg_file['atts']['viewBox'];
					$viewBox = explode(' ', $viewBox);
				}

				if (rwp_array_has('width', $svg_file['atts'])) {
					$width = $svg_file['atts']['width'];
				} elseif (!empty($viewBox)) {
					$width = intval($viewBox[2]);
				}

				if (rwp_array_has('height', $svg_file['atts'])) {
					$height = $svg_file['atts']['height'];
				} elseif (!empty($viewBox)) {
					$height = intval($viewBox[3]);
				}
			}
			$image_meta['width'] = $width;
			$image_meta['height'] = $height;
		}
		$image_meta['sizes'] = [];
	} else {
		$image_meta['sizes'] = rwp_missing_sizes($image_meta, $image_src, $attachment_id);
	}
	return $image_meta;
}

add_filter('wp_calculate_image_srcset_meta', __NAMESPACE__ . '\\image_sizes', 5, 4);


/**
 * Filters the list of attachment image attributes.
 *
 * @since 2.8.0
 *
 * @param array        $attr       Array of attribute values for the image markup, keyed by attribute name.
 *                                 See wp_get_attachment_image().
 * @param WP_Post      $attachment Image attachment post.
 * @param string|array $size       Requested size. Image size or array of width and height values
 *                                 (in that order). Default 'thumbnail'.
 */

function image_atts($attr, $attachment, $size) {

	$attr = rwp_image_attrs($attr, $attachment, $size);

	return $attr;
}

add_filter('wp_get_attachment_image_attributes', __NAMESPACE__ . '\\image_atts', 30, 3);

/**
 * HTML img element representing an image attachment.
 *
 * @since 5.6.0
 *
 * @param string       $html          HTML img element or empty string on failure.
 * @param int          $attachment_id Image attachment ID.
 * @param string|int[] $size          Requested image size. Can be any registered image size name, or
 *                                    an array of width and height values in pixels (in that order).
 * @param bool         $icon          Whether the image should be treated as an icon.
 * @param string[]     $attr          Array of attribute values for the image markup, keyed by attribute name.
 *                                    See wp_get_attachment_image().
 */

function image_wrapper($html, $attachment_id, $size, $icon, $attr) {

	if (!empty($html) && is_attachment($attachment_id)) {
		if (!rwp_string_has('media-wrapper', $html)) {

			$args = [
				'src' => $attachment_id,
				'size' => $size,
			];

			$image = rwp_extract_html_atts($html);

			$classes = [];
			if (rwp_array_has('class', $image['atts'])) {
				$classes = $image['atts']['class'];
			}

			if (rwp_array_has('class', $attr)) {
				$classes = rwp_merge_classes($classes, $attr['class']);
			}

			$classes = rwp_output_classes($classes);

			preg_match('/embed\-(\w+)/', $classes, $embed);

			if (!empty($embed)) {
				$args['embed'] = $embed[1];
				$classes = str_replace($embed[0], '', $classes);
			}

			preg_match('/zoom/', $classes, $zoom);

			if (!empty($zoom)) {
				$args['zoom'] = true;
				$classes = str_replace('zoom', '', $classes);
			}

			preg_match('/is-bg/', $classes, $is_bg);

			if (!empty($is_bg)) {
				$args['is_bg'] = true;
				$classes = str_replace('is-bg', '', $classes);
			}

			$image['atts']['class'] = rwp_parse_classes($classes);

			$args['image'] = $image;

			$image = rwp_media($args);

			$html = $image->__toString();
		}
	}




	return $html;
}
add_filter('wp_get_attachment_image', __NAMESPACE__ . '\\image_wrapper', 30, 5);


/**
 * Filters the custom logo output.
 *
 * @since 4.5.0
 * @since 4.6.0 Added the `$blog_id` parameter.
 *
 * @param string $html    Custom logo HTML output.
 * @param int    $blog_id ID of the blog to get the custom logo for.
 */
function update_custom_logo_html($html, $blog_id){
	$img = $html;
	$html = rwp_html2('<figure class="media-wrapper custom-logo-wrapper"></figure>');

	$html->setInnerHtml($img);

	$html->filter('.custom-logo-link')->addClass('media-content');

	$html = apply_filters('rwp_logo_args', $html, $blog_id);

	return $html->saveHTML();

}
add_filter('get_custom_logo', __NAMESPACE__ . '\\update_custom_logo_html', 10, 2);

// // @ Filter Post Thumbnail
// function thumbnail($html = '', $post_id = null, $post_thumbnail_id = 0, $size = '', $attr = []) {
// 	$image = rwp_post_thumbnail_object($html, $post_id, $post_thumbnail_id, $size, $attr);

// 	if ($image) {
// 		$html = $image->__toString();
// 	}
// 	return $html;
// }

// add_filter('post_thumbnail_html', __NAMESPACE__ . '\\thumbnail', 10, 5);

function image_block($block_content, $block) {
	if ('core/image' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {

		$image = rwp_extract_img_block($block_content, $block);
		$block_content = $image->__toString();
	}
	return $block_content;
}

add_filter('render_block', __NAMESPACE__ . '\\image_block', 10, 2);

function video_block($block_content, $block) {
	if ('core/video' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {

		$link = [];
		$video = [];
		$caption = [];

		$wrapper = rwp_extract_html_atts($block_content);
		$content = '';
		if ($wrapper) {
			if (rwp_array_has('content', $wrapper)) {
				$content = $wrapper['content'];
			}
		}

		$video = rwp_extract_html_tag($content, 'video');

		$link = rwp_extract_html_tag($content, 'a');

		$caption = rwp_extract_html_tag($content, 'figcaption');

		$figure = [
			'video' => $video,
			'atts'  => $wrapper['atts'],
			'type'  => 'video'
		];
		if (!empty($link)) {
			$figure['media'] = $link;
		}
		if (!empty($caption)) {
			$figure['caption'] = $caption;
		}
		if (rwp_array_has('id', $block['attrs'])) {
			$figure['src'] = $block['attrs']['id'];
		} else {
			$figure['src'] = $video['atts']['src'];
		}

		if (rwp_array_has('linkTo', $block['attrs'])) {
			if ('file' === $block['attrs']['linkTo']) {
				$figure['zoom'] = true;
			}
		}

		$figure = rwp_media($figure);

		$block_content = $figure->__toString();
	}
	return $block_content;
}

add_filter('render_block', __NAMESPACE__ . '\\video_block', 10, 2);


function embed_block($block_content, $block) {
	if ('core/embed' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {

		$type = data_get($block, 'attrs.type', 'video');
		$host = data_get($block, 'attrs.providerNameSlug', 'youtube');
		$link = data_get($block, 'attrs.url', '');
		$class = data_get($block, 'attrs.className', '');
		$responsive = data_get($block, 'attrs.responsive', '');

		if (empty($link) || !preg_match('/(youtu(.?be)?|vimeo|wistia\.com|wi\.st)/', $link) || 'video' !== $type ) {
			return $block_content;
		}

		$video_id = rwp_extract_video_src($link);

		$host =  data_get($video_id, 'host');
		$id = data_get($video_id, 'id');
		$url = data_get($video_id, 'url');


		$content = rwp_html2($block_content);

		$wrapper = $content->filter('figure');
		$wrapper = rwp_extract_html_attributes($wrapper);

		$video = $content->filter('iframe')->saveHTML();
		$video = rwp_extract_html_attributes($video);

		$link = $content->filter('a')->saveHTML();

		if (empty($link)) {
			$link = array();
		} else {
			$link = rwp_extract_html_attributes($link);
		}

		$caption = $content->filter('figcaption')->saveHTML();

		if (empty($caption)) {
			$caption = array();
		} else {
			$caption = rwp_extract_html_attributes($caption);
		}

		$args = [
			'src'   => $id,
			'host'  => $host,
			'video' => array(
				'atts' => $video
			),
			'media' => array(
				'atts' => $link
			),
			'atts'  => $wrapper,
			'type'  => 'video',
			'caption' => array(
				'atts' => $caption
			),
		];

		$video = rwp_media($args);

		$video = $video->__toString();

		$block_content = $video;
	}
	return $block_content;
}

add_filter('render_block', __NAMESPACE__ . '\\embed_block', 10, 2);


function gallery_block($block_content, $block) {
	if ('core/gallery' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {

		$wrapper = rwp_extract_html_atts($block_content);

		preg_match('/<figcaption[^<]+(?=blocks-gallery-caption)blocks-gallery-caption(?<=blocks-gallery-caption)[^>]*+>((\s|\S)*?(?=<\/figcaption))<\/figcaption>/', $wrapper['content'], $caption);

		if (!empty($caption)) {
			$caption = reset($caption);
			$wrapper['content'] = str_replace($caption, '', $wrapper['content']);
			$caption = rwp_extract_html_atts($caption);
		}

		$gallery_items = [];

		preg_match('/<(?\'tag\'[\w|\-]+)[^<]+(?=blocks-gallery-grid)blocks-gallery-grid(?<=blocks-gallery-grid)[^>]*+>((\s|\S)*?(?=<\/(?P=tag)))<\/(?P=tag)>/', $wrapper['content'], $list_wrapper);

		$classes = [];

		if (rwp_array_has('atts', $wrapper)) {
			if (rwp_array_has('class', $wrapper['atts'])) {

				$classes = $wrapper['atts']['class'];
			}
		}

		if (!empty($list_wrapper)) {
			$list_wrapper = reset($list_wrapper);
			$wrapper['content'] = str_replace($list_wrapper, '', $wrapper['content']);

			$list_wrapper = rwp_extract_html_atts($list_wrapper);
			$item_wrapper = [];
			if (rwp_array_has('content', $list_wrapper)) {
				preg_match_all('/<li[^<]+>((\s|\S)*?(?=<\/li))<\/li>/', $list_wrapper['content'], $list_items);

				if (!empty($list_items)) {
					$list_items = reset($list_items);
					foreach ($list_items as $i => $list_item) {
						$item_wrapper = rwp_extract_html_atts($list_item);
						$image_block = [];
						$image_args = [];
						$image = '';

						if (rwp_array_has('content', $item_wrapper)) {
							$image = $item_wrapper['content'];
						}

						if (rwp_array_has('ids', $block['attrs'])) {
							if (rwp_array_has($i, $block['attrs']['ids'])) {
								$image_block['attrs']['id'] = $block['attrs']['ids'][$i];
							}
						}

						if (rwp_array_has('linkTo', $block['attrs'])) {
							$image_block['attrs']['linkTo'] = $block['attrs']['linkTo'];
						}

						if (preg_grep('/is-cropped/', $classes)) {
							$image_args['embed'] = '3by2';
						}

						$media = rwp_extract_img_block($image, $image_block, $image_args);

						$gallery_items[$i] = $media;
					}
				}
			}
		}

		$gallery = [
			'atts' => $wrapper['atts'],
			'items' => $gallery_items,
			'item_args' => $item_wrapper
		];
		if (preg_grep('/is-slider/', $classes)) {
			$gallery['type'] = 'slider';
		}

		$gallery = rwp_media([
			'type' => 'gallery',
			'gallery' => $gallery,
			'caption' => $caption
		]);

		$gallery->gallery->removeClass('wp-block-gallery');

		$block_content = $gallery->__toString();

		return $block_content;
	}
}

add_filter('render_block', __NAMESPACE__ . '\\gallery_block', 10, 2);

function media_text_block($block_content, $block) {
	if ('core/media-text' !== $block['blockName']) {
		return $block_content;
	}
	if (!empty($block_content)) {

		$wrapper = rwp_extract_html_atts($block_content);

		$media = null;

		preg_match('/\<figure([^>]*)\/?\>.*(?=\<\/figure\>)(<\/figure\>)/', $wrapper['content'], $media);

		$media = $media[0];

		$content = str_replace($media, '', $wrapper['content']);

		unset($wrapper['content']);

		$image_block = [
			'attrs' => []
		];

		if (rwp_array_has('mediaId', $block['attrs'])) {
			$image_block['attrs']['id'] = $block['attrs']['mediaId'];
		}

		if (rwp_array_has('mediaSizeSlug', $block['attrs'])) {
			$image_block['attrs']['sizeSlug'] = $block['attrs']['mediaSizeSlug'];
		}

		$media = rwp_extract_img_block($media, $image_block);


		$wrapper = rwp_html($wrapper);

		$wrapper->removeStyle('grid-template-columns');


		$content = rwp_extract_html_atts($content);
		$content = rwp_html($content);
		$content->addClass('media-body');
		$media = $media->__toString();
		$wrapper->addContent($media);
		$content = $content->__toString();
		$wrapper->addContent($content);

		$block_content = $wrapper->__toString();

		return $block_content;
	}
}

add_filter('render_block', __NAMESPACE__ . '\\media_text_block', 10, 2);
