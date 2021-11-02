<?php

/** ============================================================================
 * Icon
 *
 * @package   RWP\/includes/components/Icon.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Components\Str;

class Icon extends Element {
	/**
	 * @var string
	 */
	public $tag = 'i';

	/**
	 * The array of default attributes
	 * @var array
	 */
	public $atts = array(
		'aria-hidden' => 'true',
		'role'        => 'presentation',
		'class'       => array(
			'rwp-icon',
		),
	);

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		if ( is_string( $args ) ) {
			if ( rwp_str_is_element( $args, 'svg' ) ) {
				$args = new SVG( $args );
			} else if ( ( is_file( $args ) && rwp_file_exists( $args ) ) || rwp_is_url( $args ) ) {
				if ( rwp_str_ends_with( $args, 'svg' ) ) {
					if ( rwp_is_url( $args ) && ! rwp_is_outbound_link( $args ) && rwp_str_has( $args, 'wp-content' ) ) {
						$dir = rwp_filesystem()->wp_content_dir();
						$args = Str::after( $args, 'wp-content/' );
						$args = $dir . DIRECTORY_SEPARATOR . $args;
					}
					$args = new SVG( array( 'src' => $args ) );
					$args->build();
					$args = $args->toArray();
				} else if ( rwp_str_ends_with( $args, array( 'jpg', 'jpeg', 'png', 'gif', 'ico' ) ) ) {
					$args = new Image( array( 'src' => $args ) );
					$args->build();
					$args = $args->image->toArray();
				}
			} else {
				/**
				 * Assuming the arguments are class names (ex: fas fa-facebook)
				 */
				$args = array(
					'atts' => array(
						'class' => rwp_parse_classes( $args ),
					),
				);
			}
		} elseif ( rwp_array_has( 'src', $args ) ) {

			$src = $args['src'];

			if ( ( is_file( $src ) && rwp_file_exists( $src ) ) || rwp_is_url( $src ) ) {
				if ( rwp_str_ends_with( $src, 'svg' ) ) {
					if ( rwp_is_url( $src ) && ! rwp_is_outbound_link( $src ) && rwp_str_has( $src, 'wp-content' ) ) {
						$dir = rwp_filesystem()->wp_content_dir();
						$src = Str::after( $src, 'wp-content/' );
						$src = $dir . DIRECTORY_SEPARATOR . $src;
					}
					$args['src'] = $src;
					$args = new SVG( $args );
					$args->build();
					$args = $args->toArray();
				} else if ( rwp_str_ends_with( $src, array( 'jpg', 'jpeg', 'png', 'gif', 'ico' ) ) ) {
					$args['src'] = $src;
					$args = new Image( $args );
					$args->build();
					$args = $args->image->toArray();
				}
			}
		}

		parent::__construct( $args );
	}
}
