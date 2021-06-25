<?php

/** ============================================================================
 * RWP html
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ========================================================================== */

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Vendor\Illuminate\Support\{Pluralizer, Str};

/**
 * Returns a sanitized and unique array of css classes
 *
 * @param mixed $classes The array|string|object of classes to parse
 * @param bool  $filter  Whether to run the classes through the
 *                       `sanitize_html_class()` function
 *
 * @return string[]
 */
function rwp_parse_classes( $classes, $filter = false ) {
	if ( empty( $classes ) ) {
		return $classes;
    }

	if ( is_string( $classes ) ) {
		$classes = explode( ' ', $classes );
	}

	if ( ! ( $classes instanceof Collection ) ) {
		$classes = new Collection( $classes );
	}

	$classes = $classes->unique();

	if ( $filter ) {
		$classes->transform( '\sanitize_html_class' );
	}

	$classes = rwp_collection_remove_empty_items( $classes );

	$classes = $classes->all();

	if ( empty( $classes ) ) {
		$classes = array();
	}

	return $classes;
}

/**
 * Returns a sanitized and unique array of css classes
 *
 * @param mixed $class_set_1 The first set of classes
 * @param mixed $class_set_2 The second set of classes
 * @param bool  $filter      Whether to run the classes through the
 *                          `sanitize_html_class()` function
 *
 * @return array
 */
function rwp_merge_classes( $class_set_1 = '', $class_set_2 = '', $filter = false ) {

	$class_set_1 = new Collection( rwp_parse_classes( $class_set_1, $filter ) );

	$class_set_2 = new Collection( rwp_parse_classes( $class_set_1, $filter ) );

	$classes = $class_set_1->merge( $class_set_2 );

	$classes = $classes->unique();

	return $classes->all();
}

/**
 * Returns a sanitized and unique array of css inline styles
 *
 * @param mixed $styles
 *
 * @return array|mixed $styles_array The processed styles
 */
function rwp_parse_styles( $styles ) {

	if ( empty( $styles ) ) {
		return $styles;
    }

	if ( is_string( $styles ) ) {
		$styles = explode( ';', $styles );
	}

	$styles = new Collection( $styles );

	$styles = rwp_collection_remove_empty_items( $styles );

	if ( $styles->isNotEmpty() ) {

		foreach ( $styles->all() as $key => $style ) {
			if ( is_numeric( $key ) && preg_match( '/[\w\-]\:\s*/', $style ) && rwp_has_value( $style ) ) {

				$styles->forget( $key );
				$style = explode( ':', $style );
				$key   = trim( $style[0] );
				$style = trim( $style[1] );
				if ( 'background-image' === $key ) {
					$style = "url('{$style}')";
				}
				$styles->put( $key, $style );
			}
		}
	}
	return $styles->all();
}


/**
 * Extract Html Attributes
 *
 * Takes a single-level html string and converts it into an array. So
 * `<p>Test</p>` becomes:
 * ```
 * $args = [
 *   'content' => 'Test',
 *   'atts'    => [
 *     'tag' => 'p'
 *   ],
 * ];
 *```
 *
 * @param string $str        The HTML string to parse
 * @param bool   $multilevel Whether the string contains multiple html nodes/tags
 *
 * @return array|false The "exploded" string or false if empty
 */
function rwp_extract_html_atts( $str = '', $multilevel = false ) {
	$self_closing = array(
		'area',
		'base',
		'br',
		'col',
		'embed',
		'hr',
		'img',
		'input',
		'link',
		'meta',
		'param',
		'source',
		'textarea',
		'track',
		'wbr',
	);
	if ( empty( $str ) || ! is_string( $str ) ) {
		return false;
    }
	$html = array();

	$str = trim( $str );
	$str = preg_replace( "/\r|\n|\h{2,}|\t/", ' ', $str );
	$str = is_string( $str ) ? force_balance_tags( $str ) : '';

	if ( empty( $str ) || ! is_string( $str ) ) {
		return false;
    }

	if ( $multilevel ) {
		preg_match_all( '/(?<original_tag>\<\w+[^>]*\/?\>)(?<content>[^><]*+)?/m', $str, $matches, PREG_SET_ORDER, 0 );
		if ( rwp_has_value( $matches ) ) {
			foreach ( $matches as $i => $match ) {
				if ( is_array( $match ) ) {
					$tag   = trim( $match['original_tag'] );
					$match = rwp_extract_html_atts( $tag );

					if ( $match ) {
						$html[ $i ] = $match;
					}
				}
			}
		}
	} else {

		$re = '/(?<original_tag>(?>\<)(?<tag>(?<=<)[^\s\>\/]+)(?<atts>[^>]*)(?>\/?\>)(?<content>(?:\s|\S)*+))/m';

		preg_match( $re, $str, $matches );

		if ( rwp_has_value( $matches ) ) {
			$html['original_tag'] = $matches['original_tag'];
			$tag                  = $matches['tag'];
			$atts                 = '';
			$content              = '';

			if ( rwp_array_has( 'atts', $matches ) ) {
				$atts = trim( $matches['atts'] );
			}

			if ( rwp_array_has( 'content', $matches ) ) {
				$content = trim( $matches['content'] );
			}

			if ( rwp_has_value( $atts ) ) {
				$re = '/(?<attr>[\w|\-|\_]+)(?|\=|\b)((?<quotes>\'|\")(?<val>.*?)?(?=(?P=quotes)))?/m';
				preg_match_all( $re, $atts, $matches, PREG_SET_ORDER, 0 );
				$atts = array();

				foreach ( $matches as $match ) {
					$val = '';
					if ( rwp_array_has( 'val', $match ) ) {
						$val = trim( $match['val'] );
					}
					$atts[ $match['attr'] ] = $val;
				}

				$html['atts'] = rwp_prepare_args( $atts );
			}

			$html['atts']['tag'] = $tag;
			if ( ! in_array( $tag, $self_closing, true ) ) {
				$end_tag = "</$tag>";
				$content = Str::before( $content, $end_tag );
				if ( rwp_has_value( $content ) ) {
					$content         = trim( $content );
					$html['content'] = $content;
				}
			}
		}
	}
	return $html;
}

