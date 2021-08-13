<?php
/** ============================================================================
 * bootstrap
 *
 * @package   RWP\/includes/internals/Modules/bootstrap.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Modules\Bootstrap;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function bootstrap_assets() {
	if ( rwp_get_option( 'modules.bootstrap.styles', false ) ) {
		rwp()->register_styles( 'bootstrap' );
		rwp()->enqueue_styles( 'bootstrap' );
	}
	if ( rwp_get_option( 'modules.bootstrap.scripts', false ) ) {
		rwp()->register_scripts( 'bootstrap' );
		rwp()->enqueue_scripts( 'bootstrap' );
	}
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\bootstrap_assets' );
/**
 * @param string $form
 * @return string
 */
function bootstrap_search( $form ) {

	$form = rwp_html( $form );

	$label = '<label class="visually-hidden" for="s">' . $form->filter( 'label > span' )->text() . '</label>';

	$input = $form->filter( 'input.search-field' )->addClass( 'form-control' )->saveHTML();

	$btn = $form->filter( 'input.search-submit' )->saveHTML();

	$btn = rwp_input_to_button( $btn );

	$btn = $btn->html();

	$form->makeEmpty();

	$form->append( $label )->append( $input )->append( $btn );

	return $form->saveHTML();
}

if ( rwp_get_option( 'modules.bootstrap.search', false ) ) {
	\add_filter( 'get_search_form', __NAMESPACE__ . '\\bootstrap_search', 10, 1 );
}

if ( rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
	\add_filter( 'wp_nav_menu_args', 'rwp_menu_args', 5 );
}

/**
 * Filters the CSS classes applied to a menu item's list item element.
 *
 * @since 3.0.0
 * @since 4.1.0 The `$depth` parameter was added.
 *
 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
 * @param \WP_Post  $item    The current menu item.
 * @param \stdClass $args    An object of wp_nav_menu() arguments.
 * @param int      $depth   Depth of menu item. Used for padding.
 */

function nav_menu_item_class( $classes, $item, $args, $depth ) {
	if ( 'nav_menu_item' === $item->post_type ) {
		$_request_uri = data_get( $_SERVER, 'REQUEST_URI' );
		$ancestors = rwp_collection();
		if ( ! empty( $_request_uri ) ) {
			if ( '/' === $_request_uri ) {
				$_current_page = rwp_home_page();
			} else {
				$_current_page = url_to_postid( $_request_uri );
			}

			if ( ! empty( $_current_page ) ) {
				$ancestors = rwp_ancestors( $_current_page );
			}
		}
		$title = data_get( $item, 'title', $item->post_title );
		$slug = sanitize_title( $title );
		$is_current = data_get( $item, 'current', false );
		$is_current_parent = data_get( $item, 'current_item_parent', false );
		$is_current_ancestor = data_get( $item, 'current_item_ancestor', false );
		$is_parent = data_get( $item, 'is_subitem', false );

		$is_active = false;

		if ( $is_current ) {
			$is_active = true;
		}
		if ( $is_current_parent ) {
			$is_active = true;
		}

		if ( $is_current_ancestor ) {
			$is_active = true;
		}

		if ( ! empty( $ancestors ) && rwp_is_collection( $ancestors ) ) {
			$ancestors = $ancestors->filter(function ( $ancestor ) use ( $slug ) {
				$object = data_get( $ancestor, 'slug' );
				return $slug === $object;
			});
			if ( $ancestors->isNotEmpty() ) {

				$is_active = true;
			}
		}

		if ( is_search() || is_404() ) {
			$is_active = false;
		}

		if ( $is_active ) {
			$classes[] = 'active';
		}

		// Remove most core classes
		$classes = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', '', $classes );
		$classes = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );

		// Re-add core `menu-item` class
		$classes[] = 'menu-item';

		// Re-add core `menu-item-has-children` class on parent elements
		if ( $is_parent ) {
			$classes[] = 'has-children';
		}

		// Add `menu-<slug>` class
		$classes[] = 'menu-' . $slug;

		$classes[] = 'nav-item';

		$classes = array_unique( $classes );
		$classes = array_map( 'trim', $classes );

		return array_filter( $classes );
	}

}
if ( rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
	\add_filter( 'nav_menu_css_class', __NAMESPACE__ . '\\nav_menu_item_class', 10, 4 );
}

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * @since 3.6.0
 * @since 4.1.0 The `$depth` parameter was added.
 *
 * @param array $atts {
 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *
 *     @type string $title        Title attribute.
 *     @type string $target       Target attribute.
 *     @type string $rel          The rel attribute.
 *     @type string $href         The href attribute.
 *     @type string $aria-current The aria-current attribute.
 * }
 * @param \WP_Post  $item  The current menu item.
 * @param \stdClass $args  An object of wp_nav_menu() arguments.
 * @param int       $depth Depth of menu item. Used for padding.
 */

function nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	$atts['class'] = 'nav-link';

	return $atts;
}
if ( rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
	\add_filter( 'nav_menu_link_attributes', __NAMESPACE__ . '\\nav_menu_link_attributes', 10, 4 );
}

/**
 * Filters the CSS class(es) applied to a menu list element.
 *
 * @since 4.8.0
 *
 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
 * @param \stdClass $args    An object of `wp_nav_menu()` arguments.
 * @param int      $depth   Depth of menu item. Used for padding.
 */

function nav_menu_submenu_css_class( $classes, $args, $depth ) {
	$classes[] = 'sub-menu';
	$classes[] = 'nav';
	$classes[] = 'level-' . ( $depth ) . '-menu';

	return $classes;
}
if ( rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
	\add_filter( 'nav_menu_submenu_css_class', __NAMESPACE__ . '\\nav_menu_submenu_css_class', 10, 3 );
}

function wp_nav_menu_args( $args ) {
    $classes = data_get( $args, 'menu_class', '' );
	$classes .= ' nav';

	$args['menu_class'] = $classes;

    return $args;
}
if ( rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
	add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\\wp_nav_menu_args', 5 );
}
