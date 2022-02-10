<?php
/** ============================================================================
 * RIESTERWP Initializer
 *
 * @package   RWP\Engine
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Traits;

use RWP\Vendor\Illuminate\Container\Container;
use RWP\Engine\Abstracts\Singleton;
use Composer\Autoload\ClassLoader;
use RWP\Components\Collection;

trait Initialize {

	/**
	 * @var Container $app The settings of the plugin.
	 */
	public $app;

    /**
	 * @var array $components Array of plugin components which might need upgrade
	 */
    public static $active_classes = array();

	 /**
	 * @var array $components Array of plugin components which might need upgrade
	 */
    public static $components = array();

	/**
	 * @var ClassLoader
	 */
    public static $autoloader;

	/**
	 * @var array
	 */
    public static $classes;

	/**
	 * The Constructor that load the entry classes
	 *
	 * @since 1.0.0
	 */
	public function initialize_classes() {

		$classes_to_init = new Collection();

		$internals = $this->get_classes( 'Internals' );
		$integrations = $this->get_classes( 'Integrations' );

		$classes_to_init = $classes_to_init->merge( $internals );
		$classes_to_init = $classes_to_init->merge( $integrations );

		if ( $this->request( 'rest' ) ) {
			$rest = $this->get_classes( 'Rest' );
			$classes_to_init = $classes_to_init->merge( $rest );
		}

		if ( $this->request( 'ajax' ) ) {
			$ajax = $this->get_classes( 'Ajax' );
			$classes_to_init = $classes_to_init->merge( $ajax );
		}

		if ( $this->request( 'backend' ) ) {
			$backend = $this->get_classes( 'Backend' );
			$classes_to_init = $classes_to_init->merge( $backend );
		}

		if ( $this->request( 'frontend' ) ) {
			$frontend = $this->get_classes( 'Frontend' );
			$classes_to_init = $classes_to_init->merge( $frontend );
		}

		$classes_to_init = $classes_to_init->flatten()->unique()->all();

		$this->load_classes( $classes_to_init );
	}

	/**
	 * Initialize all the classes.
	 *
	 * @since 1.0.0
	 */
	private function load_classes( $classes = array() ) {
		$classes = \apply_filters( 'rwp_classes_to_execute', $classes );

		foreach ( $classes as $class ) {
			$temp = data_get( $this::$active_classes, $class, $class::instance() );

			if ( $temp->is_component() && ! isset( $this::$active_classes[ $class ] ) ) {
				//$this->app->bindIf( $class );
				$this::$active_classes[ $class ] = $temp;
				$temp->initialize();
			}
		}
	}

	private function is_component( $class ) {
		$rc = new \ReflectionClass( $class );

		if ( $this->IsExtendsOrImplements( 'RWP\\Engine\\Abstracts\\Singleton', $class ) && $rc->hasMethod( 'initialize' ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
     * Check if a class extends or implements a specific class/interface
     * @param string $search The class or interface name to look for
     * @param string $class_name The class name of the object to compare to
     * @return bool
     */
    public function IsExtendsOrImplements( $search, $class_name ) {
        $class = new \ReflectionClass( $class_name );
        if ( false === $class ) {
            return false;
        }
        do {
            $name = $class->getName();
            if ( $search == $name ) {
                return true;
            }
            $interfaces = $class->getInterfaceNames();
            if ( is_array( $interfaces ) && in_array( $search, $interfaces ) ) {
                return true;
            }
            $class = $class->getParentClass();
        } while ( false !== $class );
        return false;
    }

	/**
	 * Based on the folder loads the classes automatically using the Composer autoload to detect the classes of a Namespace.
	 *
	 * @param string $namespace Class name to find.
	 * @since 1.0.0
	 * @return array Return the classes.
	 */
	private function initialize_autoloader() {
		$autoloader = $this->autoloader;
		$prefix    = $autoloader->getPrefixesPsr4();
		$classmap  = $autoloader->getClassMap();
		$namespace = $this->get( 'namespace' );

		$class_loader = array();

		// In case composer has autoload optimized
		if ( isset( $classmap['RWP\\Engine\\Plugin'] ) ) {
			$classes = \array_keys( $classmap );

			foreach ( $classes as $class ) {
				if ( 0 !== \strncmp( (string) $class, $namespace, \strlen( $namespace ) ) ) {
					continue;
				}

				$class_loader[] = $class;
			}
		}

		$namespace .= '\\';

		// In case composer is not optimized
		if ( isset( $prefix[ $namespace ] ) ) {
			$folder    = $prefix[ $namespace ][0];
			$php_files = $this->scandir( $folder );
			$class_loader = $this->find_classes( $php_files, $folder, $namespace );

			if ( ! WP_DEBUG ) {
				\wp_die( \esc_html__( 'RWP is on production environment with missing `composer dumpautoload -o` that will improve the performance on autoloading itself.', 'rwp' ) );
			}
		}

		$components = array();

		foreach ( $class_loader as $class ) {
			if ( rwp_str_has( $class, '\\' ) ) {
				$component = rwp_remove_prefix( $class, $namespace );
				$component = rwp_str_replace( '\\', '.', $component );
			}

			$components = data_set( $components, $component, $class );
		}

		$this->set( 'classes', $components );
	}

	/**
	 * Based on the folder loads the classes automatically using the Composer autoload to detect the classes of a Namespace.
	 *
	 * @param string $classes Class name to find.
	 * @since 1.0.0
	 * @return array Return the classes.
	 */
	public function get_classes( string $classes = '' ) {

		if ( rwp_str_has( $classes, '\\' ) ) {
			$classes = rwp_str_replace( '\\', '.', $classes );
		}
		$classes = rwp_str_replace( 'RWP.', '', $classes );
		return $this->get( "classes.$classes" );
	}


	/**
	 * Get php files inside the folder/subfolder that will be loaded.
	 * This class is used only when Composer is not optimized.
	 *
	 * @param string $folder Path.
	 * @since 1.0.0
	 * @return array List of files.
	 */
	private function scandir( string $folder ) {
		$temp_files = \scandir( $folder );
			$files  = array();

		if ( \is_array( $temp_files ) ) {
			$files = $temp_files;
		}

		return \array_diff( $files, array( '..', '.', 'index.php' ) );
	}

	/**
	 * Load namespace classes by files.
	 *
	 * @param array  $php_files List of files with the Class.
	 * @param string $folder Path of the folder.
	 * @param string $base Namespace base.
	 * @since 1.0.0
	 */

	private function find_classes( array $php_files, string $folder, string $base ) {
		$class_loader = array();
		foreach ( $php_files as $php_file ) {
			$class_name = \substr( $php_file, 0, -4 );
			$path       = $folder . '/' . $php_file;

			if ( \is_file( $path ) ) {
				$class_loader[] = $base . $class_name;

				continue;
			}

			// Verify the Namespace level
			if ( \substr_count( $base . $class_name, '\\' ) < 2 ) {
				continue;
			}

			if ( ! \is_dir( $path ) || \strtolower( $php_file ) === $php_file ) {
				continue;
			}

			$sub_php_files = $this->scandir( $folder . '/' . $php_file );
			$sub_class_loader = $this->find_classes( $sub_php_files, $folder . '/' . $php_file, $base . $php_file . '\\' );

			$class_loader = array_unique( array_merge( $class_loader, $sub_class_loader ) );
		}
		return $class_loader;
	}

}
