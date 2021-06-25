<?php

/** ============================================================================
 * RWP Nav
 *
 * @package RWP\Components\Nav
 * @since   0.1.0
 * ========================================================================== */


namespace RWP\Components;

use stdClass;

class Nav extends Html {

	/**
	 * @var string $id The menu id
	 */

	public $id = 'menu';

	/**
	 * @var array|Collection $order The order the content is generated in
	 */

	public $order = ['before', 'list', 'after'];

	/**
	 * @var array|Collection $navbar_content The order the content is generated in
	 */

	public $navbar_content = ['start' => '', 'end' => ''];

	/**
	 * @var int $depth If the depth is greater than 0 then it is a subnav
	 */

	public $depth = 0;

	/**
	 * @var null|int|\WP_Term $wp_menu The associated nav menu
	 */

	public $wp_menu;
	/**
	 * @var string $type The type of navigation. One of `nav|navbar|tabs|pills`
	 * @link https://getbootstrap.com/docs/4.5/components/navs/
	 */
	public $type = 'nav';

	/**
	 * @var string $direction The direction of the navigation (either horizontal or vertical)
	 */
	public $direction = 'vertical';

	/**
	 * @var string $parent The subnav parent id or the menu id if `$depth == 0`
	 */
	public $parent;

	/**
	 * @var string $child_type The type of dropdown.
	 *                         Can be one of `collapse|dropdown|tabs|indented`
	 */
	public $child_type;

	/**
	 * @var  string  $theme  The theme color for navbar
	 * @link https://getbootstrap.com/docs/4.5/components/navbar/#color-schemes
	 */

	public $theme;

	/**
	 * @var  string  $color  The background color class for navbar
	 * @link https://getbootstrap.com/docs/4.5/components/navbar/#color-schemes
	 */

	public $color;

	/**
	 * @var  string  $breakpoint  The breakpoint where the navbar becomes a toggle.
	 *                            Can be one of `md|ml|lg|xl`
	 * @link https://getbootstrap.com/docs/4.5/components/navbar/#responsive-behaviors
	 */

	public $breakpoint = 'lg';


	/**
	 * @var array|Html $navbar Container added when the nav is a navbar
	 */

	public $navbar = [
		'order' => ['before', 'list', 'after'],
		'atts' => [
			'tag'   => 'div',
			'class' => [
				'collapse',
				'navbar-collapse'
			]
		]
	];

	/**
	 * @var  array|string|Media  $brand  The brand image for the navbar
	 */

	public $brand = [
		'link' => true,
		'atts' => [
			'class' => [
				'navbar-brand',
			]
		]
	];

	/**
	 * @var  array|string|Form  $search  A search form to add to the navbar
	 */

	public $search = [
		'atts' => [
			'tag' => 'div',
			'class' => [
				'navbar-search'
			]
		]
	];

	/**
	 * @var  array|string|Html  $text  Custom text to add to the navbar
	 */
	public $text = [
		'atts' => [
			'class' => [
				'navbar-text'
			]
		]
	];

	/**
	 * @var  array|string|Button  $toggle  The mobile toggle button to add to the navbar
	 */
	public $toggle = [
		'text' => [
			'content' => 'Toggle Navigation',
			'screen_reader' => true
		],
		'icon' => [
			'bars' => 3,
			'atts' => [
				'class' => [
					'navbar-toggler-icon'
				]
			]
		],
		'toggle' => 'collapse',
		'atts' => [
			'tag' => 'button',
			'class' => [
				'navbar-toggler'
			]
		],
	];


	/**
	 * @var array $atts The arguments for the nav
	 */

	public $atts = [
		'tag' => 'nav',
		'class'     => [
			'nav-wrapper',
		]
	];

	/**
	 * @var array|string|HtmlList $list The unordered list tag
	 */

	public $list = [
		'atts' => [
			'tag' => 'ul',
			'class' => [
				'nav',
			],
			'role' => 'menu'
		]
	];

	/**
	 * @var array $atts The arguments for the nav items
	 */

	public $item_atts = [
		'tag'       => 'li',
		'itemscope' => '',
		'itemtype'  => 'https://www.schema.org/SiteNavigationElement',
		'role'      => 'none',
		'class'     => [
			'nav-item',
		]
	];

