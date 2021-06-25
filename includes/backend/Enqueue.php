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

use RWP\Engine\Base;

class Enqueue extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Load admin style sheet and JavaScript.
		\add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		\add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}


	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_styles() {
		$admin_page = \get_current_screen();

		if ( ! \is_null( $admin_page ) && 'toplevel_page_rwp_options' === $admin_page->id ) {
			$this->register_styles( 'settings' );
			$this->enqueue_styles( 'settings' );
		}

		$this->register_styles( 'admin' );
		$this->enqueue_styles( 'admin' );

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts() {
		$admin_page = \get_current_screen();

		if ( ! \is_null( $admin_page ) && 'toplevel_page_rwp_options' === $admin_page->id ) {
			$this->register_scripts( 'settings' );
			$this->enqueue_scripts( 'settings' );
		}
		$this->register_scripts( 'admin' );
		$this->enqueue_scripts( 'admin' );

	}
}
