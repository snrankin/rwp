<?php
/** ============================================================================
 * Nav
 *
 * @package   RWP\/includes/integrations/Walkers/Nav.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\Walkers;

use RWP\Vendor\Illuminate\Support\Str;
use RWP\Vendor\Bootstrap_Navwalker;
use RWP\Components\NavItem;
use RWP\Components\Nav as HtmlNav;
use RWP\Vendor\Illuminate\Support\Collection;
use stdClass;

/**
 * WP_Bootstrap_Navwalker class.
 *
 * @inheritdoc
 */

class Nav extends Bootstrap_Navwalker {

	/**
	 * @var bool $cpt is current post a custom post type
	 */

	private $cpt;

	/**
	 * @var string|false $archive Stores the archive page for current URL
	 */
	private $archive;

	/**
	 * @var string[] $icon_patterns An array of regex patterns to search for icons
	 */
	public $icon_patterns = array(
		'glyphicon',
		'fa(s|r|l|b)?',
		'bs',
		'glyphicon',
	);

	/**
	 * @var HtmlNav The current sub-menu object
	 */
	public $sub_menu;

	/**
	 * @var string The current sub-menu id
	 */
	public $sub_menu_id;

	/**
	 * @var \WP_Term The current menu object
	 */
	public $menu;

	/**
	 * @var NavItem The current nav item object
	 */
	public $nav_item;

	/**
	 * @var \WP_Post The current nav item post object
	 */
	public $item;

	/**
	 * @var bool|\WP_Post  The current nav item parent object
	 */
	public $parent = false;

	/**
	 * @var array Current Page info
	 */
	public $current_page = array();

	/**
	 * @var Collection The collection of ancestors
	 */
	public $ancestors;

	public function __construct() {
		$cpt           = get_post_type();
		$this->cpt     = in_array( $cpt, get_post_types( array( '_builtin' => false ) ) );
		$this->archive = get_post_type_archive_link( $cpt );
		$_request_uri = data_get( $_SERVER, 'REQUEST_URI' );
		$this->ancestors = rwp_collection();
		if ( ! empty( $_request_uri ) ) {
			if ( '/' === $_request_uri ) {
				$_current_page = rwp_home_page();
			} else {
				$_current_page = url_to_postid( $_request_uri );
			}

			if ( empty( $this->current_page ) ) {
				$this->current_page = rwp_object_type( $_current_page );
			}

			if ( ! empty( $_current_page ) ) {
				$this->ancestors = rwp_ancestors( $_current_page );
			}

			rwp_log( $this );
		}

	}

	/**
	 * Check if current is active based on the classes
	 *
	 * @param string|string[] $classes
	 *
	 * @return bool
	 */

