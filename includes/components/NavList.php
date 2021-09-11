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
	 * @var mixed $wp_menu The associated nav menu
	 */

	public $wp_menu;

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
	 * @var string $parent The subnav parent id or the menu id if `$depth == 0`
	 */
	public $parent;

	/**
	 * @var string $child_type  The type of dropdown. Can be one of `
	 *                          collapse|dropdown|tabs|indented`
	 */
	public $child_type = 'collapse';

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

		switch ( $direction ) {
			case 'vertical':
				$this->add_class( 'flex-column' );
				break;
			default:
				$this->remove_class( 'flex-column' );
				break;
		}
	}
}
