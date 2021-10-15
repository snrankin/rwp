<?php
/** ============================================================================
 * Lazysizes
 *
 * Improve lazy image loading with Lazysizes plugin
 *
 * @package   RWP\Internals\Lazysizes
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Image;

class Lazysizes extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
			add_filter( 'wp_get_attachment_image', array( $this, 'update_image_tag' ), 30, 5 );
		}

		add_filter( 'wp_calculate_image_srcset_meta', array( $this, 'svg_image_sizes' ), 5, 4 );

		add_action( 'init', array( $this, 'update_image_sizes' ) );
	}

	/**
	 * Update default image sizes
	 *
	 * @return void
	 */
	public function update_image_sizes() {
		update_option( 'thumbnail_size_w', 120 );
		update_option( 'thumbnail_size_h', 120 );
		update_option( 'thumbnail_crop', 1 );

		update_option( 'post-thumbnail_size_w', 480 );
		update_option( 'post-thumbnail_size_h', 360 );
		update_option( 'post-thumbnail_crop', 1 );

		update_option( 'medium_size_w', 768 );
		update_option( 'medium_size_h', 576 );
		update_option( 'medium_crop', 0 );

		update_option( 'medium_large_size_w', 1024 );
		update_option( 'medium_large_size_h', 768 );
		update_option( 'medium_large_crop', 0 );

		update_option( 'large_size_w', 1280 );
		update_option( 'large_size_h', 960 );
		update_option( 'large_crop', 0 );

		add_image_size( 'small', 480, 360, true );
	}


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

	public function update_image_tag( $html, $attachment_id, $size, $icon, $attr ) {

		if ( ! empty( $html ) ) {
			$html = Image::add_lazysizes( $html );
			$html = $html->html();
		}

		return $html;
	}

	/**
	 * Pre-filter the image meta to be able to fix inconsistencies in the stored data for svgs.
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

	public function svg_image_sizes( $image_meta = [], $size_array = [], $image_src = '', $attachment_id = 0 ) {
		$type = pathinfo( $image_src, PATHINFO_EXTENSION );

		if ( 'svg' === $type && empty( $size_array ) ) {
			$height = data_get( $image_meta, 'height', 0 );
			$width = data_get( $image_meta, 'width', 0 );
			if ( empty( $width ) || empty( $height ) ) {
				$file = wp_get_original_image_path( $attachment_id );
				$svg_file = simplexml_load_file( $file );
				if ( $svg_file ) {
					$svg_file = rwp_xml_to_array( $svg_file );
					$view_box = explode( ' ', data_get( $svg_file, 'atts.viewBox', '' ) );

					if ( ! empty( $view_box ) ) {
						$height = intval( $view_box[3] );
						$width = intval( $view_box[2] );
					}
				}
				if ( ! empty( $width ) && ! empty( $height ) ) {
					$image_meta['width'] = $width;
					$image_meta['height'] = $height;
				}
			}
			$image_meta['sizes'] = [];
		}
		return $image_meta;
	}
}
