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
	/**
	 * Add an col to the group with specific formatting
	 *
	 * @see Group::add_item
	 *
	 * @param mixed       $col        The col
	 * @param string|int  $key        The index key
	 * @param bool        $overwrite  Overwrite if exists or add if it doesn't
	 * @param bool        $format     Whether to format the col with class defaults
	 *
	 * @return mixed      The updated key;
	 */
	public function add_col( $col = '', $key = '', $overwrite = false, $format = true ) {
		return $this->add_item( $col, $key, $overwrite, $format );
	}

	/**
	 * Overwrite an col in the group with specific formatting
	 *
	 * @see Group::set_item
	 *
	 * @param mixed       $col        The col
	 * @param string|int  $key        The index key
	 * @param bool        $format     Whether to format the col with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function set_col( $col = '', $key = '', $format = true ) {
		return $this->add_col( $col, $key, true, $format );
	}

	/**
	 * Get an existing col
	 *
	 * @see Group::has_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return bool
	 */
	public function has_col( $key ) {
		return $this->has_item( $key );
	}

	/**
	 * Get an existing col
	 *
	 * @see Group::get_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return Element|false
	 */
	public function get_col( $key ) {
		return $this->get_item( $key );
	}

	/**
	 * Update an existing col
	 *
	 * @see Group::update_item
	 *
	 * @param string|int  $key     The index key
	 * @param string      $method  The class method to use
	 * @param mixed       $args
	 *
	 * @return void
	 */
	public function update_col( $key, $method, ...$args ) {
		$this->update_item( $key, $method, ...$args );
	}

	/**
	 * Remove an col
	 *
	 * @see Group::remove_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return void
	 */

	public function remove_col( $key ) {
		$this->remove_item( $key );
	}
}
