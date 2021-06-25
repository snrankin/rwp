<?php

/** ============================================================================
 * RWP Media
 *
 * @package RWP\Components\Media
 * @since   0.1.0
 * ========================================================================== */


namespace RWP\Components;

use function RWP\Modules\Wistia\get_wistia_data;

class Media extends Html {

	/**
	 * @var array $order The order of content items;
	 */
	public $order = ['before', 'title', 'media', 'caption', 'after'];

	/**
	 * @var array $atts The outer wrapper attributes
	 */

	public $atts = [
		'tag'       => 'figure',
		'class'     => [
			'media-wrapper'
		]
	];

	/**
	 * @var int|str $src The attachement id to use or the url of an external item.
	 */
	public $src;

	/**
	 * @var str $type The type of media (either `image or `video`).
	 */
	public $type = 'image';

	/**
	 * @var str $host The video host
	 */

	public $host;

	/**
	 * @var str $size The image size
	 */

	public $size = 'full';

	/**
	 * @var bool|str $is_bg Whether or not the item is background media and the background type.
	 */

	public $is_bg = false;

	/**
	 * @var str $fit How the image should fill the container
	 */

	public $fit = null;

	/**
	 * @var str $embed The embed aspect ratio (i.e; 16by9)
	 */

	public $embed;

	public $zoom = false;

	public $add_spacer = false;

	/**
	 * @var array|Html $media The media inner wrapper
	 */

	public $media = [
		'order' => ['before', 'sources', 'spacer', 'media', 'after'],
		'atts' => [
			'class' => [
				'media-content',
			],
		]
	];

	/**
	 * @var array|Html $spacer The media inner wrapper
	 */

	public $spacer = [
		'atts' => [
			'tag' => 'span',
			'class' => [
				'media-spacer',
			],
		]
	];

	/**
	 * @var array|Html $image Image options
	 */
	public $image = [
		'inline' => false,
		'atts' => [
			'tag'   => 'img',
		]
	];

	/**
	 * @var array|Html $video Video options
	 */
	public $video = [
		'atts' => [
			'tag'   => 'video',
			'class' => [
				'media-src',
				'media-video'
			]
		],
		'play_btn' => [
			'text' => [
				'content' => 'Play Video',
				'screen_reader' => true
			],
			'icon' => [
				'content' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106.92 106.92"><path d="M53.46,106.92a53.46,53.46,0,1,1,53.46-53.46A53.52,53.52,0,0,1,53.46,106.92ZM53.46,2a51.46,51.46,0,1,0,51.46,51.46A51.51,51.51,0,0,0,53.46,2Z"/><path d="M77.91,52.59,40.35,19.72V85.46L77.91,52.6m2.65,0-42,36.72V15.86Z"/></svg>',
			],
			'atts' => [
				'tag' => 'button',
				'class' => [
					'play-btn'
				]
			]
		]
	];

	/**
	 * @var array|Html $title Title options
	 */
	public $title = [
		'atts' => [
			'class' => [
				'media-title'
			]
		]
	];

	/**
	 * @var array|Html $caption Caption options
	 */
	public $caption = [
		'atts' => [
			'tag' => 'figcaption',
			'class' => [
				'media-caption',
				'figure-caption'
			]
		]
	];

	/**
	 * @var array|HtmlList $gallery Gallery options
	 */
	public $gallery = [
		'type' => 'grid',
		'atts' => [
			'class' => [
				'gallery',
				'list-unstyled'
			]
		],
		'item_atts' => [
			'atts' => [
				'class' => [
					'gallery-item'
				]
			]
		]
	];

