<?php

/** ============================================================================
 * RWP plugins
 *
 * @package RWP\/includes/core/Modules/plugins.php
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Modules\Plugins;

if (!defined('ABSPATH')) {
	die();
}


if (!get_theme_support('rwp-plugins')) {
	return;
}
$options = get_theme_support('rwp-plugins')[0];

if (in_array('fancybox', $options)) {
	function enqueue_fancybox() {

		if (!wp_style_is('rwp-fancybox', 'registered')) {
			rwp()->register_styles('fancybox');
		}

		if (!wp_script_is('rwp-fancybox', 'registered')) {
			rwp()->register_scripts('fancybox');
		}

		rwp()->enqueue_assets('fancybox');
	}
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_fancybox');
}

if (in_array('select2', $options)) {
	function enqueue_select2() {
		if (!wp_script_is('select2', 'registered')) {
			$js = rwp_plugin_asset_uri('select2.js', 'js');
			$path = rwp_plugin_asset_dir('select2.js', 'js');
			$ver = null;
			if ($path) {
				$ver = strval(filemtime($path));
			}

			wp_register_script('select2', $js, array('jquery'), $ver, true);
		}

		if (!wp_script_is('select2', 'enqueued')) {
			wp_enqueue_script('select2');
		}

		if (!wp_style_is('select2', 'registered')) {
			$css = rwp_plugin_asset_uri('select2.css', 'css');
			$path = rwp_plugin_asset_dir('select2.css', 'css');
			$ver = null;
			if ($path) {
				$ver = strval(filemtime($path));
			}

			wp_register_style('select2', $css, array(), $ver, 'all');
		}
		if (!wp_style_is('select2', 'enqueued')) {
			wp_enqueue_style('select2');
		}
	}
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_select2');
}

if (in_array('tiny-slider', $options)) {
	function enqueue_tiny_slider() {
		if (!wp_style_is('rwp-tiny-slider', 'registered')) {
			rwp()->register_styles('tiny-slider');
		}

		if (!wp_script_is('rwp-tiny-slider', 'registered')) {
			rwp()->register_scripts('tiny-slider');
		}

		rwp()->enqueue_assets('tiny-slider');
	}
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_tiny_slider');
}

if (in_array('font-awesome', $options)) {
	function enqueue_font_awesome() {

		if (!wp_style_is('font-awesome', 'registered')) {
			$css = rwp_plugin_asset_uri('font-awesome.css', 'css');
			$path = rwp_plugin_asset_dir('font-awesome.css', 'css');
			$ver = null;
			if ($path) {
				$ver = strval(filemtime($path));
			}

			wp_register_style('font-awesome', $css, array(), $ver, 'all');
		}
		if (!wp_style_is('font-awesome', 'enqueued')) {
			wp_enqueue_style('font-awesome');
		}
	}
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_font_awesome');
	add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_font_awesome');
	add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_font_awesome');
}

if (in_array('bootstrap-icons', $options)) {
	function enqueue_bootstrap_icons() {
		if (!wp_style_is('rwp-bootstrap-icons', 'registered')) {
			rwp()->register_styles('bootstrap-icons');
		}

		rwp()->enqueue_styles('bootstrap-icons');
	}
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_bootstrap_icons');
	add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_bootstrap_icons');
	add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_bootstrap_icons');
}
