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

use RuntimeException;
use Exception;
use RWP\Vendor\Illuminate\Support\Str;
use RWP\Components\NavItem;
use RWP\Components\Nav as HtmlNav;
use RWP\Vendor\Illuminate\Support\Collection;
use stdClass;

/**
 * WP_Bootstrap_Navwalker class.
 *
 * @inheritdoc
 */

class Nav extends \Walker_Nav_Menu {

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
		'fa(s|r|l|b)?[\w\-]*', // Font Awesome
		'glyphicon[\w\-]*', // WordPress Glyphicons
		'bs[\w\-]*', // Bootstrap 5 Icons
	);

	/**
	 * @var string[] $linkmod_patterns An array of regex patterns to search for special link modifiers
	 */
	public $linkmod_patterns = array(
		'disabled',
		'visually-hidden',
		'[\w\-]*logo[\w\-]*',
		'[\w\-]*search[\w\-]*',
		'dropdown[\w\-]*',
		'vr',
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
		// Allow modifying icon patterns
		$this->icon_patterns = apply_filters( 'rwp_nav_icon_patters', $this->icon_patterns );
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

		$classes = apply_filters( 'nav_menu_submenu_css_class', array(), $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$id = $this->sub_menu_id;

		if ( empty( $id ) ) {
			$id = 'item-' . $this->item->ID;
			$id .= '-sub-menu';
		}

		$menu_depth = $depth + 1;

		$output .= $n . $indent;
		$sub_menu_args = array(
			'depth'      => $menu_depth,
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
		$menu = $this->menu;

		if ( empty( $menu ) && wp_get_nav_menu_object( $args->menu ) ) {
			$menu = wp_get_nav_menu_object( $args->menu );
			$this->menu = $menu;
		}

		$menu_id = \data_get( $args, 'menu_id', '' );

		$this->item = $item;

		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$output .= $n . $indent;

		/**
		 * @var string[] $classes
		 */
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;

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

		$linkmod_classes = array();

		$icon_classes = array();

		/**
		 * Get an updated $classes array without linkmod or icon classes.
		 */
		$this->separate_linkmods_and_icons_from_classes( $classes, $linkmod_classes, $icon_classes );

		// Set a typeflag to easily test if this is a linkmod or not.
		$linkmod_classes = rwp_parse_classes( $linkmod_classes );

		$icon_classes = rwp_parse_classes( $icon_classes );

		if ( get_field( 'icon', $item ) ) {
			$icon_classes = rwp_parse_classes( get_field( 'icon', $item ) );
		}

		/**
		 * Initiate empty icon var, then if we have a string containing any
		 * icon classes form the icon markup with an <i> element. This is
		 * output inside of the item before the $title (the link text).
		 */
		$icon = null;
		if ( ! empty( $icon_classes ) ) {
			// Append an <i> with the icon classes to what is output before links.
			$icon_classes[] = 'nav-icon';
			$icon = rwp_icon( rwp_output_classes( $icon_classes ) );
			$icon = $icon->html();
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
		$id = apply_filters( 'nav_menu_item_id', 'item-' . $item->ID, $item, $args, $depth ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		$link_attr_title = data_get( $item, 'attr_title', strip_tags( $title ) );
		$link_target     = data_get( $item, 'target', '' );
		$link_xfn        = data_get( $item, 'xfn', '' );
		$link_url        = data_get( $item, 'url', '' );
		$link_current    = data_get( $item, 'current', false );

		$link_atts = array(
			'title'        => $link_attr_title,
			'target'       => $link_target,
			'rel'          => $link_xfn,
			'href'         => rwp_relative_url( $link_url ),
			'aria-current' => $link_current ? 'page' : '',
		);

		if ( rwp_get_field( 'link_atts', $item ) ) {
			$link_atts_custom = rwp_get_field( 'link_atts', $item );
			$link_atts = rwp_merge_args( $link_atts, $link_atts_custom );
		}

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
		} else {
			$nav_item_args['parent'] = '#' . $menu_id;
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

		$this->update_atts_for_linkmod_type( $linkmod_classes );

		$this->nav_item->build();
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

	/**
	 * Find any custom linkmod or icon classes and store in their holder
	 * arrays then remove them from the main classes array.
	 *
	 * **Supported linkmods:**
	 * * `.disabled`,
	 * * `.dropdown-header`,
	 * * `.dropdown-divider`,
	 * * `.dropdown-text`,
	 * * `.visually-hidden`
	 * * `.logo`
	 * * `.search`
	 *
	 * **Supported iconsets:**
	 * * Font Awesome 4/5,
	 * * Glypicons
	 * * Bootstrap 5
	 *
	 * @since 4.0.0
	 *
	 * @param array   $classes            an array of classes currently assigned to the item (passed by reference).
	 * @param array   $linkmod_classes    an array to hold linkmod classes (passed by reference).
	 * @param array   $icon_classes       an array to hold icon classes (passed by reference).
	 *
	 * @return void
	 */
	public function separate_linkmods_and_icons_from_classes( &$classes, &$linkmod_classes, &$icon_classes ) {
		$icon_patterns = implode( '|', $this->icon_patterns );
		$icon_patterns = "/$icon_patterns/i";
		$linkmod_patterns = implode( '|', $this->linkmod_patterns );
		$linkmod_patterns = "/$linkmod_patterns/i";

		if ( preg_grep( $icon_patterns, $classes ) ) {
			$icon_classes = preg_grep( $icon_patterns, $classes );
			$classes = array_diff( $classes, $icon_classes );
		}
		if ( preg_grep( $linkmod_patterns, $classes ) ) {
			$linkmod_classes = preg_grep( $linkmod_patterns, $classes );
			$classes = array_diff( $classes, $linkmod_classes );
		}
	}

	/**
	 * Update the attributes of a nav item depending on the linkmod classes.
	 *
	 * @since 4.0.0
	 *
	 * @param array    $linkmod_type    Array of atts for the current link in nav item.
	 * @return void
	 * @throws RuntimeException
	 * @throws Exception
	 */
	private function update_atts_for_linkmod_type( $linkmod_type ) {

		if ( empty( $linkmod_type ) ) {
			return;
		}

		if ( preg_grep( '/disabled|dropdown[\w\-]*|vr/i', $linkmod_type ) ) {

			$this->nav_item->remove_nav_atts();
			$this->nav_item->link->set_tag( 'span' );

			if ( in_array( 'dropdown-header', $linkmod_type ) ) {
				$this->nav_item->link->add_class( 'h6' );
			}

			if ( in_array( 'dropdown-divider', $linkmod_type ) ) {
				$this->nav_item->link->add_class( 'dropdown-divider' );
				$this->nav_item->link->make_empty();
				$this->nav_item->link->set_tag( 'hr' );
			}

			if ( in_array( 'vr', $linkmod_type ) ) {
				$this->nav_item->link->add_class( 'vr' );
				$this->nav_item->link->make_empty();
				$this->nav_item->link->set_tag( 'span' );
			}

			if ( in_array( 'disabled', $linkmod_type ) ) {
				$this->nav_item->disabled = true;
			}
		}

		if ( preg_grep( '/[\w\-]*search[\w\-]*/', $linkmod_type ) ) {
			$this->nav_item->link->make_empty();
			$this->nav_item->remove_nav_atts();
			$this->nav_item->link->set_tag( 'span' );
			$this->nav_item->link->set_content( get_search_form( [ 'echo' => 0 ] ) );
		}

		if ( ( preg_grep( '/[\w\-]*logo[\w\-]*/i', $linkmod_type ) ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$link_atts = rwp_extract_html_attributes( $logo, 'a' );

			if ( $link_atts ) {
				$this->nav_item->link->merge_atts( $link_atts );
			}

			$logo = rwp_html( $logo )->filter( 'img' );

			$logo = apply_filters( 'rwp_nav_logo', $logo );

			$logo = $logo->saveHtml();
			$this->nav_item->link->make_empty();
			$this->nav_item->link->set_content( $logo );
			$this->nav_item->add_class( 'navbar-item-brand' );
			$this->nav_item->link->add_class( 'navbar-brand' );
		}
	}

	/**
	 * Menu Fallback.
	 *
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a menu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'edit_theme_options' ) ) {

			$container_tag = data_get( $args, 'container', 'nav' );
			$container_id = data_get( $args, 'container_id', '' );
			$container_class = rwp_parse_classes( data_get( $args, 'container_class', '' ) );

			$menu_id = data_get( $args, 'menu_id', '' );
			$menu_class = rwp_parse_classes( data_get( $args, 'menu_class', '' ) );

			// Initialize var to store fallback html.
			$fallback_output = new HtmlNav(array(
				'tag' => $container_tag,
				'atts' => array(
					'id'    => $container_id,
					'class' => $container_class,
				),
				'list' => array(
					'atts' => array(
						'id'    => $menu_id,
						'class' => $menu_class,
					),
				),
			));

			$nav_item = new NavItem(array(
				'link' => array(
					'content' => __( 'Add a menu', 'rwp' ),
					'atts' => array(
						'href' => esc_url( admin_url( 'nav-menus.php' ) ),

					),
				),
			));

			$fallback_output->list->add_item( $nav_item );

			// If $args has 'echo' key and it's true echo, otherwise return.
			if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
				echo $fallback_output; // WPCS: XSS OK.
			} else {
				return $fallback_output->html();
			}
		}
	}
}
