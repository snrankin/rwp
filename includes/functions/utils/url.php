<?php

/**
 * ============================================================================
 * RWP URL Utilities
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ==========================================================================
 */

/**
 * Is URL
 *
 * Really this is just an easier to remember function for checking if a string is
 * a url.
 *
 * @param string $url
 *
 * @return bool Whether or not the string is a url
 */
function rwp_is_url( $url = '' ) {
	if ( empty( $url ) ) {
        return false;
    }
	$is_url = false;
	$wp_content_dir = rwp_add_prefix( basename( WP_CONTENT_DIR ), '/' );
	if ( rwp_str_starts_with( $url, array( 'http', $wp_content_dir, 'tel:', 'mailto:' ) ) ) {
		$is_url = true;
	}

	return $is_url;
}

/**
 * Check if a url is already relative
 *
 * @param string $input The string to check
 *
 * @return bool
 */

function rwp_is_relative_url( $input ) {
    $input = wp_parse_url( $input );

    if ( empty( $input ) ) {
        return false;
    }

    return ! rwp_array_has( 'scheme', $input );
}

/**
 * Check if a url is for an outbound site
 *
 * @param string $link The string to check
 *
 * @return bool
 */

function rwp_is_outbound_link( $link ) {
	if ( ! is_string( $link ) ) {
        return false;
	}

	$is_url = rwp_is_url( $link );
	$is_relative = rwp_is_relative_url( $link );
	$is_email = rwp_is_email( $link ) || rwp_str_starts_with( $link, 'mailto' ) ? true : false;
	$is_phone = rwp_is_phone_number( $link ) || rwp_str_starts_with( $link, 'tel' ) ? true : false;

	if ( $is_url && ! $is_relative && ! $is_email && ! $is_phone ) {
		$home = wp_parse_url( network_home_url(), PHP_URL_HOST );
		$input = wp_parse_url( $link, PHP_URL_HOST );
		if ( rwp_str_starts_with( $input, $home ) ) {
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}

/**
 * Make a URL relative
 *
 * @param string $input The url to check
 *
 * @return string The relative url
 */
function rwp_relative_url( $input ) {
	if ( ! rwp_is_url( $input ) ) {
		return $input;
	}

	$use_relative_urls = rwp_get_option( 'modules.relative_urls', false );

	if ( ! $use_relative_urls ) {
		return $input;
	}

	$is_relative = rwp_is_relative_url( $input );
	$is_outbound = rwp_is_outbound_link( $input );
	$is_email = rwp_is_email( $input );
	$is_phone = rwp_is_phone_number( $input );

	if ( ! $is_relative && ! $is_outbound && ! $is_email && ! $is_phone ) {
		$link          = $input;
		$url           = wp_parse_url( $input );
		$hosts_match   = true;
		$schemes_match = true;
		$ports_match   = true;
		if ( is_array( $url ) ) {
			if ( ! rwp_array_has( 'host', $url ) || ! rwp_array_has( 'path', $url ) ) {
				return $input;
			}
			$site_url = wp_parse_url( network_home_url() );  // falls back to home_url

			if ( is_array( $site_url ) ) {

				if ( rwp_array_has( 'host', $url ) && rwp_array_has( 'host', $site_url ) ) {

					$hosts_match = $site_url['host'] === $url['host'];
				}

				if ( rwp_array_has( 'scheme', $url ) && rwp_array_has( 'scheme', $site_url ) ) {

					$schemes_match = $site_url['scheme'] === $url['scheme'];
				}

				if ( rwp_array_has( 'port', $url ) && rwp_array_has( 'port', $site_url ) ) {

					$ports_match = $site_url['port'] === $url['port'];
				}
			}
		}
		if ( $hosts_match && $schemes_match && $ports_match ) {
			$input = wp_make_link_relative( $input );
		}

		$input = apply_filters( 'rwp_relative_url', $input, $link );

		return $input;
	} else {
		return $input;
	}
}


/**
 * Compare URL against relative URL
 *
 * @param  string $url
 * @param  string $rel
 * @return bool
 */
function rwp_url_compare( $url, $rel ) {
     $url = trailingslashit( $url );
    $rel = trailingslashit( $rel );
    return ( ( strcasecmp( $url, $rel ) === 0 ) || rwp_relative_url( $url ) === $rel );
}

/**
 * Formats a phone number string for use in urls
 *
 * @uses rwp_is_phone_number()
 *
 * @param string $number The number to ouput
 *
 * @return string $number The formatted number string
 */
function rwp_format_phone_url( $number = '' ) {
	if ( ! rwp_is_phone_number( $number ) ) {
        return $number;
	}

    $formatted_number = preg_replace( '/\s*\D*/', '', $number );

	if ( ! empty( $formatted_number ) ) {
		return $formatted_number;
	} else {
		return $number;
	}
}
