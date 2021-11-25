<?php
/** ============================================================================
 * Bootstrap Container
 *
 * @package   RWP\Components
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class Container extends Group {

	public $tag = 'div';

	/**
	 *
	 * @var bool|string[] Boolean for fluid container or an array of breakpoints
	 */

	public $fluid = false;

	/**
	 * @var string The class to map all sub-elements into
	 */

	public $item_type = 'Row';

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

	public function setup_html() {
		parent::setup_html();
		if ( is_array( $this->fluid ) ) {
			foreach ( $this->fluid  as $bp ) {
				$this->add_class( "container-$bp" );
			}
		} else if ( $this->fluid ) {
			$this->add_class( 'container-fluid' );
		} else {
			$this->add_class( 'container' );
		}
	}
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
	 * Add an col to the group with specific formatting
	 *
	 * @see Group::add_item
	 *
	 * @param mixed       $col        The col
	 * @param string|int  $key        The index key
	 * @param bool        $overwrite  Overwrite if exists or add if it doesn't
	 * @param bool        $format     Whether to format the col with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function add_col( $col = '', $key = '', $row = 0, $overwrite = false, $format = true ) {
		if ( ! $this->has_row( $row ) ) {
			$row = $this->add_row( '', $row );
		}
		return $this->update_row( $row, 'add_col', $col, $key, $overwrite, $format );

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
	public function set_col( $col = '', $key = '', $row = 0, $format = true ) {
		return $this->add_col( $col, $key, $row, true, $format );
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
	public function has_col( $key, $row = 0 ) {
		if ( ! $this->has_row( $row ) ) {
			return false;
		} else {
			$row = $this->get_row( $row );
			return $row->has_col( $key );
		}

	}

	/**
	 * Get an existing col
	 *
	 * @see Group::get_item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return Column|false
	 */
	public function get_col( $key, $row = 0 ) {
		if ( ! $this->has_row( $row ) ) {
			return false;
		} else {
			$row = $this->get_row( $row );
			return $row->get_col( $key );
		}
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
	 * @return mixed|void The updated key
	 */
	public function update_col( $key, $row = 0, $method, ...$args ) {
		if ( ! $this->has_row( $row ) ) {
			return;
		}
		return $this->update_row( $row, 'update_col', $key, $method, $args );
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

	public function remove_col( $key, $row = 0 ) {

		if ( ! $this->has_row( $row ) ) {
			return;
		}
		$this->update_row( $row, 'remove_col', $key );
	}
}
