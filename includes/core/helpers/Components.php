<?php

/** ============================================================================
 * Autoloader
 *
 * @package   RWP\Helpers
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2022 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Helpers;

trait Components {

	/**
	 * List of classes to initialize.
	 *
	 * @var array
	 */
	public $classes = array();

	/**
	 * @var array $components Array of plugin components which might need upgrade
	 */
	public static $active_classes = array();

	/**
	 * Composer autoload file list.
	 *
	 * @var \RWP\Autoloader
	 */
	protected $autoloader;


	/**
	 * @var string The plugin namespace
	 */
	protected $namespace;

	/**
	 * Groups all classes together based on their namespace
	 *
	 * @since 0.9.3
	 *
	 * @return array
	 */
	protected function extract_components() {
		$autoloader = $this->autoloader;
		$classmap  = $autoloader::get_classes_map();
		$namespace = $this->namespace . '\\';
		$components = array();

		foreach ( $classmap as $class => $file ) {

			if ( rwp_str_has( $class, '\\' ) ) {
				$component = rwp_remove_prefix( $class, $namespace );
				$component = rwp_str_replace( '\\', '.', $component );
			}

			$components = data_set( $components, $component, $class );
		}

		return $components;
	}

	/**
	 * Check if the class is a component
	 *
	 * See if a class extends Singleton and has a method called initialize
	 *
	 * @param mixed $class
	 *
	 * @return bool
	 */
	protected function is_component( $class ) {
		$rc = new \ReflectionClass( $class );

		if ( self::IsExtendsOrImplements( 'RWP\\Base\\Singleton', $class ) && ! $rc->isAbstract() && $rc->hasMethod( 'initialize' ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if a class extends or implements a specific class/interface
	 *
	 * @param string $search The class or interface name to look for
	 * @param string $class_name The class name of the object to compare to
	 *
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
	 * Get all components that need to be initialized based on the current
	 * request
	 *
	 * @access private
	 *
	 * @return void
	 */
	private function initialize_components() {
		if ( $this->blank( 'components' ) ) {
			$this->components = $this->extract_components();
		}

		$classes_to_init = new Collection();

		$internals = data_get( $this->components, 'Internals' );
		$integrations = data_get( $this->components, 'Integrations' );

		$classes_to_init = $classes_to_init->merge( $internals );
		$classes_to_init = $classes_to_init->merge( $integrations );

		if ( $this->request_is( 'rest' ) ) {
			$rest = data_get( $this->components, 'Rest' );
			$classes_to_init = $classes_to_init->merge( $rest );
		}

		if ( $this->request_is( 'ajax' ) ) {
			$ajax = data_get( $this->components, 'Ajax' );
			$classes_to_init = $classes_to_init->merge( $ajax );
		}

		if ( $this->request_is( 'backend' ) ) {
			$backend = data_get( $this->components, 'Backend' );
			$classes_to_init = $classes_to_init->merge( $backend );
		}

		if ( $this->request_is( 'frontend' ) ) {
			$frontend = data_get( $this->components, 'Frontend' );
			$classes_to_init = $classes_to_init->merge( $frontend );
		}

		$classes = $classes_to_init->flatten()->unique()->all();

		$classes = \apply_filters( 'rwp_classes_to_execute', $classes );

		foreach ( $classes as $class ) {

			if ( $this->is_component( $class ) && ! isset( $this::$active_classes[ $class ] ) ) {

				$temp = $class::instance();
				$this::$active_classes[ $class ] = $temp;
				$temp->initialize();
			}
		}
	}
}
