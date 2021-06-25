<?php
/** ============================================================================
 * assets
 *
 * @package   RWP\/config/assets.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


$rwp_plugin_assets = [
	'dir'  => RWP_PLUGIN_ROOT . 'assets/',
	'uri'  => RWP_PLUGIN_URI . 'assets/',
	'manifest_path' => RWP_PLUGIN_ROOT . 'assets/manifest.json',
    'scripts' => [
        'public' => [
            'handle'   => 'public',
			'src'      => '',
			'deps'     => ['jquery'],
			'ver'      => false,
            'footer'   => true,
            'localize' => false,
			'folder'   => 'js',
            'location' => 'public',
        ],
		'admin' => [
            'handle'   => 'admin',
            'src'      => '',
			'deps'     => ['jquery'],
			'ver'      => false,
            'footer'   => true,
            'localize' => false,
			'folder'   => 'js',
            'location' => 'admin',
        ],
		'settings' => [
            'handle'   => 'settings',
            'src'      => '',
			'deps'     => ['jquery', 'jquery-ui-core', 'jquery-ui-tabs'],
			'ver'      => false,
            'footer'   => true,
            'localize' => false,
			'folder'   => 'js',
            'location' => 'settings',
        ],
    ],

    'styles' => [
        'public' => [
            'handle'   => 'public',
			'src'      => '',
			'deps'     => [],
			'ver'      => false,
            'media'    => 'all',
			'folder'   => 'css',
            'location' => 'public',
        ],
        'admin' => [
            'handle'   => 'admin',
			'src'      => '',
			'deps'     => [],
			'ver'      => false,
            'media'    => 'all',
			'folder'   => 'css',
            'location' => 'admin',
        ],
		'settings' => [
            'handle'   => 'settings',
			'src'      => '',
			'deps'     => [],
			'ver'      => false,
            'media'    => 'all',
			'folder'   => 'css',
            'location' => 'settings',
        ],
    ],
];


$rwp_webpack_config = rwp_get_json_data( RWP_PLUGIN_ROOT . 'config.json', true );

if ( $rwp_webpack_config ) {
	$rwp_webpack_config = rwp_object_to_array( $rwp_webpack_config );
	$rwp_plugin_assets  = array_merge( $rwp_plugin_assets, $rwp_webpack_config );
}

return $rwp_plugin_assets;
