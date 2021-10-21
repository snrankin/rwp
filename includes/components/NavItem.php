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
	 * @var (string|string[][])[]|Element $link
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
	 * @var (string|string[][])[]|Element $toggle
	 */

	public $toggle = array(
		'tag' => 'button',
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
     * @var bool $is_parent Is item active?
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

		parent::__construct( $args );

		$this->link = new Element( $this->link );

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
			if ( ! array_search( 'link', $this->order ) ) {
				$this->set_order( 'link', 0 );
			}
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
		if ( $this->is_parent && false !== $this->toggle_type ) {
			$this->set( 'toggle.toggle', $this->toggle_type );

			$this->toggle = new Button( $this->toggle );
			$this->toggle->set_attr( 'data-bs-parent', $this->parent );
			if ( ! array_search( 'toggle', $this->order ) ) {
				$this->set_order( 'toggle', 1 );
			}
		} else {
			$this->order = rwp_array_remove( $this->order, 'toggle' );
			$this->order = rwp_array_remove( $this->order, 'dropdown' );
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
		$this->remove_class( 'nav-item' );
		$this->link->remove_class( 'nav-link' );
        $this->link->remove_attr( 'href' );
        $this->link->remove_attr( 'target' );
        $this->link->remove_attr( 'rel' );
        $this->link->remove_attr( 'title' );
        $this->link->remove_attr( 'role' );
    }
}
