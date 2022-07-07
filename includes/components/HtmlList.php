<?php
/** ============================================================================
 * List
 *
 * @package   RWP\/includes/components/List.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class HtmlList extends Group {
	/**
	 * @var string
	 */
	public $tag = 'ul';

	/**
	 * @var (string|string[][])[] $item_atts Attributes to add to all
	 *                                               list items
	 */

	public $item_atts = array(
		'tag' => 'li',
	);

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
