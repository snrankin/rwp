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

namespace RWP\Base;

if ( ! \defined( 'ABSPATH' ) ) {
	exit;
}

use RWP\Vendor\Exceptions\Http\Server\NotImplementedException;
use RWP\Vendor\WPBP\Debug\Debug;
use RWP\Vendor\Symfony\Component\VarDumper\VarDumper;
use RWP\Vendor\Illuminate\Support\Arr;

abstract class Singleton {

	use \RWP\Helpers\Utils;
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
			$rf = new \ReflectionClass( $class );
			$args = \func_get_args();

			if ( ! $rf->isAbstract() ) {

				self::$instances[ $class ] = new $class( ...$args ); // @phpstan-ignore-line
			}
		}
		return self::$instances[ $class ];
	}

	/**
	 * Check if a class extends or implements a specific class/interface
	 * @param string $search The class or interface name to look for
	 * @param string $class_name The class name of the object to compare to
	 * @return bool
	 */
	public static function IsExtendsOrImplements( $search, $class_name ) {
		$class = new \ReflectionClass( $class_name );
		if ( false === $class ) {
			return false;
		}
		do {
			$name = $class->getName();
			if ( $search === $name ) {
				return true;
			}
			$interfaces = $class->getInterfaceNames();
			if ( is_array( $interfaces ) && in_array( $search, $interfaces, true ) ) {
				return true;
			}
			$class = $class->getParentClass();
		} while ( false !== $class );
		return false;
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
	 *  Needed for initializing the component
	 */
	public function initialize() {
	}
}
