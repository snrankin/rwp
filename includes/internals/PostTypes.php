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

/**
 * Post Types and Taxonomies
 */
class PostTypes extends Singleton {

	public $cpts;

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( rwp_get_option( 'cpt_options.page_for_cpt', false ) ) {
			rwp_get_plugin_file( 'page-for-post-type.php', 'includes/dependencies/vendor/wordpress/page-for-post-type', true, true );
		}

		\add_action( 'init', array( $this, 'load_cpts' ) );

		$cpts = rwp_get_option( 'cpt_options.cpts', array() );
		$cpts = rwp_collection( $cpts );

		$cpts = $cpts->mapWithKeys(
			function ( $item, $key ) {
				return [ $item['value'] => $item['label'] ];
			}
		);

		$this->cpts = $cpts;

		if ( $cpts->has( 'team_member' ) ) {
			$this->init_team_member_cpt();
		}

		if ( $cpts->has( 'landing_page' ) ) {
			$this->init_landing_page_cpt();
		}

		if ( $cpts->has( 'global_block' ) ) {
			$this->init_global_block_cpt();
		}

		if ( $cpts->has( 'page_header' ) ) {
			$this->init_page_header_cpt();
		}

		if ( $cpts->has( 'testimonial' ) ) {
			$this->init_testimonial_cpt();
		}

		/*
        * Custom Columns
        */

