<?php
/** ============================================================================
 * NavList
 *
 * @package   RWP\/includes/components/NavList.php
 * @since     1.0.0
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
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'list'   => 'NavList',
		'toggle' => 'Button',
	);

	/**
	 * @var int $depth If the depth is greater than 0 then it is a subnav
	 */

	public $depth = 0;

	/**
	 * @var string $type The type of navigation. One of `nav|navbar|tabs|pills`
	 * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#base-nav
	 */
	public $type;

	/**
	 * @var string $direction The direction of the navigation (either horizontal or vertical)
	 */
	public $direction = 'vertical';

	/**
	 * @var string $toggle_type  The type of dropdown. Can be one of `
	 *                          collapse|dropdown|tabs|indented`
	 */
	public $toggle_type = 'collapse';

	/**
	 * @var mixed $list
	 */

	public $list = array(
        'class'     => array(
            'nav',
		),
		'role' => 'menu',
	);

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

		$list = data_get( $args, 'list' );

		$list_args = rwp_collection( $args )->only( array( 'direction', 'toggle_type', 'depth', 'type', 'parent', 'toggle' ) );

		$args['list'] = $list_args->merge( $list )->all();

		parent::__construct( $args );

	}

	public function setup_html() {

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

	}
}
