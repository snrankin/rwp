<?php

/** ============================================================================
 * Base skeleton of the plugin
 *
 * @package   RWP
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RWP\Helpers\Collection;
use RWP\Helpers\Context;
use RWP\Helpers\Str;
use RWP\Vendor\PUC\v4\Factory;


class Plugin {

	use Helpers\Assets;
	use Helpers\Utils;
	use Helpers\Components;
	use Helpers\Request;

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
	 * @var string Absolute path to plugin main file
	 * @access private
	 */
	private $file;

	/**
	 * @var string Current plugin version
	 * @access private
	 */
	private $version = '';

	/**
	 * @var array $components Array of plugin components which might need upgrade
	 * @access public
	 */
	protected $components = array();


	/**
	 * @var array|Collection $options The option keys available in the database
	 */
	protected $options = array();

	/**
	 * @var array $paths An array of paths for various folders for easy access
	 */
	protected $paths = array();

	/**
	 * @var Factory Instance of the plugin update checker
	 */

	private $update_checker;

	/**
	 * Autoloader instance
	 *
	 * @var self $instance
	 */
	private static $instance;


	/**
	 *  @inheritdoc
	 */
	private function __construct() {

		$this->register_autoloader();

		$this->file         = RWP_PLUGIN_FILE;
		$this->dir          = RWP_PLUGIN_ROOT;
		$this->uri          = RWP_PLUGIN_URI;
		$this->namespace    = 'RWP';
		$this->slug         = 'rwp';
		$this->title        = __( 'RIESTER Core Plugin', 'rwp' );
		$this->capability   = 'manage_options';
		$this->settings_uri = add_query_arg( 'page', 'rwp-options', 'admin.php' );
		$this->icon         = 'rwp-icon.svg';
		$this->paths        = array(
			'assets'       => array(
				'dir' => RWP_PLUGIN_ROOT . 'assets/',
				'uri' => RWP_PLUGIN_URI . 'assets/',
			),
			'config'       => array(
				'dir' => RWP_PLUGIN_ROOT . 'includes/config/',
				'uri' => RWP_PLUGIN_URI . 'includes/config/',
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

		$this->context = Context::determine();
		$this->request = $this->request();

		/**
		 * @var \RWP\Vendor\PUC\v4p11\Vcs\PluginUpdateChecker $update_checker
		 */
		$update_checker = \RWP\Vendor\PUC\v4p11\Factory::buildUpdateChecker(
			'https://digital.riester.com/plugin/?action=get_metadata&slug=rwp',
			RWP_PLUGIN_FILE,
			'rwp',
		);

		$this->update_checker = $update_checker;

		if ( ! wp_installing() ) {
			\add_action( 'plugins_loaded', array( __CLASS__, 'init' ) );
		}
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public static function init() {

		/**
		 * @var Plugin $plugin
		 */
		$plugin = self::instance();

		\register_activation_hook( RWP_PLUGIN_FILE, array( __CLASS__, 'activation' ) );
		\register_uninstall_hook( RWP_PLUGIN_FILE, array( __CLASS__, 'uninstall' ) );

		\add_action( 'wpmu_new_blog', array( __CLASS__, 'activate_new_site' ) );

		$plugin->initialize_settings();
		$plugin->initialize_configs();
		$plugin->initialize_assets();
		$plugin->initialize_options();
		$plugin->initialize_components();
	}

	public function register_autoloader() {

		$this->autoloader = Autoloader::instance( __DIR__ . '/core' );
		class_alias( 'RWP\Helpers\Collection' , 'RWP\Components\Collection', true );
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

	private function initialize_settings() {
		$meta = \get_plugin_data( $this->get_plugin_file(), false );

		$settings = new Collection( \wp_parse_args( $this->settings, $meta ) );

		$settings = $settings->mapWithKeys(function ( $value, $key ) {
			$key = Str::snake( $key );
			$key = Str::replace( array( 'u_r_i', 'w_p', 'p_h_p' ), array( 'uri', 'wp', 'php' ), $key );
			return [ $key => $value ];
		})->each(function ( $value, $key ) {
			$this->$key = $value;
		});
	}

	private function initialize_options() {
		$this->options = $this->get_options();
	}

	/**
	 *  @return string full plugin file path (with file name)
	 */

	public function get_plugin_file() {
		return $this->file;
	}

	/**
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
	 * Get full plugin file path of a folder
	 *
	 * @param string $folder Get specific path folder
	 * @return string
	 */
	public function get_plugin_dir( $folder = '' ) {
		$folders = $this->paths;

		if ( ! empty( $folder ) ) {
			return data_get( $folders, "$folder.dir", '' );
		} else {
			return $this->dir;
		}
	}

	/**
	 *  @return string full plugin url path
	 */
	public function get_plugin_uri( $folder = '' ) {
		$folders = $this->paths;

		if ( ! empty( $folder ) ) {
			return data_get( $folders, "$folder.uri", '' );
		} else {
			return $this->dir;
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
		return $this->name;
	}

	/**
	 *  @return string plugin slug
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 *  @return string plugin settings uri
	 */
	public function get_settings_uri() {
		return $this->settings_uri;
	}

	/**
	 * Get the admin icon
	 * @param bool $encode
	 * @return string|false
	 */
	public function get_settings_icon( $encode = false ) {
		$icon = $this->icon;
		$icon = $this->asset_path( $icon );

		if ( $encode ) {
			$icon = rwp_encode_img( $icon );
		}
		return $icon;
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

		return $this->version;
	}

	/**
	 * Upgrade if necessary
	 *
	 * @action plugins_loaded
	 *
	 * @return void
	 */
	public static function maybe_upgrade() {

		/**
		 * @var Plugin $plugin
		 */
		$plugin = self::instance();

		if ( ! $plugin->request() !== 'backend' ) {
			return;
		}
		// trigger upgrade
		$file_version = $plugin->version();
		$db_version = \strval( $plugin->get_option( 'version', $file_version, true ) );
		// call upgrade
		if ( \version_compare( $file_version, $db_version, '>' ) ) {
			$result = $plugin->upgrade( $file_version, $db_version );
			$result = data_get( $result, 'success', false );
			if ( $result ) {
				$plugin->update_option( 'version', $file_version, true, true );
			}
		}
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

		$options = new Collection( $options );

		return apply_filters( 'rwp_get_options', $options );
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

		if ( 1 === $options->count() && $options->has( 'options' ) ) {
			$options = $options->first();
		}

		if ( $global ) {
			$updated = update_network_option( get_current_network_id(), $option, $options );
		} else {
			$updated = update_option( $option, $options, true );
		}

		$this->options = $this->get_options( $global );

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

		$this->options = $this->get_options( $global );

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
	 * Fired when the plugin is activated.
	 *
	 * @param bool $network_wide True if active in a multiste, false if classic site.
	 * @since {{plugin_version}}
	 * @return void
	 */
	public static function activate( bool $network_wide ) {
		if ( \function_exists( 'is_multisite' ) && \is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				/** @var array<\WP_Site> $blogs */
				$blogs = \get_sites();

				foreach ( $blogs as $blog ) {
					\switch_to_blog( (int) $blog->blog_id );
					self::single_activate();
					\restore_current_blog();
				}

				return;
			}
		}

		self::single_activate();
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @param int $blog_id ID of the new blog.
	 * @since 0.9.0
	 * @return void
	 */
	public static function activate_new_site( int $blog_id ) {
		if ( 1 !== \did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		\switch_to_blog( $blog_id );
		self::single_activate();
		\restore_current_blog();
	}

	/**
	 * Upgrade procedure
	 *
	 * @return void
	 */
	public static function upgrade() {
		// @TODO: [RWP-3] Define upgrade procedure

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param bool $network_wide True if WPMU superadmin uses
	 * "Network Deactivate" action, false if
	 * WPMU is disabled or plugin is
	 * deactivated on an individual blog.
	 * @since {{plugin_version}}
	 * @return void
	 */
	public static function deactivate( $network_wide = false ) {
		if ( \function_exists( 'is_multisite' ) && \is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				/** @var array<\WP_Site> $blogs */
				$blogs = \get_sites();

				foreach ( $blogs as $blog ) {
					\switch_to_blog( (int) $blog->blog_id );
					self::single_deactivate();
					\restore_current_blog();
				}

				return;
			}
		}

		self::single_deactivate();
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 0.9.3
	 * @return void
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
		self::add_capabilities();
		self::maybe_upgrade();

		// Clear the permalinks
		\flush_rewrite_rules();
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 0.9.3
	 * @return void
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here

		self::remove_capabilities();

		// Clear the permalinks
		\flush_rewrite_rules();
	}

	/**
	 * Add admin capabilities
	 *
	 * @return void
	 */
	public static function add_capabilities() {
	}

	/**
	 * Remove capabilities to specific roles
	 *
	 * @return void
	 */
	public static function remove_capabilities() {

	}

	/**
	 * Getting a singleton.
	 *
	 * @return self
	 */
	final public static function instance() {

		if ( null === self::$instance ) {
			$args = \func_get_args();

			self::$instance = new self( ...$args );
		}

		return self::$instance;
	}

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
					$string = Str::snake( $string, $separator );
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
					$string = Str::slug( $string, $separator );
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
	 * @since 0.9.0
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

	/**
	 * Avoid clone instance
	 */
	private function __clone() {
	}

	/**
	 * Avoid serialize instance
	 */
	private function __sleep() { // phpcs:ignore
	}

	/**
	 * Avoid unserialize instance
	 */
	private function __wakeup() {
	}
}

Plugin::instance();
