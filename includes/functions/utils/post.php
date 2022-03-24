<?php

/** ============================================================================
 * post
 *
 * @package   RWP\/includes/functions/utils/post.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


use \RWP\Vendor\Illuminate\Support\Collection;
use RWP\Internals\PostTypes;
use RWP\Internals\Taxonomies;

/**
 * Is item a blog post
 *
 * Checks different conditionals to see if the current item is a blog post
 *
 * @return bool
 */
function rwp_is_blog( $post = null ) {
	if ( ! ( $post instanceof \WP_Post ) ) {
		$post = get_post( $post );
	}
	$posttype = get_post_type( $post );
	return ( ( ( is_archive() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) ) && ( 'post' === $posttype ) ) ? true : false;
}

/**
 * Function to get the ID home page
 *
 * @return int|false
 */

function rwp_get_home_page() {
	$home = get_option( 'page_on_front' );
	if ( $home ) {
		$home = intval( $home );
	}
	return $home;
}

/**
 * Function to get the ID blog page
 *
 * @return int|false
 */

function rwp_get_blog_page() {
	$blog = get_option( 'page_for_posts' );
	if ( $blog ) {
		$blog = intval( $blog );
	}
	return $blog;
}

/**
 * Check if a post is a custom post type.
 *
 * @param  mixed $post Post object or ID
 * @return boolean
 */
function rwp_post_is_cpt( $post = null ) {
	$all_custom_post_types = get_post_types( array( '_builtin' => false ) );

	// there are no custom post types
	if ( empty( $all_custom_post_types ) ) {
		return false;
	}

	$custom_types      = array_keys( $all_custom_post_types );
	$current_post_type = get_post_type( $post );

	// could not detect current type
	if ( ! $current_post_type ) {
		return false;
	}

	return in_array( $current_post_type, $custom_types );
}

/**
 * Generate array of post type labels
 *
 * Used for generated custom post types
 *
 * @param string $singular Required. The singular version of the post type
 * @param string $plural   Optional. The plural version of the post type
 * @param string $menu     Optional. The label to use in the admin menu
 * @param string $slug     Optional. The post type slug
 *
 * @return array
 */
function rwp_cpt_labels( $singular, $plural = '', $menu = '', $slug = '' ) {

	return PostTypes::labels( $singular, $plural, $menu, $slug );
}

/**
 * Generate array of taxonomy labels
 *
 * Used for generating custom taxonomy types
 *
 * @param string $singular Required. The singular version of the taxonomy
 * @param string $plural   Optional. The plural version of the taxonomy
 * @param string $menu     Optional. The label to use in the admin menu
 * @param string $slug     Optional. The taxonomy slug
 *
 * @return array
 */
function rwp_tax_labels( $singular, $plural = '', $menu = '', $slug = '' ) {

	return Taxonomies::labels( $singular, $plural, $menu, $slug );
}

/**
 * Get the page ID for the given or current post type
 *
 * @param bool|string $post_type
 *
 * @return bool|int
 */
function rwp_get_page_for_post_type( $post_type = false ) {
	if ( ! $post_type && is_post_type_archive() ) {
		$post_type = get_queried_object()->name;
	}
	if ( ! $post_type && is_singular() ) {
		$post_type = get_queried_object()->post_type;
	}
	if ( ! $post_type && in_the_loop() ) {
		$post_type = get_post_type();
	}
	if ( $post_type ) {
		if ( 'post' === $post_type ) {
				return rwp_get_blog_page();
		} else if ( in_array( $post_type, get_post_types() ) ) {
			return get_option( "page_for_{$post_type}", false );
		}
	}

	return false;
}

/**
 * Helps for standardizing requests
 *
 * @param  mixed|null $obj
 * @param  string     $type
 * @return array     $info {
 *     The object info
 *
 * @type str      $type     The general type of object. One of post|archive
 *                              |term|user|widget|comment|taxonomy|error|search
 * @type str      $subtype  The sub-type. So if it is a post, it is the
 *                              post type, or if its a term, it's the taxonomy
 * @type int      $id       The object id or 0
 * @type int|str  $acf_id   The formatted ACF id
 * @type str      $title    The object title
 * @type int      $parent   The parent id or 0
 * @type str      $slug     The slug
 * @type str      $url      The item url (relative to home)
 * @type mixed    $object   The object instance.
 *
 * }
 */
