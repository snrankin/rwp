<?php
/** ============================================================================
 * List
 *
 * @package   RWP\/includes/components/List.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class Row extends Group {

	public $tag = 'div';

	public $atts = array(
		'class' => array(
            'row',
		),
	);

	public $item_type = 'Column';

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		parent::__construct( $args );
	}
}
