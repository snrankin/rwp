<?php

/** ============================================================================
 * RIESTER rest [@TODO Fill out summary for rest.php (no period for file headers)]
 *
 * [@TODO Fill out description for rest.php. (use period)]
 *
 * @link [@TODO Fill out url]
 *
 * @package WordPress
 * @subpackage RIESTER
 * @since RIESTER 0.1.0
 * ========================================================================== */

use RWP\Vendor\Illuminate\Support\Collection;



/**
 * Get WordPress Rest Data
 *
 * @param array|string $args
 * @param string $endpoint
 * @param bool|int $single
 *
 * @return bool|mixed \WP_REST_Response data or false
 */

function rwp_get_rest_data($args = [], $endpoint = 'posts', $single = false, $data = true) {

	$request = '';
	if (is_array($args)) {
		$path = "wp/v2/$endpoint";
		if ($single) {
			$path .= "/$single";
		}
		$url = rest_url($path);
		$url = add_query_arg($args, $url);
		$request = WP_REST_Request::from_url($url);
	} else if (rwp_is_url($args)) {
		$request = WP_REST_Request::from_url($args);
	}

	/**
	 * @var WP_REST_Response $response REST response.
	 */
	$response = rest_do_request($request);

	if (!$response->is_error()) {

		if ($data) {
			$response = $response->get_data();
		}
		return $response;
	} else {
		return $response;
	}
}

function rwp_rest_query($query = array()) {

	if (rwp_array_has('tax_query', $query)) {
		$taxonomies = $query['tax_query'];
		$tax_query = [];
		foreach ($taxonomies as $tax) {
			$terms = array();

			if (is_array($tax)) {
				$taxonomy = rwp_get_option($tax, 'taxonomy');

				$terms = rwp_get_option($tax, 'terms');
				if (is_array($terms)) {
					foreach ($terms as $term) {
						$term = get_term($term, $taxonomy);
						if (!is_wp_error($term)) {
							if (rwp_array_has($term->taxonomy, $tax_query)) {
								$tax_query[$term->taxonomy][] = $term->term_id;
							} else {
								$tax_query[$term->taxonomy] = [
									$term->term_id
								];
							}
						}
					}
				} else {
					$term = get_term($terms, $taxonomy);
					if (!is_wp_error($term)) {
						if (rwp_array_has($term->taxonomy, $tax_query)) {
							$tax_query[$term->taxonomy][] = $term->term_id;
						} else {
							$tax_query[$term->taxonomy] = [
								$term->term_id
							];
						}
					}
				}
			}
		}
		if (!empty($tax_query)) {
			foreach ($tax_query as $tax => $terms) {
				$query[$tax] = implode(',', $terms);
			}
		}
		unset($query['tax_query']);
	}


	if (rwp_array_has('posts_per_page', $query)) {
		if ('-1' != $query['posts_per_page']) {
			$query['per_page'] = intval($query['posts_per_page']);
		} else {
			$query['per_page'] = 99;
		}

		unset($query['posts_per_page']);
	}

	if (rwp_array_has('post_parent__in', $query)) {
		$query['parent'] = reset($query['post_parent__in']);
		unset($query['post_parent__in']);
	}

	$available_orderby = array(
		'author',
		'date',
		'id',
		'include',
		'modified',
		'parent',
		'relevance',
		'slug',
		'include_slugs',
		'title',
		'menu_order' // added via custom filter
	);


	if (rwp_array_has('orderby', $query)) {
		$orderby = $query['orderby'];
		if (is_array($orderby)) {
			$query['order']   = reset(array_values($orderby));
			$query['orderby'] = reset(array_keys($orderby));
		}

		if (!in_array($query['orderby'], $available_orderby, true)) {
			unset($query['orderby']);
		}
	}

	if (rwp_array_has('order', $query)) {
		$query['order'] = strtolower($query['order']);
	}

	if (rwp_array_has('meta_query', $query)) {

		$meta_query = $query['meta_query'];

		unset($query['meta_query']);

		$meta_query = rwp_collection($meta_query);

		if ($meta_query->count() == 1) {

			$meta_query->transform(function ($item) {
				foreach ($item as $key => $value) {
					$item["meta_$key"] = $value;
					unset($item[$key]);
				}

				return $item;
			});
			$meta_query = $meta_query->first();
		} else {
			$meta_query = $meta_query->all();
		}

		if (wp_is_numeric_array($meta_query)) {
			foreach ($meta_query as $i => $meta_query) {

				foreach ($meta_query as $key => $value) {
					$query["filter[meta_query][$i][$key]"] = $value;
				}
			}
		} else {
			foreach ($meta_query as $key => $value) {
				$query["filter[$key]"] = $value;
			}
		}
	}

	return $query;
}

