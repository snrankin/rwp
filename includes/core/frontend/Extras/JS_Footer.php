<?php

/** ============================================================================
 * JS_Footer
 *
 * Moves all scripts to wp_footer action
 *
 * @package   RWP\Frontend\Extras
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Frontend\Extras;

use RWP\Base\Singleton;

class JS_Footer extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( \is_admin() || ! \rwp_get_option( 'modules.enable_js_to_footer', false ) ) {
			return;
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'js_to_footer' ) );
	}

	/**
	 * Moves all scripts to wp_footer action
	 *
	 * @since 0.9.0
	 * @return void
	 */
	public function js_to_footer() {
		remove_action( 'wp_head', 'wp_print_scripts' );
		remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
		remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	}
}
