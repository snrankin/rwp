<?php

/**
 * ============================================================================
 * Taxonomies
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
class Taxonomies extends Singleton {


	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		$cpts = rwp_get_option( 'cpt_options.cpts', array() );
		$cpts = rwp_collection( $cpts );

		$cpts = $cpts->mapWithKeys(
			function ( $item, $key ) {
				return [ $item['value'] => $item['label'] ];
			}
		);

		if ( $cpts->has( 'team_member' ) ) {
			\add_action( 'init', array( $this, 'init_team_member_tax' ) );
		}
	}

	/**
	 * Add a new tax
	 *
	 * @param  mixed  $singular
	 * @param  string $plural
	 * @param  string $menu
	 * @param  array  $args
	 * @return void
	 */

	public static function new_tax( $singular, $post_type, $plural = '', $menu = '', $args = array() ) {

		$singular = rwp_change_case( rwp_singulizer( $singular ), 'title' );

		$plural = empty( $plural ) ? rwp_change_case( rwp_pluralizer( $singular ), 'title' ) : $plural;

		$defaults = array(
			'label'               => $singular,
			'labels'              => self::tax_labels( $singular, $plural, $menu ),
			'show_in_rest'        => true,
			'hierarchical'        => true,
		);

		$args = wp_parse_args( $args, $defaults );

		$type = rwp()->prefix( $singular, '_', 'snake' );

		$slug = rwp_change_case( $singular );

		$names  = array(
			'plural' => $plural,
			'singular' => $singular,
			'slug' => $slug,

		);

		$args = apply_filters( "{$type}_tax_args", $args );

		if ( ! empty( $type ) ) {
			if ( strlen( $type ) < 20 ) {
				\register_extended_taxonomy( $type, $post_type, $args, $names );
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
	public static function tax_labels( $singular, $plural = '', $menu = '' ) {

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
			'name'                       => $title_plural,
			'singular_name'              => $title_singular,
			'search_items'               => wp_sprintf( 'Search %s', $title_plural ),
			'popular_items'              => wp_sprintf( 'Popular %s', $title_plural ),
			'all_items'                  => wp_sprintf( 'All %s', $title_plural ),
			'parent_item'                => wp_sprintf( 'Parent %s', $title_singular ),
			'parent_item_colon'          => wp_sprintf( 'Parent %s:', $title_singular ),
			'edit_item'                  => wp_sprintf( 'Edit %s', $title_singular ),
			'view_item'                  => wp_sprintf( 'View %s', $title_singular ),
			'update_item'                => wp_sprintf( 'Update %s', $title_singular ),
			'add_new_item'               => wp_sprintf( 'Add New %s', $title_singular ),
			'new_item_name'              => wp_sprintf( 'New %s Name', $title_singular ),
			'separate_items_with_commas' => wp_sprintf( 'Separate %s with commas', $lower_plural ),
			'add_or_remove_items'        => wp_sprintf( 'Add or remove %s', $lower_plural ),
			'choose_from_most_used'      => wp_sprintf( 'Choose from the most used %s', $lower_plural ),
			'not_found'                  => wp_sprintf( 'No %s found.', $lower_plural ),
			'no_terms'                   => wp_sprintf( 'No %s', $lower_plural ),
			'filter_by_item'             => wp_sprintf( 'Filter by %s', $lower_singular ),
			'items_list_navigation'      => wp_sprintf( '%s list navigation', $title_plural ),
			'items_list'                 => wp_sprintf( '%s list', $title_plural ),
			'back_to_items'              => wp_sprintf( '&larr; Go to %s', $title_plural ),
			'item_link'                  => wp_sprintf( '%s Link', $title_singular ),
			'item_link_description'      => wp_sprintf( 'A link to a %s.', $lower_singular ),
		);
	}

	/**
	 * Init Team Member functionality
	 *
	 * @return void
	 */

	public function init_team_member_tax() {
		self::new_tax( 'Team Category', 'rwp_team_member' );
	}

}
