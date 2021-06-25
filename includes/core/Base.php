<?php

/** ============================================================================
 * Base
 *
 * @package RIESTERWP Plugin\/includes/core/Base.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP;

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Vendor\Illuminate\Config\Repository as Config;

class Base {

	use Traits\Helpers;
	use Traits\Assets;
	use Traits\Lifecycle;
	use Traits\Options;
	use Traits\Backend;
	use Traits\Frontend;
	use Traits\I18n;
	use Traits\Loader;
	use Traits\Modules;
	use Traits\Blocks;
	use Traits\ACF;
	use Traits\Shortcodes;
	use Traits\CPT;
	use Traits\Terms;
	use Traits\Widgets;
	/**
	 * The display name of the plugin
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $name    The string used to uniquely identify this plugin.
	 */
	protected $name;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $prefix    The string used to uniquely identify this plugin.
	 */
	protected $prefix;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Required minimum php version
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $php_version    Required minimum php version
	 */
	protected $php_version = '7.4';

	/**
	 * Required minimum WordPress Version
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wp_version    Required minimum WordPress Version
	 */
	protected $wp_version = '5.5';

	/**
	 * URL of plugin directory.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $url;

	/**
	 * Absolute path of plugin directory.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $path;

	/**
	 * The main plugin file
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $file;

	/**
	 * The plugin icon for admin pages
	 *
	 * @var    string $icon
	 * @since  1.0.0
	 */

	protected $icon = '';

	/**
	 * The static config object
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array|Config $config
	 */

	protected $config  = [];



	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->tables     = new Collection($this->tables);
		$this->blocks     = new Collection($this->blocks);
		$this->actions    = new Collection($this->actions);
		$this->filters    = new Collection($this->filters);
		$this->modules    = new Collection($this->modules);
		$this->acf_pages  = new Collection($this->acf_pages);
		$this->acf_blocks = new Collection($this->acf_blocks);
		$this->shortcodes = new Collection($this->shortcodes);
		$this->cpts       = new Collection($this->cpts);
		$this->terms      = new Collection($this->terms);
		$this->widgets    = new Collection($this->widgets);

		$this->config = new Config([
			'admin'   => rwp_get_plugin_file('admin.php', 'includes/config', true),
			'assets'  => rwp_get_plugin_file('assets.php', 'includes/config', true),
		]);

		$this->init();
	}

	public function init() {
		$this->init_assets();
		$this->init_blocks();
		$this->init_cpts();
		$this->init_terms();
		if (class_exists('\\ACF')) {
			$this->init_acf();
		}
		$this->init_hooks();
	}

	public function init_hooks() {
		$this->add_action('wp_loaded', $this, 'init_modules');
		$this->add_action('widgets_init', $this, 'init_widgets');
		$this->add_action('init', $this, 'register_shortcodes');
		$this->backend_hooks();
		$this->frontend_hooks();
	}
}
