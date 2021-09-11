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

class Base extends Plugin implements Core {

	use Traits\Assets;

	/**
     *  @inheritdoc
     */
    protected function __construct( $args = array() ) {
		$file = RWP_PLUGIN_ABSOLUTE;
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
		$this->initialize();
		$this->options = \rwp_get_options();

		$this->initialize_assets();
    }

	/** Initialize the class and get the plugin settings */
	public function initialize() {

		$settings = array(
			'name'        => __( 'RWP', 'rwp' ),
			'title'       => __( 'RIESTER Core Plugin', 'rwp' ),
			'capability'  => 'manage_options',
			'settings-uri' => add_query_arg( 'page', $this->prefix( 'options', '-' ), 'admin.php' ),
			'icon'        => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNiAxNiIgd2lkdGg9IjFlbSIgaGVpZ2h0PSIxZW0iIGZpbGw9ImN1cnJlbnRDb2xvciI+PHBhdGggZD0iTTAgMHYxNmgxNlYwem05LjMzIDE0LjRMNy43NyA5LjFhOS40NyA5LjQ3IDAgMDEtMS4xMy4wNXY1LjI1aC0yLjJWMS42aDMuMDhjMi40NyAwIDMuNzIgMSAzLjcyIDMuNzggMCAyLjA1LS43OSAyLjg5LTEuNTQgMy4yMmwxLjg2IDUuOHoiLz48cGF0aCBkPSJNNy40MiAzLjQxaC0uNzh2My45M2guNzhjMS4xOCAwIDEuNjMtLjQ0IDEuNjMtMlM4LjYgMy40MSA3LjQyIDMuNDF6Ii8+PC9zdmc+',
		);
		foreach ( $settings as $key => $value ) {
			$this->set_setting( $key, $value );
		}
	}
}
