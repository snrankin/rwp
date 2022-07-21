<?php

/** ============================================================================
 * Debug Output
 *
 * @package   RWP\Integrations\QM\Output
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\QM\Output;

class Debug extends Output {

	public $output = array();


	/**
	 * Outputs data in the footer
	 */
	public function output() {
		$output = $this->output;

		$this->before_tabular_output();

		$data = rwp_collection( $output );

		$groups = $data->groupBy( 'file', true );

		$files = $groups->keys()->transform(function ( $file ) {
			return wp_basename( $file );
		})->all();

		$header = $this->build_filter( 'file', $files, esc_html__( 'File', 'rwp' ) );

		$this::$table_header = array(
			esc_html__( 'Variable', 'rwp' ),

			esc_html__( 'Line', 'rwp' ),
			$header,

		);

		if ( is_array( $output ) && ! empty( $output ) ) {
			$this::debug_inner( $output );
		}
		$this->after_tabular_output();
	}

	/**
	 * @param array $class
	 *
	 * @return array
	 */
	public function admin_class( array $class ) {
		$class[] = $this->id;
		return $class;
	}
}
