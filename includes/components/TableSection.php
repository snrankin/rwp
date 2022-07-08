<?php
/** ============================================================================
 * Bootstrap Container
 *
 * @package   RWP\Components
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class TableSection extends Group {

	public $tag = 'tbody';


	/**
	 * @var string The class to map all sub-elements into
	 */

	public $item_type = 'TableRow';


	/**
	 * Add an row to the group with specific formatting
	 *
	 * @see Group::add_item
	 *
	 * @param mixed       $row        The row
	 * @param string|int  $key        The index key
	 * @param bool        $overwrite  Overwrite if exists or add if it doesn't
	 * @param bool        $format     Whether to format the row with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function add_row( $row = '', $key = '', $overwrite = false, $format = true ) {
		return $this->add_item( $row, $key, $overwrite, $format );
	}

	/**
	 * Overwrite an row in the group with specific formatting
	 *
	 * @see Group::set_item
	 *
	 * @param mixed       $row        The row
	 * @param string|int  $key        The index key
	 * @param bool        $format     Whether to format the row with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function set_row( $row = '', $key = '', $format = true ) {
		return $this->add_row( $row, $key, true, $format );
	}

	/**
	 * Get an existing row
	 *
	 * @see Group::has_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return bool
	 */
	public function has_row( $key ) {
		return $this->has_item( $key );
	}

	/**
	 * Get an existing row
	 *
	 * @see Group::get_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return Row
	 */
	public function get_row( $key ) {
		return $this->get_item( $key );
	}

	/**
	 * Update an existing row
	 *
	 * @see Group::update_item
	 *
	 * @param string|int  $key     The index key
	 * @param string      $method  The class method to use
	 * @param mixed       $args
	 *
	 * @return mixed      The updated key
	 */
	public function update_row( $key, $method, ...$args ) {
		return $this->update_item( $key, $method, ...$args );
	}

	/**
	 * Remove an row
	 *
	 * @see Group::remove_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return void
	 */

	public function remove_row( $key ) {
		$this->remove_item( $key );
	}

	/**
	 * Add an cell to the group with specific formatting
	 *
	 * @see Group::add_item
	 *
	 * @param mixed       $cell        The cell
	 * @param string|int  $key        The index key
	 * @param bool        $overwrite  Overwrite if exists or add if it doesn't
	 * @param bool        $format     Whether to format the cell with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function add_cell( $cell = '', $key = '', $row = 0, $overwrite = false, $format = true ) {
		if ( ! $this->has_row( $row ) ) {
			$row = $this->add_row( '', $row );
		}
		return $this->update_row( $row, 'add_cell', $cell, $key, $overwrite, $format );

	}

	/**
	 * Overwrite an cell in the group with specific formatting
	 *
	 * @see Group::set_item
	 *
	 * @param mixed       $cell        The cell
	 * @param string|int  $key        The index key
	 * @param bool        $format     Whether to format the cell with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function set_cell( $cell = '', $key = '', $row = 0, $format = true ) {
		return $this->add_cell( $cell, $key, $row, true, $format );
	}

	/**
	 * Get an existing cell
	 *
	 * @see Group::has_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return bool
	 */
	public function has_cell( $key, $row = 0 ) {
		if ( ! $this->has_row( $row ) ) {
			return false;
		} else {
			$row = $this->get_row( $row );
			return $row->has_cell( $key );
		}

	}

	/**
	 * Get an existing cell
	 *
	 * @see Group::get_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return Column|false
	 */
	public function get_cell( $key, $row = 0 ) {
		if ( ! $this->has_row( $row ) ) {
			return false;
		} else {
			$row = $this->get_row( $row );
			return $row->get_cell( $key );
		}
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
	 * @return mixed|void The updated key
	 */
	public function update_cell( $key, $row = 0, $method, ...$args ) {
		if ( ! $this->has_row( $row ) ) {
			return;
		}
		return $this->update_row( $row, 'update_cell', $key, $method, $args );
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

	public function remove_cell( $key, $row = 0 ) {

		if ( ! $this->has_row( $row ) ) {
			return;
		}
		$this->update_row( $row, 'remove_cell', $key );
	}
}
