<?php

/** ============================================================================
 * Button
 *
 * @package   RWP\Html
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Html;

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
		'class' => array(
			'btn',
		),
	);

	/**
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'text' => 'Element',
		'icon' => 'Icon',
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
	 * @var bool $open Whether or not the item is currently open
	 */
	public $open = false;

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
		'tag'  => 'span',
		'atts' => array(
			'class' => array(
				'btn-text',
			),
		),
	);

	/**
	 * @var (string|string[][])[]|Element $icon The button icon
	 */

	public $icon = array(
		'tag'  => 'span',
		'atts' => array(
			'class' => array(
				'btn-icon',
			),
		),
	);

	/**
	 * @var mixed $icon_opened Icon that displays when the toggle target is open.
	 */

	public $icon_opened = array(
		'tag'  => 'span',
		'atts' => array(
			'class' => array(
				'icon-opened',
			),
		),
	);

	/**
	 * @var mixed $icon_closed Icon that displays when the toggle target is
	 *                         closed.
	 */

	public $icon_closed = array(
		'tag'  => 'span',
		'atts' => array(
			'class' => array(
				'icon-closed',
			),
		),
	);

	public function __construct( $args = [] ) {

		$text = data_get( $args, 'text', '' );

		if ( is_string( $text ) && ! rwp_str_is_html( $text ) && filled( $text ) ) {
			$args['text'] = array(
				'content' => $text,
			);
		}

		parent::__construct( $args );

		$href = $this->get_attr( 'href' );

		if ( ! empty( $href ) ) {
			$this->set( 'link', $href, false );
		} elseif ( ! blank( $this->link ) && rwp_is_url( $this->link ) ) {
			$this->set_attr( 'href', $this->link, false );
		}

		if ( $this->content->isNotEmpty() ) {
			$this->content->reject(function ( $item ) {
				if ( is_string( $item ) ) {
					if ( rwp_str_is_html( $item ) ) {
						if ( rwp_str_is_element( $item, 'i|svg|img' ) ) {
							$this->set_icon( $item );
							return true;
						} else {
							$this->set_text( $item );
							return true;
						}
					} else {
						$this->set_text( $item );
						return true;
					}
				}
				if ( $item instanceof Icon ) {
					$this->set_icon( $item );
					return true;
				}

				return false;
			});
		}

		if ( $this->filled( 'toggle' ) ) {

			if ( $this->filled( 'icon_opened' ) ) {
				if ( ! ( $this->icon_opened instanceof Icon ) ) {
					$this->icon_opened = new Icon( $this->icon_opened );
				}
				$this->icon_opened->add_class( 'icon-opened' );
			}

			if ( $this->filled( 'icon_closed' ) ) {
				if ( ! ( $this->icon_closed instanceof Icon ) ) {
					$this->icon_closed = new Icon( $this->icon_closed );
				}
				$this->icon_closed->add_class( 'icon-closed' );
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
				$this->set_toggle_icons();
				break;
			case 'tab':
				$this->set_attr( 'data-bs-toggle', $toggle );
				$this->set_attr( 'data-bs-target', $link );
				$this->set_attr( 'aria-controls', $target );
				$this->set_attr( 'role', 'tab' );
				if ( $this->open ) {
					$this->set_attr( 'aria-selected', 'true' );
				} else {
					$this->set_attr( 'aria-selected', 'false' );
				}

				$this->set_toggle_icons();
				break;
			case 'collapse':
				$this->set_attr( 'data-bs-toggle', $toggle );
				$this->set_attr( 'data-bs-target', $link );
				$this->set_attr( 'aria-controls', $target );
				if ( $this->open ) {
					$this->set_attr( 'aria-expanded', 'true' );
				} else {
					$this->set_attr( 'aria-expanded', 'false' );
				}
				$this->set_toggle_icons();
				break;
			case 'offcanvas':
			case 'modal':
				$this->set_attr( 'data-bs-toggle', $toggle );
				$this->set_attr( 'data-bs-target', $link );
				$this->set_attr( 'aria-controls', $target );
				$this->set_toggle_icons();
				break;
			case 'close':
				$this->set_attr( 'data-bs-dismiss', 'modal' );
				$this->add_class( 'btn-close' );
				$this->set_attr( 'aria-label', __( 'Close', 'rwp' ) );
				break;
		}
	}

	public function set_toggle_icons() {
		if ( $this->filled_element( 'icon_opened' ) ) {
			$this->icon->set_content( $this->icon_opened, 'opened', true );
		}

		if ( $this->filled_element( 'icon_closed' ) ) {
			if ( ! $this->filled_element( 'icon_opened' ) ) {
				$this->icon_closed->remove_class( 'icon-closed' );
				$this->icon->merge_args( $this->icon_closed );
			} else {
				$this->icon->set_content( $this->icon_closed, 'closed', true );
			}
		}
	}

	/**
	 * Set the button icon
	 * @param mixed $args
	 * @param string $key
	 * @param bool $overwrite
	 * @return void
	 */
	public function set_icon( $args, $overwrite = true ) {
		if ( ! ( $this->icon instanceof Element ) ) {
			$this->icon = new Element( $this->icon );
		}
		$this->icon->merge_args( $args, $overwrite );
	}

	/**
	 * Set button text
	 *
	 * @param array|string $args
	 * @return void
	 */
	public function set_text( $args, $overwrite = true ) {
		if ( ! ( $this->text instanceof Element ) ) {
			$this->text = new Element( $this->text );
		}
		$this->text->merge_args( $args, $overwrite );
	}


	public function setup_html() {
		if ( ! blank( $this->toggle ) ) {
			$this->toggle_atts();
		} else {
			if ( $this->has_attr( 'href' ) && rwp_is_url( $this->get_attr( 'href' ) ) ) {
				$this->set_tag( 'a' );
			} elseif ( rwp_is_url( $this->link ) ) {
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

		if ( in_array( 'icon', $this->order ) ) {
			if ( ! $this->filled_element( 'icon' ) ) {
				$this->remove_order_item( 'icon' );
				$this->remove_content( 'icon' );
			}
		} elseif ( $this->filled_element( 'icon' ) ) {
			$this->set_order( 'icon', 'last' );
		}

		if ( in_array( 'text', $this->order ) ) {
			if ( ! $this->filled_element( 'text' ) ) {
				$this->remove_order_item( 'text' );
				$this->remove_content( 'text' );
			}
		} elseif ( $this->filled_element( 'text' ) ) {
			$this->set_order( 'text', 'last' );
		}

		if ( in_array( 'text', $this->order, true ) && in_array( 'icon', $this->order, true ) ) {

			$icon_order = array_search( 'icon', $this->order );

			$text_order = array_search( 'text', $this->order );

			if ( $icon_order < $text_order ) {
				$this->icon->add_class( 'icon-left' );
			} else {
				$this->icon->add_class( 'icon-right' );
			}
		}
	}
}
