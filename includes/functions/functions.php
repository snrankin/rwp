<?php
/** ============================================================================
 * functions
 *
 * @package   RWP\functions
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

use RWP\Vendor\Exceptions\IO\Filesystem\FileNotFoundException;
use RWP\Vendor\Exceptions\IO\Filesystem\FileNotReadableException;
use RWP\Vendor\Exceptions\IO\Filesystem\NotAFileException;
use RWP\Vendor\Exceptions\IO\Filesystem\DirectoryNotFoundException;
use RWP\Vendor\Exceptions\IO\Filesystem\DirectoryNotReadableException;
use RWP\Vendor\Exceptions\Http\HttpException;


/**
 * Grab the RWP object and return it.
 * Wrapper for RWP::get_instance().
 *
 * @since  1.0.0
 * @return RWP\Engine\Base  Singleton instance of plugin class.
 */
function rwp() {
	$plugin = RWP\Engine\Base::instance();
	return $plugin;
}


// function rwp_autoloader(){
// 	if(!class_exists('RWP\\Vendor\\Symfony\\Component\\Finder\\Finder')){
// 		require_once RWP_PLUGIN_ROOT . 'includes/dependencies/vendor/symfony/finder/Finder.php';
// 	}
// 	$finder = new RWP\Vendor\Symfony\Component\Finder\Finder();

// 	$finder->files()->name('*.php')->notName('index.php')->in(RWP_PLUGIN_ROOT . 'includes')->notPath('dependencies')->notPath('functions')->notPath('backend/views');



// 	if ($finder->hasResults()) {
// 		foreach ($finder as $file) {
// 			$absoluteFilePath = $file->getRealPath();

// 			spl_autoload_register(function () use ($absoluteFilePath) {
// 				require_once $absoluteFilePath;
// 			});
// 		}
// 	}
// }


/**
 * Creates Notice.
 *
 * @param string $notice_content Notice content.
 * @param string $notice_type Notice type.
 * @param bool $dismissible Dismissible notice.
 * @param int $priority Notice priority,
 *
 * @return RWP\Vendor\WPDesk\Notice\Notice
 */
function rwp_admin_notice( $notice_content, $notice_type = 'info', $dismissible = false, $priority = 10 ) {
	return WPDeskWpNotice( $notice_content, $notice_type, $dismissible, $priority );
}

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
function rwp_get_options() {
	return apply_filters( 'rwp_get_options', get_option( RWP_PLUGIN_TEXTDOMAIN . '_options' ) );
}


/**
 *
 * @param mixed $option
 * @param mixed $default
 * @return mixed
 */
function rwp_get_option( $option, $default ) {
	$options = rwp_get_options();
	$option = data_get( $options, $option, $default );
	return apply_filters( "rwp_get_option_{$option}", $option );
}


/**
 * Hooks a single callback to multiple tags
 *
 * @param array    $tags            An array of filter tags to add the function to
 * @param callable $function        The callback to be run when the filter is applied.
 * @param int      $priority        Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action. Default 10.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 *
 * @return void
 */
function rwp_add_filters( $tags, $function, $priority = 10, $accepted_args = 1 ) {
	foreach ( (array) $tags as $tag ) {
		add_filter( $tag, $function, $priority, $accepted_args );
	}
}

/**
 * Check if a variable had value
 *
 * @param mixed $input
 *
 * @return bool
 */

function rwp_has_value( $input ) {
	return filled( $input );
}

/**
 * Access the WordPress Filesystem class
 *
 * @return WP_Filesystem_Base
 */

function rwp_filesystem() {
	/**
	 * @var WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
	 */

	global $wp_filesystem;

	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();

	return $wp_filesystem;
}

/**
 * Get file
 *
 * @param string $filename The file name or array of file names to include
 * @param string $dir      The sub-directory to look in (starting in root of plugin)
 *
 * @throws FileNotFoundException Throws error if the file is not found
 * @throws FileNotReadableException Throws error if the file is not readable
 * @throws DirectoryNotReadableException Throws error if the directory is not readable
 * @throws DirectoryNotFoundException Throws error if the directory is not found
 *
 * @return string
 */

