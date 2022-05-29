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
use RWP\Components\Collection;
class Initialize {

	use Traits\Helpers;

	/**
	 * Instance of this Is_Methods.
	 *
	 * @var Is_Methods
	 */
	protected $is = null;

	/**
	 * The Constructor that load the entry classes
	 *
	 * @param ClassLoader $composer Composer autoload output.
	 * @since 1.0.0
	 */
	public function __construct( ClassLoader $composer ) {
		$this->is       = new Is_Methods();
		$this->autoloader = $composer;

		$this->initialize_autoloader();

		$classes_to_init = new Collection();

		$internals = $this->get_classes( 'Internals' );
		$integrations = $this->get_classes( 'Integrations' );

		$classes_to_init = $classes_to_init->merge( $internals );
		$classes_to_init = $classes_to_init->merge( $integrations );

		if ( $this->is->request( 'rest' ) ) {
			$rest = $this->get_classes( 'Rest' );
			$classes_to_init = $classes_to_init->merge( $rest );
		}

		if ( $this->is->request( 'ajax' ) ) {
			$ajax = $this->get_classes( 'Ajax' );
			$classes_to_init = $classes_to_init->merge( $ajax );
		}

		if ( $this->is->request( 'backend' ) ) {
			$backend = $this->get_classes( 'Backend' );
			$classes_to_init = $classes_to_init->merge( $backend );
		}

		if ( $this->is->request( 'frontend' ) ) {
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
			if ( $this->is_component( $class ) && ! isset( $this::$active_classes[ $class ] ) ) {
				$temp = $class::instance();
				$this::$active_classes[ $class ] = $temp;
				$temp->initialize();
			}
		}
	}

}
