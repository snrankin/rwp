<?php

/**
 * ============================================================================
 * RIESTER file [@TODO Fill out summary for file.php (no period for file headers)]
 *
 * [@TODO Fill out description for file.php. (use period)]
 *
 * @link [@TODO Fill out url]
 *
 * @package    WordPress
 * @subpackage RIESTER
 * @since      RIESTER 0.1.0
 * ==========================================================================
 */


use RWP\Vendor\Exceptions\IO\Filesystem\FileNotFoundException;
use RWP\Vendor\Exceptions\IO\Filesystem\FileNotReadableException;
use RWP\Vendor\Exceptions\IO\Filesystem\NotAFileException;
use RWP\Vendor\Exceptions\IO\Filesystem\DirectoryNotFoundException;
use RWP\Vendor\Exceptions\IO\Filesystem\DirectoryNotReadableException;
use RWP\Vendor\Exceptions\Http\HttpException;
use RWP\Vendor\Symfony\Component\Finder\Finder;
use \RWP\Vendor\Illuminate\Support\{Pluralizer, Str};


/**
 * Only adds a trailing slash if the string does not already have one
 *
 * @param  string $string
 * @return string
 */

function rwp_trailingslashit( $string ) {
	if ( empty( $string ) ) {
        return $string;
	}
	if ( ! Str::endsWith( $string, '/' ) ) {
		$string = Str::finish( $string, '/' );
	}

    return wp_normalize_path( $string );
}

/**
 * Get the name of a file without the extension
 *
 * @param  mixed $string
 * @return string
 */

function rwp_basename( $string ) {
     $ext = pathinfo( $string, PATHINFO_EXTENSION );
    $string = wp_basename( $string, ".$ext" );

    return $string;
}

/**
 * Simplified wrapper for getting file data
 *
 * @param string $url
 * @param bool   $local  Whether the url is a local path
 * @param string $output The output type
 *
 * @throws HttpException
 * @throws JsonException
 *
 * @return mixed|false
 */

function rwp_get_file_data( $url, $local = false, $output = 'OBJECT' ) {
    $url  = esc_url_raw( $url );
    $data = null;
    $type = pathinfo( $url, PATHINFO_EXTENSION );
	$is_array = ( 'ARRAY' === $output );

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

    if ( 'json' === $type ) {
        try {
            if ( ! empty( $data ) ) {
                $data = json_decode( $data, $is_array, 512, JSON_THROW_ON_ERROR );

                if ( filled( $data ) ) {
                    return $data;
                }
            }
        } catch ( JsonException $e ) {
            rwp_error( $e->getMessage(), 'error' );
        }
    } else {
        return $data;
    }

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

    include_once ABSPATH . '/wp-admin/includes/file.php';
    WP_Filesystem();

    return $wp_filesystem;
}

/**
 * Get file
 *
 * @param string $filename The file name or array of file names to include
 * @param string $dir      The sub-directory to look in
 * @param string $base     The folder to start searching from.
 *
 * @throws FileNotFoundException Throws error if the file is not found
 * @throws FileNotReadableException Throws error if the file is not readable
 * @throws DirectoryNotReadableException Throws error if the directory is not readable
 * @throws DirectoryNotFoundException Throws error if the directory is not found
 *
 * @return string|false
 */

function rwp_find_file( $filename, $dir = '', $base = __DIR__ ) {
    $base = rwp_trailingslashit( $base ); // only adds slash if it isn't already there

    $finder = new Finder();
    $finder->ignoreUnreadableDirs()->in( $base . $dir )->files()->name( $filename );

    $filepath = false;

    // check if there are any search results
    if ( $finder->hasResults() ) {
        foreach ( $finder as $file ) {
            $filepath = $file->getRealPath();
        }
    }

    return $filepath;
}


/**
 * Get plugin file
 *
 * @param string $filename The file name or array of file names to include
 * @param string $dir      The sub-directory to look in
 *
 * @throws FileNotFoundException Throws error if the file is not found
 * @throws FileNotReadableException Throws error if the file is not readable
 * @throws DirectoryNotReadableException Throws error if the directory is not readable
 * @throws DirectoryNotFoundException Throws error if the directory is not found
 *
 * @return string|false
 */

