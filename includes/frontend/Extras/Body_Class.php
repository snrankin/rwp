<?php
/** ============================================================================
 * Add custom css class to <body>
 *
 * @package   RWP\Frontend\Extras
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Frontend\Extras;

use RWP\Engine\Base;

class Body_Class extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		\add_filter( 'body_class', array( self::class, 'add_rwp_class' ), 10, 3 );
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param array $classes The array with all the classes of the page.
	 * @since 1.0.0
	 * @return array
	 */
	public static function add_rwp_class( array $classes ) {
		$classes[] = RWP_PLUGIN_TEXTDOMAIN;

		return $classes;
	}

}
