<?php
/** ============================================================================
 * This class contain the Enqueue stuff for the backend
 *
 * @package   RWP\Backend
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Backend;

use RWP\Engine\Abstracts\Singleton;

class Enqueue extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		// Load admin style sheet and JavaScript.
		\add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}


	/**
	 * Register and enqueue admin-specific styles and scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_admin_assets() {
		rwp()->register_assets( 'admin' );
		rwp()->enqueue_assets( 'admin' );

	}
}
