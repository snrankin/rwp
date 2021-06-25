<?php

/** ============================================================================
 * RWP html
 *
 * @package RWP\functions\utils
 * @since   0.1.0
 * ========================================================================== */

use \RWP\Vendor\Illuminate\Support\Collection;
use \RWP\Vendor\Illuminate\Support\{Pluralizer, Str};
use \RWP\Vendor\Wa72\HtmlPageDom\HtmlPageCrawler as Html;

/**
 * Returns a sanitized and unique array of css classes
 *
 * @param mixed $classes The array|string|object of classes to parse
 * @param bool  $filter  Whether to run the classes through the
 *                       `sanitize_html_class()` function
 *
 * @return string[]
 */
function rwp_parse_classes($classes, $filter = false) {
	if (empty($classes)) {
		return array();
	}

	if (is_string($classes)) {
		$classes = explode(' ', $classes);
	}

	if (!($classes instanceof Collection)) {
		$classes = new Collection($classes);
	}

	$classes = $classes->unique();

	if ($filter) {
		$classes->transform('\sanitize_html_class');
	}

	$classes = rwp_collection_remove_empty_items($classes);

	$classes = $classes->all();

	if (empty($classes)) {
		$classes = array();
	}

	return $classes;
}

/**
 * Returns a sanitized and unique array of css classes
 *
 * @param mixed $class_set_1 The first set of classes
 * @param mixed $class_set_2 The second set of classes
 * @param bool  $filter      Whether to run the classes through the
 *                          `sanitize_html_class()` function
 *
 * @return array
 */
function rwp_merge_classes($class_set_1 = '', $class_set_2 = '', $filter = false) {

	$class_set_1 = new Collection(rwp_parse_classes($class_set_1, $filter));

	$class_set_2 = new Collection(rwp_parse_classes($class_set_2, $filter));

	$classes = $class_set_1->merge($class_set_2);

	$classes = $classes->unique();

	return $classes->all();
}

/**
 * Returns a sanitized and unique array of css inline styles
 *
 * @param mixed $styles
 *
 * @return array|mixed $styles_array The processed styles
 */
function rwp_parse_styles($styles) {

	if (empty($styles)) {
		return $styles;
	}

	if (is_string($styles)) {
		$styles = explode(';', $styles);
	}

	$styles = new Collection($styles);

	$styles = rwp_collection_remove_empty_items($styles);

	if ($styles->isNotEmpty()) {

		foreach ($styles->all() as $key => $style) {
			if (is_numeric($key) && preg_match('/[\w\-]\:\s*/', $style) && rwp_has_value($style)) {
				// @phpstan-ignore-next-line
				$styles->forget($key);
				$style = explode(':', $style);
				$key   = trim($style[0]);
				$style = trim($style[1]);
				if ('background-image' === $key) {
					$style = "url('{$style}')";
				}
				$styles->put($key, $style);
			}
		}
	}
	return $styles->all();
}


/**
 * Extract Html Attributes
 *
 * Takes a single-level html string and converts it into an array. So
 * `<p>Test</p>` becomes:
 * ```
 * $args = [
 *   'content' => 'Test',
 *   'atts'    => [
 *     'tag' => 'p'
 *   ],
 * ];
 *```
 *
 * @param string $str        The HTML string to parse
 * @param bool   $multilevel Whether the string contains multiple html nodes/tags
 *
 * @return array|false The "exploded" string or false if empty
 */
