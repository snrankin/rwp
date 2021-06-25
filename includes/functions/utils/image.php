<?php

/** ============================================================================
 * RIESTER image [@TODO Fill out summary for image.php (no period for file headers)]
 *
 * [@TODO Fill out description for image.php. (use period)]
 *
 * @link [@TODO Fill out url]
 *
 * @package WordPress
 * @subpackage RIESTER
 * @since RIESTER 0.1.0
 * ========================================================================== */

use RWP\Components\Media;

/**
 * Get all the registered image sizes along with their dimensions
 *
 * @global array $_wp_additional_image_sizes
 *
 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
 *
 * @return array $image_sizes The image sizes
 */
function rwp_registered_image_sizes() {
	$wp_additional_image_sizes = wp_get_additional_image_sizes();

	$sizes = array();
	$registered_sizes = get_intermediate_image_sizes();
	// Create the full array with sizes and crop info
	foreach ($registered_sizes as $_size) {
		if (!rwp_array_has($_size, $wp_additional_image_sizes)) {
			$sizes[$_size]['width'] = intval(get_option($_size . '_size_w'));
			$sizes[$_size]['height'] = intval(get_option($_size . '_size_h'));
			$sizes[$_size]['crop'] = (bool) get_option($_size . '_crop');
		} elseif (isset($wp_additional_image_sizes[$_size])) {
			$sizes[$_size] = array(
				'width'  => intval($wp_additional_image_sizes[$_size]['width']),
				'height' => intval($wp_additional_image_sizes[$_size]['height']),
				'crop'   => boolval($wp_additional_image_sizes[$_size]['crop'])
			);
		}
	}

	$sizes = rwp_collection($sizes);

	$sizes = $sizes->sortBy('width');
	$sizes = $sizes->all();
	$sizes['full'] = ['crop' => false];
	return $sizes;
}

function rwp_media_path($image = null) {

	if (empty($image)) return false;

	if (is_string($image)) {
		if (rwp_is_url($image) && !rwp_is_outbound_link($image)) {
			$image = attachment_url_to_postid($image);
		} elseif (is_numeric($image)) {
			$image = intval($image);
		}
	}

	if ($image instanceof \WP_Post) {
		$image = $image->ID;
	}

	if (!wp_attachment_is_image($image)) {
		return false;
	}

	$uploads_path = wp_get_upload_dir();
	$uploads_dir  = trailingslashit($uploads_path['basedir']);
	$uploads_uri  = trailingslashit(rwp_relative_url($uploads_path['baseurl']));

	$img_dir = wp_get_original_image_path($image);
	$img_folder = trailingslashit(pathinfo($img_dir, PATHINFO_DIRNAME));
	$img_folder = str_replace($uploads_dir, '', $img_folder);
	$ext = '.' . pathinfo($img_dir, PATHINFO_EXTENSION);
	$name = wp_basename($img_dir, $ext);
	$size = getimagesize($img_dir);

	$info = [
		'uploads_uri' => $uploads_uri,
		'uploads_dir' => $uploads_dir,
		'folder'      => $img_folder,
		'image_uri'   => trailingslashit(dirname(rwp_relative_url(wp_get_original_image_url($image)))),
		'image_dir'   => trailingslashit(dirname($img_dir)),
		'filename'    => $name,
		'ext'         => $ext
	];

	if ($size) {
		$info['mime'] = $size['mime'];
		$info['width'] = $size[0];
		$info['height'] = $size[1];
	}

	return $info;
}

function rwp_inline_svg($image, $args = array()){
	if (is_string($image)) {
		if (rwp_is_url($image) && !rwp_is_outbound_link($image)) {
			$image = attachment_url_to_postid($image);
		} elseif (is_numeric($image)) {
			$image = intval($image);
		}
	}

	if ($image instanceof \WP_Post) {
		$image = $image->ID;
	}

	if (!wp_attachment_is_image($image)) {
		return false;
	}

	$path = wp_get_original_image_path($image);

	$type = null;

	if ($path) {
		$type = pathinfo($path, PATHINFO_EXTENSION);
	}

	if('svg' !== $type || ! $path){
		return '';
	}

	$args['file'] = $path;

	$image = Media::svg($args);

	return $image->__toString();
}

