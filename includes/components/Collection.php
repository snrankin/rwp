<?php
/** ============================================================================
 * Collection
 *
 * @package   RWP\/includes/components/Collection.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection as IlluminateCollection;

class Collection extends IlluminateCollection {

	/**
	 * Check if key exists in collection and if it is not empty
	 *
	 * @param mixed $key
	 *
	 * @return bool
	 */
	public function filled( $key ) {
        if ( $this->has( $key ) ) {
			return filled( $this->get( $key ) );
		} else {
			return false;
		}
	}
}
