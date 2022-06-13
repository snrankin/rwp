<?php

/**
 * RWP
 *
 * @package   RWP
 * @author    RIESTER Advertising Agency <wordpress@riester.com>
 * @copyright 2020 RIESTER Advertising Agency
 * @license   GPL 2.0+
 * @link      https://www.riester.com
 */

namespace RWP\Backend;

use RWP\Engine\Abstracts\Singleton;
/**
 * Create the settings page in the backend
 */
class Settings extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		\add_filter( 'plugin_action_links_' . plugin_basename( RWP_PLUGIN_FILE ), array( $this, 'add_action_links' ), );
		\add_filter( 'admin_body_class', array( $this, 'add_plugin_class' ) );
	}

	/**
	 * Add class in the body on the backend
	 *
	 * @param array $classes The array with all the classes of the page.
	 * @since 1.0.0
	 * @return array
	 */
	public static function add_plugin_class( $classes ) {

		$classes = rwp_output_classes( rwp_parse_classes( $classes, rwp()->get_slug() ) );

		return $classes;
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 * @param array $links Array of links.
	 * @return array
	 */
	public function add_action_links( array $links ) {
		$url = rwp()->get_settings_uri();
		return array_merge(
			array(
				'settings' => '<a href="' . $url . '">' . \__( 'Settings', 'rwp' ) . '</a>',
			),
				$links,
			);
	}
}
