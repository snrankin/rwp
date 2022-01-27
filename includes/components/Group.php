<?php
/** ============================================================================
 * Html Group Element Template
 *
 * A class for creating an html element with a similar grouping of sub elements,
 * such as an unordered list with list items, or a row with columns, etc.
 *
 * @package   RWP\/includes/components/List.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

use RWP\Components\Collection;

class Group extends Element {

	/**
	 *
	 * @var Collection $elements The collection of items to add to the group
	 */

	public $elements;

	/**
	 * @var (string|string[][])[] $item_atts Attributes to add to all sub elements
	 */

	public $item_atts = array();

	/**
	 * @var string The class to map all sub-elements into
	 */

	public $item_type = 'Element';

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		parent::__construct( $args );

		if ( ! rwp_is_collection( $this->elements ) ) {
			$this->elements = new Collection( $this->elements );
		}

		$this->elements->transform(function( $item ) {
			$item = $this->format_item( $item );
			return $item;
		});
	}

	/**
	 * Format an item before adding it to the group
	 *
	 * @param mixed $item
	 *
	 * @return object
	 */

	public function format_item( $item ) {
        $item_default_atts = $this->item_atts;
		$item_type = __NAMESPACE__ . '\\' . $this->item_type;

		if ( is_array( $item ) ) {
			$item = rwp_merge_args( $item_default_atts, $item );
		}

		if ( ! ( $item instanceof $item_type ) ) {
			$item = new $item_type( $item );
		}
		if ( $item instanceof $item_type ) {
			/**
			 * @var Element $item
			 */
			$item = $item;
			foreach ( $item_default_atts as $key => $value ) {
				if ( 'tag' === $key ) {
					$item->set_tag( $value );
				} elseif ( 'atts' === $key && is_array( $value ) ) {
					$atts = $value;
					foreach ( $atts as $prop => $prop_val ) {
						$item->set_attr( $prop, $prop_val );
					}
				} else {
					$item->set( $key, $value, false );
				}
			}
		}

		return $item;

	}

	/**
	 * Add an item to the group with specific formatting
	 *
	 * @param mixed       $item       The item
	 * @param string|int  $key        The index key
	 * @param bool        $overwrite  Overwrite if exists or add if it doesn't
	 * @param bool        $format     Whether to format the item with class defaults
	 *
	 * @return mixed
	 */
	public function add_item( $item = '', $key = '', $overwrite = false, $format = true ) {

		if ( $format ) {
			$item = $this->format_item( $item );
		}

		if ( blank( $key ) ) {
			$this->elements->push( $item );
			$key = $this->elements->search( $item );
		} else {
			$this->set( "elements.$key", $item, $overwrite );
		}

		return $key;

	}

	/**
	 * Overwrite an item in the group with specific formatting
	 *
	 * @param mixed       $item       The item
	 * @param string|int  $key        The index key
	 * @param bool        $format     Whether to format the item with class defaults
	 *
	 * @return mixed      The updated key
	 */
	public function set_item( $item = '', $key = '', $format = true ) {
		return $this->add_item( $item, $key, true, $format );
	}

	/**
	 * Get an existing item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return bool
	 */
	public function has_item( $key ) {
		return $this->has( "elements.$key" );
	}

	/**
	 * Get an existing item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return Element|false
	 */
	public function get_item( $key, $default = false ) {
		return $this->get( "elements.$key", $default );
	}

	/**
	 * Update an existing item
	 *
	 * @param string|int  $key     The index key
	 * @param string      $method  The class method to use
	 * @param mixed       $args
	 *
	 * @return mixed      The updated key
	 */
	public function update_item( $key, $method, ...$args ) {
		$item = $this->get_item( $key );

		if ( ! blank( $item ) && rwp_is_element( $item ) ) {
			$item->__call( $method, $args );

			$this->set_item( $item, $key, false );
		}
	}

	/**
	 * Remove an item
	 *
	 * @param string|int  $key        The index key
	 *
	 * @return void
	 */

	public function remove_item( $key ) {
		$this->remove( "elements.$key" );
	}

	/**
	 * Function to run before building the Html class
	 *
	 * @return void
	 */

	public function setup_html() {
		if ( rwp_is_collection( $this->elements ) && $this->elements->isNotEmpty() ) {
			$this->elements->each(function( $item, $key ) {
				$item = $this->format_item( $item );
				$item = $item->html();
				$this->set_content( $item, $key, true );
			});
		}
	}
}
