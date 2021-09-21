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
	  * @param string $group
	  * @param string $class_prefix
	  * @param string $class_suffix
	  * @param string $label_prefix
	  * @param string $label_suffix
	  * @return mixed
	  */
	public static function bs_atts( $group = '', $class_prefix = '', $class_suffix = '', $label_prefix = '', $label_suffix = '' ) {
		$atts = array(
			'colors' => array(
				'primary'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Primary', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('primary', $class_suffix), $class_prefix),
				),
				'secondary'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Secondary', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('secondary', $class_suffix), $class_prefix),
				),
				'tertiary'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Tertiary', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('tertiary', $class_suffix), $class_prefix),
				),
				'info'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Info', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('info', $class_suffix), $class_prefix),
				),
				'success'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Success', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('success', $class_suffix), $class_prefix),
				),
				'warning'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Warning', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('warning', $class_suffix), $class_prefix),
				),
				'danger'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Danger', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('danger', $class_suffix), $class_prefix),
				),
				'light'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Light', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('light', $class_suffix), $class_prefix),
				),
				'dark'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Dark', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('dark', $class_suffix), $class_prefix),
				),
				// 'blue'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Blue', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('blue', $class_suffix), $class_prefix),
				// ),
				// 'indigo'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Indigo', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('indigo', $class_suffix), $class_prefix),
				// ),
				// 'purple'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Purple', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('purple', $class_suffix), $class_prefix),
				// ),
				// 'pink'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Pink', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('pink', $class_suffix), $class_prefix),
				// ),
				// 'red'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Red', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('red', $class_suffix), $class_prefix),
				// ),
				// 'orange'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Orange', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('orange', $class_suffix), $class_prefix),
				// ),
				// 'yellow'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Yellow', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('yellow', $class_suffix), $class_prefix),
				// ),
				// 'green'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Green', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('green', $class_suffix), $class_prefix),
				// ),
				// 'teal'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Teal', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('teal', $class_suffix), $class_prefix),
				// ),
				// 'cyan'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Cyan', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('cyan', $class_suffix), $class_prefix),
				// ),
				'white'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('White', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('white', $class_suffix), $class_prefix),
				),
				'black'=> array(
					'label' => rwp_add_prefix(rwp_add_suffix('Black', $label_suffix), $label_prefix),
					'value' => rwp_add_prefix(rwp_add_suffix('black', $class_suffix), $class_prefix),
				),
				// 'gray-100'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 100', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-100', $class_suffix), $class_prefix),
				// ),
				// 'gray-200'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 200', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-200', $class_suffix), $class_prefix),
				// ),
				// 'gray-300'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 300', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-300', $class_suffix), $class_prefix),
				// ),
				// 'gray-400'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 400', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-400', $class_suffix), $class_prefix),
				// ),
				// 'gray-500'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 500', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-500', $class_suffix), $class_prefix),
				// ),
				// 'gray-600'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 600', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-600', $class_suffix), $class_prefix),
				// ),
				// 'gray-700'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 700', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-700', $class_suffix), $class_prefix),
				// ),
				// 'gray-800'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 800', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-800', $class_suffix), $class_prefix),
				// ),
				// 'gray-900'=> array(
				// 	'label' => rwp_add_prefix(rwp_add_suffix('Gray 900', $label_suffix), $label_prefix),
				// 	'value' => rwp_add_prefix(rwp_add_suffix('gray-900', $class_suffix), $class_prefix),
				// ),
			),
			'breakpoints' => array(
				'sm' => array(
					'label' => 'Devices from 576px to 768px',
					'value' => 576,
					'class' => rwp_add_prefix(rwp_add_suffix('sm', $class_suffix), $class_prefix),
				),
				'md' => array(
					'label' => 'Devices from 768px to 992px',
					'value' => 768,
					'class' => rwp_add_prefix(rwp_add_suffix('md', $class_suffix), $class_prefix),
				),
				'lg' => array(
					'label' => 'Devices from 992px to 1200px',
					'value' => 992,
					'class' => rwp_add_prefix(rwp_add_suffix('lg', $class_suffix), $class_prefix),
				),
				'xl' => array(
					'label' => 'Devices from 1200px to 1400px',
					'value' => 1200,
					'class' => rwp_add_prefix(rwp_add_suffix('xl', $class_suffix), $class_prefix),
				),
				'xxl' => array(
					'label' => 'Devices from 1400px',
					'value' => 1400,
					'class' => rwp_add_prefix(rwp_add_suffix('xxl', $class_suffix), $class_prefix),
				),
			),
		);

		if ( ! empty( $group ) ) {
			return data_get( $atts, $group );
		} else {
			return $atts;
		}
	}
}