function rwp_post( $obj = null, $type = 'post' ) {

	if ( ! is_array( $obj ) ) {

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
			'title'   => wp_sprintf( '%s%s', __( 'Search Results for: ', 'rwp' ), get_search_query() ),
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
			'title'   => __( '404: Not Found', 'rwp' ),
			'parent'  => $parent,
			'slug'    => 'error-404',
			'url'     => '',
			'object'  => null,
		);

		if ( is_404() && empty( $obj ) ) {
			return $error;
		}

		if ( is_search() && empty( $obj ) ) {
			return $search;
		}

		if ( is_numeric( $obj ) ) {
			$id = intval( $obj );

			if ( ! empty( $id ) ) {
				switch ( $type ) {
					case 'comment':
						$obj = get_comment( $id );
						break;
					case 'term':
						$obj = get_term( $id );
						break;
					case 'user':
						$obj = get_userdata( $id );
						break;
					default:
						$obj = get_post( $id );
						break;
				}
			} else {
				return $error;
			}
		}

		if ( empty( $obj ) ) {
			$obj = get_queried_object();
		}

		if ( is_object( $obj ) ) {

			if ( $obj instanceof \WP_Post ) {
				$type     = 'post';
				$sub_type = $obj->post_type; // What type of post is it?
				$id       = $obj->ID;
				$acf_id   = $id;
				$title    = $obj->post_title;
				$parent   = $obj->post_parent;
				$slug     = $obj->post_name;
				$url      = get_permalink( $id );
			} else if ( $obj instanceof \WP_Post_Type ) {
				$type     = 'archive';
				$sub_type = $obj->name; // What type of archive is it?
				$title    = $obj->label;
				$slug     = 'archive-' . $obj->name;

				$url      = get_post_type_archive_link( $sub_type );

				$custom_archive_page = false;

				if ( rwp_get_option( 'cpt_options.page_for_cpt', false ) ) {
					$custom_archive_page = rwp_get_page_for_post_type( $sub_type );
				}

				if ( ! empty( $custom_archive_page ) ) {
					return rwp_post( $custom_archive_page );
				}
				$info['description'] = $obj->description;
			} else if ( $obj instanceof \WP_Term ) {
				$type     = 'term';
				$sub_type = $obj->taxonomy; // What type of term is it?
				$id       = $obj->term_id;
				$acf_id   = "{$type}_{$id}";
				$title    = $obj->name;
				$parent   = $obj->parent;
				$slug     = $obj->slug;
				$url      = get_term_link( $id, $sub_type );
			} else if ( $obj instanceof \WP_User ) {
				$type     = 'user';
				$sub_type = $obj->cap_key; // What type of user is it?
				$id       = $obj->ID;
				$acf_id   = "{$type}_{$id}";
				$title    = $obj->display_name;
				$slug     = $title;
			} else if ( $obj instanceof \WP_Widget ) {
				$type     = 'widget';
				$sub_type = $obj->name; // What type of widget is it?
				$id       = $obj->id;
				$acf_id   = "{$type}_{$id}";
				$slug     = rwp_change_case( $id, 'slug' );
			} else if ( $obj instanceof \WP_Comment ) {
				$type     = 'comment';
				$sub_type = $obj->comment_type;
				$id       = $obj->comment_ID;
				$acf_id   = "{$type}_{$id}";
				$parent   = $obj->comment_parent;
				$slug     = $id;
				$url      = get_comment_link( $obj );
				$info['post_parent'] = $obj->comment_post_ID; // ID of the post the comment is associated with.
			} else if ( $obj instanceof \WP_Taxonomy ) {
				$type     = 'taxonomy';
				$sub_type = $obj->name; // What type of taxonomy is it?
				$title    = $obj->label;
				$slug     = 'taxonomy-' . $sub_type;

				$custom_archive_page = false;

				if ( rwp_get_option( 'cpt_options.page_for_cpt', false ) ) {
					$custom_archive_page = rwp_get_page_for_post_type( $sub_type );
				}

				if ( ! empty( $custom_archive_page ) ) {
					return rwp_post( $custom_archive_page );
				}

				$info['description'] = $obj->description;
			}

			$object = $obj;
		}

		if ( ! empty( $url ) ) {
			$url = rwp_relative_url( $url );
		}
		if ( ! empty( $slug ) ) {
			$slug = rwp_change_case( $slug, 'slug' );
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

		if ( ! empty( $info ) ) {
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
function rwp_post_object( $post = null ) {
	$post = rwp_post( $post );
	$post = data_get( $post, 'object', null );

	global $wp_query;

	if ( ( is_search() && $wp_query->is_main_query() ) || is_404() ) {
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
 * @param  mixed|null $post
 * @return mixed
 */

function rwp_post_subtype( $post = null ) {

	return data_get( rwp_post( $post ), 'subtype', 'post' );
}


/**
 * Rolls all types of ID requests for various object types into one function
 *
 * Also formats the id for use in ACF
 *
 * @param  mixed|null $obj
 * @param  mixed|null $id_type
 * @return int|string
 */
function rwp_post_id( $obj = null, $id_type = null ) {
	$obj_type = rwp_post( $obj );
	$id       = data_get( $obj_type, 'id', 0 );
	$acf_id   = data_get( $obj_type, 'acf_id', 'options' );

	if ( 'acf' === $id_type ) {

		$id = $acf_id;
	}

	return $id;
}

/**
 * Get the post slug
 *
 * @param mixed|null $post
 * @return mixed
 */
function rwp_post_slug( $post = null ) {
	return data_get( rwp_post( $post ), 'slug' );
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
function rwp_filtered_content( $content = '', $beautify = false ) {

	if ( ! is_string( $content ) ) {
		return $content;
	}

	$content = apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

	$content = str_replace( ']]>', ']]&gt;', $content );

	if ( $beautify ) {
		$content = rwp_beautify_html( $content );
	}

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

function rwp_post_content( $post = null, $more_link_text = null, $strip_teaser = false ) {

	$obj = rwp_post( $post );

	$object_type  = data_get( $obj, 'type', 'post' );
	$post_object  = data_get( $obj, 'object' );
	$subtype      = data_get( $obj, 'subtype', 'post' );

	$id = data_get( $obj, 'id', 0 );

	$content = '';

	if ( 'post' === $object_type ) {
		$content = get_the_content( $more_link_text, $strip_teaser, $id );
	} elseif ( 'term' === $object_type ) {
		$content = get_term_field( 'description', $post_object );
	} elseif ( 'archive' === $object_type ) {
		$content = data_get( $obj, 'description', '' );
		$post_type_obj = get_post_type_object( $subtype );
		$content = apply_filters( 'get_the_post_type_description', $content, $post_type_obj ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
	}

	$content = rwp_filtered_content( $content );

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
function rwp_post_excerpt( $post = null, $args = [] ) {
	$obj          = rwp_post( $post );
	$type         = data_get( $obj, 'type', 'post' );
	$post_object  = data_get( $obj, 'object' );
	$subtype      = data_get( $obj, 'subtype', 'post' );
	$subtype      = rwp()->unprefix( $subtype );
	$excerpt      = '';
	$post         = data_get( $obj, 'object', $post );

	$args         = apply_filters( 'rwp_excerpt_args', $args );
	$args         = apply_filters( "rwp_{$type}_excerpt_args", $args );
	$args         = apply_filters( "rwp_{$subtype}_excerpt_args", $args );

	$length       = data_get( $args, 'length', 15 );
	$variable     = data_get( $args, 'variable', true );
	$excerpt_end  = data_get( $args, 'excerpt_end', '' );
	$allowed_tags = data_get( $args, 'allowed_tags', array( 'em', 'i', 'b', 'strong' ) );
	$trim_type    = data_get( $args, 'trim_type', 'words' );

	if ( 'post' === $type ) {
		if ( has_excerpt( $post ) ) {
			$excerpt      = get_the_excerpt( $post );
		}
	} elseif ( 'term' === $type ) {
		$excerpt = get_term_field( 'description', $post_object );
	} elseif ( 'archive' === $type ) {
		$excerpt = data_get( $obj, 'description', '' );
		$post_type_obj = get_post_type_object( $subtype );
		$excerpt = apply_filters( 'get_the_post_type_description', $excerpt, $post_type_obj ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
	}
	if ( empty( $excerpt ) ) {
		$excerpt = $post->post_content;
		if ( ! empty( $length ) ) {
			$excerpt = rwp_trim_text( $excerpt, $length, $variable, $excerpt_end, $allowed_tags, $trim_type );
		}
	}

	$excerpt         = apply_filters( 'rwp_excerpt', $excerpt );
	$excerpt         = apply_filters( "rwp_{$type}_excerpt", $excerpt );
	$excerpt         = apply_filters( "rwp_{$subtype}_excerpt", $excerpt );
	return $excerpt;
}

/**
 * Get the item link
 *
 * @param  mixed|null $post
 * @return string
 */
function rwp_post_link( $post = null ) {
	$obj = rwp_post( $post );

	$link = data_get( $obj, 'url', '' );

	return $link;
}

/**
 * Get the item title
 *
 * @param  mixed|null $post
 * @param  bool       $use_alt
 * @param  string     $before
 * @param  string     $after
 *
 * @return string
 */

function rwp_post_title( $post = null, $use_alt = false, $before = '', $after = '' ) {

	$obj     = rwp_post( $post );
	$type    = data_get( $obj, 'type', 'post' );
	$subtype = data_get( $obj, 'subtype', 'post' );
	$subtype = rwp()->unprefix( $subtype );
	$acf_id  = data_get( $obj, 'acf_id', 'options' );
	$title   = data_get( $obj, 'title', '' );

	if ( 'post' === $type ) {
		$title = get_the_title( $post );
	} elseif ( 'archive' === $type || 'term' === $type ) {
		ob_start();

		the_archive_title();

		$title = ob_get_contents();

		ob_end_clean();
	}

	if ( $use_alt ) {
		$alt_title    = get_field( 'alt_title', $acf_id );
		if ( ! empty( $alt_title ) ) {
			$title = $alt_title;
		}
	}

	$title = rwp_add_prefix( $title, $before );
	$title = rwp_add_suffix( $title, $after );
	$title = apply_filters( 'rwp_title', $title, $use_alt, $obj );
	$title = apply_filters( "rwp_{$type}_title", $title, $use_alt, $obj );
	$title = apply_filters( "rwp_{$subtype}_title", $title, $use_alt, $obj );

	return $title;
}

/**
 * Get the ancestors for an item with filters
 *
 * @param  mixed|null $post
 * @return Collection
 */
function rwp_post_ancestors( $post = null ) {

	$obj = rwp_post( $post );

	$home_page = rwp_get_home_page();

	$ancestors = rwp_collection();

	if ( $home_page ) {
		$ancestors->push( $home_page );
	}

	if ( is_array( $obj ) ) {
		$subtype   = data_get( $obj, 'subtype', 'post' );
		$post      = data_get( $obj, 'object', $post );
		$id        = data_get( $obj, 'id', 0 );
		$type      = data_get( $obj, 'type', 0 );
		$post_type = $subtype;

		if ( ! empty( $post ) ) {
			if ( 'post' === $type ) {

				if ( 'page' === $post_type ) {
					$parents = get_ancestors( $id, $post_type );

					if ( ! empty( $parents ) ) {
						$ancestors = $ancestors->concat( array_reverse( $parents ) );
					}
				} else {
					$parent = rwp_get_page_for_post_type( $subtype );
					if ( $parent ) {
						$parent = rwp_post_id( $parent );
						$grandparents = get_ancestors( $parent );
						$ancestors = $ancestors->concat( array_reverse( $grandparents ) );
						$ancestors->push( $parent );
					}
				}
			} else if ( 'term' === $type ) {
				$taxonomy = get_taxonomy( $subtype );
				$post_type = reset( $taxonomy->object_type );

				$grandparent = rwp_get_page_for_post_type( $post_type ); // Associate the term beneath the cpt archive page

				if ( $grandparent ) {
					$grandparent = rwp_post_id( $grandparent );
					$grandparents = get_ancestors( $grandparent );
					$ancestors = $ancestors->concat( array_reverse( $grandparents ) );
					$ancestors->push( $grandparent );
				}

				$parents = get_ancestors( $id, $subtype, $type );

				if ( ! empty( $parents ) ) {
					$ancestors = $ancestors->concat( array_reverse( $parents ) );
				}
			}
		}

		$ancestors = apply_filters( 'rwp_post_ancestors_pre_filter', $ancestors, $id, $subtype );

		$ancestors->transform(
			function ( $item ) {
				return rwp_post( $item );
			}
		);

		$ancestors->push( $obj );
	}
	$ancestors = apply_filters( 'rwp_post_ancestors_post_filter', $ancestors, $obj, $subtype );

	return $ancestors;
}

/**
 * Find Root Page for deeply nested posts (That is not home page);
 *
 * @param int|null|\WP_Post $post
 *
 * @return null|array
 */

function rwp_root_page( $post = null ) {
	$post_id = rwp_post_id( $post );
	$ancestors = rwp_post_ancestors( $post );

	$home_page = rwp_get_home_page();

	$root = null;

	if ( $home_page ) {

		$root = $ancestors->first(
			function ( $value ) use ( $home_page, $post_id ) {
				return ( $value['id'] !== $home_page && $value['id'] !== $post_id );
			}
		);
	} else {
		$root = $ancestors->first(
			function ( $value ) use ( $post_id ) {
				return ( $value['id'] !== $post_id );
			}
		);
	}

	return $root;
}

/**
 * Get the post parent
 *
 * @param  mixed|null $post
 * @return array|false
 */

function rwp_post_parent( $post = null ) {

	$post_id = rwp_post_id( $post );

	$ancestors = rwp_post_ancestors( $post );

	$home_page = rwp_get_home_page();

	if ( $ancestors->isNotEmpty() ) {
		if ( $home_page ) {
			$parent = $ancestors->reverse()->first(
				function ( $value ) use ( $home_page, $post_id ) {
					return ( $value['id'] !== $home_page && $value['id'] !== $post_id );
				}
			);
		} else {
			$parent = $ancestors->reverse()->first(
				function ( $value ) use ( $post_id ) {
					return ( $value['id'] !== $post_id );
				}
			);
		}

		return $parent;
	} else {
		return false;
	}
}

/**
 * Generate an items html id
 *
 * @param  mixed|null $post
 * @return string
 */

function rwp_post_id_html( $post = null ) {
	$post    = rwp_post( $post );
	$type    = data_get( $post, 'type', 'post' );
	$subtype = data_get( $post, 'subtype', '' );
	$slug    = data_get( $post, 'slug', '' );
	$id      = data_get( $post, 'id', 0 );
	$html_id = array();

	if ( 'post' === $type ) {
		if ( ! empty( $subtype ) ) {
			$html_id[] = $subtype;
		} else {
			$html_id[] = $type;
		}
	} else {
		$html_id[] = $type;
		if ( ! empty( $subtype ) && $subtype !== $type ) {
			$html_id[] = $subtype;
		}
	}

	if ( ! empty( $slug ) ) {
		$html_id[] = $slug;
	}

	if ( 0 !== $id ) {
		$html_id[] = $id;
	}

	$html_id = array_unique( $html_id );
	$html_id = join( '-', $html_id );
	$html_id = rwp_change_case( $html_id, 'slug' );

	return esc_attr( $html_id );
}


/**
 * Get array of post classes
 *
 * @param \WP_Post|int|null $post
 * @param string|string[]   $classes
 *
 * @return string[]
 */
function rwp_get_post_class( $post, $classes = '' ) {
	$post_id = rwp_post_id( $post );
	return rwp_parse_classes( get_post_class( $classes, $post_id ) );
}

/**
 * Output string of post classes
 *
 * @param \WP_Post|int|null $post
 * @param string|string[]   $classes
 *
 * @return string
 */
function rwp_post_class( $post, $classes = '' ) {
	return rwp_output_classes( rwp_get_post_class( $post, $classes ) );
}

/**
 * Check if a post has children
 *
 * @param mixed|null $post
 *
 * @return bool
 */
function rwp_post_has_children( $post = null ) {

	$ancestors = rwp_post_ancestors( $post );

	$post_id = rwp_post_id( $post );

	if ( $ancestors->isNotEmpty() ) {
		$ancestors = $ancestors->keyBy( 'id' )->keys();

		$last_item = $ancestors->last();

		if ( $post_id == $last_item ) {
			return false;
		} else {
			return true;
		}
	}
	return false;
}

/**
 * Quick function to get a list of all posts of a certain type (cached).
 *
 * @param string $post_type  The post type to retrieve
 * @param string $orderby    The order of the posts
 * @param string $order      Ascending or Descending
 * @param array  $args       Additional arguments to merge with the defaults
 *
 * @return WP_Query
 */
function rwp_post_type_query( $post_type, $orderby = 'menu_order', $order = 'ASC', $args = array() ) {
	$query_args = array(
		'post_type'      => array( $post_type ),
		'post_status'    => array( 'publish' ),
		'has_password'   => false,
		'posts_per_page' => '-1',
		'order'          => $order,
		'orderby'        => $orderby,
	);

	$query_args = wp_parse_args( $args, $query_args );
	$post_query = wp_cache_remember($post_type, function () use ( $query_args ) {
		return new \WP_Query( $query_args );
	}, 'post-types');

	return $post_query;
}