	public function __construct($args = []) {

		parent::__construct($args);

		$this->title   = new Html($this->title);
		$this->caption = new Html($this->caption);
		$this->media   = new Html($this->media);
		$this->spacer  = new Html($this->spacer);
		$this->gallery = new HtmlList($this->gallery);


		$type = $this->type;

		if ($this->type !== 'gallery') {
			if (empty($this->src)) {
				if (is_array($this->$type)) {
					if (rwp_array_has('src', $this->$type)) {
						$this->src = $this->$type['src'];
					} else if (rwp_array_has('atts', $this->$type)) {
						if (rwp_array_has('src', $this->$type['atts'])) {
							$this->src = $this->$type['atts']['src'];
						} else if (rwp_array_has('data-src', $this->$type['atts'])) {
							$this->src = $this->$type['atts']['data-src'];
						}
					}
				}
			}
			// if (!empty($this->src) && is_numeric($this->src) && $this->src != 0 && !$this->is_bg) {
			// 	$caption = wp_get_attachment_caption($this->src);

			// 	if ($caption) {
			// 		$this->caption->addContent($caption);
			// 	}
			// }
		}

		if (!empty($this->embed)) {
			if (empty($this->fit)) {
				$this->fit = 'cover';
			}
		}

		if ($this->is_bg !== false) {
			$this->addClass('is-bg');
			if (empty($this->fit)) {
				$this->fit = 'cover';
			}
		}

		switch ($type) {
			case 'video':
				$this->setupVideo();
				break;

			case 'gallery':
				$this->setupGallery();
				break;

			default:
				$this->setupImage();
				break;
		}
	}

	// @ Setup Image

	public function setupImage() {
		$image = $this->image;
		if (!$this->media->hasAttr('tag')) {
			$this->media->setAttr('tag', 'picture');
		}


		if (is_string($image) && !empty($image)) {

			$this->media->media = $image;
		} else {
			if (!empty($this->src)) {
				if (is_object($image)) {
					if ($image instanceof Html) {
						$image = self::extractAtts($image);
					} else {
						$image = rwp_object_to_array($image);
					}
				}
				if (is_array($image)) {


					if (!empty($this->embed)) {
						$image['atts']['class'][] = 'embed-responsive-item';
					}

					if (!empty($this->fit)) {
						$image['atts']['data-parent-fit'] = $this->fit;
						$image['atts']['data-parent-container'] = '.media-content';
					}
				}

				$image['atts'] = rwp_image_attrs($image['atts'], $this->src, $this->size);

				$srcset = rwp_get_srcset($this->src, $this->size);



				if ($srcset) {

					$sources = '';
					foreach ($srcset['sizes'] as $name => $src) {
						$width = $height = $url = '';
						if (rwp_array_has('width', $src)) {
							$width = intval($src['width']);
						}

						if (rwp_array_has('height', $src)) {
							$height = intval($src['height']);
						}

						if (rwp_array_has('url', $src)) {
							$url = $src['url'];
							$url = wp_sprintf('%1$s %2$dw %3$dh', $url, $width, $height);
						}

						$sources .= wp_sprintf('<source data-srcset="%s" data-aspectratio="%d/%d" media="--media-%s" data-tag="media-%s" />', $url, $width, $height, $name, $name);
					}
					$this->media->sources = $sources;
				}

				$lazy_image = rwp_html($image);

				$this->image = $lazy_image;
				if (!$this->image->hasAttr('tag')) {
					$this->image->setAttr('tag', 'img');
				}
				$this->media->media = $lazy_image;

				$no_script = rwp_html($image);

				$no_script->setAttr('src', $no_script->getAttr('data-src'));
				$no_script->setAttr('srcset', $no_script->getAttr('data-srcset'));
				$no_script->removeAttr('data-sizes');
				$no_script->removeAttr('data-aspectratio');
				$no_script->removeAttr('data-parent-fit');
				$no_script->removeAttr('data-parent-container');
				$no_script->removeClass('lazyload');
				$this->media->before =
					'<noscript>' . $no_script->__toString() . '</noscript>';
			}
		}
	}


	// @ Setup Video

