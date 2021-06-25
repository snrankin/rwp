<?php
/** ============================================================================
 * Shortcodes of this plugin
 *
 * @package   RWP\Internals
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals;

use RWP\Engine\Base;

/**
 * Shortcodes of this plugin
 */
class Shortcode extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		\add_shortcode( 'foobar', array( $this, 'foobar_func' ) );
	}

	/**
	 * Shortcode example
	 *
	 * @param array $atts Parameters.
	 * @since 1.0.0
	 * @return string
	 */
	public static function foobar_func( array $atts ) {
		\shortcode_atts(
			array(
				'foo' => 'something',
				'bar' => 'something else',
			),
			$atts
		);

		return '<span class="foo">foo = ' . $atts[ 'foo' ] . '</span>' .
			'<span class="bar">foo = ' . $atts[ 'bar' ] . '</span>';
	}

}
