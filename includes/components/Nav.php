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

	public $direction = 'vertical';

	/**
	 * @var array $atts
	 */
	public $atts = array(
        'class'     => array(
            'nav-wrapper',
		),
	);

	/**
	 * @var int $depth If the depth is greater than 0 then it is a subnav
	 */

	public $depth = 0;

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
	 * @var string $toggle_type The type of dropdown.
	 *                         Can be one of `collapse|dropdown|tabs|indented`
	 */
	public $toggle_type = 'collapse';

	/**
	 * @var string $nested_type The type of dropdown. Can be one of `collapse|indented`
	 */
	public $nested_type = 'collapse';

	/**
	 * @var int $nested_type_depth What depth to start the nested type
	 */
	public $nested_type_depth = 1;

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		parent::__construct( $args );

		$navlist_args = $this->get( 'list', array() );

		$navlist_args = data_set( $navlist_args, 'direction', $this->direction );
		$navlist_args = data_set( $navlist_args, 'toggle_type', $this->toggle_type );

		$this->list = new NavList( $navlist_args );
	}

	public function setup_html() {

		switch ( $this->toggle_type ) {
			case 'dropdown':
				if ( $this->nested_type_depth === $this->depth ) {
					$this->add_class( 'dropdown-menu' );
				} elseif ( $this->nested_type_depth < $this->depth ) {
					if ( 'collapse' === $this->nested_type ) {
						$this->add_class( 'collapse' );
					}
				}
				break;
			case 'tab':
				if ( $this->nested_type_depth === $this->depth ) {
					$this->add_class( array( 'tab-pane', 'fade' ) );
					$this->set_attr( 'role', 'tabpanel' );
				} elseif ( $this->nested_type_depth < $this->depth ) {
					if ( 'collapse' === $this->nested_type ) {
						$this->add_class( 'collapse' );
					}
				}
				break;
			case 'collapse':
				if ( $this->depth > 0 ) {
					$this->add_class( 'collapse' );
				}
				break;
		}

		if ( 0 < $this->depth ) {
			$this->add_class( array( 'sub-nav', 'level-' . ( $this->depth ) . '-menu' ) );
			if ( ! empty( $this->toggle_type ) ) {
				$this->set_attr( 'aria-labelledby', $this->get_attr( 'id' ) . '-btn' );
			}
		}

	}
}
