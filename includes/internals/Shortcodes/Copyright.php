<?php
/** ============================================================================
 * Copyright
 *
 * @package   RWP\/includes/internals/Shortcodes/Copyright.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals\Shortcodes;

use RWP\Engine\Abstracts\Shortcode;


class Copyright extends Shortcode {

	public $defaults = array(
		'before' => '&copy; Copyright ',
		'after'  => ', All Rights Reserved.',
		'id'     => '',
		'class'  => '',
	);

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		$this->defaults['name'] = get_bloginfo( 'name' );

		parent::initialize();
	}
	/**
	 * Easily add copyright info with an auto-updating year
	 *
	 * @param array $atts
	 * @return string
	 */

	public function output( $atts ) {

        $atts = rwp_process_shortcode( $atts, $this->defaults );

		$content = wp_sprintf( '%s%d %s%s', $atts['before'], gmdate( 'Y' ), $atts['name'], $atts['after'] );

		$copyright = $this->wrapper( $content, $atts )->html();

		return $copyright;
    }

}