	public function setupVideo() {

		$this->video = rwp_html($this->video);

		if (!empty($this->embed)) {
			$this->video->addClass('embed-responsive-item');
		}



		if (rwp_is_url($this->src) && rwp_is_outbound_link($this->src)) {
			$this->video->setAttr('tag', 'iframe');
			$this->video->setAttr('data-src', $this->src);
			$this->video->addClass('lazyload');
			if (!empty($this->zoom)) {
				if (!$this->media->hasAttr('data-type')) {
					$this->media->setAttr('data-type', 'iframe');
				}
			}
		} elseif (is_string($this->src)) {
			$this->media->addClass($this->host);
			$video_id = $this->src;
			$this->video->setAttr('tag', 'div');

			$play_btn = rwp_button($this->video->play_btn);
			switch ($this->host) {
				case 'youtube':
					$this->video->setAttr('data-' . $this->host, $video_id);
					$this->video->addClass('lazyload');
					$this->video->addContent($play_btn);
					if (!empty($this->zoom)) {
						if (!rwp_is_url($this->zoom)) {
							$this->zoom = 'https://www.youtube.com/watch?v=' . $video_id;
						}
						if (!$this->media->hasAttr('data-type')) {
							$this->media->setAttr('data-type', 'video');
						}
					}
					break;
				case 'vimeo':
					$this->video->setAttr('data-' . $this->host, $video_id);
					$this->video->addClass('lazyload');
					$this->video->addContent($play_btn);
					if (!empty($this->zoom)) {
						if (!rwp_is_url($this->zoom)) {
							$this->zoom = 'https://vimeo.com/' . $video_id;
						}
						if (!$this->media->hasAttr('data-type')) {
							$this->media->setAttr('data-type', 'video');
						}
					}
					break;
				case 'wistia':
					$wistia = get_wistia_data($video_id);

					if (!empty($wistia) && $this->is_bg == false) {
						$this->media->addAttr('data-bgset', $wistia['image']);
						$this->media->addClass('lazyload');
					}
					$wistia_classes = [
						'wistia_embed',
						'wistia_async_' . $video_id,
						'wistia-video',
						'playbar=false',
						'controlsVisibleOnLoad=false',
					];
					if ($this->is_bg !== false) {
						$wistia_classes = array_merge($wistia_classes, [
							'autoPlay=true',
							'muted=true',
							'silentAutoPlay=true',
							'videoFoam=false',
							'endVideoBehavior=loop',
							'no-video-foam'
						]);
					} else {
						$wistia_classes = array_merge($wistia_classes, [
							'seo=true',
							'videoFoam=true',
						]);
					}
					$this->video->addClasses($wistia_classes, false);
					if (!empty($this->zoom)) {
						if (!$this->media->hasAttr('data-type')) {
							$this->media->setAttr('data-type', 'inline');
						}
					}
					break;
			}
		} elseif (is_int($this->src) || is_numeric($this->src)) {
			$meta = wp_get_attachment_metadata($this->src);

			$url = $this->video->getAttr('src') ??
				wp_get_attachment_url($this->src);
			$width = $meta['width'];
			$height = $meta['height'];
			$this->video->removeAttr('src');
			//$this->video->setAttr('data-src', $url);
			$this->video->addClass('lazyload');

			$this->video->setAttr('tag', 'video');
			// $this->video->setAttr('src', $url);
			// $this->video->setAttr('width', $width);
			// $this->video->setAttr('height', $height);
			$this->video->setAttr('preload', 'none');

			if ($this->video->hasAttr('poster')) {
				$poster = $this->video->getAttr('poster');
				$poster = rwp_relative_url($poster);
				$this->video->setAttr('data-poster', $poster);
				$this->video->removeAttr('poster');
			}

			$source = new Html([
				'atts' => [
					'tag' => 'source',
					'src' => $url,
					'data-aspectratio' => $width / $height,
					'type' => $meta['mime_type']
				]
			]);

			$this->video->addContent($source);

			if (!empty($this->fit)) {
				$this->video->setAttr('data-parent-fit', $this->fit);
			}

			if (
				$this->is_bg !== false
			) {
				$this->video->setAttr('muted', '');
				$this->video->setAttr('autoplay', '');
				$this->video->setAttr('loop', '');
			} else {
				$this->video->setAttr('controls', '');
			}
			if (!empty($this->zoom)) {
				if (!rwp_is_url($this->zoom)) {
					$this->zoom = $url;
				}
				$this->media->setAttr('data-type', 'video');
			}
		}

		if (!$this->media->hasAttr('tag')) {
			$this->media->setAttr('tag', 'div');
		}

		$this->media->addContent($this->video, 'media');

		$this->media->media = $this->video;
	}

	// @ Setup Gallery

	public function setupGallery() {
		$this->setAttr('tag', 'div');
		$this->removeClass('figure');

		$this->gallery->items->transform(function ($item) {
			if (is_array($item)) {
				$item = new self($item);
				$item = $item->__toString();
			}
			return $item;
		});

		$this->order = preg_replace('/media/', 'gallery', $this->order);
		$this->gallery->setAttr('tag', 'ul');
		$this->gallery->addClass('gallery-' . $this->gallery->type);
	}


