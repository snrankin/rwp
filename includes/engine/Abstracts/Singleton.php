<?php

/** ============================================================================
 * Singleton Abstract
 *
 * @package   RWP\Engine
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

if ( ! \defined( 'ABSPATH' ) ) {
    die( 'FU!' );
}
use RWP\Vendor\Exceptions\Http\Server\NotImplementedException;
use RWP\Vendor\WPBP\Debug\Debug;
use RWP\Vendor\Symfony\Component\VarDumper\VarDumper;

abstract class Singleton {

    /**
     * @var array $instances
     */
    private static $instances = array();

	/**
	 *
	 * @var string $name The component name (useful for debugging)
	 */
	public $name;

    /**
     * Getting a singleton.
     *
     * @return self single instance of Core
     */
    final public static function instance() {

        $class = \get_called_class();
        if ( ! isset( self::$instances[ $class ] ) ) {
            $args = \func_get_args();
            self::$instances[ $class ] = new $class( ...$args ); // @phpstan-ignore-line
        }
        return self::$instances[ $class ];
    }

	/**
     *  Needed for initializing the component
     */
    public function initialize() {}

	/**
	 * Get an attribute from the plugin instance.
	 *
	 * @param  string  $key
	 * @param  mixed   $default The default to use if the key is not found
	 * @return mixed   The value of the key if found else the default set
	 */
	public function get( $key, $default = null ) {
		return data_get( $this, $key, $default );

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
	public function set( $key, $value, $overwrite = true ) {
		data_set( $this, $key, $value, $overwrite );
	}

	/**
     * Find if there is an item in an array or object using "dot" notation.
     *
     * @param  string|string[] $key
	 *
     * @return bool
     */
	public function has( $key ) {
		return data_has( $this, $key );
	}

	/**
	 * Remove an item on an array or object using dot notation.
	 *
	 * @param mixed $key
	 *
	 * @return void
	 */
	public function remove( $key ) {
		data_remove( $this, $key );
	}

	/**
	 * Get object info in a formatted way
	 * @param bool $qm Whether to add the variable to Query Monitor
	 * @return void|VarDumper
	 */

	public function debug( $qm = false ) {
		if ( $qm ) {
			$qm = Debug::instance( 'RWP' );
			$qm->log( $this );
		} else {
			return VarDumper::dump( $this );
		}

	}

	/**
     *  Prevent Instantinating
     */
    final private function __clone(){}

    /**
     *  Protected constructor
     */
    protected function __construct(){}

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
}
