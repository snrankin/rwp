<?php
/** ============================================================================
 * Transients used by the plugin
 *
 * @package   RWP\Internals
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals;

use RWP\Engine\Abstracts\Singleton;
use stdClass;

/**
 * Transient used by the plugin
 */
class Transient extends Singleton {

	/**
	 * This method contain an example of caching a transient with an external request.
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public function transient_caching_example() {
		$key = 'placeholder_json_transient';

		// Use wp-cache-remember package to retrive or save in transient
		return \remember_transient(
		$key,
		static function () {
			// If there's no cached version we ask
			$response = \wp_remote_get( 'https://jsonplaceholder.typicode.com/todos/' );

			if ( \is_wp_error( $response ) ) {
				// In case API is down we return an empty object
				return new stdClass();
			}

			// If everything's okay, parse the body and json_decode it
			return \json_decode( \wp_remote_retrieve_body( $response ) );
		},
		DAY_IN_SECONDS
		);
	}

	/**
	 * Print the transient content
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function print_transient_output() {
		$transient = $this->transient_caching_example();
		echo '<div class="siteapi-bridge-container">';

		foreach ( $transient as $value ) {
			echo '<div class="siteapi-bridge-single">';
			// $transient is an object so use -> to call children
			echo '</div>';
		}

		echo '</div>';
	}

}
