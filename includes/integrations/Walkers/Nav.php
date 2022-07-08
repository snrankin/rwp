<?php
/** ============================================================================
 * Nav
 *
 * @package   RWP\/includes/integrations/Walkers/Nav.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\Walkers;

use RuntimeException;
use Exception;
use RWP\Components\Str;
use RWP\Components\NavItem;
use RWP\Components\Nav as HtmlNav;
use RWP\Components\NavList;
use RWP\Components\Collection;
use stdClass;

/**
 * WP_Bootstrap_Navwalker class.
 *
 * @inheritdoc
 */

class Nav extends \Walker_Nav_Menu {

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
	 * @var string The current menu id
	 */
	public $menu_id;

	/**
	 * @var NavItem The current nav item object
	 */
	public $nav_item;

	/**
	 * @var \WP_Post The current nav item post object
	 */
	public $item;

	/**
	 * @var bool|string  The current nav item parent object
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

	public $item_args = array();

	public $link_args = array();

	/**
	 * @var Collection The collection of item options for ACF
	 */
	public $parent_options;

	/**
	 * @var Collection The collection of item options for ACF
	 */
	public $item_options;

	public function __construct( $args = array() ) {
		// Allow modifying icon patterns
		$this->icon_patterns = apply_filters( 'rwp_nav_icon_patterns', $this->icon_patterns );

		$menu = data_get( $args, 'menu' );
		if ( empty( $menu ) ) {
			$menu = data_get( $args, 'theme_location' );
		}
		// Get the requested menu, either a menu ID or a theme location
		$menu = rwp_get_menu( $menu );

		$this->menu = $menu;

		$menu_id = data_get( $args, 'menu_id' );

		if ( empty( $menu_id ) ) {
			$wrapper = \data_get( $args, 'items_wrap', '' );
			$wrapper = rwp_extract_html_attributes( $wrapper, 'ul' );
			$menu_id = \data_get( $wrapper, 'atts.id', '' );
		}

		$this->menu_id = $menu_id;

	}

	private function nav_item_options( $item, $depth = 0, $args = null, $id = 0 ) {
         /**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param \WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth ); // phpcs:ignore

		/**
		 * @var Collection $item_args Arguments applied to all nav items (comes from menu object)
		 */

		$item_args = data_get( $args, 'item_options', rwp_collection() );

		/**
		 * @var Collection $item_options Custom arguments for the individual nav item
		 */
<<<<<<< HEAD
		$item_options = rwp_get_field( 'nav_item_options', rwp_post_id( $item, 'acf' ) );
=======
		$item_options = rwp_get_field( 'nav_item_options', $item );
		$item_options = rwp_collection( rwp_merge_args( $item_args, $item_options ) );
>>>>>>> release/v0.9.0

		$this->item_options = $item_options;

	}

	private function nav_item_args( $item, $depth = 0, $args = null, $id = 0, $classes = array() ) {

		$menu = $this->menu;

		$menu_id = $this->menu_id;

		$this->sub_menu_id = 'item-' . $item->ID . '-sub-menu';

		$parent_type = data_get( $this->parent_options, 'toggle_type', false );
<<<<<<< HEAD
=======
		$item_type = data_get( $this->item_options, 'toggle_type', false );

		$toggle_type = $parent_type;

		if ( false != $item_type ) {
			$toggle_type = $item_type;
		}
>>>>>>> release/v0.9.0

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

		$classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ); // phpcs:ignore

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
		$id = apply_filters( 'nav_menu_item_id', 'item-' . $item->ID, $item, $args, $depth ); // phpcs:ignore

		// ========================================================================== //
		// ============================= Menu Item Icon ============================= //
		// ========================================================================== //

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

		$is_parent = false;

		if ( ! empty( preg_grep( '/has-children/', $classes ) ) ) {
			$is_parent = true;
			$this->parent_options = $this->item_options;
		}

		$parent = intval( data_get( $item, 'menu_item_parent', 0 ) );

		if ( $parent ) {
			$parent = '#item-' . $parent . '-sub-menu';
		} else {
			$parent = '#' . $menu_id;
		}

		$this->parent = $parent;

		$nav_item_args = array(
			'nav_item'    => $item,
			'depth'       => $depth,
			'menu'        => $menu,
			'active'      => $this->checkCurrent( $classes ),
			'is_parent'   => $is_parent,
			'parent'      => $parent,
<<<<<<< HEAD
=======
			'toggle_type' => $toggle_type,
>>>>>>> release/v0.9.0
			'parent_type' => $parent_type,
			'atts'        => array(
				'id'     => $id,
				'class'  => $classes,
			),
		);

		$nav_item_order = array( 'link' );

		if ( rwp_object_has( 'link_before', $args ) ) {
			array_unshift( $nav_item_order, 'before' );
			$nav_item_args['content']['before'] = $args->link_before;
		}

		if ( $is_parent ) {
			$this->sub_menu_id = $this->sub_menu_id;
			$nav_item_order[] = 'toggle';
			$nav_item_args['toggle']['link'] = '#' . $this->sub_menu_id;

			$nav_item_args['toggle_type'] = data_get( $this->item_options, 'toggle_type', 'collapse' );

			$toggle_icon_opened = data_get( $this->item_options, 'toggle_icon.icon_opened.icon', false );
			$toggle_icon_opened = rwp_get_icon_from_acf( $toggle_icon_opened );
			if ( $toggle_icon_opened ) {
				$nav_item_args['toggle']['icon_opened'] = $toggle_icon_opened;
			}

			$toggle_icon_closed = data_get( $this->item_options, 'item_toggle_icon.icon_closed.icon', false );
			$toggle_icon_closed = rwp_get_icon_from_acf( $toggle_icon_closed );

			if ( $toggle_icon_closed ) {
				$nav_item_args['toggle']['icon_closed'] = $toggle_icon_closed;
			}
		}

