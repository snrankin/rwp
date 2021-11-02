<?php

/** ============================================================================
 * RWP acf
 *
 * @package RWP\/includes/functions/utils/acf.php
 * @since   0.1.0
 * ========================================================================== */

use RWP\Components\{Element, Html};
use RWP\Vendor\Illuminate\Support\Collection;

/**
 *
 * @param  mixed|null $post
 * @return false|array
 */
function rwp_get_acf_fields( $post = null ) {
     $post = rwp_post_id( $post, 'acf' );
    if ( function_exists( 'acfe_get_fields' ) ) {
        return acfe_get_fields( $post );

    } else if ( function_exists( 'get_fields' ) ) {
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
 * Extract background color from acf fields and adjust the attributes
 *
 * @param array|Collection|Element|Html $args
 * @param array|Collection $fields
 * @param mixed $post
 *
 * @return mixed|void
 */

function rwp_add_acf_bg_color( $args, $fields = array(), $post = null ) {

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

	$bg_color = data_get( $fields, 'bg_color.bs_bg_color', '' );
	$custom_bg_color = data_get( $fields, 'bg_color.custom_bg_color', '' );

	if ( is_array( $args ) || rwp_is_collection( $args ) ) {
		$atts = array();

		if ( ! empty( $bg_color ) ) {
			if ( 'custom' === $bg_color && ! empty( $custom_bg_color ) ) {
				$atts['atts']['style']['background-color'] = $custom_bg_color;
			} else {
				$atts['atts']['class'][] = rwp_add_prefix( $bg_color, 'bg-' );
			}
		}

		$args = rwp_merge_args( $args, $atts );

		return $args;
	} else if ( rwp_is_element( $args ) ) {
		if ( ! empty( $bg_color ) ) {
			if ( 'custom' === $bg_color && ! empty( $custom_bg_color ) ) {
				$args->set_style( 'background-color', $custom_bg_color );
			} else {
				$args->add_class( rwp_add_prefix( $bg_color, 'bg-' ) );
			}
		}
	} else if ( $args instanceof Html ) {
		if ( ! empty( $bg_color ) ) {
			if ( 'custom' === $bg_color && ! empty( $custom_bg_color ) ) {
				$args->setStyle( 'background-color', $custom_bg_color );
			} else {
				$args->addClass( rwp_add_prefix( $bg_color, 'bg-' ) );
			}
		}
	}
}
