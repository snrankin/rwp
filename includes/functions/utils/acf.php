<?php

/** ============================================================================
 * RWP acf
 *
 * @package RWP\/includes/functions/utils/acf.php
 * @since   0.1.0
 * ========================================================================== */


/**
 *
 * @param  mixed|null $post
 * @return false|array
 */
function rwp_get_acf_fields( $post = null ) {
     $post = rwp_id( $post, 'acf' );
    if ( function_exists( 'acfe_get_fields' ) ) {
        return acfe_get_fields( $post );

    } else if ( function_exists( 'get_fields' ) ) {
        return get_fields( rwp_id( $post, 'acf' ) );
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
    $post_type = rwp_object_type( $post );
    $post_id = rwp_id( $post );

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
            $fields = get_fields( rwp_id( $post, 'acf' ) );

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
	$post_id = rwp_id( $post, 'acf' );
	$field = get_field_object( 'rating', $post_id );
	return \StarRatingField::output_stars( $field );
}
