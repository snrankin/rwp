<?php
/** ============================================================================
 * Helpers
 *
 * @package   RWP\/includes/engine/Traits/Helpers.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2022 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Engine\Traits;

if ( ! \defined( 'ABSPATH' ) ) {
    die( 'FU!' );
}
use RWP\Vendor\Exceptions\Http\Server\NotImplementedException;
use RWP\Vendor\Illuminate\Support\Arr;
trait Helpers {

	/**
	 * Get an attribute from the plugin instance.
	 *
	 * @param  string  $key
	 * @param  mixed   $default The default to use if the key is not found
	 * @return mixed   The value of the key if found else the default set
	 */
	public function get( $key, $default = null ) {
		$key = \is_array( $key ) ? $key : \explode( '.', $key );
		$first = array_shift( $key );

		if ( ! empty( $this->$first ) ) {
			$property = $this->$first; // Used for getting private/protected properties
			if ( ! empty( $key ) ) {
				return data_get( $property, $key, $default );
			} else {
				return $property;
			}
		} else {
			return $default;
		}

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

		$current = $this->get( $key );

		if ( $value !== $current ) {
			$key = \is_array( $key ) ? $key : \explode( '.', $key );
			$first = array_shift( $key );

			$target = $this->$first; // Used for getting private/protected properties
			if ( ! empty( $key ) ) {

				if ( Arr::accessible( $target ) || \is_object( $target ) ) {
					$target = data_set( $target, $key, $value, $overwrite );
					$this->$first = $target;
				} else {
					$expanded_value = data_set( [], $key, $value );
					if ( $overwrite ) {
						$this->$first = $expanded_value;
					} elseif ( ! isset( $this->$first ) ) {
						$this->$first = $expanded_value;
					}
				}
			} else {
				if ( $overwrite ) {
					$this->$first = $value;
				} elseif ( ! isset( $this->$first ) ) {
					$this->$first = $value;
				}
			}
		}
	}

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

	/**
	 * Alias for has()
	 *
	 * @param  string|string[]  $key
	 *
	 * @return bool
	 */
	public function exists( $key ) {
		return $this->has( $key );
	}

	/**
     * Find if there is an item in an array or object using "dot" notation.
     *
     * @param  string|string[] $key
	 *
     * @return bool
     */
	public function has( $key ) {
		$key = \is_array( $key ) ? $key : \explode( '.', $key );
		$first = array_shift( $key );

		if ( ! empty( $this->$first ) ) {
			$property = $this->$first; // Used for getting private/protected properties
			if ( ! empty( $key ) ) {
				return data_has( $property, $key );
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * Remove an item on an array or object using dot notation.
	 *
	 * @param mixed $key
	 *
	 * @return void
	 */
	public function remove( $key ) {

		$key = \is_array( $key ) ? $key : \explode( '.', $key );
		$first = array_shift( $key );

		if ( ! empty( $key ) && isset( $this->$first ) ) {
			$target = $this->$first; // Used for getting private/protected properties

			data_remove( $target, $key );
			$this->$first = $target;
		} elseif ( isset( $this->$first ) ) {
			unset( $this->$first );
		}
	}

	/**
	 * Get object info in a formatted way
	 * @param bool $qm Whether to add the variable to Query Monitor
	 * @return void|VarDumper
	 */

	public function debug( $qm = false ) {
		if ( $qm ) {
			rwp_log( $this );
		} else {
			return rwp_dump( $this );
		}

	}

	/**
	 * Handle dynamic calls to the plugin instance to set attributes.
	 *
	 * @param mixed $method
	 * @param mixed $parameters
	 *
	 * @return mixed
	 */
	public function __call( $method, $parameters ) {
		try {
			if ( method_exists( $this, $method ) ) {
				$args = \func_get_args();
				if ( count( $args ) > 1 ) {
					array_shift( $args );
					return $this->$method( ...$args );
				}
				return $this->$method();
			} else {
				$class = get_called_class();
				throw new NotImplementedException( "The class $class does not have a method called $method" );
			}
		} catch ( NotImplementedException $th ) {
			return new \WP_Error( $th->getCode(), $th->getMessage() );
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

	public function offsetSet( $offset, $value ) {
        $this->set( $offset, $value );
    }

    public function offsetExists( $offset ) {
        return $this->exists( $offset );
    }

    public function offsetUnset( $offset ) {
        $this->remove( $offset );
    }

    public function offsetGet( $offset ) {
        return $this->get( $offset );
    }

}
