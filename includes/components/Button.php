<?php

/** ============================================================================
 * Button
 *
 * @package   RWP\Components
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

class Button extends Element {
	/**
	 * @var string
	 */
	public $tag = 'button';

	/**
	 * The array of default attributes
	 * @var array
	 */
	public $atts = array(
		'class' => 'btn',
	);

	/**
	 * @var bool $active Whether or not the item is currently active
	 */
	public $active = false;

	/**
	 * @var bool $disabled Whether or not the item is currently disabled
	 */
	public $disabled = false;

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */

	public $order = array( 'text' );

	/**
	 * @var string $link The url or id of the toggle target
	 */

	public $link;

	/**
	 * @var string $toggle The type of toggle. Can be one of
	 *                     `dropdown|collapse|tabs|modal|close'
	 */

	public $toggle;

	/**
	 * @var (string|string[][])[]|Element $text The button text
	 */

	public $text = array(
		'tag' => 'span',
		'atts' => array(
			'class'     => array(
				'btn-text',
			),
		),
	);

	/**
	 * @var (string|string[][])[]|Element $icon The button icon
	 */

	public $icon = array(
		'tag' => 'span',
		'atts' => array(
			'class'     => array(
				'btn-icon',
			),
		),
	);

	/**
	 * @var mixed $icon_opened Icon that displays when the toggle target is open.
	 */

	public $icon_opened = array(
		'content' => '−',
		'atts' => array(
			'class'     => array(
				'icon-opened',
			),
		),
	);

	/**
	 * @var mixed $icon_closed Icon that displays when the toggle target is
	 *                         closed.
	 */

	public $icon_closed = array(
		'content' => '+',
		'atts' => array(
			'class'     => array(
				'icon-closed',
			),
		),
	);

	public function __construct( $args = [] ) {

		$this->text = new Element( $this->text );
		$this->icon = new Element( $this->icon );

		if ( ! empty( $args['text'] ) ) {
			$this->set_text( $args['text'] );
			unset( $args['text'] );
		}

		if ( ! empty( $args['icon'] ) ) {
			$this->set_icon( $args['icon'] );
			unset( $args['icon'] );
		}

		parent::__construct( $args );

		$href = $this->get_attr( 'href' );

		if ( ! empty( $href ) ) {
			$this->set( 'link', $href, false );
		} elseif ( ! blank( $this->link ) && rwp_is_url( $this->link ) ) {
			$this->set_attr( 'href', $this->link, false );
		}

		if ( ! blank( $this->toggle ) ) {

			if ( ! blank( $this->icon_opened ) ) {
				$this->icon_opened = new Icon( $this->icon_opened );
			}

			if ( ! blank( $this->icon_closed ) ) {
				$this->icon_closed = new Icon( $this->icon_closed );
			}
		}
	}

	public function toggle_atts() {

		$target = false;
		$link = $this->link;
		$toggle = $this->toggle;

		if ( rwp_str_starts_with( $link, '#' ) ) {
			$target = rwp_remove_prefix( $link, '#' );
			$this->set_attr( 'id', $target . '-btn' );
		}

		$this->add_class( 'btn-toggle' );
		$this->add_class( "$toggle-toggle" );

		switch ( $toggle ) {
			case 'dropdown':
				$this->set_attr( 'data-bs-toggle', $toggle );
				$this->set_attr( 'aria-haspopup', 'true' );
				$this->set_attr( 'aria-expanded', 'false' );
				break;
			case 'tab':
			case 'pill':
				$this->set_attr( 'href', $link );
				$this->set_attr( 'aria-controls', $target );
				$this->set_attr( 'role', 'tab' );
				$this->set_attr( 'aria-selected', 'false' );

				break;
			case 'collapse':
				$this->set_attr( 'data-bs-toggle', $toggle );
				$this->set_attr( 'data-bs-target', $link );
				$this->set_attr( 'aria-controls', $target );
				$this->set_attr( 'aria-expanded', 'false' );
				break;
			case 'modal':
				$this->set_attr( 'data-bs-toggle', $toggle );
				$this->set_attr( 'data-bs-target', $link );
				break;
			case 'close':
				$this->set_attr( 'data-bs-dismiss', 'modal' );
				$this->add_class( 'close' );
				$this->set_attr( 'aria-label', __( 'Close', 'rwp' ) );
				break;
		}
	}

	/**
	 * Set the button icon
	 * @param mixed $args
	 * @param string $key
	 * @param bool $overwrite
	 * @return void
	 */
	public function set_icon( $args, $key = '', $overwrite = true ) {

		$icon = new Icon( $args );

		$icon->add_class( 'btn-icon' );

		$this->icon->set_content( $icon, $key, $overwrite );
	}

	/**
	 * Set button text
	 *
	 * @param array|string $args
	 * @return void
	 */
	public function set_text( $args, $key = '', $overwrite = true ) {

		$text = $this->text->toArray();

		if ( is_array( $args ) ) {
			$text = rwp_merge_args( $text, $args );

			$this->text = new Element( $text );
		} else if ( is_string( $args ) ) {
			$this->text->set_content( $args, $key, $overwrite );
		}
	}


	public function setup_html() {
		if ( ! blank( $this->toggle ) ) {
			$this->toggle_atts();
		} else {
			if ( ( $this->has_attr( 'href' ) && rwp_is_url( $this->get_attr( 'href' ) ) ) || rwp_is_url( $this->link ) ) {
				$this->set_tag( 'a' );
			} else {
				$this->set_tag( 'button' );
				$this->remove_attr( 'href' );
			}
		}
		if ( $this->disabled ) {
			$this->add_class( 'disabled' );
			$this->set_attr( 'aria-disabled', 'true' );
			$this->set_attr( 'tabindex', '-1' );
		}

		if ( $this->active ) {
			$this->add_class( 'active' );
		}

		if ( 'a' === $this->tag ) {
			$this->set_attr( 'role', 'button' );
		}

		if ( 'button' === $this->tag ) {
			$this->set_attr( 'type', 'button' );
		}

		if ( $this->icon_opened instanceof Icon ) {
			$this->icon->set_content( $this->icon_opened, 'opened', true );
		}

		if ( $this->icon_closed instanceof Icon ) {
			$this->icon->set_content( $this->icon_closed, 'closed', true );
		}

		if ( $this->icon->has_content() ) {
			if ( ! in_array( 'icon', $this->order ) ) {
				$this->set_order( 'icon', 1 );
			}
		}

		$icon_order = array_search( 'icon', $this->order );

		$text_order = array_search( 'text', $this->order );

		if ( $icon_order < $text_order ) {
			$this->icon->add_class( 'icon-left' );
		} else {
			$this->icon->add_class( 'icon-right' );
		}
	}
}
