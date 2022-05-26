<?php
/** ============================================================================
 * NavItem
 *
 * @package   RWP\/includes/components/NavItem.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class NavItem extends Element {
	/**
	 * @var string $tag
	 */
	public $tag = 'li';

	public $order = array( 'link', 'toggle', 'dropdown' );

	/**
	 * @var array $atts
	 */
	public $atts = array(
		'itemscope' => '',
        'itemtype'  => 'https://www.schema.org/SiteNavigationElement',
        'role'      => 'none',
        'class'     => array(
            'nav-item',
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
		'tag' => 'a',
		'atts' => array(
			'class'     => array(
				'nav-link',
			),
		),
	);

	/**
	 * @var mixed $toggle
	 */

	public $toggle = array(
		'tag' => 'button',
		'text' => array(
			'content' => 'Toggle submenu',
			'atts' => array(
				'class'     => array(
					'visually-hidden',
				),
			),
		),
		'atts' => array(
			'class'     => array(
				'nav-toggle',
			),
		),
	);

	/**
     * @var int $depth The depth or level of the menu-item
     */
    public $depth = 0;

	/**
     * @var false|string $toggle_type The toggle type or false
     */
    public $toggle_type = 'collapse';

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
	 * @var string $parent The subnav parent id or the menu id if `$depth == 0`
	 */
	public $parent;

	/**
	 * @var string $parent_type The parent type toggle
	 */
	public $parent_type = 'collapse';

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

		if ( false === $this->is_parent ) {
			$this->remove_order_item( 'toggle' );
			$this->remove_order_item( 'dropdown' );
		}
	}

	/**
	 * Function to run before building the Html class
	 *
	 * @return void
	 */

	public function setup_html() {
		if ( 'dropdown' === $this->parent_type && $this->depth > 0 ) {
			$this->remove_class( 'nav-item' );
			$this->link->add_class( 'dropdown-item' );
		}
		$this->setup_link();
		$this->setup_toggle();
	}

	public function setup_toggle() {
		if ( $this->is_parent && false !== $this->toggle_type && filled( $this->toggle ) ) {
			switch ( $this->toggle_type ) {
				case 'dropdown':
					$this->add_class( 'dropdown' );
					if ( $this->depth >= 1 ) {
						$this->add_class( 'dropend' );
					}
				    break;
				case 'tab':
				case 'pill':
				    break;
				case 'collapse':
				    break;
			}
			$this->set( 'toggle.toggle', $this->toggle_type );

			$this->toggle = new Button( $this->toggle );
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

					} else { // else make it a button
						$link = $this->link->toArray();

						$this->link = new Button( $link );
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