	/**
	 * @var array|Html $link The link item attributes
	 */
	public $link_atts = [
		'atts' => [
			'tag' => 'a',
			'class' => [
				'nav-link'
			]
		],
		'text' => [
			'atts' => [
				'tag' => 'span',
				'class' => [
					'nav-text'
				]
			],
		]
	];



	public function __construct($args = []) {

		parent::__construct($args);

		$this->list = new HtmlList($this->list);
		$this->list->item_atts = $this->item_atts;
		$this->navbar_content = new stdClass($this->navbar_content);
		if (!property_exists($this->navbar_content, 'start')) {
			$this->navbar_content->start = '';
		}
		if (!property_exists($this->navbar_content, 'end')) {
			$this->navbar_content->end = '';
		}

		$this->navbar = new Html($this->navbar);

		if (!empty($this->wp_menu) && !($this->wp_menu instanceof \WP_Term)) {
			$this->wp_menu = rwp_get_menu($this->wp_menu);
		}

		if ($this->list->hasAttr('id')) {
			$this->id = $this->list->getAttr('id');
		} elseif (!empty($this->wp_menu)) {
			$id = $this->prefix($this->wp_menu->slug, 'menu-');
			$this->list->setAttr('id', $id);
			$this->id = $this->wp_menu->slug;
		}

		if (!$this->hasAttr('id') && !empty($this->id)) {
			$wrapper = $this->suffix($this->id, '-wrapper');
			$this->setAttr('id', $wrapper);
		}

		if (!$this->list->hasAttr('id') && !empty($this->id)) {
			$this->list->setAttr('id', $this->id);
		}

		$this->setupMenu();
		$this->setupNav();
	}

	public function setupNavbar() {
		$this->addClass('navbar');

		$this->order = preg_replace('/list/', 'navbar', $this->order);

		$nav_id = $this->suffix($this->id, '-container');

		// Setup navbar atts

		if (!empty($this->breakpoint)) {
			$this->addClass('navbar-expand-' . $this->breakpoint);
		} else {
			$this->addClass('navbar-expand');
		}

		if (!empty($this->theme)) {
			$this->addClass('navbar-' . $this->theme);
		}

		if (!empty($this->color)) {
			$this->addClass('bg-' . $this->color);
		}

		if (!$this->navbar->hasAttr('aria-labelledby')) {
			$this->navbar->setAttr('aria-labelledby', "$nav_id-btn");
		}

		if (!$this->navbar->hasAttr('id')) {
			$this->navbar->setAttr('id', $nav_id);
		}



		// Setup menu atts
		$this->list->addClass('navbar-nav');
		$this->list->addAttr('role', 'menubar');
		$this->list->addAttr('aria-orientation', 'horizontal');

		$this->search = \get_search_form(array('echo' => false));
		$this->toggle = rwp_button($this->toggle);
		if (!$this->toggle->hasAttr('id')) {
			$this->toggle->setAttr('id', "$nav_id-btn");
		}

		if (!$this->toggle->hasArg('target') || empty($this->toggle->target)) {
			$this->toggle->target = $nav_id;
		}
		$this->text = rwp_text($this->text);
		$this->brand = rwp_get_logo($this->brand);

		if (!in_array('toggle', $this->order)) {
			$this->order[] = 'toggle';
		}

		$navbar_content_order = rwp_collection($this->order);

		$navbar_start_content = $navbar_content_order->takeUntil('navbar')->all();
		$navbar_end_content = $navbar_content_order->reverse()->takeUntil('navbar')->all();

		if (!property_exists($this->navbar_content, 'start')) {
			$this->navbar_content->start = '';
		}
		if (!property_exists($this->navbar_content, 'end')) {
			$this->navbar_content->end = '';
		}

		foreach ($navbar_start_content as $location) {
			if ($this->hasArg($location) && $this->$location instanceof Html) {
				$this->navbar_content->start .= $this->$location->__toString();
			}
		}

		foreach ($navbar_end_content as $location) {
			if ($this->hasArg($location) && $this->$location instanceof Html) {
				$this->navbar_content->end .= $this->$location->__toString();
			}
		}
	}

