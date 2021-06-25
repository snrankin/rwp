<?php

/** ============================================================================
 * RWP String Utilities
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ========================================================================== */

use \RWP\Vendor\Illuminate\Support\{Pluralizer, Str};

if (!defined('RWP_TITLE_CASE')) {
	define('RWP_TITLE_CASE', array());
}

/**
 * Check if a variable had value
 *
 * @param mixed $input
 *
 * @return bool
 */

function rwp_has_value($input) {
	return filled($input);
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
 * @param  string  $string  The string to convert
 * @param  string  $case    The case to covert the string to.
 *
 * @return string
 */
function rwp_change_case($string = '', $case = 'kebab') {
	switch ($case) {
		case 'title':
			$string = Str::title($string);
			break;
		case 'lower':
			$string = Str::lower($string);
			break;
		case 'snake':
			$string = Str::snake($string);
			break;
		case 'kebab':
			$string = Str::kebab($string);
			break;
		case 'slug':
			$string = Str::slug($string);
			break;
		case 'camel':
			$string = Str::camel($string);
			break;
	}

	return $string;
}
/**
 * Determine if a given string contains a given substring.
 *
 * @param  string           $haystack
 * @param  string|string[]  $needles
 * @return bool
 */
function rwp_string_has($haystack, $needles) {

	return Str::contains($haystack, $needles);
}

/**
 * Converts a string to a plural form (English only).
 *
 * @uses  Pluralizer::plural()
 * @param string $string
 *
 * @return string
 */

function rwp_pluralizer($string = '') {
	return Pluralizer::plural($string);
}

/**
 * Converts a string to the singular form (English only).
 *
 * @uses  Pluralizer::singular()
 * @param string $string
 *
 * @return string
 */

function rwp_singulizer($string = '') {
	return Pluralizer::singular($string);
}

/**
 * Determine if a given string starts with a given substring.
 *
 * @param  string           $haystack
 * @param  string|string[]  $needles
 * @return bool
 */
function rwp_str_starts_with($haystack, $needles) {
	return Str::startsWith($haystack, $needles);
}

/**
 * Determine if a given string ends with a given substring.
 *
 * @param  string           $haystack
 * @param  string|string[]  $needles
 * @return bool
 */

function rwp_str_ends_with($haystack, $needles) {
	return Str::endsWith($haystack, $needles);
}

/**
 * Remove any occurrence of the given string in the subject.
 *
 * @param  string|array<string>  $search
 * @param  string                $subject
 * @param  bool                  $case_sensitive
 *
 * @return string
 */

function rwp_str_remove($search, $subject, $case_sensitive = true) {
	return Str::remove($search, $subject, $case_sensitive);
}

/**
 * Add prefix to string
 *
 * @param  string  $string  The string to prefix.
 * @param  string  $prefix  The prefix to add
 *
 * @return string
 */
function rwp_add_prefix($string = '', $prefix = '') {
	if (empty($prefix) || empty($string)) {
		return $string;
	}

	if (!rwp_str_starts_with($string, $prefix)) {
		$string = Str::start($string, $prefix);
	}
	return $string;
}

/**
 * Remove prefix from string.
 *
 * @param  string  $string  The string to prefix.
 * @param  string  $prefix  The prefix to remove
 *
 * @return string
 */
function rwp_remove_prefix($string = '', $prefix = '') {
	if (empty($prefix) || empty($string)) {
		return $string;
	}
	if (rwp_str_starts_with($string, $prefix)) {
		$string = Str::after($string, $prefix);
	}
	return $string;
}

/**
 * Add suffix to string
 *
 * @param  string  $string  The string to add a suffix.
 * @param  string  $suffix  The suffix to use
 *
 * @return string
 */
function rwp_add_suffix($string = '', $suffix = '') {
	if (empty($suffix) || empty($string)) {
		return $string;
	}

	if (!rwp_str_ends_with($string, $suffix)) {
		$string = Str::finish($string, $suffix);
	}
	return $string;
}

/**
 * Remove suffix from string
 *
 * @param  string  $string  The string to prefix.
 * @param  string  $suffix  The suffix to remove
 *
 * @return string
 */
function rwp_remove_suffix($string = '', $suffix = '') {
	if (empty($suffix) || empty($string)) {
		return $string;
	}
	if (rwp_str_starts_with($string, $suffix)) {
		$string = Str::before($string, $suffix);
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
function rwp_is_phone_number($str = '') {
	if (!is_string($str)) {
		return $str;
	}
	$str         = rwp_remove_prefix($str, 'tel:');
	$phone_regex = "/(?(DEFINE)(?'spacers'\s?\.?\-?))^\+?\d?(?P>spacers)((\(\d{3}\)?)|(\d{3}))(?P>spacers)(\d{3})(?P>spacers)(\d{4})/";
	preg_match($phone_regex, $str, $matches);

	if (!empty($matches)) {
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
 * @param string       $text          The text to trim
 * @param int          $length        Max length of excerpt (will vary if
 *                                    $variable = true). So 0 to disable
 * @param bool         $variable      Should the sentence finish or should there
 *                                    be a hard cut off.
 * @param string       $excerpt_end   Text to append to the end of the trimmed
 *                                    text
 * @param array|false  $allowed_tags  Allowable html tags. Set to false for plain
 *                                    text
 *
 * @return string
 */

function rwp_trim_text($text = '', $length = 0, $variable = true, $excerpt_end = '', $allowed_tags = array()) {

	global $allowedtags;


	if (is_array($allowed_tags) && empty($allowed_tags)) {
		$allowed_tags = $allowedtags;
	}

	if (!empty($text)) {
		$text   = preg_replace("/\r|\n|\h{2,}|\t/", "", $text);
		$text   = strip_tags($text, $allowed_tags);
		$tokens = array();
		$out    = '';
		$word   = 0;

		if (!empty($length)) {
			//Divide the string into tokens; HTML tags, or words, followed by any whitespace.
			$regex = '/(<[^>]+>|[^<>\s]+)\s*/u';
			preg_match_all($regex, $text, $tokens);
			foreach ($tokens[0] as $t) {
				//Parse each token
				if ($word >= $length && !$variable) {
					//Limit reached
					break;
				}
				if ('<' !== $t[0]) {
					//Token is not a tag.
					//Regular expression that checks for the end of the sentence: '.', '?' or '!'
					$regex1 = '/[\?\.\!]\s*$/uS';
					if ($word >= $length && $variable && preg_match($regex1, $t) === 1) {
						//Limit reached, continue until ? . or ! occur to reach the end of the sentence.
						$out .= trim($t);
						break;
					}
					$word++;
				}
				$out .= $t;
			}
		} else {
			$out = $text;
		}

		$out .= $excerpt_end;

		return trim(force_balance_tags($out));
	} else {
		return '';
	}
}


function rwp_render_time($args = []) {

	$start = '';
	$end = '';
	$separator = ' &ndash; ';
	$format = 'F j, Y';

	extract($args);

	$rendered = '';
	$start_time = '';
	$end_time = '';
	if (!empty($start)) {
		if (!is_numeric($start)) {
			$start_time = strtotime($start);
		} else {
			$start_time = $start;
		}

		$start = date_i18n($format, $start_time);
	}
	if (!empty($end)) {
		if (!is_numeric($end)) {
			$end_time = strtotime($end);
		} else {
			$end_time = $end;
		}
		$end = date_i18n($format, $end_time);
	}

	if (!empty($start)) {
		$rendered .= $start;
		if (!empty($end) && $end_time !== $start_time) {
			$rendered .= $separator;
		}
	}

	if (!empty($end) && $end_time !== $start_time) {
		$rendered .= $end;
	}

	return $rendered;
}
