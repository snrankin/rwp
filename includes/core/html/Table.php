<?php

/** ============================================================================
 * Bootstrap Table
 *
 * @package   RWP\Html
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Html;

class Table extends Element {

	public $tag = 'table';

	public $order = array( 'header', 'body', 'footer' );

	public $header = array(
		'tag' => 'thead',
	);

	public $body = array(
		'tag' => 'tbody',
	);

	public $footer = array(
		'tag' => 'tfoot',
	);

	public $atts = array(
		'class' => array(
			'table',
		),
	);

	/**
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'header' => 'TableSection',
		'body'   => 'TableSection',
		'footer' => 'TableSection',
	);


	/**
	 * Add an row to the group with specific formatting
	 *
	 * @see Group::add_item
	 *
	 * @param mixed       $row        The row
	 * @param string|int  $key        The index key
	 * @param string      $location   The section the row belongs to
	 * @param bool        $overwrite  Overwrite if exists or add if it doesn't
	 * @param bool        $format     Whether to format the row with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function add_row( $row = '', $key = '', $location = 'body', $overwrite = false, $format = true ) {

		return $this->$location->add_row( $row, $key, $overwrite, $format );
	}

	/**
	 * Overwrite an row in the group with specific formatting
	 *
	 * @see Group::set_item
	 *
	 * @param mixed       $row        The row
	 * @param string|int  $key        The index key
	 * @param string      $location   The section the row belongs to
	 * @param bool        $format     Whether to format the row with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function set_row( $row = '', $key = '', $location = 'body', $format = true ) {

		return $this->add_row( $row, $key, $location, true, $format );
	}

	/**
	 * Get an existing row
	 *
	 * @see Group::has_item
	 *
	 * @param string|int  $key        The index key
	 * @param string      $location   The section the row belongs to
	 *
	 * @return bool
	 */
	public function has_row( $key, $location = 'body' ) {

		return $this->$location->has_row( $key );
	}

	/**
	 * Get an existing row
	 *
	 * @see Group::get_item
	 *
	 * @param string|int  $key        The index key
	 * @param string      $location   The section the row belongs to
	 *
	 * @return Row
	 */
	public function get_row( $key, $location = 'body' ) {
		return $this->$location->get_item( $key );
	}

	/**
	 * Update an existing row
	 *
	 * @see Group::update_item
	 *
	 * @param string|int  $key     The index key
	 * @param string      $location   The section the row belongs to
	 * @param string      $method  The class method to use
	 * @param mixed       $args
	 *
	 * @return mixed      The updated key
	 */
	public function update_row( $key, $location = 'body', $method = '', ...$args ) {

		return $this->$location->update_row( $key, $method, ...$args );
	}

	/**
	 * Remove an row
	 *
	 * @see Group::remove_item
	 *
	 * @param string|int  $key        The index key
	 * @param string      $location   The section the row belongs to
	 *
	 * @return void
	 */

	public function remove_row( $key, $location = 'body' ) {
		$this->$location->remove_item( $key );
	}

	/**
	 * Add an cell to the group with specific formatting
	 *
	 * @see Group::add_item
	 *
	 * @param mixed       $cell       The cell
	 * @param string|int  $key        The index key
	 * @param string|int  $row        The row key in the section
	 * @param string      $location   The section the cell belongs to
	 * @param bool        $overwrite  Overwrite if exists or add if it doesn't
	 * @param bool        $format     Whether to format the cell with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function add_cell( $cell = '', $key = '', $row = 0, $location = 'body', $overwrite = false, $format = true ) {
		if ( ! $this->has_row( $row, $location ) ) {
			$row = $this->add_row( array( 'location' => $location ), $row );
		}
		return $this->update_row( $row, 'add_cell', $cell, $key, $overwrite, $format );
	}

	/**
	 * Overwrite an cell in the group with specific formatting
	 *
	 * @see Group::set_item
	 *
	 * @param mixed       $cell       The cell
	 * @param string|int  $key        The index key
	 * @param string|int  $row        The row key in the section
	 * @param string      $location   The section the cell belongs to
	 * @param bool        $format     Whether to format the cell with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function set_cell( $cell = '', $key = '', $row = 0, $location = 'body', $format = true ) {
		if ( ! $this->has_row( $row, $location ) ) {
			$row = $this->add_row( array( 'location' => $location ), $row );
		}
		return $this->add_cell( $cell, $key, $row, true, $format );
	}

	/**
	 * Get an existing cell
	 *
	 * @see Group::has_item
	 *
	 * @param string|int  $key        The index key
	 * @param string|int  $row        The row key in the section
	 * @param string      $location   The section the cell belongs to
	 *
	 * @return bool
	 */
	public function has_cell( $key, $row = 0, $location = 'body' ) {
		if ( ! $this->has_row( $row, $location ) ) {
			return false;
		} else {
			$row = $this->get_row( $row, $location );
			return $row->has_cell( $key );
		}
	}

	/**
	 * Get an existing cell
	 *
	 * @see Group::get_item
	 *
	 * @param string|int  $key        The index key
	 * @param string|int  $row        The row key in the section
	 * @param string      $location   The section the cell belongs to
	 *
	 * @return Column|false
	 */
	public function get_cell( $key, $row = 0, $location = 'body' ) {
		if ( ! $this->has_row( $row, $location ) ) {
			return false;
		} else {
			$row = $this->get_row( $row, $location );
			return $row->get_cell( $key );
		}
	}

	/**
	 * Update an existing cell
	 *
	 * @see Group::update_item
	 *
	 * @param string|int  $key       The index key
	 * @param string|int  $row       The row key in the section
	 * @param string      $location  The section the cell belongs to
	 * @param string      $method    The class method to use
	 * @param mixed       $args
	 *
	 * @return mixed|void The updated key
	 */
	public function update_cell( $key, $row = 0, $location = 'body', $method = '', ...$args ) {
		if ( ! $this->has_row( $row, $location ) ) {
			return;
		}
		return $this->update_row( $row, $location, 'update_cell', $key, $method, $args );
	}

	/**
	 * Remove an cell
	 *
	 * @see Group::remove_item
	 *
	 * @param string|int  $key        The index key
	 * @param string|int  $row        The row key in the section
	 * @param string      $location   The section the cell belongs to
	 *
	 * @return void
	 */

	public function remove_cell( $key, $row = 0, $location = 'body' ) {

		if ( ! $this->has_row( $row, $location ) ) {
			return;
		}
		$this->update_row( $row, $location, 'remove_cell', $key );
	}
}
