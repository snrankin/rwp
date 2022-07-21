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

use RWP\Base\Singleton;

/**
 * AJAX in the public
 */
class Ajax extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! \apply_filters( 'rwp_ajax_initialize', true ) ) {
			return;
		}

		// For not logged user
		\add_action( 'wp_ajax_nopriv_your_method', array( $this, 'your_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @since 0.9.0
	 * @return void
	 */
	public function your_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 1,
		);

		\wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}
}
