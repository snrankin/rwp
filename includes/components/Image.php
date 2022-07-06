<?php

/** ============================================================================
 * Image
 *
 * @package   RWP\Components
 *
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Exceptions\Data\FormatException;

class Image extends Element {

	public $order = array( 'inner' );

	/**
	 * @var string
	 */
	public $tag = 'figure';

	/**
	 * @var bool[] $lazysizes Enable/disable lazysizes features
	 */
	public $lazysizes = array(
		'lazyload'  => false,
		'noscript'  => false,
		'blurup'    => false,
		'parentfit' => false,
		'artdirect' => false,
	);


	/**
	 * @var int|string $src The attachement id to use or the url of an external item.
	 */
	public $src;

	/**
	 * @var int $id The attachement id
	 */
	public $id;

	/**
	 * @var bool|string $is_bg Whether or not the item is background media and the background type.
	 */
	public $is_bg = false;

	/**
	 * @var string $fit How the image should fill the container
	 */
	public $fit = 'contain';

	/**
	 * @var string $size The WordPress image size
	 */

	public $size = 'full';

	/**
	 * @var string $ratio The aspect ratio (i.e; 16x9)
	 */
	public $ratio = '';

	/**
	 * @var string|bool $zoom Add lightbox feature
	 */
	public $zoom = false;

	/**
	 * @var array $srcset The array of sources for responsive image display
	 */
	public $srcset = array();

	/**
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array(
		'link'    => 'Element',
		'inner'   => 'Element',
		'title'   => 'Element',
		'caption' => 'Element',
		'image'   => 'Element',
	);

	/**
	 * @var string|array|Element $link Image Link options
	 */
	public $link = array(
		'tag' => 'a',
		'order' => array( 'inner' ),
		'atts' => array(
			'class' => array(
				'media-link',
			),
		),
	);

	/**
	 * @var string|array|Element $inner Inner wrapper options
	 */
	public $inner = array(
		'tag' => 'picture',
		'order' => array( 'sources', 'image' ),
		'atts' => array(
			'class' => array(
				'media-content',
			),
		),
	);

	/**
	 * @var string|array|Element $title Title options
	 */
	public $title = array(
		'tag' => 'h3',
		'atts' => array(
			'class' => array(
				'media-title',
			),
		),
	);

	/**
	 * @var string|array|Element $caption Caption options
	 */
	public $caption = array(
		'tag' => 'figcaption',
		'atts' => array(
			'class' => array(
				'media-caption',
				'figure-caption',
			),
		),
	);

	/**
	 * @var string|array|Element $image The image content
	 */
	public $image = array(
		'tag' => 'img',
		'atts' => array(
			'class' => array(
				'media-src',
				'media-image',
			),
		),
	);

	/**
	 * The array of default attributes
	 * @var array
	 */

	public $atts = array(
		'class' => array(
			'media-wrapper',
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

		/**
		 * Set defaults from plugin options
		 */

		$this->lazysizes = array(
			'lazyload'  => rwp_get_option( 'modules.lazysizes.lazyload', false ),
			'noscript'  => rwp_get_option( 'modules.lazysizes.noscript', false ),
			'blurup'    => rwp_get_option( 'modules.lazysizes.blurup', false ),
			'fadein'    => rwp_get_option( 'modules.lazysizes.fadein', false ),
			'custommedia' => rwp_get_option( 'modules.lazysizes.custommedia', false ),
			'artdirect' => rwp_get_option( 'modules.lazysizes.artdirect', false ),
		);

		$src  = '';
		$size = data_get( $args, 'size', 'full' );
		$html = '';
		$id   = 0;
		$defaults = array();

		if ( ! empty( $args ) ) {

			if ( rwp_str_is_html( $args ) ) {
				$html = $args;
				$id = rwp_image_id( $args );
				$src = rwp_extract_img_src( $args, $size );
			} else if ( is_numeric( $args ) ) {
				//$html = wp_get_attachment_image( $id, $size );
				$id = $args;
				$src = rwp_extract_img_src( $args, $size );
			} else if ( rwp_is_class( $args, 'Element' ) ) {

				/**
				 * @var Element $args
				 */
				$html = $args->html();
				$id = rwp_image_id( $args );
				$src = rwp_extract_img_src( $args, $size );

			} else if ( rwp_is_class( $args, 'Html' ) ) {
				/**
				 * @var Html $args
				 */
				$html = $args->__toString();
				$id = rwp_image_id( $args );
				$src = rwp_extract_img_src( $args, $size );
			} else {
				$src  = data_get( $args, 'src', $src );
				$size = data_get( $args, 'size', $size );
				$html = data_get( $args, 'html', $html );
				$id   = data_get( $args, 'id', $id );
				if ( empty( $id ) ) {
					$id   = rwp_image_id( $src );
				}
			}
		} else {
			if ( ! is_array( $args ) ) {
				$args = array();
			}
		}

		if ( ! empty( $id ) ) {
			$html = wp_get_attachment_image( $id, $size );
			$defaults = rwp_extract_html_attributes( $html );
			$image_args = data_get( $args, 'image', array() );
			$image_args = rwp_merge_args( $defaults, $image_args );
			$args['image'] = $image_args;
		}

		$args['src'] = $src;
		$args['size'] = $size;
		$args['id'] = $id;

		if ( rwp_str_is_element( $html, 'div|figure' ) ) {
			$args['html'] = $html;
		} else if ( rwp_str_is_element( $html, 'img|svg' ) ) {
			$args['image']['html'] = $html;
		}

		if ( rwp_array_has( 'link', $args ) ) {
			$link = data_get( $args, 'link' );
			if ( filled( $link ) ) {
				$this->set_order( 'link', 'first' );
				$this->remove_order_item( 'inner' );
				if ( is_string( $link ) && rwp_is_url( $link ) ) {
					$args = data_set( $args, 'link.atts.href', $link );
				}
			}
		}

		parent::__construct( $args );

	}

	/**
	 * Add lazysizes to an image
	 *
	 * @param mixed $image
	 * @return Element
	 */

	public static function add_lazysizes( $image = '' ) {

		$lazysizes = array(
			'lazyload'  => rwp_get_option( 'modules.lazysizes.lazyload', false ),
			'noscript'  => rwp_get_option( 'modules.lazysizes.noscript', false ),
			'blurup'    => rwp_get_option( 'modules.lazysizes.blurup', false ),
			'fadein'    => rwp_get_option( 'modules.lazysizes.fadein', false ),
			'custommedia' => rwp_get_option( 'modules.lazysizes.custommedia', false ),
			'artdirect' => rwp_get_option( 'modules.lazysizes.artdirect', false ),
		);

		$lazyload  = data_get( $lazysizes, 'lazyload', false );

		if ( ! $lazyload ) {
			return $image;
		}

		$placeholder = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		if ( ! rwp_is_class( $image, __NAMESPACE__ . '\\Element' ) ) {
			$image = new Element( $image );

			$image->set_attr( 'data-src', $image->get_attr( 'src' ) );

			if ( $image->has_attr( 'srcset' ) ) {
				$srcset = $image->get_attr( 'srcset' );
				if ( $srcset !== $placeholder ) {
					$image->set_attr( 'data-srcset', $image->get_attr( 'srcset' ) );
					$image->set_attr( 'srcset', $placeholder, true ); // set to trasparent gif
				}
			}
		}

		$element = $image;

		if ( rwp_is_class( $image, __NAMESPACE__ . '\\Image' ) ) {
			$image = $image->image;

			if ( data_get( $lazysizes, 'custommedia', false ) ) {
				$sources = rwp_image_sources( $element->id, $element->size );

				$element->inner->set_content( $sources, 'sources' );
				$image->remove_attr( 'data-srcset' );

			}

			$image->set_attr( 'data-src', $placeholder );

			$image->set_attr( 'data-parent', '.media-content' );
			$image->set_attr( 'data-parent-fit', 'cover' );

		}

		$image->add_class( 'lazyload' );

		if ( data_get( $lazysizes, 'blurup', false ) ) {
			$image->add_class( 'blur-up' );
		} else {
			$image->remove_class( 'blur-up' );
		}

			$image->remove_attr( 'src' );

			$image->remove_attr( 'srcset' );

		if ( $image->has_attr( 'width' ) && $image->has_attr( 'height' ) ) {
			$width = floatval( $image->get_attr( 'width', 0 ) );
			$height = floatval( $image->get_attr( 'height', 0 ) );
			if ( rwp_image_has_dimensions( $width, $height ) ) {
				$image->set_attr( 'data-aspectratio', $width / $height );
			}
		}

		if ( $image->has_attr( 'sizes' ) ) {
			$image->remove_attr( 'sizes' );
		}

		$image->set_attr( 'data-sizes', 'auto' );

		if ( rwp_is_class( $image, __NAMESPACE__ . '\\Image' ) ) {

			$element->image = $image;

			$image = $element;

		}

		return $image;
	}

	/**
	 * Add a caption
	 *
	 * @param array|string $args
	 * @return void
	 */
	public function set_caption( $args ) {

		$caption = $this->caption->toArray();

		if ( is_array( $args ) ) {
			$caption = rwp_merge_args( $caption, $args );

			$this->caption = new Element( $caption );
		} else if ( is_string( $args ) ) {
			$this->caption->set_content( $args );
		}

		$this->order[] = 'caption';
	}

	/**
	 * Add a title
	 *
	 * @param array|string $args
	 * @return void
	 */
	public function set_title( $args ) {

		$title = $this->title->toArray();

		if ( is_array( $args ) ) {
			$title = rwp_merge_args( $title, $args );

			$this->title = new Element( $title );
		} else if ( is_string( $args ) ) {
			$this->title->set_content( $args );
		}

		$this->order[] = 'title';
	}

	public function setup_html() {
		self::add_lazysizes( $this );

		if ( ! empty( $this->ratio ) ) {
			$this->inner->add_class( 'ratio' );
			if ( rwp_str_ends_with( $this->ratio, '%' ) ) {
				$this->set_style( '--bs-aspect-ratio', $this->ratio );
			} else {
				$this->inner->add_class( 'ratio-' . $this->ratio );
			}
		}

		if ( $this->caption->has_content() ) {
			$this->addClass( 'has-caption' );
		}

		$this->inner->set_content( $this->image, 'image' );

		if ( $this->link->has_attr( 'href' ) ) {
			$this->link->set_content( $this->inner, 'inner' );
		}
	}
}
