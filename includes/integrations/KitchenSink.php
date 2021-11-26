<?php
/** ============================================================================
 * KitchenSink
 *
 * @package   RWP\/includes/integrations/KitchenSink.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use JsonException;
use RWP\Engine\Abstracts\Singleton;
use RWP\Vendor\Exceptions\Http\HttpException;
use RWP\Vendor\WPBP\FakePage;

class KitchenSink extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		new FakePage(array(
			'slug' => 'kitchen-sink',
			'post_title' => 'Kitchen Sink',
			'post_content' => 'This is the fake page content',
		));
	}

}
