<?php

/** ============================================================================
 * Card
 *
 * @package   RWP\/includes/components/Card.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Components\Collection;

class Card extends Element {

	/**
	 * @var string $tag The html element tag
	 */
	public $tag = 'div';

	/**
	 * @var Collection|array $atts The collection of atts
	 */
	public $atts = array(
		'class' => array(
			'card',
		),
	);

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */

	public $order = array( 'header', 'image', 'body', 'list', 'footer' );

	/**
	 * @var string  $style  A card style. One of `vertical (default) | overlay | horizontal`
	 */
	public $style = 'vertical';

	/**
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'header' => 'Element',
		'image'  => 'Image',
		'body'   => 'Element',
		'list'   => 'HtmlList',
		'footer' => 'Element',
	);

	/**
	 * @var array|string|Element $header The header content wrapper
	 */
	public $header = array(
		'tag' => 'header',
		'atts' => array(
			'class' => array(
				'card-header',
			),
		),
	);

	/**
	 * @var mixed $image The image content wrapper
	 */
	public $image = array(
		'size' => 'medium',
		'atts' => array(
			'class' => array(
				'card-img',
			),
		),
	);

	/**
	 * @var array|string|Element $body The body content wrapper
	 */
	public $body = array(
		'tag' => 'div',
		'atts' => array(
			'class' => array(
				'card-body',
			),
		),
	);

	/**
	 * @var array|string|HtmlList $list The list content wrapper
	 */
	public $list = array(
		'tag' => 'ul',
		'atts' => array(
			'class' => array(
				'card-list',
				'list-group',
				'list-group-flush',
			),
		),
		'item_atts' => array(
			'atts' => array(
				'class' => array(
					'list-group-item',
				),
			),
		),
	);

	/**
	 * @var array|string|Element $footer The footer content wrapper
	 */
	public $footer = array(
		'tag' => 'footer',
		'atts' => array(
			'class' => array(
				'card-footer',
			),
		),
	);

	/**
	 * @var array $text_args The footer content wrapper
	 */
	public $text_args = array(
		'content' => array(),
		'location' => 'body',
		'key' => null,
		'tag' => 'p',
		'atts' => array(
			'class' => array(
				'card-text',
			),
		),
	);

	/**
	 * @var array $title_args The footer content wrapper
	 */
	public $title_args = array(
		'content' => array(),
		'location' => 'body',
		'key' => null,
		'tag' => 'h3',
		'atts' => array(
			'class' => array(
				'card-title',
			),
		),
	);

	/**
	 * @var array $subtitle_args The footer content wrapper
	 */
	public $subtitle_args = array(
		'content' => array(),
		'location' => 'body',
		'key' => null,
		'tag' => 'h4',
		'atts' => array(
			'class' => array(
				'card-subtitle',
			),
		),
	);

	/**
	 * @var array $link_args The footer content wrapper
	 */
	public $link_args = array(
		'content'  => array(),
		'location' => 'body',
		'key'      => null,
		'tag'      => 'a',
		'is_btn'   => false,
	);


	public function __construct( $args = [] ) {

		$this->image['size'] = apply_filters( 'rwp_card_image_size', 'medium' ); // Adjust size for post card images globally

		parent::__construct( $args );

		if ( $this->content->isNotEmpty() ) {
			$this->content->reject( function ( $item ) {
				if ( is_string( $item ) ) {
					$item = rwp_html( $item );
				} else if ( is_array( $item ) ) {
					$item = new Element( $item );
					$item = $item->html;
				} else if ( $item instanceof Element ) {
					$item = $item->html;
				} else if ( $item instanceof Html ) {
					$item = $item->html;
				}

				if ( rwp_is_component( $item, 'Html' ) ) {
					/**
					 * @var Html $html
					 */
					$html = $item;

					$text = rwp_extract_html_elements( $html, 'p', true );

					if ( ! empty( $text ) ) {
						foreach ( $text as $node ) {
							$this->add_text( $node );
						}
					}

					$title = rwp_extract_html_elements( $html, 'h1,h2,h3', true );

					if ( ! empty( $title ) ) {
						foreach ( $title as $node ) {
							$this->add_title( $node );
						}
					}

					$subtitle = rwp_extract_html_elements( $html, 'h4,h5,h6', true );

					if ( ! empty( $subtitle ) ) {
						foreach ( $subtitle as $node ) {
							$this->add_subtitle( $node );
						}
					}

					$link = rwp_extract_html_elements( $html, 'a:not(.btn)', true );

					if ( ! empty( $link ) ) {
						foreach ( $link as $node ) {
							$this->add_link( $node );
						}
					}

					return true;
				} else {
					return false;
				}
			});
		}

		if ( $this->has( 'title' ) && ! empty( $this->get( 'title' ) ) ) {
			$title = $this->get( 'title' );

			$this->add_title( $title );

			$this->remove( 'title' );
		}

		if ( $this->has( 'subtitle' ) && ! empty( $this->get( 'subtitle' ) ) ) {
			$subtitle = $this->get( 'subtitle' );

			$this->add_subtitle( $subtitle );

			$this->remove( 'subtitle' );
		}

		if ( $this->has( 'text' ) && ! empty( $this->get( 'text' ) ) ) {
			$text = $this->get( 'text' );

			$this->add_text( $text );

			$this->remove( 'text' );
		}

		if ( $this->has( 'links' ) && ! empty( $this->get( 'links' ) ) ) {
			$links = $this->get( 'links' );

			if ( wp_is_numeric_array( $links ) ) {
				foreach ( $links as $link ) {
					$this->add_link( $link );
				}
			} else {
				$this->add_link( $links );
			}

			$this->remove( 'links' );
		}
	}

	/**
	 * Add text to card
	 *
	 * @param Html|string|array|Element  $text  The text value
	 *
	 * @return void
	 */
	public function add_text( $text_args ) {

		$text = new Element( $this->text_args );

		$text->merge_args( $text_args, true );

		$location = data_get( $text, 'location', 'body' );

		$order = data_get( $text, 'key', 3 );

		if ( $order >= 3 ) { // Making sure additional content is added at the end of the content array
			$content_count = $this->$location->content->count();

			$order = $content_count + $order;
		}

		$text = $text->html();

		$this->$location->set_content( $text, $order );
	}

	/**
	 * Set the card title
	 *
	 * @param Html|string|array|Element  $title_args  The title value
	 *
	 */
	public function add_title( $title_args ) {

		$title = new Element( $this->title_args );

		$title->merge_args( $title_args, true );

		$location = data_get( $title, 'location', 'body' );

		$order = data_get( $title, 'key', 1 );

		$title = $title->html();

		$this->$location->set_content( $title, $order );
	}

	/**
	 * Set the card subtitle
	 *
	 * @param Html|string|array|Element  $title_args  The subtitle value
	 *
	 */
	public function add_subtitle( $title_args ) {
		$title = new Element( $this->title_args );

		$title->merge_args( $title_args, true );

		$location = data_get( $title, 'location', 'body' );

		$order = data_get( $title, 'key', 2 );

		$title = $title->html();

		$this->$location->set_content( $title, $order );
	}

	/**
	 * Add a link to a card
	 *
	 * @param Html|string|array|Element  $link
	 *
	 * @return void
	 */
	public function add_link( $link ) {

		$defaults = $this->link_args;

		if ( is_array( $link ) ) {
			if ( wp_is_numeric_array( $link ) ) {
				$links = $link;
				foreach ( $links as $link ) {
					$this->add_link( $link );
				}
			} else {
				$defaults = rwp_merge_args( $defaults, $link );
				$link = $defaults;
			}
		}

		$is_btn   = data_get( $defaults, 'is_btn', false );
		$href     = data_get( $defaults, 'link', '' );
		$text     = data_get( $defaults, 'text', '' );
		$location = data_get( $defaults, 'location', 'body' );
		$order    = data_get( $defaults, 'key', 4 );

		if ( $link instanceof Html ) {
			if ( $link->filter( 'a' )->hasClass( 'btn' ) ) {
				$is_btn = true;
			}
			$link = $link->saveHTML();
		}

		if ( is_string( $link ) ) {

			if ( rwp_str_is_html( $link ) ) {
				$html = rwp_html( $link );
				if ( $html->filter( 'a' )->hasClass( 'btn' ) ) {
					$is_btn = true;
				}
				$link = rwp_extract_html_attributes( $link, '', true, true );
			}
		}

		if ( $is_btn ) {
			$link = new Button( $link );
			$link->set_attr( 'href', $href );
			$link->text->set_content( $text, 0 );
		} else {
			$link = new Element( $link );
			$link->add_class( 'card-link' );
			$link->set_attr( 'href', $href );
			$link->set_content( $text, 0 );
		}

		if ( ( $link->has_attr( 'href' ) && ! empty( $link->get_attr( 'href' ) ) && 'a' === $link->tag ) || ( 'button' === $link->tag ) ) {
			$link = $link->html();

			if ( $order >= 4 ) { // Making sure additional content is added at the end of the content array
				$content_count = $this->$location->content->count();

				$order = $content_count + $order;
			}

			$this->$location->set_content( $link, $order );
		}
	}

	/**
	 * Setup card header (or remove if empty)
	 *
	 * @return void
	 */
	public function setup_header() {
		if ( in_array( 'header', $this->order, true ) ) {
			if ( ! $this->filled_element( 'header' ) ) {
				$this->remove_order_item( 'header' );
			} else {
				if ( empty( $this->header->order ) ) {
					$order = array_values( $this->header->content->keys()->sort()->all() );

					$this->header->order = $order;
				}
			}
		}
	}

	/**
	 * Setup card image (or remove if empty)
	 *
	 * @return void
	 */
	public function setup_image() {
		if ( in_array( 'image', $this->order, true ) ) {

			if ( ! $this->filled_element( 'image' ) ) {
				$this->remove_order_item( 'image' );
			}
		}
	}

	/**
	 * Setup card body (or remove if empty)
	 *
	 * @return void
	 */
	public function setup_body() {
		if ( in_array( 'body', $this->order, true ) ) {
			if ( ! $this->filled_element( 'body' ) ) {
				$this->remove_order_item( 'body' );
			} else {
				if ( empty( $this->body->order ) ) {
					$order = array_values( $this->body->content->keys()->sort()->all() );

					$this->body->order = $order;
				}
			}
		}
	}

	/**
	 * Setup card list (or remove if empty)
	 *
	 * @return void
	 */
	public function setup_list() {
		if ( in_array( 'list', $this->order, true ) ) {
			if ( ! $this->filled_element( 'list' ) ) {
				$this->remove_order_item( 'list' );
			}
		}
	}

	/**
	 * Setup card footer (or remove if empty)
	 *
	 * @return void
	 */
	public function setup_footer() {
		if ( in_array( 'footer', $this->order, true ) ) {
			if ( ! $this->filled_element( 'footer' ) ) {
				$this->remove_order_item( 'footer' );
			} else {
				if ( empty( $this->footer->order ) ) {
					$order = array_values( $this->footer->content->keys()->sort()->all() );

					$this->footer->order = $order;
				}
			}
		}
	}

	public function setup_html() {
		$this->setup_header();
		$this->setup_image();
		$this->setup_body();
		$this->setup_list();
		$this->setup_footer();
	}
}
