<?php

/** ============================================================================
 * Bootstrap
 *
 * Implement Bootstrap v5 into Wordpress
 *
 * @package   RWP\Internals\Bootstrap
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Html;
use RWP\Components\Embed;
use RWP\Vendor\Exceptions\Collection\KeyNotFoundException;

class Bootstrap extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( rwp_get_option( 'modules.bootstrap.styles', false ) || rwp_get_option( 'modules.bootstrap.scripts', false ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_assets' ) );
			$this->bootstrap_in_tinymce();
		}

		if ( rwp_get_option( 'modules.bootstrap.gutenberg', false ) ) {
			add_filter( 'render_block', array( $this, 'embed_block' ), 10, 2 );
		}
	}


	/**
	 * Registers/enqueues Bootstrap assets if the settings are turned on
	 *
	 * @return void
	 * @throws KeyNotFoundException
	 */

	public function bootstrap_assets() {
		if ( rwp_get_option( 'modules.bootstrap.styles', false ) ) {
			rwp()->register_styles( 'bootstrap' );
			rwp()->enqueue_styles( 'bootstrap' );
		}
		if ( rwp_get_option( 'modules.bootstrap.scripts', false ) ) {
			rwp()->register_scripts( 'bootstrap' );
			rwp()->enqueue_scripts( 'bootstrap' );
		}
	}

	public function bootstrap_in_tinymce() {
		/**
		 * Enabling styleselect
		 *
		 * Before any registered formats/styles will show, we need to activate the
		 * styleselect pulldown menu in the Visual editor. We do this by filtering the
		 * array of buttons loaded by TinyMCE. We use the mce_buttons_2 filter because
		 * that is the second row and it looks good there.
		 *
		 * @return array $buttons
		 */

		add_filter( 'mce_buttons_2', function ( $buttons ) {
			array_unshift( $buttons, 'styleselect' );
			return $buttons;
		});

		/**
		 *  Registering Custom Styles
		 *
		 * Once styleselect is in place we can register our actual styles in two
		 * different ways. Both involve using the tiny_mce_before_init filter, which
		 * receives the full configuration parameters of TinyMCE and into which we'll
		 * inject our custom styles.
		 *
		 * @param array $styles
		 *
		 * @return array $init_array
		 */

		// Callback function to insert 'styleselect' into the $buttons array

		$tinymce_styles = rwp()->get_setting( 'tinymce.editor' );

		add_filter( 'tiny_mce_before_init', function ( $init_array ) use ( $tinymce_styles ) {

			$styles = wp_json_encode( $tinymce_styles );

			$init_array['style_formats'] = $styles;

			return $init_array;
		});
	}


	/**
	 * Get colors/breakpoints from Bootstrap
	 * @param string $group
	 * @param string $class_prefix
	 * @param string $class_suffix
	 * @param string $label_prefix
	 * @param string $label_suffix
	 * @return mixed
	 */
	public static function bs_atts( $group = '', $class_prefix = '', $class_suffix = '', $label_prefix = '', $label_suffix = '' ) {

		$colors = rwp_collection(array(
			'blue'   => array(),
			'indigo' => array(),
			'purple' => array(),
			'pink'   => array(),
			'red'    => array(),
			'orange' => array(),
			'yellow' => array(),
			'green'  => array(),
			'teal'   => array(),
			'cyan'   => array(),
			'white'  => array(),
			'black'  => array(),
			'gray'   => array(),
		))->transform(function ( $info, $color ) use ( $class_prefix, $class_suffix, $label_prefix, $label_suffix ) {
			$label = rwp_change_case( $color, 'title' );
			$shades = array(
				'default' => "var(--bs-$color)",
			);
			for ( $i = 1; $i <= 9; $i++ ) {
				$shades[ "{$i}00" ] = "var(--bs-$color-{$i}00)";
			}
			return array(
				'label' => rwp_add_prefix( rwp_add_suffix( $label, $label_suffix ), $label_prefix ),
				'value' => rwp_add_prefix( rwp_add_suffix( $color, $class_suffix ), $class_prefix ),
				'shades' => $shades,
			);
		});

		$theme_colors = rwp_collection(array(
			'primary'   => array(),
			'secondary' => array(),
			'success'   => array(),
			'info'      => array(),
			'warning'   => array(),
			'danger'    => array(),
			'light'     => array(),
			'dark'      => array(),
		))->transform(function ( $info, $color ) use ( $class_prefix, $class_suffix, $label_prefix, $label_suffix ) {
			$label = rwp_change_case( $color, 'title' );
			return array(
				'label' => rwp_add_prefix( rwp_add_suffix( $label, $label_suffix ), $label_prefix ),
				'value' => rwp_add_prefix( rwp_add_suffix( $color, $class_suffix ), $class_prefix ),
				'shades' => array(
					'default' => "var(--bs-$color)",
				),
			);
		})->merge( $colors );

		$atts = array(
			'colors' => $theme_colors->all(),
			'breakpoints' => array(
				'sm' => array(
					'label' => 'Devices from 576px to 768px',
					'value' => 576,
					'class' => rwp_add_prefix( rwp_add_suffix( 'sm', $class_suffix ), $class_prefix ),
				),
				'md' => array(
					'label' => 'Devices from 768px to 992px',
					'value' => 768,
					'class' => rwp_add_prefix( rwp_add_suffix( 'md', $class_suffix ), $class_prefix ),
				),
				'lg' => array(
					'label' => 'Devices from 992px to 1200px',
					'value' => 992,
					'class' => rwp_add_prefix( rwp_add_suffix( 'lg', $class_suffix ), $class_prefix ),
				),
				'xl' => array(
					'label' => 'Devices from 1200px to 1400px',
					'value' => 1200,
					'class' => rwp_add_prefix( rwp_add_suffix( 'xl', $class_suffix ), $class_prefix ),
				),
				'xxl' => array(
					'label' => 'Devices from 1400px',
					'value' => 1400,
					'class' => rwp_add_prefix( rwp_add_suffix( 'xxl', $class_suffix ), $class_prefix ),
				),
			),
		);

		if ( ! empty( $group ) ) {
			return data_get( $atts, $group );
		} else {
			return $atts;
		}
	}

	/**
	 *
	 * @param string $block_content
	 * @param array $block
	 * @return string
	 */

	public function embed_block( $block_content, $block ) {
		if ( 'core/embed' !== $block['blockName'] ) {
			return $block_content;
		}
		if ( ! empty( $block_content ) ) {

			$url = data_get( $block, 'attrs.url', '' );

			$wrapper = rwp_extract_html_attributes( $block_content, 'figure' );
			$video = rwp_extract_html_attributes( $block_content, 'iframe' );
			$link = rwp_extract_html_attributes( $block_content, 'a', true );
			$caption = rwp_extract_html_attributes( $block_content, 'figcaption', true, true );

			$args = array(
				'src'   => $url,
				'embed' => $video,
				'inner' => $link,
				'atts'  => $wrapper['atts'],
			);

			$video = rwp_embed( $args );

			if ( ! empty( $caption ) ) {
				$video->set_caption( $caption );
			}

			$video = $video->html();

			$block_content = $video;
		}
		return $block_content;
	}
}
