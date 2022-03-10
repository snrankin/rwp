<?php
/** ============================================================================
 * Embed
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
use RWP\Integrations\Wistia;

class Embed extends Element {

	public $order = array( 'inner' );
	/**
	 * @var string
	 */
	public $tag = 'figure';

	/**
	 * @var int|string $src The attachement id to use or the url of an external item.
	 */
	public $src;

	/**
	 * @var int|string $id The video id
	 */
	public $id;

	/**
	 * @var string $host The video host
	 */
	public $host = 'self';

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
	 * @var mixed $icon The play button icon
	 */
	public $icon = 'bi bi-play-circle';

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
	 * @var string|array|Element $embed The embed content
	 */
	public $embed = array(
		'tag' => 'iframe',
        'atts' => array(
            'class' => array(
				'media-src',
				'media-embed',
			),
		),
	);

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
	 * The array of default attributes for the wrapper
	 * @var array
	 */

	public $atts = array(
		'class' => array(
			'media-wrapper',
			'embed',
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
		$html = $this->get( 'html' );
		if ( rwp_str_is_html( $args ) ) {
			$html = $args;
		}

		if ( ! empty( $args ) ) {
			if ( is_string( $args ) ) {
				$args = self::extract_embed_src( $args );
			} elseif ( is_array( $args ) ) {
				$host = data_get( $args, 'host' );
				$src = self::extract_embed_src( data_get( $args, 'src' ), $host );
				$args = rwp_merge_args( $args, $src );
			}
		}

		if ( ! is_array( $args ) ) {
			$args = array();
		}

		if ( rwp_str_is_element( $html, 'div|figure' ) ) {
			$args['html'] = $html;
		} else if ( rwp_str_is_element( $html, '[iframe|video]' ) ) {
			$args['embed']['html'] = $html;
		}

		parent::__construct( $args );

		$this->embed = new Element( $this->embed );
		$this->inner = new Element( $this->inner );
		$this->caption = new Element( $this->caption );
		$this->title = new Element( $this->title );
		$this->icon = new Icon( $this->icon );

	}

	public function setup_embed() {
		$lazyload  = $this->get( 'lazysizes.lazyload', false );
		$host = $this->host;
		if ( $lazyload ) {
			$this->embed->remove_attr( 'src' );
		}
		switch ( $host ) {
			case 'youtube':
			case 'vimeo':
				if ( $lazyload ) {
					$this->embed->set_tag( 'div' );
					$this->embed->set_attr( "data-$host", $this->id );
					$this->embed->add_class( 'lazyload' );
				}

				break;
			case 'wistia':
				$wistia_classes = array(
					'wistia_embed',
					'wistia_async_' . $this->id,
					'wistia-video',
					'playbar=false',
					'controlsVisibleOnLoad=false',
				);
				if ( false !== $this->is_bg ) {
					$wistia_classes = rwp_parse_classes($wistia_classes, array(
						'autoPlay=true',
						'endVideoBehavior=loop',
						'fitStrategy=cover',
						'fullscreenButton=false',
						'playbackRateControl=false',
						'muted=true',
						'no-video-foam',
						'playButton=false',
						'preload=none',
						'qualityControl=false',
						'seo=false',
						'silentAutoPlay=true',
						'smallPlayButton=false',
						'videoFoam=false',
						'volume=0',
						'volumeControl=false',
					));
				} else {
					$wistia_classes = array_merge($wistia_classes, array(
						'seo=true',
						'videoFoam=true',
					));
				}
				$this->embed->remove_attr( 'src' );
				$this->embed->add_class( $wistia_classes, false );
				$this->embed->set_tag( 'div' );
				break;
			case 'self': // if it is a video from the media library
				$this->embed->set_tag( 'video' );
				$meta = array();
				$url = $this->src;
				if ( empty( $this->id ) ) {
					$this->id = attachment_url_to_postid( $url );
				}
				if ( ! empty( $this->id ) ) {
					$meta = wp_get_attachment_metadata( $this->id );
				}

				if ( ! is_array( $meta ) ) {
					$meta = array();
				}

				$width = data_get( $meta, 'width', '' );
				$height = data_get( $meta, 'height', '' );
				$mime = data_get( $meta, 'mime_type', '' );

				if ( false !== $this->is_bg ) {
					$this->embed->set_attr( 'muted', '' );
					$this->embed->set_attr( 'autoplay', '' );
					$this->embed->set_attr( 'loop', '' );
				}

				if ( $lazyload ) {
					$this->embed->set_attr( 'preload', 'none' );
					$this->embed->add_class( 'lazyload' );
					$this->embed->set_attr( 'data-src', $url );
					if ( $this->embed->has_attr( 'poster' ) ) {
						$poster = $this->embed->get_attr( 'poster' );
						$this->embed->remove_attr( 'poster' );
						$this->embed->set_attr( 'data-poster', $poster );
					}
					if ( $this->embed->has_attr( 'autoplay' ) ) {
						$this->embed->remove_attr( 'autoplay' );
						$this->embed->set_attr( 'data-autoplay', '' );
					}

					$source = new Element(array(
						'tag' => 'source',
						'atts' => array(
							'src' => $url,
							'data-aspectratio' => $width / $height,
							'type' => $mime,
						),
					));
					$this->embed->set_content( $source );

					if ( ! empty( $this->fit ) ) {
						$this->embed->set_attr( 'data-parent-fit', $this->fit );
					}
				}
				break;
			default:
				if ( $lazyload ) {
					$this->embed->set_tag( 'div' );
					$this->embed->set_attr( 'data-src', $this->src );
					$this->embed->add_class( 'lazyload' );
				}
				break;
		}

	}

	/**
	 * Add a play icon
	 *
	 * @param array|string $args
	 * @return void
	 */
	public function set_icon( $args = '' ) {

		$icon = $this->icon->toArray();

		if ( is_array( $args ) ) {
			$icon = rwp_merge_args( $icon, $args );
		} else if ( is_string( $args ) ) {
			$icon = $args;
		}

		$this->icon = new Icon( $icon );

		$this->inner->order[] = 'icon';
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
		$this->setup_embed();

		if ( ! empty( $this->ratio ) ) {
			$this->inner->add_class( 'ratio' );
			if ( rwp_str_ends_with( $this->ratio, '%' ) ) {
				$this->set_style( '--bs-aspect-ratio', $this->ratio );
			} else {
				$this->inner->add_class( 'ratio-' . $this->ratio );
			}
		}

		$this->inner->set_content( $this->embed, 'embed' );
	}

	/**
	 * Gets the host name, url, and video id
	 *
	 * @param string|int $string
	 * @param string $host
	 * @return array
	 */

	public static function extract_embed_src( $string = '', $host = '' ) {

		$url = '';
		$id = '';

		if ( rwp_str_has( $string, array( 'youtube.com', 'youtu.be' ) ) ) {
			$host = 'youtube';
		} elseif ( rwp_str_has( $string, array( 'wistia', 'wi.st' ) ) ) {
			$host = 'wistia';
		} elseif ( rwp_str_has( $string, 'vimeo' ) ) {
			$host = 'vimeo';
		} elseif ( rwp_str_has( $string, 'wp-content' ) || is_int( $string ) || is_numeric( $string ) ) {
			$host = 'self';
			if ( is_int( $string ) || is_numeric( $string ) ) {
				$url = wp_get_attachment_url( $string );
				$id = $string;
			}
		}

		if ( rwp_str_is_html( $string ) ) {
			preg_match( '/(?<=src=\")([^\"]+)/', $string, $url_match );

			if ( ! empty( $url_match ) ) {
				$url = reset( $url_match );
			}
		}

		if ( rwp_is_url( $string ) ) {
			$url = $string;
		}

		if ( empty( $host ) ) {
			return array();
		}

		$url_matches = array();

		switch ( $host ) {
			case 'youtube':
				preg_match( '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)(?<videoID>[^"&?\/\s]{11})/i', $string, $url_matches );
				break;

			case 'vimeo':
				preg_match( '/(?:http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(?<videoID>\d+)(?:|\/\?)/i', $string, $url_matches );
				break;
			case 'wistia':
				preg_match( '/https?:\/\/[^.]+\.(?:wistia\.com|wi\.st|wistia\.net)(?:\/(?:medias|embed\/iframe)\/)(?<videoID>[^?\s]+)/i', $string, $url_matches );
				break;
		}

		if ( ! empty( $url_matches ) ) {
			$id = data_get( $url_matches, 'videoID', '' );
		}

		return array(
			'src' => $url,
			'host' => $host,
			'id'   => $id,
		);
	}


}
