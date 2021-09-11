<?php
/** ============================================================================
 * RIESTERRX rest
 *
 * @package WordPress
 * @subpackage RIESTERRX
 * @since RIESTERRX 1.0.0
 * ========================================================================== */



/**
 * Get WordPress Rest Data
 *
 * @param array|string $args
 * @param string $endpoint
 * @param bool|int $single
 *
 * @return bool|mixed \WP_REST_Response data or false
 */

function rwp_get_rest_data($args = [], $endpoint = 'posts', $single = false, $data = true) {

	$request = '';
	if (is_array($args)) {
		$path = "wp/v2/$endpoint";
		if ($single) {
			$path .= "/$single";
		}
		$url = rest_url($path);
		$url = add_query_arg($args, $url);
		$request = WP_REST_Request::from_url($url);
	} else if (rwp_is_url($args)) {
		$request = WP_REST_Request::from_url($args);
	}

	/**
	 * @var WP_REST_Response $response REST response.
	 */
	$response = rest_do_request($request);

	if (!$response->is_error()) {
		if ($data) {
			$response = $response->get_data();
		}
		return $response;
	} else {
		return $response;
	}
}