	public function checkCurrent( $classes ) {
		if ( is_array( $classes ) ) {
			if ( ! empty( preg_grep( '/(current[-_])|active/', $classes ) ) ) {
				return true;
			}
			return false;
		} elseif ( is_string( $classes ) ) {
			if ( ! empty( preg_match( '/(current[-_])|active/', $classes ) ) ) {
				return true;
			}
			return false;
		}
		return false;
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output  Used to append additional content (passed by reference).
	 * @param int      $depth   Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		if ( $depth ) {
			$indent = str_repeat( $t, $depth );
		} else {
			$indent = '';
		}

		$classes = apply_filters( 'nav_menu_submenu_css_class', array( 'sub-menu' ), $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$id = $this->sub_menu_id;

		if ( empty( $id ) ) {
			$id = 'menu-item-' . $this->item->ID;
			$id .= '-sub-menu';
		}

		$output .= $n . $indent;
		$sub_menu_args = array(
			'depth'      => $depth + 1,
			'atts' => array(
				'id'    => $id,
				'class' => $classes,
			),
		);

		$sub_menu = new HtmlNav( $sub_menu_args );
		$this->sub_menu = $sub_menu;
		$nav_output = $sub_menu->html();
		$nav_output = Str::replaceLast( '</nav>', '', $nav_output );
		$nav_output = Str::replaceLast( '</ul>', '', $nav_output );
		$output .= $nav_output;
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string    $output Used to append additional content (passed by reference).
	 * @param \WP_Post  $item   Menu item data object.
	 * @param int       $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int       $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		if ( empty( $this->menu ) && wp_get_nav_menu_object( $args->menu ) ) {
			$this->menu = wp_get_nav_menu_object( $args->menu );
		}

		$this->item = $item;

		$menu = $this->menu;

		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$output .= $n . $indent;

		/**
		 * @var string[] $classes
		 */
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Initialize some holder variables to store specially handled item
		 * wrappers and icons.
		 */

		 /**
		 * @var string[] $linkmod_classes
		 */
		$linkmod_classes = array();
		/**
		 * @var string[] $icon_classes
		 */
		$icon_classes    = array();

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param \WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param \WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */

		$classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		$is_parent = false;

		if ( ! empty( preg_grep( '/has-children/', $classes ) ) ) {
			$is_parent = true;
		}

		$parent = intval( data_get( $item, 'menu_item_parent', 0 ) );

		if ( 0 !== $parent ) {
			$parent = get_post( $parent );
			$this->parent = $parent;
		}

		/**
		 * Get an updated $classes array without linkmod or icon classes.
		 *
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes         Array of the CSS classes that are
		 *                                  applied to the menu item's `<li>` element.
		 * @param array   $linkmod_classes  Array of modifying classes
		 * @param array   $args             Array of icon classes
		 * @param int     $depth            Depth of menu item. Used for padding.
		 */
		//self::separate_linkmods_and_icons_from_classes( $classes, $linkmod_classes, $icon_classes, $depth );

		// Set a typeflag to easily test if this is a linkmod or not.
		$linkmod_classes = rwp_parse_classes( $linkmod_classes );

		$icon_classes = rwp_parse_classes( $icon_classes );

		// if ( get_field( 'icon', $item ) ) {
		// 	$icon_classes = rwp_parse_classes( get_field( 'icon', $item ) );
		// }

		/**
		 * Initiate empty icon var, then if we have a string containing any
		 * icon classes form the icon markup with an <i> element. This is
		 * output inside of the item before the $title (the link text).
		 */
		$icon = null;
		if ( ! empty( $icon_classes ) ) {
			// Append an <i> with the icon classes to what is output before links.
			$icon_classes[] = 'nav-icon';
			$icon = rwp_icon( [ 'atts' => [ 'class' => $icon_classes ] ] );
			$icon = $icon->__toString();
		}

		$title = data_get( $item, 'title' );
		$title = apply_filters( 'the_title', $title, $item->ID ); // phpcs:ignore

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param \WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string    $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param \WP_Post  $item    The current menu item.
		 * @param stdClass  $args    An object of wp_nav_menu() arguments.
		 * @param int       $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		$id = ! empty( $id ) ? $id : 'menu-item-' . $item->ID;

		$link_attr_title = data_get( $item, 'attr_title', strip_tags( $title ) );
		$link_target     = data_get( $item, 'target', '' );
		$link_xfn        = data_get( $item, 'xfn', '' );
		$link_url        = data_get( $item, 'url', '' );
		$link_current    = data_get( $item, 'current', false );

		$link_atts = [
			'title'        => $link_attr_title,
			'target'       => $link_target,
			'rel'          => $link_xfn,
			'href'         => rwp_relative_url( $link_url ),
			'aria-current' => $link_current ? 'page' : '',
		];

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $link_atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        The title attribute.
		 *     @type string $target       The target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria_current The aria-current attribute.
		 * }
		 * @param \WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */

		$link_atts = apply_filters( 'nav_menu_link_attributes', $link_atts, $item, $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		foreach ( $link_atts as $key => $value ) {
			if ( empty( $value ) ) {
				unset( $link_atts[ $key ] );
			}
		}
		if ( rwp_get_field( 'link_atts', $item ) ) {
			$link_atts_custom = rwp_get_field( 'link_atts', $item );
			$link_atts = rwp_merge_args( $link_atts, $link_atts_custom );
		}

		// If the .sr-only class was set apply to the nav items text only.

		$nav_item_args = array(
			'nav_item'   => $item,
			'depth'      => $depth,
			'menu'       => $menu,
			'active'     => $this->checkCurrent( $classes ),
			'is_parent'  => $is_parent,
			'atts'       => array(
				'id'     => $id,
				'class'  => $classes,
			),
		);

		if ( 0 !== $parent ) {
			$nav_item_args['parent'] = $parent;
		}

		$nav_item_order = array( 'link' );

		if ( rwp_object_has( 'link_before', $args ) ) {
			array_unshift( $nav_item_order, 'before' );
			$nav_item_args['before'] = $args->link_before;
		}

		if ( $is_parent ) {
			$this->sub_menu_id = $id . '-sub-menu';
			$nav_item_order[] = 'toggle';
			$nav_item_args['toggle']['link'] = '#' . $id . '-sub-menu';
		}

		if ( rwp_object_has( 'link_after', $args ) ) {
			$nav_item_order[] = 'after';
			$nav_item_args['after'] = $args->link_after;
		}

		$nav_item_args['order'] = $nav_item_order;

		$nav_link_args = array(
			'atts' => $link_atts,
		);

		$nav_link_content = array(
			'title' => $title,
		);

		if ( rwp_object_has( 'before', $args ) ) {
			$nav_link_content = array(
				'before' => $args->before,
				'title'  => $title,
			);
		}

		if ( rwp_object_has( 'after', $args ) ) {
			$nav_link_content['after'] = $args->after;
		}

		$nav_link_args['content'] = $nav_link_content;

		$nav_item_args['link'] = $nav_link_args;

		/**
		 * This is the end of the internal nav item. We need to close the
		 * correct element depending on the type of link or link mod.
		 */

		// Update atts of this item based on any custom linkmod classes.
		$this->nav_item = new NavItem( $nav_item_args );

		$item_output = $this->nav_item->start_tag();
		$item_output = apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );  // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$item_output .= $this->nav_item->content();
		// END appending the internal item contents to the output.
		$output .= $item_output;
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see  Walker_Nav_Menu::end_lvl
	 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/end_lvl/
	 *
	 * @inheritDoc
	 */

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$output .= $n . $indent;
		$output .= '</ul></nav>';
	}


	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->is_subitem = ( ( ! empty( $children_elements[ $element->ID ] ) && ( ( $depth + 1 ) < $max_depth || ( 0 === $max_depth ) ) ) );

		if ( $element->is_subitem ) {
			foreach ( $children_elements[ $element->ID ] as $child ) {
				if ( $child->current_item_parent || rwp_url_compare( $this->archive, $child->url ) ) {
					$element->classes[] = 'active';
				}
			}
		}

		$element->is_active = ( ! empty( $element->url ) && strpos( $this->archive, $element->url ) );

		if ( $element->is_active ) {
			$element->classes[] = 'active';
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
