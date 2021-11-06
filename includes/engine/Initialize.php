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

namespace RWP\Engine;

use RWP\Engine\Is_Methods;
use Composer\Autoload\ClassLoader;

class Initialize {

	/**
	 * List of classes to initialize.
	 *
	 * @var array
	 */
	public $classes = array();

	/**
	 * Instance of this Is_Methods.
	 *
	 * @var Is_Methods
	 */
	protected $is = null;

	/**
	 * Composer autoload file list.
	 *
	 * @var ClassLoader
	 */
	private $composer;

	/**
	 * The Constructor that load the entry classes
	 *
	 * @param ClassLoader $composer Composer autoload output.
	 * @since 1.0.0
	 */
	public function __construct( ClassLoader $composer ) {
		$this->is       = new Is_Methods();
		$this->composer = $composer;

		$this->get_classes( 'Internals' );
		$this->get_classes( 'Integrations' );

		if ( $this->is->request( 'rest' ) ) {
			$this->get_classes( 'Rest' );
		}

		if ( $this->is->request( 'ajax' ) ) {
			$this->get_classes( 'Ajax' );
		}

		if ( $this->is->request( 'backend' ) ) {
			$this->get_classes( 'Backend' );
		}

		if ( $this->is->request( 'frontend' ) ) {
			$this->get_classes( 'Frontend' );
		}

		$this->load_classes();
	}

	/**
	 * Initialize all the classes.
	 *
	 * @since 1.0.0
	 */
	private function load_classes() {
		$this->classes = \apply_filters( 'rwp_classes_to_execute', $this->classes );

		foreach ( $this->classes as $class ) {
			try {
				$temp = $class::instance();
				$temp->initialize();
			} catch ( \Throwable $err ) {
				\do_action( 'rwp_initialize_failed', $err );

				if ( \WP_DEBUG ) {
					throw new \Exception( $err->getMessage() );
				}
			}
		}
	}

	/**
	 * Based on the folder loads the classes automatically using the Composer autoload to detect the classes of a Namespace.
	 *
	 * @param string $namespace Class name to find.
	 * @since 1.0.0
	 * @return array Return the classes.
	 */
	private function get_classes( string $namespace ) {
		$prefix    = $this->composer->getPrefixesPsr4();
		$classmap  = $this->composer->getClassMap();
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
