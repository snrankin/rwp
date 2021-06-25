<?php

/** ============================================================================
 * RWP Html
 *
 * A simple class to dynamically build HTML elements
 *
 * @package RWP\Components\Html
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

class Html {

	use Helpers;

	/**
	 * @var const $selfClosing An array of html elements that don't need an end tag
	 */

	protected const selfClosing = [
		'area',
		'base',
		'br',
		'col',
		'embed',
		'hr',
		'img',
		'input',
		'link',
		'meta',
		'param',
		'source',
		'textarea',
		'track',
		'wbr',
	];

	/**
	 * @var array|Collection $order The order the content is generated in
	 */

	public $order = ['before', 'content', 'after'];

	/**
	 * Default Content
	 *
	 * @var array|string|Collection $content A collection of content items
	 */

	public $content;

	/**
	 * Content to add before the main content
	 *
	 * @var array|string|Collection $content A collection of content items
	 */

	public $before;

	/**
	 * Content to add after the main content
	 *
	 * @var array|string|Collection $content A collection of content items
	 */

	public $after;

	/**
	 * Default Attributes
	 *
	 * @var array|Collection $atts An array or Collection class of attributes
	 */

	public $atts = [];

	/**
	 * Initialize the Html Class
	 *
	 * @uses RWP\Vendor\Illuminate\Support\Collection::make
	 *
	 * @param array $args Should contain AT LEAST a `content` and `atts` parameter.
	 *
	 * ```
	 * $args = [
	 *   'content' => [], // The inner content of the element. Can be one of string|array|Collection
	 *   'atts'    => [], // The attributes to apply to the element (including the html tag). Can be one of array|Collection
	 * ];
	 *```
	 * @return void
	 */

	public function __construct($args = []) {

		$properties = get_object_vars($this);

		if (!empty($args)) {
			$properties = rwp_merge_args($properties, $args);
			foreach ($properties as $key => $value) {
				$this->$key = $value;
			}
		}

		$this->content = rwp_collection($this->content);
		$this->atts = rwp_collection($this->atts);

		if ($this->hasAttr('class')) {
			$class = rwp_collection($this->getAttr('class'));
			$this->setAttr('class', $class);
		}

		if ($this->hasAttr('style')) {
			$style = rwp_collection($this->getAttr('style'));
			$this->setAttr('style', $style);
		}
	}

	public function setupAtts($args = null) {
		if (!empty($args)) {
			foreach ($args as $key => $value) {
				switch ($key) {
					case 'class':
						$this->addClasses($value);
						break;
					case 'style':
						$this->addStyles($value);
						break;
					default:
						$this->setAttr($key, $value);
						break;
				}
			}
		}
	}

	public static function mergeAttrs($args = null, $obj) {

		if (!empty($args)) {
			if (is_object($args)) {
				$args = rwp_object_to_array($args);
			}
			foreach ($args as $key => $value) {
				switch ($key) {
					case 'class':
						$obj->addClasses($value);
						break;
					case 'style':
						$obj->addStyles($value);
						break;
					default:
						$obj->setAttr($key, $value);
						break;
				}
			}
		}

		return new static($obj);
	}

	public function mergeArgs($args = []) {

		if (!empty($args)) {
			if (is_object($args)) {
				$args = rwp_object_to_array($args);
			}
			foreach ($args as $key => $value) {
				switch ($key) {
					case 'atts':
						$this->setupAtts($value);
						break;
					case 'class':
						$this->addClasses($value);
						break;
					case 'style':
						$this->addStyles($value);
						break;
					case 'items':
					case 'order':
						$this->$key = $value;
						break;
					default:
						if (property_exists($this, $key)) {
							if (is_array($this->$key)) {
								if (wp_is_numeric_array($this->$key)) {
									if (is_string($value) && !empty($value)) {
										$value = [$value];
									}
									$this->$key = $value;
								} else {
									if (is_string($value) && !empty($value)) {
										$value = [$value];
									}
									if (is_array($value)) {
										$this->$key = rwp_merge_args($this->$key, $value);
									}
								}
							} else if ($this->$key instanceof self) {
								$this->$key->mergeArgs($value);
							} else if ($this->$key instanceof Collection) {
								$this->$key = $this->$key->merge($value);
							} else {
								$this->$key = $value;
							}
						} else {
							$this->$key = $value;
						}


						break;
				}
			}
		}
	}

	/**
	 * Create a new html instance if the value isn't one already.
	 *
	 * @param  mixed  $items
	 * @return self
	 */
	public static function make($args = []) {
		if (!($args instanceof self)) {
			return new self($args);
		} else {
			return $args;
		}
	}

	/**
	 * Check if content exists
	 *
	 * @see \Illuminate\Support\Collection::has;
	 *
	 * @param string $key The attribute name
	 *
	 * @return bool
	 */

	public function hasContent($key = null) {
		if (!property_exists($this, 'content')) return false;
		if (is_string($this->content) && !empty($this->content)) {
			return true;
		}
		if (is_array($this->content) && !empty($this->content)) {
			$this->content = Collection::make($this->content);
		}

		if ($this->content instanceof Collection && $this->content->isNotEmpty()) {
			if (!empty($key)) {
				return $this->content->has($key);
			} else {
				return true;
			}
		}

		return false;
	}

	public function hasArg($key = null) {
		return property_exists($this, $key);
	}

	/**
	 * Check if attribute exists
	 *
	 * @see \Illuminate\Support\Collection::has;
	 *
	 * @param string $attr The attribute name
	 *
	 * @return bool
	 */

	public function hasAttr($attr) {
		if (!property_exists($this, 'atts')) return false;
		if (is_array($this->atts)) {
			$this->atts = Collection::make($this->atts);
		}
		return $this->atts->has($attr);
	}

	/**
	 * Get attribute
	 *
	 * @see \Illuminate\Support\Collection::get;
	 *
	 * @param string $attr The attribute name to retrieve
	 *
	 * @return mixed The attribute value
	 */

	public function getAttr($attr) {
		if ($this->hasAttr($attr)) {
			return $this->atts->get($attr);
		} else {
			return false;
		}
	}

	/**
	 * Set attribute
	 *
	 * @see \Illuminate\Support\Collection::put;
	 *
	 * @param string $attr The attribute name to retrieve
	 * @param mixed $value The value to set for the attribute
	 *
	 * @return void
	 */

	public function setAttr($attr, $value) {
		$this->atts->put($attr, $value);
	}

	/**
	 * Remove an attribute
	 *
	 * @see \Illuminate\Support\Collection::pull;
	 *
	 * @param string $attr The attribute name to retrieve
	 * @param mixed $value The value to remove for the attribute
	 *
	 * @return void
	 */


	public function removeAttr($attr) {
		if ($this->hasAttr($attr)) {
			$this->atts->pull($attr);
		}
	}

	public function addContent($value, $i = null) {
		if (!($this->content instanceof Collection)) {
			$this->content = Collection::make();
		}
		if ($value instanceof self) {
			$value = $value->__toString();
		}
		$this->content->put($i, $value);
	}

	public function hasClass($class) {
		if (!$this->hasAttr('class')) {
			return false;
		}
		$classes = $this->getAttr('class');
		$key = $classes->search($class);
		if ($key !== false) {
			return true;
		} else {
			return false;
		}
	}

	public function addClass($value, $filter = true) {
		$classes = $this->getAttr('class');
		if ($classes) {
			$classes = rwp_parse_classes($classes, $filter);
		} else {
			$classes = [];
		}

		if (!($classes instanceof Collection)) {
			$classes = new Collection($classes);
		}
		if ($classes->has($value)) return;

		$classes->push($value);
		$this->setAttr('class', $classes);
	}

	public function addClasses($values, $filter = false) {
		if (empty($values)) return;
		foreach ($values as $value) {
			$this->addClass($value, $filter);
		}
	}

	public function removeClass($value) {
		if (!$this->hasAttr('class')) {
			return;
		}
		$classes = $this->getAttr('class');
		$index = $classes->search($value);
		if ($index !== false) {
			$classes->pull($index);
		}
		$this->setAttr('class', $classes);
	}

	public function removeClasses($values) {
		if (!$this->hasAttr('class')) {
			return;
		}
		foreach ($values as $value) {
			$this->removeClass($value);
		}
	}

	public function hasStyle($style) {
		if (!$this->hasAttr('style')) {
			return false;
		}
		$styles = $this->getAttr('style');
		if (!($styles instanceof Collection)) {
			$styles = Collection::make();
			$this->addAttr('style', $styles);
		}
		return $styles->has($style);
	}

	public function getStyle($style) {
		if (!$this->hasAttr('style')) {
			return false;
		}
		$styles = $this->getAttr('style');
		if ($this->hasStyle($style)) {
			return $styles->get($style);
		}
		return false;
	}

	public function addStyle($key, $value) {
		if ($this->hasAttr('style')) {
			$styles = $this->getAttr('style');
		} else {
			$styles = new Collection();
		}

		$styles->put($key, $value);
		$this->setAttr('style', $styles);
	}

	public function addStyles($args) {
		$args = rwp_parse_styles($args);
		foreach ($args as $key => $value) {
			$this->addStyle($key, $value);
		}
	}

	public function removeStyle($value) {
		if (!$this->hasAttr('style')) {
			return;
		}
		$styles = $this->getAttr('style');
		if ($styles->has($value)) {
			$styles->pull($value);
		}
		$this->setAttr('style', $styles);
	}

	public function removeStyles($values) {
		if (!$this->hasAttr('style')) {
			return;
		}
		foreach ($values as $value) {
			$this->removeStyle($value);
		}
	}

	public function addAttr($key, $value) {
		switch ($key) {
			case 'class':
				$this->addClasses($value);
				break;
			case 'style':
				$this->addStyles($value);
				break;
			default:
				$this->setAttr($key, $value);
				break;
		}
	}

	public function startTag() {
		$selfClosing = self::selfClosing;

		if (!$this->hasAttr('tag')) return;
		$tag = $this->getAttr('tag');
		$atts = rwp_output_html_atts($this->atts);
		$output = "<$tag";
		if (!empty($atts)) {
			$output .= ' ' . $atts;
		}
		$output .= ">\n";

		return $output;
	}

	public function endTag() {
		$selfClosing = self::selfClosing;

		if (!$this->hasAttr('tag')) return;

		$tag = $this->getAttr('tag');

		$output = '';

		$output .= !in_array($tag, $selfClosing) ? "</$tag>\n" : '';

		return $output;
	}




	public static function makeContent($obj) {
		if (!($obj->content instanceof Collection) && !empty($obj->content)) {
			$obj->content = new Collection($obj->content);
		}

		if ($obj->content->isNotEmpty()) {

			$obj->setupContent();
			return $obj->content->join('');
		} else {
			return null;
		}
	}


	public static function extractAtts($obj) {
		if (is_array($obj)) return $obj;
		if (!property_exists($obj, 'atts') || empty($obj->atts) || ($obj->atts instanceof Collection && $obj->atts->isEmpty())) {
			return;
		}
		if ($obj->atts instanceof Collection) {
			$atts = $obj->atts->all();
		}
		if (isset($atts['class']) && $atts['class'] instanceof Collection) {
			$atts['class'] = $atts['class']->all();
		}

		if (isset($atts['style']) && $atts['style'] instanceof Collection) {
			$atts['style'] = $atts['style']->all();
		}

		return $atts;
	}




	public function addAllContent() {
		$selfClosing = self::selfClosing;
		if (!($this->content instanceof Collection) && is_array($this->content)) {
			$this->content = new Collection($this->content);
		}

		if ($this->content instanceof Collection) {

			if (!empty($this->order)) {
				// Make sure content items appear in the right order
				foreach ($this->order as $location) {
					if (is_string($location)) {
						if (property_exists($this, $location)) {
							if ($this->$location instanceof self) {
								$this->$location->preBuild();
								$this->$location->setupContent();
								$tag = $this->$location->getAttr('tag');
								if (($this->$location->hasContent() && !in_array($tag, $selfClosing)) || in_array($tag, $selfClosing)) {
									$this->addContent($this->$location, $location);
								}
							} else if (is_string($this->$location) && !empty($this->$location)) {
								$this->addContent($this->$location, $location);
							}
						}
					}
				}
			}
		}
	}


	public function setupContent() {
		$this->addAllContent();
		if ($this->content instanceof Collection) {
			$this->content = $this->content->reject(function ($item) {
				return empty($item);
			});
			if ($this->content->isNotEmpty()) {
				if (!empty($this->order)) {

					$content = $this->content->all();

					$sorted_array = rwp_sort_array_by_keys($content, $this->order);

					$this->content = new Collection($sorted_array);
				}
			}
		}
	}

	public function preBuild() {
	}

	public function buildContent() {
		if (!($this->content instanceof Collection)) {
			$this->content = new Collection($this->content);
		}
		$this->setupContent();
		if ($this->content->isNotEmpty()) {
			return $this->content->join('');
		}
	}

	public function build() {
		if (!$this->hasAttr('tag')) return;

		$selfClosing = self::selfClosing;
		$start_tag = $this->startTag();
		$content = $this->buildContent();
		$end_tag = $this->endTag();

		$output = $start_tag;

		if (!in_array($this->getAttr('tag'), $selfClosing)) {
			$output .= $content . $end_tag;
		}

		return $output;
	}

	public function __toString() {
		$this->preBuild();
		return $this->build();
	}

	public static function stringify($obj) {
		return $obj->_toString();
	}

	/**
	 * Wrapper for basic HTML text elements.
	 *
	 * @param string|array $args Item arguments
	 * ```
	 * $args = [
	 *   'content' => [], // @param string|array|Collection $content The inner content of the element.
	 *   'atts'    => [ // @param array|Collection $atts The attributes to apply to the element (including the html tag).
	 *      'tag' => 'p', // Default tag
	 *    ],
	 *   'screen_reader' => false // @param bool $screen_reader Is the content for screen readers?
	 * ];
	 *```
	 *
	 * @uses self::parseArgs
	 * @uses self::make
	 *
	 * @return Html The html class instance
	 */

	public static function text($args = []) {
		if (is_string($args)) {
			$args = [
				'content' => $args
			];
		}
		$atts = [
			'atts' => [
				'tag' => 'p',
			],
			'screen_reader' => false
		];
		$atts = rwp_merge_args($atts, $args);
		$text = self::make($atts);
		if ($atts['screen_reader']) {
			$text->addClass('sr-only');
		}
		return $text;
	}

	/**
	 * Wrapper for basic HTML text elements.
	 *
	 * @param string|array $args Item arguments
	 * ```
	 * $args = [
	 *   'content' => [], // @param string|array|Collection $content The inner content of the element.
	 *   'atts'    => [ // @param array|Collection $atts The attributes to apply to the element (including the html tag).
	 *      'tag' => 'a', // Default tag
	 *    ],
	 *   'screen_reader' => false // @param bool $screen_reader Is the content for screen readers?
	 * ];
	 *```
	 *
	 * @uses self::linkAtts
	 * @uses self::make
	 *
	 * @return Html $link The html class instance
	 */

	public static function link($args = []) {

		$defaults = [
			'content' => null,
			'screen_reader' => false
		];

		if (is_object($args)) {
			$args = rwp_object_to_array($args);
		}
		$args = rwp_merge_args($defaults, $args);

		$link = self::text($args);

		if ($link->getAttr('tag') !== 'a' || $link->getAttr('tag') !== 'button') {
			$link->setAttr('tag', 'a');
		}

		return $link;
	}

	/**
	 * Wrapper for icons.
	 *
	 * @param array $args Item arguments
	 * ```
	 * $args = [
	 *   'content' => [], // @param string|array|Collection $content The inner content of the element.
	 *   'atts'    => [ // @param array|Collection $atts The attributes to apply to the element (including the html tag).
	 *      'tag' => 'i', // Default tag
	 *    ],
	 * ];
	 *```
	 *
	 * @uses self::parseArgs
	 * @uses self::make
	 *
	 * @return null|Html $icon The html class instance or nothing
	 */

	public static function icon($args = []) {
		$atts = [
			'atts' => [
				'tag'         => 'i',
				'aria-hidden' => 'true',
				'role'        => 'presentation',
			]
		];

		$atts = rwp_merge_args($atts, $args);

		$icon = self::make($atts);

		if ($icon->getAttr('tag') === 'i' || (!empty($icon->content))) {
			if (!empty($icon->content) && !$icon->hasAttr('tag')) {
				$icon->setAttr('tag', 'span');
			}
			return $icon;
		} else {
			return null;
		}
	}
}
