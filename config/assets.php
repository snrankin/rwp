<?php
/**
 * ============================================================================
 * assets
 *
 * @package   RWP\/config/assets.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ==========================================================================
 */


$rwp_plugin_assets = [
    'dir'  => RWP_PLUGIN_ROOT . 'assets/',
    'uri'  => RWP_PLUGIN_URI . 'assets/',
    'manifest_path' => RWP_PLUGIN_ROOT . 'assets/manifest.json',
    'scripts' => [
        'app' => [
            'handle'   => 'app',
            'deps'     => ['jquery', 'lodash'],
            'location' => 'global',
            'footer'   => true,
        ],
        'public' => [
            'handle'   => 'public',
            'deps'     => ['jquery', 'rwp-app'],
            'location' => 'public',
        	'footer'   => true,
        ],
        'modernizr' => [
            'handle'   => 'modernizr',
            'location' => 'modernizr',
        	'footer'   => true,
        ],
        'admin' => [
            'handle'   => 'admin',
            'deps'     => ['jquery', 'rwp-app'],
            'location' => 'admin',
        	'footer'   => true,
        ],
        // 'acf' => [
        //     'handle'   => 'acf',
        // 	'deps'     => ['jquery', 'rwp-app'],
        //     'location' => 'acf',
        // 	'footer'   => true,
        // ],
        'modal' => [
            'handle'   => 'modal',
            'deps'     => ['rwp-app'],
            'location' => 'modal',
            'footer'   => true,
        ],
        'select2' => [
            'handle'   => 'select2',
            'location' => 'select2',
            'footer'   => true,
        ],
        'slider' => [
            'handle'   => 'slider',
            'deps'     => ['rwp-app'],
            'location' => 'slider',
            'footer'   => true,
        ],
    ],
    'styles' => [
        'public' => [
            'handle'   => 'public',
            'location' => 'public',
        ],
        'bootstrap' => [
            'handle'   => 'bootstrap',
            'location' => 'bootstrap',
        ],
		'wordpress' => [
            'handle'   => 'wordpress',
            'location' => 'global',
        ],
        'admin' => [
            'handle'   => 'admin',
            'location' => 'admin',
        ],
        'acf' => [
            'handle'   => 'acf',
            'location' => 'acf',
        ],
        'modal' => [
            'handle'   => 'modal',
            'location' => 'modal',
        ],
        'select2' => [
            'handle'   => 'select2',
            'location' => 'select2',
        ],
        'slider' => [
            'handle'   => 'slider',
            'location' => 'slider',
        ],
        'gravity-forms' => [
            'handle'   => 'gravity-forms',
            'location' => 'gravity-forms',
        ],
        'font-awesome' => [
            'handle'   => 'font-awesome',
            'location' => 'font-awesome',
        ],
        'bootstrap-icons' => [
            'handle'   => 'bootstrap-icons',
            'location' => 'bootstrap-icons',
        ],
    ],
];

if((defined('WP_DEBUG') && true === WP_DEBUG) || is_plugin_active( 'query-monitor/query-monitor.php' ) ){
	$rwp_plugin_assets['scripts'][ 'debug'] = array(
		'location' => 'public',
		'footer'   => true,
		'handle'   => 'debug'
	);
	$rwp_plugin_assets['styles'][ 'debug'] = array(
		'location' => 'public',
		'handle'   => 'debug'
    );
}


if (rwp_get_option('modules.lazysizes.lazyload', false) ) {
    $rwp_lazysizes_version = '5.3.2';
    $rwp_lazysizes_plugins = array(
    'aspectratio' => true,
    'print'       => true,
    'video-embed' => true,
    'progressive' => true,
    'unload'      => true,
    'object-fit'  => true,
    'bgset'       => true,
    'noscript'    => rwp_get_option('modules.lazysizes.noscript', false),
    'blur-up'     => rwp_get_option('modules.lazysizes.blurup', false),
    'parent-fit'  => rwp_get_option('modules.lazysizes.parentfit', false),
    'artdirect'   => rwp_get_option('modules.lazysizes.artdirect', false)
    );

    $rwp_lazysizes_deps = array();

    foreach ($rwp_lazysizes_plugins as $plugin => $include) {
        if($include) {
            $rwp_lazysizes_deps[] = "rwp-lazysizes-$plugin";
            $rwp_plugin_assets['scripts']["lazysizes-$plugin"] = array(
            'src'      => "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/$rwp_lazysizes_version/plugins/$plugin/ls.$plugin.min.js",
            'version'  => $rwp_lazysizes_version,
            'location' => 'lazysizes',
            'footer'   => true,
            'handle'   => "lazysizes-$plugin"
            );
        }
    }

    $rwp_plugin_assets['scripts']['lazysizes'] = array(
    'src'      => "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/$rwp_lazysizes_version/lazysizes.min.js",
    'version'  => $rwp_lazysizes_version,
    'location' => 'lazysizes',
    'footer'   => true,
    'handle'   => 'lazysizes',
    'deps'     => $rwp_lazysizes_deps
    );
}

$rwp_webpack_config = rwp_get_file_data(RWP_PLUGIN_ROOT . 'config.json', true);

if ($rwp_webpack_config ) {
    $rwp_webpack_config = rwp_object_to_array($rwp_webpack_config);
    $rwp_plugin_assets  = array_merge($rwp_plugin_assets, $rwp_webpack_config);
}

return $rwp_plugin_assets;
