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
use RWP\Components\Collection;
use RWP\Components\Html;
/**
 * Get menu by theme location or name of menu
 *
 * @var string|\WP_Term    $menu
 *
 * @return WP_Term|false False if $menu param isn't supplied or term does not exist, menu object if successful.
 */

function rwp_get_menu( $menu = '' ) {
    if ( ! ( $menu instanceof \WP_Term ) ) {
		$locations = get_nav_menu_locations();

		if ( ! empty( $locations ) ) {
			if ( ! empty( $menu ) && rwp_array_has( $menu, $locations ) ) {
				$menu = $locations[ $menu ];
			}
		}

		$menu = wp_get_nav_menu_object( $menu );
	}

	return $menu;
}

/**
 * Generate Nav Menu Args
 *
 * @param  array $args
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

	$menu_id = data_get( $menu, 'term_id' );

    // Set up the default WordPress nav arguments
    $wp_defaults = rwp_collection(
        array(
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
			'item_options'         => rwp_collection(), // Custom argument but needed in Walker
        )
    );

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

	$menu_class[] = 'nav';

    // Merge the container classes from the ACF fields with classes set in the
    // $args variable
    $container_class = rwp_parse_classes( data_get( $args, 'container_class', '' ) );

	if ( false !== $menu ) {
		$container_class[] = 'menu-' . $menu->slug;
	}

    // Set the container ID to the incoming arguments or set placeholder string
    $container_id = data_get( $args, 'container_id', '%1$s-wrapper' );

    // Set the container label to the incoming arguments or set it as tthe menu name
    $container_label = data_get( $args, 'container_aria_label', data_get( $menu, 'name' ) );

	$direction = data_get( $custom_args, 'direction', 'vertical' );
	$type = data_get( $custom_args, 'type', 'nav' );

    // Build the arguments array for the Nav class
    $new_args = array(
		'direction'  => $direction,
		'type'       => $type,
		'toggle_type' => data_get( $custom_args, 'toggle_type' ),
		'list'       => array(
			'content' => array(
				'%3$s',
			),
			'atts' => array(
				'id'    => '%1$s',
				'class' => $menu_class,
			),
		),
		'atts'    => array(
			'id'         => $container_id,
			'class'      => $container_class,
			'aria-label' => $container_label,
		),
    );

    if ( $custom_args->isNotEmpty() ) {
        // Merge Nav args with extracted custom args
        $new_args = rwp_merge_args( $new_args, $custom_args->all() );
    }

    $nav_type = data_get( $custom_args, 'type', 'nav' );

    // Apply filters per nav ID to new arguments
    $new_args = apply_filters( "rwp_nav_args/nav/{$menu_id}", $new_args );

    // Initialize the Nav class
    $nav = rwp_nav( $new_args );

    if ( 'navbar' !== $nav_type ) {
        $theme = data_get( $custom_args, 'theme' );
        if ( ! empty( $theme ) ) {
            $nav->add_class( 'nav-' . $theme );
        }

		rwp_add_acf_color( $nav, 'background', $custom_args, $menu );
    }

    // Add the placeholder text as a class to the menu (filter option must be false)
    $nav->list->add_class( '%2$s', false );

    // Run all the build functionality before outputting it
    $nav->build();

    // Initialize $items_wrap variable as empty string
    $items_wrap = '';

    // Store the Html class in a variable
    $html = $nav->html;

    if ( 'navbar' === $nav_type ) {
        // Create a navbar if specified
        $html = rwp_navbar( $nav, $custom_args, $menu );
    }

    // Apply html filters per nav ID to the Html class
    $html = apply_filters( "rwp_nav_args/html/{$menu_id}", $html, $menu, $custom_args );

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

	if ( rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
		$walker = new \RWP\Integrations\Walkers\Nav( $defaults->all() );
		$defaults->put( 'walker', $walker );
		$defaults->put( 'fallback_cb', '\RWP\Integrations\Walkers\Nav::fallback' );

	}

    return $defaults->all();
}

/**
 *
 * @param Element    $nav
 * @param Collection $custom_args
 * @param mixed      $menu
 *
 * @return Html
 */
