<?php

/** ============================================================================
 * RWP NavWalker
 *
 * Adds Bootstrap 4 classes/structure to the nav walker. Based on
 * https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 *
 * @package RWP\Components\NavWalker
 * @since   0.1.0
 * @see     Walker_Nav_Menu
 * @link    https://developer.wordpress.org/reference/classes/walker_nav_menu/
 *
 * @inheritDoc
 * ========================================================================== */

namespace RWP\Components;


use RWP\Components\{Nav, NavItem};


class NavWalker extends \Walker_Nav_Menu {
	use \RWP\Components\Helpers;

	private $cpt; // Boolean, is current post a custom post type
	private $archive; // Stores the archive page for current URL
	private $ancestors;
	public function __construct() {
		add_filter('nav_menu_css_class', array($this, 'cssClasses'), 10, 2);
		add_filter('nav_menu_item_id', '__return_null');
		$cpt             = get_post_type();
		$this->cpt       = in_array($cpt, get_post_types(array('_builtin' => false)));
		$this->archive   = get_post_type_archive_link($cpt);
		$_current_page   = url_to_postid($_SERVER['REQUEST_URI']);
		if (rwp_is_blog()) {
			$_current_page   = get_option('page_for_posts');
		}
		if (!empty($_current_page)) {
			if (empty($this->ancestors)) {
				$this->ancestors = rwp_ancestors($_current_page);
			}
		}
	}

	public static function checkCurrent($classes) {
		if (is_string($classes)) {
			return preg_match('/(current[-_])|active/', $classes);
		}
		if (is_array($classes)) {
			return preg_grep('/(current[-_])|active/', $classes);
		}
	}

