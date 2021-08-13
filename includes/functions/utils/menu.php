<?php
/** ============================================================================
 * menu
 *
 * @package   RWP\/includes/functions/utils/menu.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

use RWP\Components\Element;
use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\Html;
/**
 * Get menu by theme location or name of menu
 *
 * @var string    $menu
 *
 * @return WP_Term|false False if $menu param isn't supplied or term does not exist, menu object if successful.
 */

function rwp_get_menu( $menu = '' ) {

	// Get the nav menu based on the theme_location.
	$locations = get_nav_menu_locations();

	if ( ! empty( $menu ) && rwp_array_has( $menu, $locations ) ) {
		$menu = $locations[ $menu ];
	}

	// Get the nav menu based on the requested menu.
	$menu = wp_get_nav_menu_object( $menu );

	return $menu;
}

/**
 * Generate Nav Menu Args
 *
 * @param array $args
 * @return array
 */

function rwp_menu_args( $args = [] ) {

	$args = rwp_collection( $args );

	// Get the nav menu based on the requested menu.

	$menu = data_get( $args, 'menu' );
	if ( empty( $menu ) ) {
		$menu = data_get( $args, 'theme_location' );
	}
	// Get the requested menu, either a menu ID or a theme location
	$menu = rwp_get_menu( $menu );

	// Set up the default WordPress nav arguments
	$wp_defaults = rwp_collection(array(
		'menu'                 => '',
		'container'            => 'nav',
		'container_class'      => '',
		'container_id'         => '',
		'container_aria_label' => '',
		'menu_class'           => 'menu',
		'menu_id'              => '',
		'echo'                 => true,
		'fallback_cb'          => 'wp_page_menu',
		'before'               => '',
		'after'                => '',
		'link_before'          => '',
		'link_after'           => '',
		'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'item_spacing'         => 'preserve',
		'depth'                => 0,
		'walker'               => '',
		'theme_location'       => '',
	));

	// Get the custom ACF fields for the menu term
	$menu_fields = rwp_get_field( 'nav_options', $menu, array() );

	if ( ! empty( $menu_fields ) ) {
		$args = $args->merge( $menu_fields );
	}

	// Extract custom arguments from the incoming args array
	$custom_args = $args->diffKeys( $wp_defaults );

	if ( $custom_args->isNotEmpty() ) {
		// Remove the custom arguments from the incoming arguments
		$args->forget( $custom_args->keys()->all() );
	}

	// Merge the incoming arguments with the WordPress defaults (this is needed
	// at the end of the function)
	$defaults = $wp_defaults->replace( $args );

	// Remove empty arguments
	$args = rwp_collection_remove_empty_items( $defaults );

	// Merge the menu classes from the ACF fields with classes set in the $args variable
	$menu_class = rwp_parse_classes( data_get( $args, 'menu_class', '' ) );

	// Merge the container classes from the ACF fields with classes set in the
	// $args variable
	$container_class = rwp_parse_classes( data_get( $args, 'container_class', '' ) );

	// Set the container ID to the incoming arguments or set placeholder string
	$container_id = data_get( $args, 'container_id', '%1$s-wrapper' );

	// Set the container label to the incoming arguments or set it as tthe menu name
	$container_label = data_get( $args, 'container_aria_label', data_get( $menu, 'name' ) );

	// Build the arguments array for the Nav class
	$new_args = array(
		'direction' => data_get( $custom_args, 'direction', 'vertical' ),
		'wp_menu' => $menu,
		'child_type' => data_get( $custom_args, 'child_type' ),
		'list'    => array(
			'content' => array(
				'%3$s',
			),
			'atts' => array(
				'id'    => '%1$s',
				'class' => $menu_class,
			),
		),
		'atts'    => array(
			'id' => $container_id,
			'class' => $container_class,
			'aria-label' => $container_label,
		),
	);

	if ( $custom_args->isNotEmpty() ) {
		// Merge Nav args with extracted custom args
		$new_args = rwp_merge_args( $new_args, $custom_args->all() );
	}

	$nav_type = data_get( $custom_args, 'type', 'nav' );

	// Apply filters per nav ID to new arguments
	$new_args = apply_filters( "rwp_nav_args/nav/{$menu->term_id}", $new_args );

	// Initialize the Nav class
	$menu = rwp_nav( $new_args );

	if ( 'navbar' === $nav_type ) {
		$menu->set_tag( 'div' );
	} else {
		$theme = data_get( $custom_args, 'theme' );
		$bg = data_get( $custom_args, 'background_color' );
		if ( ! empty( $theme ) ) {
			$menu->add_class( 'nav-' . $theme );
		}

		if ( ! empty( $bg ) ) {
			$menu->add_class( 'bg-' . $bg );
		}
	}

	// Add the placeholder text as a class to the menu (filter option must be false)
	$menu->list->add_class( '%2$s', false );

	// Run all the build functionality before outputting it
	$menu->build();

	// Initialize $items_wrap variable as empty string
	$items_wrap = '';

	// Store the Html class in a variable
	$html = $menu->html;

	if ( 'navbar' === $nav_type ) {
		// Create a navbar if specified
		$html = rwp_navbar( $html, $custom_args, $menu );
	}

	// Apply html filters per nav ID to the Html class
	$html = apply_filters( "rwp_nav_args/html/{$menu->term_id}", $html, $menu, $custom_args );

	if ( false !== $args->get( 'items_wrap' ) ) {
		// If the container argument exists, then output everything
		if ( false !== $args->get( 'container' ) ) {
			$items_wrap = $html->__toString();
		} else { // else only output the unordered list
			$items_wrap = $html->unwrap()->__toString();
		}
	}

	/**
	 * Setup arguments in the defaults collection
	 *
	 * This is needed because wp_nav_menu needs all of the arguments to exist in
	 * the array, and we removed empty arguments from the $args variable
	 */
	$defaults->put( 'container_class', '' );
	$defaults->put( 'menu_class', '' );
	$defaults->put( 'container_id', '' );
	$defaults->put( 'container', '' );
	$defaults->put( 'items_wrap', $items_wrap );
	$defaults->put( 'walker', new \RWP\Integrations\Walkers\Nav() );
	$defaults->put( 'fallback_cb', '\RWP\Integrations\Walkers\Nav::fallback' );

	return $defaults->all();
}