function rwp_navbar( $nav, $custom_args, $menu ) {

    if ( is_string( $menu ) ) {
        $menu = rwp_get_menu( $menu );
    }

    $theme           = data_get( $custom_args, 'theme' );
    $order           = data_get( $custom_args, 'navbar.order', rwp_collection( array( 'navbar', 'toggle' ) ) );
    $in_grid_content = data_get( $custom_args, 'navbar.in_grid_content', false );
    $breakpoint      = data_get( $custom_args, 'navbar.breakpoint' );
    $in_grid         = data_get( $custom_args, 'navbar.in_grid', false );
	$item_styles          = array();
	$item_acf_styles     = data_get( $custom_args, 'item_options.styles', rwp_collection() );

	$menu_slug = '';

	if ( false !== $menu ) {
		$menu_slug = $menu->slug;
	}

	foreach ( $item_acf_styles->keys()->all() as $key ) {
		$type = rwp_remove_suffix( $key, '_color' );
		rwp_get_acf_color_style( $item_styles, $type, $item_acf_styles );
	}

    $navbar = rwp_element( array(
		'tag' => 'nav',
		'atts' => array(
			'id' => '%1$s-navbar',
			'class' => array(
				'navbar',
			),
		),
	) );

	$navbar->add_class( 'navbar-' . $menu_slug );

    $nav->add_class( array( 'collapse', 'navbar-collapse' ) );
	$nav->set_tag( 'div' );

    if ( ! empty( $breakpoint ) ) {
        $navbar->add_class( 'navbar-expand-' . $breakpoint );
    }

    if ( ! empty( $theme ) ) {
        $navbar->add_class( 'navbar-' . $theme );
    }

	rwp_add_acf_color( $navbar, 'background', $custom_args, $menu );

    $navbar_content = rwp_element( array(
		'tag' => 'div',
		'atts' => array(
			'class' => array(
				'navbar-wrapper-inner',
			),
		),
	) );

    $navbar_content->order = $order->all();

	$toggle_icon_opened = data_get( $custom_args, 'navbar.toggle_icon.icon_opened.icon' );
	$toggle_icon_opened = rwp_get_icon_from_acf( $toggle_icon_opened );
	$toggle_icon_closed = data_get( $custom_args, 'navbar.toggle_icon.icon_closed.icon' );
	$toggle_icon_closed = rwp_get_icon_from_acf( $toggle_icon_closed );

    $nav_toggle = rwp_button(
        array(
			'link'   => '#%1$s-wrapper',
			'toggle' => 'collapse',
			'icon_closed' => $toggle_icon_closed,
			'icon_opened' => $toggle_icon_opened,
			'atts'   => array(
				'class' => array(
					'navbar-toggler',
				),
			),
        )
    );

    $navbar_content->set_content( $nav_toggle, 'toggle' );

    if ( false !== $order->search( 'brand' ) ) {
		$logo_defaults = array(
			'class' => array(
				'navbar-brand',
			),
		);

		$logo_args = data_get( $custom_args, 'navbar.brand.atts', array() );
		$logo_args = rwp_merge_args( $logo_defaults, $logo_args );
        $logo = rwp_get_logo( $logo_args );
        $navbar_content->set_content( $logo, 'brand' );
    }

    if ( false !== $order->search( 'search' ) ) {
		$search_args = data_get( $custom_args, 'navbar.search' );
        $search = rwp_search_form( '', $search_args );
        $navbar_content->set_content( $search, 'search' );
    }

	if ( false !== $order->search( 'text' ) ) {
		$text_args = data_get( $custom_args, 'navbar.text' );
		$text_content = data_get( $text_args, 'content' );
		$text_content = rwp_filtered_content( $text_content );
        $navbar_content->set_content( $text_content, 'text' );
    }

	$nav->list->remove_class( 'nav' );
	$nav->list->add_class( 'navbar-nav' );

    if ( $in_grid_content ) {
        $navbar_content->add_class( 'container' );
    } else {
        $navbar_content->add_class( 'container-fluid' );
    }

    $navbar_wrapper = rwp_element( array(
		'tag' => 'div',
		'atts' => array(
			'class' => array(
				'navbar-wrapper',
			),
		),
	) );

	if ( ! empty( $item_styles ) ) {
		$styles = rwp_output_styles( $item_styles );

		$navbar_wrapper->set_content( '<style> .navbar-' . $menu_slug . ' .nav-item::before {' . $styles . ' }</style>' );

	}

    if ( $in_grid ) {
        $navbar_wrapper->add_class( 'container' );
    }

    $navbar_content->set_content( $nav, 'navbar' );

    $navbar->set_content( $navbar_content );

    $navbar_wrapper->set_content( $navbar );

    return $navbar_wrapper;
}
