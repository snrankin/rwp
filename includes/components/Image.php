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
	 * @var string|array|Element $inner Inner wrapper options
	 */
	public $inner = array(
		'tag' => 'media',
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
			'parentfit' => rwp_get_option( 'modules.lazysizes.parentfit', false ),
			'artdirect' => rwp_get_option( 'modules.lazysizes.artdirect', false ),
		);

		$src  = '';
		$size = 'full';
		$html = '';
		if ( rwp_string_is_html( $args ) ) {
			$html = $args;
		}

		if ( ! empty( $args ) ) {

			if ( is_string( $args ) || is_numeric( $args ) ) {
				$src = rwp_extract_img_src( $args, $size );
			} elseif ( is_array( $args ) ) {
				$src  = data_get( $args, 'src', '' );
				$size = data_get( $args, 'size', $size );
				$src = rwp_extract_img_src( $src, $size );
			}
		}

		if ( ! is_array( $args ) ) {
			$args = array();
		}

		$args['src'] = $src;
		$args['size'] = $size;

		if ( rwp_is_element( $html, 'div|figure' ) ) {
			$args['html'] = $html;
		} else if ( rwp_is_element( $html, '[img|svg]' ) ) {
			$args['image']['html'] = $html;
		}

		parent::__construct( $args );

		$this->image = new Element( $this->image );
		$this->inner = new Element( $this->inner );
		$this->caption = new Element( $this->caption );
		$this->title = new Element( $this->title );

		$this->add_lazysizes();

	}

	public function add_lazysizes() {

		$lazyload  = $this->get( 'lazysizes.lazyload', false );

		$this->image->add_class( 'lazyload' );

		if ( ! $lazyload ) {
			$this->image->remove_class( 'lazyload' );
			return;
		}

		if ( $this->get( 'lazysizes.blurup', false ) ) {
			$this->image->add_class( 'blur-up' );
		} else {
			$this->image->remove_class( 'blur-up' );
		}

		if ( $this->image->has_attr( 'src' ) ) {
			$this->image->set_attr( 'data-src', $this->image->get_attr( 'src' ) );
			$this->image->remove_attr( 'src' );
		}

		if ( $this->image->has_attr( 'srcset' ) ) {
			$this->image->set_attr( 'data-srcset', $this->image->get_attr( 'srcset' ) );
			$this->image->set_attr( 'srcset', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==', true ); // set to trasparent gif
		}

		if ( $this->image->has_attr( 'sizes' ) ) {
			$this->image->remove_attr( 'sizes' );
		}

		$this->image->set_attr( 'data-sizes', 'auto' );

		if ( $this->image->get( 'lazysizes.parentfit', false ) ) {
			$this->image->set_attr( 'data-parent-fit', $this->fit );
		}

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
		$this->add_lazysizes();
		$this->inner->set_content( $this->image, 'image' );
	}

}
