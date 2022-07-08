<?php
/** ============================================================================
 * NavList
 *
 * @package   RWP\/includes/components/NavList.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class NavList extends HtmlList {

	/**
	 * @var array $atts
	 */
	public $atts = array(
        'class'     => array(
            'menu',
		),
		'role' => 'menu',
	);

	/**
	 * @var string The class to map all sub-elements into
	 */

	public $item_type = 'NavItem';

	/**
	 * @var bool $has_wrapper Whether or not this menu is wrapped with a <nav>
	 */
	public $has_wrapper = false;

	/**
	 * @var int If the depth is greater than 0 then it is a subnav
	 */
	public $depth = 0;

	/**
	 * @var string The type of navigation. One of `nav|navbar|tabs|pills|indented|flush`
	 * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#base-nav
	 */
	public $type = 'indented';

	/**
	 * @var string The direction of the navigation (either horizontal or vertical)
	 */
	public $direction = 'vertical';

	/**
	 * @var string|false The type of dropdown. Can be one of `collapse|dropdown|tabs`
	 */
	public $toggle_type = false;

	/**
	 * @var string The subnav parent id or the menu id if `$depth == 0`
	 */
	public $parent;

	/**
	 * @var string|false The parent type of dropdown. Can be one of `collapse|dropdown|tabs`
	 */
	public $parent_type = false;

	/**
	 * @var bool Make nav items fill available space (unequal widths)
	 */
	public $fill = false;

	/**
	 * @var bool Make nav items fill available space (equal widths)
	 */
	public $justified = false;

	/**
	 * @var bool Make nav items pill style
	 */
	public $pills = false;

	/**
	 * @var false|Button The Toggle Button Element
	 */
	public $toggle = false;

	/**
	 * @var bool $open Whether or not the item is currently open
	 */
	public $open = false;

	/**
	 * @var bool $has_wrapper Whether or not this menu is wrapped with a <nav>
	 */
	public $has_wrapper = true;

	/**
	 * @var mixed $parent The subnav parent id
	 */
	public $parent;

	/**
	 * @var string $nested_type The type of dropdown. Can be one of `collapse|indented`
	 */
	public $nested_type = 'collapse';

	/**
	 * @var int $nested_type_depth What depth to start the nested type
	 */
	public $nested_type_depth = 1;

	/**
	 * @var mixed The Toggle Button Element
	 */
	public $toggle;


	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		$item = data_get( $args, 'item_args' );

		$item_args = rwp_collection( $args )->only( array( 'depth', 'toggle_type', 'type', 'parent', 'toggle', 'parent_type', 'open' ) );

		$args['item_args'] = $item_args->merge( $item )->all();

		parent::__construct( $args );

		if ( false !== $this->nested_type && $this->depth === $this->nested_type_depth ) {
			$this->item_atts['parent_type'] = $this->nested_type;
		}

<<<<<<< HEAD
		$this->set_attr( 'aria-orientation', $direction, true );
	}

	public function setup_html() {

		if ( ! $this->has_wrapper ) {
			switch ( $this->toggle_type ) {
				case 'dropdown':
					if ( 0 < $this->depth ) {
						$this->add_class( 'dropdown-menu' );
						$this->set_attr( 'aria-labelledby', $this->get_attr( 'id' ) . '-btn' );
					}
				    break;
				case 'tab':
					if ( 0 == $this->depth ) {
						$this->add_class( array( 'tab-pane', 'fade' ) );
						$this->set_attr( 'role', 'tabpanel' );
					}
				    break;
				case 'collapse':
					if ( 0 < $this->depth ) {
						$this->add_class( 'collapse' );
						$this->set_attr( 'aria-labelledby', $this->get_attr( 'id' ) . '-btn' );
					}
				    break;
			}

			if ( 0 < $this->depth ) {
				$this->add_class( array( 'sub-nav', 'level-' . ( $this->depth ) . '-menu' ) );
			}
=======
	}


	public function setup_html() {

		$this->set_attr( 'aria-orientation', $this->direction, true );
		$type = $this->type;
		if ( 0 == $this->depth ) { // top level only
			switch ( $type ) {
				case 'tabs':
					$this->add_class( 'nav' );
					$this->add_class( "nav-$type" );
					$this->set_attr( 'role', 'tablist', true );
					break;
				case 'pills':
					$this->add_class( 'nav' );
					$this->add_class( "nav-$type" );
					break;
				case 'navbar':
					$this->set_attr( 'role', 'menubar', true );
					$this->add_class( 'navbar-menu' );
					break;
				case 'nav':
					$this->add_class( 'nav' );
					break;
			}
		} else {
			switch ( $type ) {

				case 'pills':
					$this->add_class( "nav-$type" );
					break;
				case 'dropdown':
					if ( ! $this->has_wrapper ) {
						$this->add_class( 'dropdown-menu' );
						$this->remove_class( 'nav' );
						$this->set_attr( 'aria-labelledby', $this->get_attr( 'id' ) . '-btn' );
					}
					break;
				case 'collapse':
					$this->add_class( 'nav' );
					if ( ! $this->has_wrapper ) {
						$this->add_class( 'collapse' );
						$this->set_attr( 'aria-labelledby', $this->get_attr( 'id' ) . '-btn' );
						if ( $this->open ) {
							$this->add_class( 'show' );
						}
					}
					break;
				case 'nav':
					$this->add_class( 'nav' );
					break;
			}
		}
		if ( 0 < $this->depth ) {
			$this->add_class( array( 'sub-menu', 'level-' . ( $this->depth ) . '-menu' ) );

		}

		if ( $this->pill ) {
			$this->add_class( 'nav-pill' );
		} else {
			$this->remove_class( 'nav-pill' );
		}

		if ( $this->fill ) {
			$this->add_class( 'nav-fill' );
		} else {
			$this->remove_class( 'nav-fill' );
		}

		if ( $this->justified ) {
			$this->add_class( 'nav-justified' );
		} else {
			$this->remove_class( 'nav-justified' );
>>>>>>> release/v0.9.0
		}

	}
}
