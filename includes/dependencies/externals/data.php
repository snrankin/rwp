<?php
/** ============================================================================
 * data
 *
 * @package   RWP\/includes/dependencies/externals/data.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

use RWP\Vendor\Illuminate\Support\Arr;
use RWP\Vendor\Illuminate\Support\Collection;

 /**
 * Additional data helper functions
 * @link https://gist.github.com/derekmd/34da3c9861c14a7ebe4dc78582e20a35
 */

if ( ! function_exists( 'data_dot' ) ) {
    /**
     * Flatten a multi-dimensional object with dots.
     *
     * @param  array|ArrayAccess|object $object
     * @param  string $prepend
     *
     * @return array
     */
    function data_dot( $object, $prepend = '' ) { // phpcs:ignore
        $results = [];

        if ( Arr::accessible( $object ) ) {
            $array = $object;
        } elseif ( is_object( $object ) ) {
            $array = get_object_vars( $object );
        } else {
            $array = [];
        }

        foreach ( $array as $key => $value ) {
            if ( is_array( $value ) && ! empty( $value ) ) {
                $results = array_merge( $results, data_dot( $value, $prepend . $key . '.' ) );
            } elseif ( $value instanceof Collection ) {
                $results = array_merge( $results, data_dot( $value->all(), $prepend . $key . '.' ) );
            } elseif ( is_object( $value ) && ! empty( get_object_vars( $value ) ) ) {
				$props = get_object_vars( $value );
                $results = array_merge( $results, data_dot( $props, $prepend . $key . '.' ) );
            } else {
                $results[ $prepend . $key ] = $value;
            }
        }

        return $results;
    }
}

if ( ! function_exists( 'data_has' ) ) {
    /**
     * Find if there is an item in an array or object using "dot" notation.
     *
     * @param  mixed   $target
     * @param  string|array  $keys
     *
     * @return bool
     */
    function data_has( $target, $keys ) { // phpcs:ignore
        if ( is_null( $keys ) ) {
            return false;
        }

        $keys = (array) $keys;

        if ( ! $target ) {
            return false;
        }

        if ( [] === $keys ) {
            return false;
        }

        foreach ( $keys as $i => $key ) {
            $sub_key_target = $target;

            if ( Arr::accessible( $sub_key_target ) && Arr::exists( $sub_key_target, $key ) ) {
                continue;
            }

            if ( is_object( $sub_key_target ) && Arr::exists( get_object_vars( $sub_key_target ), $key ) ) {
                continue;
            }

            foreach ( explode( '.', $key ) as $segment ) {
                if ( '*' === $segment ) {
                    if ( $sub_key_target instanceof Collection ) {
                        $sub_key_target = $sub_key_target->all();
                    } elseif ( ! is_array( $sub_key_target ) ) {
                        return false;
                    }

                    if ( empty( $key ) ) {
                        return true;
                    }

                    return array_reduce($sub_key_target, function ( $present, $item ) use ( $keys, $i ) {
                        return $present || data_has( $item, array_slice( $keys, $i + 1 ) );
                    }, false);
                }

                if ( Arr::accessible( $sub_key_target ) && Arr::exists( $sub_key_target, $segment ) ) {
                    $sub_key_target = $sub_key_target[ $segment ];
                } elseif ( is_object( $sub_key_target ) && isset( $sub_key_target->{$segment} ) ) {
                    $sub_key_target = $sub_key_target->{$segment};
                } else {
                    return false;
                }
            }
        }

        return true;
    }
}

if ( ! \function_exists( 'data_remove' ) ) {
    /**
     * Set an item on an array or object using dot notation.
     *
     * @param  mixed  $target
     * @param  string|array  $key
     * @return mixed
     */
    function data_remove( &$target, $key ) { // phpcs:ignore
        $segments = \is_array( $key ) ? $key : \explode( '.', $key );
        if ( ( $segment = \array_shift( $segments ) ) === '*' ) { // phpcs:ignore
            if ( ! Arr::accessible( $target ) ) {
                return $target;
            }
            if ( $segments ) {
                foreach ( $target as &$inner ) {
                    data_remove( $inner, $segments );
                }
            } else {
				unset( $target[ $segment ] );
			}
        } elseif ( Arr::accessible( $target ) ) {
            if ( $segments ) {
                if ( ! Arr::exists( $target, $segment ) ) {
                    return $target;
                }
                data_remove( $target[ $segment ], $segments );
            } else {
				unset( $target[ $segment ] );
			}
        } elseif ( \is_object( $target ) ) {
            if ( $segments ) {
                if ( ! isset( $target->{$segment} ) ) {
                    return $target;
                }
                data_remove( $target->{$segment}, $segments );
            } else {
				unset( $target->{$segment} );
			}
        } else {
            return $target;
        }
    }
}