	public function navbarContent($type = 'start') {
		$navbar_content = '';

		if ($this->type === 'navbar' && $this->depth == 0) {

			if (property_exists($this->navbar_content, $type)) {
				if (!empty($this->navbar_content->$type)) {
					$navbar_content = $this->navbar_content->$type;
				}
			}
		}


		return $navbar_content;
	}

	public function setupNav() {

		$parent_id = $this->parent;

		if ($this->depth == 0) {
			if ($this->child_type === 'dropdown') {
				if ($this->depth == 1) {
					$this->addClass('dropdown-menu');
				}
			}
			if ($this->type === 'tab') {
				if ($this->depth == 1) {
					$this->addClasses(['tab-pane', 'fade']);
					$this->setAttr('role', 'tabpanel');
				}
			}
		} else {
			$this->addClasses(['sub-nav', 'level-' . ($this->depth) . '-menu']);
			if (!empty($this->child_type)) {
				if (!$this->hasAttr('aria-labelledby')) {
					$this->setAttr('aria-labelledby', $this->getAttr('id') . '-btn');
				}
			}
		}

		if ($this->type === 'navbar') {
			$this->setupNavbar();
		} else {
			if ($this->depth > 0) {
				if ($this->child_type === 'collapse') {
					$this->addClass('collapse');
					// if (!$this->hasAttr('data-parent')) {
					//     $this->setAttr('data-parent', $parent_id);
					// }
				}
			}
		}
	}

	public function formatItem($args = []) {
		$item_args = [
			'atts' => $this->item_atts,
			'link' => $this->link_atts
		];
		if (is_array($args)) {
			$args = rwp_merge_args($item_args, $args);
			$args = rwp_nav_item($args);
		} else if (is_string($args)) {
			$item_args['content'] = $args;
			$args =  $item_args;
			$args = rwp_html($args);
		} else if (is_object($args)) {
			$args->mergeArgs($item_args);
		}
		return $args;
	}

	public function addItem($args = [], $i = null) {
		$args = $this->formatItem($args);

		if ($this->type === 'navbar' && $this->depth == 0) {
			$this->navbar->list->addItem($args, $i);
		} else {
			$this->list->addItem($args, $i);
		}
	}

	public function setupMenu() {

		if ($this->type === 'tab') {
			$this->list->addClass('nav-tabs');
			$this->list->setAttr('role', 'tablist');
		}

		if ($this->type === 'pills') {
			$this->list->addClass('nav-pills');
			$this->list->setAttr('role', 'tablist');
		}

		if (!empty($this->direction)) {
			$this->list->addAttr('aria-orientation', $this->direction);
			if ($this->direction === 'vertical') {
				$this->list->addClass('flex-column');
				$this->list->addAttr('aria-orientation', 'vertical');
			}
		}

		if (!$this->list->hasAttr('aria-orientation')) {
			$this->list->addClass('flex-column');
			$this->list->addAttr('aria-orientation', 'vertical');
		}

		if ($this->type === 'navbar' && $this->depth == 0) {
			$this->list->preBuild();
			$this->navbar->list = $this->list;
		}
	}
	public function navStartTag() {
		$nav_tag =  $this->startTag();
		$start_tag = '';
		$navbar_tag = '';
		$menu_tag = $this->list->startTag();

		if ($this->type === 'navbar' && $this->depth == 0) {
			$navbar_tag = $this->navbar->startTag();
			$navbar_content = $this->navbarContent();
			$navbar_tag = $navbar_content . $navbar_tag;
		}


		$start_tag = $nav_tag . $navbar_tag . $menu_tag;
		return $start_tag;
	}

	public function navEndTag() {


		$nav_tag =  $this->endTag();
		$end_tag = '';
		$navbar_tag = '';
		$menu_tag = $this->list->endTag();

		if ($this->type === 'navbar' && $this->depth == 0) {
			$navbar_tag = $this->navbar->endTag();
			$navbar_content = $this->navbarContent('end');
			$navbar_tag = $navbar_tag . $navbar_content;
		}

		$end_tag = $menu_tag . $navbar_tag .  $nav_tag;
		return $end_tag;
	}
}
