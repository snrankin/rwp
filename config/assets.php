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


return [
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
