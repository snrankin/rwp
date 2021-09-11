<?php
/** ============================================================================
 * Modules
 *
 * Include the various plugin modules
 *
 * @package   RWP\/includes/internals/Modules.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals;

use RWP\Engine\Abstracts\Singleton;

class Modules extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		$modules = glob( RWP_PLUGIN_ROOT . 'includes/internals/Modules/*.php' );

        foreach ( $modules as $file ) {
            require_once $file;
        }
	}
}
