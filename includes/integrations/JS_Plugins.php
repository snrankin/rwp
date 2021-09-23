<?php
/** ============================================================================
 * JS_Plugins
 *
 * Registers/enqueues various javascript plugins included with the plugin
 *
 * @package   RWP\Internals\JS_Plugins
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;

class JS_Plugins extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		$rwp_js_plugins = rwp_get_option( 'modules.js_plugins', array() );
		$rwp_icon_fonts = rwp_get_option( 'modules.icon_fonts', array() );

		if ( preg_grep( '/fancybox/i', $rwp_js_plugins ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fancybox' ) );
		}

		if ( preg_grep( '/select2/i', $rwp_js_plugins ) ) {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_select2' ) );
		}

		if ( preg_grep( '/tiny(?:\s|\-)slider/i', $rwp_js_plugins ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_tiny_slider' ) );
		}

		if ( preg_grep( '/font(?:\s|\-)awesome/i', $rwp_icon_fonts ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_font_awesome' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_font_awesome' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_font_awesome' ) );
		}

		if ( preg_grep( '/bootstrap(?:\s|\-)icons/i', $rwp_icon_fonts ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_bootstrap_icons' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_bootstrap_icons' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_bootstrap_icons' ) );
		}

		if ( ! rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_lazysizes' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_lazysizes' ) );
		}
	}

	/**
	 * Register/enqueue Fancybox v4
	 *
	 * @link https://fancyapps.com/docs/ui/fancybox/
	 *
	 * @return void
	 */
	public function enqueue_fancybox() {
		rwp()->register_assets( 'modal' );
		rwp()->enqueue_assets( 'modal' );
	}

	/**
	 * Register/enqueue Select2
	 *
	 * @link https://select2.org/
	 *
	 * @return void
	 */
	public function enqueue_select2() {
		rwp()->register_assets( 'select2' );
		rwp()->enqueue_assets( 'select2' );
	}

	/**
	 * Register/enqueue Tiny Slider
	 *
	 * @link https://github.com/ganlanyuan/tiny-slider
	 *
	 * @return void
	 */
	public function enqueue_tiny_slider() {
		rwp()->register_assets( 'slider' );
		rwp()->enqueue_assets( 'slider' );
	}

	/**
	 * Register/enqueue FontAwesome 5 Free
	 *
	 * @link https://fontawesome.com/
	 *
	 * @return void
	 */
	public function enqueue_font_awesome() {
		if ( ! wp_style_is( 'font-awesome', 'registered' ) ) {
			if ( ! wp_style_is( 'rwp-font-awesome', 'registered' ) ) {
				rwp()->register_styles( 'font-awesome' );
			}
		}
		if ( ! wp_style_is( 'font-awesome', 'enqueued' ) ) {
			rwp()->enqueue_styles( 'font-awesome' );
		}
	}

	/**
	 * Register/enqueue Bootstrap Icons
	 *
	 * @link https://icons.getbootstrap.com/
	 *
	 * @return void
	 */
	public function enqueue_bootstrap_icons() {
		if ( ! wp_style_is( 'rwp-bootstrap-icons', 'registered' ) ) {
			rwp()->register_styles( 'bootstrap-icons' );
		}

		if ( ! wp_style_is( 'rwp-bootstrap-icons', 'enqueued' ) ) {
			rwp()->enqueue_styles( 'bootstrap-icons' );
		}
	}

	/**
	 * Register/enqueue Lazysizes
	 *
	 * @link https://github.com/aFarkas/lazysizes
	 * @return void
	 */
	public function enqueue_lazysizes() {
		rwp()->register_assets( 'lazysizes' );
		rwp()->enqueue_assets( 'lazysizes' );
	}


}
