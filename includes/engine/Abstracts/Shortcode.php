<?php
/** ============================================================================
 * Shortcode Template
 *
 * @package   RWP\Internals
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

use RWP\Components\Element;
use RWP\Engine\Abstracts\Singleton;

/**
 * Shortcodes of this plugin
 */
abstract class Shortcode extends Singleton {

	/**
	 * @var string $tag The shortcode tag
	 */
	protected static $tag = '';


	/**
	 * @var array $defaults The shortcode defaults
	 */
	protected static $defaults = array();

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		self::set_tag();

		\add_action( 'init', function() {
			\add_shortcode( $this::$tag, array( $this, 'output' ) );
		} );
	}

	/**
	 * Wrap the content in a standard wrapper
	 *
	 * @param string $content
	 * @param array $args
	 * @return Element
	 */
	public static function wrapper( $content = '', $args = array() ) {
		$wrapper = array(
			'tag' => 'span',
			'atts' => array(
				'class' => array(
					rwp_change_case( self::$tag ),
				),
			),
		);

		$wrapper = rwp_merge_args( $wrapper, $args );

		$wrapper['content'] = $content;

		return rwp_element( $wrapper );
	}

	/**
	 * The Shortcode Output
	 *
	 * @param array $atts
	 * @return string
	 */

	public static function output( $atts ) {
		return '';
	}

	/**
	 * Set the shortcode tag
	 *
	 * @return void
	 */
	final public static function set_tag() {
		$shortcode_tag  = explode( '\\', get_called_class() );
		$shortcode_tag  = end( $shortcode_tag );
		$shortcode_tag  = rwp()->prefix( $shortcode_tag );

		self::$tag = $shortcode_tag;
	}

}
