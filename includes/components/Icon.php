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

		if ( is_string( $args ) ) {
			if ( rwp_is_element( $args, 'svg' ) ) {
				$this->set_content( $args );
				$this->add_class( 'svg-icon' );
				$this->set_tag( 'span' );
			} else if ( is_file( $args ) && rwp_file_exists( $args ) ) {
				if ( rwp_str_ends_with( $args, 'svg' ) ) {
					$icon = new SVG( array( 'src' => $args ) );
					$this->set_content( $icon->html() );
					$this->add_class( 'svg-icon' );
				} else if ( rwp_str_ends_with( $args, array( 'jpg', 'jpeg', 'png', 'gif', 'ico' ) ) ) {
					$icon = new Image( array( 'src' => $args ) );
					$this->set_content( $icon );
					$this->add_class( 'img-icon' );
				}

				$this->set_tag( 'span' );
				$args = array();
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

			if ( rwp_str_ends_with( $args['src'], 'svg' ) ) {
				$icon = new SVG( $args );
				$this->set_content( $icon->html() );
				$this->add_class( 'svg-icon' );
			} else if ( rwp_str_ends_with( $args['src'], array( 'jpg', 'jpeg', 'png', 'gif', 'ico' ) ) ) {
				$icon = new Image( $args );
				$this->set_content( $icon );
				$this->add_class( 'img-icon' );
			}

			$this->set_tag( 'span' );
		}

		parent::__construct( $args );
	}
}
