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

use RWP\Engine\Interfaces\Core;
use RWP\Engine\Abstracts\Plugin;
use RWP\Vendor\Illuminate\Support\Str;
use RWP\Vendor\Exceptions\Collection\KeyNotFoundException;

class Base extends Plugin implements Core {

	use Traits\Assets;

	/**
     *  @inheritdoc
     */
    protected function __construct( $file, $args = array() ) {
		parent::__construct( $file, $args );

		$root    = $this->get_plugin_dir();
        $configs = glob( $root . '/config/*.php' );

		if ( $configs ) {
			foreach ( $configs as $config ) {
				$config = Str::after( $config, $root );
				$filename = basename( $config );
				$configname = rwp_basename( $config );
				$dir = Str::before( $config, $filename );

				$config = rwp_get_plugin_file( $filename, $dir, true, true );
				$this->set_setting( $configname, $config );
			}
		}
    }

	/** Initialize the class and get the plugin settings */
	public function initialize() {
		// Define constants.

		$configs       = glob( RWP_PLUGIN_ROOT . '/config/*.php' );
		if ( $configs ) {
			foreach ( $configs as $config ) {
				$name                    = basename( $config, '.php' );
				$this->settings[ $name ] = require $config;
			}
		}
		$this->options = \rwp_get_options();

		$this->initialize_assets();
		return true;
	}

}