/**
 * Prepares html arguments
 *
 * @param mixed $args
 * @return array
 */

function rwp_prepare_args( $args = array() ) {
	if ( is_object( $args ) ) {
		$args = rwp_object_to_array( $args );
	}
	if ( is_string( $args ) ) {
		$args = rwp_extract_html_atts( $args );
	}

	if ( is_array( $args ) && ! wp_is_numeric_array( $args ) ) {
		foreach ( $args as $key => $value ) {
			if ( ! is_int( $key ) && rwp_has_value( $value ) ) {
				switch ( $key ) {
					case 'style':
						$value = rwp_parse_styles( $value );
						break;
					case 'class':
						$value = rwp_parse_classes( $value );
						break;
					case 'content':
						if ( is_string( $value ) ) {
							$value = array(
								'content' => $value,
							);
						}
						break;
					default:
						if ( is_array( $value ) ) {
							$value = rwp_prepare_args( $value );
						}
						break;
				}
				if ( rwp_is_collection( $value ) ) {
					$value = rwp_object_to_array( $value );
				}
				$args[ $key ] = $value;
			}
		}
	}

	return $args;
}

/**
 * Merge Arguments
 *
 * @param mixed $defaults An array of HTML attributes
 * @param mixed $args     Attributes to add to the original array.
 *
 * @return array The merged array
 */
function rwp_merge_args( $defaults = array(), $args = array() ) {

	$defaults = rwp_prepare_args( $defaults );
	$args     = rwp_prepare_args( $args );
	if ( empty( $args ) ) {

		return $defaults;
	}

	if ( ! wp_is_numeric_array( $args ) && ! wp_is_numeric_array( $defaults ) ) {
		foreach ( $args as $key => $value ) {
			switch ( $key ) {
				case 'class':
					if ( rwp_array_has( $key, $defaults ) ) {
						$value = rwp_merge_classes( $defaults[ $key ], $value );
					}

					break;
				case 'style':
					if ( rwp_array_has( $key, $defaults ) ) {
						$value = array_replace_recursive( $defaults[ $key ], $value );
					}
					break;
				default:
					if ( is_array( $value ) ) {
						if ( rwp_array_has( $key, $defaults ) && is_array( $defaults[ $key ] ) ) {
							if ( rwp_array_is_multi( $defaults[ $key ] ) || rwp_array_is_multi( $value ) ) {
								$value = rwp_merge_args( $defaults[ $key ], $value );
							}
						}
					}
					break;
			}
			$defaults[ $key ] = $value;
		}
	} else {
		foreach ( $args as $key => $value ) {
			if ( is_array( $value ) ) {
				if ( rwp_array_has( $key, $defaults ) && is_array( $defaults[ $key ] ) ) {
					if ( rwp_array_is_multi( $defaults[ $key ] ) || rwp_array_is_multi( $value ) ) {
						$value = rwp_merge_args( $defaults[ $key ], $value );
					}
				}
			}
			$defaults[ $key ] = $value;
		}
		$defaults = $args;
	}

	return $defaults;
}

/**
 * Filter and output css classes for html
 *
 * @param mixed $classes
 *
 * @return string
 */

function rwp_output_classes( $classes ) {
	if ( rwp_is_collection( $classes ) ) {
		$classes = $classes->all();
	}
	if ( rwp_has_value( $classes ) && is_array( $classes ) ) {
		$classes = implode( ' ', $classes );
	} else {
		$classes = '';
	}

	return $classes;
}

/**
 * Filter and output inline styles
 *
 * @param mixed $styles
 *
 * @return string
 */

function rwp_output_styles( $styles ) {
	if ( rwp_is_collection( $styles ) ) {
		$styles = $styles->all();
	}
	if ( rwp_has_value( $styles ) && is_array( $styles ) ) {
		foreach ( $styles as $prop => $style ) {
			if ( ! preg_match( '/[\w\-]\:\s*/', $style ) ) {
				$styles[ $prop ] = "$prop: $style;";
			}
		}
		$styles = implode( ' ', $styles );
	} else {
		$styles = '';
	}
	$styles = safecss_filter_attr( $styles );

	return $styles;
}

