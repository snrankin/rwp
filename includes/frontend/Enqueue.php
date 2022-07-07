<?php
/** ============================================================================
 * Enqueue stuff on the frontend
 *
 * @package   RWP\/includes/frontend/Enqueue.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Frontend;

use RWP\Engine\Abstracts\Singleton;

class Enqueue extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		\add_action( 'wp_head', array( $this, 'replace_no_script' ) );

		// Load public-facing style sheet and JavaScript.
		\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );
	}

	public function replace_no_script() {
		echo "<script id=\"rwp-replace-no-script\">document.documentElement.className = document.documentElement.className.replace(/(\s*)(\bno-js\b)(\s*)/gm, `$1js$3`);</script>";
	}


	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 0.9.0
	 * @return void
	 */
	public function enqueue_public_assets() {
		rwp()->add_assets( 'public' );
	}

	public function debug_plugin_js() {
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			echo '<script> console.log(rwp); rwp.logCustomProperties(); </script>';
        }
	}

}
