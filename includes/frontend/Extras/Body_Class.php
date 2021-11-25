<?php
/** ============================================================================
 * Add custom css class to <body>
 *
 * @package   RWP\Frontend\Extras
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Frontend\Extras;

use RWP\Engine\Abstracts\Singleton;

class Body_Class extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		\add_filter( 'body_class', array( $this, 'add_plugin_class' ), 10, 3 );
		\add_filter( 'qm/output/menu_class', array( $this, 'add_plugin_class' ) );
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param array $classes The array with all the classes of the page.
	 * @since 1.0.0
	 * @return array
	 */
	public static function add_plugin_class( array $classes ) {

		if ( is_plugin_active( 'elementor/elementor.php' ) && rwp_get_option( 'modules.bootstrap.elementor', false ) ) {
			$classes[] = 'rwp-elementor';
		}

		if ( ! is_admin() ) {
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

				// $parent_id = data_get( $parent, 'id', 0 );

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
							} else if ( rwp_str_has( $taxonomy, [ 'rwp_', 'rwp-' ] ) ) {
								$taxonomy = rwp_str( 'remove', [ 'rwp_', 'rwp-' ], $taxonomy );
							}

							$classes[] = sanitize_html_class( $taxonomy . '-' . $term_class, $taxonomy . '-' . $term->term_id );
						}
					}
				}
			}
		}

		$classes = rwp_array_remove( $classes, 'page-id-' . get_option( 'page_on_front' ) );

		$classes = rwp_parse_classes( $classes, rwp()->get_slug() );

		return $classes;
	}
}
