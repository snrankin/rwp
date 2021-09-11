<?php
/** ============================================================================
 * lazysizes
 *
 * @package   RWP\/includes/internals/Modules/lazysizes.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals\Modules\LazySizes;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}
if ( ! rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
	return;
}

function enqueue_lazysizes() {
	// if ( ! wp_style_is( 'rwp-lazysizes', 'registered' ) ) {
	// 	rwp()->register_styles( 'lazysizes' );
	// }

	if ( ! wp_script_is( 'rwp-lazysizes', 'registered' ) ) {
		rwp()->register_scripts( 'lazysizes' );
	}

	rwp()->enqueue_assets( 'lazysizes' );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_lazysizes' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_lazysizes' );

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

function rwp_update_image_tag( $html, $attachment_id, $size, $icon, $attr ) {

	if ( ! empty( $html ) ) {
		$html = rwp_image( $html )->html();
	}

	return $html;
}
add_filter( 'wp_get_attachment_image', __NAMESPACE__ . '\\rwp_update_image_tag', 30, 5 );
