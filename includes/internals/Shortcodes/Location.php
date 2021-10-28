<?php

/** ============================================================================
 * TeamGrid
 *
 * @package   RWP\/includes/internals/Shortcodes/TeamGrid.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\Shortcodes;

use RWP\Engine\Abstracts\Shortcode;

class Location extends Shortcode {

	public $defaults = array(
		'location' => '',
		'items'    => 'address,phone,email',
		'id'       => '',
		'class'    => '',
	);

	/**
	 * Wrap the content in a standard wrapper
	 *
	 * @param string $content
	 * @param array $args
	 * @return \RWP\Components\Row
	 */
	public function wrapper( $content = '', $args = array() ) {

		$classes[] = rwp_change_case( $this->tag );

		$wrapper = array(
			'atts' => array(
				'class' => rwp_parse_classes( $classes ),
			),
		);

		$wrapper = rwp_merge_args( $wrapper, $args );

		$wrapper['content'] = $content;

		return rwp_row( $wrapper );
	}

	/**
	 * Shortcut output
	 *
	 * @param array $atts
	 * @return string
	 */

	public function output( $atts ) {
		$output  = '';
		$atts = rwp_process_shortcode( $atts, $this->defaults );

		$location = data_get( $atts, 'location' );
		$items = data_get( $atts, 'items', 'address,phone,email' );

		$items = explode( ',', $items );

		if ( ! empty( $location ) ) {
			$location = rwp_location( $location );
			$location->order = $items;
			$location = $location->html();
			$output  = $this->wrapper( $location, $atts );
		}

		return $output;
	}
}
