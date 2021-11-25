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
use RWP\Components\Str;
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

		$this::$cpts = rwp_collection( rwp_get_option( 'cpt_options.cpts', array() ) )->mapWithKeys(function ( $item ) {
			return [ $item['value'] => $item['label'] ];
		});

		\add_action( 'init', array( $this, 'load_cpts' ) );
		\add_filter( 'post_class', array( $this, 'clean_post_classes' ) );
		\add_filter( 'pre_get_posts', array( $this, 'filter_search' ) );

		if ( rwp_get_option( 'modules.blog.update_urls', false ) ) { // can't rewrite basic permalinks with ELementor :(
			\add_filter( 'register_post_type_args', array( $this, 'add_blog_page_to_post_url' ), 10, 2 );
			\add_action( 'generate_rewrite_rules', array( $this, 'generate_blog_rewrite_rules' ) );
			\add_filter( 'pre_post_link', array( $this, 'post_link' ), 1, 3 );
			//\add_action( 'init', array( $this, 'update_post_permalinks' ) );
		}

	}

	/**
	 * Rewrite WordPress URLs to Include /blog/ in Post Permalink Structure
	 *
	 * @author   Golden Oak Web Design <info@goldenoakwebdesign.com>
	 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPLv2+
	 */
	public function generate_blog_rewrite_rules( $wp_rewrite ) {
		$blog_page = rwp_get_blog_page();
		if ( ! $blog_page ) {
			return;
		}

		$blog_page = get_post( $blog_page );

		$blog_page = untrailingslashit( wp_make_link_relative( get_permalink( $blog_page ) ) );
		$blog_page = rwp_remove_prefix( $blog_page, '/' );

		$rules = $wp_rewrite->rules;

		$new_rules = array(
			'/' . $blog_page . '/?$' => 'index.php?post_type=post',
			'/' . $blog_page . '/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&feed=$matches[1]',
			'/' . $blog_page . '/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&feed=$matches[1]',
			'/' . $blog_page . '/page/([0-9]{1,})/?$' => 'index.php?post_type=post&paged=$matches[1]',
			$blog_page . '/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?acfe-dt=$matches[1]&paged=$matches[2]',
			$blog_page . '/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?acfe-dt=$matches[1]&cpage=$matches[2]',
			$blog_page . '/([^/]+)/?$' => 'index.php?wp_template=$matches[1]',
			$blog_page . '/(.+?)/page/?([0-9]{1,})/?$' => 'index.php?acfe-dop=$matches[1]&paged=$matches[2]',
			$blog_page . '/(.+?)/comment-page-([0-9]{1,})/?$' => 'index.php?acfe-dop=$matches[1]&cpage=$matches[2]',
			$blog_page . '/(.+?)/?$' => 'index.php?post_type=page&pagename=$matches[1]',
			$blog_page . '/.+?/attachment/([^/]+)/?$' => 'index.php?attachment=$matches[1]',
			$blog_page . '/.+?/attachment/([^/]+)/trackback/?$' => 'index.php?attachment=$matches[1]&tb=1',
			$blog_page . '/.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
			$blog_page . '/.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
			$blog_page . '/.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?attachment=$matches[1]&cpage=$matches[2]',
			$blog_page . '/.+?/attachment/([^/]+)/embed/?$' => 'index.php?attachment=$matches[1]&embed=true',
			$blog_page . '/(.+?)/embed/?$' => 'index.php?acfe-dop=$matches[1]&embed=true',
			$blog_page . '/(.+?)/trackback/?$' => 'index.php?acfe-dop=$matches[1]&tb=1',
			$blog_page . '/(.+?)(?:/([0-9]+))?/?$' => 'index.php?acfe-dop=$matches[1]&page=$matches[2]',
			$blog_page . '/[^/]+/attachment/([^/]+)/?$' => 'index.php?attachment=$matches[1]',
			$blog_page . '/[^/]+/attachment/([^/]+)/trackback/?$' => 'index.php?attachment=$matches[1]&tb=1',
			$blog_page . '/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
			$blog_page . '/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
			$blog_page . '/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?attachment=$matches[1]&cpage=$matches[2]',
			$blog_page . '/[^/]+/attachment/([^/]+)/embed/?$' => 'index.php?attachment=$matches[1]&embed=true',
			$blog_page . '/([^/]+)/embed/?$' => 'index.php?acfe-dt=$matches[1]&embed=true',
			$blog_page . '/([^/]+)/trackback/?$' => 'index.php?acfe-dt=$matches[1]&tb=1',
			$blog_page . '/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post=$matches[1]&feed=$matches[2]',
			$blog_page . '/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post=$matches[1]&feed=$matches[2]',
			$blog_page . '/([^/]+)(?:/([0-9]+))?/?$' => 'index.php?acfe-dt=$matches[1]&page=$matches[2]',
			$blog_page . '/[^/]+/([^/]+)/?$' => 'index.php?attachment=$matches[1]',
			$blog_page . '/[^/]+/([^/]+)/trackback/?$' => 'index.php?attachment=$matches[1]&tb=1',
			$blog_page . '/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
			$blog_page . '/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
			$blog_page . '/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?attachment=$matches[1]&cpage=$matches[2]',
			$blog_page . '/[^/]+/([^/]+)/embed/?$' => 'index.php?attachment=$matches[1]&embed=true',
		);
		$rules = array_merge( $rules, $new_rules );
		$wp_rewrite->rules = $rules;
	}

	/**
	 *
	 * @param string   $permalink  The site's permalink structure .
	 * @param \WP_Post $post       The post in question .
	 * @param bool     $leavename  Whether to keep the post name .
	 * @return mixed
	 */
	public function post_link( $post_link, $post, $leavename ) {
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
	 *
	 * @param mixed $args
	 * @param mixed $post_type
	 * @return mixed
	 */

	public function add_blog_page_to_post_url( $args, $post_type ) {
		$blog_page = rwp_get_blog_page();
		if ( ! $blog_page ) {
			return $args;
		}

		$blog_page = get_post( $blog_page );

		if ( 'post' !== $post_type && ! ( $blog_page instanceof \WP_Post ) ) {
			return $args;
		}

		$blog_page = untrailingslashit( wp_make_link_relative( get_permalink( $blog_page ) ) );

		$args['rewrite'] = array(
			'slug' => $blog_page,
			'with_front' => true,
		);

		return $args;

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
		$blog_slug = $blog_page->post_name;
		$permalink_structure = get_option( 'permalink_structure', '/%postname%/' );

		$updated_permalink_structure = rwp_add_prefix( $permalink_structure, '/' . $blog_slug );

		if ( '/%postname%/' === $permalink_structure ) {
			update_option( 'permalink_structure', $updated_permalink_structure );
		}

		flush_rewrite_rules( true );

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

		if ( empty( $slug ) ) {
			$slug = data_get( $labels, 'names.slug', '' );
		}

		$defaults = array(
			'label'               => $singular,
			'labels'              => $labels['labels'],
			'capability_type'     => 'page',
			'show_in_rest'        => true,
			'rewrite'             => array(
				'slug'       => $slug,
				'with_front' => false,
				'pages'      => false,
			),
			'query_var'           => $slug,
			'rest_base'           => $slug,
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
