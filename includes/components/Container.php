<?php
/** ============================================================================
 * List
 *
 * @package   RWP\/includes/components/List.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class Container extends Element {

	public $tag = 'div';

	/**
	 *
	 * @var bool|string[] Boolean for fluid container or an array of breakpoints
	 */

	public $fluid = false;

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		parent::__construct( $args );
	}

	public function setup_html() {
		if ( is_array( $this->fluid ) ) {
			foreach ( $this->fluid  as $bp ) {
				$this->add_class( "container-$bp" );
			}
		} else if ( $this->fluid ) {
			$this->add_class( 'container-fluid' );
		} else {
			$this->add_class( 'container' );
		}
	}

}
