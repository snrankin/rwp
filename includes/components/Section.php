<?php
/** ============================================================================
 * Column
 *
 * @package   RWP\/includes/components/Column.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

 namespace RWP\Components;

use RWP\Components\Collection;

class Section extends Element {

	/**
	 * @var string $tag The html element tag
	 */
	public $tag = 'section';

	/**
	 * @var Collection|array $atts The collection of atts
	 */
	public $atts = array(
		'class' => array(
            'page-section',
		),
	);

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */

    public $order = array( 'inner' );

	/**
	 * @var array|Container $inner The inner content wrapper
	 */
    public $inner;


    public function __construct( $args = [] ) {

        parent::__construct( $args );

        $this->inner = new Container( $this->inner );
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
		return $this->inner->add_row( $row, $key, $overwrite, $format );
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
		return $this->inner->has_row( $key );
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
		return $this->inner->get_row( $key );
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
		return $this->inner->update_row( $key, $method, ...$args );
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
		$this->inner->remove_row( $key );
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
		return $this->inner->add_col( $col, $key, $row, $overwrite, $format );
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
	 * @return void
	 */
	public function set_col( $col = '', $key = '', $row = 0, $format = true ) {
		$this->inner->set_col( $col, $key, $row, $format );
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
		return $this->inner->has_col( $key, $row );
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
		return $this->inner->get_col( $key, $row );
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
	public function update_col( $key, $row = 0, $method, ...$args ) {
		$this->inner->update_col( $key, $row, $method, ...$args );
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
		$this->inner->remove_col( $key, $row );
	}
}
