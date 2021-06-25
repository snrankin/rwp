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


use RWP\Engine\Base;
/**
 * Create the settings page in the backend
 */
class Settings extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		\add_filter( 'plugin_action_links_' . \plugin_basename( RWP_PLUGIN_ABSOLUTE ), array( $this, 'add_action_links' ), );

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 * @param array $links Array of links.
	 * @return array
	 */
	public function add_action_links( array $links ) {
		$url = $this->get_setting( 'url' );
		return array_merge(
			array(
				'settings' => '<a href="' . $url . '">' . \__( 'Settings', 'rwp' ) . '</a>',
			),
				$links,
			);
	}
}
