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
				if ( is_numeric( $args ) ) {
					$html = wp_get_attachment_image( $args, $size, false );
				}
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
		$args['image']['atts']['src'] = $src;
		$args['size'] = $size;

		if ( rwp_is_element( $html, 'div|figure' ) ) {
			$args['html'] = $html;
		} else if ( rwp_is_element( $html, 'img|svg' ) ) {
			$args['image']['html'] = $html;
		}

		parent::__construct( $args );

		$this->image = new Element( $this->image );
		$this->inner = new Element( $this->inner );
		$this->caption = new Element( $this->caption );
		$this->title = new Element( $this->title );

	}

	/**
	 * Add lazysizes to an image
	 *
	 * @param mixed $image
	 * @return Element
	 */

	public static function add_lazysizes( $image = '' ) {

		if ( ! ( $image instanceof Element ) ) {
			$image = new Element( $image );
		}

		$lazysizes = array(
			'lazyload'  => rwp_get_option( 'modules.lazysizes.lazyload', false ),
			'noscript'  => rwp_get_option( 'modules.lazysizes.noscript', false ),
			'blurup'    => rwp_get_option( 'modules.lazysizes.blurup', false ),
			'fadein'    => rwp_get_option( 'modules.lazysizes.fadein', false ),
			'parentfit' => rwp_get_option( 'modules.lazysizes.parentfit', false ),
			'artdirect' => rwp_get_option( 'modules.lazysizes.artdirect', false ),
		);

		$lazyload  = data_get( $lazysizes, 'lazyload', false );

		if ( ! $lazyload ) {
			return $image;
		}

		$image->add_class( 'lazyload' );

		if ( data_get( $lazysizes, 'blurup', false ) ) {
			$image->add_class( 'blur-up' );
		} else {
			$image->remove_class( 'blur-up' );
		}

		if ( $image->has_attr( 'src' ) ) {
			$image->set_attr( 'data-src', $image->get_attr( 'src' ) );
			$image->remove_attr( 'src' );
		}

		$placeholder_srcset = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		if ( $image->has_attr( 'srcset' ) ) {
			$srcset = $image->get_attr( 'srcset' );
			if ( $srcset !== $placeholder_srcset ) {
				$image->set_attr( 'data-srcset', $image->get_attr( 'srcset' ) );
				$image->set_attr( 'srcset', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==', true ); // set to trasparent gif
			}
		}

		if ( $image->has_attr( 'sizes' ) ) {
			$image->remove_attr( 'sizes' );
		}

		$image->set_attr( 'data-sizes', 'auto' );

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
		self::add_lazysizes( $this->image );
		$this->inner->set_content( $this->image, 'image' );
	}

}
