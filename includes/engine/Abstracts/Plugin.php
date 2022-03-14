<?php
/** ============================================================================
 * Plugin
 *
 * @package   RWP\/includes/engine/Plugin.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

use RWP\Engine\Interfaces\Component;
use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Collection;
use RWP\Components\Str;

abstract class Plugin extends Singleton implements Component {

    /**
	 * @var string $file Absolute path to plugin main file
	 * @access private
	 */
    public $file;

    /**
	 * @var string $version Current plugin version
	 * @access public
	 */
    public $version = '';

    /**
	 * @var array $components Array of plugin components which might need upgrade
	 * @access public
	 */
    public static $components = [];

	/**
	 * @var ClassLoader
	 * @access public
	 */
    public static $autoloader;

	/**
	 * @var array
	 * @access public
	 */
    public static $classes;

	/**
	 * @var array $settings The settings of the plugin.
	 */
	public $settings = array();

	/**
	 * @var array|Collection $options The option keys available in the database
	 */
	public $options = array();

	/**
	 * @var array $paths An array of paths for various folders for easy access
	 */
	public $paths = array();

    /**
     *  @inheritdoc
     */
    public function __construct( $args = array() ) {

        $this->set( $args );

		// Activate plugin when new blog is added
		\add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );
        \register_activation_hook( $this->get_plugin_file(), array( $this, 'activate' ) );
        \register_deactivation_hook( $this->get_plugin_file(), array( $this, 'deactivate' ) );
        \register_uninstall_hook( $this->get_plugin_file(), array( __CLASS__, 'uninstall' ) );
        \add_action( 'admin_init', array( $this, 'maybe_upgrade' ) );
        \add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

        parent::__construct();

		$this->initialize_settings();
		$this->initialize_configs();
    }

	public function initialize_configs() {

		$root    = $this->get_plugin_dir( 'config' );
        $configs = glob( $root . '*.php' );

		if ( $configs ) {
			foreach ( $configs as $config ) {
				$configname = rwp_basename( $config );
				$config = include_once $config;
				$this->set( $configname, $config );
			}
		}
	}

	/**
	 * Initializes the plugin settings
	 *
	 * @return void
	 */

	public function initialize_settings() {
		$meta = \get_plugin_data( $this->get_plugin_file(), false );

		$settings = new Collection( \wp_parse_args( $this->settings, $meta ) );

		$settings = $settings->mapWithKeys(function( $value, $key ) {
			$key = Str::snake( $key );
			$key = Str::replace( array( 'u_r_i', 'w_p', 'p_h_p' ), array( 'uri', 'wp', 'php' ), $key );
			return [ $key => $value ];
		})->each(function( $value, $key ) {
			$this->set( $key, $value, true );
		});
	}

	public function initialize_options() {
		$this->options = $this->get_options();
	}

    /**
     *  @return string full plugin file path (with file name)
     */
    public function get_plugin_file() {
        return $this->file;
    }

	/**
	 * Get full plugin file path of a folder
	 *
	 * @param string $folder Get specific path folder
	 * @return string
	 */
    public function get_plugin_dir( $folder = '' ) {
		if ( ! empty( $folder ) ) {
			return $this->get( "paths.$folder.dir", '' );
		} else {
			return $this->get( 'dir' );
		}

    }

    /**
     *  @return string full plugin url path
     */
    public function get_plugin_uri( $folder = '' ) {
		if ( ! empty( $folder ) ) {
			return $this->get( "paths.$folder.uri", '' );
		} else {
			return $this->get( 'uri' );
		}
    }

    /**
     *  @inheritdoc
     */
    public function get_asset_roots() {
        return array( $this->get_plugin_dir() => $this->get_plugin_url() );
    }

    /**
     *  @return string plugin slug
     */
    public function get_slug() {
        return \basename( $this->get_plugin_dir() );
    }

    /**
     *  @return string Path to the main plugin file from plugins directory
     */
    public function get_wp_plugin() {
         return \plugin_basename( $this->get_plugin_file() );
    }

    /**
     *  @return string current plugin version
     */
    public function version() {

		if ( empty( $this->version ) ) {
            $this->version = $this->get( 'version' );
		}
        return $this->version;
    }

	/**
	 * Upgrade if necessary
	 *
	 * @action plugins_loaded
	 *
	 * @return void
	 */
    public function maybe_upgrade() {
		if ( ! \is_admin() ) {
			return;
		}
         // trigger upgrade
        $new_version = $this->version();
        $old_version = $this->get_option( 'version', $new_version, true );
        // call upgrade
        if ( \version_compare( $new_version, $old_version, '>' ) ) {
            $result = $this->upgrade( $new_version, $old_version );
			$result = data_get( $result, 'success', false );
			if ( $result ) {
				$this->update_option( 'version', $new_version, true, true );
			}
        }
    }

	/**
	 * Load text domain
	 *
	 * @action plugins_loaded
	 *
	 * @return void
	 */
    public function load_textdomain() {
        \load_plugin_textdomain( $this->get( 'textdomain' ), false, $this->get( 'domainpath' ) );
    }

	/**
	 * Get plugin options
	 *
	 * All options for this plugin are store in one table row as  a collection
	 *
	 * @param bool $global
	 *
	 * @return Collection
	 */
    public function get_options( $global = false ) {
		$option = $this->prefix( 'options' );
		if ( $global ) {
			$options = get_network_option( get_current_network_id(), $option );
		} else {
			$options = get_option( $option );
		}

		return new Collection( $options );
    }

	/**
	 * Update plugin options
	 *
	 * @param  Collection $options
	 * @param  bool       $global
	 * @return bool
	 */
    public function update_options( $options, $global = false ) {

		$option = $this->prefix( 'options' );

		if ( 1 == $options->count() && $options->has( 'options' ) ) {
			$options = $options->first();
		}

		if ( $global ) {
			$updated = update_network_option( get_current_network_id(), $option, $options );
		} else {
			$updated = update_option( $option, $options, true );
		}

		$this->set( 'options', $options, true );

		return $updated;
    }

	/**
	 * Delete all plugin options.
	 *
	 * @param  bool $global
	 * @return bool
	 */
    public function delete_options( $global = false ) {

		$option = $this->prefix( 'options' );

		if ( $global ) {
			$deleted = delete_network_option( get_current_network_id(), $option );
		} else {
			$deleted = delete_option( $option );
		}

		return $deleted;
    }

	/**
	 * Get plugin option.
	 *
	 * @param  string|array|int|null  $key
     * @param  mixed                  $default
	 * @param  bool                   $global
	 * @return mixed
	 */
    public function get_option( $key, $default = null, $global = false ) {

		$options = $this->get_options( $global );

		return data_get( $options, $key, $default );
    }

	/**
	 * Update plugin option
	 *
	 * Since all plugin options are stored in one object in the `rwp_options`
	 * row in the `wp_options` table, the option must be updated in the
	 * object and then the option in the database must be updated with the
	 * updated object
	 *
	 * @param  string|array|int|null  $key
	 * @param  mixed                  $value
	 * @param  bool                   $global
	 * @return void
	 */
    public function update_option( $key, $value, $global = false ) {

		$options = $this->get_options( $global );

		$options = data_set( $options, $key, $value );

        $this->update_options( $options, $global );
    }

    /**
	 * Delete plugin option
     *
	 * Since all plugin options are stored in one object in the `rwp_options`
	 * row in the `wp_options` table, the option must be deleted from the
	 * object and then the option in the database must be updated with the
	 * updated object
	 *
	 * @param  string|array|int|null  $key
	 * @param  bool                   $global
	 * @return void
	 */
    public function delete_option( $key, $global = false ) {

		$options = $this->get_options( $global );

		$options = data_remove( $options, $key );

		$this->update_options( $options, $global );

    }

	/**
	 * @inheritdoc
	 */
    public function activate( $network_wide = false ) {

		$result = array(
			'success' => \true,
			'messages' => array(),
		);

		if ( \function_exists( 'is_multisite' ) && \is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				/** @var array<\WP_Site> $blogs */
				$blogs = \get_sites();

				foreach ( $blogs as $blog ) {
					\switch_to_blog( (int) $blog->blog_id );
					$result = $this->single_activate();
					$result['success'] &= $result['success'];
					$result['messages'] = \array_merge( $result['messages'], $result['message'] );
					\restore_current_blog();
				}

				return $result;
			}
		}

		$result = $this->single_activate();
		$result['success'] &= $result['success'];
		$result['messages'] = \array_merge( $result['messages'], $result['message'] );

		return $result;
    }

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @param int $blog_id ID of the new blog.
	 * @since 1.0.0
	 * @return void
	 */
	public function activate_new_site( int $blog_id ) {
		if ( 1 !== \did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		\switch_to_blog( $blog_id );
		$this->activate();
		\restore_current_blog();
	}

    /**
     *  @inheritdoc
     */
    public function upgrade( $new_version, $old_version ) {
        $result = array(
			'success' => \true,
			'messages' => array(),
		);
        // foreach ( self::$components as $component ) {
        //     $comp = $component::instance();
        //     $result = $comp->upgrade( $new_version, $old_version );
        //     $result['success'] &= $result['success'];
        //     $result['messages'] = \array_merge( $result['messages'], $result['message'] );
        // }
        return $result;
    }

    /**
	 * @inheritdoc
	 */
    public function deactivate( $network_wide = false ) {
		$result = array(
			'success' => \true,
			'messages' => array(),
		);

		if ( \function_exists( 'is_multisite' ) && \is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				/** @var array<\WP_Site> $blogs */
				$blogs = \get_sites();

				foreach ( $blogs as $blog ) {
					\switch_to_blog( (int) $blog->blog_id );
					$result = $this->single_deactivate();
					$result['success'] &= $result['success'];
					$result['messages'] = \array_merge( $result['messages'], $result['message'] );
					\restore_current_blog();
				}

				return $result;
			}
		}

		$result = $this->single_deactivate();
		$result['success'] &= $result['success'];
		$result['messages'] = \array_merge( $result['messages'], $result['message'] );

		return $result;
    }

    /**
     *  @inheritdoc
     */
    public function uninstall( $network_wide = false ) {
		$result = array(
			'success' => \true,
			'messages' => array(),
		);
		// foreach ( self::$components as $component ) {
        //     $comp = $component::instance();
		// 	$result = $comp->uninstall();
		// 	$result['success'] &= $result['success'];
        //     $result['messages'] = \array_merge( $result['messages'], $result['message'] );
		// }
		return $result;
    }

	/**
	 * @inheritdoc
	 */
	public function single_activate() {
		$this->add_capabilities();
		$this->maybe_upgrade();

		$result = array(
			'success'  => true,
			'messages' => array(),
		);

		// foreach ( self::$components as $component ) {
        //     $comp = $component::instance();
        //     $result = $comp->single_activate();
		// 	$result['success'] &= $result['success'];
        //     $result['messages'] = \array_merge( $result['messages'], $result['message'] );
		// }

		\flush_rewrite_rules();

		return $result;
	}

	/**
	 * @inheritdoc
	 */
	public function single_deactivate() {
		$result = array(
			'success'  => true,
			'messages' => array(),
		);

		// foreach ( self::$components as $component ) {
        //     $comp = $component::instance();
        //     $result = $comp->single_deactivate();
		// 	$result['success'] &= $result['success'];
        //     $result['messages'] = \array_merge( $result['messages'], $result['message'] );
		// }

		\flush_rewrite_rules();

		return $result;
	}

	/**
	 * Add admin capabilities
	 *
	 * @return void
	 */
	public function add_capabilities() {}

	/**
	 * Add plugin prefix to string
	 *
	 * @uses rwp_add_prefix()
	 * @uses rwp_change_case()
	 *
	 * @param string  $string     The string to prefix
	 * @param string  $case       The string case. @see rwp_change_case() for
	 *                            details
	 * @param string  $separator  The string to add in between the prefix and
	 *                            the string. Defaults to null
	 * @return string
	 */
    public function prefix( $string, $case = 'snake', $separator = null ) {

		if ( 'title' === $case ) {
			$prefix = $this->get( 'name' );
		} else {
			$prefix = $this->get_slug();
		}

		if ( ! empty( $case ) ) {
			switch ( $case ) {
				case 'title':
					if ( null === $separator ) {
						$separator = ' ';
					}
					$string = preg_replace( '/((?<=\w)-(?=\w)|\_)/m', ' ', $string );
					$string = Str::title( $string );
			        break;
				case 'lower':
					$string = Str::lower( $string );
			        break;
				case 'snake':
					if ( empty( $separator ) ) {
						$separator = '_';
					}
					$string = Str::snake( $string );
			        break;
				case 'kebab':
					if ( empty( $separator ) ) {
						$separator = '-';
					}
					$string = Str::kebab( $string );
			        break;
				case 'slug':
					if ( empty( $separator ) ) {
						$separator = '-';
					}
					$string = Str::slug( $string );
			        break;
				case 'camel':
					$string = Str::camel( $string );
			        break;
			}
		}

		// Add the separator if it isn't already there
		if ( ! Str::endsWith( $prefix, $separator ) ) {
			$prefix = Str::finish( $prefix, $separator );
		}

		if ( ! Str::startsWith( $string, $prefix ) ) {
			$string = Str::start( $string, $prefix );
		}

        return $string;
    }

    /**
	 * Remove plugin prefix to string
	 *
	 * @uses rwp_remove_prefix()
	 *
	 * @param string  $string     The string to prefix
	 * @param string  $separator  The string to add in between the prefix and
	 *                            the string. Defaults to '_'
	 * @param string  $case       The string case. @see rwp_change_case() for
	 *                            details
	 * @return string
	 */
    public function unprefix( $string, $separator = '_', $case = '' ) {
        if ( 'title' === $case ) {
			$prefix = $this->get( 'name' );
		} else {
			$prefix = $this->get( 'slug' );
		}

		// Add the separator if it isn't already there
		if ( ! Str::endsWith( $prefix, $separator ) ) {
			$prefix = Str::finish( $prefix, $separator );
		}

		// If the string begins with the specified prefix, remove it
		if ( Str::startsWith( $string, $prefix ) ) {
			$string = Str::after( $string, $prefix );
		}

		return $string;
    }

	/**
	 * Based on the folder loads the classes automatically using the Composer autoload to detect the classes of a Namespace.
	 *
	 * @param string $component Class name to find.
	 * @since 1.0.0
	 * @return array Return the classes.
	 */
	public function get_component( string $component = '' ) {

		if ( rwp_str_has( $component, '\\' ) ) {
			$component = rwp_str_replace( '\\', '.', $component );
		}
		$component = rwp_str_replace( 'RWP.', '', $component );
		return $this->get( "components.$component" );
	}

	/**
	 * Get a setting from the plugin instance.
	 *
	 * @param  string  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function get_setting( $key, $default = null ) {
		return $this->get( "settings.$key", $default );
	}

	/**
	 * Set a setting for the plugin instance.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function set_setting( $key, $value = null ) {
		$this->set( "settings.$key", $value );
	}

	/**
	 * define
	 *
	 * Defines a constant if doesnt already exist.
	 *
	 *
	 * @param string $name  The constant name.
	 * @param mixed  $value The constant value.
	 *
	 * @return void
	 */
	public function define( $name, $value = true ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
}
