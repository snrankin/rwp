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
	 * @var string The current version of lazysizes
	 */
	private static $version = '5.3.2';

	/**
	 * @var bool[] The array of  additional lazysizes plugins to add
	 */
	protected static $plugins  = array(
		'artdirect'   => false,
		'aspectratio' => true,
		'custommedia' => false,
		'bgset'       => true,
		'blur-up'     => false,
		'noscript'    => false,
		'object-fit'  => true,
		'parent-fit'  => false,
		'print'       => true,
		'progressive' => true,
		'respimg'     => true,
		'unload'      => true,
		'video-embed' => true,
	);

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'add_lazysizes' ) );

		add_filter( 'wp_get_attachment_image', array( $this, 'update_image_tag' ), 30, 5 );

		add_filter( 'wp_calculate_image_srcset_meta', array( $this, 'svg_image_sizes' ), 5, 4 );

		add_action( 'after_setup_theme', array( $this, 'update_image_sizes' ) );
	}

	/**
	 * Add the various lazysizes scripts
	 *
	 * @return void
	 */

	public function add_lazysizes() {
		// Options that can be enabled/disabled from the admin
		$user_options = array(
			'artdirect',
			'custommedia',
			'blur-up',
			'noscript',
			'parent-fit',
		);

		foreach ( $user_options as $plugin => $value ) {
			// Set values from the admin
			self::$plugins[ $plugin ] = rwp_get_option( "modules.lazysizes.$value", false );
		}

		self::$plugins['artdirect'] = rwp_get_option( 'modules.lazysizes.artdirect', false );

		$lazysizes_deps = array();

		$version = self::$version;

		foreach ( self::$plugins as $plugin => $include ) {
			if ( $include ) {
				rwp()->add_script( "lazysizes-$plugin", 'lazysizes', array(
					'src'      => "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/$version/plugins/$plugin/ls.$plugin.min.js",
					'version'  => $version,
					'footer'   => true,
				) );
				$lazysizes_deps[] = "rwp-lazysizes-$plugin";
			}
		}

		rwp()->add_script( 'lazysizes', 'lazysizes', array(
			'src'      => "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/$version/lazysizes.min.js",
			'version'  => $version,
			'footer'   => true,
			'deps'     => $lazysizes_deps,
		) );
	}

	/**
	 * Update default image sizes
	 *
	 * @return void
	 */
	public function update_image_sizes() {
		$thumbnail_size = get_option( 'thumbnail_size_w' );
		if ( 120 !== $thumbnail_size ) {
			update_option( 'thumbnail_size_w', 120 );
			update_option( 'thumbnail_size_h', 120 );
			update_option( 'thumbnail_crop', true );
		}

		if ( ! has_image_size( 'post-thumbnail' ) ) {
			set_post_thumbnail_size( 720, 480, false );
		}

		$medium_size = get_option( 'medium_size_w' );
		if ( 480 !== $medium_size ) {
			update_option( 'medium_size_w', 480 );
			update_option( 'medium_size_h', 360 );
			update_option( 'medium_crop', false );
		}

		$medium_large_size = get_option( 'medium_large_size_w' );
		if ( 1024 !== $medium_large_size ) {
			update_option( 'medium_large_size_w', 1024 );
			update_option( 'medium_large_size_h', 768 );
			update_option( 'medium_large_crop', false );
		}

		$large_size = get_option( 'large_size_w' );
		if ( 1280 !== $large_size ) {
			update_option( 'large_size_w', 1280 );
			update_option( 'large_size_h', 960 );
			update_option( 'large_crop', false );
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
			$args = array(
				'html'  => $html,
				'id'    => intval( $attachment_id ),
				'size'  => $size,
				'image' => array(
					'atts' => $attr,
				),
			);
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
			if ( ! rwp_image_has_dimensions( $width, $height ) ) {
				$file       = wp_get_original_image_path( $attachment_id );
				$dimensions = rwp_get_svg_dimensions( $file );
				$width      = data_get( $dimensions, 'width', 0 );
				$height     = data_get( $dimensions, 'height', 0 );
				if ( rwp_image_has_dimensions( $width, $height ) ) {
					$image_meta['width'] = $width;
					$image_meta['height'] = $height;
				}
			}
			$image_meta['sizes'] = [];
		}
		return $image_meta;
	}
}
