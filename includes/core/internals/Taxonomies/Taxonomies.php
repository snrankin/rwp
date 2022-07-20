<?php

/**
 * ============================================================================
 * Taxonomies
 *
 * @package   RWP\Internals
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ==========================================================================
 */

namespace RWP\Internals\Taxonomies;

use RWP\Base\Singleton;
use RWP\Helpers\Collection;

/**
 * Post Types and Taxonomies
 */
class Taxonomies extends Singleton {


	/**
	 * @var Collection $taxonomies The registered taxonomies
	 */
	public static $taxonomies;

	/**
	 * Add a new tax
	 *
	 * @param  mixed  $singular
	 * @param  string $plural
	 * @param  string $menu
	 * @param  array  $args
	 * @return void
	 */

	public static function new_tax( $singular, $post_type, $plural = '', $menu = '', $slug = '', $args = array() ) {

		$singular = rwp_change_case( rwp_singulizer( $singular ), 'title' );

		$plural = empty( $plural ) ? rwp_change_case( rwp_pluralizer( $singular ), 'title' ) : $plural;

		$labels = self::labels( $singular, $plural, $menu, $slug );

		$defaults = array(
			'label'        => $singular,
			'labels'       => $labels['labels'],
			'show_in_rest' => true,
			'hierarchical' => true,
		);

		$args = wp_parse_args( $args, $defaults );

		$type = rwp()->prefix( $singular );

		$names = $labels['names'];

		$args = apply_filters( "{$type}_tax_args", $args );

		register_extended_taxonomy( $type, $post_type, $args, $names );
		flush_rewrite_rules();
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
				'name'                       => $title_plural,
				'singular_name'              => $title_singular,
				'menu_name'                  => $menu,
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
			),
		);
	}

	public static function registered_taxonomies() {
		return self::$taxonomies;
	}
}