function rwp_extract_html_atts($str = '', $multilevel = false) {
	$self_closing = array(
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
	);
	if (empty($str) || !is_string($str)) {
		return false;
	}
	$html = array();

	$str = trim($str);
	$str = preg_replace("/\r|\n|\h{2,}|\t/", ' ', $str);
	$str = is_string($str) ? force_balance_tags($str) : '';

	if (empty($str) || !is_string($str)) {
		return false;
	}

	if ($multilevel) {
		preg_match_all('/(?<original_tag>\<\w+[^>]*\/?\>)(?<content>[^><]*+)?/m', $str, $matches, PREG_SET_ORDER, 0);
		if (rwp_has_value($matches)) {
			foreach ($matches as $i => $match) {
				if (is_array($match)) {
					$tag   = trim($match['original_tag']);
					$match = rwp_extract_html_atts($tag);

					if ($match) {
						$html[$i] = $match;
					}
				}
			}
		}
	} else {

		$re = '/(?<original_tag>(?>\<)(?<tag>(?<=<)[^\s\>\/]+)(?<atts>[^>]*)(?>\/?\>))(?<content>(?:\s|\S)*+)/m';

		preg_match($re, $str, $matches);

		if (rwp_has_value($matches)) {
			$html['original_tag'] = $matches['original_tag'];
			$tag                  = $matches['tag'];
			$atts                 = '';
			$content              = '';

			if (rwp_array_has('atts', $matches)) {
				$atts = trim($matches['atts']);
			}

			if (rwp_array_has('content', $matches)) {
				$content = trim($matches['content']);
			}

			if (rwp_has_value($atts)) {
				$re = '/(?<attr>[\w|\-|\_]+)(?|\=|\b)((?<quotes>\'|\")(?<val>.*?)?(?=(?P=quotes)))?/m';
				preg_match_all($re, $atts, $matches, PREG_SET_ORDER, 0);
				$atts = array();

				foreach ($matches as $match) {
					$val = '';
					if (rwp_array_has('val', $match)) {
						$val = trim($match['val']);
					}
					$atts[$match['attr']] = $val;
				}

				$html['atts'] = rwp_prepare_args($atts);
			}

			$html['atts']['tag'] = $tag;
			if (!in_array($tag, $self_closing, true)) {
				$end_tag = "</$tag>";
				$content = Str::replaceLast($end_tag, '', $content);
				if (rwp_has_value($content)) {
					$content         = trim($content);
					$html['content'] = $content;
				}
			}
		}
	}
	return $html;
}

/**
 * Prepares html arguments
 *
 * @param mixed $args
 * @return array
 */

function rwp_prepare_args($args = array()) {
	if (is_object($args)) {
		$args = rwp_object_to_array($args);
	}
	if (is_string($args)) {
		$args = rwp_extract_html_atts($args);
	}

	if (is_array($args) && !wp_is_numeric_array($args)) {
		if (rwp_array_has('url', $args)  || rwp_array_has('href', $args)) {
			rwp_parse_href($args);
		}

		foreach ($args as $key => $value) {
			if (!is_int($key)) {
				switch ($key) {
					case 'style':
						$value = rwp_parse_styles($value);
						break;
					case 'class':
						$value = rwp_parse_classes($value);
						break;
					case 'content':
						if (is_string($value)) {
							$value = array(
								'content' => $value,
							);
						}
						break;
					default:
						if (is_array($value)) {
							$value = rwp_prepare_args($value);
						}
						break;
				}
				if (rwp_is_collection($value)) {
					$value = rwp_object_to_array($value);
				}
				$args[$key] = $value;
			}
		}
	}

	return $args;
}

/**
 * Merge Arguments
 *
 * @param mixed $defaults An array of HTML attributes
 * @param mixed $args     Attributes to add to the original array.
 *
 * @return array The merged array
 */
function rwp_merge_args($defaults = array(), $args = array()) {

	$defaults = rwp_prepare_args($defaults);
	$args     = rwp_prepare_args($args);
	if (empty($args)) {

		return $defaults;
	}

	if (!wp_is_numeric_array($args) && !wp_is_numeric_array($defaults)) {
		foreach ($args as $key => $value) {
			switch ($key) {
				case 'class':
					if (rwp_array_has($key, $defaults)) {
						$value = rwp_merge_classes($defaults[$key], $value);
					}

					break;
				case 'style':
					if (rwp_array_has($key, $defaults)) {
						$value = array_replace_recursive($defaults[$key], $value);
					}
					break;
				default:
					if (is_array($value)) {
						if (rwp_array_has($key, $defaults) && is_array($defaults[$key])) {
							if (rwp_array_is_multi($defaults[$key]) || rwp_array_is_multi($value)) {
								$value = rwp_merge_args($defaults[$key], $value);
							} else {
								$value = array_replace_recursive($defaults[$key], $value);
							}
						}
					}
					break;
			}
			$defaults[$key] = $value;
		}
	} else {
		foreach ($args as $key => $value) {
			if (is_array($value)) {
				if (rwp_array_has($key, $defaults) && is_array($defaults[$key])) {
					if (rwp_array_is_multi($defaults[$key]) || rwp_array_is_multi($value)) {
						$value = rwp_merge_args($defaults[$key], $value);
					}
				}
			}
			$defaults[$key] = $value;
		}
		$defaults = $args;
	}

	return $defaults;
}

/**
 * Filter and output css classes for html
 *
 * @param mixed $classes
 *
 * @return string
 */

function rwp_output_classes($classes) {
	if (rwp_is_collection($classes)) {
		$classes = $classes->all();
	}
	if (rwp_has_value($classes) && is_array($classes)) {
		$classes = implode(' ', $classes);
	} else {
		$classes = '';
	}
	//$classes = sanitize_html_class( $classes );

	return $classes;
}

