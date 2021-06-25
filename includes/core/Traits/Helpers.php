<?php

/** ============================================================================
 * trait-helpers
 *
 * @package RIESTERWP Plugin\/includes/traits/trait-helpers.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;

trait Helpers {

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  1.0.0
	 *
	 * @return boolean True if requirements met, false if not.
	 */
	public function check_requirements() {

		// Bail early if plugin meets requirements.
		if ($this->meets_requirements()) {
			return true;
		}

		// Didn't meet the requirements.
		return false;
	}

	/**
	 * Helper function for prettying up errors
	 * @param string $message
	 * @param string $subtitle
	 * @param string $title
	 */

	public static function error_message($message, $title = '', $additional_details = '') {
		$title = $title ?: __(RWP_PLUGIN_NAME . ' &rsaquo; Error', 'rwp');
		$title_tag = is_admin() ? 'h4' : 'h1';
		$message = wp_sprintf('<%s>%s</%s><p>%s</p>%s', $title_tag, wp_kses_post($title), wp_kses_post($message), wp_kses_post($additional_details));

		if (is_admin()) {
			echo '<div class="error notice">' . $message . '</div>';
		} else {
			wp_die($message, $title);
		}
	}

	/**
	 * Check that all plugin requirements are met.
	 *
	 * @since  1.0.0
	 *
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {

		/**
		 * Ensure compatible version of PHP is used
		 */
		if (version_compare(RWP_PLUGIN_MIN_PHP_VERSION, phpversion(), '>=')) {
			$this->add_error(__('You must be using PHP ' . RWP_PLUGIN_MIN_PHP_VERSION . ' or greater.', 'rwp'), __('Invalid PHP version', 'rwp'));
		}

		/**
		 * Ensure compatible version of WordPress is used
		 */
		if (version_compare(RWP_PLUGIN_MIN_WP_VERSION, get_bloginfo('version'), '>=')) {
			$this->add_error(__('You must be using WordPress ' . RWP_PLUGIN_MIN_WP_VERSION . ' or greater.', 'rwp'), __('Invalid WordPress version', 'rwp'));
		}

		// Do checks for required classes / functions or similar.
		// Add detailed messages to $this->activation_errors array.
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met.
	 *
	 * @since  1.0.0
	 */
	public function requirements_not_met_notice() {
		// Add details if any exist.
		if ($this->errors->isNotEmpty()) {
			$this->errors->each(function ($item) {
				echo $item;
			});
		}
	}

	public function include_file($file) {
		$path = $this->path . 'includes/' . $file . '.php';
		if (file_exists($path)) {
			include $path;
		}
	}

	public function require_file($file) {
		$path = $this->path . 'includes/' . $file . '.php';
		if (file_exists($path)) {
			require $path;
		}
	}


	public function include_file_once($file) {
		$path = $this->path . 'includes/' . $file . '.php';
		if (file_exists($path)) {
			include_once $path;
		}
	}

	public function require_file_once($file) {
		$path = $this->path . 'includes/' . $file . '.php';
		if (file_exists($path)) {
			require_once $path;
		}
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
	 *                            the string. Defaults to an empty string
	 * @return string
	 */
	public function prefix($string, $case = 'snake', $separator = '') {
		$prefix = $this->prefix;
		if (empty($separator)) {

			switch ($case) {
				case 'snake':
					//$separator = '_';
					$separator = ' ';
					break;
				case 'kebab':
				case 'slug':
					$separator = '-';
					break;
				case 'slash':
					$separator = '/';
					break;
				default:
					$separator = ' ';
					break;
			}
		}
		$prefix .= $separator;
		$string = rwp_add_prefix($string, $prefix);
		$string = rwp_change_case($string, $case);
		return $string;
	}

	/**
	 * Remove plugin prefix from option name.
	 *
	 * @param  string $name  The option name to remove the prefix from.
	 *
	 * @return string
	 */
	public function unprefix($name) {
		$prefix = $this->prefix;
		$pattern = "/^({$prefix})[\-|\_|\/|\s]/";
		if (preg_match($pattern, $name)) {
			preg_match($pattern, $name, $matches);
			$prefix = $matches[0];
			$name = substr($name, strlen($prefix));
		}
		return $name;
	}
}
