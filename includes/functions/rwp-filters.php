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
 */
function rwp_add_filters($tags, $function, $priority = 10, $accepted_args = 1) {
	foreach ((array) $tags as $tag) {
		add_filter($tag, $function, $priority, $accepted_args);
	}
}

add_filter('acf/load_field/name=location', function ($field) {
	$company_info = rwp_get_field('company_info');

	// reset choices
	$field['choices'] = [];

	if (rwp_is_collection($company_info)) {
		$locations = $company_info->get('locations');

		foreach ($locations->keys() as $location) {
			$field['choices'][$location] = rwp_change_case($location, 'title');
		}
	}

	// return the field
	return $field;
});

add_filter('acf/load_field/name=sidebar_id', function ($field) {
	global $wp_registered_sidebars;


	// reset choices
	$field['choices'] = [];

	foreach ($wp_registered_sidebars as $name => $args) {
		$field['choices'][$name] = $args['name'];
	}

	// return the field
	return $field;
});

function rwp_filter_location_info($field) {

	$fields = $field['sub_fields'];
	$location = $fields[1]['value'];

	$info = rwp_company_info(['location' => $location]);

	foreach ($field['sub_fields'] as $i => $sub_field) {

		$type = $sub_field['name'];
		switch ($type) {
			case 'phone':
			case 'email':
				$info_items = $info->$type->values;
				$choices = $sub_field['sub_fields'][0]['choices'];
				if (rwp_is_collection($info_items)) {
					foreach ($info_items->all() as $key => $value) {
						$choices[$key] = $value;
					}
				}
				$sub_field['sub_fields'][0]['choices'] = $choices;
				$field['sub_fields'][$i] = $sub_field;
				break;

			default:

				break;
		}
	}

	return $field;
}
add_filter('acf/load_field/name=company_info_block', 'filter_location_info', 10, 1);

/**
 * Add `rand` as an option for orderby param in REST API.
 * Hook to `rest_{$this->post_type}_collection_params` filter.
 *
 * @param array $query_params Accepted parameters.
 * @return array
 */
function add_rand_orderby_rest_post_collection_params($query_params) {
	$query_params['orderby']['enum'][] = 'rand';
	return $query_params;
}
add_filter('rest_post_collection_params', 'add_rand_orderby_rest_post_collection_params');

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
function rwp_increase_rest_limit() {
	$post_types = get_post_types(
		array(
			'show_in_rest' => true,
		),
		'names'
	);
	if (!empty($post_types)) {
		foreach ($post_types as $post_type) {
			if ($post_type instanceof WP_Post_Type) {
				$post_type = $post_type->name;
			}
			add_filter("rest_{$post_type}_query", function ($args, $request) {
				$limit = intval($request->get_param('per_page'));
				if (99 === $limit) {
					$limit = 999;
				}
				$args['posts_per_page'] = $limit;


				return $args;
			}, 15, 2);
			/**
			 * @link https://www.timrosswebdevelopment.com/wordpress-rest-api-post-order/
			 */
			add_filter("rest_{$post_type}_collection_params", function ($params) {
				$params['orderby']['enum'][] = 'menu_order';
				$query_params['orderby']['enum'][] = 'rand';
				return $params;
			}, 10, 1);
		}
	}
}

add_action('init', 'rwp_increase_rest_limit');