	// @codingStandardsIgnoreStart
	public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output) {
		$element->is_subitem = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

		if ($element->is_subitem) {
			foreach ($children_elements[$element->ID] as $child) {
				if ($child->current_item_parent || rwp_url_compare($this->archive, $child->url)) {
					$element->classes[] = 'active';
				}
			}
		}

		$element->is_active = (!empty($element->url) && strpos($this->archive, $element->url));

		if ($element->is_active) {
			$element->classes[] = 'active';
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
	// @codingStandardsIgnoreEnd

	public function cssClasses($classes, $item) {
		$slug = sanitize_title($item->title);

		$ancestors = $this->ancestors;

		$is_active = false;

		if ($item->current) {
			$is_active = true;
		}
		if ($item->current_item_parent) {
			$is_active = true;
		}

		if ($item->current_item_ancestor) {
			$is_active = true;
		}

		if (!empty($ancestors) && rwp_is_collection($ancestors)) {
			$ancestors = $ancestors->filter(function ($ancestor) use ($slug) {
				$object = data_get($ancestor, 'slug');
				return $slug === $object;
			});
			if ($ancestors->isNotEmpty()) {

				$is_active = true;
			}
		}

		// if (rwp_is_blog($item)) {
		// 	$is_active = false;
		// }

		// Fix core `active` behavior for custom post types

		if (is_search() || is_404()) {
			$is_active = false;
		}


		if ($is_active) {
			$classes[] = 'active';
		}



		// Remove most core classes
		$classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', '', $classes);
		$classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

		// Re-add core `menu-item` class
		$classes[] = 'menu-item';

		// Re-add core `menu-item-has-children` class on parent elements
		if ($item->is_subitem) {
			$classes[] = 'has-children';
		}

		// Add `menu-<slug>` class
		$classes[] = 'menu-' . $slug;

		$classes = array_unique($classes);
		$classes = array_map('trim', $classes);

		return array_filter($classes);
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see  Walker_Nav_Menu::start_lvl
	 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/start_lvl/
	 *
	 * @inheritDoc
	 */
	public function start_lvl(&$output, $depth = 0, $args = null) {
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		if ($depth) {
			$indent = str_repeat($t, $depth);
		} else {
			$indent = '';
		}

		$classes = apply_filters('nav_menu_submenu_css_class', ['sub-menu'], $args, $depth);

		$output .= $n . $indent;
		$sub_menu_args = [
			'depth'      => $depth + 1,
			'list'       => [
				'atts' => [
					'class' => $classes
				]
			],
		];

		if ($this->nav_item instanceof NavItem) {
			if ($this->nav_item->hasArg('wp_menu')) {
				$sub_menu_args['wp_menu'] = $this->nav_item->wp_menu;
			}
			if ($this->nav_item->hasArg('parent')) {
				$sub_menu_args['parent'] = $this->nav_item->parent;
			}
			if ($this->nav_item->hasArg('child_type')) {
				$sub_menu_args['child_type'] = $this->nav_item->child_type;
			}
			if ($this->nav_item->hasArg('children')) {
				$sub_menu_args['atts']['id'] = $this->nav_item->children;
			}
		}

		if ($this->nav_item->child_type === 'dropdown' && $depth > 0) {
			$sub_menu_args['child_type'] = 'collapse';
		}

		$sub_menu = new Nav($sub_menu_args);
		$this->sub_menu = $sub_menu;
		$nav_output = $sub_menu->navStartTag();

		$output .= $nav_output;
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see  Walker_Nav_Menu::end_lvl
	 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/end_lvl/
	 *
	 * @inheritDoc
	 */

	public function end_lvl(&$output, $depth = 0, $args = null) {
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat($t, $depth);
		$output .= $n . $indent;
		$output .= $this->sub_menu->navEndTag();
	}

	/**
	 * Starts the element output.
	 *
	 * @see  Walker_Nav_Menu::start_el
	 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/start_el/
	 *
	 * @inheritDoc
	 */
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent = ($depth) ? str_repeat($t, $depth) : '';
		$output .= $n . $indent;
		$classes   = empty($item->classes) ? [] : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Initialize some holder variables to store specially handled item
		 * wrappers and icons.
		 */

		$linkmod_classes = [];
		$icon_classes    = [];

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters('nav_menu_item_args', $args, $item, $depth);

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */


		$classes = apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth);

		$is_parent = preg_grep('/has[-_]children|ancestor/', $classes);
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
		self::separate_linkmods_and_icons_from_classes($classes, $linkmod_classes, $icon_classes, $depth);

		// Set a typeflag to easily test if this is a linkmod or not.
		$linkmod_classes = rwp_parse_classes($linkmod_classes);

		$icon_classes = rwp_parse_classes($icon_classes);

		if (get_field('icon', $item)) {
			$icon_classes = rwp_parse_classes(get_field('icon', $item));
		}

		/**
		 * Initiate empty icon var, then if we have a string containing any
		 * icon classes form the icon markup with an <i> element. This is
		 * output inside of the item before the $title (the link text).
		 */
		$icon = null;
		if (!empty($icon_classes)) {
			// Append an <i> with the icon classes to what is output before links.
			$icon_classes[] = 'nav-icon';
			$icon = rwp_icon(['atts' => ['class' => $icon_classes]]);
			$icon = $icon->__toString();
		}

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);

		$id = !empty($id) ? $id : 'menu-item-' . $item->ID;



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
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */

		$link_atts = [
			'href'         => rwp_relative_url($item->url),
			'target'       => $item->target,
			'rel'          => $item->xfn,
			'title'        => $item->attr_title ?? strip_tags($item->title),
			'aria-current' => $item->current ? 'page' : '',
		];

		$link_atts = apply_filters('nav_menu_link_attributes', $link_atts, $item, $args, $depth);



		if (get_field('link_atts', $item)) {
			$link_atts_custom = get_field('link_atts', $item);
			$link_atts = rwp_merge_args($link_atts, $link_atts_custom);
		}

		foreach ($link_atts as $key => $value) {
			if (empty($value)) {
				unset($value);
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters('the_title', $item->title, $item->ID);

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

		// If the .sr-only class was set apply to the nav items text only.


		$nav_item = [
			'nav_item'   => $item,
			'depth'      => $depth,
			'parent'     => $item->menu_item_parent,
			'menu'       => wp_get_nav_menu_object($args->menu),
			'children'   => ($is_parent) ? "submenu-" . $item->ID : null,
			'child_type' => (property_exists($args, 'child_type')) ? $args->child_type : 'collapse',
			'before'     => $args->link_before,
			'after'      => $args->link_after,
			'link'       => [
				'before' => $args->before,
				'after'  => $args->after,
				'active' => self::checkCurrent($classes),
				'atts'   => $link_atts,
				'icon'   => [
					'content' => $icon
				],
				'text'   => [
					'content' => $title,
				],

			],
			'atts'       => [
				'id'     => $id,
				'class'  => $classes
			]
		];



		if (!empty($linkmod_classes)) {
			if (in_array('sr-only', $linkmod_classes)) {
				$nav_item['link']['text']['screen_reader'] = true;
			}
			if (in_array('disabled', $linkmod_classes)) {
				$nav_item['link']['disabled'] = true;
			}
		}

		if ($is_parent) {
			$nav_item['toggle']['toggle'] = (property_exists($args, 'child_type')) ? $args->child_type : 'collapse';
			$nav_item['toggle']['target'] = "submenu-" . $item->ID;
			$nav_item['toggle']['text']['content'] = __("Toggle $title subnav", 'rwp');
			$nav_item['toggle']['text']['screen_reader'] = true;
			$nav_item['toggle']['atts']['class'][] = 'nav-item-toggle';
		}


		if ($depth == 0) {
			if (property_exists($args, 'menu_id') && !empty($args->menu_id)) {
				$nav_item['parent'] = '#' . $args->menu_id;
			} else if (property_exists($args, 'menu')) {
				if ($args->menu instanceof \WP_Term) {
					$nav_item['parent'] = '#menu-' . $args->menu->slug;
				} elseif (is_string($args->menu)) {
					$nav_item['parent'] = '#menu-' . rwp_change_case($args->menu);
				}
			}
		} elseif ($depth > 0) {
			if (property_exists($this, 'sub_menu')) {
				$nav_item['parent'] = '#' . $this->sub_menu->getAttr('id');
			}
		}

		/**
		 * This is the end of the internal nav item. We need to close the
		 * correct element depending on the type of link or link mod.
		 */


		// Update atts of this item based on any custom linkmod classes.
		$this->nav_item = new NavItem($nav_item);
		$this->update_atts_for_linkmod_type($linkmod_classes, $nav_item);
		if (rwp_array_has('onclick', $link_atts)) {
			$this->nav_item->removeNavAtts();
			$this->nav_item->link->setAttr('tag', 'button');
		}
		$end_tag = $this->nav_item->endTag();

		$item_output = $this->nav_item->__toString();
		$end_tag_length = strlen($end_tag);
		$item_output = substr($item_output, 0, -$end_tag_length);
		//$item_output = apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

		// END appending the internal item contents to the output.
		$output .= $item_output;
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
	public static function fallback($args) {
		if (current_user_can('edit_theme_options')) {

			// Initialize var to store fallback html.
			$fallback_output = new Nav([
				'atts' => [
					'tag'   => $args['container'],
					'id'    => $args['container_id'],
					'class' => $args['container_class']
				],
				'list' => [
					'atts' => [
						'id'    => $args['menu_id'],
						'class' => $args['menu_class']
					]
				]
			]);

			$navItem = new NavItem([
				'text' => [
					'content' => 'Add a menu'
				],
				'link' => [
					'atts' => [
						'href' => esc_url(admin_url('nav-menus.php')),

					]
				]
			]);

			$fallback_output->list->addContent($navItem);

			// If $args has 'echo' key and it's true echo, otherwise return.
			if (array_key_exists('echo', $args) && $args['echo']) {
				echo $fallback_output; // WPCS: XSS OK.
			} else {
				return $fallback_output->__toString();
			}
		}
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
	 * * `.sr-only`
	 * * `.logo`
	 * * `.search`
	 *
	 * **Supported iconsets:**
	 * * Font Awesome 4/5,
	 * * Glypicons
	 *
	 * @since 4.0.0
	 *
	 * @param array   $classes            an array of classes currently assigned to the item (passed by reference).
	 * @param array   $linkmod_classes    an array to hold linkmod classes (passed by reference).
	 * @param array   $icon_classes       an array to hold icon classes (passed by reference).
	 *
	 * @return array  $classes            a maybe modified array of classnames.
	 */
	private static function separate_linkmods_and_icons_from_classes(&$classes, &$linkmod_classes, &$icon_classes) {
		$icon_pattern = '/fa-(\S*)?|fa(s|r|l|b)?[\w\-]*|glyphicon[\w\-]*|glaza[\w\-]*/i';
		$linkmod_pattern = '/disabled|sr-[\w\-]*|[\w\-]*logo[\w\-]*|[\w\-]*search[\w\-]*|dropdown[\w\-]*/i';
		if (preg_grep($icon_pattern, $classes)) {
			$icon_classes = preg_grep($icon_pattern, $classes);
			$classes = array_diff($classes, $icon_classes);
		}
		if (preg_grep($linkmod_pattern, $classes)) {
			$linkmod_classes = preg_grep($linkmod_pattern, $classes);
			$classes = array_diff($classes, $linkmod_classes);
		}
	}

	/**
	 * Update the attributes of a nav item depending on the linkmod classes.
	 *
	 * @since 4.0.0
	 *
	 * @param array    $linkmod_type    Array of atts for the current link in nav item.
	 * @param Html     $item            Current item object (passed by reference).
	 *
	 * @return Html    $item            Updated Html object
	 */
	private function update_atts_for_linkmod_type($linkmod_type) {


		if (empty($linkmod_type)) {
			return;
		}

		$item = $this->nav_item;

		if (preg_grep('/disabled|dropdown[\w\-]*/i', $linkmod_type)) {

			$this->nav_item->removeNavAtts();
			$this->nav_item->removeClass('nav-item');
			$this->nav_item->link->setAttr('tag', 'span');
			$this->nav_item->link->removeClass('nav-link');

			if (in_array('dropdown-header', $linkmod_type)) {
				$this->nav_item->link->addClass('h6');
			}

			if (in_array('dropdown-divider', $linkmod_type)) {
				$this->nav_item->addClass('dropdown-divider');
				$this->nav_item->link->removeAttr('tag');
			}

			if (in_array('disabled', $linkmod_type)) {
				$this->nav_item->link->disabled = true;
			}
		}

		if (preg_grep('/[\w\-]*search[\w\-]*/', $linkmod_type)) {

			if (preg_grep('/[\w\-]*search-btn[\w\-]*/', $linkmod_type)) {

				$btn_args = rwp_object_to_array($this->nav_item->link);
				$btn_args['toggle'] = 'collapse';
				$btn_args['target'] = ltrim($btn_args['atts']['href'], '#');
				unset($btn_args['atts']['href']);

				$this->nav_item->link = rwp_button($btn_args);
				$this->nav_item->link->setAttr('tag', 'button');
				$this->nav_item->removeNavAtts();
			} else {
				$this->nav_item->removeNavAtts();
				$this->nav_item->link->removeClass('nav-link');
				$this->nav_item->link->setAttr('tag', 'span');
				$this->nav_item->link = get_search_form(['echo' => 0]);
			}
		}

		if ((preg_grep('/[\w\-]*logo[\w\-]*/i', $linkmod_type))) {
			$logo = rwp_get_logo(['link' => false])->__toString();
			$this->nav_item->link->addContent($logo, 'before');
			$this->nav_item->link->text->content = [];
			$this->nav_item->link->text->screen_reader = true;
			$this->nav_item->addClass('navbar-item-brand');
			$this->nav_item->link->addClass('navbar-brand');
		}
		$this->nav_item->preBuild();
	}
}
