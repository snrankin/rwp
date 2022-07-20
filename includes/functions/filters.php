<?php

/** ============================================================================
 * rwp-filters
 *
 * @package RIESTERWP Core\/includes/functions/rwp-filters.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

/**
 * Hooks a single callback to multiple tags
 *
 * @param array    $tags            An array of filter tags to add the function to
 * @param callable $function        The callback to be run when the filter is applied.
 * @param int      $priority        Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action. Default 10.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 *
 * @return void
 */
function rwp_add_filters( $tags, $function, $priority = 10, $accepted_args = 1 ) {
	foreach ( (array) $tags as $tag ) {
		add_filter( $tag, $function, $priority, $accepted_args );
	}
}

/**
 * Applies multiple filter to the same set of arguments
 *
 * @param array $tags            An array of filter tags to add the function to
 * @param mixed $accepted_args
 * @return void
 */
function rwp_apply_filters( $tags, ...$accepted_args ) {
	foreach ( (array) $tags as $tag ) {
		apply_filters( $tag, ...$accepted_args );
	}
}

/**
 * Remove certain classes from plugin initialization process
 */

add_filter('rwp_classes_to_execute', function ( $classes ) {

	$classes_to_filter = preg_grep( '/Walkers\\\\|Elementor\\\\Widgets\\\\|Yoast\\\\Generators\\\\|QM\\\\(Collectors|Output)\\\\|SVG\\\\|Taxonomies\\\\Types\\\\|PostTypes\\\\Types\\\\|CustomBulkAction/i', $classes );

	if ( ! empty( $classes_to_filter ) ) {
		foreach ( array_keys( $classes_to_filter ) as $index ) {
			unset( $classes[ $index ] );
		}
	}

	return $classes;
});

/**
 * Add `rand` as an option for orderby param in REST API.
 * Hook to `rest_{$this->post_type}_collection_params` filter.
 *
 * @param array $query_params Accepted parameters.
 * @return array
 */
add_filter('rest_post_collection_params', function ( $query_params ) {
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
add_action('init', function () {
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

/**
 * Removes empty attributes (unless they're boolean attributes or data attributes)
 *
 * @link https://meiert.com/en/blog/boolean-attributes-of-html/
 *
 * @param array $args
 *
 * @return array
 */
function rwp_empty_html_attributes_filter( $args = array(), $remove_empty = true ) {

	if ( $remove_empty ) {

		foreach ( $args as $key => $value ) {
			if ( ! rwp_attr_can_be_empty( $key ) && blank( $value ) ) {
				unset( $args[ $key ] );
			}
		}
	}

	return $args;
}
add_filter( 'rwp_html_attributes_filter', 'rwp_empty_html_attributes_filter' );