/**
 * Filter and output inline styles
 *
 * @param mixed $styles
 *
 * @return string
 */

function rwp_output_styles($styles) {
	if (rwp_is_collection($styles)) {
		$styles = $styles->all();
	}
	if (rwp_has_value($styles) && is_array($styles)) {
		foreach ($styles as $prop => $style) {
			if (!preg_match('/[\w\-]\:\s*/', $style)) {
				$styles[$prop] = "$prop: $style;";
			}
		}
		$styles = implode(' ', $styles);
	} else {
		$styles = '';
	}
	//$styles = safecss_filter_attr( $styles );

	return $styles;
}

/**
 * Output Html Attributes
 *
 * Sanitizes data attributes from an array and outputs them as a string (except
 * for the tag).
 *
 * @param array $atts An array of HTML attributes
 * @param string $output How to output the result
 *
 * @return string|array
 */

function rwp_output_html_atts($atts = array(), $output = 'string') {
	$atts = rwp_prepare_args($atts);
	if (!empty($atts)) {

		foreach ($atts as $attr => $value) {
			$is_json = false;
			if (is_string($attr) && 'tag' !== $attr) {
				switch ($attr) {
					case 'class':
						$value = rwp_output_classes($value);
						break;

					case 'style':
						$value = rwp_output_styles($value);
						break;
					default:
						if (rwp_is_collection($value)) {
							$value   = $value->toJson(JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT | JSON_BIGINT_AS_STRING);
							$is_json = true;
						} elseif (is_array($value) || is_object($value)) {
							$value   = wp_json_encode($value, JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT | JSON_BIGINT_AS_STRING);
							$is_json = true;
						} elseif (rwp_str_starts_with($attr, 'on')) {
							$value = str_replace('"', "'", $value);
							$value = esc_js($value);
						} else {
							$value = esc_attr($value);
						}

						break;
				}
				if ('string' === $output) {
					if ($is_json) {
						$value = esc_attr($attr) . '=\'' . $value . '\'';
					} else {
						if (('class' === $attr || 'style' === $attr) && rwp_has_value($value)) {
							$value = esc_attr($attr) . '="' . $value . '"';
						} else {
							$value = esc_attr($attr) . '="' . $value . '"';
						}
					}
				}

				$atts[$attr] = $value;
			}
		}

		if (rwp_array_has('tag', $atts)) {
			unset($atts['tag']);
		}
		if ('string' === $output) {
			$html = implode(' ', $atts);
		} else {
			$html = $atts;
		}

		return $html;
	} else {
		if ('string' === $output) {
			return '';
		} else {
			return array();
		}
	}
}

/**
 * Output URL
 *
 * Processes urls (including emails and phone numbers) and outputs it. Adds
 * `tel:` in front of phone numbers, adds `mailto:` in front of emails and also
 * hides emails from bots using `antispambot()'
 *
 *
 * @param string $link
 *
 * @return string The processed url
 */
function rwp_output_href($link = '') {

	if (rwp_is_phone_number($link)) {
		$link = rwp_add_prefix($link, 'tel:');
	} elseif (is_email($link)) {
		$link = antispambot(sanitize_email($link));
		$link = rwp_add_prefix($link, 'mailto:');
	} elseif (rwp_is_url($link) && !rwp_is_outbound_link($link)) {
		$link = rwp_relative_url($link);
	}

	$link = esc_url($link);

	return $link;
}

/**
 * Parse href
 *
 * Makes sure that if a `href` is set that other proper attributes are also set
 *
 * @param array $atts The array or attributes (passed by reference).
 *
 * @return void The modified array.
 */
function rwp_parse_href(&$atts = array()) {

	$link = '';

	if (rwp_array_has('url', $atts)) {
		$link = $atts['url'];
		unset($atts['url']);
	} elseif (rwp_array_has('href', $atts)) {
		$link = $atts['href'];
	} else {
		// return $atts;
	}

	if (is_array($link)) {
		$atts = rwp_merge_args($atts, $link);
	} else {
		$atts['href'] = $link;
	}

	if (!rwp_array_has('tag', $atts)) {
		$atts['tag'] = 'a';
	}

	if (rwp_array_has('href', $atts)) {
		$atts['href'] = rwp_output_href($atts['href']);
	}

	if (rwp_is_outbound_link($link)) {
		if (!rwp_array_has('target', $atts)) {
			$atts['target'] = '_blank';
		}
	}

	if (rwp_array_has('target', $atts) && '_blank' === $atts['target']) {
		$atts['rel'] = 'noopener noreferrer';
	}

	// return $atts;
}

