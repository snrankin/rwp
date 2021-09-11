<?php
/** ============================================================================
 * Class to extend functionality of HtmlPageCrawler
 *
 * @package   RWP\Components
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use \RWP\Vendor\Wa72\HtmlPageDom\HtmlPageCrawler;

/**
 * @inheritdoc
 */

class Html extends HtmlPageCrawler {

	/**
	 * Extracts all attributes including tag name and content
	 *
	 * @example $crawler->filter('h1 a')->extract(['_text', 'href']);
	 *
	 * @param bool $include_tag
	 * @param bool $include_content
	 *
	 * @return array An array of extracted values
	 */
	public function extractAll( $include_tag = false, $include_content = false ) {

		$node = $this->getNode( 0 );

		$atts = array();

		if ( $node instanceof \DOMElement ) {
			foreach ( $node->attributes as $attribute ) {
				$atts[ $attribute->name ] = $attribute->value;
			}

			if ( $include_content ) {
				$atts['_text'] = $node->nodeValue; //phpcs:ignore
			}

			if ( $include_tag ) {
				$atts['_name'] = $node->nodeName; //phpcs:ignore
			}
		}

		return $atts;
	}

	/**
	 * Get the tag from the html element
	 *
	 * @return string|false
	 */

	public function getTag() {
		$node = $this->getNode( 0 ); //phpcs:ignore
		if ( $node instanceof \DOMElement ) {
			return $node->nodeName; //phpcs:ignore
		} else {
			return false;
		}
	}

	/**
	 * Bulk set attributes
	 * @param array $atts
	 * @return void
	 */

	public function setAllAttributes( $atts = array() ) {

		if ( ! empty( $atts ) ) {
			$atts = rwp_format_html_atts( $atts, 'array' );
			foreach ( $atts as $name => $attr ) {
				$this->setAttribute( $name, $attr );
			}
		}
	}

	/**
	 * @param array $classes
	 * @param bool $filter Whether to sanitize the classes
	 *
	 * @return void
	 */

	public function addClasses( $classes = array(), $filter = false ) {
		$classes = rwp_output_classes( $classes, $filter );
		if ( ! empty( $classes ) ) {
			$this->addClass( $classes );
		}
	}
}
