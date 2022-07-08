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

class Nav extends Element {

	public $tag = 'nav';

	public $order = array( 'list' );

	/**
	 * @var array $atts
	 */
	public $atts = array(
        'class'     => array(
            'nav-wrapper',
		),
	);

	/**
	 * @var array An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'list'   => 'NavList',
		'toggle' => 'Button',
	);

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
	 * @var array|NavList
	 */
	public $list = array(
		'has-wrapper' => true,
	);

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
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		$list = data_get( $args, 'list' );

		$list_args = rwp_collection( $args )->only( array( 'direction', 'toggle_type', 'depth', 'type', 'parent', 'toggle', 'parent_type', 'fill', 'pill', 'justified' ) );

		$args['list'] = $list_args->merge( $list )->all();

		parent::__construct( $args );

	}

	public function setup_html() {
		$type = $this->type;
		$this->add_class( "nav-$type-wrapper" );

		switch ( $this->toggle_type ) {
			case 'dropdown':
				if ( 0 < $this->depth ) {
					$this->add_class( 'dropdown-menu' );
					$this->set_attr( 'aria-labelledby', $this->get_attr( 'id' ) . '-btn' );
				}
				break;

			case 'collapse':
				if ( 0 < $this->depth ) {
					$this->add_class( 'collapse' );
					$this->set_attr( 'aria-labelledby', $this->get_attr( 'id' ) . '-btn' );
					if ( $this->open ) {
							$this->add_class( 'show' );
					}
				}
				break;
		}

		if ( 0 < $this->depth ) {
			$this->add_class( array( 'sub-nav', 'level-' . ( $this->depth ) . '-menu' ) );
		}

	}
}
