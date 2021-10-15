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

use RWP\Engine\Abstracts\Singleton;

class Body_Class extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		\add_filter( 'body_class', array( $this, 'add_plugin_class' ), 10, 3 );
		\add_filter( 'qm/output/menu_class', array( $this, 'add_plugin_class' ) );
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param array $classes The array with all the classes of the page.
	 * @since 1.0.0
	 * @return array
	 */
	public static function add_plugin_class( array $classes ) {

		$classes = rwp_parse_classes( $classes, rwp()->get_slug() );

		if ( is_plugin_active( 'elementor/elementor.php' ) && rwp_get_option( 'modules.bootstrap.elementor', false ) ) {
			$classes[] = 'rwp-elementor';
		}

		return $classes;
	}
}
