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

use RWP\Integrations\QM\Output\Debug;

class QM extends Singleton {

	/**
	 * @var string|false|null
	 */
	protected static $file_link_format = null;

	public $output = [];

	public $panels = array(
		'Debug',
		'Info',
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

		self::$file_link_format = self::get_file_link_format();

		if ( class_exists( '\\QM_Collectors' ) ) {
			$class = get_called_class();

			foreach ( $this->panels as $panel ) {

				$collector = rwp()->get_component( "$class\\Collectors\\$panel" );
				/**
				 * @var \RWP\Engine\Abstracts\Collector $collector
				 */
				$collector = new $collector( $this, $panel );

				\QM_Collectors::add( $collector );
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
			$id = rwp()->prefix( $panel );
			$class = get_called_class();
			$collector = $collectors::get( $id );
			if ( $collector ) {
				/**
				 * @var \RWP\Engine\Abstracts\DebugOutput $output_class
				 */
				$output_class = rwp()->get_component( "$class\\Output\\$panel" );
				$output_class = new $output_class( $collector, $this, $panel );
				$output[ $id ] = $output_class;
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
		$class = get_called_class();
		$trace  = new \QM_Backtrace( array(

			'ignore_class' => array( $class => true ),
		) );
		$caller = $trace->get_caller();

		$file = data_get( $caller, 'file' );
		$line = data_get( $caller, 'line' );
		$link_text = wp_basename( $file );

		$file = self::output_filename( $link_text, $file, $line, true );

		$this->output['rwp_debug'][] = array(
			'variable' => $var,
			'line'     => $line,
			'file'     => $file,

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

	/**
	 * Provides a protocol URL for edit links in QM stack traces for various editors.
	 *
	 * @param string $editor the chosen code editor
	 * @param string $default_format a format to use if no editor is found
	 *
	 * @return string a protocol URL format
	 */
	public static function get_editor_file_link_format( $editor, $default_format ) {
		switch ( $editor ) {
			case 'phpstorm':
				return 'phpstorm://open?file=%f&line=%l';
			case 'vscode':
				return 'vscode://file/%f:%l';
			case 'atom':
				return 'atom://open/?url=file://%f&line=%l';
			case 'sublime':
				return 'subl://open/?url=file://%f&line=%l';
			case 'textmate':
				return 'txmt://open/?url=file://%f&line=%l';
			case 'netbeans':
				return 'nbopen://%f:%l';
			default:
				return $default_format;
		}
	}

	/**
	 * @return string|false
	 */
	public static function get_file_link_format() {
		if ( ! isset( self::$file_link_format ) ) {
			$format = ini_get( 'xdebug.file_link_format' );

			$editor = '';

			if ( defined( 'QM_EDITOR_COOKIE' ) ) {
				$editor = QM_EDITOR_COOKIE;
			} else if ( isset( $_COOKIE['QM_EDITOR_COOKIE'] ) ) {
				$editor = data_get( $_COOKIE, 'QM_EDITOR_COOKIE' );
			}

			$format = self::get_editor_file_link_format(
				$editor,
				$format
			);

			/**
			 * Filters the clickable file link format.
			 *
			 * @link https://querymonitor.com/blog/2019/02/clickable-stack-traces-and-function-names-in-query-monitor/
			 * @since 3.0.0
			 *
			 * @param string|false $format The format of the clickable file link, or false if there is none.
			 */
			$format = apply_filters( 'qm/output/file_link_format', $format ); //phpcs:ignore
			if ( empty( $format ) ) {
				self::$file_link_format = false;
			} else {
				self::$file_link_format = str_replace( array( '%f', '%l' ), array( '%1$s', '%2$d' ), $format );
			}
		}

		return self::$file_link_format;
	}

	/**
	 * Returns a file path, name, and line number, or a clickable link to the file. Safe for output.
	 *
	 * @link https://querymonitor.com/blog/2019/02/clickable-stack-traces-and-function-names-in-query-monitor/
	 *
	 * @param  string $text        The display text, such as a function name or file name.
	 * @param  string $file        The full file path and name.
	 * @param  int    $line        Optional. A line number, if appropriate.
	 * @param  bool   $is_filename Optional. Is the text a plain file name? Default false.
	 * @return string The fully formatted file link or file name, safe for output.
	 */
	public static function output_filename( $text, $file, $line = 0, $is_filename = false ) {
		if ( empty( $file ) ) {
			if ( $is_filename ) {
				return esc_html( $text );
			} else {
				return '<code>' . esc_html( $text ) . '</code>';
			}
		}

		$link_line = ( $line ) ? $line : 1;

		if ( ! ( false !== self::get_file_link_format() ) ) {
			$fallback = rwp_standard_dir( $file, '' );
			if ( $line ) {
				$fallback .= ':' . $line;
			}
			if ( $is_filename ) {
				$return = esc_html( $text );
			} else {
				$return = '<code>' . esc_html( $text ) . '</code>';
			}
			if ( $fallback !== $text ) {
				$return .= '<br><span class="qm-info qm-supplemental">' . esc_html( $fallback ) . '</span>';
			}
			return $return;
		}

		$map = apply_filters( 'qm/output/file_path_map', array() ); //phpcs:ignore

		if ( ! empty( $map ) ) {
			foreach ( $map as $from => $to ) {
				$file = str_replace( $from, $to, $file );
			}
		}

		$link = sprintf( self::get_file_link_format(), rawurlencode( $file ), intval( $link_line ) );

		if ( $is_filename ) {
			$format = '<a href="%s" class="qm-edit-link">%s</a>';
		} else {
			$format = '<a href="%s" class="qm-edit-link"><code>%s</code></a>';
		}

		return sprintf(
			$format,
			esc_attr( $link ),
			esc_html( $text )
		);
	}
}
