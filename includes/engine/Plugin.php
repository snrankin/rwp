<?php
/** ============================================================================
 * Base skeleton of the plugin
 *
 * @package   RWP\Engine
<<<<<<< HEAD
 * @since     1.0.0
=======
 * @since     0.9.0
>>>>>>> release/v0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine;

use RWP\Engine\Interfaces\Component;
use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Collection;
use RWP\Components\Str;
<<<<<<< HEAD
use RWP\Engine\Traits\Assets;
use RWP\Engine\Traits\Helpers;
class Plugin extends Singleton implements Component {

	use Assets;
	use Helpers;

    protected $name;

	protected $dir;
	protected $uri;
	protected $namespace;
	protected $title;
	protected $capability;
	protected $icon;
	protected $plugin_uri;
	protected $description;
	protected $author;
	protected $settings_uri;
	protected $text_domain;
	protected $domain_path;
	protected $network;
	protected $requires;

    /**
	 * @var string $file Absolute path to plugin main file
	 * @access private
	 */
    private $file;

    /**
	 * @var string $version Current plugin version
	 * @access private
	 */
    private $version = '';
=======
class Plugin extends Singleton implements Component {

	use Traits\Assets;
	use Traits\Helpers;
	use Traits\Autoloader;
	use Traits\Request;

	/**
	 * @var string The Plugin Name
	 */
    protected $name;

	/**
	 * @var string The absolute path to the plugin directory
	 */
	protected $dir;

	/**
	 * @var string The relative path to the plugin directory
	 */
	protected $uri;

	/**
	 * @var string The plugin namespace
	 */
	protected $namespace;

	/**
	 * @var string The plugin admin title
	 */
	protected $title;

	/**
	 * @var string The plugin admin capabilities
	 */
	protected $capability;

	/**
	 * @var string The plugin admin icon
	 */
	protected $icon;

	/**
	 * @var string The plugin options url
	 */
	protected $settings_uri;

	/**
	 * @var string The plugin text domain
	 */
	protected $text_domain;

	/**
	 * @var string The plugin path for langages
	 */
	protected $domain_path;

    /**
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
	 * @var string $file Absolute path to plugin main file
	 * @access private
	 */
    public $file;

    /**
	 * @var string $version Current plugin version
	 * @access public
	 */
    public $version = '';
========
	 * @var string Absolute path to plugin main file
	 * @access private
	 */
    private $file;

    /**
	 * @var string Current plugin version
	 * @access private
	 */
    private $version = '';
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0

    /**
	 * @var array $components Array of plugin components which might need upgrade
	 * @access public
	 */
<<<<<<< HEAD
    public $components = [];

=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
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
========
    protected $components = array();

>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0

	/**
	 * @var array|Collection $options The option keys available in the database
	 */
<<<<<<< HEAD
	public $options = array();
=======
	protected $options = array();
>>>>>>> release/v0.9.0

	/**
	 * @var array $paths An array of paths for various folders for easy access
	 */
<<<<<<< HEAD
	public $paths = array();
=======
	protected $paths = array();

>>>>>>> release/v0.9.0

