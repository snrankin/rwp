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

	public $output = array();

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

			\QM_Collectors::add( new QM\Debug( $this->title, $this ) );
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
		$id = rwp_change_case( $this->title );
		$collector = $collectors::get( $id );
		if ( $collector ) {
			$output[ $id ] = new QM\Output( $collector, $this->output, $this->title );
		}
		return $output;
	}
	/**
	 * Debugs a variable
	 *
	 * Only visible to admins if \WP_DEBUG is on
	 *
	 * @param mixed  $var       The var to debug.
	 * @param bool   $die       Whether to die after outputting.
	 * @param string $function  The function to call, usually either print_r or
	 *                          var_dump, but can be anything.
	 * @return mixed
	 */
	public function log( $var, $die = \false, $function = 'var_dump' ) {
		\ob_start();
		if ( \is_string( $var ) ) {
			echo $var . "\n"; // phpcs:ignore
		} else {
			\call_user_func( $function, $var );
		}
		if ( $die ) {
			die;
		}
		$this->output[] = \ob_get_clean();
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
