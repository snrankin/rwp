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
			'icon'         => 'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCIgcm9sZT0iaW1nIiBhcmlhLWhpZGRlbj0idHJ1ZSIgZm9jdXNhYmxlPSJmYWxzZSIgZmlsbD0iY3VycmVudENvbG9yIj4KCTxwYXRoIGQ9Ik00ODYuMSwzMDguOGgtMzQuNXYxNzQuMWgzNC41YzUyLjUsMCw3Mi4yLTE5LjYsNzIuMi04N1M1MzguNywzMDguOCw0ODYuMSwzMDguOHoiIC8+Cgk8cGF0aCBkPSJNMCwwdjEwMjRoMTAyNGwwLTEwMjRIMHogTTU3MC44LDc5NS4ybC02OS0yMzQuNWMtMTIuNSwxLjYtMzIuOSwyLjMtNTAuMiwyLjN2MjMyLjJoLTk3LjJWMjI4LjhoMTM2LjUgYzEwOSwwLDE2NC43LDQ2LjMsMTY0LjcsMTY3LjFjMCw5MS0zNS4zLDEyNy44LTY4LjIsMTQyLjdsODIuMywyNTYuNUg1NzAuOHoiIC8+Cjwvc3ZnPgo=',
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
					'dir' => RWP_PLUGIN_ROOT . 'dependencies/',
					'uri' => RWP_PLUGIN_URI . 'dependencies/',
				),
			),
		);

		$args = rwp_merge_args( $defaults, $args );

		parent::__construct( $args );

		$this->initialize_assets();

    }

	/** Initialize the class and get the plugin settings */
	public function initialize() {}
}
