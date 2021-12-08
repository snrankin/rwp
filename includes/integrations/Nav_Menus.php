<?php
/** ============================================================================
 * Nav_Menus
 *
 * Updates/adds various functionality to different types of nav menus
 *
 * @package   RWP\Integrations\Nav_Menus
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;

class Nav_Menus extends Singleton {

	/**
	 * @var string The current page
	 */

	public $current = '';

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
			return;
		}

			\add_filter( 'nav_menu_css_class', array( $this, 'nav_menu_item_class' ), 10, 4 );
			\add_filter( 'nav_menu_link_attributes', array( $this, 'nav_menu_link_attributes' ), 10, 4 );
			\add_filter( 'nav_menu_submenu_css_class', array( $this, 'nav_menu_submenu_css_class' ), 10, 3 );
			\add_filter( 'wp_nav_menu_args', 'rwp_menu_args', 5 );

			\add_filter( 'wp_nav_menu_args', function( array $args ) {

				if ( rwp_get_option( 'modules.bootstrap.nav.navwalker', false ) ) {
					$args['walker'] = new \RWP\Integrations\Walkers\Nav( $args );

					$args['fallback_cb'] = '\RWP\Integrations\Walkers\Nav::fallback';

				}
				return $args;
			}, 20 );

		$this->current = data_get( $_SERVER, 'REQUEST_URI' );
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

	public function nav_menu_submenu_css_class( $classes, $args, $depth ) {
		$classes[] = 'level-' . ( $depth + 1 ) . '-menu';

		return $classes;
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

	public function nav_menu_link_attributes( $atts, $item, $args, $depth ) {

		global $post;

		$classes = data_get( $atts, 'class', '' );
		$classes = rwp_parse_classes( $classes );
		$item_url = data_get( $item, 'url', '' );
		$href = $item_url;
		$item_url = wp_parse_url( $item_url, PHP_URL_PATH );
		$post_id = data_get( $item, 'object_id', '' );
		if ( ! empty( $post_id ) ) {
			$post_id = intval( $post_id );
		}
		$is_current = data_get( $item, 'current', false );
		$is_current_parent = data_get( $item, 'current_item_parent', false );
		$is_current_ancestor = data_get( $item, 'current_item_ancestor', false );

		$is_active = rwp_str_has( $this->current, $item_url );

		$blog_page = rwp_get_blog_page();

		if ( $post instanceof \WP_Post && 'post' === $post->post_type && $post_id === $blog_page ) {
			$is_active = true;
		}

		if ( $is_current ) {
			$is_active = true;
		}
		if ( $is_current_parent ) {
			$is_active = true;
		}

		if ( $is_current_ancestor ) {
			$is_active = true;
		}

		if ( is_search() || is_404() ) {
			$is_active = false;
		}

		if ( $is_active ) {
			$classes[] = 'active';
		}

		$classes[] = 'nav-link';

		$atts['class'] = rwp_output_classes( $classes );

		$atts = rwp_format_html_atts( $atts, 'array', true );

		$atts['href'] = $href;

		return $atts;
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

	public function nav_menu_item_class( $classes, $item, $args, $depth ) {
		if ( 'nav_menu_item' === $item->post_type ) {

			$item_url = data_get( $item, 'url', '' );
			$item_url = wp_parse_url( $item_url, PHP_URL_PATH );
			$title = data_get( $item, 'title', $item->post_title );
			$slug = sanitize_title( $title );
			$is_current = data_get( $item, 'current', false );
			$is_current_parent = data_get( $item, 'current_item_parent', false );
			$is_current_ancestor = data_get( $item, 'current_item_ancestor', false );
			$is_parent = false;
			if ( ! empty( preg_grep( '/.*has-children.*/i', $classes ) ) ) {
				$is_parent = true;
			}

			$is_active = rwp_str_has( $this->current, $item_url );

			if ( $is_current ) {
				$is_active = true;
			}
			if ( $is_current_parent ) {
				$is_active = true;
			}

			if ( $is_current_ancestor ) {
				$is_active = true;
			}

			if ( is_search() || is_404() ) {
				$is_active = false;
			}

			if ( $is_active ) {
				$classes[] = 'active-item';
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

			$classes[] = 'level-' . ( $depth ) . '-item';
		}

		$classes = rwp_parse_classes( $classes );

		return $classes;

	}
}
