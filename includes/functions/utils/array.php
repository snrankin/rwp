<?php

/**
 * ============================================================================
 * RWP array
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ==========================================================================
 */

/**
 * Check if an array has a key and if the value is not empty
 *
 * @param string|int $key
 * @param mixed      $array
 *
 * @return bool
 */
function rwp_array_has( $key, $array ) {
	if ( is_array( $array ) ) {
        if ( isset( $array[ $key ] ) && filled( $array[ $key ] ) ) {
            return true;
        } else {
            return false;
        }
	} else {
		return false;
	}
}

/**
 * Checks if the array is multidimensional
 *
 * @param array $array The array to check
 *
 * @return bool
 */

function rwp_array_is_multi( $array ) {
	if ( count( $array ) === count( $array, COUNT_RECURSIVE ) ) {
        return false;
	} else {
		return true;
	}
}

/**
 * A function to easily sort an array by a specified key order.
 *
 * @param array $array The array of key/value items (non-numeric array) (passed by reference).
 * @param array $order A simple array of key names that correspond to the input array
 *
 * @return array The sorted array
 */
function rwp_sort_array_by_keys( $array, $order ) {
     uksort(
        $array, function ( $key1, $key2 ) use ( $order ) {
            return ( ( array_search( $key1, $order, true ) > array_search( $key2, $order, true ) ) ? 1 : -1 );
        }
    );

    return $array;
}


/**
 * Is Sequential
 *
 * A function to check if a numeric array is in sequential order with no gaps
 *
 * @link https://stackoverflow.com/a/173479
 *
 * @param array $arr The numeric array
 *
 * @return bool
 */
function rwp_array_is_sequential( array $arr ) {
    if ( empty( $arr ) ) {
        return false;
    }
    $start = array_key_first( $arr );

    $end = array_key_last( $arr );

    return array_keys( $arr ) !== range( $start, $end - 1 );
}

/**
 * Convert an array into a stdClass()
 *
 * Converts a multilevel array into an object
 *
 * @link https://stackoverflow.com/questions/4790453/php-recursive-array-to-object#answer-9185337
 *
 * @param array $array The array we want to convert
 *
 * @return object|false
 */
function rwp_array_to_object( $array ) {
	if ( empty( $array ) || ! is_array( $array ) ) {
        return false;
	}
    // First we convert the array to a json string
    $json = wp_json_encode( $array, JSON_FORCE_OBJECT );

	if ( $json ) {
		// The we convert the json string to a stdClass()
		$object = json_decode( $json );

		return $object;
	} else {
		return false;
	}
}

/**
 * Easily remove elements from an array
 *
 * @param array           $array
 * @param string[]|string $element
 *
 * @return array
 */
function rwp_array_remove( $array, $element ) {
     return ( is_array( $element ) ) ? array_values( array_diff( $array, $element ) ) : array_values( array_diff( $array, array( $element ) ) );
}

/**
 *
 * @param array      $array
 * @param int|string $position
 * @param mixed      $insert
 */
function rwp_array_insert( &$array, $position, $insert ) {
    if ( is_int( $position ) ) {
        array_splice( $array, $position, 0, $insert );
    } else {
        $pos   = array_search( $position, array_keys( $array ) );
        $array = array_merge(
            array_slice( $array, 0, $pos ),
            $insert,
            array_slice( $array, $pos )
        );
    }
}

/**
 * XML to Array
 *
 * Takes a SimpleXMLElement element and converts it into an array
 *
 * @link https://www.php.net/manual/en/class.simplexmlelement.php#122006
 *
 * @param SimpleXMLElement $xml
 *
 * @return array
 */
function rwp_xml_to_array( \SimpleXMLElement $xml ): array {
    $parser = function ( \SimpleXMLElement $xml, array $collection = array() ) use ( &$parser ) {
        $nodes      = $xml->children();
        $attributes = $xml->attributes();

        $collection['tag'] = $xml->getName();

        if ( 0 !== count( $attributes ) ) {
            foreach ( $attributes as $attr_name => $attr_value ) {
                $collection['atts'][ $attr_name ] = strval( $attr_value );
            }
        }

        if ( 0 === $nodes->count() ) {
            $collection['content'] = strval( $xml );
            return $collection;
        }

        foreach ( $nodes as $node_name => $node_value ) {
            if ( count( $node_value->xpath( '../' . $node_name ) ) < 2 ) {
                $collection['children'][] = $parser( $node_value );
                continue;
            }

            $collection['children'][] = $parser( $node_value );
        }

        return $collection;
    };

    return $parser( $xml );
}
