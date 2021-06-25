<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://riester.com
 * @since      1.0.0
 *
 * @package    RWP
 * @subpackage RWP/includes
 */

use RWP\Base;

use RWP\Vendor\Illuminate\Support\Collection;

if (!class_exists('RWP')) {
	class RWP extends Base {

		/**
		 * The plugin icon for admin pages
		 *
		 * @var    string $icon
		 * @since  1.0.0
		 */

		protected $icon = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1024 1024'%3E%3Cpolygon points='0 1024 1023.97 1024 1024 0 0 0 0 1024' fill='%23b42025'/%3E%3Cpath d='M587.33,538.65c32.92-14.89,68.23-51.76,68.23-142.72,0-120.82-55.69-167.1-164.72-167.1H354.34V795.17h97.25V563c17.3,0,37.68-.76,50.22-2.33l69,234.52h98.82Zm-101.2-55.71H451.59V308.84h34.54c52.55,0,72.17,19.63,72.17,87.09S538.68,482.94,486.13,482.94Z' fill='%23fff'/%3E%3C/svg%3E";

		/**
		 * Singleton instance of plugin.
		 *
		 * @var    self $instance
		 * @since  0.0.0
		 */
		public static $instance = null;



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

			if (defined('RWP_PLUGIN_VERSION')) {
				$this->version = RWP_PLUGIN_VERSION;
			} else {
				$this->version = '1.0.0';
			}
			if (defined('RWP_PLUGIN_PATH')) {
				$this->path = RWP_PLUGIN_PATH;
				$this->acf_save_path = RWP_PLUGIN_PATH . 'includes/config/acf/';
			}
			if (defined('RWP_PLUGIN_URL')) {
				$this->url = RWP_PLUGIN_URL;
			}
			if (defined('RWP_PLUGIN_NAME')) {
				$this->name = RWP_PLUGIN_NAME;
			}
			if (defined('RWP_PLUGIN_PREFIX')) {
				$this->prefix = RWP_PLUGIN_PREFIX;
			}
			if (defined('RWP_PLUGIN_FILE')) {
				$this->file = RWP_PLUGIN_FILE;
			}

			parent::__construct();

			self::$instance = $this;
		}

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @since   0.0.0
		 * @return  self A single instance of this class.
		 */
		public static function instance() {
			if (null === self::$instance) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}