		// Add bubble notification for cpt pending
		\add_action( 'admin_menu', array( $this, 'pending_cpt_bubble' ), 999 );
		\add_filter( 'pre_get_posts', array( $this, 'filter_search' ) );
	}

	/**
	 * Add support for custom CPT on the search box
	 *
	 * @param  \WP_Query $query WP_Query.
	 * @since  1.0.0
	 * @return \WP_Query
	 */
	public function filter_search( \WP_Query $query ) {
		global $wp_post_types;

		if ( $query->is_search && ! \is_admin() ) {
			$post_types = $query->get( 'post_type' );

			if ( 'post' === $post_types ) {
				$post_types = array( $post_types );
				$query->set( 'post_type', \array_push( $post_types, array( 'demo' ) ) );
			}
		}

		return $query;
	}

	/**
	 * Load CPT and Taxonomies on WordPress
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function load_cpts() {
		$cpts = rwp_get_option( 'cpt_options.cpts', array() );

		if ( ! empty( $cpts ) ) {
			foreach ( $cpts as $cpt ) {
				$label = rwp_singulizer( data_get( $cpt, 'value' ) );
				self::new_cpt( $label );
			}
		}
	}

	/**
	 * Add a new cpt
	 *
	 * @param  mixed  $singular
	 * @param  string $plural
	 * @param  string $menu
	 * @param  array  $args
	 * @return void
	 */

	public static function new_cpt( $singular, $plural = '', $menu = '', $args = array() ) {

		$singular = rwp_change_case( rwp_singulizer( $singular ), 'title' );

		$plural = empty( $plural ) ? rwp_change_case( rwp_pluralizer( $singular ), 'title' ) : $plural;

		$defaults = array(
			'label'               => $singular,
			'labels'              => self::cpt_labels( $singular, $plural, $menu ),
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

		$slug = rwp_change_case( $singular );

		$names  = array(
			'plural' => $plural,
			'singular' => $singular,
			'slug' => $slug,

		);

		$args = apply_filters( "{$type}_cpt_args", $args );

		if ( ! empty( $type ) ) {
			if ( strlen( $type ) < 20 ) {
				register_extended_post_type( $type, $args, $names );
				flush_rewrite_rules();
			}
		}
	}

	/**
	 * Post Type Labels Generator
	 *
	 * @param string $singular (Required) The singular version of the post type
	 * @param string $plural   (Required) The plural version of the post type
	 * @param string $menu     (Optional) The admin menu name. Defaults to $plural
	 *
	 * @return array The array of post type labels
	 */
	public static function cpt_labels( $singular, $plural = '', $menu = '' ) {

		$singular = rwp_singulizer( $singular );

		if ( empty( $plural ) ) {
			$plural = rwp_pluralizer( $singular );
		}

		$lower_plural = rwp_change_case( $plural, 'lower' );
		$lower_singular = rwp_change_case( $singular, 'lower' );

		$title_singular = rwp_change_case( $singular, 'title' );
		$title_plural = rwp_change_case( $plural, 'title' );

		$menu = $menu ?: $title_plural;

		return array(
			'name'                     => $title_plural,
			'singular_name'            => $title_singular,
			'menu_name'                => $menu,
			'name_admin_bar'           => $title_singular,
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
		);

	}

	/**
	 * Init Team Member functionality
	 *
	 * @return void
	 */

	public function init_team_member_cpt() {
		\add_filter(
			'rwp_team_member_cpt_args',
			function ( $args ) {
				$updated_args = array(
					'menu_icon'   => 'dashicons-groups',
					'supports'    => array(
						'title',
						'editor',
						'excerpt',
						'thumbnail',
						'custom-fields',
						'page-attributes',
					),
				);
				$args = rwp_merge_args( $args, $updated_args );

				return $args;
			}
		);
	}

	/**
	 * Init Team Member functionality
	 *
	 * @return void
	 */

	public function init_testimonial_cpt() {
		\add_filter(
			'rwp_testimonial_cpt_args',
			function ( $args ) {
				$updated_args = array(
					'menu_icon'   => 'dashicons-star-filled',
					'supports'    => array(
						'title',
						'editor',
						'excerpt',
						'thumbnail',
						'custom-fields',
						'page-attributes',
					),
					'admin_cols' => array(
						// The default Title column:
						'title',
						// A meta field column:
						'rating' => array(
							'title'       => 'Rating',
							'function' => function () {
								$field = get_field_object( 'rating' );
								echo \StarRatingField::output_stars( $field ); // phpcs:ignore
							},
						),
					),

				);
				$args = rwp_merge_args( $args, $updated_args );

				return $args;
			}
		);
	}

	/**
	 * Init Global Block functionality
	 *
	 * @return void
	 */

	public function init_global_block_cpt() {
		\add_filter(
			'rwp_global_block_cpt_args',
			function ( $args ) {
				$updated_args = array(
					'menu_icon'           => 'dashicons-admin-site',
					'has_archive'         => false,
					'public'              => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'supports'            => array(
						'title',
						'editor',
						'page-attributes',
						'custom-fields',
					),
				);
				$args = rwp_merge_args( $args, $updated_args );

				return $args;
			}
		);
	}

	/**
	 * Init Page Header functionality
	 *
	 * @return void
	 */

	public function init_page_header_cpt() {
		\add_filter(
			'rwp_page_header_cpt_args',
			function ( $args ) {
				$updated_args = array(
					'menu_icon'           => 'dashicons-slides',
					'has_archive'         => false,
					'public'              => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'supports'            => array(
						'title',
						'editor',
						'page-attributes',
						'custom-fields',
					),
				);
				$args = rwp_merge_args( $args, $updated_args );

				return $args;
			}
		);
	}

	/**
	 * Init Landing Pages functionality
	 *
	 * @return void
	 */
	public function init_landing_page_cpt() {
		\add_filter(
			'rwp_landing_page_cpt_args',
			function ( $args ) {
				$updated_args = array(
					'menu_icon'   => 'dashicons-welcome-widgets-menus',
					'has_archive' => false,
					'rewrite'     => array(
						'slug'       => '/',
						'with_front' => false,
					),
					'supports'    => array(
						'title',
						'editor',
						'excerpt',
						'thumbnail',
						'custom-fields',
						'page-attributes',
					),
				);
				$args = rwp_merge_args( $args, $updated_args );

				return $args;
			}
		);

		/**
		 * Remove the slug from published post permalinks.
		 * Only affect landing pages.
		 *
		 * @link https://gist.github.com/kellenmace/a79dfde1e5a14d51a8014d880dac52e7
		 */

		add_filter(
			'post_type_link',
			function ( $post_link, $post ) {

				if ( 'rwp_landing_page' === $post->post_type && 'publish' === $post->post_status ) {
					$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
				}

				return $post_link;
			},
			10,
			2
		);

		/**
		 * Have WordPress match postname to any of our public post types
		 * All of our public post types can have /post-name/ as the slug, so
		 * they need to be unique across all posts. By default, WordPress only
		 * accounts for posts and pages where the slug is /post-name/.
		 *
		 * @link https://gist.github.com/kellenmace/fae42a47342d0ee4fe4a
		 *
		 * @param $query The current query.
		 */

		\add_action(
			'pre_get_posts',
			function ( $wp_query ) {

				/**
				 * @var \WP_Query $query
				 */

				$query = $wp_query;

				// Bail if this is not the main query.
				if ( ! $query->is_main_query() ) {
					return;
				}

				// Bail if this query doesn't match our very specific rewrite rule.
				if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
					return;
				}

				// Bail if we're not querying based on the post name.
				if ( empty( $query->query['name'] ) ) {
					return;
				}

				// Add CPT to the list of post types WP will include when it queries based on the post name.
				$post_types = $query->get( 'post_type', array() );

				$post_types[] = 'rwp_landing_page';

				$query->set( 'post_type', $post_types );
			}
		);
	}
}
