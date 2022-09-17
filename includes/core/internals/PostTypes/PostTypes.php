<?php

/**
 * ============================================================================
 * Post Types
 *
 * @package   RWP\Internals
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ==========================================================================
 */

namespace RWP\Internals\PostTypes;

use RWP\Base\Singleton;
use RWP\Helpers\Str;
use RWP\Helpers\Collection;

/**
 * Post Types and Taxonomies
 */
class PostTypes extends Singleton {

	/**
	 * @var Collection $cpts The registered cpts
	 */
	public static $cpts;

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		$this::$cpts = rwp_collection( rwp_get_option( 'cpt_options.cpts', array() ) )->mapWithKeys(function ( $item ) {
			if ( rwp_is_collection( $item ) ) {
				$item = $item->all();
			}
			$post_type = rwp_change_case( $item['value'], 'pascal' );

			$post_type_obj = rwp()->get_component( get_called_class() . "\\$post_type" );

			if ( $post_type_obj ) {
				$post_type = rwp_object_to_array( new $post_type_obj() );
			}

			return [ $item['value'] => $post_type ];
		});

		\add_action( 'init', array( $this, 'load_cpts' ), 5 );
		\add_filter( 'post_class', array( $this, 'clean_post_classes' ) );
		\add_filter( 'pre_get_posts', array( $this, 'filter_search' ) );

