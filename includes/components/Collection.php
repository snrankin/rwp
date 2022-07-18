<?php
/** ============================================================================
 * Collection
 *
 * @package   RWP\/includes/components/Collection.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection as IlluminateCollection;

class Collection extends IlluminateCollection {

	/**
	 * Check if key exists in collection and if it is not empty
	 *
	 * @param mixed $key
	 *
	 * @return bool
	 */
	public function filled( $key ) {
        if ( $this->has( $key ) ) {
			return filled( $this->get( $key ) );
		} else {
			return false;
		}
	}

	/**
	 * Check if key exists in collection and if it is empty
	 *
	 * @param mixed $key
	 *
	 * @return bool
	 */
	public function blank( $key ) {
        if ( $this->has( $key ) ) {
			return blank( $this->get( $key ) );
		} else {
			return false;
		}
	}

	public function next( $key, $part = null ) {
		$keys = $this->keys();
		$values = $this->values();

		$current_index = $keys->search( $key );
		$nonzero_index = $current_index + 1;

		if ( false !== $current_index && $keys->count() > $nonzero_index ) {
			$next_index = $nonzero_index;
			if ( 'key' === $part ) {
				return $keys->get( $next_index );
			} else if ( 'value' === $part ) {
				return $values->get( $next_index );
			} else {
				return [
					'key' => $keys->get( $next_index ),
					'value' => $values->get( $next_index ),
				];
			}
		}

		return false;

	}

	public function previous( $key, $part = null ) {
		$keys = $this->keys();
		$values = $this->values();

		$current_index = $keys->search( $key );

		if ( false !== $current_index && $keys->count() >= $current_index && $current_index > 0 ) {
			$prev_index = $current_index - 1;
			if ( 'key' === $part ) {
				return $keys->get( $prev_index );
			} else if ( 'value' === $part ) {
				return $values->get( $prev_index );
			} else {
				return [
					'key' => $keys->get( $prev_index ),
					'value' => $values->get( $prev_index ),
				];
			}
		}

		return false;

	}

	/**
     * Recursively replace the collection items with the given items.
     *
     * @param  mixed  $items
     * @return static
     */
    public function replaceRecursive( $items ) {
		$items = rwp_object_to_array( $items );
        return new static( \array_replace_recursive( $this->items, $items ) );
    }

	/**
	 * Remove an item on an array or object using dot notation.
	 *
	 * @param mixed $key
	 *
	 * @return void
	 */
	public function remove( $key ) {

		unset( $this->items[ $key ] );
	}

	/**
     * Set an item on an array or object using dot notation.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @param  bool  $overwrite
	 *
	 * @return void
     */
	public function set( $key, $value = null, $overwrite = true ) {

		if ( $this->has( $key ) && $overwrite ) {
			$this->put( $key, $value );
		} else if ( ! $this->has( $key ) ) {
			$this->put( $key, $value );
		}
	}

	/**
	 * Dynamically retrieve the value of an attribute.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this->get( $key );
	}
	/**
	 * Dynamically set the value of an attribute.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function __set( $key, $value ) {
		$this->set( $key, $value );
	}

	/**
	 * Dynamically check if an attribute is set.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function __isset( $key ) {
		return $this->has( $key );
	}

	/**
	 * Dynamically unset an attribute.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __unset( $key ) {
		$this->remove( $key );
	}
}
