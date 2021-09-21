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

namespace RWP\Internals;

use RWP\Engine\Abstracts\Singleton;


class Lazysizes extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
			add_filter( 'wp_get_attachment_image', array( $this, 'rwp_update_image_tag' ), 30, 5 );
		}
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
			$html = rwp_image( $html )->html();
		}

		return $html;
	}

}
