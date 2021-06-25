<?php

/** ============================================================================
 * RWP Object utilities
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ========================================================================== */

use \RWP\Vendor\Illuminate\Support\Collection;


/**
 * Object to Array
 *
 * Converts a multilevel object into an array
 *
 * @link https://stackoverflow.com/questions/4790453/php-recursive-array-to-object#answer-9185337
 *
 * @param object $obj
 *
 * @return array|false The converted object
 */
function rwp_object_to_array($obj) {
	if (empty($obj) || !is_object($obj)) {
		return false;
	}

	if ($obj instanceof Collection) {
		$obj = json_decode($obj->toJson(), true);
	} else {
		$obj = wp_json_encode($obj);
		if ($obj) {
			$obj = json_decode($obj, true);
		}
	}

	if ($obj) {
		return $obj;
	} else {
		return false;
	}
}

/**
 * Check if an object has a key and if the value is not empty
 *
 * @param string $key
 * @param mixed $obj
 *
 * @return bool
 */
function rwp_object_has($key, $obj) {
	if (is_object($obj)) {
		if (property_exists($obj, $key) && rwp_has_value($obj->$key)) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
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
 * @return bool|Collection
 */
function rwp_is_collection($var) {
	if ($var instanceof Collection) {
		return $var;
	} else {
		return false;
	}
}

/**
 * Check if an object has a key and if the value is not empty
 *
 * @param string $key
 * @param Collection $obj
 *
 * @return bool
 */
function rwp_collection_has($key, $obj) {
	if (rwp_is_collection($obj)) {
		if ($obj->isNotEmpty()) {
			if ($obj->has($key) && rwp_has_value($obj->get($key))) {
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

function rwp_collection_remove_empty_items($collection) {
	if (rwp_is_collection($collection)) {
		return $collection->reject(function ($item) {
			return empty($item);
		});
	} else {
		return $collection;
	}
}

/**
 * Remove empty items from a collection
 *
 * @param Collection $collection The collection to filter
 * @param array $order The array of keys in the desired order
 *
 * @return Collection
 */

function rwp_collection_sort_by_keys($collection, $order) {
	if (rwp_is_collection($collection)) {
		$collection = $collection->all();
		$collection = rwp_sort_array_by_keys($collection, $order);
		$collection = new Collection($collection);
	}

	return $collection;
}
