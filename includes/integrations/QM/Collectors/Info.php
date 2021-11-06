<?php
/** ============================================================================
 * Plugn Info Collector
 *
 * @package   RWP\Integrations\QM\Collectors
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\QM\Collectors;

if ( class_exists( '\\QM_Collector' ) ) {

	class Info extends \QM_Collector {

		public function __construct( $title, $parent ) {
			$this->title = $title;
			$this->parent = $parent;
			$this->id = rwp_change_case( $title );
		}
		public function name() {
			return $this->title;
		}

		public function process() {
			if ( is_array( $this->parent->output ) ) {
				$this->data['log'] = $this->parent->output;
			}
		}
	}
}
