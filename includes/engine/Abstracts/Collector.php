<?php
/** ============================================================================
 * Debug
 *
 * @package   RWP\/includes/integrations/QM/Debug.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

if ( ! \defined( 'ABSPATH' ) ) {
	die( 'FU!' );
}

abstract class Collector extends \QM_Collector {

	public function __construct( \RWP\Integrations\QM $parent, $id = '' ) {
		$prefix = rwp()->get( 'namespace' );

		$this->title = rwp_add_prefix( $id, $prefix . ' ' );
		$this->parent = $parent;
		$this->id = rwp()->prefix( $id );
	}
	public function name() {
		return $this->title;
	}

	public function process() {
		$id = $this->id;
		if ( rwp_array_has( $id, $this->parent->output ) && is_array( $this->parent->output[ $id ] ) ) {
			$this->data['log'] = $this->parent->output[ $id ];
		}
	}
}