/**
 *
 * @param Html $html
 * @param Collection $custom_args
 * @param mixed $menu
 *
 * @return Html
 */
function rwp_navbar( $html, $custom_args, $menu ) {

	rwp_log( $custom_args );

	if ( is_string( $menu ) ) {
		$menu = rwp_get_menu( $menu );
	}

	$theme           = data_get( $custom_args, 'theme' );
	$bg              = data_get( $custom_args, 'background_color' );
	$order           = data_get( $custom_args, 'navbar.order', array( 'navbar', 'toggle' ) );
	$in_grid_content = data_get( $custom_args, 'navbar.in_grid_content', false );
	$breakpoint      = data_get( $custom_args, 'navbar.breakpoint' );
	$in_grid         = data_get( $custom_args, 'navbar.in_grid', false );

	$navbar = rwp_html( '<nav id="%1$s-navbar" class="navbar"></div>' );

	$html->addClass( 'collapse navbar-collapse' );

	if ( ! empty( $breakpoint ) ) {
		$navbar->addClass( 'navbar-expand-' . $breakpoint );
	}

	if ( ! empty( $theme ) ) {
		$navbar->addClass( 'navbar-' . $theme );
	}

	if ( ! empty( $bg ) ) {
		$navbar->addClass( 'bg-' . $bg );
	}

	$navbar_content = new Element( '<div class="navbar-inner-wrapper"><div>' );

	$navbar_content->order = $order;

	$nav_toggle = rwp_button(array(
		'link'   => '#%1$s-wrapper',
		'toggle' => 'collapse',
		'atts'   => array(
			'class' => array(
				'navbar-toggler',
			),
		),
	));

	$nav_toggle = $nav_toggle->html();

	$navbar_content->set_content( $nav_toggle, 'toggle' );

	if ( in_array( 'brand', $order ) ) {
		$logo = rwp_get_logo(array(
			'class' => array(
				'navbar-brand',
			),
		));

		$navbar_content->set_content( $logo, 'brand' );
	}

	if ( in_array( 'search', $order ) ) {
		$search = rwp_html(get_search_form(array(
			'echo' => 0,
		)))->addClass( 'd-flex' )->saveHTML();

		$navbar_content->set_content( $search, 'search' );
	}

	$html->filter( '.menu' )->removeClass( 'nav' )->addClass( 'navbar-nav' );

	// $test = $html->saveHTML();

	if ( $in_grid_content ) {
		$navbar_content->add_class( 'container' );
	} else {
		$navbar_content->add_class( 'container-fluid' );
	}

	$navbar_wrapper = rwp_html( '<div class="navbar-wrapper"><div>' );

	if ( $in_grid ) {
		$navbar_wrapper->addClass( 'container' );
	}

	$navbar_content->set_content( $html, 'navbar' );

	$navbar_content = $navbar_content->html();

	$navbar->setInnerHtml( $navbar_content );

	$navbar_wrapper->setInnerHtml( $navbar );

	return $navbar_wrapper;
}