    /**
     *  @inheritdoc
     */
<<<<<<< HEAD
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
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
========
>>>>>>> release/v0.9.0
    protected function __construct() {

		$this->file         = RWP_PLUGIN_FILE;
		$this->autoloader   = require RWP_PLUGIN_ROOT . '/vendor/autoload.php';
		$this->dir          = RWP_PLUGIN_ROOT;
		$this->uri          = RWP_PLUGIN_URI;
		$this->namespace    = 'RWP';
		$this->slug         = 'rwp';
		$this->title        = __( 'RIESTER Core Plugin', 'rwp' );
		$this->capability   = 'manage_options';
		$this->settings_uri = add_query_arg( 'page', 'rwp-options', 'admin.php' );
<<<<<<< HEAD
		$this->icon         = 'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCIgcm9sZT0iaW1nIiBhcmlhLWhpZGRlbj0idHJ1ZSIgZm9jdXNhYmxlPSJmYWxzZSIgZmlsbD0iY3VycmVudENvbG9yIj4KCTxwYXRoIGQ9Ik00ODYuMSwzMDguOGgtMzQuNXYxNzQuMWgzNC41YzUyLjUsMCw3Mi4yLTE5LjYsNzIuMi04N1M1MzguNywzMDguOCw0ODYuMSwzMDguOHoiIC8+Cgk8cGF0aCBkPSJNMCwwdjEwMjRoMTAyNGwwLTEwMjRIMHogTTU3MC44LDc5NS4ybC02OS0yMzQuNWMtMTIuNSwxLjYtMzIuOSwyLjMtNTAuMiwyLjN2MjMyLjJoLTk3LjJWMjI4LjhoMTM2LjUgYzEwOSwwLDE2NC43LDQ2LjMsMTY0LjcsMTY3LjFjMCw5MS0zNS4zLDEyNy44LTY4LjIsMTQyLjdsODIuMywyNTYuNUg1NzAuOHoiIC8+Cjwvc3ZnPgo=';
=======
		$this->icon         = 'rwp-icon.svg';
>>>>>>> release/v0.9.0
		$this->paths        = array(
			'assets'       => array(
				'dir' => RWP_PLUGIN_ROOT . 'assets/',
				'uri' => RWP_PLUGIN_URI . 'assets/',
			),
			'config'       => array(
				'dir' => RWP_PLUGIN_ROOT . 'config/',
				'uri' => RWP_PLUGIN_URI . 'config/',
			),
			'includes'     => array(
				'dir' => RWP_PLUGIN_ROOT . 'includes/',
				'uri' => RWP_PLUGIN_URI . 'includes/',
			),
			'dependencies' => array(
				'dir' => RWP_PLUGIN_ROOT . 'dependencies/',
				'uri' => RWP_PLUGIN_URI . 'dependencies/',
			),
		);

<<<<<<< HEAD
		// Activate plugin when new blog is added
		\add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );
        \register_activation_hook( $this->get_plugin_file(), array( $this, 'activate' ) );
        \register_deactivation_hook( $this->get_plugin_file(), array( $this, 'deactivate' ) );
        \register_uninstall_hook( $this->get_plugin_file(), array( __CLASS__, 'uninstall' ) );
        \add_action( 'admin_init', array( $this, 'maybe_upgrade' ) );
        \add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		$this->initialize_autoloader();
		$this->initialize_settings();
		$this->initialize_configs();
		$this->initialize_assets();
    }

=======
		$this->context = Context::determine();
		$this->request = $this->request();
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php

		$this->initialize_settings();
		$this->initialize_configs();
    }

