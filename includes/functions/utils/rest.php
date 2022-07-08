<?php
/**
 * ============================================================================
 * RIESTERRX rest
 *
 * @package    WordPress
 * @subpackage RIESTERRX
 * @since      RIESTERRX 0.9.0
 * ==========================================================================
 */



/**
 * Get WordPress Rest Data
 *
 * @param array|string $args
 * @param string       $post_type
 * @param bool|int     $single
 *
 * @return bool|mixed \WP_REST_Response data or false
 */

function rwp_get_rest_data( $args = array(), $post_type = 'post', $single = false, $data = true ) {
    $request = '';
    $endpoint = rwp_get_rest_endpoint( $post_type );
    if ( is_array( $args ) ) {

        $path = "wp/v2/$endpoint";
        if ( $single ) {
            $path .= "/$single";
        }
        $url = rest_url( $path );
        $url = add_query_arg( $args, $url );
        $request = WP_REST_Request::from_url( $url );
    } else if ( rwp_is_url( $args ) ) {
        $request = WP_REST_Request::from_url( $args );
    }

    /**
     * @var WP_REST_Response $response REST response.
     */
    $response = rest_do_request( $request );

    if ( ! $response->is_error() ) {
        if ( $data ) {
            $response = $response->get_data();
        }
        return $response;
    } else {
        return $response;
    }
}


/**
 * Get rest endpoint for post type
 *
 * @param  string $post_type
 * @return mixed
 */

function rwp_get_rest_endpoint( $post_type = 'post' ) {
    $endpoint = false;

    global $wp_post_types;

    $post_type = data_get( $wp_post_types, $post_type, false );

    if ( $post_type instanceof \WP_Post_Type ) {
        if ( $post_type->show_in_rest ) {

            $rest_base = data_get( $post_type, 'rest_base', false );
            $rewrite   = data_get( $post_type, 'rewrite', array() );
            $slug      = data_get( $rewrite, 'slug', false );

            if ( $rest_base ) {
                $endpoint = $rest_base;
            } elseif ( $slug ) {
                $endpoint = $slug;
            }
        }
    }

    return $endpoint;
}
