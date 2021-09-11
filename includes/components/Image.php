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
	/**
	 * @var string
	 */
	public $tag = 'img';

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
	 * @var string $embed The embed aspect ratio (i.e; 16by9)
	 */
	public $embed;

	/**
	 * @var string|bool $zoom Add lightbox feature
	 */
	public $zoom = false;

	/**
	 * @var array $srcset The array of sources for responsive image display
	 */
	public $srcset = array();

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
	 * The array of default attributes
	 * @var array
	 */

	public $atts = array(
		'class' => array(
			'media-src',
			'media-image',
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

		$src = $this->get( 'src' );
		$size = $this->get( 'size', 'full' );
		$html = $this->get( 'html' );
		if ( rwp_string_is_html( $args ) ) {
			$html = $args;
		}

		if ( ! empty( $args ) ) {

			if ( is_string( $args ) || is_numeric( $args ) ) {
				$src = rwp_extract_img_src( $args, $size );
			} elseif ( is_array( $args ) ) {
				$size = data_get( $args, 'size', $size );
				$src = rwp_extract_img_src( data_get( $args, 'src' ), $size );
			}
		}

		if ( ! is_array( $args ) ) {
			$args = array();
		}

		$args['src'] = $src;
		$args['html'] = $html;

		parent::__construct( $args );


	}

	public function add_lazysizes() {

		$lazyload  = $this->get( 'lazysizes.lazyload', false );

		if ( ! $lazyload ) {
			$this->remove_class( 'lazyload' );
			return;
		}

		if ( $this->get( 'lazysizes.blurup', false ) ) {
			$this->add_class( 'blur-up' );
		} else {
			$this->remove_class( 'blur-up' );
		}

		$this->add_class( 'lazyload' );

		if ( $this->has_attr( 'src' ) ) {
			$this->set_attr( 'data-src', $this->get_attr( 'src' ) );
			$this->remove_attr( 'src' );
		}

		if ( $this->has_attr( 'srcset' ) ) {
			$this->set_attr( 'data-srcset', $this->get_attr( 'srcset' ) );
			$this->set_attr( 'srcset', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==', true ); // set to trasparent gif
		}

		if ( $this->has_attr( 'sizes' ) ) {
			$this->remove_attr( 'sizes' );
		}

		$this->set_attr( 'data-sizes', 'auto' );

		if ( $this->get( 'lazysizes.parentfit', false ) ) {
			$this->set_attr( 'data-parent-fit', $this->fit );
		}

	}

	public function setup_html(){
		$this->add_lazysizes();
	}

}
