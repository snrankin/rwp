<?php
/** ============================================================================
 * Bootstrap
 *
 * Implement Bootstrap v5 into Wordpress
 *
 * @package   RWP\Internals\Bootstrap
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals;

use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Html;
use RWP\Vendor\Exceptions\Collection\KeyNotFoundException;

class Bootstrap extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_assets' ) );
		}
	}


	/**
	 * Registers/enqueues Bootstrap assets if the settings are turned on
	 *
	 * @return void
	 * @throws KeyNotFoundException
	 */

	function bootstrap_assets() {
		if ( rwp_get_option( 'modules.bootstrap.styles', false ) ) {
			rwp()->register_styles( 'bootstrap' );
			rwp()->enqueue_styles( 'bootstrap' );
		}
		if ( rwp_get_option( 'modules.bootstrap.scripts', false ) ) {
			rwp()->register_scripts( 'bootstrap' );
			rwp()->enqueue_scripts( 'bootstrap' );
		}
	}

	/**
	 * Get colors/breakpoints from Bootstrap
	 *
	 * @param string $group
	 * @return array
	 */
	public static function bs_atts( $group = '' ) {
		$atts = array(
			'colors' => array(
				'primary',
				'secondary',
				'tertiary',
				'info',
				'success',
				'warning',
				'danger',
				'light',
				'dark',
				'blue',
				'indigo',
				'purple',
				'pink',
				'red',
				'orange',
				'yellow',
				'green',
				'teal',
				'cyan',
				'white',
				'black',
				'gray-100',
				'gray-200',
				'gray-300',
				'gray-400',
				'gray-500',
				'gray-600',
				'gray-700',
				'gray-800',
				'gray-900',
			),
			'breakpoints' => array(
				'sm' => array(
					'label' => 'Devices from 576px to 768px',
					'value' => '576px',
				),
				'md' => array(
					'label' => 'Devices from 768px to 992px',
					'value' => '768px',
				),
				'lg' => array(
					'label' => 'Devices from 992px to 1200px',
					'value' => '992px',
				),
				'xl' => array(
					'label' => 'Devices from 1200px to 1400px',
					'value' => '1200px',
				),
				'xxl' => array(
					'label' => 'Devices from 1400px',
					'value' => '1400px',
				),
			),
		);

		if ( ! empty( $group ) ) {
			return data_get( $atts, $group, array() );
		} else {
			return $atts;
		}
	}
}
