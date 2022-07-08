<?php

/**
 * RWP
 *
 * @package   RWP
 * @author    RIESTER Advertising Agency <wordpress@riester.com>
 * @copyright 2020 RIESTER Advertising Agency
 * @license   GPL 2.0+
 * @link      https://www.riester.com
 */

namespace RWP\Ajax;

use RWP\Engine\Abstracts\Singleton;

/**
 * AJAX as logged user
 */
class Ajax_Admin extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! \apply_filters( 'rwp_ajax_admin_initialize', true ) ) {
			return;
		}

		// For logged user
		\add_action( 'wp_ajax_your_admin_method', array( $this, 'your_admin_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @since 0.9.0
	 * @return void
	 */
	public function your_admin_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 2,
		);

		\wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}

}
