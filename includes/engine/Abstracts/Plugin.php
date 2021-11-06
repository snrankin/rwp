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
use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\Str;

abstract class Plugin extends Singleton implements Component {

    /**
	 * @var string $plugin_file Absolute path to plugin main file
	 * @access private
	 */
    private $plugin_file;

    /**
	 * @var string $_version Current plugin version
	 * @access private
	 */
    private $_version = '';

    /**
	 * @var array $components Array of plugin components which might need upgrade
	 * @access private
	 */
    private static $components = [];

	/**
	 * @var ClassLoader
	 * @access private
	 */
    private static $autoloader;

	/**
	 * @var array
	 * @access private
	 */
    private static $classes;

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
    public function __construct( $file, $args = array() ) {
        $this->plugin_file = $file;

		$properties = \wp_parse_args( $args, get_object_vars( $this ) );

		foreach ( $properties as $key => $value ) {
			$this->set( $key, $value, true );
		}

		// Activate plugin when new blog is added
		\add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );
        \register_activation_hook( $this->get_plugin_file(), array( $this, 'activate' ) );
        \register_deactivation_hook( $this->get_plugin_file(), array( $this, 'deactivate' ) );
        \register_uninstall_hook( $this->get_plugin_file(), array( __CLASS__, 'uninstall' ) );
        \add_action( 'admin_init', array( $this, 'maybe_upgrade' ) );
        \add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

