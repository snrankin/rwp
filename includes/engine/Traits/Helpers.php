<?php
/** ============================================================================
 * Helpers
 *
 * @package   RWP\/includes/engine/Traits/Helpers.php
<<<<<<< HEAD
 * @since     1.0.1
=======
 * @since     0.9.0
>>>>>>> release/v0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2022 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Engine\Traits;

<<<<<<< HEAD
use Composer\Autoload\ClassLoader;

trait Helpers {

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
	 * Based on the folder loads the classes automatically using the Composer autoload to detect the classes of a Namespace.
	 *
	 * @param string $namespace Class name to find.
	 * @since 1.0.0
	 * @return void
	 */
	protected function initialize_autoloader() {
		$autoloader = $this->autoloader;
		$prefix    = $autoloader->getPrefixesPsr4();
		$classmap  = $autoloader->getClassMap();
		$namespace = 'RWP';

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
	 * @since 1.0.0
	 * @return array Return the classes.
	 */
	protected function get_classes( string $namespace ) {
		$prefix    = $this->autoloader->getPrefixesPsr4();
		$classmap  = $this->autoloader->getClassMap();
		$namespace = 'RWP\\' . $namespace;

		// In case composer has autoload optimized
		if ( isset( $classmap['RWP\\Engine\\Initialize'] ) ) {
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
	 * @since 1.0.0
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
=======
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
>>>>>>> release/v0.9.0
		} else {
			return false;
		}
	}

	/**
<<<<<<< HEAD
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
	 * @since 1.0.0
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

=======
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

>>>>>>> release/v0.9.0
}