<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
	public function initialize_configs() {

		$root    = $this->get_plugin_dir( 'config' );
        $configs = glob( $root . '*.php' );

========
	/**
	 * Initialize the plugin
	 * @param Plugin $plugin
	 * @return void
	 */
	public static function init( $plugin ) {
        // Activate plugin when new blog is added
		\add_action( 'wpmu_new_blog', array( $plugin, 'activate_new_site' ) );
        \register_activation_hook( $plugin->get_plugin_file(), array( $plugin, 'activate' ) );
        \register_deactivation_hook( $plugin->get_plugin_file(), array( $plugin, 'deactivate' ) );
        \register_uninstall_hook( $plugin->get_plugin_file(), array( __CLASS__, 'uninstall' ) );
        \add_action( 'admin_init', array( $plugin, 'maybe_upgrade' ) );
        \add_action( 'plugins_loaded', array( $plugin, 'load_textdomain' ) );

		$plugin->initialize_autoloader();
		$plugin->initialize_classes();
		$plugin->initialize_settings();
		$plugin->initialize_configs();
		$plugin->initialize_assets();
		$plugin->initialize_options();

	}

>>>>>>> release/v0.9.0
	public function initialize_configs() {

		$root    = $this->get_plugin_dir( 'config' );
        $configs = glob( $root . '*.php' );

<<<<<<< HEAD
=======
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
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

<<<<<<< HEAD
	public function initialize_settings() {
=======
	private function initialize_settings() {
>>>>>>> release/v0.9.0
		$meta = \get_plugin_data( $this->get_plugin_file(), false );

		$settings = new Collection( \wp_parse_args( $this->settings, $meta ) );

		$settings = $settings->mapWithKeys(function( $value, $key ) {
			$key = Str::snake( $key );
			$key = Str::replace( array( 'u_r_i', 'w_p', 'p_h_p' ), array( 'uri', 'wp', 'php' ), $key );
			return [ $key => $value ];
		})->each(function( $value, $key ) {
<<<<<<< HEAD
			$this->$key = $value;
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
			$this->set( $key, $value, true );
>>>>>>> release/v0.9.0
		});
	}

	public function initialize_options() {
		$this->options = $this->get_options();
<<<<<<< HEAD
=======
========
			$this->$key = $value;
		});
	}

	private function initialize_options() {
		$this->options = $this->get_options();
	}

	private function initialize_classes() {
        $classes_to_init = new Collection();

		$internals = $this->get_classes( 'Internals' );
		$integrations = $this->get_classes( 'Integrations' );

		$classes_to_init = $classes_to_init->merge( $internals );
		$classes_to_init = $classes_to_init->merge( $integrations );

		if ( $this->request_is( 'rest' ) ) {
			$rest = $this->get_classes( 'Rest' );
			$classes_to_init = $classes_to_init->merge( $rest );
		}

		if ( $this->request_is( 'ajax' ) ) {
			$ajax = $this->get_classes( 'Ajax' );
			$classes_to_init = $classes_to_init->merge( $ajax );
		}

		if ( $this->request_is( 'backend' ) ) {
			$backend = $this->get_classes( 'Backend' );
			$classes_to_init = $classes_to_init->merge( $backend );
		}

		if ( $this->request_is( 'frontend' ) ) {
			$frontend = $this->get_classes( 'Frontend' );
			$classes_to_init = $classes_to_init->merge( $frontend );
		}

		$classes_to_init = $classes_to_init->flatten()->unique()->all();

		$this->load_classes( $classes_to_init );
	}

	/**
	 * Initialize all the classes.
	 *
	 * @since 0.9.0
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
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
	}

    /**
     *  @return string full plugin file path (with file name)
     */

    public function get_plugin_file() {
        return $this->file;
    }

	/**
<<<<<<< HEAD
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
========
>>>>>>> release/v0.9.0
	 * Get plugin namespace
	 *
	 * @return string
	 */
    public function get_namespace() {
        return $this->namespace;
    }

	/**
	 * Get plugin capability
	 *
	 * @return string
	 */
    public function get_capability() {
        return $this->capability;
    }

	/**
	 * Get plugin capability
	 *
	 * @return string
	 */
    public function get_icon() {
        return $this->icon;
    }

	/**
<<<<<<< HEAD
=======
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
	 * Get full plugin file path of a folder
	 *
	 * @param string $folder Get specific path folder
	 * @return string
	 */
    public function get_plugin_dir( $folder = '' ) {
<<<<<<< HEAD
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
>>>>>>> release/v0.9.0
		if ( ! empty( $folder ) ) {
			return $this->get( "paths.$folder.dir", '' );
		} else {
			return $this->get( 'dir' );
<<<<<<< HEAD
=======
========
		$folders = $this->paths;

		if ( ! empty( $folder ) ) {
			return data_get( $folders, "$folder.dir", '' );
		} else {
			return $this->dir;
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
		}

    }

    /**
     *  @return string full plugin url path
     */
    public function get_plugin_uri( $folder = '' ) {
<<<<<<< HEAD
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
>>>>>>> release/v0.9.0
		if ( ! empty( $folder ) ) {
			return $this->get( "paths.$folder.uri", '' );
		} else {
			return $this->get( 'uri' );
<<<<<<< HEAD
=======
========
		$folders = $this->paths;

		if ( ! empty( $folder ) ) {
			return data_get( $folders, "$folder.uri", '' );
		} else {
			return $this->dir;
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
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
    public function get_name() {
<<<<<<< HEAD
        return $this->get( 'name' );
=======
        return $this->name;
>>>>>>> release/v0.9.0
    }

    /**
     *  @return string plugin slug
     */
    public function get_slug() {
<<<<<<< HEAD
        return $this->get( 'slug' );
=======
        return $this->slug;
>>>>>>> release/v0.9.0
    }

	/**
     *  @return string plugin settings uri
     */
    public function get_settings_uri() {
        return $this->settings_uri;
    }

	/**
	 * Get the admin icon
<<<<<<< HEAD
	 * @param bool $decode
	 * @return string|false
	 */
    public function get_settings_icon( $decode = false ) {
		$icon = $this->icon;
		if ( $decode ) {
			$icon = base64_decode( $icon );
=======
	 * @param bool $encode
	 * @return string|false
	 */
    public function get_settings_icon( $encode = false ) {
		$icon = $this->icon;
		$icon = $this->asset_path( $icon );

		if ( $encode ) {
			$icon = rwp_encode_img( $icon );
>>>>>>> release/v0.9.0
		}
        return $icon;
    }

    /**
     *  @return string Path to the main plugin file from plugins directory
     */
    public function get_wp_plugin() {
<<<<<<< HEAD
         return \plugin_basename( $this->get_plugin_file() );
=======
        return \plugin_basename( $this->get_plugin_file() );
>>>>>>> release/v0.9.0
    }

    /**
     *  @return string current plugin version
     */
    public function version() {

<<<<<<< HEAD
		if ( empty( $this->version ) ) {
            $this->version = $this->get( 'version' );
		}
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
		if ( empty( $this->version ) ) {
            $this->version = $this->get( 'version' );
		}
========
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
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
<<<<<<< HEAD
		if ( ! \is_admin() ) {
=======
		if ( ! $this->request() !== 'backend' ) {
>>>>>>> release/v0.9.0
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
<<<<<<< HEAD
        \load_plugin_textdomain( $this->get( 'textdomain' ), false, $this->get( 'domainpath' ) );
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
        \load_plugin_textdomain( $this->get( 'textdomain' ), false, $this->get( 'domainpath' ) );
========
        \load_plugin_textdomain( $this->textdomain, false, $this->get( 'domainpath' ) );
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
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
<<<<<<< HEAD
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
========

>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
		if ( $global ) {
			$options = get_network_option( get_current_network_id(), $option );
		} else {
			$options = get_option( $option );
		}

<<<<<<< HEAD
		return new Collection( $options );
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
		return new Collection( $options );
========
		$options = new Collection( $options );

		return apply_filters( 'rwp_get_options', $options );
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
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

<<<<<<< HEAD
		$this->set( 'options', $options, true );
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
		$this->set( 'options', $options, true );
========
		$this->options = $this->get_options( $global );
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0

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
<<<<<<< HEAD
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
========

		$this->options = $this->get_options( $global );
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0

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
<<<<<<< HEAD
	 * @since 1.0.0
=======
	 * @since 0.9.0
>>>>>>> release/v0.9.0
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
<<<<<<< HEAD
					$string = Str::snake( $string );
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
					$string = Str::snake( $string );
========
					$string = Str::snake( $string, $separator );
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
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
<<<<<<< HEAD
					$string = Str::slug( $string );
=======
<<<<<<<< HEAD:includes/engine/Abstracts/Plugin.php
					$string = Str::slug( $string );
========
					$string = Str::slug( $string, $separator );
>>>>>>>> release/v0.9.0:includes/engine/Plugin.php
>>>>>>> release/v0.9.0
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
<<<<<<< HEAD
	 * @since 1.0.0
=======
	 * @since 0.9.0
>>>>>>> release/v0.9.0
	 * @return mixed Return the classes.
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
