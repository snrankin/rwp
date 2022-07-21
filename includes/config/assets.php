<?php

/**
 * ============================================================================
 * assets
 *
 * @package   RWP\/config/assets.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ==========================================================================
 */


$rwp_plugin_assets = [
	'dir'           => RWP_PLUGIN_ROOT . 'assets/',
	'uri'           => RWP_PLUGIN_URI . 'assets/',
	'manifest_path' => RWP_PLUGIN_ROOT . 'assets/manifest.json',
	'scripts'       => [
		'app'       => [
			'handle'   => 'app',
			'deps'     => [ 'jquery' ],
			'location' => 'public',
			'footer'   => true,
		],
		'public'    => [
			'handle'   => 'public',
			'deps'     => [ 'jquery', 'rwp-app' ],
			'location' => 'public',
			'footer'   => true,
		],
		'bootstrap' => [
			'handle'   => 'bootstrap',
			'location' => 'bootstrap',
			'deps'     => [ 'jquery' ],
			'footer'   => true,
		],
		'modernizr' => [
			'handle'   => 'modernizr',
			'location' => 'public',
			'footer'   => true,
		],
		'select2'   => [
			'handle'   => 'select2',
			'location' => 'select2',
			'deps'     => [ 'jquery' ],
			'footer'   => true,
		],
		'slider'    => [
			'handle'   => 'slider',
			'location' => 'slider',
			'deps'     => [ 'jquery', 'rwp-app' ],
			'footer'   => true,
		],
		'modal'     => [
			'handle'   => 'modal',
			'location' => 'modal',
			'deps'     => [ 'jquery', 'rwp-app' ],
			'footer'   => true,
		],
	],
	'styles'        => [

		'bootstrap'       => [
			'handle'   => 'bootstrap',
			'location' => 'bootstrap',
		],
		'public'          => [
			'handle'   => 'public',
			'location' => 'public',
		],
		'admin'           => [
			'handle'   => 'admin',
			'location' => 'admin',
		],
		'acf'             => [
			'handle'   => 'acf',
			'location' => 'acf',
		],
		'select2'         => [
			'handle'   => 'select2',
			'location' => 'select2',
		],
		'gravity-forms'   => [
			'handle'   => 'gravity-forms',
			'location' => 'gravity-forms',
		],
		'font-awesome'    => [
			'handle'   => 'font-awesome',
			'location' => 'font-awesome',
		],
		'elementor'       => [
			'handle'   => 'elementor',
			'location' => 'elementor',
		],
		'bootstrap-icons' => [
			'handle'   => 'bootstrap-icons',
			'location' => 'bootstrap-icons',
		],
		'slider'          => [
			'handle'   => 'slider',
			'location' => 'slider',
		],
		'modal'           => [
			'handle'   => 'modal',
			'location' => 'modal',
		],
	],
];

if ( ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) || is_plugin_active( 'query-monitor/query-monitor.php' ) ) {
	$rwp_plugin_assets['scripts']['debug'] = array(
		'location' => 'global',
		'handle'   => 'debug',
		'deps'     => [ 'jquery' ],
		'footer'   => false,
	);
	$rwp_plugin_assets['styles']['debug'] = array(
		'location' => 'global',
		'handle'   => 'debug',
	);
	$rwp_plugin_assets['styles']['debug_font'] = array(
		'location' => 'global',
		'src'      => 'https://cdn.jsdelivr.net/npm/firacode@6.2.0/distr/fira_code.css',
		'handle'   => 'debug-font',
	);
}

if ( rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {

	$rwp_lazysizes_version = '5.3.2';
	$rwp_lazysizes_plugins = array(
		'artdirect'   => rwp_get_option( 'modules.lazysizes.artdirect', false ),
		'custommedia' => rwp_get_option( 'modules.lazysizes.custommedia', false ),
		'blur-up'     => rwp_get_option( 'modules.lazysizes.blurup', false ),
	);

	$rwp_lazysizes_deps = array();

	$rwp_lazysizes_url = 'https://cdn.jsdelivr.net/combine/';

	foreach ( $rwp_lazysizes_plugins as $plugin => $include ) {

		if ( $include ) {
			$prefix = 'npm/lazysizes@5';
			$name = '';
			$name = "$prefix/plugins/$plugin/ls.$plugin";
			if ( defined( 'COMPRESS_CSS' ) && \COMPRESS_CSS ) {
				$name .= '.min';
			}
			$name .= '.js';
			$rwp_lazysizes_deps[] = $name;
		}
	}

	$rwp_lazysizes_url .= join( ',', $rwp_lazysizes_deps );


	$rwp_plugin_assets['scripts']['lazysizes'] = array(

		'location' => 'lazysizes',
		'footer'   => true,
		'handle'   => 'lazysizes',
	);

	if ( ! empty( $rwp_lazysizes_deps ) ) {
		$rwp_plugin_assets['scripts']['lazysizes_addons'] = array(
			'src'      => $rwp_lazysizes_url,
			'version'  => $rwp_lazysizes_version,
			'location' => 'lazysizes',
			'footer'   => true,
			'handle'   => 'lazysizes-addons',
			'deps'     => [ 'rwp-lazysizes' ],
		);
	}
}

$rwp_webpack_config = rwp_get_file_data( RWP_PLUGIN_ROOT . 'config.json', true );

if ( $rwp_webpack_config ) {
	$rwp_webpack_config = rwp_object_to_array( $rwp_webpack_config );
	$rwp_plugin_assets  = array_merge( $rwp_plugin_assets, $rwp_webpack_config );
}

return $rwp_plugin_assets;