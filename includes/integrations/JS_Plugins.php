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
use RWP\Components\Collection;
class JS_Plugins extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		/**
		 * @var Collection $rwp_js_plugins
		 */
		$rwp_js_plugins = rwp_get_option( 'modules.js_plugins', rwp_collection() );

		/**
		 * @var Collection $rwp_icon_fonts
		 */
		$rwp_icon_fonts = rwp_get_option( 'modules.icon_fonts', rwp_collection() );

		if ( $rwp_js_plugins->search( 'Fancybox' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fancybox' ) );
		}

		if ( $rwp_js_plugins->search( 'Select2' ) ) {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_select2' ) );
		}

		if ( $rwp_js_plugins->search( 'Tiny Slider' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_tiny_slider' ) );
		}

		if ( $rwp_icon_fonts->search( 'Font Awesome' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_font_awesome' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_font_awesome' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_font_awesome' ) );
		}

		if ( $rwp_icon_fonts->search( 'Bootstrap Icons' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_bootstrap_icons' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_bootstrap_icons' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_bootstrap_icons' ) );
		}

		if ( rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_lazysizes' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_lazysizes' ) );
		}
	}

	/**
	 * Register/enqueue Select2
	 *
	 * @link https://select2.org/
	 *
	 * @return void
	 */
	public function enqueue_select2() {
		rwp()->add_assets( 'select2' );
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
		rwp()->add_assets( 'lazysizes' );
	}
}