/**
 *
 * @param array $args
 * @return DOMDocument
 */

function rwp_array_to_dom_node($args = array(), &$dom) {
	$args = rwp_prepare_args($args);

	if (!($dom instanceof DOMDocument)) {
		$dom = new \DOMDocument();
	}
	if (!empty($args)) {
		$content = '';
		$tag = '';
		$atts = array();
		if (rwp_array_has('atts', $args)) {
			$atts = $args['atts'];
			if (rwp_array_has('tag', $atts)) {
				$tag = $atts['tag'];
				unset($atts['tag']);
			} else {
				return null;
			}
		} else {
			return null;
		}

		if (rwp_array_has('content', $args)) {
			$content = $args['content'];
		}

		if (is_array($content)) {
			$content = join('', $content);
		}

		$node = $dom->createElement($tag, $content);

		if (!empty($atts)) {
			$atts = rwp_output_html_atts($atts, 'array');
			foreach ($atts as $name => $value) {
				$node->setAttribute($name, $value);
			}
		}

		return $node;
	} else {
		return null;
	}
}


/**
 * Extract button arguments
 *
 * @param string $button
 * @param array $args
 * @return string
 */

function rwp_input_to_button($input = '', $args = array()) {
	if (!preg_match('/\<input/', $input)) {
		return $input;
	}

	$button = rwp_html2('<button></button>');


	$dom = new \DOMDocument();
	$dom->loadHTML('<?xml encoding="utf-8" ?>' . $input);

	/**
	 * @var \DOMElement $input
	 */
	$input = $dom->getElementsByTagName('input')->item(0);

	$btn_text = '<span class="btn-text">' . $input->getAttribute('value') . '</span>';

	$button->setInnerHtml($btn_text);
	$input->removeAttribute('value');
	$atts = array();

	foreach ($input->attributes as $attribute) {
		$atts[$attribute->name] = $attribute->value;
	}

	if (!empty($args)) {
		if (rwp_array_has('atts', $args)) {
			$atts = $args['atts'];
		}

		$button->setAttribute($attribute->name, $attribute->value);
	}


	if (!empty($atts)) {
		foreach ($atts as $name => $value) {
			$button->setAttribute($name, $value);
		}
	}
	$button->addClass('btn');

	return apply_filters('rwp_button', $button->saveHtml());
}

/**
 * Extract a specific html tag from a string
 *
 * @param string          $str
 * @param string|string[] $tag
 * @param string          $attr_regex
 * @param bool            $multiple
 * @param bool            $remove      Remove the match from the original string?
 * @param string          $format      The format to return the matches in (the
 * 							           string or the exploded array of attributes)
 *
 * @return array|string Will always return an array if $multiple is set to true
 */

