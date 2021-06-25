<?php
/** ============================================================================
 * Everything that involves notification on the WordPress dashboard
 *
 * @package   RWP\Backend
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Backend;

use RWP\Engine\Base;

class Notices extends Base {

	/**
	 * Initialize the class
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}
	}
}