	// @ SVG
	public static function svg($args = []) {

		if (empty($args)) {
			return;
		}
		$file = $args['file'];

		if (empty($file)) return;

		$svg_file = simplexml_load_file($file);

		if (!$svg_file) return;

		$svg_file = rwp_xml_to_array($svg_file);

		$width = null;
		$height = null;

		$viewBox = null;

		if (rwp_array_has('viewBox', $svg_file['atts'])) {
			$viewBox = $svg_file['atts']['viewBox'];
			$viewBox = explode(' ', $viewBox);
		}

		if (rwp_array_has('width', $svg_file['atts'])) {
			$width = $svg_file['atts']['width'];
		} elseif (!empty($viewBox)) {
			$width = $viewBox[2];
		}

		if (rwp_array_has('height', $svg_file['atts'])) {
			$height = $svg_file['atts']['height'];
		} elseif (!empty($viewBox)) {
			$height = $viewBox[3];
		}

		if (!rwp_array_has('width', $args['atts']) && !empty($width)) {
			$args['atts']['width'] = $width;
		}

		if (!rwp_array_has('height', $args['atts']) && !empty($height)) {
			$args['atts']['height'] = $height;
		}


		$defaults = [
			'atts' => [
				'tag'   => 'svg',
				'xmlns' => 'http://www.w3.org/2000/svg',
				'role'  => 'img',
			]
		];

		$args = rwp_merge_args($defaults, $args);

		$svg = rwp_merge_args($args, $svg_file);

		foreach ($svg_file['children'] as $path) {
			$svg['content'][] = rwp_html($path)->__toString();
		}

		$svg = rwp_html($svg);

		if ($svg->hasAttr('alt') && !$svg->hasAttr('aria-label')) {
			$svg->setAttr('aria-label', $svg->getAttr('alt'));
		} else if ($svg->hasAttr('title') && !$svg->hasAttr('aria-label')) {
			$svg->setAttr('aria-label', $svg->getAttr('title'));
		}

		if (empty($svg->getAttr('width'))) {
			$svg->removeAttr('width');
		}

		if (empty($svg->getAttr('height'))) {
			$svg->removeAttr('height');
		}

		$svg->removeAttr('data-src');
		$svg->removeClass('lazyload');
		$svg->removeAttr('alt');
		$svg->removeAttr('title');

		return $svg;
	}

	// @ Prebuild
	public function preBuild() {

		if ($this->type !== 'gallery') {

			if (!empty($this->zoom) && $this->type !== 'gallery') {
				$zoom = wp_get_attachment_image_src($this->src, 'full');
				if (!rwp_is_url($this->zoom) && $zoom) {

					$this->setAttr('tag', 'a');

					if (!$this->hasAttr('href')) {
						$this->setAttr('href', $zoom[0]);
					}
					if (!$this->hasAttr('data-width')) {
						$this->setAttr('data-width', $zoom[1]);
					}
					if (!$this->hasAttr('data-height')) {
						$this->setAttr('data-height', $zoom[2]);
					}
				}
				if (!$this->hasAttr('data-type')) {
					$this->setAttr('data-type', $this->type);
				}
				if (!$this->hasAttr('data-fancybox')) {
					$this->setAttr('data-fancybox', '');
				}
				$this->media->addClass('image-zoom');
				if ($this->caption->hasContent()) {
					$caption = $this->caption->buildContent();
					$this->setAttr('data-caption', $caption);
				}
			}

			if (!empty($this->embed)) {
				$this->media->addClasses(['embed-responsive', 'embed-responsive-' . $this->embed]);
				$this->media->media->addClasses('embed-responsive-item');
				if (empty($this->fit)) {
					$this->fit = 'cover';
				}
				$this->media->media->setAttr('data-parent-fit', $this->fit);
				$this->media->media->setAttr('data-parent-container', '.media-content');
			}

			if ($this->is_bg !== false) {
				$this->addClass('is-bg');
				if (empty($this->fit)) {
					$this->fit = 'cover';
				}
				$this->media->media->setAttr('data-parent-fit', $this->fit);
				$this->media->media->setAttr('data-parent-container', '.media-content');
			}
		}

		if ($this->caption->hasContent()) {
			$this->addClass('has-caption');
		}

		$this->addClass($this->type . '-wrapper');

		$this->removeClass('lazyload');
	}
}