function rwp_find_plugin_file( $filename, $dir = '' ) {
     return rwp_find_file( $filename, $dir, RWP_PLUGIN_ROOT );
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
 * @param string $base     The folder to start searching from.
 * @param bool   $require  True to require the file/false to include the file
 * @param bool   $once     Require/include the file only once
 *
 * @throws FileNotFoundException
 *
 * @return mixed
 */

function rwp_get_file( $filename, $dir = '', $base = __DIR__, $require = false, $once = false ) {
	if ( is_string( $filename ) ) {
        $file = '';
        $type = pathinfo( $filename, PATHINFO_EXTENSION );
        if ( filter_var( $filename, FILTER_VALIDATE_URL ) == false ) {
            $filename = rwp_find_file( $filename, $dir, $base );
            if ( $filename ) {

                if ( 'php' === $type ) {
                    if ( $require ) {
                        if ( $once ) {
                            $file = include_once $filename;
                        } else {
                            $file = include $filename;
                        }
                    } else {
                        if ( $once ) {
                               $file = include_once $filename;
                        } else {
                               $file = include $filename;
                        }
                    }
                } elseif ( 'css' === $type || 'js' === $type ) {
                    $file = rwp_get_file_data( $filename, true );
                } else {
                    $file = $filename;
                }
            }
        } else {
            $file = rwp_get_file_data( $filename );
        }

        return $file;
	} elseif ( is_array( $filename ) ) {
		$files = $filename;

		foreach ( $files as $file ) {
			rwp_get_file( $file, $dir, $base, $require, $once );
		}
	}
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
 * @return mixed
 */

function rwp_get_plugin_file( $filename, $dir = '', $require = false, $once = false ) {
	if ( is_string( $filename ) ) {
        $file = '';
        $type = pathinfo( $filename, PATHINFO_EXTENSION );
        if ( filter_var( $filename, FILTER_VALIDATE_URL ) == false ) {
            $filename = rwp_find_plugin_file( $filename, $dir );
            if ( $filename ) {

                if ( 'php' === $type ) {
                    if ( $require ) {
                        if ( $once ) {
                            $file = include_once $filename;
                        } else {
                            $file = include $filename;
                        }
                    } else {
                        if ( $once ) {
                               $file = include_once $filename;
                        } else {
                               $file = include $filename;
                        }
                    }
                } elseif ( 'css' === $type || 'js' === $type ) {
                    $file = rwp_get_file_data( $filename, true );
                } else {
                    $file = $filename;
                }
            }
        } else {
            $file = rwp_get_file_data( $filename );
        }

        return $file;
	} elseif ( is_array( $filename ) ) {
		$files = $filename;

		foreach ( $files as $file ) {
			rwp_get_plugin_file( $file, $dir, $require, $once );
		}
	}
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
 * @return mixed
 */

function rwp_get_dependency_file( $filename, $dir = '', $require = false, $once = false ) {
	if ( is_string( $filename ) ) {
        $file = '';
		$base_dir = 'includes/dependencies/';
		if ( ! empty( $dir ) ) {
			$dir = rwp_add_suffix( $base_dir, $dir );
			$dir = wp_normalize_path( $dir );
		} else {
			$dir = $base_dir;
		}
		$dir = rwp_trailingslashit( $dir );
        $type = pathinfo( $filename, PATHINFO_EXTENSION );
        if ( filter_var( $filename, FILTER_VALIDATE_URL ) == false ) {
            $filename = rwp_find_plugin_file( $filename, $dir );
            if ( $filename ) {

                if ( 'php' === $type ) {
                    if ( $require ) {
                        if ( $once ) {
                            $file = include_once $filename;
                        } else {
                            $file = include $filename;
                        }
                    } else {
                        if ( $once ) {
                               $file = include_once $filename;
                        } else {
                               $file = include $filename;
                        }
                    }
                } elseif ( 'css' === $type || 'js' === $type ) {
                    $file = rwp_get_file_data( $filename, true );
                } else {
                    $file = $filename;
                }
            }
        } else {
            $file = rwp_get_file_data( $filename );
        }

        return $file;
	} elseif ( is_array( $filename ) ) {
		$files = $filename;

		foreach ( $files as $file ) {
			rwp_get_plugin_file( $file, $dir, $require, $once );
		}
	}
}
