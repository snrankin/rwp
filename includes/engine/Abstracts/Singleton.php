<?php

/** ============================================================================
 * Singleton Abstract
 *
 * @package   RWP\Engine
 * @since     0.9.0
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
use RWP\Vendor\Illuminate\Support\Arr;
abstract class Singleton {

    /**
	 * Any Singleton class.
	 *
	 * @var Singleton[] $instances
	 */
    private static $instances = array();

    /**
     * Getting a singleton.
     *
     * @return Singleton
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
	 * Consctruct.
	 * Private to avoid "new".
	 *
	 * @access
	 */
	private function __construct() {
	}

	/**
	 * Avoid clone instance
	 */
	private function __clone() {
	}

	/**
	 * Avoid serialize instance
	 */
	private function __sleep() { // phpcs:ignore
	}

	/**
	 * Avoid unserialize instance
	 */
	private function __wakeup() {
	}

	/**
     *  Needed for initializing the component
     */
    public function initialize() {}


}