		//\add_action( 'pre_get_posts', array( $this, 'update_permalinks' ) );

	}

	/**
	 *
	 * @param string   $permalink  The site's permalink structure
	 * @param \WP_Post $post       The post in question
	 * @return mixed
	 */
	public function post_link( $post_link, $post ) {
		$blog_page = rwp_get_blog_page();
		if ( ! $blog_page ) {
			return $post_link;
		}

		$blog_page = get_post( $blog_page );

		if ( $post instanceof \WP_Post && $blog_page instanceof \WP_Post && 'post' === $post->post_type ) {
			$blog_page = untrailingslashit( wp_make_link_relative( get_permalink( $blog_page ) ) );
			$post_link = '/' . $blog_page . $post_link;
		}
		return $post_link;
	}

	/**
	 * Update post links if there is a custom blog page set
	 *
	 * @return void
	 */
	public function update_post_permalinks() {
		$blog_page = rwp_get_blog_page();

		if ( ! $blog_page ) {
			return;
		}
		$blog_page = get_post( $blog_page );

		if ( ! ( $blog_page instanceof \WP_Post ) ) {
			return;
		}
		$blog_slug = rwp_post_slug( $blog_page );
		$permalink_structure = get_option( 'permalink_structure', '/%postname%/' );

		$updated_permalink_structure = rwp_add_prefix( $permalink_structure, '/' . $blog_slug );

		if ( '/%postname%/' === $permalink_structure ) {
			update_option( 'permalink_structure', $updated_permalink_structure );
		}

		flush_rewrite_rules( true );
	}

	/**
	 *
	 * @param \WP_Query $query
	 * @return void
	 */
	public function update_permalinks( $query ) {

		// Bail if this is not the main query.
		if ( ! $query->is_main_query() ) {
			return;
		}

		// Bail if this query doesn't match our very specific rewrite rule.
		if ( ! isset( $query->query['page'] ) ) {
			return;
		}

		// Bail if we're not querying based on the post name.
		if ( empty( $query->query['name'] ) && ! $query->is_single ) {
			return;
		}

		$post_types = array_keys(get_post_types(array(
			'public'             => true,
			'publicly_queryable' => true,
		)));

		$post_types[] = 'page';

		$name = data_get( $query, 'query.name', '' );

		if ( ! empty( $name ) ) {
			$query->set( 'post_type', $post_types );
		}

		$blog_page = rwp_get_blog_page();
		$blog_slug = rwp_post_slug( $blog_page );

		if ( $blog_page && $name === $blog_slug ) {
			$post_types = '';
			$query->query = array(
				'page'     => '',
				'pagename' => $name,
			);
			$query->set( 'pagename', $name );
			$query->set( 'name', '' );
			$query->queried_object = get_post( $blog_page );
			$query->queried_object_id = $blog_page;
			$query->is_home = true;
			$query->is_posts_page = true;
			$query->is_singular = false;
			$query->is_single = false;
		} else {
			$query->set( 'pagename', $name );
			$query->set( 'landing-pages', $name );
			$postname = $name;
			$permalink_structure = get_option( 'permalink_structure', '/%postname%/' );
			if ( '/%postname%/' !== $permalink_structure ) {
				$permalink_structure = rwp_str( 'replace', '%postname%/', '', $permalink_structure );
				$permalink_structure = rwp_str( 'after', $permalink_structure, '/' );
				if ( rwp_str_has( $name, $permalink_structure ) ) {
					$name = rwp_str_remove( $permalink_structure, $name );
					$query->set( 'name', $name );
				}
			}

			$query->query = array(
				'landing-pages' => $name,
				'pagename'      => $name,
				'name'          => $postname,
			);
		}

		// $query->set( 'post_type', $post_types );
	}

	/**
	 * Remove 'rwp_' from custom post types, add sole rwp class
	 *
	 * @param string[] $classes An array of post class names.
	 *
	 * @return mixed
	 */
	public function clean_post_classes( $classes ) {
		foreach ( $classes as $index => $post_class ) {
			if ( rwp_str_has( $post_class, 'rwp_' ) ) {
				$classes[ $index ] = Str::remove( 'rwp_', $post_class );
			}
		}

		return $classes;
	}

	/**
	 * Add support for custom CPT on the search box
	 *
	 * @param  \WP_Query $query WP_Query.
	 * @since  0.9.0
	 * @return void
	 */
	public function filter_search( \WP_Query $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}
		if ( $query->is_search ) {
			/**
			 * @var Collection $cpts
			 */
			$cpts = $this::$cpts->reject(function ( array $item ) {
				return $item['exclude_from_search'];
			})->mapWithKeys(function ( array $item ) {
				return [ $item['type'] => $item ];
			});

			if ( $cpts->isNotEmpty() ) {

				$post_types = $query->get( 'post_type' );

				if ( ! is_array( $post_types ) ) {
					$post_types = array( $post_types );
				}

				if ( ! empty( $post_types ) ) {
					$post_types = array_merge( $post_types, $cpts->keys()->all() );

					$query->set( 'post_type', $post_types );
				}
			}
		}
	}

	/**
	 * Load CPT and Taxonomies on WordPress
	 *
	 * @since  0.9.0
	 * @return void
	 */
	public function load_cpts() {
		if ( ! empty( $this::$cpts ) ) {
			$this::$cpts->transform(function ( $args, $cpt ) {
				$label = rwp_singulizer( $cpt );
				$args = self::new_cpt( $label, '', '', '', $args );
				return $args;
			});
		}
	}

	/**
	 * Add a new cpt
	 *
	 * @param  mixed  $singular
	 * @param  string $plural
	 * @param  string $menu
	 * @param  array  $args
	 * @return array
	 */

	public static function new_cpt( $singular, $plural = '', $menu = '', $slug = '', $args = array() ) {

		$singular = rwp_change_case( rwp_singulizer( $singular ), 'title' );

		$plural = empty( $plural ) ? rwp_change_case( rwp_pluralizer( $singular ), 'title' ) : $plural;

		$labels = self::labels( $singular, $plural, $menu, $slug );

		if ( empty( $slug ) ) {
			$slug = data_get( $labels, 'names.slug', '' );
		}

		$defaults = array(
			'label'           => $singular,
			'labels'          => $labels['labels'],
			'rest_base'       => $slug,
			'capability_type' => 'page',
			'show_in_rest'    => true,
			'has_archive'     => false,
			'rewrite'         => array(
				'slug'       => $slug,
				'with_front' => false,
			),
		);

		$args = wp_parse_args( $args, $defaults );

		$type = rwp()->prefix( $singular );

		$names = $labels['names'];

		$args = apply_filters( "{$type}_cpt_args", $args ); // phpcs:ignore

		register_extended_post_type( $type, $args, $names );
		flush_rewrite_rules();

		$args['type'] = $type;

		return $args;
	}

	/**
	 * Post Type Labels Generator
	 *
	 * @param string $singular (Required) The singular version of the post type
	 * @param string $plural   (Required) The plural version of the post type
	 * @param string $menu     (Optional) The admin menu name. Defaults to $plural
	 * @param string $slug     (Optional) The post type slug
	 *
	 * @return array The array of post type labels
	 */
	public static function labels( $singular, $plural = '', $menu = '', $slug = '' ) {

		$singular = rwp_singulizer( $singular );

		if ( empty( $plural ) ) {
			$plural = rwp_pluralizer( $singular );
		}

		$lower_plural = rwp_change_case( $plural, 'lower' );
		$lower_singular = rwp_change_case( $singular, 'lower' );

		$title_singular = rwp_change_case( $singular, 'title' );
		$title_plural = rwp_change_case( $plural, 'title' );

		$slug = ! empty( $slug ) ? $slug : rwp_change_case( $lower_plural, 'slug' );

		$menu = $menu ?: $title_plural;

		return array(
			'names'  => array(
				'singular' => $title_singular,
				'plural'   => $title_plural,
				'slug'     => $slug,
			),
			'labels' => array(
				'name_admin_bar'           => $title_singular,
				'menu_name'                => $menu,
				'add_new_item'             => wp_sprintf( 'Add New %s', $title_singular ),
				'update_item'              => wp_sprintf( 'Update %s', $title_singular ),
				'new_item'                 => wp_sprintf( 'New %s', $title_singular ),
				'edit_item'                => wp_sprintf( 'Edit %s', $title_singular ),
				'view_item'                => wp_sprintf( 'View %s', $title_singular ),
				'view_items'               => wp_sprintf( 'View %s', $title_plural ),
				'search_items'             => wp_sprintf( 'Search %s', $title_plural ),
				'not_found'                => wp_sprintf( 'No %s found', $lower_plural ),
				'not_found_in_trash'       => wp_sprintf( 'No %s found in Trash.', $lower_plural ),
				'parent_item'              => wp_sprintf( 'Parent %s', $title_singular ),
				'parent_item_colon'        => wp_sprintf( 'Parent %s:', $title_singular ),
				'all_items'                => wp_sprintf( 'All %s', $title_plural ),
				'archives'                 => wp_sprintf( '%s Archives', $title_singular ),
				'attributes'               => wp_sprintf( '%s Attributes', $title_singular ),
				'insert_into_item'         => wp_sprintf( 'Insert into %s', $lower_singular ),
				'uploaded_to_this_item'    => wp_sprintf( 'Uploaded to this %s', $title_singular ),
				'filter_items_list'        => wp_sprintf( 'Filter %s list', $lower_plural ),
				'items_list_navigation'    => wp_sprintf( '%s list navigation', $title_plural ),
				'items_list'               => wp_sprintf( '%s list', $title_plural ),
				'item_published'           => wp_sprintf( '%s published.', $title_singular ),
				'item_published_privately' => wp_sprintf( '%s  published privately.', $title_singular ),
				'item_reverted_to_draft'   => wp_sprintf( '%s reverted to draft.', $title_singular ),
				'item_scheduled'           => wp_sprintf( '%s scheduled.', $title_singular ),
				'item_updated'             => wp_sprintf( '%s updated.', $title_singular ),
				'item_link'                => wp_sprintf( '%s Link', $title_singular ),
				'item_link_description'    => wp_sprintf( 'A link to a %s.', $lower_singular ),
			),
		);
	}

	public static function registered_cpts() {
		return self::$cpts;
	}
}