        parent::__construct();
		if ( is_array( $this->options ) ) {
			$this->options = rwp_collection( $this->options );
		}
		$this->init_autoloader();
		$this->initialize_paths();
		$this->initialize_settings();

    }

	public function init_autoloader() {
		$autoloader = rwp_get_plugin_file( 'autoload.php', 'vendor', true );

		$class_loader = $this->get_classes();

		$prefix    = $autoloader->getPrefixesPsr4();
		$classmap  = $autoloader->getClassMap();
		$namespace = $this->get_setting( 'namespace' );

		$class_loader = array();

		// In case composer has autoload optimized
		if ( isset( $classmap['RWP\\Engine\\Initialize'] ) ) {
			$classes = \array_keys( $classmap );

			foreach ( $classes as $class ) {
				if ( 0 !== \strncmp( (string) $class, $namespace, \strlen( $namespace ) ) ) {
					continue;
				}

				$class_loader[] = $class;
			}
		}

		$namespace = rwp_add_suffix( $namespace . '\\' );

		// In case composer is not optimized
		if ( isset( $prefix[ $namespace ] ) ) {
			$folder    = $prefix[ $namespace ][0];
			$php_files = $this->scandir( $folder );
			$this->find_classes( $php_files, $folder, $namespace );

			if ( ! WP_DEBUG ) {
				\wp_die( \esc_html__( 'RWP is on production environment with missing `composer dumpautoload -o` that will improve the performance on autoloading itself.', 'rwp' ) );
			}
		}

		$components = rwp_collection( $class_loader )->groupBy( function ( $class ) use ( $namespace ) {

			$class = rwp_remove_prefix( $class, $namespace );
			$sub_groups = explode( '\\', $class );
			$sub_key = array_shift( $sub_groups );
			return $sub_key;
		})->transform( function ( $group, $key ) use ( $namespace ) {
			$parent = $key;
			$group = $group->groupBy( function ( $class ) use ( $parent, $namespace ) {
				$parent = rwp_add_suffix( $parent . '\\' );
				$class = rwp_remove_prefix( $class, $namespace . $parent );
				$sub_groups = explode( '\\', $class );
				$sub_key = array_shift( $sub_groups );
				return $sub_key;
			});
			return $group;
		});

		$components = rwp_object_to_array( $components );

		// $components = $this->format_class_groups( $components );

		$this->set( 'components', $components );

		$this->set( 'autoloader', $autoloader );

		$this->set( 'classes', $class_loader );
	}

	public function format_class_groups( $group, $key = '' ) {
		$namespace = $this->get_setting( 'namespace' );

		if ( ! empty( $key ) && ! is_numeric( $key ) ) {
			$key = rwp_add_prefix( $key, '\\' );
		} else {
			$key = '';
		}
		$namespace = rwp_add_suffix( $namespace . $key, '\\' );
		if ( rwp_is_collection( $group ) ) {
			$group = $group->all();
		}

		if ( is_array( $group ) ) {
			foreach ( $group as $i => $class ) {
				unset( $group[ $i ] );
				if ( is_array( $class ) ) {
					$sub_key = $i;
					$sub_groups = $this->format_class_groups( $class, $i );
				} else if ( is_string( $class ) ) {
					$sub_groups = rwp_remove_prefix( $class, $namespace );
					$sub_groups = explode( '\\', $sub_groups );
					$sub_key = array_shift( $sub_groups );

					if ( ! empty( $sub_groups ) ) {
						$this->format_class_groups( $sub_groups, $sub_key );
					} else {
						$sub_groups = $class;
					}
				}

				$group[ $sub_key ] = $sub_groups;
			}
		}

		return $group;

	}

	/**
	 * Initializes the plugin settings
	 *
	 * @return void
	 */

	public function initialize_settings() {
		$meta = \get_plugin_data( $this->get_plugin_file(), false );

		$plugin_meta = array(
			'name'        => data_get( $meta, 'Name' ),
			'uri'         => data_get( $meta, 'PluginURI' ),
			'version'     => data_get( $meta, 'Version' ),
			'description' => data_get( $meta, 'Description' ),
			'author'      => data_get( $meta, 'Author' ),
			'author_uri'  => data_get( $meta, 'AuthorURI' ),
			'textdomain'  => data_get( $meta, 'TextDomain' ),
			'domainpath'  => data_get( $meta, 'DomainPath' ),
			'network'     => data_get( $meta, 'Network' ),
			'wp_ver'      => data_get( $meta, 'RequiresWP' ),
			'php_ver'     => data_get( $meta, 'RequiresPHP' ),
			'update_uri'  => data_get( $meta, 'UpdateURI' ),
			'path'        => $this->get_plugin_dir(),
			'slug'        => $this->get_slug(),
		);

		$settings = \wp_parse_args( $this->settings, $plugin_meta );

		$this->set( 'settings', $settings );
	}

	/**
	 * Set up the array of plugin paths for easy reference
	 *
	 * @return void
	 */

	public function initialize_paths() {

		$paths = array(
			'base' => \plugin_dir_path( $this->get_plugin_file() ),
		);

		$paths = \wp_parse_args( $this->paths, $paths );

		$this->set( 'paths', $paths );
	}

    /**
     *  @return string full plugin file path (with file name)
     */
    public function get_plugin_file() {
        return $this->plugin_file;
    }

    /**
     *  @return string full plugin file path
     */
    public function get_plugin_dir( $folder = 'base' ) {
		return $this->get( "paths.$folder" );
    }

    /**
     *  @return string full plugin url path
     */
    public function get_plugin_url() {
        return \plugin_dir_url( $this->get_plugin_file() );
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

		if ( empty( $this->_version ) ) {
            $this->_version = $this->get_setting( 'version' );
		}
        return $this->_version;
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
        \load_plugin_textdomain( $this->get_setting( 'textdomain' ), false, $this->get_setting( 'domainpath' ) );
    }

	/**
     * Get plugin option.
     *
     * @param string $key     The name of the option (without the prefix)
     * @param mixed  $default The default value of the option
     *
     * @return mixed $option
     */
    public function get_option( $key, $default = null, $global = false ) {
		return data_get( $this->options, $key, $default );

    }

    /**
     * Get plugin option.
     *
     * @see https://developer.wordpress.org/reference/functions/delete_option/
     *
     * @param string  $key  The name of the option (without the prefix)
     *
	 * @return bool
     *
     */
    public function delete_option( $key, $global = false ) {

		$deleted = delete_option( $this->prefix( $key ) );

		if ( $global ) {
			$deleted = delete_network_option( get_current_network_id(), $this->prefix( $key ) );
		} else {
			$deleted = delete_option( $this->prefix( $key ) );
		}

		$this->options = data_remove( $this->options, $key );

		return $deleted;
    }

    /**
     * Update plugin option.
     *
     * @link https://developer.wordpress.org/reference/functions/update_option/
     *
     * @param string $key       The key of the option (without the prefix)
     * @param mixed  $value     The default value of the option
	 * @param bool   $autoload  Optional. Whether to load the option when
	 *                          WordPress starts up.
     *
     * @return bool
     */
    public function update_option( $key, $value, $autoload = true, $global = false ) {

		if ( $global ) {
			$updated = update_network_option( get_current_network_id(), $this->prefix( $key ), $value );
		} else {
			$updated = update_option( $this->prefix( $key ), $value, $autoload );
		}

		if ( 'options' === $key ) {
			$this->set( 'options', $value );
		} else {
			$this->options = data_set( $this->options, $key, $value );
		}

        return $updated;
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
	 * @param string  $separator  The string to add in between the prefix and
	 *                            the string. Defaults to '_'
	 * @param string  $case       The string case. @see rwp_change_case() for
	 *                            details
	 * @return string
	 */
    public function prefix( $string, $separator = '_', $case = 'snake' ) {

		if ( 'title' === $case ) {
			$prefix = $this->get_setting( 'name' );
		} else {
			$prefix = $this->get_slug();
		}

		if ( ! empty( $case ) ) {
			switch ( $case ) {
				case 'title':
					$string = preg_replace( '/((?<=\w)-(?=\w)|\_)/m', ' ', $string );
					$string = Str::title( $string );
			        break;
				case 'lower':
					$string = Str::lower( $string );
			        break;
				case 'snake':
					$string = Str::snake( $string );
			        break;
				case 'kebab':
					$string = Str::kebab( $string );
			        break;
				case 'slug':
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
			$prefix = $this->get_setting( 'name' );
		} else {
			$prefix = $this->get_setting( 'slug' );
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
