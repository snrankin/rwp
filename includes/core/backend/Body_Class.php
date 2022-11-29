<?php

/** ============================================================================
 * Add custom css class to admin <body>
 *
 * @package   RWP\Backend
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Backend;

use RWP\Base\Singleton;

class Body_Class extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		\add_filter( 'admin_body_class', array( $this, 'add_plugin_class' ), 10, 3 );
		\add_filter( 'qm/output/menu_class', array( $this, 'add_plugin_class' ) );
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param string $classes The array with all the classes of the page.
	 * @since 0.9.0
	 * @return string
	 */
	public static function add_plugin_class( $classes ) {

		$classes = rwp_parse_classes( $classes );

		if ( get_post_type() === 'page' ) {
			$hierarchy = rwp_hierarchy()->getTemplates();

			if ( $hierarchy ) {
				$hierarchy = rwp_collection( $hierarchy )->transform(function( $path ) {
					return basename( $path, '.php' );
				})->all();
				$classes = rwp_parse_classes( $classes, $hierarchy );
			}
		}

		if ( is_singular() && ! is_front_page() ) {

			/**
			 * @var \WP_Post $post
			 */
			global $post;

			$type = $post->post_type;
			$id   = $post->ID;
			$slug = $post->post_name;

			$classes[] = $type . '-' . $id;
			$classes[] = $slug;

			$home = rwp_get_home_page();

			$parents = rwp_post_ancestors( $post );

			$parents = $parents->where( 'id', '!==', $home )->where( 'id', '!==', $id );

			if ( $parents->isNotEmpty() ) {
				foreach ( $parents->all() as $parent ) {
					$classes[] = 'parent-' . $parent['id'];
				}
			}

			$taxonomies = get_taxonomies( array( 'public' => true ) );
			foreach ( (array) $taxonomies as $taxonomy ) {
				if ( is_object_in_taxonomy( $type, $taxonomy ) ) {
					foreach ( (array) get_the_terms( $id, $taxonomy ) as $term ) {
						if ( empty( $term->slug ) ) {
							continue;
						}

						$term_class = sanitize_html_class( $term->slug, $term->term_id );
						if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
							$term_class = $term->term_id;
						}

						// 'post_tag' uses the 'tag' prefix for backward compatibility.
						if ( 'post_tag' === $taxonomy ) {
							$taxonomy = rwp_str( 'remove', 'post_', $taxonomy );
						} elseif ( rwp_str_has( $taxonomy, [ 'rwp_', 'rwp-' ] ) ) {
							$taxonomy = rwp_str( 'remove', [ 'rwp_', 'rwp-' ], $taxonomy );
						}

						$classes[] = sanitize_html_class( $taxonomy . '-' . $term_class, $taxonomy . '-' . $term->term_id );
					}
				}
			}
		}

		$classes = rwp_array_remove( $classes, 'page-id-' . get_option( 'page_on_front' ) );

		$classes = rwp_parse_classes( $classes, rwp()->get_slug() );

		$classes = rwp_output_classes( $classes );

		// Add a leading space and a trailing space.
		$classes .= ' ' . $classes . ' ';

		return $classes;
	}
}