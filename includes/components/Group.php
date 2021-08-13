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

use RWP\Vendor\Illuminate\Support\Collection;

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
	 *
	 * @param mixed $item
	 * @return object
	 */

	public function format_item( $item ) {
        $item_default_atts = $this->item_atts;
		$item_type = __NAMESPACE__ . '\\' . $this->item_type;

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
				} else {
					$item->set( $key, $value, false );
				}
			}
		}

		return $item;

	}

	public function add_item( $item, $key = '', $overwrite = false ) {
		$item = $this->format_item( $item );

		if ( empty( $key ) ) {
			$this->elements->push( $item );
		} else {
			$this->set( "elements.$key", $item, $overwrite );
		}

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
