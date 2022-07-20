<?php

/** ============================================================================
 * Grid
 *
 * @package   RWP\/includes/components/Grid.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Html;

use RWP\Helpers\Collection;

class Grid extends Element {
	public $sections;
	public $containers;
	public $rows;
	public $columns;

	public function __construct( $args = [] ) {
		parent::__construct( $args );
		$this->sections = new Collection( $this->sections );
		$this->containers = new Collection( $this->containers );
		$this->rows = new Collection( $this->rows );
		$this->columns = new Collection( $this->columns );
	}
}