function rwp_find_file( $filename, $dir = '' ) {
	// @phpstan-ignore-next-line
	$folder = rwp_filesystem()->search_for_folder( $dir, RWP_PLUGIN_ROOT );

	$filepath = '';
	try {
		if ( $folder ) {
			if ( rwp_filesystem()->is_readable( $folder ) ) {
				//$folder = RWP_PLUGIN_ROOT . trailingslashit( $dir );
				$file_path = $folder . $filename;
				if ( rwp_filesystem()->exists( $file_path ) ) {
					if ( rwp_filesystem()->is_readable( $file_path ) ) {
						$filepath = $file_path;
					} else {
						throw new FileNotReadableException( wp_sprintf( '%s not readable', $file_path ) );
					}
				} else {
					throw new FileNotFoundException( wp_sprintf( 'File named %s not found in %s', $filename, $folder ) );
				}
			} else {
				throw new DirectoryNotReadableException( wp_sprintf( '%s not readable', $folder ) );
			}
		} else {
			throw new DirectoryNotFoundException( wp_sprintf( 'Folder named %s not found in %s', $dir, RWP_PLUGIN_ROOT ) );
		}
	} catch ( FileNotReadableException $e ) {
		rwp_error( $e->getMessage(), 'error' );

	} catch ( NotAFileException $e ) {
		rwp_error( $e->getMessage(), 'error' );

	} catch ( FileNotFoundException $e ) {
		rwp_error( $e->getMessage(), 'error' );

	} catch ( DirectoryNotReadableException $e ) {
		rwp_error( $e->getMessage(), 'error' );

	} catch ( DirectoryNotFoundException $e ) {
		rwp_error( $e->getMessage(), 'error' );
	}

	$filepath = str_replace( '/', DIRECTORY_SEPARATOR, $filepath );

	return $filepath;
}

/**
 * Does the file exist
 *
 * @param string $filepath The file path to check
 *
 * @throws FileNotFoundException
 *
 * @return bool
 */

function rwp_file_exists( $filepath ) {

	try {
		if ( rwp_filesystem()->exists( $filepath ) ) {
			return true;
		} else {
			throw new FileNotFoundException( wp_sprintf( 'File named %s not found in %s', basename( $filepath ), dirname( $filepath ) ) );
		}
	} catch ( FileNotFoundException $e ) {
		rwp_error( $e->getMessage(), 'error' );
	}
	return false;
}


/**
 * Get file
 *
 * @param mixed  $filename The file name or array of file names to include (does not need .php at the end)
 * @param string $dir      The sub-directory to look in (starting in root of plugin)
 * @param bool   $require  True to require the file/false to include the file
 * @param bool   $once     Require/include the file only once
 *
 * @throws FileNotFoundException
 *
 * @return void
 */

function rwp_get_file( $filename, $dir = '', $require = false, $once = false ) {
	if ( is_string( $filename ) ) {
		if ( strpos( $filename, '.php' ) === false ) {
			$filename = $filename . '.php';
		}
		$file_path = rwp_find_file( $filename, $dir );
		if ( rwp_file_exists( $file_path ) ) {
			if ( $require ) {
				if ( $once ) {
					require_once $file_path;
				} else {
					require $file_path;
				}
			} else {
				if ( $once ) {
					include_once $file_path;
				} else {
					include $file_path;
				}
			}
		}
	} elseif ( is_array( $filename ) ) {
		$files = $filename;

		foreach ( $files as $file ) {
			rwp_get_file( $file, $dir, $require, $once );
		}
	}
}

/**
 * Simplified wrapper for getting json data
 *
 * @param string $url
 * @param bool   $local Whether the url is a local path
 *
 * @throws HttpException
 * @throws JsonException
 *
 * @return mixed|false
 */

function rwp_get_json_data( $url, $local = false ) {
	$url  = esc_url_raw( $url );
	$data = null;

	if ( $local ) {
		if ( rwp_file_exists( $url ) ) {
			$data = rwp_filesystem()->get_contents( $url );
		}
	} else {
		$response = wp_safe_remote_get( $url );
		try {
			if ( ! is_wp_error( $response ) ) {
				$data = wp_remote_retrieve_body( $response );
			} else {
				$code = $response->get_error_code();
				$message = $response->get_error_message( $code );
				throw new Exception( $message, $code );
			}
		} catch ( Exception $e ) {
			rwp_error( $e->getMessage(), 'error' );
		}
	}

	try {
		if ( ! empty( $data ) ) {
			$data = json_decode( $data, false, 512, JSON_THROW_ON_ERROR );

			if ( is_object( $data ) && rwp_has_value( $data ) ) {
				return $data;
			}
		}
	} catch ( JsonException $e ) {
		rwp_error( $e->getMessage(), 'error' );
	}
}