		if ( rwp_object_has( 'link_after', $args ) && filled( $args->link_after ) ) {
			$nav_item_order[] = 'after';
			$nav_item_args['content']['after'] = $args->link_after;
		}

		$nav_item_args['order'] = $nav_item_order;

		$nav_item_args['link'] = $this->link_args;

		$this->item_args = $nav_item_args;

	}

	private function nav_link_args( $item, $depth = 0, $args = null, $id = 0 ) {

<<<<<<< HEAD
		$parent_type = data_get( $this->parent_options, 'toggle_type', false );
=======
		$toggle_type = data_get( $this->item_options, 'toggle_type', false );
>>>>>>> release/v0.9.0

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
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth ); // phpcs:ignore

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

		$classes = apply_filters( 'nav_menu_link_css_class', array( 'menu-link' ), $item, $args, $depth ); // phpcs:ignore

<<<<<<< HEAD
		if ( false !== $parent_type ) {
			if ( 'dropdown' === $parent_type ) {
				$classes[] = 'dropdown-item';
			}
		}

=======
>>>>>>> release/v0.9.0
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

		$link_atts = apply_filters( 'nav_menu_link_attributes', $link_atts, $item, $args, $depth ); // phpcs:ignore

		$link_atts = rwp_prepare_args( $link_atts );

		$nav_link_args = array(
			'atts' => $link_atts,
		);

		$nav_link_args['atts']['class'] = $classes;

		$nav_link_content = array(
			'title' => $title,
		);

		$nav_link_order = array( 'title' );

		if ( rwp_object_has( 'before', $args ) ) {
			array_unshift( $nav_link_order, 'before' );
			$nav_link_content['before'] = $args->before;
		}

		if ( rwp_object_has( 'after', $args ) ) {
			$nav_link_order[] = 'after';
			$nav_link_content['after'] = $args->after;
		}

		$nav_link_args['order'] = $nav_link_order;
		$nav_link_args['content'] = $nav_link_content;

		$nav_link_args = rwp_add_acf_color( $nav_link_args, 'background', $this->item_options, $item );

		$this->link_args = $nav_link_args;

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

<<<<<<< HEAD
		$item_options = $this->item_options;

		if ( rwp_is_collection( $item_options ) ) {
			$item_options = $item_options->all();
		}
=======
		$item_options = $this->parent_options;
>>>>>>> release/v0.9.0

		$classes = apply_filters( 'nav_menu_submenu_css_class', array(), $args, $depth ); // phpcs:ignore
		$id = $this->sub_menu_id;

		if ( empty( $id ) ) {
			$id = 'item-' . $this->item->ID;
			$id .= '-sub-menu';
		}

		$menu_depth = $depth + 1;

		$this->parent_options = $item_options;

		$output .= $n . $indent;
		$sub_menu_args = array(
			'depth'  => $menu_depth,
			'parent' => $this->parent,
<<<<<<< HEAD
			'toggle_type' => data_get( $item_options, 'toggle_type', 'collapse' ),
			'has_wrapper' => false,
=======
			'toggle_type' => data_get( $item_options, 'toggle_type' ),
>>>>>>> release/v0.9.0
			'atts'   => array(
				'id'    => $id,
				'class' => $classes,
			),
		);

		$sub_menu = new NavList( $sub_menu_args );
		$this->sub_menu = $sub_menu;
		$item_output = $sub_menu->start_tag( true );
		$item_output = Str::replaceLast( '</ul>', '', $item_output );
		$output .= $item_output;
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

		if ( $depth ) {
			$indent = str_repeat( $t, $depth );
		} else {
			$indent = '';
		}

		// Reset the nav item options

		$this->item_args = array();
		$this->link_args = array();

		$this->nav_item_options( $item, $depth, $args, $id ); // Set the nav item ACF options

		$this->item = $item;

		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$output .= $n . $indent;

		/**
		 * @var string[] $classes
		 */
		$classes   = empty( $item->classes ) ? array() : rwp_parse_classes( $item->classes );

		 /**
		 * @var string[] $linkmod_classes
		 */
		$linkmod_classes = array();

		/**
		 * @var string[] $icon_classes
		 */
		$icon_classes    = array();

		/**
		 * Get an updated $classes array without linkmod or icon classes.
		 */
		$this->separate_linkmods_and_icons_from_classes( $classes, $linkmod_classes, $icon_classes );

		$this->nav_link_args( $item, $depth, $args, $id ); // Set the nav link args

		$this->nav_item_args( $item, $depth, $args, $id, $classes ); // Set the nav item args

		// Update atts of this item based on any custom linkmod classes.
		$this->nav_item = new NavItem( $this->item_args );

		$this->update_atts_for_linkmod_type( $linkmod_classes );

		$item_output = $this->nav_item->start_tag();
		$item_output = apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );  // phpcs:ignore
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
		$output .= '</ul>';
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

		$linkmod_classes = rwp_parse_classes( $linkmod_classes );

		$icon_classes = rwp_parse_classes( $icon_classes );
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
				$this->nav_item->link->add_class( array( 'dropdown-divider', 'flex-fill' ) );
				$this->nav_item->link->make_empty();
				$this->nav_item->link->remove_class( 'nav-link' );
				$this->nav_item->link->set_tag( 'hr' );
			}

			if ( in_array( 'vr', $linkmod_type ) ) {
				$this->nav_item->add_class( 'menu-divider' );
				$this->nav_item->link->remove_class( 'nav-link' );
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
			$this->nav_item->link->remove_class( 'nav-link' );
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

			if ( empty( $container_tag ) ) {
				$container_tag = 'nav';
			}
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