function rwp_missing_sizes($image_meta = [], $image_src = '', $attachment_id = 0) {
	$type = pathinfo($image_src, PATHINFO_EXTENSION);

	if ($type !== 'svg') {

		$media_path = rwp_media_path($attachment_id);

		$mime = 'image/jpeg';

		if ($media_path && rwp_array_has('mime', $media_path)) {

			$mime = $media_path['mime'];
		}


		$sizes = rwp_collection();
		if (rwp_array_has('sizes', $image_meta)) {
			$sizes = rwp_collection($image_meta['sizes']);
		}
		$registered_sizes = rwp_collection(rwp_registered_image_sizes());

		if ($sizes->isNotEmpty()) {
			$missing_sizes = $registered_sizes->except($sizes->keys());
		} else {
			$missing_sizes = $registered_sizes;
		}



		if ($missing_sizes->isNotEmpty()) {
			$missing_sizes->transform(function ($item, $size)
			use ($attachment_id, $media_path, $mime) {

				$img_src = image_get_intermediate_size($attachment_id, $size);

				if ($img_src) {
					return $img_src;
				}

				$ext = $media_path['ext'];
				$name = $media_path['filename'];

				$file_name = $name;
				if ($size !== 'full') {
					if (rwp_array_has('width', $item) && rwp_array_has('height', $item)) {
						$file_name .= '-' . $item['width'] . 'x' . $item['height'];
					}
				} else {
					$item['width']  = $media_path['width'];
					$item['height'] = $media_path['height'];
				}

				$file_name .= $ext;

				$file_path = wp_normalize_path($media_path['image_dir'] . $file_name);
				if (file_exists($file_path)) {
					$item['file']      = $file_name;
					$item['mime-type'] = $mime;
				}

				return $item;
			});

			$sizes = $sizes->merge($missing_sizes);
		}

		$sizes = $sizes->reject(function ($item) {

			return !rwp_array_has('file', $item);
		});

		$sizes = $sizes->sortBy('width');

		$sizes = $sizes->all();

		return $sizes;
	} else {
		return [];
	}
}

/**
 * Get all the registered image sizes along with their dimensions
 *
 * @param string|int|\WP_Post $image The id of the image;
 *
 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
 *
 * @return array $image_sizes The image sizes
 */
function rwp_image_sizes($image) {

	if (is_string($image)) {
		if (rwp_is_url($image) && !rwp_is_outbound_link($image)) {
			$image = attachment_url_to_postid($image);
		} elseif (is_numeric($image)) {
			$image = intval($image);
		}
	}

	if ($image instanceof \WP_Post) {
		$image = $image->ID;
	}

	if (!wp_attachment_is_image($image)) {
		return false;
	}

	$type = wp_get_original_image_url($image);

	if ($type) {
		$type = pathinfo($type, PATHINFO_EXTENSION);
	}

	$sizes = [];

	$media_path = rwp_media_path($image);

	if ($media_path && rwp_array_has('mime', $media_path)) {

		$mime = $media_path['mime'];
	}

	if ('svg' !== $type) {
		$sizes = rwp_registered_image_sizes();

		$sizes = rwp_collection($sizes);

		if ($sizes->isNotEmpty()) {
			$sizes->transform(function ($item, $size) use ($image, $media_path, $mime) {

				$img_src = image_get_intermediate_size($image, $size);

				if ($img_src) {
					if (rwp_array_has('url', $img_src)) {
						$img_src['url'] = rwp_relative_url($img_src['url']);
					}
					return $img_src;
				}

				$ext = $media_path['ext'];
				$name = $media_path['filename'];

				$file_name = $name;
				if ($size !== 'full') {
					if (rwp_array_has('width', $item) && rwp_array_has('height', $item)) {
						$file_name .= '-' . $item['width'] . 'x' . $item['height'];
					}
				} else {
					$item['width']  = $media_path['width'];
					$item['height'] = $media_path['height'];
				}

				$file_name .= $ext;

				$file_path = wp_normalize_path($media_path['image_dir'] . $file_name);
				$file_uri = $media_path['image_uri'] . $file_name;
				if (file_exists($file_path)) {
					$item['file']      = $file_name;
					$item['path']      = $media_path['folder'] . $file_name;
					$item['url']       = $file_uri;
					$item['mime-type'] = $mime;
				}

				return $item;
			});
		}
		$sizes = $sizes->reject(function ($item) {

			return !rwp_array_has('file', $item);
		});

		$sizes = $sizes->sortBy('width');

		$sizes = $sizes->all();
		return $sizes;
	} else {
		return false;
	}
}

