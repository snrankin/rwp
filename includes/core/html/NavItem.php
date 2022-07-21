<?php

/** ============================================================================
 * NavItem
 *
 * @package   RWP\/includes/components/NavItem.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Html;

class NavItem extends Element {
	/**
	 * @var string $tag
	 */
	public $tag = 'li';

	public $order = array( 'link' );

	/**
	 * @var array $atts
	 */
	public $atts = array(
		'itemscope' => '',
		'itemtype'  => 'https://www.schema.org/SiteNavigationElement',
		'role'      => 'none',
		'class'     => array(
			'menu-item',
		),
	);

	/**
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'link'   => 'Element',
		'toggle' => 'Button',
	);

	/**
	 * @var mixed $link
	 */

	public $link = array(
		'tag'  => 'a',
		'atts' => array(
			'class' => array(
				'menu-link',
			),
		),
	);

	/**
	 * @var (string|(string|string[][])[]|string[][])[]|false|Button
	 */
	public $toggle = array(
		'tag'  => 'button',
		'text' => array(
			'content' => 'Toggle submenu',
			'atts'    => array(
				'class' => array(
					'visually-hidden',
				),
			),
		),
		'atts' => array(
			'class' => array(
				'menu-toggle',
			),
		),
	);

	/**
	 * @var string The type of navigation. One of `nav|navbar|tabs|pills|indented|flush`
	 * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#base-nav
	 */
	public $type = 'indented';

	/**
	 * @var int $depth The depth or level of the menu-item
	 */
	public $depth = 0;

	/**
	 * @var string|false The type of dropdown. Can be one of `collapse|dropdown|tabs`
	 */
	public $toggle_type = false;

	/**
	 * @var string $parent The subnav parent id or the menu id if `$depth == 0`
	 */
	public $parent;

	/**
	 * @var string $parent_type The parent type toggle
	 */
	public $parent_type = false;

	/**
	 * @var bool $has_link Does this item have link
	 */
	public $has_link = true;

	/**
	 * @var bool $disabled Is item disabled?
	 */
	public $disabled = false;

	/**
	 * @var bool $active Is item active?
	 */
	public $active = false;

	/**
	 * @var bool $is_parent Is item a parent item?
	 */
	public $is_parent = false;

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		$depth = data_get( $args, 'depth', $this->depth );

		$toggle_type = data_get( $args, 'toggle_type', $this->toggle_type );

		if ( rwp_array_has( 'toggle', $args ) ) {
			$args = data_set( $args, 'toggle.toggle', $toggle_type );
		}

		parent::__construct( $args );

		$url = $this->link->get_attr( 'href' );

		if ( $url ) {
			if ( ! rwp_is_url( $url ) ) {
				if ( '#' === $url ) { // if it is not the pound sign on it's own
					$this->remove_nav_atts();
					$this->has_link = false;
				}
			}
		}

		if ( $this->has_link ) {
			if ( false === array_search( 'link', $this->order ) ) {
				$this->set_order( 'link', 0 );
			}
		}

		if ( $this->is_parent ) {
			$this->add_order_item( 'toggle' );
			$this->add_order_item( 'dropdown' );
		}
	}

	/**
	 * Function to run before building the Html class
	 *
	 * @return void
	 */

	public function setup_html() {

		$this->setup_link();
		$this->setup_toggle();
	}

	public function setup_toggle() {

		if ( $this->is_parent && false !== $this->toggle_type && filled( $this->toggle ) ) {
			$this->set( 'toggle.toggle', $this->toggle_type );
			switch ( $this->toggle_type ) {
				case 'dropdown':
					$this->add_class( 'dropdown' );
					if ( $this->depth >= 1 ) {
						$this->add_class( 'dropend' );
					}
					break;
				case 'tab':
					$this->add_class( 'nav-item' );
					$link = $this->link;
					$link = $link->mergeArgs( $this->toggle )->all();

					$this->link = new Button( $link );
					break;
				case 'pill':
					$this->add_class( 'nav-item' );
					break;
				case 'collapse':
					$this->add_class( 'nav-item' );
					break;
			}

			if ( ! array_search( 'toggle', $this->order ) ) {
				$this->set_order( 'toggle', 2 );
			}
		} elseif ( false === $this->is_parent ) {
			$this->remove_order_item( 'toggle' );
			$this->remove_order_item( 'dropdown' );
		}
	}

	public function setup_link() {
		if ( $this->has_link ) {
			if ( $this->disabled ) {
				$this->link->add_class( 'disabled' );
			}

			if ( $this->active ) {
				$this->link->add_class( 'active' );
			}

			$url = $this->link->get_attr( 'href' );

			if ( $url ) {
				if ( ! rwp_is_url( $url ) ) {
					if ( '#' === $url ) { // if it is not the pound sign on it's own
						$this->remove_nav_atts();
					}
				}
			} else {
				$this->has_link = false;
			}
		} else {
			$this->remove_nav_atts();
		}
	}

	/**
	 * Remove attributes specifically for navigation menu items
	 * @return void
	 */

	public function remove_nav_atts() {
		$this->remove_attr( 'itemtype' );
		$this->remove_attr( 'itemscope' );
		$this->remove_attr( 'role' );
		$this->link->remove_attr( 'href' );
		$this->link->remove_attr( 'target' );
		$this->link->remove_attr( 'rel' );
		$this->link->remove_attr( 'title' );
		$this->link->remove_attr( 'role' );
		if ( 'a' === $this->link->tag ) {
			$this->link->set( 'tag', 'span' );
		}
	}
}