/**
 * Output Html Attributes
 *
 * Sanitizes data attributes from an array and outputs them as a string (except
 * for the tag).
 *
 * @param array $atts An array of HTML attributes
 *
 * @return string
 */

function rwp_output_html_atts( $atts = array() ) {
	$atts = rwp_prepare_args( $atts );
	if ( ! empty( $atts ) ) {

		foreach ( $atts as $attr => $value ) {
			$is_json = false;
			if ( is_string( $attr ) && 'tag' !== $attr ) {
				switch ( $attr ) {
					case 'class':
						$value = rwp_output_classes( $value );
						break;

					case 'style':
						$value = rwp_output_styles( $value );
						break;
					default:
						if ( rwp_is_collection( $value ) ) {
							$value   = $value->toJson( JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT | JSON_BIGINT_AS_STRING );
							$is_json = true;
						} elseif ( is_array( $value ) || is_object( $value ) ) {
							$value   = wp_json_encode( $value, JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT | JSON_BIGINT_AS_STRING );
							$is_json = true;
						} else {
							$value = esc_attr( $value );
						}

						break;
				}
				if ( $is_json ) {
					$value = esc_attr( $attr ) . '=\'' . $value . '\'';
				} else {
					if ( ( 'class' === $attr || 'style' === $attr ) && rwp_has_value( $value ) ) {
						$value = esc_attr( $attr ) . '="' . $value . '"';
					} else {
						$value = esc_attr( $attr ) . '="' . $value . '"';
					}
				}

				$atts[ $attr ] = $value;
			}
		}

		if ( rwp_array_has( 'tag', $atts ) ) {
			unset( $atts['tag'] );
		}
		$html = implode( ' ', $atts );

		return $html;
	} else {
		return '';
	}
}

/**
 * Output URL
 *
 * Processes urls (including emails and phone numbers) and outputs it. Adds
 * `tel:` in front of phone numbers, adds `mailto:` in front of emails and also
 * hides emails from bots using `antispambot()'
 *
 *
 * @param string $link
 *
 * @return string The processed url
 */
function rwp_output_href( $link = '' ) {

	if ( rwp_is_phone_number( $link ) ) {
		$link = rwp_add_prefix( $link, 'tel:' );

	} elseif ( is_email( $link ) ) {
		$link = antispambot( sanitize_email( $link ) );
		$link = rwp_add_prefix( $link, 'mailto:' );

	} elseif ( rwp_is_url( $link ) && ! rwp_is_outbound_link( $link ) ) {
		$link = rwp_relative_url( $link );
	}

	$link = esc_url( $link );

	return $link;
}

/**
 * Parse href
 *
 * Makes sure that if a `href` is set that other proper attributes are also set
 *
 * @param array $atts The array or attributes (passed by reference).
 *
 * @return array The modified array.
 */
function rwp_parse_href( &$atts = array() ) {

	if ( rwp_array_has( 'url', $atts ) ) {
		$link = $atts['url'];
		unset( $atts['url'] );
	} elseif ( rwp_array_has( 'href', $atts ) ) {
		$link = $atts['href'];
	} else {
		return $atts;
	}

	if ( is_array( $link ) ) {
		$atts = rwp_merge_args( $atts, $link );
	} else {
		$atts['href'] = $link;
	}

	if ( ! rwp_array_has( 'tag', $atts ) ) {
		$atts['tag'] = 'a';
	}

	if ( rwp_array_has( 'href', $atts ) ) {
		$atts['href'] = rwp_output_href( $atts['href'] );
	}

	if ( rwp_is_outbound_link( $link ) ) {
		if ( ! rwp_array_has( 'target', $atts ) ) {
			$atts['target'] = '_blank';
		}
	}

	if ( rwp_array_has( 'target', $atts ) && '_blank' === $atts['target'] ) {
		$atts['rel'] = 'noopener noreferrer';
	}

	return $atts;
}

/**
 * Extract button arguments
 *
 * @param string $button
 * @param array $args
 * @return array
 */

function rwp_input_to_button( $button = '', $args = array() ) {
	$button   = rwp_extract_html_atts( $button );
	$defaults = array(
		'atts' => array(
			'type' => 'submit',
			'tag'  => 'button',
		),
	);
	if ( $button ) {
        if ( rwp_array_has( 'content', $button ) ) {
			$button['text']['content'] = $button['content'];
			unset( $button['content'] );
		} elseif ( rwp_array_has( 'atts', $button ) ) {
			if ( rwp_array_has( 'value', $button['atts'] ) ) {
				$button['text']['content'] = $button['atts']['value'];
				unset( $button['atts']['value'] );
			}
		}

		$defaults                        = rwp_merge_args( $defaults, $button );
		$defaults['text']['atts']['tag'] = 'span';
		$defaults['atts']['tag']         = 'button';
	}

	$args = rwp_merge_args( $defaults, $args );

	return $args;
}
