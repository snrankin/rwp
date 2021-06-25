<?php
/** ============================================================================
 * Assets
 *
 * @package   RWP\Engine
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Engine\Traits;

use RWP\Vendor\Exceptions\IO\IOException;
use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Vendor\Exceptions\Data\NotFoundException;
use RWP\Vendor\Exceptions\Collection\EmptyException;
use RWP\Vendor\Exceptions\Collection\KeyNotFoundException;

trait Assets {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize_assets() {

		$manifest_path = $this->get_setting( 'assets_dir' ) . 'manifest.json';

		if ( rwp_file_exists( $manifest_path ) ) {
			$manifest = rwp_get_json_data( $manifest_path, true );
			if ( $manifest ) {
				$manifest = new Collection( $manifest );
				$this->set_setting( 'manifest', $manifest );
			}
		} else {
			$this->set_setting( 'manifest', false );
		}

		$this->set_setting( 'styles', rwp_collection() );
		$this->set_setting( 'scripts', rwp_collection() );

	}

	/**
	 * Gets the asset file name with support for cache busting
	 *
	 * @param string $asset   The asset file name base (including extension but
	 *                        not the plugin prefix)
	 * @param string $folder  The sub folder the asset is in
	 * @param bool   $prefix  Whether to add the plugin prefix to the asset name
	 *
	 * @return string
	 *
	 * @throws NotFoundException Thrown if manifest file exists but the asset
	 *                           does not exist in the file
	 */

	public function asset_filename( $asset, $folder = '', $prefix = true ) {

		if ( $prefix ) {
			$asset = $this->prefix( $asset, '-' );
		}

		$manifest = $this->get_setting( 'manifest' );
		if ( ! empty( $folder ) ) {
			$asset = rwp_add_prefix( $asset, $folder . DIRECTORY_SEPARATOR );
		}
		if ( $manifest ) {
			try {
				if ( $manifest->has( $asset ) ) {
					$asset = $manifest->get( $asset );
				} else {
					throw new NotFoundException( wp_sprintf( '%s not found in manifest file', $asset ) );
				}
			} catch ( NotFoundException $e ) {
				rwp_error( $e->getMessage(), 'error' );
			}
		}

		return $asset;
	}

	/**
	 * Get the absolute path of an asset
	 *
	 * @param string $asset   The asset file name base (including extension but
	 *                        not the plugin prefix)
	 * @param string $folder  The sub folder the asset is in
	 *
	 * @param bool   $prefix  Whether to add the plugin prefix to the asset name
	 *
	 * @return string|false
	 *
	 * @throws NotFoundException Thrown if manifest file exists but the asset
	 *                           does not exist in the file
	 * @throws IOException       Thrown if the file does not exist
	 */
	public function asset_path( $asset, $folder = '', $prefix = true ) {

		$asset = $this->asset_filename( $asset, $folder, $prefix );

		$path = $this->get_setting( 'assets_dir' ) . $asset;

		if ( rwp_file_exists( $path ) ) {

			return $path;

		} else {

			return false;

		}
	}

	/**
	 * Get the relative path of an asset
	 *
	 * @param string $asset   The asset file name base (including extension but
	 *                        not the plugin prefix)
	 * @param string $folder  The sub folder the asset is in
	 *
	 * @param bool   $prefix  Whether to add the plugin prefix to the asset name
	 *
	 * @return string|false
	 *
	 * @throws NotFoundException Thrown if manifest file exists but the asset
	 *                           does not exist in the file
	 * @throws IOException       Thrown if the file does not exist
	 */
	public function asset_uri( $asset, $folder = '', $prefix = true ) {

		$file = $this->asset_filename( $asset, $folder, $prefix );

		if ( $this->asset_path( $asset, $folder, $prefix ) ) {

			return $this->get_setting( 'assets_uri' ) . $file;

		} else {

			return false;

		}
	}

	/**
	 * Register plugin scripts
	 *
	 * @see  wp_register_script();
	 * @link https://developer.wordpress.org/reference/functions/wp_register_script/
	 *
	 * @param string           $handle    Name of the script. Should be unique.
	 * @param string|bool      $src       Full URL of the script, or path of the
	 *                                    script relative to the WordPress root
	 *                                    directory. If source is set to false,
	 *                                    script is an alias of other scripts it
	 *                                    depends on.
	 * @param string[]         $deps      Optional. An array of registered script
	 *                                    handles this script depends on. Default
	 *                                    empty array.
	 * @param string|bool|null $ver       Optional. String specifying script
	 *                                    version number, if it has one, which
	 *                                    is added to the URL as a query string
	 *                                    for cache busting purposes. If version
	 *                                    is set to false, a version number is
	 *                                    automatically added equal to current
	 *                                    installed WordPress version. If set to
	 *                                    null, no version is added.
	 * @param bool             $footer    Optional. Whether to enqueue the script
	 *                                    before `</body>` instead of in the
	 *                                    `<head>`. Default 'false'.
	 * @param bool|array       $localize  Optional. Is this an ajax script?
	 *                                    @see wp_localize_script(). Defaults to `
	 *                                    false`
	 * @param string           $folder    Optional. Defaults to `js/`
	 *
	 * @return void
	 *
	 * @throws NotFoundException Thrown if manifest file exists but the asset
	 *                           does not exist in the file
	 * @throws IOException       Thrown if the file does not exist
	 */

	public function register_script( $handle, $src = '', $deps = array(), $ver = false, $footer = true, $localize = false, $folder = 'js' ) {

		if ( ! is_string( $src ) || empty( $src ) ) {
			$src = $handle;
		}

		$handle = $this->prefix( $handle, '-', 'slug' );

		$src = rwp_add_suffix( $src, '.js' ); // Only adds js if it isn't already there

		if ( is_string( $src ) && ! rwp_is_url( $src ) ) { // if the source is not an external url
			$file = $this->asset_path( $src, $folder );
			$src  = $this->asset_uri( $src, $folder );
			if ( $src && empty( $ver ) ) {
				if ( $file ) {
					$ver = strval( filemtime( $file ) );
				} else {
					$ver = false;
				}
			}
		}
		if ( ! empty( $src ) ) {
			\wp_register_script( $handle, $src, $deps, $ver, $footer );
			if ( is_array( $localize ) && rwp_has_value( $localize ) ) {
				foreach ( $localize as $key => $value ) {
					$localize[ $key ]['ajaxurl'] = admin_url( 'admin-ajax.php' );
					\wp_localize_script( $handle, $key, $value );
				}
			}
		}
	}

	/**
	 * Get all plugin scripts for a certain location
	 * @param string  $location  The location to register scripts for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 * @return Collection|false
	 * @throws KeyNotFoundException
	 */

	public function get_plugin_scripts( $location = '' ) {

		$scripts = $this->get_setting( 'assets.scripts' );

		try {
			if ( rwp_has_value( $scripts ) ) {
				$scripts = rwp_collection( $scripts )->whereIn( 'location', array( 'global', $location ) );

				if ( $scripts->isEmpty() ) {
					$scripts = false;
					throw new EmptyException( __( 'There are no scripts to register', 'rwp' ) );
				}
			} else {
				$scripts = false;
			}
		} catch ( EmptyException $th ) {
			rwp_error( $th->getMessage(), 'notice' );
		}

		return $scripts;

	}

	/**
	 * Register all plugin scripts for a certain location
	 *
	 * @param string  $location  The location to register scripts for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 * @return void
	 */

	public function register_scripts( $location = '' ) {
		/**
		 * @var false|Collection $scripts
		 */
		$scripts = $this->get_plugin_scripts( $location );

		$this->set_setting( 'scripts', $scripts );

		if ( $scripts ) {
			$scripts->map( function ( $item ) {
				call_user_func_array( array( $this, 'register_script' ), $item );
			});
		}
	}

	/**
	 * Enqueue all plugin scripts for a certain location
	 *
	 * @param string  $location  The location to register scripts for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 * @return void
	 */


	public function enqueue_scripts( $location = '' ) {

		/**
		 * @var false|Collection $scripts
		 */
		$scripts = $this->get_plugin_scripts( $location );

		if ( $scripts ) {
			$scripts->keys()->map(function ( $item ) {
				$item = rwp_add_prefix( $item, RWP_PLUGIN_TEXTDOMAIN . '-' );
				wp_enqueue_script( $item );
			});
		}
	}

	/**
	 * Register plugin style
	 *
	 * @see  wp_register_style();
	 * @link https://developer.wordpress.org/reference/functions/wp_register_style/
	 *
	 * @param string           $handle  Name of the stylesheet. Should be unique.
	 * @param string|bool      $src     Full URL of the stylesheet, or path of
	 *                                  the stylesheet relative to the WordPress
	 *                                  root directory. If source is set to
	 *                                  false, stylesheet is an alias of other
	 *                                  stylesheets it depends on.
	 * @param string[]         $deps    Optional. An array of registered
	 *                                  stylesheet handles this stylesheet
	 *                                  depends on. Default empty array.
	 * @param string|bool|null $ver     Optional. String specifying stylesheet
	 *                                  version number, if it has one, which is
	 *                                  added to the URL as a query string for
	 *                                  ache busting purposes. If version is set
	 *                                  to false, a version number is
	 *                                  automatically added equal to current
	 *                                  installed WordPress version. If set to
	 *                                  null, no version is added.
	 * @param string           $media   Optional. The media for which this
	 *                                  stylesheet has been defined. Default
	 *                                  'all'. Accepts media types like 'all',
	 *                                  print' and 'screen', or media queries
	 *                                  like '(orientation: portrait)' and
	 *                                  (max-width: 640px)'.
	 * @param string           $folder  Optional. The subfolder where the asset
	 *                                  resides. Defaults to `css/`
	 * @return void
	 */

	public function register_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all', $folder = 'css' ) {

		if ( ! is_string( $src ) || empty( $src ) ) {
			$src = $handle;
		}

		$handle = $this->prefix( $handle, '-' );

		$src = rwp_add_suffix( $src, '.css' ); // Only adds js if it isn't already there

		if ( is_string( $src ) && ! rwp_is_url( $src ) ) { // if the source is not an external url
			$file = $this->asset_path( $src, $folder );
			$src  = $this->asset_uri( $src, $folder );

			if ( $src && empty( $ver ) ) {
				if ( $file ) {
					$ver = strval( filemtime( $file ) );
				}
			} else {
				$ver = false;
			}
		}
		if ( ! empty( $src ) ) {
			wp_register_style( $handle, $src, $deps, $ver, $media );
		}
	}

	/**
	 * Get all plugin styles for a certain location
	 * @param string  $location  The location to register styles for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 * @return Collection|false
	 * @throws KeyNotFoundException
	 */

	public function get_plugin_styles( $location = '' ) {

		$styles = $this->get_setting( 'assets.styles' );

		try {
			if ( rwp_has_value( $styles ) ) {
				$styles = rwp_collection( $styles )->whereIn( 'location', array( 'global', $location ) );

				if ( $styles->isEmpty() ) {
					$styles = false;
					throw new EmptyException( __( 'There are no styles to register', 'rwp' ) );
				}
			} else {
				$styles = false;
			}
		} catch ( EmptyException $th ) {
			rwp_error( $th->getMessage(), 'notice' );
		}

		return $styles;

	}

	/**
	 * Register all plugin styles for a certain location
	 *
	 * @param string  $location  The location to register styles for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 * @return void
	 */
	public function register_styles( $location = '' ) {

		$styles = $this->get_plugin_styles( $location );

		if ( $styles ) {
			$styles->map(function ( $item ) {
				call_user_func_array( array( $this, 'register_style' ), $item );
			});
		}
	}

	/**
	 * Enqueue all plugin styles for a certain location
	 *
	 * @param string  $location  The location to register styles for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 * @return void
	 */


	public function enqueue_styles( $location = '' ) {

		/**
		 * @var false|Collection $styles
		 */
		$styles = $this->get_plugin_styles( $location );

		if ( $styles ) {
			$styles->keys()->map(function ( $item ) {
				$item = rwp_add_prefix( $item, RWP_PLUGIN_TEXTDOMAIN . '-' );
				wp_enqueue_style( $item );
			});
		}
	}

	/**
	 * Register all assets for a specific location
	 * @param string  $location  The location to register styles for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 *
	 * @return void
	 */

	public function register_assets( $location = '' ) {
		$this->register_scripts( $location );
		$this->register_styles( $location );
	}

	/**
	 * Enqueue all assets for a specific location
	 *
	 * @param string  $location  The location to register styles for. Default
	 *                           empty string. Accepts options like 'global',
	 *                           'admin' and 'public'. Can be any custom location.
	 *
	 * @return void
	 */

	public function enqueue_assets( $location = '' ) {
		$this->enqueue_scripts( $location );
		$this->enqueue_styles( $location );
	}

}
