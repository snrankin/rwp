<?php

/** ============================================================================
 * BugHerd
 *
 * @package   RWP\Integrations
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Base\Singleton;

class BugHerd extends Singleton {

	/**
	 *
	 * @var string The project api key
	 */

	protected static $api_key;

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! rwp_get_option( 'modules.bugherd.enable', false ) ) {
			return;
		}

		$api_key = self::$api_key;

		if ( empty( $api_key ) && ! empty( rwp_get_option( 'modules.bugherd.project_key', '' ) ) ) {
			$api_key = rwp_get_option( 'modules.bugherd.project_key', '' );
			self::$api_key = sanitize_text_field( $api_key );
		}

		if ( $api_key ) {
			$url = add_query_arg( 'apikey', $api_key, 'https://www.bugherd.com/sidebarv2.js' );

			if ( rwp_get_option( 'modules.bugherd.frontend', true ) ) {
				\add_action('wp_head', function () use ( $url ) {
					echo wp_sprintf('<script type="text/javascript" src="%s" async="true"></script>', $url); // phpcs:ignore
				});
			}

			if ( rwp_get_option( 'modules.bugherd.backend', true ) ) {
				\add_action('admin_head', function () use ( $url ) {
					echo wp_sprintf('<script type="text/javascript" src="%s" async="true"></script>', $url);  // phpcs:ignore
				});
			}
		}
	}
}
