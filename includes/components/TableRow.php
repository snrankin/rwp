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

class TableRow extends Group {

	public $tag = 'tr';

	public $item_type = 'TableCell';

	public $location = 'body';



	/**
	 * Add a cell to the group with specific formatting
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
	public function add_cell( $cell = '', $key = '', $overwrite = false, $format = true ) {
		return $this->add_item( $cell, $key, $overwrite, $format );
	}

	/**
	 * Overwrite an cell in the group with specific formatting
	 *
	 * @see Group::set_item
	 *
	 * @param mixed       $col        The col
	 * @param string|int  $key        The index key
	 * @param bool        $format     Whether to format the col with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function set_cell( $cell = '', $key = '', $format = true ) {
		return $this->add_cell( $cell, $key, true, $format );
	}

	/**
	 * Check if a cell exists
	 *
	 * @see Group::has_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return bool
	 */
	public function has_cell( $key ) {
		return $this->has_item( $key );
	}

	/**
	 * Get an existing cell
	 *
	 * @see Group::get_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return TableCell|false
	 */
	public function get_cell( $key ) {
		return $this->get_item( $key );
	}

	/**
	 * Update an existing cell
	 *
	 * @see Group::update_item
	 *
	 * @param string|int  $key     The index key
	 * @param string      $method  The class method to use
	 * @param mixed       $args
	 *
	 * @return void
	 */
	public function update_cell( $key, $method, ...$args ) {
		$this->update_item( $key, $method, ...$args );
	}

	/**
	 * Remove an cell
	 *
	 * @see Group::remove_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return void
	 */

	public function remove_cell( $key ) {
		$this->remove_item( $key );
	}
}
