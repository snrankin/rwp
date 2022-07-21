<?php

/**
 * ============================================================================
 * image
 *
 * @package   RWP\/includes/functions/utils/image.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ==========================================================================
 */

use RWP\Html\Element;
use RWP\Html\Html;
use RWP\Html\Image;
use RWP\Html\SVG;
use RWP\Vendor\Exceptions\IO\Filesystem\FileNotFoundException;

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
	foreach ( $registered_sizes as $_size ) {
		if ( ! rwp_array_has( $_size, $wp_additional_image_sizes ) ) {
			$sizes[ $_size ]['width'] = intval( get_option( $_size . '_size_w' ) );
			$sizes[ $_size ]['height'] = intval( get_option( $_size . '_size_h' ) );
			$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
		} elseif ( isset( $wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => intval( $wp_additional_image_sizes[ $_size ]['width'] ),
				'height' => intval( $wp_additional_image_sizes[ $_size ]['height'] ),
				'crop'   => boolval( $wp_additional_image_sizes[ $_size ]['crop'] ),
			);
		}
	}

	$sizes = rwp_collection( $sizes );
	$sizes = $sizes->sortBy( 'width' );
	$sizes = $sizes->all();
	$sizes['full'] = [ 'crop' => false ];
	return $sizes;
}

function rwp_media_path( $image = null ) {

	if ( empty( $image ) ) {
		return false;
	}

	if ( is_string( $image ) ) {
		if ( rwp_is_url( $image ) && ! rwp_is_outbound_link( $image ) ) {
			$image = attachment_url_to_postid( $image );
		} elseif ( is_numeric( $image ) ) {
			$image = intval( $image );
		}
	}

	if ( $image instanceof \WP_Post ) {
		$image = $image->ID;
	}

	if ( ! wp_attachment_is_image( $image ) ) {
		return false;
	}

	$uploads_path = wp_get_upload_dir();
	$uploads_dir  = trailingslashit( $uploads_path['basedir'] );
	$uploads_uri  = trailingslashit( rwp_relative_url( $uploads_path['baseurl'] ) );

	$img_dir = wp_get_original_image_path( $image );
	$img_folder = trailingslashit( pathinfo( $img_dir, PATHINFO_DIRNAME ) );
	$img_folder = str_replace( $uploads_dir, '', $img_folder );
	$ext = '.' . pathinfo( $img_dir, PATHINFO_EXTENSION );
	$name = wp_basename( $img_dir, $ext );
	$size = getimagesize( $img_dir );

	$info = [
		'uploads_uri' => $uploads_uri,
		'uploads_dir' => $uploads_dir,
		'folder'      => $img_folder,
		'image_uri'   => trailingslashit( dirname( rwp_relative_url( wp_get_original_image_url( $image ) ) ) ),
		'image_dir'   => trailingslashit( dirname( $img_dir ) ),
		'filename'    => $name,
		'ext'         => $ext,
	];

	if ( $size ) {
		$info['mime'] = $size['mime'];
		$info['width'] = $size[0];
		$info['height'] = $size[1];
	}

	return $info;
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
function rwp_image_sizes( $image ) {

	if ( is_string( $image ) ) {
		if ( rwp_is_url( $image ) && ! rwp_is_outbound_link( $image ) ) {
			$image = attachment_url_to_postid( $image );
		} elseif ( is_numeric( $image ) ) {
			$image = intval( $image );
		}
	}

	if ( $image instanceof \WP_Post ) {
		$image = $image->ID;
	}

	if ( ! wp_attachment_is_image( $image ) ) {
		return false;
	}

	$type = wp_get_original_image_url( $image );

	if ( $type ) {
		$type = pathinfo( $type, PATHINFO_EXTENSION );
	}

	$sizes = [];

	$media_path = rwp_media_path( $image );

	if ( $media_path && rwp_array_has( 'mime', $media_path ) ) {

		$mime = $media_path['mime'];
	}

	if ( 'svg' !== $type ) {
		$sizes = rwp_registered_image_sizes();

		$sizes = rwp_collection( $sizes );

		if ( $sizes->isNotEmpty() ) {
			$sizes->transform(function ( $item, $size ) use ( $image, $media_path, $mime ) {

				$img_src = image_get_intermediate_size( $image, $size );

				if ( $img_src ) {
					if ( rwp_array_has( 'url', $img_src ) ) {
						$img_src['url'] = rwp_relative_url( $img_src['url'] );
					}
					return $img_src;
				}

				$ext = $media_path['ext'];
				$name = $media_path['filename'];

				$file_name = $name;
				if ( 'full' !== $size ) {
					if ( rwp_array_has( 'width', $item ) && rwp_array_has( 'height', $item ) ) {
						$file_name .= '-' . $item['width'] . 'x' . $item['height'];
					}
				} else {
					$item['width']  = $media_path['width'];
					$item['height'] = $media_path['height'];
				}

				$file_name .= $ext;

				$file_path = wp_normalize_path( $media_path['image_dir'] . $file_name );
				$file_uri = $media_path['image_uri'] . $file_name;
				if ( file_exists( $file_path ) ) {
					$item['file']      = $file_name;
					$item['path']      = $media_path['folder'] . $file_name;
					$item['url']       = $file_uri;
					$item['mime-type'] = $mime;
				}

				return $item;
			});
		}
		$sizes = $sizes->reject(function ( $item ) {

			return ! rwp_array_has( 'file', $item );
		});

		$sizes = $sizes->sortBy( 'width' );

		$sizes = $sizes->all();
		return $sizes;
	} else {
		return false;
	}
}

/**
 * Get an array with formatted srcset url and source urls
 *
 * @param mixed $id
 * @param string $size
 * @return array|false
 * @throws Exception
 */
function rwp_get_srcset( $id, $size = 'full' ) {
	$sizes = rwp_image_sizes( $id );

	$type = wp_get_original_image_url( $id );

	if ( $type ) {
		$type = pathinfo( $type, PATHINFO_EXTENSION );
	}

	if ( 'svg' !== $type ) {
		if ( $sizes ) {

			$sizes = rwp_collection( $sizes );
			if ( 'full' !== $size ) {

				$size_index = $sizes->keys()->search( $size );
				if ( false !== $size_index ) {

					$size_keys = $sizes->keys()->takeUntil(function ( $item, $key ) use ( $size_index ) {
						return $key > $size_index;
					});

					$sizes = $sizes->only( $size_keys->all() );
				}
			}

			$sources = [];
			$srcset = [];
			if ( $sizes->isNotEmpty() && $sizes->count() > 1 ) {

				foreach ( $sizes->all() as $k => $v ) {
					$srcset[ $k ] = sprintf( '%1$s %2$dw %3$dh', $v['url'], $v['width'], $v['height'] );

					$sources['sizes'][ $k ] = $v;
				}
				$srcset = implode( ', ', $srcset );
				$sources['srcset'] = $srcset;
			}

			if ( ! empty( $sources ) ) {
				return $sources;
			}
		}
	}
	return false;
}

/**
 * Gets the formatted string for source tags for responsive images
 *
 * @param mixed $image
 * @param mixed $size
 * @return string
 * @throws InvalidArgumentException
 * @throws Exception
 */
function rwp_image_sources( $image, $size ) {
	$id = rwp_image_id( $image );
	$sources = '';
	if ( 0 != $id ) {
		$srcset = rwp_get_srcset( $id, $size );

		if ( $srcset ) {
			$sources .= '<!--[if IE 9]><audio><![endif]-->';
			foreach ( $srcset['sizes'] as $name => $src ) {
				$url = data_get( $src, 'url', '' );
				$width = data_get( $src, 'width', 0 );
				$height = data_get( $src, 'height', 0 );
				if ( ! empty( $url ) ) {
					$aspect = '';
					if ( rwp_image_has_dimensions( $width, $height ) ) {
						$aspect = "$width/$height";
					}
					$sources .= wp_sprintf( '<source data-srcset="%s %dw" media="--media-%s" data-tag="media-%s" data-aspectratio="%s" />', $url, $width, $name, $name, $aspect );
				}
			}
			$sources .= '<!--[if IE 9]></audio><![endif]-->';
		}
	}

	return $sources;
}

/**
 * Check if an image has a width and a height
 * @param mixed $width
 * @param mixed $height
 * @return bool
 */
function rwp_image_has_dimensions( $width = null, $height = null ) {
	if ( ( ! empty( $width ) && intval( $width ) != 0 ) && ( ! empty( $height ) && intval( $height ) != 0 ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the variable is an image url, id or instance of WP_Post
 *
 * @param  mixed $image
 * @return bool
 */

function rwp_is_image( $image ) {
	if ( empty( $image ) ) {
		return false;
	}

	$image_types = array(
		// Jpeg
		'jpg',
		'jpeg',
		'jpe',
		'jif',
		'jfif',
		'jfi',
		// PNG
		'png',
		// GIF
		'gif',
		// Google Webp
		'webp',
		// SVGS
		'svg',
		'svgz',
		// iOS High Efficiency Image File
		'heif',
		'heic',
		// Jpeg 2000
		'jp2',
		'j2k',
		'jpf',
		'jpx',
		'jpm',
		'mj2',
		// TIFF
		'tiff',
		'tif',
		// Icons
		'ico',
		// Windows
		'bmp',
		'dib',
	);

	if ( is_string( $image ) ) {
		if ( ! rwp_str_is_html( $image ) ) {
			$ext = pathinfo( $image, PATHINFO_EXTENSION );
			return in_array( $ext, $image_types );
		} else {
			return rwp_str_is_element( $image, 'img' );
		}
	} elseif ( $image instanceof \WP_Post ) {
		return wp_attachment_is_image( $image );
	} elseif ( is_int( $image ) ) {
		return wp_attachment_is_image( $image );
	} elseif ( $image instanceof Element ) {
		return 'img' === $image->tag ? true : false;
	} elseif ( $image instanceof Html ) {
		return 'img' === $image->getTag() ? true : false;
	}

	return false;
}

/**
 * Extracts an image src
 *
 * @param  mixed  $image
 * @param  string $size
 * @return string|false
 */

function rwp_extract_img_src( $image, $size = 'full' ) {
	$src = false;

	$image_types = array(
		// Jpeg
		'jpg',
		'jpeg',
		'jpe',
		'jif',
		'jfif',
		'jfi',
		// PNG
		'png',
		// GIF
		'gif',
		// Google Webp
		'webp',
		// SVGS
		'svg',
		'svgz',
		// iOS High Efficiency Image File
		'heif',
		'heic',
		// Jpeg 2000
		'jp2',
		'j2k',
		'jpf',
		'jpx',
		'jpm',
		'mj2',
		// TIFF
		'tiff',
		'tif',
		// Icons
		'ico',
		// Windows
		'bmp',
		'dib',
	);

	if ( $image instanceof Element ) {
		$image = $image->html();
	}

	if ( is_string( $image ) ) {
		if ( ! rwp_str_is_html( $image ) ) {
			$ext = pathinfo( $image, PATHINFO_EXTENSION );
			if ( in_array( $ext, $image_types ) ) {
				$src = $image;
			}
		} elseif ( is_numeric( $image ) ) {
			$image = intval( $image );
			$src = wp_get_attachment_image_url( $image, $size, false );
		} elseif ( rwp_str_is_html( $image ) ) {
			$image = rwp_html( $image )->filter( 'img' );
			$src = $image->getAttribute( 'src' );
			if ( empty( $src ) ) {
				$src = $image->getAttribute( 'data-src' );
			}
		}
	} elseif ( ( $image instanceof \WP_Post ) ) {
		$src = wp_get_attachment_image_url( $image->ID, $size, false );
	} elseif ( is_int( $image ) ) {
		$src = wp_get_attachment_image_url( $image, $size, false );
	} elseif ( $image instanceof Html ) {
		$image = $image->filter( 'img' );
		$src = $image->getAttribute( 'src' );
		if ( empty( $src ) ) {
			$src = $image->getAttribute( 'data-src' );
		}
	}
	return $src;
}

/**
 * Checks if the variable is an image in the WordPress Media Library
 *
 * @param  mixed $image
 * @return bool
 * @throws InvalidArgumentException
 */

function rwp_is_wp_image( $image ) {
	$image = rwp_extract_img_src( $image );

	if ( rwp_is_url( $image ) ) {
		$image = preg_replace( '/-\d{1,4}x\d{1,4}/', '', $image );
		$image = rwp_add_prefix( $image, get_home_url() );
		return 0 !== attachment_url_to_postid( $image );
	}

	return false;
}

/**
 * Get the ID of an image from the WordPress Media Library
 *
 * @param  mixed $image
 * @return int
 * @throws InvalidArgumentException
 */
function rwp_image_id( $image ) {
	$id = 0;
	if ( rwp_is_url( $image ) ) {
		$image = preg_replace( '/-\d{1,4}x\d{1,4}/', '', $image );
		$image = rwp_add_prefix( $image, get_home_url() );
		$id = attachment_url_to_postid( $image );
	}

	return $id;
}
/**
 * Get the linked site title or the custom logo
 *
 * @param array $args
 *
 * @return string
 */
function rwp_get_logo( $args = array() ) {
	$content = get_bloginfo( 'name', 'display' );

	$unlink_homepage_logo = (bool) get_theme_support( 'custom-logo', 'unlink-homepage-logo' );

	if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
		// If on the home page, don't link the logo to home.
		$content = sprintf(
			'<span class="custom-logo-link">%1$s</span>',
			$content
		);
	} else {
		$aria_current = is_front_page() && ! is_paged() ? ' aria-current="page"' : '';

		$content = sprintf(
			'<a href="%1$s" class="custom-logo-link" rel="home"%2$s>%3$s</a>',
			home_url( '/' ),
			$aria_current,
			$content
		);
	}

	if ( has_custom_logo() ) {
		$content = get_custom_logo();
	}

	$html = rwp_html( $content );

	if ( ! empty( $args ) ) {
		$html->setAllAttributes( $args );
	}

	return $html->saveHTML();
}


/**
 * Get the featured image id of a post with filters
 *
 * @param mixed|null $post
 * @return false|int|string
 */

function rwp_featured_image_id( $post = null ) {

	$id      = false;
	$post    = rwp_post_object( $post );
	$post_id = rwp_post_id( $post );

	if ( has_post_thumbnail( $post_id ) ) {
		$id = get_post_thumbnail_id( $post_id );
	}

	$id = apply_filters( 'rwp_featured_image_id', $id, $post );

	return $id;
}


/**
 * Get the featured image object for a post
 *
 * @param mixed|null $post
 * @param array $args
 * @return Image|false
 */
function rwp_get_featured_image( $post = null, $size = 'full', $args = [], $html = '' ) {

	$post    = rwp_post_object( $post );
	$post_id = rwp_post_id( $post );

	$image = data_get( $args, 'image', array() );

	$id = rwp_featured_image_id( $post );

	if ( $id ) {

		$args['id'] = $id;
		$args['size'] = $size;
		$args['html'] = $html;

		if ( ! rwp_array_has( 'atts', $image ) ) {
			$image['atts'] = array();
		}

		if ( ! rwp_array_has( 'alt', $image['atts'] ) && ! empty( $post_id ) ) {
			$image['atts']['alt'] = rwp_post_title( $post, false, 'Image for ' );
		}

		if ( ! rwp_array_has( 'itemprop', $image['atts'] ) ) {
			$image['atts']['itemprop'] = 'image';
		}

		if ( ! rwp_array_has( 'tag', $image ) ) {
			$image['tag'] = 'img';
		}

		$args['image'] = $image;

		$args = apply_filters( 'rwp_get_featured_image', $args, $post );

		return rwp_image( $args );
	} else {
		return false;
	}
}

/**
 * Get dimensions of svg from viewbox attributes
 *
 * @param string $file
 * @return array|false
 */
function rwp_get_svg_dimensions( $file ) {
	$svg_file = simplexml_load_file( $file );
	if ( $svg_file ) {
		$svg_file = rwp_xml_to_array( $svg_file );
		$view_box = null;

		if ( rwp_array_has( 'viewBox', $svg_file['atts'] ) ) {
			$view_box = $svg_file['atts']['viewBox'];
			$view_box = explode( ' ', $view_box );
		}

		if ( rwp_array_has( 'width', $svg_file['atts'] ) ) {
			$width = $svg_file['atts']['width'];
		} elseif ( ! empty( $view_box ) ) {
			$width = floatval( $view_box[2] );
		}

		if ( rwp_array_has( 'height', $svg_file['atts'] ) ) {
			$height = $svg_file['atts']['height'];
		} elseif ( ! empty( $view_box ) ) {
			$height = floatval( $view_box[3] );
		}
		return array(
			'width'  => $width,
			'height' => $height,
		);
	} else {
		return false;
	}
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
function rwp_image_attrs( $attr = array(), $attachment = 0, $size = 'full' ) {
	if ( is_string( $attachment ) && rwp_is_url( $attachment ) && ! rwp_is_outbound_link( $attachment ) ) {
		$attachment = attachment_url_to_postid( $attachment );
	}

	$attachment = rwp_post_object( $attachment );
	$attachment_id = data_get( $attachment, 'id', 0 );
	$attachment_object = data_get( $attachment, 'object' );

	if ( ! empty( $attr ) ) {
		$attr = rwp_prepare_args( $attr );
	}

	$url = '';
	$sizes = array();

	if ( wp_attachment_is_image( $attachment_id ) ) {
		$url   = rwp_relative_url( wp_get_attachment_image_url( $attachment_id, $size ) );
		$sizes = rwp_image_sizes( $attachment_object, $size );
	} else {
		if ( rwp_array_has( 'src', $attr ) ) {
			$url = $attr['src'];
		} elseif ( rwp_array_has( 'data-src', $attr ) ) {
			$url = $attr['data-src'];
		}
	}

	$type = pathinfo( $url, PATHINFO_EXTENSION );

	if ( rwp_array_has( 'style', $attr ) ) {
		$attr['style'] = rwp_parse_styles( $attr['style'] );
	}

	$width  = data_get( $attr, 'width', null );
	$height = data_get( $attr, 'height', null );

	if ( ! rwp_image_has_dimensions( $width, $height ) ) {
		if ( 'svg' === $type ) {
			$file = wp_get_original_image_path( $attachment_id );
			$svg_dimensions = rwp_get_svg_dimensions( $file );
			if ( $svg_dimensions ) {
				list($width, $height) = $svg_dimensions;
			}
		} else {
			if ( rwp_array_has( $size, $sizes ) ) {
				if ( rwp_array_has( 'width', $sizes[ $size ] ) ) {
					$width = $sizes[ $size ]['width'];
				}
				if ( rwp_array_has( 'height', $sizes[ $size ] ) ) {
					$height = $sizes[ $size ]['height'];
				}
			}
		}
	}

	if ( rwp_image_has_dimensions( $width, $height ) ) {
		if ( ! rwp_array_has( 'width', $attr ) ) {
			$attr['width'] = $width;
		}
		if ( ! rwp_array_has( 'height', $attr ) ) {
			$attr['height'] = $height;
		}
	}

	if ( ! rwp_array_has( 'srcset', $attr ) ) {

		$srcset = rwp_get_srcset( $attachment_id, $size );

		if ( $srcset ) {
			$attr['srcset'] = $srcset['srcset'];
		}
	}

	if ( ! rwp_array_has( 'alt', $attr ) ) {

		$image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

		if ( empty( $image_alt ) && $attachment_object instanceof \WP_Post ) {
			$image_alt = $attachment_object->post_title;
		}
		if ( empty( $image_alt ) ) {
			$image_alt = wp_get_attachment_caption( $attachment_id );
		}

		if ( empty( $image_alt ) && $attachment_object instanceof \WP_Post ) {
			$image_alt = $attachment_object->post_excerpt;
		}
	}

	if ( rwp_array_has( 'style', $attr ) && is_array( $attr['style'] ) ) {
		$attr['style'] = rwp_output_styles( $attr['style'] );
	}

	return $attr;
}

/**
 * Base64 encode an image
 *
 * @param mixed $image
 * @return string
 * @throws DOMException
 * @throws InvalidArgumentException
 * @throws FileNotFoundException
 */

function rwp_encode_img( $image ) {
	$mime = '';
	if ( rwp_is_component( $image, 'SVG' ) ) {
		/**
		 * @var SVG $image
		 */
		$image = $image->html();
		$mime = 'image/svg';
	} elseif ( rwp_is_component( $image, 'Image' ) ) {
		/**
		 * @var Image $image
		 */
		$image = $image->html();
		$mime = rwp_extract_img_src( $image );
		$mime = mime_content_type( $mime );
	} elseif ( is_string( $image ) ) {

		if ( rwp_file_exists( $image ) ) {
			$mime = mime_content_type( $image );
			$image = rwp_filesystem()->get_contents( $image );
		}
	}

	if ( is_string( $image ) ) {

		// Read image path, convert to base64 encoding
		$image_data = base64_encode( $image );
		if ( 'image/svg' === $mime ) {
			$mime .= '+xml';
		}
		$src = 'data:' . $mime . ';base64,' . $image_data;
		return $src;
	}

	return '';
}
