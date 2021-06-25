<?php
/** ============================================================================
 * Fake Pages inside WordPress
 *
 * @package   RWP\Integrations
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Base;

use RWP\Vendor\WPBP\FakePage\FakePage as FakePageBase;

/**
 * Fake Pages inside WordPress
 */
class FakePage extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		new FakePageBase(
			array(
				'slug'         => 'test-page',
				'post_title'   => 'Test Page',
				'post_content' => 'This is the fake page content',
			)
		);
	}

}
