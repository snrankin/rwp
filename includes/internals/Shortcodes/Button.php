<?php
/** ============================================================================
 * Button
 *
 * @package   RWP\Internals\Shortcodes
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals\Shortcodes;

use RWP\Engine\Abstracts\Shortcode;


class Button extends Shortcode {

	public $defaults = array(
		'link'  => '',
		'text'  => '',
		'icon'  => '',
		'id'    => '',
		'class' => '',
	);

	/**
	 * Easily add copyright info with an auto-updating year
	 *
	 * @param array $atts
	 * @return string
	 */

	public function output( $atts ) {

        $atts = rwp_process_shortcode( $atts, $this->defaults );

		return rwp_button( $atts );
    }

}
