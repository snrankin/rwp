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
use RWP\Components\Collection;
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
	);

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		$src = '';
		$html = '';
		$class = '';

		if ( is_numeric( $args ) && intval( $args ) !== 0 ) {
			$src = wp_get_attachment_image_url( $args, 'thumbnail', true );
		}

		if ( is_string( $args ) ) {

			if ( rwp_is_url( $args ) ) {
				if ( rwp_str_has( $args, 'wp-content' ) ) {
					$src = attachment_url_to_postid( $args );
					if ( is_numeric( $args ) && intval( $args ) !== 0 ) {
						$src = wp_get_attachment_image_url( $src, 'thumbnail', true );
					} else {
						$src = $args;
					}
				}
			} else if ( rwp_str_is_element( $args, 'svg' ) ) {
				$this->set_tag( 'svg' );
				$html = $args;
			} else if ( ! rwp_str_is_html( $args ) && ! rwp_is_url( $args ) ) {
				/**
				 * Assuming the arguments are class names (ex: fas fa-facebook)
				 */
				$class = rwp_parse_classes( $args );
			}

			$args = array(
				'src'  => $src,
				'html' => $html,
				'atts' => array(
					'class' => $class,
				),
			);
		} else if ( is_object( $args ) ) {
			if ( $args instanceof Html ) {
				$args = $args->__toString();
				$html = rwp_element( $args );
				$html->build();
				$args = $html->toArray();

			} elseif ( $args instanceof Element || $args instanceof Collection ) {
				$args = rwp_object_to_array( $args );
			}
		}

		if ( ! empty( $src ) ) {
			if ( rwp_is_url( $src ) ) {
				$src = wp_parse_url( $src, 6 );
				if ( rwp_str_ends_with( $src, 'svg' ) ) {
					if ( rwp_str_has( $src, 'wp-content' ) ) {
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
