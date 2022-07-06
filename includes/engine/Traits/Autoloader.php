<?php
/** ============================================================================
 * Autoloader
 *
 * @package   RWP\/includes/engine/Traits/Autoloader.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2022 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Engine\Traits;

use Composer\Autoload\ClassLoader;

trait Autoloader {

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
	 * @var ClassLoader
	 */
	protected $autoloader;


	/**
	 * @var string The plugin namespace
	 */
	protected $namespace;

	/**
	 * Based on the folder loads the classes automatically using the Composer autoload to detect the classes of a Namespace.
	 *
	 * @param string $namespace Class name to find.
	 * @since 0.9.0
	 * @return void
	 */
	protected function initialize_autoloader() {
		$autoloader = $this->autoloader;
		$prefix    = $autoloader->getPrefixesPsr4();
		$classmap  = $autoloader->getClassMap();
		$namespace = $this->namespace;

		$class_loader = array();

		$class = __CLASS__;

		// In case composer has autoload optimized
		if ( isset( $classmap[ __CLASS__ ] ) ) {
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
			$class_loader = rwp_array_remove( $class_loader, $class );
			unset( $class_loader[ $class ] );
			if ( rwp_str_has( $class, '\\' ) ) {
				$component = rwp_remove_prefix( $class, $namespace );
				$component = rwp_str_replace( '\\', '.', $component );
			}

			$components = data_set( $components, $component, $class );
		}

		$this->components = $components;

	}


	/**
	 * Based on the folder loads the classes automatically using the Composer autoload to detect the classes of a Namespace.
	 *
	 * @param string $namespace Class name to find.
	 * @since 0.9.0
	 * @return array Return the classes.
	 */
	protected function get_classes( string $namespace ) {
		$prefix    = $this->autoloader->getPrefixesPsr4();
		$classmap  = $this->autoloader->getClassMap();
		$namespace = $this->namespace . '\\' . $namespace;

		// In case composer has autoload optimized
		if ( isset( $classmap['RWP\\Engine\\Plugin'] ) ) {
			$classes = \array_keys( $classmap );

			foreach ( $classes as $class ) {
				if ( 0 !== \strncmp( (string) $class, $namespace, \strlen( $namespace ) ) ) {
					continue;
				}

				$this->classes[] = $class;
			}

			return $this->classes;
		}

		$namespace .= '\\';

		// In case composer is not optimized
		if ( isset( $prefix[ $namespace ] ) ) {
			$folder    = $prefix[ $namespace ][0];
			$php_files = $this->scandir( $folder );
			$this->find_classes( $php_files, $folder, $namespace );

			if ( ! WP_DEBUG ) {
				\wp_die( \esc_html__( 'RWP is on production environment with missing `composer dumpautoload -o` that will improve the performance on autoloading itself.', 'rwp' ) );
			}

			return $this->classes;
		}

		return $this->classes;
	}

	/**
	 * Get php files inside the folder/subfolder that will be loaded.
	 * This class is used only when Composer is not optimized.
	 *
	 * @param string $folder Path.
	 * @since 0.9.0
	 * @return array List of files.
	 */
	protected function scandir( string $folder ) {
		$temp_files = \scandir( $folder );
			$files  = array();

		if ( \is_array( $temp_files ) ) {
			$files = $temp_files;
		}

		return \array_diff( $files, array( '..', '.', 'index.php' ) );
	}

	protected function is_component( $class ) {
		$rc = new \ReflectionClass( $class );

		if ( self::IsExtendsOrImplements( 'RWP\\Engine\\Abstracts\\Singleton', $class ) && $rc->hasMethod( 'initialize' ) ) {
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
    public static function IsExtendsOrImplements( $search, $class_name ) {
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
	 * Load namespace classes by files.
	 *
	 * @param array  $php_files List of files with the Class.
	 * @param string $folder Path of the folder.
	 * @param string $base Namespace base.
	 * @since 0.9.0
	 */
	protected function find_classes( array $php_files, string $folder, string $base ) {
		foreach ( $php_files as $php_file ) {
			$class_name = \substr( $php_file, 0, -4 );
			$path       = $folder . '/' . $php_file;

			if ( \is_file( $path ) ) {
				$this->classes[] = $base . $class_name;

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
			$this->find_classes( $sub_php_files, $folder . '/' . $php_file, $base . $php_file . '\\' );
		}
	}

}