/**
 *
 * @param array $query
 * @return WP_REST_Response
 */

function rwp_get_rest_posts($query = array()) {

	$query = rwp_rest_query($query);

	if (empty($query)) {
		return false;
	}
	$post_type = rwp_get_option($query, 'post_type', 'post');

	if (rwp_array_has('post_type', $query)) {

		unset($query['post_type']);
	}

	global $wp_post_types;

	if (rwp_array_has($post_type, $wp_post_types)) {
		$post_type = $wp_post_types[$post_type];
		if (rwp_object_has('rest_base', $post_type)) {
			if (false !== $post_type->rest_base) {
				$post_type = $post_type->rest_base;
			} elseif (rwp_object_has('rewrite', $post_type)) {
				$rewrite = $post_type->rewrite;
				if (rwp_array_has('slug', $rewrite)) {
					$post_type = $rewrite['slug'];
				}
			}
		} elseif (rwp_object_has('rewrite', $post_type)) {
			$rewrite = $post_type->rewrite;
			if (rwp_array_has('slug', $rewrite)) {
				$post_type = $rewrite['slug'];
			}
		}
	} else {
		$post_type = rwp_pluralizer($post_type);
	}

	return  rwp_get_rest_data($query, $post_type, false, false);
}


/**
 *
 * @param array $query
 * @return false|Collection
 */

function rwp_rest_posts($query = array()) {

	$orderby = rwp_get_option($query, 'orderby', 'date');
	$order   = rwp_get_option($query, 'order', 'desc');

	if (rwp_array_has('orderby', $query)) {
		unset($query['orderby']);
	}

	if (rwp_array_has('order', $query)) {
		unset($query['order']);
	}


	$posts = rwp_get_rest_posts($query);

	$posts = $posts->get_data();

	if (!empty($posts)) {

		$posts = rwp_collection($posts);

		switch ($orderby) {
			case 'name':
			case 'title':
				$posts = $posts->keyBy(function ($item) {
					$title = rwp_change_case($item['title'], 'title');
					return $title;
				});

				$posts = $posts->unique();


				break;
			case 'menu_order':
				$posts = $posts->keyBy(function ($item) {

					return $item['menu_order'];
				});
				break;
			case 'date':
				$posts = $posts->keyBy(function ($item) {

					return $item['date'];
				});
				break;
			case 'id':
				$posts = $posts->keyBy(function ($item) {

					return $item['id'];
				});
				break;
		}
		if ($order === 'asc') {
			$posts = $posts->sortKeys();
		} else if ($order === 'desc') {
			$posts = $posts->sortKeysDesc();
		}


		return $posts;
	} else {
		return false;
	}
}

function rwp_sort_rest_posts($posts, $orderby = 'date', $order = 'desc', $callback = '') {

	if ($posts instanceof WP_REST_Response) {
		$posts = $posts->get_data();
	}

	if (is_array($posts)) {
		$posts = rwp_collection($posts);
	}

	if ($posts->isNotEmpty()) {

		switch ($orderby) {
			case 'name':
			case 'title':
				$posts = $posts->keyBy(function ($item) {
					$title = rwp_change_case($item['title'], 'title');
					return $title;
				});

				$posts = $posts->unique();


				break;
			case 'menu_order':
				$posts = $posts->keyBy(function ($item) {

					return $item['menu_order'];
				});
				break;
			case 'date':
				$posts = $posts->keyBy(function ($item) {

					return $item['date'];
				});
				break;
			case 'id':
				$posts = $posts->keyBy(function ($item) {

					return $item['id'];
				});
				break;
			case 'custom':
				$posts = $posts->keyBy($callback);
				break;
		}
		if ($order === 'asc') {
			$posts = $posts->sortKeys();
		} else if ($order === 'desc') {
			$posts = $posts->sortKeysDesc();
		}
	}

	return $posts;
}
