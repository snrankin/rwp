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

		if ( is_string( $args ) && ! rwp_string_is_html( $args ) ) {
			/**
			 * Assuming the arguments are class names (ex: fas fa-facebook)
			 */
			$args = array(
				'atts' => array(
					'class' => rwp_parse_classes( $args ),
				),
			);
        }

		parent::__construct( $args );
	}
}
