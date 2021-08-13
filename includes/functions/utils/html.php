<?php

/** ============================================================================
 * RWP html
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ========================================================================== */

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\Html;

/**
 * Check if a string is an html string
 * @param mixed $string
 * @return bool
 */
function rwp_string_is_html( $string ) {
	return strip_tags( $string ) !== $string ? true : false;
}

/**
 * Check if a string is an html tag and if that tag is a specific html tag
 *
 * @param mixed $string
 * @param mixed $tag
 * @return bool
 */
function rwp_is_element( $string, $tag ) {
	if ( rwp_string_is_html( $string ) ) {
		return preg_match( '/\s*\<' . $tag . '/m', $string ) ? true : false;
	} else {
		return false;
	}
}

/**
 * Returns a sanitized and unique array of css classes
 *
 * @param mixed $classes The array|string|object of classes to parse
 * @param mixed $additional_classes The second set of classes
 * @param bool  $filter  Whether to run the classes through the
 *                       `sanitize_html_class()` function
 *
 * @return string[]
 */
function rwp_parse_classes( $classes, $additional_classes = '', $filter = false ) {
	if ( empty( $classes ) ) {
		return array();
	}

	if ( is_string( $classes ) ) {
		$classes = explode( ' ', $classes );
	}

	if ( ! ( $classes instanceof Collection ) ) {
		$classes = new Collection( $classes );
	}

	if ( ! empty( $additional_classes ) ) {
		if ( is_string( $additional_classes ) ) {
			$additional_classes = explode( ' ', $additional_classes );
		}
		$classes = $classes->merge( $additional_classes );
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
function rwp_parse_href( $atts = array() ) {

	if ( rwp_array_has( 'href', $atts ) ) {
		$atts['href'] = rwp_output_href( $atts['href'] );
		if ( rwp_is_outbound_link( $atts['href'] ) ) {
			if ( ! rwp_array_has( 'target', $atts ) ) {
				$atts['target'] = '_blank';
			}
		}

		if ( rwp_array_has( 'target', $atts ) && '_blank' === $atts['target'] ) {
			$atts['rel'] = 'noopener noreferrer';
		}
	}

	return $atts;
}

/**
 * Filter and output css classes for html
 *
 * @param mixed $classes
 * @param bool $filter
 *
 * @return string
 */

function rwp_output_classes( $classes, $filter = false ) {

	if ( rwp_is_collection( $classes ) ) {
		$classes = $classes->all();
	}

	$classes = rwp_parse_classes( $classes, '', $filter );
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

	return $styles;
}

/**
 * Prepares html arguments
 *
 * @param mixed $args
 * @return array
 */

function rwp_prepare_args( $args = array() ) {
	if ( rwp_is_collection( $args ) ) {
		$args = $args->all();
	}

	if ( is_array( $args ) && ! wp_is_numeric_array( $args ) ) {
		$args = rwp_parse_href( $args );

		foreach ( $args as $key => $value ) {
			if ( ! is_int( $key ) ) {
				switch ( $key ) {
					case 'style':
						$value = rwp_parse_styles( $value );
						break;
					case 'class':
						$value = rwp_parse_classes( $value );
						break;

					default:
						if ( rwp_is_collection( $value ) ) {
							$value = $value->all();
						}
						if ( is_array( $value ) ) {
							$value = rwp_prepare_args( $value );
						}
						break;
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
						$value = rwp_parse_classes( $defaults[ $key ], $value );
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
							} else {
								$value = array_replace_recursive( $defaults[ $key ], $value );
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
 * Output Html Attributes
 *
 * Sanitizes data attributes from an array and outputs them as a string (except
 * for the tag).
 *
 * @param array $atts An array of HTML attributes
 * @param string $output How to output the result
 *
 * @return string|array
 */

function rwp_format_html_atts( $atts = array(), $output = 'string' ) {
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
						} elseif ( rwp_str_starts_with( $attr, 'on' ) ) {
							$value = str_replace( '"', "'", $value );
							$value = esc_js( $value );
						} else {
							$value = esc_attr( $value );
						}

						break;
				}
				if ( 'string' === $output ) {
					if ( $is_json ) {
						$value = esc_attr( $attr ) . '=\'' . $value . '\'';
					} else {
						if ( ( 'class' === $attr || 'style' === $attr ) && rwp_has_value( $value ) ) {
							$value = esc_attr( $attr ) . '="' . $value . '"';
						} else {
							$value = esc_attr( $attr ) . '="' . $value . '"';
						}
					}
				}

				$atts[ $attr ] = $value;
			}
		}

		if ( rwp_array_has( 'tag', $atts ) ) {
			unset( $atts['tag'] );
		}
		if ( 'string' === $output ) {
			$html = implode( ' ', $atts );
		} else {
			$html = $atts;
		}

		return $html;
	} else {
		if ( 'string' === $output ) {
			return '';
		} else {
			return array();
		}
	}
}

/**
 * Extract button arguments
 *
 * @param string $input
 * @param array $args
 * @return RWP\Components\Button|string
 */

function rwp_input_to_button( $input = '', $args = array() ) {
	if ( ! rwp_is_element( $input, 'input' ) ) {
		return $input;
	}

	$args['html'] = $input;

	$button = rwp_button( $args );

	if ( $button->has_attr( 'value' ) ) {
		$btn_text = $button->get_attr( 'value' );

		$button->text->set_content( $btn_text );
		$button->remove_attr( 'value' );
	}

	return $button;
}
