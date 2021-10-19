<?php

/**
 * ============================================================================
 * Post Types
 *
 * @package   RWP\Internals
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ==========================================================================
 */

namespace RWP\Internals;

use RWP\Engine\Abstracts\Singleton;
use RWP\Vendor\Illuminate\Support\Str;
use RWP\Vendor\Illuminate\Support\Collection;

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
		if ( rwp_get_option( 'cpt_options.page_for_cpt', false ) ) {
			rwp_get_plugin_file( 'page-for-post-type.php', 'includes/dependencies/vendor/wordpress/page-for-post-type', true, true );
		}

		$this::$cpts = rwp_collection( rwp_get_option( 'cpt_options.cpts', array() ) )->mapWithKeys(function ( $item ) {
			return [ $item['value'] => $item['label'] ];
		});

		\add_action( 'init', array( $this, 'load_cpts' ) );
		\add_filter( 'post_class', array( $this, 'clean_post_classes' ) );
		\add_filter( 'pre_get_posts', array( $this, 'filter_search' ) );
	}

	/**
	 * Remove 'rwp_' from custom post types, add sole rwp class
	 *
	 * @param string[] $classes An array of post class names.
	 * @param string[] $class   An array of additional class names added to the post.
	 * @param int      $post_id The post ID.
	 *
	 * @return mixed
	 */
	public function clean_post_classes( $classes, $class = array(), $post_id = 0 ) {
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
	 * @since  1.0.0
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
	 * @since  1.0.0
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

		$defaults = array(
			'label'               => $singular,
			'labels'              => $labels['labels'],
			'capability_type'     => 'page',
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
		);

		$args = wp_parse_args( $args, $defaults );

		$type = rwp()->prefix( $singular, '_', 'snake' );

		$names  = $labels['names'];

		$args = apply_filters( "{$type}_cpt_args", $args );

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
			'names'     => array(
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
