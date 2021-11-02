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
		'location'  => '',
		'items'     => 'address,phone,email,schedule',
		'labels'    => '',
		'id'        => '',
		'class'     => '',
		'add_label' => false,
		'combine'   => false,
	);

	/**
	 * Shortcut output
	 *
	 * @param array $atts
	 * @return string
	 */

	public function output( $atts ) {
		$output  = '';
		$args = rwp_process_shortcode( $atts, $this->defaults );

		$location = data_get( $args, 'location' );
		$items = data_get( $args, 'items' );

		if ( ! empty( $items ) ) {
			$items = explode( ',', $items );
			$args['order'] = $items;
		}
		unset( $args ['items'] );

		$labels = data_get( $args, 'labels' );

		if ( ! empty( $labels ) ) {
			$labels = explode( ',', $labels );
			$args['schedule']['order'] = $labels;
		}
		unset( $args ['labels'] );

		$add_label = data_get( $args, 'add_label' );

		if ( ! empty( $add_label ) ) {
			$args['schedule']['add_label'] = $add_label;
		}
		unset( $args ['add_label'] );

		$combine = data_get( $args, 'combine' );

		if ( ! empty( $combine ) ) {
			$args['schedule']['combine'] = $combine;
		}
		unset( $args ['combine'] );

		if ( ! empty( $location ) ) {
			$location = rwp_location( $location, $args );
			$location = $location->html();
			$output  = $location;
		}

		return $output;
	}
}
