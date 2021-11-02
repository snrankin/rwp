<?php

/**
 * ============================================================================
 * RWP String Utilities
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ==========================================================================
 */

use RWP\Components\Str;

if ( ! defined( 'RWP_TITLE_CASE' ) ) {
	define( 'RWP_TITLE_CASE', array() );
}

if ( ! function_exists( 'str_contains' ) ) {
	function str_contains() { // phpcs:ignore
		return Str::contains( ...func_get_args() );
	}
}
/**
 * Change Case
 *
 * Changes the case of a string into the chosen format. Can be one of:
 * * `kebab` - (kebab-case)
 * * `slug`  - (slug-case)
 * * `title` - (Title Case)
 * * `lower` - (lower case)
 * * `snake` - (snake_case)
 * * `camel` - (camelCase)
 *
 * @param string $string The string to convert
 * @param string $case   The case to covert the string to.
 *
 * @return string
 */
function rwp_change_case( $string = '', $case = 'slug' ) {

	$original = $string;
	switch ( $case ) {
		case 'title':
			$string = preg_replace( '/((?<=\w)-(?=\w)|\_)/m', ' ', $string );
			$string = Str::title( $string );
			break;
		case 'lower':
			$string = Str::lower( $string );
			break;
		case 'snake':
			$string = Str::snake( $string );
			$string = str_replace( '-', '_', $string );
			break;
		case 'kebab':
			$string = Str::kebab( $string );
			$string = str_replace( '_', '-', $string );
			break;
		case 'slug':
			$string = Str::slug( $string );
			$string = str_replace( '_', '-', $string );
			break;
		case 'camel':
			$string = Str::camel( $string );
			break;
	}

	$string = apply_filters( 'rwp_change_case', $string, $original, $case );

	return $string;
}

/**
 * Determine if a given string contains a given substring.
 *
 * @param  string          $haystack
 * @param  string|string[] $needles
 * @return bool
 */
function rwp_str_has( $haystack, $needles ) {
	return Str::contains( $haystack, $needles );
}

/**
 * Converts a string to a plural form (English only).
 *
 * @uses  Pluralizer::plural()
 * @param string $string
 *
 * @return string
 */

function rwp_pluralizer( $string = '' ) {
	return Str::plural( $string );
}

/**
 * Converts a string to the singular form (English only).
 *
 * @uses  Pluralizer::singular()
 * @param string $string
 *
 * @return string
 */

function rwp_singulizer( $string = '' ) {
	return Str::singular( $string );
}

/**
 * Determine if a given string starts with a given substring.
 *
 * @param  string          $haystack
 * @param  string|string[] $needles
 * @return bool
 */
function rwp_str_starts_with( $haystack, $needles ) {
	return Str::startsWith( $haystack, $needles );
}

/**
 * Determine if a given string ends with a given substring.
 *
 * @param  string          $haystack
 * @param  string|string[] $needles
 * @return bool
 */

function rwp_str_ends_with( $haystack, $needles ) {
	return Str::endsWith( $haystack, $needles );
}

/**
 * Add prefix to string
 *
 * @param string $string The string to prefix.
 * @param string $prefix The prefix to add
 *
 * @return string
 */
function rwp_add_prefix( $string = '', $prefix = '' ) {
	if ( empty( $prefix ) || empty( $string ) ) {
		return $string;
	}

	if ( ! rwp_str_starts_with( $string, $prefix ) ) {
		$string = Str::start( $string, $prefix );
	}
	return $string;
}

/**
 * Remove prefix from string.
 *
 * @param string $string The string to prefix.
 * @param string $prefix The prefix to remove
 *
 * @return string
 */
function rwp_remove_prefix( $string = '', $prefix = '' ) {
	if ( empty( $prefix ) || empty( $string ) ) {
		return $string;
	}
	if ( rwp_str_starts_with( $string, $prefix ) ) {
		$string = Str::after( $string, $prefix );
	}
	return $string;
}

/**
 * Add suffix to string
 *
 * @param string $string The string to prefix.
 * @param string $suffix The suffix to use
 *
 * @return string
 */
function rwp_add_suffix( $string = '', $suffix = '' ) {
	if ( empty( $suffix ) || empty( $string ) ) {
		return $string;
	}

	if ( ! rwp_str_ends_with( $string, $suffix ) ) {
		$string = Str::finish( $string, $suffix );
	}
	return $string;
}

/**
 * Remove suffix from string
 *
 * @param string $string The string to prefix.
 * @param string $suffix The suffix to remove
 *
 * @return string
 */
function rwp_remove_suffix( $string = '', $suffix = '' ) {
	if ( empty( $suffix ) || empty( $string ) ) {
		return $string;
	}
	if ( rwp_str_starts_with( $string, $suffix ) ) {
		$string = Str::before( $string, $suffix );
	}
	return $string;
}

/**
 * Check if a string is a phone number based on a regex pattern
 *
 * @param string $str The string to check
 *
 * @return bool
 */
function rwp_is_phone_number( $str = '' ) {
	if ( ! is_string( $str ) ) {
		return $str;
	}
	$str         = rwp_remove_prefix( $str, 'tel:' );
	$phone_regex = "/(?(DEFINE)(?'spacers'\h|\.|\-))(?<country_code>\+?\d+)?(?P>spacers)*(?<area_code>\(?\d{3}\)?)(?P>spacers)*(?<group1>\d{3})(?P>spacers)*(?<group2>\d{4})(?<ext>\h.*)?/";
	preg_match( $phone_regex, $str, $matches );

	if ( ! empty( $matches ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Trim Text
 *
 * @global array       $allowedtags
 *
 * @param string          $text         The text to trim
 * @param int             $length       Max length of excerpt (will vary if
 *                                      $variable = true). So 0 to disable
 * @param bool            $variable     Should the sentence finish or should there
 *                                      be a hard cut off.
 * @param string          $excerpt_end  Text to append to the end of the trimmed
 *                                      text
 * @param string|string[] $allowed_tags Allowable html tags. Set to null for
 *                                      plain text
 * @param string          $trim_type    Trim content based on `words` or `chars`.
 *                                      Default:`words`
 *
 * @return string
 */

function rwp_trim_text( $text = '', $length = 0, $variable = true, $excerpt_end = '', $allowed_tags = array(), $trim_type = 'words' ) {
	/**
	 * @var string[] $allowedtags
	 */

	global $allowedtags;

	$allowedtags_keys = array_keys( $allowedtags );

	if ( is_string( $allowed_tags ) ) {
		$allowed_tags = explode( ',', $allowed_tags );
	}

	$allowed_tags = rwp_collection( $allowed_tags );
	$allowed_tags = $allowed_tags->merge( $allowedtags_keys )->unique()->all();

	$out    = '';

	if ( ! empty( $text ) ) {
		$text   = (string) preg_replace( "/\r|\n|\h{2,}|\t/", '', $text );

		$text = strip_tags( $text, $allowed_tags );

		if ( ! empty( $length ) ) {

			if ( $variable ) {
				$text = Str::match( '/(.*)[\?\.\!]\s*/Us', $text );
				$out = $text . $excerpt_end;
			} else {
				if ( 'chars' === $trim_type ) {
					$text = Str::limit( $text, $length, $excerpt_end );
					$out = $text;
				} else {
					$text = Str::words( $text, $length, $excerpt_end );
					$out = $text;
				}
			}
		} else {
			$out = $text . $excerpt_end;
		}
	}
	return trim( force_balance_tags( $out ) );
}