// @ Get Srcset
function rwp_get_srcset($id, $size = 'full') {
	$sizes = rwp_image_sizes($id);

	$type = wp_get_original_image_url($id);

	if ($type) {
		$type = pathinfo($type, PATHINFO_EXTENSION);
	}

	if ('svg' !== $type) {
		if ($sizes) {

			$sizes = rwp_collection($sizes);
			if ($size !== 'full') {

				$size_index = $sizes->keys()->search($size);
				if (false !== $size_index) {

					$size_keys = $sizes->keys()->takeUntil(function ($item, $key) use ($size_index) {
						return $key > $size_index;
					});

					$sizes = $sizes->only($size_keys->all());
				}
			}

			$sources = [];
			$srcset = [];
			if ($sizes->isNotEmpty() && $sizes->count() > 1) {
				// The 'src' image has to be the first in the 'srcset', because
				// of a bug in iOS8 but NOT the first <source>
				$last = $sizes->last();
				$last_size = $sizes->keys()->last();

				$srcset[$last_size] = sprintf('%1$s %2$dw %3$dh', $last['url'], $last['width'], $last['height']);
				$sources['sizes'][$size] = $last;

				foreach ($sizes->all() as $k => $v) {
					if ($last_size !== $k) { // So the last size isn't added twice
						$srcset[$k] = sprintf('%1$s %2$dw %3$dh', $v['url'], $v['width'], $v['height']);
					}

					$sources['sizes'][$k] = $v;
				}
				$srcset = implode(', ', $srcset);
				$sources['srcset'] = $srcset;
			}

			if (!empty($sources)) {
				return $sources;
			}
		}
	}
	return false;
}

// @ Has Dimensions
function rwp_image_has_dimensions($width = null, $height = null) {
	if ((!empty($width) && intval($width) != 0) && (!empty($height) && intval($height) != 0)) return true;
}

