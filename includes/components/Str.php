<?php
/** ============================================================================
 * String
 *
 * @package   RWP\/includes/components/String.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Traits\Macroable;
use RWP\Vendor\Illuminate\Support\Arr;
use RWP\Vendor\Exceptions\Http\Server\NotImplementedException;
class Str {

    use Macroable;
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snake_cache = [];
    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camel_cache = [];
    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studly_cache = [];

	/**
     * The cache of title-cased words.
     *
     * @var array
     */
    protected static $title_leave_alone = [
		'and',
		'as',
		'as if',
		'as long as',
		'at',
		'but',
		'by',
		'even if',
		'for',
		'from',
		'if',
		'if only',
		'in',
		'into',
		'like',
		'near',
		'now that',
		'nor',
		'of',
		'off',
		'on',
		'on top of',
		'once',
		'onto',
		'or',
		'out of',
		'over',
		'past',
		'so',
		'so that',
		'than',
		'that',
		'till',
		'to',
		'up',
		'upon',
		'with',
		'when',
		'yet',
	];

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function after( $subject, $search ) {
        return '' === $search ? $subject : \array_reverse( \explode( $search, $subject, 2 ) )[0];
    }
    /**
     * Return the remainder of a string after the last occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function afterLast( $subject, $search ) {
        if ( '' === $search ) {
            return $subject;
        }
        $position = \strrpos( $subject, (string) $search );
        if ( false === $position ) {
            return $subject;
        }
        return \substr( $subject, $position + \strlen( $search ) );
    }

    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function before( $subject, $search ) {
        if ( '' === $search ) {
            return $subject;
        }
        $result = \strstr( $subject, (string) $search, \true );
        return false === $result ? $subject : $result;
    }
    /**
     * Get the portion of a string before the last occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function beforeLast( $subject, $search ) {
        if ( '' === $search ) {
            return $subject;
        }
        $position = \mb_strrpos( $subject, $search );
        if ( false === $position ) {
            return $subject;
        }
        return static::substr( $subject, 0, $position );
    }
    /**
     * Get the portion of a string between two given values.
     *
     * @param  string  $subject
     * @param  string  $from
     * @param  string  $to
     * @return string
     */
    public static function between( $subject, $from, $to ) {
        if ( '' === $from || '' === $to ) {
            return $subject;
        }
        return static::beforeLast( static::after( $subject, $from ), $to );
    }
    /**
     * Convert a value to camel case.
     *
     * @param  string  $value
     * @return string
     */
    public static function camel( $value ) {
        if ( isset( static::$camel_cache[ $value ] ) ) {
            return static::$camel_cache[ $value ];
        }
		static::$camel_cache[ $value ] = \lcfirst( static::studly( $value ) );
        return static::$camel_cache[ $value ];
    }
    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     * @return bool
     */
    public static function contains( $haystack, $needles ) {
        foreach ( (array) $needles as $needle ) {
            if ( '' !== $needle && \mb_strpos( $haystack, $needle ) !== \false ) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Determine if a given string contains all array values.
     *
     * @param  string  $haystack
     * @param  string[]  $needles
     * @return bool
     */
    public static function containsAll( $haystack, array $needles ) {
        foreach ( $needles as $needle ) {
            if ( ! static::contains( $haystack, $needle ) ) {
                return \false;
            }
        }
        return \true;
    }
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     * @return bool
     */
    public static function endsWith( $haystack, $needles ) {
        foreach ( (array) $needles as $needle ) {
            if ( '' !== $needle && null !== $needle && \substr( $haystack, -\strlen( $needle ) ) === (string) $needle ) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $cap
     * @return string
     */
    public static function finish( $value, $cap ) {
        $quoted = \preg_quote( $cap, '/' );
        return \preg_replace( '/(?:' . $quoted . ')+$/u', '', $value ) . $cap;
    }
    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string|array  $pattern
     * @param  string  $value
     * @return bool
     */
    public static function is( $pattern, $value ) {
        $patterns = Arr::wrap( $pattern );
        $value = (string) $value;
        if ( empty( $patterns ) ) {
            return \false;
        }
        foreach ( $patterns as $pattern ) {
            $pattern = (string) $pattern;
            // If the given value is an exact match we can of course return true right
            // from the beginning. Otherwise, we will translate asterisks and do an
            // actual pattern match against the two strings to see if they match.
            if ( $pattern == $value ) {
                return \true;
            }
            $pattern = \preg_quote( $pattern, '#' );
            // Asterisks are translated into zero-or-more regular expression wildcards
            // to make it convenient to check if the strings starts with the given
            // pattern such as "library/*", making any string check convenient.
            $pattern = \str_replace( '\\*', '.*', $pattern );
            if ( \preg_match( '#^' . $pattern . '\\z#u', $value ) === 1 ) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Determine if a given string is a valid UUID.
     *
     * @param  string  $value
     * @return bool
     */
    public static function isUuid( $value ) {
        if ( ! \is_string( $value ) ) {
            return \false;
        }
        return \preg_match( '/^[\\da-f]{8}-[\\da-f]{4}-[\\da-f]{4}-[\\da-f]{4}-[\\da-f]{12}$/iD', $value ) > 0;
    }
    /**
     * Convert a string to kebab case.
     *
     * @param  string  $value
     * @return string
     */
    public static function kebab( $value ) {
        return static::snake( $value, '-' );
    }
    /**
     * Return the length of the given string.
     *
     * @param  string  $value
     * @param  string|null  $encoding
     * @return int
     */
    public static function length( $value, $encoding = null ) {
        if ( $encoding ) {
            return \mb_strlen( $value, $encoding );
        }
        return \mb_strlen( $value );
    }
    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int  $limit
     * @param  string  $end
     * @return string
     */
    public static function limit( $value, $limit = 100, $end = '...' ) {
        if ( \mb_strwidth( $value, 'UTF-8' ) <= $limit ) {
            return $value;
        }
        return \rtrim( \mb_strimwidth( $value, 0, $limit, '', 'UTF-8' ) ) . $end;
    }
    /**
     * Convert the given string to lower-case.
     *
     * @param  string  $value
     * @return string
     */
    public static function lower( $value ) {
        return \mb_strtolower( $value, 'UTF-8' );
    }
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int  $words
     * @param  string  $end
     * @return string
     */
    public static function words( $value, $words = 100, $end = '...' ) {
        \preg_match( '/^\\s*+(?:\\S++\\s*+){1,' . $words . '}/u', $value, $matches );
        if ( ! isset( $matches[0] ) || static::length( $value ) === static::length( $matches[0] ) ) {
            return $value;
        }
        return \rtrim( $matches[0] ) . $end;
    }

    /**
     * Get the string matching the given pattern.
     *
     * @param  string  $pattern
     * @param  string  $subject
     * @return string
     */
    public static function match( $pattern, $subject ) {
        \preg_match( $pattern, $subject, $matches );
        if ( ! $matches ) {
            return '';
        }
        return $matches[1] ?? $matches[0];
    }
    /**
     * Get the string matching the given pattern.
     *
     * @param  string  $pattern
     * @param  string  $subject
     * @return Collection
     */
    public static function matchAll( $pattern, $subject ) {
        \preg_match_all( $pattern, $subject, $matches );
        if ( empty( $matches[0] ) ) {
            return collect();
        }
        return collect( $matches[1] ?? $matches[0] );
    }
    /**
     * Pad both sides of a string with another.
     *
     * @param  string  $value
     * @param  int  $length
     * @param  string  $pad
     * @return string
     */
    public static function padBoth( $value, $length, $pad = ' ' ) {
        return \str_pad( $value, $length, $pad, \STR_PAD_BOTH );
    }
    /**
     * Pad the left side of a string with another.
     *
     * @param  string  $value
     * @param  int  $length
     * @param  string  $pad
     * @return string
     */
    public static function padLeft( $value, $length, $pad = ' ' ) {
        return \str_pad( $value, $length, $pad, \STR_PAD_LEFT );
    }
    /**
     * Pad the right side of a string with another.
     *
     * @param  string  $value
     * @param  int  $length
     * @param  string  $pad
     * @return string
     */
    public static function padRight( $value, $length, $pad = ' ' ) {
        return \str_pad( $value, $length, $pad, \STR_PAD_RIGHT );
    }
    /**
     * Parse a Class[@]method style callback into class and method.
     *
     * @param  string  $callback
     * @param  string|null  $default
     * @return array<int, string|null>
     */
    public static function parseCallback( $callback, $default = null ) {
        return static::contains( $callback, '@' ) ? \explode( '@', $callback, 2 ) : [ $callback, $default ];
    }
    /**
     * Get the plural form of an English word.
     *
     * @param  string  $value
     * @param  int  $count
     * @return string
     */
    public static function plural( $value, $count = 2 ) {
        return Pluralizer::plural( $value, $count );
    }
    /**
     * Pluralize the last word of an English, studly caps case string.
     *
     * @param  string  $value
     * @param  int  $count
     * @return string
     */
    public static function pluralStudly( $value, $count = 2 ) {
        $parts = \preg_split( '/(.)(?=[A-Z])/u', $value, -1, \PREG_SPLIT_DELIM_CAPTURE );
        $last_word = \array_pop( $parts );
        return \implode( '', $parts ) . self::plural( $last_word, $count );
    }
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     */
    public static function random( $length = 16 ) {
        $string = '';
		$len = \strlen( $string );
        while ( $len < $length ) {
            $size = $length - $len;
            $bytes = \random_bytes( $size );
            $string .= \substr( \str_replace( [ '/', '+', '=' ], '', \base64_encode( $bytes ) ), 0, $size );
        }
        return $string;
    }
    /**
     * Repeat the given string.
     *
     * @param  string  $string
     * @param  int  $times
     * @return string
     */
    public static function repeat( string $string, int $times ) {
        return \str_repeat( $string, $times );
    }
    /**
     * Replace a given value in the string sequentially with an array.
     *
     * @param  string  $search
     * @param  array<int|string, string>  $replace
     * @param  string  $subject
     * @return string
     */
    public static function replaceArray( $search, array $replace, $subject ) {
        $segments = \explode( $search, $subject );
        $result = \array_shift( $segments );
        foreach ( $segments as $segment ) {
            $result .= ( \array_shift( $replace ) ?? $search ) . $segment;
        }
        return $result;
    }
    /**
     * Replace the given value in the given string.
     *
     * @param  string|string[]  $search
     * @param  string|string[]  $replace
     * @param  string|string[]  $subject
     * @return string
     */
    public static function replace( $search, $replace, $subject ) {
        return \str_replace( $search, $replace, $subject );
    }
    /**
     * Replace the first occurrence of a given value in the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    public static function replaceFirst( $search, $replace, $subject ) {
        if ( '' === $search ) {
            return $subject;
        }
        $position = \strpos( $subject, $search );
        if ( false !== $position ) {
            return \substr_replace( $subject, $replace, $position, \strlen( $search ) );
        }
        return $subject;
    }
    /**
     * Replace the last occurrence of a given value in the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    public static function replaceLast( $search, $replace, $subject ) {
        if ( '' === $search ) {
            return $subject;
        }
        $position = \strrpos( $subject, $search );
        if ( false !== $position ) {
            return \substr_replace( $subject, $replace, $position, \strlen( $search ) );
        }
        return $subject;
    }
    /**
     * Remove any occurrence of the given string in the subject.
     *
     * @param  string|array<string>  $search
     * @param  string  $subject
     * @param  bool  $case_sensitive
     * @return string
     */
    public static function remove( $search, $subject, $case_sensitive = \true ) {
        $subject = $case_sensitive ? \str_replace( $search, '', $subject ) : \str_ireplace( $search, '', $subject );
        return $subject;
    }
    /**
     * Begin a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $prefix
     * @return string
     */
    public static function start( $value, $prefix ) {
        $quoted = \preg_quote( $prefix, '/' );
        return $prefix . \preg_replace( '/^(?:' . $quoted . ')+/u', '', $value );
    }
    /**
     * Convert the given string to upper-case.
     *
     * @param  string  $value
     * @return string
     */
    public static function upper( $value ) {
        return \mb_strtoupper( $value, 'UTF-8' );
    }
    /**
     * Convert the given string to title case.
     *
     * @param  string  $value
     * @return string
     */
    public static function title( $value ) {
		$value = explode( ' ', $value );
		$prepositions = self::$title_leave_alone;
		$leave_alone = (array) apply_filters( 'rwp_title_leave_alone', $prepositions );

		$leave_alone = implode( '|', $leave_alone );
		$leave_alone = "/$leave_alone/";

		foreach ( $value as $index => $item ) {
			if ( 0 !== $index ) {
				if ( ! in_array( $item, $prepositions ) && ! preg_match( $leave_alone, $item ) ) {
					$item = \mb_convert_case( $item, \MB_CASE_TITLE, 'UTF-8' );
				}
			} else {
				$item = \mb_convert_case( $item, \MB_CASE_TITLE, 'UTF-8' );
			}

			$value[ $index ] = $item;
		}

		$value = implode( ' ', $value );

		return $value;
    }
    /**
     * Get the singular form of an English word.
     *
     * @param  string  $value
     * @return string
     */
    public static function singular( $value ) {
        return Pluralizer::singular( $value );
    }
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string|null  $language
     * @return string
     */
    public static function slug( $title, $separator = '-', $language = 'en' ) {
        $title = $language ? sanitize_title( $title, $language ) : $title;
        // Convert all dashes/underscores into separator
        $flip = '-' === $separator ? '_' : '-';
        $title = \preg_replace( '![' . \preg_quote( $flip ) . ']+!u', $separator, $title );
        // Replace @ with the word 'at'
        $title = \str_replace( '@', $separator . 'at' . $separator, $title );
        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = \preg_replace( '![^' . \preg_quote( $separator ) . '\\pL\\pN\\s]+!u', '', static::lower( $title ) );
        // Replace all separator characters and whitespace by a single separator
        $title = \preg_replace( '![' . \preg_quote( $separator ) . '\\s]+!u', $separator, $title );
        return \trim( $title, $separator );
    }
    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
     */
    public static function snake( $value, $delimiter = '_' ) {
        $key = $value;
        if ( isset( static::$snake_cache[ $key ][ $delimiter ] ) ) {
            return static::$snake_cache[ $key ][ $delimiter ];
        }
        if ( ! \ctype_lower( $value ) ) {
            $value = \preg_replace( '/\\s+/u', '', \ucwords( $value ) );
            $value = static::lower( \preg_replace( '/(.)(?=[A-Z])/u', '$1' . $delimiter, $value ) );
        }
		static::$snake_cache[ $key ][ $delimiter ] = $value;
        return static::$snake_cache[ $key ][ $delimiter ];
    }
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     * @return bool
     */
    public static function startsWith( $haystack, $needles ) {
        foreach ( (array) $needles as $needle ) {
            if ( '' !== (string) $needle && \strncmp( $haystack, $needle, \strlen( $needle ) ) === 0 ) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     * @return string
     */
    public static function studly( $value ) {
        $key = $value;
        if ( isset( static::$studly_cache[ $key ] ) ) {
            return static::$studly_cache[ $key ];
        }
        $value = \ucwords( \str_replace( [ '-', '_' ], ' ', $value ) );
		static::$studly_cache[ $key ] = \str_replace( ' ', '', $value );
        return static::$studly_cache[ $key ];
    }
    /**
     * Returns the portion of the string specified by the start and length parameters.
     *
     * @param  string  $string
     * @param  int  $start
     * @param  int|null  $length
     * @return string
     */
    public static function substr( $string, $start, $length = null ) {
        return \mb_substr( $string, $start, $length, 'UTF-8' );
    }
    /**
     * Returns the number of substring occurrences.
     *
     * @param  string  $haystack
     * @param  string  $needle
     * @param  int  $offset
     * @param  int|null  $length
     * @return int
     */
    public static function substrCount( $haystack, $needle, $offset = 0, $length = null ) {
        if ( ! \is_null( $length ) ) {
            return \substr_count( $haystack, $needle, $offset, $length );
        } else {
            return \substr_count( $haystack, $needle, $offset );
        }
    }
    /**
     * Make a string's first character uppercase.
     *
     * @param  string  $string
     * @return string
     */
    public static function ucfirst( $string ) {
        return static::upper( static::substr( $string, 0, 1 ) ) . static::substr( $string, 1 );
    }
    /**
     * Get the number of words a string contains.
     *
     * @param  string  $string
     * @return int
     */
    public static function wordCount( $string ) {
        return \str_word_count( $string );
    }

}
