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
     * @var false|string $has_toggle The toggle type or false
     */
    public $has_toggle = 'collapse';

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

		if ( $this->has_link ) {
			if ( ! array_search( 'link', $this->order ) ) {
				$this->order[] = 'link';
			}
		}

		if ( $this->is_parent && false !== $this->has_toggle ) {
			$this->set( 'toggle.toggle', $this->has_toggle );
			$this->toggle = new Button( $this->toggle );
			if ( ! array_search( 'toggle', $this->order ) ) {
				$this->order[] = 'toggle';
			}
		}
	}
}
