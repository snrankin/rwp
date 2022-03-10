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

		$args = rwp_merge_args($defaults, $args);


		parent::__construct( $args );

		$this->initialize_assets();
    }

	/** Initialize the class and get the plugin settings */
	public function initialize() {}
}
