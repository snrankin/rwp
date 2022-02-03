<?php
/** ============================================================================
 * Query Monitor Integration
 *
 * @package   RWP\/includes/integrations/QM.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;

class QM extends Singleton {

	public $output;

	public $panels = array(
		'Info',
		'Debug',
	);

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! is_plugin_active( 'query-monitor/query-monitor.php' ) ) {
			return;
		}

		$this->title = rwp()->get_setting( 'name' );

		if ( class_exists( '\\QM_Collectors' ) ) {

			foreach ( $this->panels as $panel ) {
				$name = rwp()->prefix( $panel, ' ', 'title' );

				$collector = __NAMESPACE__ . "\\QM\\Collectors\\$panel";

				\QM_Collectors::add( new $collector( $name, $this ) );
			}
		}

		/**
		 * Register output. The filter won't run if Query Monitor is not
		 * installed so we don't have to explicity check for it.
		 */
		\add_filter( 'qm/outputter/html', array( $this, 'load' ), 101, 2 );
	}

	/**
	 * Print panel
	 *
	 * @param string         $output      The HTML code.
	 * @param \QM_Collectors $collectors  List of QM Collectors.
	 *
	 * @return array
	 */
	public function load( array $output, \QM_Collectors $collectors ) {

		foreach ( $this->panels as $panel ) {
			$name = rwp()->prefix( $panel, ' ', 'title' );
			$id = rwp_change_case( $name );

			$collector = $collectors::get( $id );
			if ( $collector ) {
				$output_class = __NAMESPACE__ . "\\QM\\Output\\$panel";
				$output[ $id ] = new $output_class( $collector, $output[ $id ], $name );
			}
		}

		return $output;
	}
	/**
	 * Debugs a variable
	 *
	 * Only visible to admins if \WP_DEBUG is on
	 *
	 * @param mixed  $var       The var to debug.
	 *
	 * @return void
	 */
	public function log( $var ) {

		$trace  = new \QM_Backtrace( array(
			'ignore_current_filter' => true,
			'ignore_frames' => 1,
		) );
		$caller = $trace->get_caller();

		$file = data_get( $caller, 'file' );
		$line = data_get( $caller, 'line' );
		$this->output['rwp-debug'][] = array(
			'variable' => $var,
			'file'     => $file,
			'line'     => $line,
		);
	}
	/**
	 * Print in Query Monitor Log panel
	 *
	 * @link https://querymonitor.com/blog/2018/07/profiling-and-logging/
	 *
	 * @param mixed  $var  The var to debug.
	 * @param string $type The error type based on Query Monitor methods.
	 *
	 * @return mixed
	 */
	public function qm_log( $var, $type ) {
		if ( \class_exists( '\\QM' ) ) {
			\QM::$type( $var );
		}
	}
	/**
	 * Timer in Query Monitor
	 *
	 * @liink https://querymonitor.com/blog/2018/07/profiling-and-logging/
	 *
	 * @param mixed  $id       Timer ID.
	 * @param string $callback The callback to profile.
	 *
	 * @return mixed
	 */
	public function qm_timer( $id, $callback ) {
		if ( \class_exists( '\\QM' ) ) {
			// Start the timer:
			\do_action( 'qm/start', $id ); // phpcs:ignore
			// Run some code
			\call_user_func( $callback );
			// Stop the timer:
			\do_action( 'qm/stop', $id ); // phpcs:ignore
		}
	}
}
