<?php
/** ============================================================================
 * Base skeleton of the plugin
 *
 * @package   RWP\Engine
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine;

use RWP\Engine\Abstracts\Plugin;
use RWP\Components\Str;
use RWP\Components\Collection;
class Base extends Plugin {

	use Traits\Assets;

	/**
     *  @inheritdoc
     */
    protected function __construct( $args = array() ) {

		$defaults = array(
			'file'         => RWP_PLUGIN_FILE,
			'autoloader'   => require RWP_PLUGIN_ROOT . '/vendor/autoload.php',
			'dir'          => RWP_PLUGIN_ROOT,
			'uri'          => RWP_PLUGIN_URI,
			'namespace'    => 'RWP',
			'title'        => __( 'RIESTER Core Plugin', 'rwp' ),
			'capability'   => 'manage_options',
			'settings-uri' => add_query_arg( 'page', 'rwp-options', 'admin.php' ),
			'icon' => 'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCIgcm9sZT0iaW1nIiBhcmlhLWhpZGRlbj0idHJ1ZSIgZm9jdXNhYmxlPSJmYWxzZSI+Cgk8cGF0aCBkPSJNNDg2LjEsMzA4LjhoLTM0LjV2MTc0LjFoMzQuNWM1Mi41LDAsNzIuMi0xOS42LDcyLjItODdTNTM4LjcsMzA4LjgsNDg2LjEsMzA4Ljh6IiAvPgoJPHBhdGggZD0iTTAsMHYxMDI0aDEwMjRsMC0xMDI0SDB6IE01NzAuOCw3OTUuMmwtNjktMjM0LjVjLTEyLjUsMS42LTMyLjksMi4zLTUwLjIsMi4zdjIzMi4yaC05Ny4yVjIyOC44aDEzNi41IGMxMDksMCwxNjQuNyw0Ni4zLDE2NC43LDE2Ny4xYzAsOTEtMzUuMywxMjcuOC02OC4yLDE0Mi43bDgyLjMsMjU2LjVINTcwLjh6IiAvPgo8L3N2Zz4K',
			'paths'        => array(
				'assets'       => array(
					'dir' => RWP_PLUGIN_ROOT . 'assets/',
					'uri' => RWP_PLUGIN_URI . 'assets/',
				),
				'config'       => array(
					'dir' => RWP_PLUGIN_ROOT . 'config/',
					'uri' => RWP_PLUGIN_URI . 'config/',
				),
				'includes'     => array(
					'dir' => RWP_PLUGIN_ROOT . 'includes/',
					'uri' => RWP_PLUGIN_URI . 'includes/',
				),
				'dependencies' => array(
					'dir' => RWP_PLUGIN_ROOT . 'includes/dependencies/',
					'uri' => RWP_PLUGIN_URI . 'includes/dependencies/',
				),
			),
		);

		$args = rwp_merge_args( $defaults, $args );

		parent::__construct( $args );

		$this->initialize_assets();

		// $icon = $this->asset_path( 'rwp-icon.svg' );

		// if ( $icon ) {
		// 	$icon = rwp_svg( $icon );
		// 	$icon = $icon->data_uri();
		// 	$this->set( 'icon', $icon );
		// }

    }

	/** Initialize the class and get the plugin settings */
	public function initialize() {}
}