function rwp_image_atts($args) {

	$no_script =
		$type =
		$size =
		$src =
		$thumb =
		$id =
		$url =
		$file =
		$width =
		$height =
		$atts =
		$image = false;

	if (is_object($args)) {
		$args = rwp_object_to_array($args);
	}

	if (is_string($args)) {
		$no_script = '<noscript>' . $args . '</noscript>';
		$args = rwp_extract_html_atts($args);
	}

	if (is_array($args)) {
		extract($args);
	}

	if (empty($src)) {
		if (rwp_array_has('src', $args)) {
			$src = $args['src'];
		} else if (rwp_array_has('data-src', $args)) {
			$src = $args['data-src'];
		} else if (!empty($atts)) {
			if (rwp_array_has('data-id', $atts)) {
				$src = $atts['data-id'];
			} else if (rwp_array_has('src', $atts)) {
				$src = $atts['src'];
			} else if (rwp_array_has('data-src', $atts)) {
				$src = $atts['data-src'];
			}
		}
	}


	if (empty($src)) return;


	if (empty($size)) {
		if (rwp_array_has('class', $atts) && is_array($atts['class'])) {
			$img_class = implode(' ', $atts['class']);

			preg_match('/size\-(\w+)/', $img_class, $matches);

			if (!empty($matches)) {
				$size = $matches[1];
			}
		}
	}

	if (empty($size)) {
		$size = 'full';
	}

	if (is_string($src) && !is_numeric($src)) {
		$type = pathinfo($src, PATHINFO_EXTENSION);
		$url = rwp_relative_url($src);
		$id = attachment_url_to_postid($src);
	} else {
		$id = $src;
		$url = rwp_relative_url(wp_get_attachment_image_url($src, $size));
		$path = pathinfo($url);
		$type = pathinfo($url, PATHINFO_EXTENSION);
	}

	if (!empty($atts)) {
		$atts = rwp_prepare_args($atts);
	}

	$atts['class'][] = 'media-src';
	$atts['class'][] = 'lazyload';

	$width = rwp_array_has('width', $atts) ? $atts['width'] : null;
	$height = rwp_array_has('height', $atts) ? $atts['height'] : null;

	if (!rwp_image_has_dimensions($width, $height)) {
		$dimensions = [];
		if (rwp_is_url($src) && rwp_is_outbound_link($src)) {
			$dimensions = getimagesize($src);
		} elseif ($id) {
			$dimensions = wp_get_attachment_image_src($src, $size);
			if (!empty($dimensions)) {
				array_shift($dimensions);
				array_pop($dimensions);
			}
		}
		if (!empty($dimensions) && count($dimensions) == 2) {
			$dimensions = array_combine(['width', 'height'], $dimensions);
			if (rwp_array_has('width', $dimensions)) {
				if (!$dimensions['width']) {
					unset($dimensions['width']);
				}
			}
			if (rwp_array_has('height', $dimensions)) {
				if (!$dimensions['height']) {
					unset($dimensions['height']);
				}
			}
		}

		if (!empty($dimensions)) {
			if (rwp_array_has('width', $dimensions)) {
				$width = $dimensions['width'];
			}
			if (rwp_array_has('height', $dimensions)) {
				$height = $dimensions['height'];
			}
		}
		if ($type === 'svg') {
			$file = wp_get_original_image_path($src);
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
		}
	}
	if (rwp_image_has_dimensions($width, $height)) {
		if (!rwp_array_has('width', $atts)) {
			$atts['width'] = $width;
		}
		if (!rwp_array_has('height', $atts)) {
			$atts['height'] = $height;
		}
		if (!rwp_array_has('data-aspectratio', $atts)) {
			$atts['data-aspectratio'] = "$width/$height";
		}
	}


	if ($id && $type !== 'svg') {
		if (
			!rwp_array_has('srcset', $atts) &&
			!rwp_array_has('data-srcset', $atts)
		) {

			$sizes = rwp_get_srcset($id, $size);

			if (!empty($sizes)) {
				if (rwp_array_has('thumbnail', $sizes)) {
					$thumb = $sizes['thumbnail']['url'];
				}

				if (count($sizes) > 1) {
					$args['sources'] = $sizes;
					$atts['srcset'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
					$atts['data-srcset'] = $sizes['srcset'];
				}
				if (empty($thumb)) {
					$thumb = rwp_relative_url(wp_get_attachment_image_url($id, 'thumbnail'));
				}
			}
		}
	} else {
		$args['file'] = wp_get_original_image_path($src);
	}

	if (empty($no_script) && $type !== 'svg') {
		$image = rwp_html($args);
		$no_script = '<noscript>' . $image->__toString() . '</noscript>';
	}

	if (!rwp_array_has('data-src', $atts)) {
		$atts['data-src'] = $url;
	}

	if (rwp_array_has('src', $atts)) {
		unset($atts['src']);
	}

	if ($type !== 'svg') {

		if ($thumb) {
			$atts['src'] = $thumb;
		}
		$atts['data-sizes']  = 'auto';
	}
	if (rwp_array_has('sizes', $atts)) {

		unset($atts['sizes']);
	}
	if (rwp_array_has('srcset', $atts)) {

		unset($atts['srcset']);
	}

	$matches = preg_grep('/parent\-(\w+)/', $atts['class']);

	if (!empty($matches)) {
		$atts['data-parent-fit'] = $matches[1];
	}

	$args['noscript'] = $no_script;

	$args['type'] = $type;

	$args['atts'] = $atts;

	return $args;
}

/**
 * Filters the list of attachment image attributes.
 *
 * @since 2.8.0
 *
 * @param array        $attr       Array of attribute values for the image markup, keyed by attribute name.
 *                                 @see wp_get_attachment_image().
 * @param int|string|\WP_Post      $attachment Image attachment post.
 * @param string|array $size       Requested size. Image size or array of width and height values
 *                                 (in that order). Default 'thumbnail'.
 */
function rwp_image_attrs($attr, $attachment, $size) {
	if (is_string($attachment) && rwp_is_url($attachment) && !rwp_is_outbound_link($attachment)) {
		$attachment = attachment_url_to_postid($attachment);
	}

	$attachment = rwp_object_type($attachment);


	if ('post-thumbnail' === $size) {
		$size = 'thumbnail';
	}

	$attachment_id = rwp_get_option($attachment, 'id', 0);
	$attachment_object = rwp_get_option($attachment, 'object');

	if (!empty($attr)) {
		$attr = rwp_prepare_args($attr);
	}

	$url = '';
	$sizes = array();

	if (wp_attachment_is_image($attachment_id)) {
		$url   = rwp_relative_url(wp_get_attachment_image_url($attachment_id, $size));
		$sizes = rwp_image_sizes($attachment_object, $size);
	} else {
		if (rwp_array_has('src', $attr)) {
			$url = $attr['src'];
		} elseif (rwp_array_has('data-src', $attr)) {
			$url = $attr['data-src'];
		}
	}

	$classes = [
		'media-src',
		'lazyload',
	];

	if (rwp_array_has('class', $attr)) {
		$classes = rwp_merge_classes($classes, $attr['class']);
	}

	if (rwp_array_has('style', $attr)) {
		$attr['style'] = rwp_parse_styles($attr['style']);
	}

	$width  = rwp_get_option($attr, 'width', null);
	$height = rwp_get_option($attr, 'height', null);

	if (!rwp_image_has_dimensions($width, $height)) {
		if (rwp_array_has($size, $sizes)) {
			if (rwp_array_has('width', $sizes[$size])) {
				$width = $sizes[$size]['width'];
			}
			if (rwp_array_has('height', $sizes[$size])) {
				$height = $sizes[$size]['height'];
			}
		}
	}

	if (rwp_image_has_dimensions($width, $height)) {
		if (!rwp_array_has('data-aspectratio', $attr)) {
			$attr['data-aspectratio'] = "$width/$height";
		}
		if (!rwp_array_has('width', $attr)) {
			$attr['width'] = $width;
		}
		if (!rwp_array_has('height', $attr)) {
			$attr['height'] = $height;
		}
	}


	$attr['data-src'] = $url;

	if (rwp_array_has('src', $attr)) {
		unset($attr['src']);
	}

	$attr['data-sizes']  = 'auto';
	if (rwp_array_has('sizes', $attr)) {

		unset($attr['sizes']);
	}
	if (rwp_array_has('srcset', $attr)) {

		$srcset = rwp_get_srcset($attachment, $size);

		$srcset = $srcset['srcset'];

		$attr['data-srcset'] = $srcset;
		$attr['srcset'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
	}

	$classes = rwp_output_classes($classes);

	preg_match('/parent\-fit\-(\w+)/', $classes, $parent_fit);

	if (!empty($parent_fit)) {
		$attr['data-parent-fit'] = $parent_fit[1];
		$classes = str_replace($parent_fit[0], '', $classes);
		$attr['data-parent-container'] = '.media-content';
	}

	if (!empty($classes)) {
		$attr['class'] = $classes;
	}

	if (rwp_array_has('style', $attr) && is_array($attr['style'])) {
		$attr['style'] = rwp_output_styles($attr['style']);
	}

	return $attr;
}

/**
 * Get post thumbnail object.
 *
 * @since 2.9.0
 *
 * @param string       $html              The post thumbnail HTML.
 * @param int          $post_id           The post ID.
 * @param int          $post_thumbnail_id The post thumbnail ID.
 * @param string|int[] $size              Requested image size. Can be any registered image size name, or
 *                                        an array of width and height values in pixels (in that order).
 * @param string|string[]       $attr              Query string of attributes.
 *
 * @return false|\RWP\Components\Media
 */

function rwp_post_thumbnail_object($post_id, $post_thumbnail_id = 0,  $size = '', $html = '',  $attr = []) {


	$attr = rwp_prepare_args($attr);

	$post = rwp_object_type($post_id);

	$img_id = $post_thumbnail_id;

	if (empty($img_id)) {
		$img_id = rwp_featured_image_id();
	}

	// $post_thumbnail_id = apply_filters('rwp_thumbnail_id', $post_thumbnail_id, $post_id, $size);



	if (empty($html)) {
		$html = wp_get_attachment_image($post_thumbnail_id, $size, $attr);
	}

	$image = rwp_extract_html_tag($html, 'img');


	$img = false;

	if ($image) {

		$media = rwp_extract_html_tag($html, ['a', 'picture']);

		$figure = rwp_extract_html_tag($html, 'figure');

		$image = apply_filters('rwp_thumbnail_image', $image, $post_id, $size);
		if (!rwp_array_has('alt', $image['atts']) && !empty($post_id)) {
			$image['atts']['alt'] = get_the_title($post_id);
		}
		if (!rwp_array_has('title', $image['atts']) && !empty($post_id)) {
			$image['atts']['title'] = get_the_title($post_id);
		}
		if (!rwp_array_has('itemprop', $image['atts'])) {
			$image['atts']['itemprop'] = 'image';
		}
		$media = apply_filters('rwp_thumbnail_media', $media, $post_id, $size);
		$figure = apply_filters('rwp_thumbnail_figure', $figure, $post_id, $size);

		$args = [
			'src' => $post_thumbnail_id,
			'size' => $size,
			'image' => $image,
			'media' => $media,
			'atts' => $figure['atts']
		];

		$args = rwp_merge_args($args, $attr);

		$args = apply_filters('rwp_thumbnail', $image, $media, $figure, $args, $post_id, $size);

		$img = rwp_media($args);

		$img->addClass(data_get($post, 'subtype', 'post') . '-thumbnail');

		$img->addClass(data_get($post, 'id', 0)  . '-thumbnail');
	}

	return $img;
}


/**
 * Get the featured image id of a post with filters
 *
 * @param mixed|null $post
 * @return false|int|string
 */

function rwp_featured_image_id($post = null) {
	$id = false;

	$post = rwp_object_type($post);
	$post_id = rwp_get_option($post, 'id', 0);

	if (has_post_thumbnail($post_id)) {
		$id = get_post_thumbnail_id($post_id);
	}

	$id = apply_filters('rwp_featured_image_id', $id, $post);

	return $id;
}


/**
 * Get the featured image object for a post
 *
 * @param mixed|null $post
 * @param array $args
 * @return Media|false
 */
function rwp_get_featured_image($post = null, $size = 'full',  $args = [], $html = '') {

	$post = rwp_object_type($post);
	$post_id = rwp_get_option($post, 'id', 0);

	$image = rwp_get_option($args, 'image', array());
	$image_atts = rwp_get_option($image, 'atts', array());

	$id = rwp_featured_image_id($post);


	if ($id) {

		$args['src'] = $id;

		$args['size'] = $size;

		if (!rwp_array_has('atts', $image)) {
			$image['atts'] = array();
		}

		if (!rwp_array_has('alt', $image['atts']) && !empty($post_id)) {
			$image['atts']['alt'] = rwp_title($post);
		}
		if (!rwp_array_has('title', $image['atts']) && !empty($post_id)) {
			$image['atts']['title'] = rwp_title($post);
		}
		if (!rwp_array_has('itemprop', $image['atts'])) {
			$image['atts']['itemprop'] = 'image';
		}

		$args['image'] = $image;

		$args = apply_filters('rwp_featured_image', $args, $post);

		return rwp_media($args);
	} else {
		return false;
	}
}

/**
 * Print the featured image for a post
 *
 * @param mixed|null $post
 * @param array $args
 * @return void
 */
function rwp_featured_image($post = null, $args = []) {

	$post = rwp_post_object($post);

	$image = rwp_get_featured_image($post, $args);

	if ($image) {
		echo wp_kses_post($image);
	}
}

if (!function_exists('rwp_get_logo')) {
	function rwp_get_logo($args = []) {

		$defaults = [
			'link' => true,
			'atts' => [
				'class' => [
					'site-title'
				]
			]
		];

		$args = rwp_merge_args($defaults, $args);
		$id = 0;
		$size = 'full';
		$image = array();
		$alt = '';
		$type = 'jpg';
		$img_id = get_theme_mod('custom_logo');
		$file = '';

		if (rwp_array_has('src', $args)) {
			$id = $args['id'];
		}

		if (!empty($id)) {
			if (is_string($id)) {
				if (rwp_is_url($id) && !rwp_is_outbound_link($id)) {
					$id = attachment_url_to_postid($id);
				} elseif (is_numeric($id)) {
					$id = intval($id);
				}
			}
		}

		if (empty($id)) {
			$id = get_theme_mod('custom_logo');
		}

		if (rwp_array_has('size', $args)) {

			$size = $args['size'];
		}

		if (rwp_array_has('image', $args)) {
			if (rwp_array_has('atts', $args['image'])) {
				$image = $args['image']['atts'];
				if (rwp_array_has('alt', $args['image']['atts'])) {
					$alt = $args['image']['atts']['alt'];
				}
			}
		}

		$link_atts = [
			'atts' => [
				'itemprop' => 'url',
				'href' => '/',
				'title' => get_bloginfo('name') . ' Home',
				'rel' => 'home'

			]
		];
		if (is_front_page() && !is_paged()) {
			$link_atts['atts']['aria-current'] = 'page';
		}
		if ($args['link']) {

			$args = rwp_merge_args($args, $link_atts);
		}
		if (empty($id)) {
			$args['content'] = get_bloginfo('name', 'display');
			if ($args['link']) {

				$args = rwp_merge_args($args, $link_atts);
				$site_title = rwp_link($args);
			} else {
				$site_title = rwp_text($args);
			}
			return $site_title;
		}

		$file = wp_get_original_image_path($id);

		if ($file) {
			$type = pathinfo($file, PATHINFO_EXTENSION);
		}

		/**
		 * If the logo alt attribute is empty, get the site title and explicitly pass it
		 * to the attributes used by wp_get_attachment_image().
		 */
		$alt = get_post_meta($id, '_wp_attachment_image_alt', true);
		if (empty($alt)) {
			$alt = get_bloginfo('name', 'display');
		}

		$image['alt'] = $alt;

		$image = rwp_image_attrs($image, $id, $size);

		/**
		 * Filters the list of custom logo image attributes.
		 *
		 * @since 5.5.0
		 *
		 * @param array $custom_logo_attr Custom logo image attributes.
		 * @param int   $custom_logo_id   Custom logo attachment ID.
		 * @param int   $blog_id          ID of the blog to get the custom logo for.
		 */
		$image = apply_filters('get_custom_logo_image_attributes', $image, $id);


		if (rwp_array_has('link', $args)) {
			if ($args['link']) {

				$args = rwp_merge_args($args, $link_atts);
			}
		}

		$defaults = [
			'src'  => $id,
			'image' => [
				'type' => $type,
				'file' => $file,
				'atts' => $image,
			]
		];

		$defaults = apply_filters('rwp_logo_args', $defaults);

		$args = rwp_merge_args($defaults, $args);

		$image = rwp_media($args);

		return $image;
	}
}
