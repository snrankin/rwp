<?php
/** ============================================================================
 * Enqueue stuff on the frontend
 *
 * @package   RWP\/includes/frontend/Enqueue.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Frontend;

use RWP\Engine\Base;

class Enqueue extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		\add_action( 'wp_head', array( $this, 'replace_no_script' ) );

		// Load public-facing style sheet and JavaScript.
		\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
		\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
	}

	public function replace_no_script() {
		echo "<script id=\"rwp-replace-no-script\">document.documentElement.className = document.documentElement.className.replace(/(\s*)(\bno-js\b)(\s*)/gm, `$1js$3`);</script>";
	}


	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_public_styles() {
		$this->register_styles( 'public' );
		$this->enqueue_styles( 'public' );
	}


	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_public_scripts() {
		$this->register_scripts( 'public' );
		$this->enqueue_scripts( 'public' );
	}

}
