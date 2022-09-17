<?php

/** ============================================================================
 * Nav_Menus
 *
 * Updates/adds various functionality to different types of nav menus
 *
 * @package   RWP\Integrations
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Base\Singleton;

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

		\add_filter('wp_nav_menu_args', function ( array $args ) {

			if ( rwp_get_option( 'modules.bootstrap.nav.navwalker', false ) ) {
				$args['walker'] = new \RWP\Integrations\Walkers\Nav( $args );

				$args['fallback_cb'] = '\RWP\Integrations\Walkers\Nav::fallback';
			}
			return $args;
		}, 20);

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

	public function nav_menu_submenu_css_class( $classes, $args, $depth ) { //phpcs:ignore
		$classes[] = 'level-' . ( $depth + 1 ) . '-menu';

		return $classes;
	}

	public static function is_active( $item ) {
		global $post;
		$current = data_get( $_SERVER, 'REQUEST_URI' );

		$item_url = data_get( $item, 'url', '' );
		$item_url = wp_parse_url( $item_url, PHP_URL_PATH );
		$post_id = data_get( $item, 'object_id', '' );
		if ( ! empty( $post_id ) ) {
			$post_id = intval( $post_id );
		}
		$is_current = data_get( $item, 'current', false );
		$is_current_parent = data_get( $item, 'current_item_parent', false );
		$is_current_ancestor = data_get( $item, 'current_item_ancestor', false );

		$is_active = false;

		$blog_page = rwp_get_blog_page();

		if ( ! is_search() && ! is_404() ) {
			if ( $is_current ) {
				$is_active = true;
			} elseif ( $is_current_parent ) {
				$is_active = true;
			} elseif ( $is_current_ancestor ) {
				$is_active = true;
			} elseif ( $post instanceof \WP_Post && 'post' === $post->post_type && $post_id === $blog_page ) {
				$is_active = true;
			} elseif ( rwp_get_home_page() === $post_id && is_front_page() ) {
				$is_active = true;
			} elseif ( '/' !== $item_url && rwp_str_has( $current, $item_url ) ) {
				$is_active = true;
			}
		}

		return $is_active;
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
	 */

	public function nav_menu_link_attributes( $atts, $item ) {

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

		$is_active = self::is_active( $item );

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

	public function nav_menu_item_class( $classes, $item, $args, $depth ) { // phpcs:ignore
		if ( 'nav_menu_item' === $item->post_type ) {

			$item_url = data_get( $item, 'url', '' );
			$item_url = wp_parse_url( $item_url, PHP_URL_PATH );
			$title = data_get( $item, 'title', $item->post_title );
			$slug = sanitize_title( $title );
			$is_parent = false;
			if ( ! empty( preg_grep( '/.*has-children.*/i', $classes ) ) ) {
				$is_parent = true;
			}

			$is_active = self::is_active( $item );

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

			$classes[] = 'menu-' . $slug;

			$classes[] = 'nav-item';

			$classes[] = 'level-' . ( $depth ) . '-item';
		}

		$classes = rwp_parse_classes( $classes );

		return $classes;
	}
}