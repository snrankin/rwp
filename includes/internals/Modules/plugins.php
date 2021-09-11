<?php

/** ============================================================================
 * RWP plugins
 *
 * @package RWP\/includes/core/Modules/plugins.php
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Internals\Modules\Plugins;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}
$rwp_js_plugins = rwp_get_option( 'modules.js_plugins', array() );
$rwp_icon_fonts = rwp_get_option( 'modules.icon_fonts', array() );

function enqueue_fancybox() {
	if ( ! wp_style_is( 'rwp-modal', 'registered' ) ) {
		rwp()->register_styles( 'modal' );
	}

	if ( ! wp_script_is( 'rwp-modal', 'registered' ) ) {
		rwp()->register_scripts( 'modal' );
	}

	rwp()->enqueue_assets( 'modal' );
}
if ( in_array( 'Fancybox', $rwp_js_plugins ) ) {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_fancybox' );
}
function enqueue_select2() {
	if ( ! wp_style_is( 'rwp-select2', 'registered' ) ) {
		rwp()->register_styles( 'select2' );
	}

	if ( ! wp_script_is( 'rwp-select2', 'registered' ) ) {
		rwp()->register_scripts( 'select2' );
	}

	rwp()->enqueue_assets( 'select2' );
}

if ( in_array( 'Select2', $rwp_js_plugins ) ) {

	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_select2' );
}

function enqueue_tiny_slider() {
	if ( ! wp_style_is( 'rwp-slider', 'registered' ) ) {
		rwp()->register_styles( 'slider' );
	}

	if ( ! wp_script_is( 'rwp-slider', 'registered' ) ) {
		rwp()->register_scripts( 'slider' );
	}

	rwp()->enqueue_assets( 'slider' );
}

if ( in_array( 'Tiny Slider', $rwp_js_plugins ) ) {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_tiny_slider' );
}

function enqueue_font_awesome() {
	if ( ! wp_style_is( 'font-awesome', 'registered' ) ) {
		if ( ! wp_style_is( 'rwp-font-awesome', 'registered' ) ) {
			rwp()->register_styles( 'font-awesome' );
		}
	}
	if ( ! wp_style_is( 'font-awesome', 'enqueued' ) ) {
		rwp()->enqueue_styles( 'font-awesome' );
	}
}

if ( in_array( 'font-awesome', $rwp_icon_fonts ) ) {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_font_awesome' );
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_font_awesome' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_font_awesome' );
}

function enqueue_bootstrap_icons() {
	if ( ! wp_style_is( 'rwp-bootstrap-icons', 'registered' ) ) {
		rwp()->register_styles( 'bootstrap-icons' );
	}

	rwp()->enqueue_styles( 'bootstrap-icons' );
}

if ( in_array( 'Bootstrap Icons', $rwp_icon_fonts ) ) {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_bootstrap_icons' );
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_bootstrap_icons' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_bootstrap_icons' );
}
