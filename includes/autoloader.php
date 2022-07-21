<?php
/** ============================================================================
 * RWP autoloader.
 *
 * RWP autoloader handler class is responsible for loading the different
 * classes needed to run the plugin.
 *
 * @package RWP
 *
 * @since 0.9.3
 * ========================================================================== */

namespace RWP;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Autoloader {

	/**
	 * Classes map.
	 *
	 * Maps Elementor classes to file names.
	 *
	 * @since 1.6.0
	 * @access private
	 * @static
	 *
	 * @var array Classes used by elementor.
	 */
	private static $classes_map;

	/**
	 * Default path for autoloader.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * Default namespace for autoloader.
	 *
	 * @var string
	 */
	private static $namespace;

	/**
	 * Autoloader instance
	 *
	 * @var self $instance
	 */
	private static $instance;

	private static $path_mappings = array();

	/**
	 * Getting a singleton.
	 *
	 * @return Singleton
	 */
	final public static function instance() {

		if ( empty( self::$instance ) ) {
			$args = \func_get_args();

			self::$instance = new self( ...$args );
		}

		return self::$instance;
	}

	/**
	 * Run autoloader.
	 *
	 * Register a function as `__autoload()` implementation.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 */
	public static function run( $dir = '', $namespace = '' ) {

		$autoloader = self::instance( $dir, $namespace );

		spl_autoload_register( [ $autoloader, 'autoload' ] );
	}

	public static function get_classes_map() {
		if ( ! self::$classes_map ) {
			self::init_classes_map();
		}

		return self::$classes_map;
	}

	public static function namespaced_name( $str ) {

		$path = explode( DIRECTORY_SEPARATOR, $str );
		$path = \array_filter($path, function ( $segment ) {
			return ! empty( $segment ) && 'includes' !== $segment;
		});
		$path = array_map( 'ucwords', $path );
		if ( false === array_search( self::$namespace, $path, true ) ) {
			array_unshift( $path, self::$namespace );
		}
		$path = join( '\\', $path );

		return $path;
	}

	private static function extract_files( &$files, $file, $parent = '' ) {

		if ( is_array( $file ) ) {

			$namepace = '';
			if ( ! empty( $parent ) ) {
				$parent = trailingslashit( $parent );
				$namepace = self::namespaced_name( $parent );
			}

			$name = $file['name'];
			if ( 'index.php' === $name ) {
				unset( $files[ $name ] );
				return $files;
			}
			$path = "$parent$name";
			if ( isset( $file['type'] ) && 'd' === $file['type'] && ! empty( $file['files'] ) ) {
				$sub_files = array();

				foreach ( $file['files'] as $key => $value ) {
					$value['parent'] = $path;

					$sub_files = self::extract_files( $file['files'], $value, $path );
				}
				unset( $files[ $name ] );
				$files = array_merge( $files, $sub_files );
			} else {
				unset( $files[ $name ] );
				$class_name = \wp_basename( $path, '.php' );
				$class_name = self::normalize_class_name( $class_name );
				$class_name = $namepace . '\\' . $class_name;

				if ( strpos( $path, self::$dir ) === false ) {
					$path = wp_normalize_path( trailingslashit( self::$dir ) . $path );
				}
				$files[ $class_name ] = $path;
			}
		}
		return $files;
	}

	private static function init_classes_map() {

		$folder = self::$dir;

		self::$classes_map = self::find_classes( $folder );

		return self::$classes_map;
	}


	/**
	 * Normalize Class Name
	 *
	 * Used to convert control names to class names.
	 *
	 * @param $string
	 * @param string $delimiter
	 *
	 * @return mixed
	 */
	private static function normalize_class_name( $string, $delimiter = ' ' ) {
		return ucwords( str_replace( '-', '_', $string ), $delimiter );
	}

	/**
	 * Load namespace classes by files.
	 *
	 * @param string $folder Path of the folder.
	 * @since 0.9.0
	 */
	protected static function find_classes( string $folder ) {

		/**
		 * @var WP_Filesystem_Direct $wp_filesystem WordPress filesystem subclass.
		 */

		global $wp_filesystem;

		include_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();

		$temp_files = $wp_filesystem->dirlist( $folder, false, true );
		$files = array();

		if ( \is_array( $temp_files ) ) {
			$files = $temp_files;
		}

		$files = \array_filter($files, function ( $key ) {
			return ! in_array( $key, array( 'index.php', basename( __FILE__ ) ), true );
		}, \ARRAY_FILTER_USE_KEY);

		foreach ( $files as $key => $value ) {
			self::extract_files( $files, $value );
		}

		ksort( $files );

		return $files;
	}

	/**
	 * Load class.
	 *
	 * For a given class name, require the class file.
	 *
	 * @since 1.6.0
	 * @access private
	 * @static
	 *
	 * @param string $relative_class_name Class name.
	 */
	private static function load_class( $relative_class_name ) {
		$classes_map = self::get_classes_map();

		if ( isset( $classes_map[ $relative_class_name ] ) ) {
			$filename = $classes_map[ $relative_class_name ];
		} else {
			$filename = strtolower(
				preg_replace(
					[ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$relative_class_name
				)
			);

			$filename = self::$dir . $filename . '.php';
		}

		if ( is_readable( $filename ) ) {
			require $filename;
		}
	}

	/**
	 * Autoload.
	 *
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.6.0
	 * @access private
	 * @static
	 *
	 * @param string $class Class name.
	 */
	private static function autoload( $class ) {
		if ( 0 !== strpos( $class, self::$namespace . '\\' ) ) {
			return;
		}

		if ( ! class_exists( $class ) ) {
			self::load_class( $class );
		}
	}

	/**
	 * Consctruct.
	 * Private to avoid "new".
	 *
	 * @access
	 */
	private function __construct( $dir = '', $namespace = '' ) {
		if ( '' === $dir ) {
			$dir = __DIR__;
		}

		if ( '' === $namespace ) {
			$namespace = __NAMESPACE__;
		}

		self::$dir = $dir;
		self::$namespace = $namespace;

		$folder = self::$dir;

		self::$classes_map = self::find_classes( $folder );
	}

	/**
	 * Avoid clone instance
	 */
	private function __clone() {
	}
}
