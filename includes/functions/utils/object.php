<?php

/**
 * ============================================================================
 * RWP Object utilities
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ==========================================================================
 */

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Vendor\Illuminate\Contracts\Support\Arrayable;
use RWP\Vendor\Illuminate\Contracts\Support\Jsonable;
use RWP\Vendor\Illuminate\Support\Enumerable;
/**
 * Function wrapper for Collection class
 *
 * @param mixed $args The Collection class arguments
 *
 * @return Collection
 */

function rwp_collection( $args = array() ) {
     return new Collection( $args );
}


/**
 * Object to Array
 *
 * Converts a multilevel object into an array
 *
 * @param object $obj
 *
 * @return array The converted object
 */
function rwp_object_to_array( $obj ) {
    if ( $obj instanceof Collection ) {
		return json_decode( $obj->toJson(), true );
	} elseif ( $obj instanceof Enumerable ) {
        return $obj->all();
    } elseif ( $obj instanceof Arrayable ) {
        return $obj->toArray();
    } elseif ( $obj instanceof Jsonable ) {
        return json_decode( $obj->toJson(), true );
    } elseif ( $obj instanceof \JsonSerializable ) {
        return (array) $obj->jsonSerialize();
    } elseif ( $obj instanceof \Traversable ) {
        return iterator_to_array( $obj );
    } else {
        $obj = wp_json_encode( $obj );
        if ( $obj ) {
            $obj = json_decode( $obj, true );
        }
    }
    return (array) $obj;

}

/**
 * Check if an object has a key and if the value is not empty
 *
 * @param string $key
 * @param mixed  $obj
 *
 * @return bool
 */
function rwp_object_has( $key, $obj ) {
	if ( is_object( $obj ) ) {
        if ( property_exists( $obj, $key ) && rwp_has_value( $obj->$key ) ) {
            return true;
        } else {
            return false;
        }
	} else {
		return false;
	}
}

/**
 * Get item from object
 *
 * @param mixed  $obj
 * @param string $key
 * @param mixed  $default
 *
 * @return bool
 */
function rwp_object_get( $obj, $key, $default = null ) {
	if ( rwp_object_has( $key, $obj ) ) {
        return $obj->$key;
	} else {
		return $default;
	}
}


// ========================================================================== //
// ====================== SECTION: Collection Functions ===================== //
// ========================================================================== //

/**
 * Check if variable is an instance of a Collection class
 *
 * @param mixed $var the variable to check
 *
 * @return bool
 */
function rwp_is_collection( $var ) {
     return ( $var instanceof Collection );
}

/**
 * Check if an object has a key and if the value is not empty
 *
 * @param string     $key
 * @param Collection $obj
 *
 * @return bool
 */
function rwp_collection_has( $key, $obj ) {
	if ( rwp_is_collection( $obj ) ) {
        if ( $obj->isNotEmpty() ) {
            if ( $obj->has( $key ) && rwp_has_value( $obj->get( $key ) ) ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
	} else {
		return false;
	}
}

/**
 * Remove empty items from a collection
 *
 * @param Collection $collection The collection to filter
 *
 * @return Collection
 */

function rwp_collection_remove_empty_items( $collection ) {
	if ( rwp_is_collection( $collection ) ) {
        return $collection->reject(
			function ( $item ) {
                return empty( $item );
			}
		);
	} else {
		return $collection;
	}
}

/**
 * Sorts items from a collection
 *
 * @param Collection $collection The collection to filter
 * @param array      $order      The array of keys in the desired order
 *
 * @return Collection
 */

function rwp_collection_sort_by_keys( $collection, $order ) {
	if ( rwp_is_collection( $collection ) ) {
        $collection = $collection->all();
        $collection = rwp_sort_array_by_keys( $collection, $order );
	}

    return new Collection( $collection );
}
