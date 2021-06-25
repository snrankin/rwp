<?php

/** ============================================================================
 * RIESTER post [@TODO Fill out summary for post.php (no period for file headers)]
 *
 * [@TODO Fill out description for post.php. (use period)]
 *
 * @link [@TODO Fill out url]
 *
 * @package WordPress
 * @subpackage RIESTER
 * @since RIESTER 0.1.0
 * ========================================================================== */

use \RWP\Vendor\Illuminate\Support\Collection;
/**
 * Is item a blog post
 *
 * Checks different conditionals to see if the current item is a blog post
 *
 * @return bool
 */
function rwp_is_blog($post = null) {
	if (!($post instanceof \WP_Post)) {
		$post = get_post($post);
	}
	$posttype = get_post_type($post);
	return (((is_archive()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ('post' === $posttype)) ? true : false;
}

/**
 * Function to get the ID home page
 *
 * @return int|false
 */

function rwp_home_page(){
	$home = get_option('page_on_front');
	if($home){
		$home = intval($home);
	}
	return $home;
}

/**
 * Generate array of post type labels
 *
 * Used for generated custom post types
 *
 * @param string  $singular Required. The singular version of the post type
 * @param string  $plural   Optional. The plural version of the post type
 * @param string  $menu     Optional. The label to use in the admin menu
 * @param string  $slug     Optional. The post type slug
 *
 * @return string[]
 */
function rwp_cpt_labels($singular, $plural = '', $menu = '', $slug = '') {

	$singular = rwp_singulizer($singular);

	if (empty($plural)) {
		$plural = rwp_pluralizer($singular);
	}

	$lower_singular = rwp_change_case($singular, 'lower');
	$lower_plural   = rwp_change_case($plural, 'lower');

	$title_singular = rwp_change_case($singular, 'title');
	$title_plural   = rwp_change_case($plural, 'title');

	$menu = !empty($menu) ? $menu : $title_plural;
	$slug = !empty($slug) ? $slug : rwp_change_case($lower_plural, 'slug');

	return array(
		'names'     => array(
			'singular' => $title_singular,
			'plural'   => $title_plural,
			'slug'     => $slug,
		),
		'labels' => array(
			'name'                  => $title_plural,
			'singular_name'         => $title_singular,
			'menu_name'             => $menu,
			'name_admin_bar'        => $title_singular,
			'archives'              => "$title_singular Archives",
			'attributes'            => "$title_singular  Attributes",
			'parent_item_colon'     => "Parent $title_singular:",
			'all_items'             => "All $title_plural",
			'add_new_item'          => "Add New $title_singular",
			'new_item'              => "New $title_singular",
			'edit_item'             => "Edit $title_singular",
			'update_item'           => "Update $title_singular",
			'view_item'             => "View $title_singular",
			'view_items'            => "View $title_plural",
			'search_items'          => "Search $title_plural",
			'insert_into_item'      => "Insert into $lower_singular",
			'uploaded_to_this_item' => "Uploaded to this $lower_singular",
			'items_list'            => "$title_plural list",
			'items_list_navigation' => "$title_plural list navigation",
			'filter_items_list'     => "Filter $lower_singular list",
		),
	);
}

/**
 * Generate array of taxonomy labels
 *
 * Used for generating custom taxonomy types
 *
 * @param string  $singular Required. The singular version of the taxonomy
 * @param string  $plural   Optional. The plural version of the taxonomy
 * @param string  $menu     Optional. The label to use in the admin menu
 * @param string  $slug     Optional. The taxonomy slug
 *
 * @return string[]
 */
function rwp_tax_labels($singular, $plural = '', $menu = '', $slug = '') {

	$singular = rwp_singulizer($singular);

	if (empty($plural)) {
		$plural = rwp_pluralizer($singular);
	}

	$lower_singular = rwp_change_case($singular, 'lower');
	$lower_plural   = rwp_change_case($plural, 'lower');

	$title_singular = rwp_change_case($singular, 'title');
	$title_plural   = rwp_change_case($plural, 'title');

	$menu = !empty($menu) ? $menu : $title_plural;
	$slug = !empty($slug) ? $slug : rwp_change_case($lower_plural, 'slug');

	return array(
		'singular' => $title_singular,
		'plural'   => $title_plural,
		'slug'     => $slug,
		'labels' => array(
			'name'                       => _x($title_plural, 'Taxonomy General Name', 'rwp'),
			'singular_name'              => _x($title_singular, 'Taxonomy Singular Name', 'rwp'),
			'menu_name'                  => __($menu, 'rwp'),
			'all_items'                  => __('All ' . $title_plural, 'rwp'),
			'parent_item'                => __('Parent ' . $title_plural, 'rwp'),
			'parent_item_colon'          => __('Parent ' . $title_singular . ':', 'rwp'),
			'new_item_name'              => __('New ' . $title_singular . ' Name', 'rwp'),
			'add_new_item'               => __('Add New ' . $title_plural, 'rwp'),
			'edit_item'                  => __('Edit ' . $title_plural, 'rwp'),
			'update_item'                => __('Update ' . $title_plural, 'rwp'),
			'view_item'                  => __('View ' . $title_plural, 'rwp'),
			'separate_items_with_commas' => __('Separate ' . $lower_plural . ' with commas', 'rwp'),
			'add_or_remove_items'        => __('Add or remove ' . $lower_plural, 'rwp'),
			'popular_items'              => __('Popular ' . $title_plural, 'rwp'),
			'search_items'               => __('Search ' . $title_plural, 'rwp'),
			'no_terms'                   => __('No ' . $title_plural, 'rwp'),
			'items_list'                 => __($title_plural . ' list', 'rwp'),
			'items_list_navigation'      => __($title_plural . ' list navigation', 'rwp'),
		),
	);
}

/**
 * Helps for standardizing requests
 *
 *
 * @param mixed|null $obj
 * @param string     $type
 * @return array     $info {
 *     The object info
 *
 *     @type str      $type     The general type of object. One of post|archive
 *                              |term|user|widget|comment|taxonomy|error|search
 *     @type str      $subtype  The sub-type. So if it is a post, it is the
 *                              post type, or if its a term, it's the taxonomy
 *     @type int      $id       The object id or 0
 *     @type int|str  $acf_id   The formatted ACF id
 *     @type str      $title    The object title
 *     @type int      $parent   The parent id or 0
 *     @type str      $slug     The slug
 *     @type str      $url      The item url (relative to home)
 *     @type mixed    $object   The object instance.
 *
 * }
 */
function rwp_object_type($obj = null, $type = 'post') {

	if (!is_array($obj)) {

		$info = array();

		$object   = null;
		$sub_type = '';
		$id       = 0;
		$acf_id   = 'options';
		$title    = '';
		$parent   = 0;
		$slug     = '';
		$url      = '';



		$search = array(
			'type'    => 'search',
			'subtype' => $sub_type,
			'id'      => $id,
			'acf_id'  => $acf_id,
			'title'   => wp_sprintf('%s%s', __('Search Results for: ', 'rwp'), get_search_query()),
			'parent'  => $parent,
			'slug'    => 'search',
			'url'     => '/search',
			'object'  => null,
		);
		$error  = array(
			'type'    => 'error',
			'subtype' => $sub_type,
			'id'      => $id,
			'acf_id'  => $acf_id,
			'title'   => __('404: Not Found', 'rwp'),
			'parent'  => $parent,
			'slug'    => 'error-404',
			'url'     => '',
			'object'  => null,
		);

		if (is_404() && empty($obj)) {
			return $error;
		}

		if (is_search() && empty($obj)) {
			return $search;
		}

		if (is_numeric($obj)) {
			$id = intval($obj);

			if (!empty($id)) {
				switch ($type) {
					case 'comment':
						$obj = get_comment($id);
						break;
					case 'term':
						$obj = get_term($id);
						break;
					case 'user':
						$obj = get_userdata($id);
						break;
					default:
						$obj = get_post($id);
						break;
				}
			} else {
				return $error;
			}
		}

		if (empty($obj)) {
			$obj = get_queried_object();
		}

		if (is_object($obj)) {

			if ($obj instanceof \WP_Post) {
				$type     = 'post';
				$sub_type = $obj->post_type; // What type of post is it?
				$id       = $obj->ID;
				$acf_id   = $id;
				$title    = $obj->post_title;
				$parent   = $obj->post_parent;
				$slug     = $obj->post_name;
				$url      = get_permalink($id);
			} else if ($obj instanceof \WP_Post_type) {
				$type     = 'archive';
				$sub_type = $obj->name; // What type of archive is it?
				$title    = $obj->label;
				$slug     = 'archive-' . $obj->name;
				$url      = get_post_type_archive_link($sub_type);

				$custom_archive_page = rwp_get_option('custom_archive_pages', $sub_type);

				if (!empty($custom_archive_page)) {
					$obj      = get_post($custom_archive_page);
					$id       = $obj->ID;
					$acf_id   = $id;
					$title    = $obj->post_title;
					$parent   = $obj->post_parent;
					$slug     = $obj->post_name;
					$url      = get_permalink($id);
				}
			} else if ($obj instanceof \WP_Term) {
				$type     = 'term';
				$sub_type = $obj->taxonomy; // What type of term is it?
				$id       = $obj->term_id;
				$acf_id   = "{$type}_{$id}";
				$title    = $obj->name;
				$parent   = $obj->parent;
				$slug     = $obj->slug;
				$url      = get_term_link($id, $sub_type);
			} else if ($obj instanceof \WP_User) {
				$type     = 'user';
				$sub_type = $obj->cap_key; // What type of user is it?
				$id       = $obj->ID;
				$acf_id   = "{$type}_{$id}";
				$title    = $obj->display_name;
				$slug     = $title;
			} else if ($obj instanceof \WP_Widget) {
				$type     = 'widget';
				$sub_type = $obj->name; // What type of widget is it?
				$id       = $obj->id;
				$acf_id   = "{$type}_{$id}";
				$slug     = rwp_change_case($id, 'slug');
			} else if ($obj instanceof \WP_Comment) {
				$type     = 'comment';
				$sub_type = $obj->comment_type;
				$id       = $obj->comment_ID;
				$acf_id   = "{$type}_{$id}";
				$parent   = $obj->comment_parent;
				$slug     = $id;
				$url      = get_comment_link($id);
				$info['post_parent'] = $obj->comment_post_ID; // ID of the post the comment is associated with.
			} else if ($obj instanceof \WP_Taxonomy) {
				$type     = 'taxonomy';
				$sub_type = $obj->name; // What type of taxonomy is it?
				$title    = $obj->label;
				$slug     = 'taxonomy-' . $sub_type;

				$custom_archive_page = rwp_get_option('custom_archive_pages', $sub_type);

				if (!empty($custom_archive_page)) {
					$obj      = get_post($custom_archive_page);
					$id       = $obj->ID;
					$acf_id   = $id;
					$title    = $obj->post_title;
					$parent   = $obj->post_parent;
					$slug     = $obj->post_name;
					$url      = get_permalink($id);
				}
			}

			$object = $obj;
		}

		if (!empty($url)) {
			$url = rwp_relative_url($url);
		}
		if (!empty($slug)) {
			$slug = rwp_change_case($slug, 'slug');
		}

		$info['type']    = $type;
		$info['subtype'] = $sub_type;
		$info['id']      = $id;
		$info['acf_id']  = $acf_id;
		$info['title']   = $title;
		$info['parent']  = $parent;
		$info['slug']    = $slug;
		$info['url']     = $url;
		$info['object']  = $object;

		if (!empty($info)) {
			return $info;
		} else {
			return $error;
		}
	} else {
		return $obj;
	}
}

/**
 * Ensures that the post variable is a post object or empty
 *
 * @param mixed|null $post
 *
 * @return WP_Post|null
 */
function rwp_post_object($post = null) {
	$post = rwp_object_type($post);
	$post = rwp_get_option($post, 'object', null);

	global $wp_query;

	if ((is_search() && $wp_query->is_main_query()) || is_404()) {
		$post = null;
	}

	return $post;
}

/**
 * Gets the item subtype
 *
 * * post type (WP_Post)  - gets the post type (page, post, cpt).
 * * term (WP_Term)       - term taxonomy
 * * widget (WP_Widget)   - widget type
 * * user (WP_User)       - capability type
 * * comment (WP_Comment) - comment type
 *
 * @param mixed|null $post
 * @return mixed
 */

function rwp_item_type($post = null) {

	return rwp_get_option(rwp_object_type($post), 'subtype', 'post');
}


/**
 * Rolls all types of ID requests for various object types into one function
 *
 * Also formats the id for use in ACF
 *
 * @param mixed|null $obj
 * @param mixed|null $id_type
 * @return int|string
 */
function rwp_id($obj = null, $id_type = null) {
	$obj_type = rwp_object_type($obj);
	$id = rwp_get_option($obj_type, 'id', 0);
	$acf_id = rwp_get_option($obj_type, 'acf_id', 'options');

	if ($id_type === 'acf') {

		$id = $acf_id;
	}

	return $id;
}

/**
 * Filter Content
 *
 * Filters any string of content, makes sure the tags are balanced and applies
 * the filter `the_content()'
 *
 * @link https://developer.wordpress.org/reference/hooks/the_content/
 *
 * @param string $content The content to filter.
 *
 * @return mixed
 */
function rwp_filtered_content($content = '') {

	if (!is_string($content)) return $content;
	//$content = force_balance_tags($content);
	$content = apply_filters('the_content', $content);
	//$content = rwp_parse_blocks($content);
	$content = preg_replace("/\r|\n|\h{2,}|\t/", "", $content);
	$content = force_balance_tags($content);

	// $content = force_balance_tags($content);
	$content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);

	return $content;
}


/**
 * Get content base on the object type
 *
 * @param WP_Post|object|int $post           Optional. WP_Post instance or Post ID/object. Default null.
 * @param string             $more_link_text Optional. Content for when there is more text.
 * @param bool               $strip_teaser   Optional. Strip teaser content before the more text. Default false.
 *
 * @return string
 */

function rwp_get_content($post = null, $more_link_text = null, $strip_teaser = false) {

	$obj = rwp_object_type($post);

	$object_type  = rwp_get_option($obj, 'type', 'post');
	$subtype      = rwp_get_option($obj, 'subtype', 'post');

	$id = rwp_get_option($obj, 'id', 0);

	$content = '';

	if ('post' === $object_type) {
		$content = get_the_content($more_link_text, $strip_teaser, $id);
	} elseif ('term' === $object_type) {
		$content = term_description($id);
	} elseif ('archive' === $object_type) {
		$post_id = rwp_get_option('custom_archive_pages', $subtype);
		if (!empty($post_id)) {
			$content = get_the_content($more_link_text, $strip_teaser, $post_id);
		} else {
			$post_type_obj = get_post_type_object($subtype);

			// Check if a description is set.
			if (rwp_object_has('description', $post_type_obj)) {
				$content = $post_type_obj->description;
				$content = apply_filters('get_the_post_type_description', $content, $post_type_obj);
			}
		}
	}

	$content = rwp_filtered_content($content);

	return $content;
}

/**
 * Generate post excerpt
 *
 * @see rwp_trim_text()
 *
 * @param mixed|null $post
 * @param array      $args Arguments for the rwp_trim_text function
 *
 * @return string
 */
function rwp_post_excerpt($post = null, $args = []) {
	$obj = rwp_object_type($post);

	$excerpt = '';

	if (is_array($obj)) {

		$object_type  = rwp_get_option($obj, 'type', 'post');
		$subtype      = rwp_get_option($obj, 'subtype', 'post');
		$post         = rwp_get_option($obj, 'object', $post);
		$args         = apply_filters("pre_rwp_excerpt_trim", $args, $post);
		$length       = rwp_get_option($args, 'length', 15);
		$variable     = rwp_get_option($args, 'variable', true);
		$excerpt_end  = rwp_get_option($args, 'excerpt_end', '[&hellip;]');
		$allowed_tags = rwp_get_option($args, 'allowed_tags', array('em', 'i', 'b', 'strong'));
		$excerpt      = get_the_excerpt($post);
		if (empty($excerpt)) {
			$excerpt = rwp_get_content($post);
			$excerpt = rwp_trim_text($excerpt, $length, $variable, $excerpt_end, $allowed_tags);
		}
		if (!empty($length)) {
			$excerpt = rwp_trim_text($excerpt, $length, $variable, $excerpt_end, $allowed_tags);
		}
	}
	$excerpt = apply_filters("post_rwp_excerpt_trim", $excerpt, $post);
	$excerpt = wp_kses_data($excerpt);
	return $excerpt;
}

/**
 * Get the item link
 *
 * @param mixed|null $post
 * @return string
 */
function rwp_post_link($post = null) {
	$obj = rwp_object_type($post);

	$link = rwp_get_option($obj, 'url', '');

	return esc_url($link);
}

/**
 *
 * @param mixed|null $post
 * @param array $args
 * @return array
 */


function rwp_card_args($post = null, $args = []) {
	$post = rwp_object_type($post);

	$subtype            = rwp_get_option($post, 'subtype', 'post');
	$object             = rwp_get_option($post, 'object', $post);
	$post_id            = rwp_get_option($post, 'id', 0);
	$args_are_processed = rwp_get_option($args, 'processed', false);

	if (!$args_are_processed && 0 !== $post_id) {

		$image = rwp_get_featured_image($post, 'medium');

		$image = rwp_object_to_array($image);

		$defaults = array(
			'atts' => array(
				'id' => rwp_post_id($post),
				'class' => get_post_class('card', $post_id)
			),
			'media' => $image,
			'title' => array(
				'content' => rwp_title($post),
			),
			'text' => array(
				'content' => rwp_post_excerpt($post)
			),
			'buttons' => array(
				'items' => array(
					array(
						'text' => array(
							'content' => 'Read More',
						),
						'atts' => array(
							'tag' => 'a',
							'href' => rwp_post_link($post),
						),
					)
				)
			)
		);

		$defaults = rwp_merge_args($defaults, $args);

		$defaults = apply_filters("rwp_loop_card_defaults", $defaults, $post);

		$defaults = apply_filters("rwp_{$subtype}_card_defaults", $defaults, $post);

		if (is_search()) {
			$defaults = apply_filters("rwp_search_card_defaults", $defaults, $post);
		}

		$args = rwp_merge_args($defaults, $args);
		$args['processed'] = true;
	}

	return $args;
}

/**
 * Get the item title
 *
 * @param mixed|null $post
 * @param bool $use_alt
 * @return string
 */

function rwp_title($post = null, $use_alt = false) {

	$obj = rwp_object_type($post);

	$title = '';

	if (is_array($obj)) {
		$post         = rwp_get_option($obj, 'object', $post);
		$title        = rwp_get_option($obj, 'title', '');
		$alt_title    = rwp_get_field('alt_title', $post);

		if (!empty($alt_title) && $use_alt) {
			$title = $alt_title;
		}
	}

	$title = apply_filters('rwp_title', $title, $use_alt, $obj);
	return $title;
}

/**
 * Get the ancestors for an item with filters
 *
 * @param mixed|null $post
 * @return Collection
 */
function rwp_ancestors($post = null) {

	$obj = rwp_object_type($post);

	$home_page = rwp_home_page();

	$ancestors = rwp_collection();

	if($home_page){
		$ancestors->push($home_page);
	}

	if (is_array($obj)) {
		$subtype      = rwp_get_option($obj, 'subtype', 'post');
		$post         = rwp_get_option($obj, 'object', $post);
		$id           = rwp_get_option($obj, 'id', 0);

		if (!empty($post)) {

			$parents = get_ancestors($id, $subtype);

			if (!empty($parents)) {
				$ancestors = $ancestors->concat(array_reverse($parents));
			}

			$ancestors = apply_filters("rwp_ancestors_pre_filter", $ancestors, $id, $subtype);

			$ancestors->transform(function ($item) {
				return rwp_object_type($item);
			});
		}

		$ancestors->push($obj);
	}
	$ancestors = apply_filters("rwp_ancestors_post_filter", $ancestors, $obj, $subtype);

	return $ancestors;
}
/**
 * Get Root Page
 *
 * @param int|null|\WP_Post $post
 *
 * @return null|array
 */

function rwp_root_page($post = null) {
	$post_id = rwp_id($post);
	$ancestors = rwp_ancestors($post);

	$home_page = rwp_home_page();

	$root = null;

	if($home_page){

		$root = $ancestors->first(function ($value) use ($home_page, $post_id) {
			return ($value['id'] !== $home_page && $value['id'] !== $post_id);
		});

	} else {
		$root = $ancestors->first(function ($value) use ($post_id) {
			return ($value['id'] !== $post_id);
		});
	}

	return $root;
}

/**
 *
 * @param mixed|null $post
 * @return array|false
 */

function rwp_parent($post = null) {

	$post_id = rwp_id($post);

	$ancestors = rwp_ancestors($post);

	$home_page = rwp_home_page();

	if ($ancestors->isNotEmpty()) {
		if($home_page){
			$parent = $ancestors->reverse()->first(function ($value) use ($home_page, $post_id) {
				return ($value['id'] !== $home_page && $value['id'] !== $post_id);
			});
		} else {
			$parent = $ancestors->reverse()->first(function ($value) use ($post_id) {
				return ($value['id'] !== $post_id);
			});
		}

		return $parent;
	} else {
		return false;
	}
}

/**
 * Generate an items html id
 *
 * @param mixed|null $post
 * @return string
 */

function rwp_post_id($post = null) {
	$post    = rwp_object_type($post);
	$type    = rwp_get_option($post, 'type', 'post');
	$subtype = rwp_get_option($post, 'subtype', '');
	$slug    = rwp_get_option($post, 'slug', '');
	$id      = rwp_get_option($post, 'id', 0);
	$html_id = array();

	if ('post' === $type) {
		if (!empty($subtype)) {
			$html_id[] = $subtype;
		} else {
			$html_id[] = $type;
		}
	} else {
		$html_id[] = $type;
		if (!empty($subtype)) {
			$html_id[] = $subtype;
		}
	}

	if (!empty($slug)) {
		$html_id[] = $slug;
	}

	$html_id[] = $id;

	$html_id = join('-', $html_id);
	$html_id = rwp_change_case($html_id, 'slug');

	return esc_attr($html_id);
}
