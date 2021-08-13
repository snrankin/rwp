<?php

/** ============================================================================
 * rwp-filters
 *
 * @package RIESTERWP Core\/includes/functions/rwp-filters.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

/**
 * Remove certain classes from plugin initialization process
 */

add_filter('rwp_classes_to_execute', function( $classes ) {

	$classes_to_filter = preg_grep( '/Walkers/mi', $classes );

	if ( ! empty( $classes_to_filter ) ) {
		foreach ( array_keys( $classes_to_filter ) as $index ) {
			unset( $classes[ $index ] );
		}
	}

	return $classes;
});

/**
 * Add existing sidebars to any ACF field named sidebar_id
 */

add_filter('acf/load_field/name=sidebar_id', function ( $field ) {
	global $wp_registered_sidebars;

	// reset choices
	$field['choices'] = [];

	foreach ( $wp_registered_sidebars as $name => $args ) {
		$field['choices'][ $name ] = $args['name'];
	}

	// return the field
	return $field;
});

/**
 * Add `rand` as an option for orderby param in REST API.
 * Hook to `rest_{$this->post_type}_collection_params` filter.
 *
 * @param array $query_params Accepted parameters.
 * @return array
 */
add_filter('rest_post_collection_params', function( $query_params ) {
	$query_params['orderby']['enum'][] = 'rand';
	return $query_params;
});

/**
 * Update post per page limit for rest queries
 *
 * Default to all posts being returned rather than the default 10 posts per
 * page. Also, do not get in the way of the native $_GET['per_page'] setting.
 *
 * @link https://stackoverflow.com/a/50226393
 *
 * @return void
 */
add_action('init', function() {
	$post_types = get_post_types(
		array(
			'show_in_rest' => true,
		),
		'names'
	);
	if ( ! empty( $post_types ) ) {
		foreach ( $post_types as $post_type ) {
			if ( $post_type instanceof WP_Post_Type ) {
				$post_type = $post_type->name;
			}
			add_filter("rest_{$post_type}_query", function ( $args, $request ) {
				$limit = intval( $request->get_param( 'per_page' ) );
				if ( 99 === $limit ) {
					$limit = 999;
				}
				$args['posts_per_page'] = $limit;

				return $args;
			}, 15, 2);
			/**
			 * @link https://www.timrosswebdevelopment.com/wordpress-rest-api-post-order/
			 */
			add_filter("rest_{$post_type}_collection_params", function ( $params ) {
				$params['orderby']['enum'][] = 'menu_order';
				$query_params['orderby']['enum'][] = 'rand';
				return $params;
			}, 10, 1);
		}
	}
});
