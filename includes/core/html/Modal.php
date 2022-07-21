<?php

/** ============================================================================
 * Modal
 *
 * @package   RWP\/includes/components/Modal.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Html;

use RWP\Helpers\Str;
use RWP\Vendor\Exceptions\Data\NotFoundException;

class Modal extends Element {
	/**
	 * @var string
	 */
	public $tag = 'div';

	/**
	 * The array of default attributes
	 * @var array
	 */
	public $atts = array(
		'tabindex'    => '-1',
		'aria-hidden' => 'true',
		'class'       => array(
			'modal',
		),
	);

	public $framework = 'bootstrap';

	public $id = '';

	/**
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'header' => 'Element',
		'body'   => 'Element',
		'footer' => 'Element',
		'close'  => 'Button',
		'dialog' => 'Element',
		'inner'  => 'Element',
	);

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */

	public $order = array( 'dialog' );

	/**
	 * @var array|string|Element $header The header content inner
	 */
	public $header = array(
		'order' => array( 'title', 'close' ),
		'tag'   => 'header',
		'atts'  => array(
			'class' => array(
				'modal-header',
			),
		),
	);

	/**
	 * @var array|string|Element $body The body content inner
	 */
	public $body = array(
		'tag'  => 'div',
		'atts' => array(
			'class' => array(
				'modal-body',
			),
		),
	);

	/**
	 * @var array|string|Element $footer The footer content inner
	 */
	public $footer = array(
		'tag'  => 'footer',
		'atts' => array(
			'class' => array(
				'modal-footer',
			),
		),
	);

	public $title;


	/**
	 * @var string[]|Button
	 */
	public $close = array(
		'tag'    => 'button',
		'toggle' => 'close',
	);

	/**
	 * @var string
	 */
	public $trigger = 'manual';

	/**
	 * @var (string|string[][])[]|Element
	 */
	public $dialog = array(
		'tag'   => 'div',
		'order' => array( 'inner' ),
		'atts'  => array(
			'class' => array(
				'modal-dialog',
			),
		),
	);

	/**
	 * @var (string|string[][])[]|Element
	 */
	public $inner = array(
		'tag'   => 'div',
		'order' => array( 'header', 'body', 'footer' ),
		'atts'  => array(
			'class' => array(
				'modal-content',
			),
		),
	);

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		parent::__construct( $args );

		if ( $this->content->isNotEmpty() ) {
			$this->body->content = $this->content;
			$this->content = rwp_collection();
		}

		switch ( $this->framework ) {
			case 'fancybox':
				# code...
				break;

			default:
				$this->bs_options( $args );
				break;
		}

		try {
			if ( ! empty( $this->id ) ) {
				$this->set_attr( 'id', $this->id );
			} elseif ( $this->has_attr( 'id' ) && ! empty( $this->get_attr( 'id' ) ) ) {
				$this->id = $this->get_attr( 'id' );
			} elseif ( ! empty( $this->title ) ) {
				$title = $this->title;
				if ( rwp_is_element( $title ) ) {
					$title = strip_tags( $title->html() );
				}
				$slug = rwp_change_case( $title );
				$this->id = $slug;
			} elseif ( $this->has_attr( 'id' ) && ! empty( $this->get_attr( 'id' ) ) ) {
				$this->id = $this->get_attr( 'id' );
			} else {
				$random = Str::random( 6 );
				$this->id = "modal-$random";
				throw new NotFoundException( 'There is no ID for this modal. All modals should have a unique ID' );
			}
		} catch ( NotFoundException $th ) {
			rwp_qm_log( $th->getMessage(), 'warning' );
		}

		if ( $this->has( 'title' ) && ! empty( $this->get( 'title' ) ) ) {
			$title = $this->get( 'title' );

			$this->add_title( $title );
		}
	}

	/**
	 * Set the card title
	 *
	 * @param Html|string|array|Element  $title  The title value
	 *
	 */
	public function add_title( $title ) {
		$defaults = array(
			'content'  => array(),
			'location' => 'header',
			'key'      => null,
			'tag'      => 'h5',
			'atts'     => array(
				'class' => array(
					'modal-title',
				),
			),
		);

		if ( is_string( $title ) && ! rwp_str_is_html( $title ) ) {
			$defaults['content'] = $title;
			$title = $defaults;
		}

		$title = new Element( $title );

		if ( ! empty( $this->id ) ) {
			$id = $this->id . '-label';
			$title->set_attr( 'id', $id );
			$this->set_attr( 'aria-labelledby', $id );
		}

		$title->merge_args( $defaults, false );

		$this->title = $title;
	}

	/**
	 * Set the modal body content
	 *
	 * @param Html|string|array|Element  $text  The text value
	 *
	 */
	public function add_text( $text ) {
		$defaults = array(
			'content'  => array(),
			'location' => 'header',
			'key'      => null,
		);

		if ( is_string( $text ) && ! rwp_str_is_html( $text ) ) {
			$defaults['content'] = $text;
			$text = $defaults;
		}

		$text = new Element( $text );

		$text->merge_args( $defaults, false );

		$location = data_get( $text, 'location', 'body' );

		$order = data_get( $text, 'key', 1 );

		$this->$location->set_order( 'text', $order );

		$this->$location->set_content( $text, $order );
	}

	public function bs_options( $args = array() ) {
		$defaults = array(
			'backdrop'   => true, // Includes a modal-backdrop element. Alternatively, specify static for a backdrop which doesn't close the modal on click.
			'scrollable' => false, // allows scroll the modal body
			'keyboard'   => true, // Closes the modal when escape key is pressed
			'focus'      => true, // Puts the focus on the modal when initialized.
			'centered'   => true, // vertically center the modal.
			'fade'       => true,
			'size'       => '',
			'fullscreen' => array(
				''    => false, // covers the user viewport always
				'sm'  => false, // covers the user viewport below 576px
				'md'  => false, // covers the user viewport below 768px
				'lg'  => false, // covers the user viewport below 992px
				'xl'  => false, // covers the user viewport below 1200px
				'xxl' => false, // covers the user viewport below 1400px
			),
		);

		$options = rwp_collection( rwp_merge_args( $defaults, $args ) );

		$classes = $options->except( array( 'backdrop', 'keyboard', 'focus', 'fullscreen', 'fade' ) )->filter(function ( $item ) {
			return ! empty( $item );
		})->keys()->transform(function ( $item ) use ( $options ) {
			switch ( $item ) {
				case 'scrollable':
					return 'modal-dialog-centered';
					break;

				case 'centered':
					return 'modal-dialog-scrollable';
					break;

				case 'size':
					$size = $options->get( 'size' );
					return "size-$size";
					break;

				default:
					return $item;
					break;
			}
		});

		$full_screen = rwp_collection( $options->get( 'fullscreen' ) );

		if ( is_array( $full_screen ) ) {
			$full_screen = rwp_collection( $full_screen )->filter(function ( $item ) {
				return ! empty( $item );
			})->keys()->transform(function ( $item ) {
				if ( ! empty( $item ) ) {
					$item = "-$item-down";
				}

				return "modal-fullscreen$item";
			});
		} elseif ( true === $full_screen ) {
			$full_screen = 'modal-fullscreen';
		}

		$classes = rwp_parse_classes( $classes, $full_screen );

		$this->dialog->add_class( $classes );

		if ( $options->get( 'fade' ) ) {
			$this->add_class( 'fade' );
		}

		$attributes = $options->only( array( 'backdrop', 'keyboard', 'focus' ) );
		$attribute_keys = $attributes->keys()->transform(function ( $item ) {
			return "data-bs-$item";
		});

		$attribute_values = $attributes->values()->transform(function ( $item ) {
			if ( is_bool( $item ) ) {
				return $item ? 'true' : 'false';
			} else {
				return $item;
			}
		});

		$attributes = $attribute_keys->combine( $attribute_values );

		$this->merge_atts( $attributes );
	}

	/**
	 * Setup card footer (or remove if empty)
	 *
	 * @return void
	 */
	public function setup_inner() {
		$sections = $this->inner->order;

		foreach ( $sections as $section ) {
			$section_item = $section;
			$section = $this->get( $section_item );
			$elements = $section->order;
			if ( ! empty( $elements ) ) {
				foreach ( $elements as $element ) {
					if ( is_string( $element ) && $this->has( $element ) ) {
						$section->set( $element, $this->$element, false );
					}
				}
			}
			$section->build();

			if ( ! $section->has_content() ) {
				$this->inner->remove_order_item( $section_item );
			} else {
				$this->inner->set( $section_item, $section, false );
			}
		}
	}

	public function setup_html() {

		$this->setup_inner();

		$inner = $this->inner->html();

		$this->dialog->set_content( $inner, 'inner' );

		$this->set_attr( 'id', $this->id, false );
	}
}