function rwp_extract_html_tag(&$str, $tag,  $attr_regex = '[^>]*+', $multiple = false, $remove = true, $format = 'array') {

	if (is_array($tag)) {
		$tag = implode(')|(', $tag);
	}

	$tag = "($tag)";

	$matches = [];

	if (empty($attr_regex)) {
		$attr_regex = '[^>]*+';
	}

	if ($multiple) {

		$pattern = "/<(?<tag>$tag)$attr_regex\/?\>((\s|\S)*?(?=<\/(?P=tag))<\/(?P=tag)>)?/m";

		preg_match_all($pattern, $str, $matches);
	} else {
		$pattern = "/<(?<tag>$tag)$attr_regex\/?\>((\s|\S)*?(?=<\/(?P=tag))<\/(?P=tag)>)?/";
		preg_match($pattern, $str, $matches);
	}

	if (!empty($matches)) {
		$matches = reset($matches);

		if (is_array($matches)) {
			foreach ($matches as $i => $match) {
				if ($remove) {
					$str = str_replace($match, '', $str);
				}

				if ('array' === $format) {
					$matches[$i] = rwp_extract_html_atts($match);
				}
			}
		} else {
			if ($remove) {
				$str = str_replace($matches, '', $str);
			}
			if ('array' === $format) {
				$matches = rwp_extract_html_atts($matches);
			}
		}
	}

	return $matches;
}
function rwp_extract_video_src($string = '', $host = '') {

	$url = '';
	$id = '';

	if(!rwp_is_url($string)){
		preg_match('/(?<=src=\")([^\"]+)/', $string, $url_match);

		if (!empty($url_match)) {
			$url = reset($url_match);
		}
	} else {
		$url = $string;
	}

	if(empty($host)){
		if(rwp_string_has($url, array('youtube.com', 'youtu.be'))){
			$host = 'youtube';
		}elseif(rwp_string_has($url, array('wistia', 'wi.st'))){
			$host = 'wistia';
		}elseif(rwp_string_has($url, 'vimeo')){
			$host = 'vimeo';
		}
	}

	if(empty($host)){
		return false;
	}

	$url_matches = array();

	switch ($host) {
		case 'youtube':
			preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)(?<videoID>[^"&?\/\s]{11})/i', $url, $url_matches);
			break;

		case 'vimeo':
			preg_match('/(?:http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(?<videoID>\d+)(?:|\/\?)/i', $url, $url_matches);
			break;
		case 'wistia':
			preg_match('/https?:\/\/[^.]+\.(?:wistia\.com|wi\.st|wistia\.net)(?:\/(?:medias|embed\/iframe)\/)(?<videoID>[^?\s]+)/i', $url, $url_matches);
			break;
	}


	if (rwp_array_has('videoID', $url_matches)) {
		$id = $url_matches['videoID'];
	}

	return array(
		'url' => $url,
		'host' => $host,
		'id'   => $id,
	);
}

function rwp_extract_search_args($form) {
	if (is_string($form)) {
		$form_tag = $label = $input = $submit = [];

		$label_re = '/<label[^>]*+>((\s|\S)*?(?=<\/label))<\/label>/';
		$input_re = '/<input[^>]*+>/';
		$submit_re = '/<(?\'tag\'[\w|\-]+)[^<]+(?=submit)submit(?<=submit)[^>]*+>(((\s|\S)*?(?=<\/(?P=tag)))<\/(?P=tag)>)?/';

		$form_tag = rwp_extract_html_atts($form);

		if (rwp_array_has('content', $form_tag)) {

			$nodes = $form_tag['content'];
			unset($form_tag['content']);

			preg_match($submit_re, $nodes, $submit);
			if (!empty($submit)) {
				$submit = reset($submit);
				$nodes = str_replace($submit, '', $nodes);
				if (!preg_match('/^\<button/', $nodes)) {
					$submit = rwp_input_to_button($submit);
				} else {
					$submit = rwp_extract_html_atts($submit);
				}
			}
			preg_match($input_re, $nodes, $input);
			if (!empty($input)) {
				$input = reset($input);
				$nodes = str_replace($input, '', $nodes);
				$input = rwp_extract_html_atts($input);
			}
			preg_match($label_re, $nodes, $label);
			if (!empty($label)) {
				$label = reset($label);
				$nodes = str_replace($label, '', $nodes);
				$label = rwp_extract_html_atts($label);
			}
		}
		$field = [
			'input' => $input,
			'label' => $label,
		];
		$form_tag['submit'] = $submit;
		$form_tag['inputs'][] = $field;
		$form_tag = apply_filters('rwp_search_args', $form_tag);

		$form = $form_tag;
	}

	return $form;
}

function rwp_search_args($args = []) {
	$search_form = rwp_extract_html_atts(get_search_form(['echo' => 0]));

	unset($search_form['original_tag']);

	$args = rwp_merge_args($search_form, $args);
	return $args;
}

/**
 *
 * @param mixed $html
 * @param string $selector
 * @return array
 * @throws Exception
 */

function rwp_extract_html_attributes($html, $selector = ''){
	if(is_string($html)){
		$html = rwp_html2($html);
	}

	$attributes_array = array();

	$item = $html->getNode( 0 );

	if(!empty($selector)){
		$item = $html->filter( $selector )->getNode( 0 );
	}
	if ( $item instanceof DOMNode ) {
		$attributes_array['tag'] = $item->nodeName;
		if($item->hasAttributes()){
			$attributes = $item->attributes;
			if(!is_null($attributes)) {
				foreach ($attributes as $attr) {
					$attributes_array[$attr->name] = $attr->value;
				}
    		}
		}

	}

	return $attributes_array;

}
/**
 *
 * @param string|Html $html
 * @param string $selector
 * @param array $atts
 * @return Html
 */
function rwp_append_html_attributes($html, $selector = '', $atts = array()){
	if(is_string($html)){
		$html = rwp_html2($html);
	}

	$item = $html->getNode( 0 );

	if(!empty($selector)){
		$item = $html->filter( $selector )->getNode( 0 );
	}
	if ( $item instanceof DOMElement ) {
		$atts = rwp_output_html_atts($atts, 'array');
		foreach ($atts as $name => $value) {
			$item->setAttribute($name, $value);
		}

	}

	return $item;

}
