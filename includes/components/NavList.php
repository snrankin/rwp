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

class NavList extends HtmlList {

	/**
	 * @var array $atts
	 */
	public $atts = array(
        'class'     => array(
            'nav',
		),
		'role' => 'menu',
	);

	/**
	 * @var string The class to map all sub-elements into
	 */

	public $item_type = 'NavItem';

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
	 * @return void
	 */
	public function __construct( $args = array() ) {

		parent::__construct( $args );

		$type      = $this->type;
		$direction = $this->direction;

		switch ( $type ) {
			case 'tabs':
			case 'pills':
				$this->add_class( "nav-$type" );
				$this->set_attr( 'role', 'tablist', true );
				break;
		}

		$this->set_attr( 'aria-orientation', $direction, true );
	}

	public function setup_html() {

		if ( ! $this->has_wrapper ) {
			switch ( $this->toggle_type ) {
				case 'dropdown':
					if ( $this->nested_type_depth === $this->depth ) {
						$this->add_class( 'dropdown-menu' );
						$this->remove_class( 'nav' );
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
}
