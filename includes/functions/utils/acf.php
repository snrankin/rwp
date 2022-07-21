<?php

/** ============================================================================
 * RWP acf
 *
 * @package RWP\/includes/functions/utils/acf.php
 * @since   0.1.0
 * ========================================================================== */

use RWP\Html\{Element, Html, Icon};
use RWP\Helpers\Collection;

/**
 *
 * @param  mixed|null $post
 * @return false|array
 */
function rwp_get_acf_fields( $post = null ) {
	$post = rwp_post_id( $post, 'acf' );
	if ( function_exists( 'acfe_get_fields' ) ) {
		return acfe_get_fields( $post );
	} elseif ( function_exists( 'get_fields' ) ) {
		return get_fields( rwp_post_id( $post, 'acf' ) );
	}

	return array();
}

/**
 * Get all fields from a post
 *
 * @param  mixed|null $post
 * @return mixed
 */

function rwp_get_fields( $post = null ) {
	$post_type = rwp_post( $post );
	$post_id = rwp_post_id( $post );

	$fields = array();

	if ( 0 !== $post_id ) {
		if ( 'post' === $post_type['type'] ) {
			$fields = get_post_meta( $post_id, '_rwp_acf', true );
			if ( empty( $fields ) ) {
				$fields = get_post_meta( $post_id, 'acf', true );
			}
		} elseif ( 'term' === $post_type['type'] ) {
			$fields = get_term_meta( $post_id, '_rwp_acf', true );
			if ( empty( $fields ) ) {
				$fields = get_term_meta( $post_id, 'acf', true );
			}
		}
		if ( empty( $fields ) && function_exists( 'get_fields' ) ) {
			$fields = get_fields( rwp_post_id( $post, 'acf' ) );
		}
	}

	if ( is_array( $fields ) ) {
		$fields = rwp_collection( $fields );
	}

	return $fields;
}

/**
 * Wrapper for ACF get field
 *
 * @param mixed|null $post
 *
 * @return mixed
 */
function rwp_get_field( $field, $post = null, $default = null ) {
	$fields = rwp_get_fields( $post );

	return data_get( $fields, $field, $default );
}

/**
 * Get star rating html
 *
 * @return string
 */
function rwp_get_star_rating( $post = null ) {
	$post_id = rwp_post_id( $post, 'acf' );
	$field = get_field_object( 'rating', $post_id );
	return \StarRatingField::output_stars( $field );
}

/**
 * Extract color from acf fields and adjust the attributes
 *
 * @param array|Collection|Element|Html  $args
 * @param string                         $type    One of `(background|text|border)`
 * @param array|Collection               $fields
 * @param mixed                          $post
 *
 * @return mixed|void
 */

function rwp_add_acf_color( $args, $type = 'background', $fields = array(), $post = null ) {

	if ( empty( $fields ) ) {
		$fields = rwp_get_fields( $post );
	}

	if ( empty( $fields ) ) {
		if ( is_array( $args ) || rwp_is_collection( $args ) ) {
			return $args;
		} else {
			return;
		}
	}

	$css_style = 'color';

	if ( 'text' !== $type ) {
		$css_style = $type . '-color';
	}

	$color_class  = data_get( $fields, $type . '_color.bs_class', '' );
	$custom_color = data_get( $fields, $type . '_color.custom', '' );

	if ( is_array( $args ) || rwp_is_collection( $args ) ) {
		$atts = array();

		if ( ! empty( $color_class ) ) {
			if ( 'custom' === $color_class && ! empty( $custom_color ) ) {
				$atts['atts']['style'][ $css_style ] = $custom_color;
			} else {
				$atts['atts']['class'][] = rwp_add_prefix( $color_class, $type . '-' );
			}
		}

		$args = rwp_merge_args( $args, $atts );

		return $args;
	} elseif ( rwp_is_element( $args ) ) {
		if ( ! empty( $color_class ) ) {
			if ( 'custom' === $color_class && ! empty( $custom_color ) ) {
				$args->set_style( $css_style, $custom_color );
			} else {
				$args->add_class( rwp_add_prefix( $color_class, $type . '-' ) );
			}
		}
	} elseif ( $args instanceof Html ) {
		if ( ! empty( $color_class ) ) {
			if ( 'custom' === $color_class && ! empty( $custom_color ) ) {
				$args->setStyle( $css_style, $custom_color );
			} else {
				$args->addClass( rwp_add_prefix( $color_class, $type . '-' ) );
			}
		}
	}
}

/**
 * Extract color from acf fields and adjust the attributes
 *
 * @param array|Collection $args
 * @param string           $type    One of `(background|text|border)`
 * @param array|Collection $fields
 * @param mixed            $post
 *
 * @return mixed|void
 */

function rwp_get_acf_color_style( &$styles, $type = 'background', $fields = array(), $post = null ) {

	if ( empty( $fields ) ) {
		$fields = rwp_get_fields( $post );
	}

	if ( empty( $fields ) ) {
		if ( is_array( $styles ) || rwp_is_collection( $styles ) ) {
			return $styles;
		} else {
			return;
		}
	}

	$css_style = 'color';

	if ( 'text' !== $type ) {
		$css_style = $type . '-color';
	}

	$prefix = $type . '-';

	if ( 'background' === $type ) {
		$prefix = 'bg-';
	}

	$color_class  = data_get( $fields, $type . '_color.bs_class', '' );
	$color_class = rwp_remove_prefix( $color_class, $prefix );
	$custom_color = data_get( $fields, $type . '_color.custom', '' );

	$atts = array();

	if ( ! empty( $color_class ) ) {
		if ( 'custom' === $color_class && ! empty( $custom_color ) ) {
			$atts[ $css_style ] = $custom_color;
		} else {
			$atts[ $css_style ] = "var(--bs-$color_class)";
		}
	}

	$styles = rwp_merge_args( $styles, $atts );
}


/**
 * Extract/generate an icon from ACF Fields
 *
 * @param Collection|array $fields
 * @param mixed|null $post
 * @return false|Icon
 */
function rwp_get_icon_from_acf( $fields, $post = null ) {
	if ( empty( $fields ) ) {
		$fields = rwp_get_fields( $post );
	}

	if ( ! empty( $fields ) ) {
		$fields = rwp_collection( $fields );
	} else {
		return false;
	}

	// if ( $fields->has( 'icon' ) ) {
	// 	$fields = data_get( $fields, 'icon', rwp_collection() );
	// }

	$type = data_get( $fields, 'type', 'none' );

	if ( 'none' === $type ) {
		return false;
	}

	$icon = '';

	switch ( $type ) {
		case 'class':
			$icon = rwp_output_classes( data_get( $fields, 'class', '' ) );
			break;
		case 'svg':
		case 'image':
			$icon = data_get( $fields, 'src', '' );
			break;
		case 'html':
			$icon = array(
				'tag'     => 'span',
				'content' => data_get( $fields, 'content', '' ),
				'atts'    => array(
					'class' => 'custom-html',
				),
			);
			break;
	}

	if ( empty( $icon ) ) {
		return false;
	}

	return rwp_icon( $icon );
}
