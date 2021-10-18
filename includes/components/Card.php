<?php
/** ============================================================================
 * Card
 *
 * @package   RWP\/includes/components/Card.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

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

    public $order = array( 'header', 'image', 'body', 'footer' );

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
	 * @var mixed  $background  A background class, a css color, or an Image
	 *                          element
	 */
    public $background;

	/**
	 * @var string  $style  A card style. One of `vertical (default) | overlay | horizontal`
	 */
    public $style = 'vertical';


    public function __construct( $args = [] ) {

		$image = data_get( $args, 'image' );

		if ( $image ) {
			if ( is_string( $image ) || is_numeric( $image ) ) {
				$image_args = (array) $this->image;
				$image_args['src'] = $image;
				$args['image'] = $image_args;
			}
		}

        parent::__construct( $args );

		$elements = array(
			'header',
			'image',
			'body',
			'footer',
		);

		foreach ( $elements as $element ) {
			switch ( $element ) {
				case 'image':
					$this->$element = new Image( $this->$element );
					break;
				default:
					$this->$element = new Element( $this->$element );
					break;
			}
		}

		if ( $this->content->isNotEmpty() ) {
			$content = $this->content;
            $content->transform( function( $item ) {
				if ( is_string( $item ) ) {
					$item = rwp_html( $item );
				}
				if ( is_array( $item ) ) {
					$item = new Element( $item );
				}
				if ( $item instanceof Element ) {
					$item = $item->html;
				}

				/**
				 * @var Html $html
				 */
				$html = $item;

				$html->filter( 'p' )->addClass( 'card-text' );
				$html->filter( 'h1,h2,h3,h4,h5,h6' )->addClass( 'card-title' );
				$html->filter( 'a:not(.btn)' )->addClass( 'card-link' );

				return $html->saveHtml();
			} );
			$this->body->content = $content;
            $this->content = new Collection();
        }

		if ( $this->has( 'title' ) ) {
			$title = $this->get( 'title' );

			$this->add_title( $title );

			$this->remove( 'title' );

		}

		if ( $this->has( 'subtitle' ) ) {
			$subtitle = $this->get( 'subtitle' );

			$this->add_subtitle( $subtitle );

			$this->remove( 'subtitle' );

		}

		if ( $this->has( 'text' ) ) {
			$text = $this->get( 'text' );

			$this->add_text( $text );

			$this->remove( 'text' );

		}

		if ( $this->has( 'links' ) ) {
			$links = $this->get( 'links' );

			$this->add_link( $links );

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
	public function add_text( $text ) {

        $defaults = array(
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

		if ( $text instanceof Html ) {
			$text = $text->saveHTML();
		}

		if ( is_string( $text ) ) {
			if ( rwp_string_is_html( $text ) ) {
				$text = rwp_extract_html_attributes( $text, '', true, true );
			} else {
				$text = array(
					'content' => $text,
				);
			}
		}

		if ( is_array( $text ) ) {
			$text = rwp_merge_args( $defaults, $text );
		}

		$text = new Element( $text );

		if ( $text instanceof Element ) {
			$text->add_class( 'card-text' );
		}

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
	 * @param Html|string|array|Element  $title  The title value
	 *
	 */
	public function add_title( $title ) {
        $defaults = array(
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

		if ( $title instanceof Html ) {
			$title = $title->saveHTML();
		}

		if ( is_string( $title ) ) {
			if ( rwp_string_is_html( $title ) ) {
				$title = rwp_extract_html_attributes( $title, '', true, true );
			} else {
				$title = array(
					'content' => $title,
				);
			}
		}

		if ( is_array( $title ) ) {
			$title = rwp_merge_args( $defaults, $title );
		}

		$title = new Element( $title );

		if ( $title instanceof Element ) {
			$title->add_class( 'card-title' );
		}

		$location = data_get( $title, 'location', 'body' );

		$order = data_get( $title, 'key', 1 );

		$title = $title->html();

		$this->$location->set_content( $title, $order );
    }

	/**
	 * Set the card title
	 *
	 * @param Html|string|array|Element  $title  The title value
	 *
	 */
	public function add_subtitle( $title ) {
        $defaults = array(
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

		if ( $title instanceof Html ) {
			$title = $title->saveHTML();
		}

		if ( is_string( $title ) ) {
			if ( rwp_string_is_html( $title ) ) {
				$title = rwp_extract_html_attributes( $title, '', true, true );
			} else {
				$title = array(
					'content' => $title,
				);
			}
		}

		if ( is_array( $title ) ) {
			$title = rwp_merge_args( $defaults, $title );
		}

		$title = new Element( $title );

		if ( $title instanceof Element ) {
			$title->add_class( 'card-title' );
		}

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

        $defaults = array(
			'content' => array(),
			'location' => 'body',
			'key' => null,
			'tag' => 'a',
			'is_btn' => false,
		);

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

		$is_btn = data_get( $defaults, 'is_btn', false );
		$href = data_get( $defaults, 'link', '' );
		$text = data_get( $defaults, 'text', '' );
		$location = data_get( $defaults, 'location', 'body' );
		$order = data_get( $defaults, 'key', 4 );

		if ( $link instanceof Html ) {
			if ( $link->filter( 'a' )->hasClass( 'btn' ) ) {
				$is_btn = true;
			}
			$link = $link->saveHTML();
		}

		if ( is_string( $link ) ) {

			if ( rwp_string_is_html( $link ) ) {
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
			if ( ! $this->header->has_content() ) {
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
			if ( ! $this->image->has( 'src' ) || empty( $this->image->get( 'src' ) ) ) {
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
			if ( ! $this->body->has_content() ) {
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
	 * Setup card footer (or remove if empty)
	 *
	 * @return void
	 */
	public function setup_footer() {
		if ( in_array( 'footer', $this->order, true ) ) {
			if ( ! $this->footer->has_content() ) {
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
		$this->setup_footer();

		self::add_background( $this->background, $this );
	}
}
