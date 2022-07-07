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

	use \RWP\Engine\Traits\Helpers;
	public $column_sizes = array();

	public $breakpoints = array(
		'xs' => 0,
		'sm' => 576,
		'md' => 768,
		'lg' => 996,
		'xl' => 1200,
		'xxl' => 1400,
	);


	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		$column_sizes = array();

		for ( $i = 1; $i <= 12; $i++ ) {
			$column_sizes[ $i ] = floatval( ( $i / 12 ) * 100 );

		}

		$this->set( 'column_sizes', $column_sizes );

		if ( rwp_get_option( 'modules.bootstrap.styles', false ) || rwp_get_option( 'modules.bootstrap.scripts', false ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_assets' ) );
			//add_action( 'admin_enqueue_scripts', array( $this, 'bootstrap_assets' ) );
			$this->bootstrap_in_tinymce();
		}

		if ( rwp_get_option( 'modules.bootstrap.gutenberg', false ) ) {
			add_filter( 'render_block', array( $this, 'embed_block' ), 10, 2 );
			add_filter( 'render_block', array( $this, 'button_block' ), 10, 2 );
			add_filter( 'render_block', array( $this, 'buttons_block' ), 10, 2 );
			add_filter( 'render_block', array( $this, 'table_block' ), 10, 2 );
			add_filter( 'render_block', array( $this, 'column_block' ), 10, 2 );
			add_filter( 'render_block', array( $this, 'image_block' ), 10, 2 );
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
			rwp()->add_styles( 'bootstrap' );
		}
		if ( rwp_get_option( 'modules.bootstrap.scripts', false ) ) {
			rwp()->add_scripts( 'bootstrap' );
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

		$tinymce_styles = rwp()->get( 'tinymce.editor' );

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
			$value = data_get( $atts, $group );
			return $value;
		} else {
			return $atts;
		}
	}

	public function bs_column_size( $percentage ) {
		$percentage = floatval( $percentage );

		$column_sizes = $this->get( 'column_sizes', array() );

		$closest = null;
		foreach ( $column_sizes as $i => $size ) {

			if ( null === $closest || abs( $i - $closest ) > abs( $size - $percentage ) ) {
				$closest = $i;
			}
		}

		return $closest;

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
			$block_type = data_get( $block, 'blockName', '' );
			if ( filled( $block_type ) ) {
				$block_type = rwp_remove_prefix( $block_type, 'core/' );
			}

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

			$block_content = rwp_embed( $args );

			if ( ! empty( $caption ) ) {
				$block_content->set_caption( $caption );
			}

			$block_content->removeClass( 'wp-block-' . $block_type );

			$block_content = $block_content->html();

		}
		return $block_content;
	}

	public function button_block( $block_content, $block ) {
		if ( 'core/button' !== $block['blockName'] ) {
			return $block_content;
		}
		if ( ! empty( $block_content ) ) {
			$block_type = data_get( $block, 'blockName', '' );
			if ( filled( $block_type ) ) {
				$block_type = rwp_remove_prefix( $block_type, 'core/' );
			}
			$button_wrapper = rwp_extract_html_attributes( $block_content, 'div' );
			$button_args = rwp_extract_html_attributes( $block_content, 'a', true, true );
			$button_args = rwp_merge_args( $button_wrapper, $button_args );

			$button_classes = data_get( $button_args, 'atts.class', array() );
			$button_classes = rwp_parse_classes( $button_classes );
			if ( rwp_array_has( 'content', $button_args ) ) {
				$button_args['text']['content'] = $button_args['content'];
				unset( $button_args['content'] );
			}
			if ( rwp_array_has( 'href', $button_args['atts'] ) ) {
				$button_args['atts']['href'] = rwp_relative_url( $button_args['atts']['href'] );
			}

			if ( rwp_array_has( '/is-style-/', $button_classes ) ) {
				$button_classes = preg_replace( '/is-style-/', '', $button_classes );
				$button_classes = rwp_parse_classes( $button_classes );
				$button_args = data_set( $button_args, 'atts.class', $button_classes );
			}

			$block_content = rwp_button( $button_args );

			$block_content->remove_class( 'wp-block-button__link' );
			$block_content->remove_class( 'wp-block-' . $block_type );

			$block_content = $block_content->html();
		}
		return $block_content;
	}

	public function buttons_block( $block_content, $block ) {
		if ( 'core/buttons' !== $block['blockName'] ) {
			return $block_content;
		}
		if ( ! empty( $block_content ) ) {
			$block_type = data_get( $block, 'blockName', '' );
			if ( filled( $block_type ) ) {
				$block_type = rwp_remove_prefix( $block_type, 'core/' );
			}
			$wrapper = rwp_extract_html_attributes( $block_content, '.wp-block-buttons' );

			$btns = array(
				'elements' => array(),
				'atts' => $wrapper['atts'],
			);

			$orientation = data_get( $block, 'attrs.orientation', 'horizontal' );

			$links = rwp_extract_html_elements( $block_content, '.btn' );

			if ( ! empty( $links ) ) {
				foreach ( $links as $i => $link ) {
					$btns['elements'][ $i ]['content'] = $link;
				}
			}

			$block_content = rwp_list( $btns );

			if ( 'horizontal' === $orientation ) {
				$block_content->add_class( 'list-inline' );
			} else {
				$block_content->add_class( 'list-unstyled' );
				$block_content->remove_class( 'is-vertical' );
			}

			$block_content->remove_class( 'wp-block-' . $block_type );

			$block_content = $block_content->html();
		}
		return $block_content;
	}

	public function table_block( $block_content, $block ) {
		if ( 'core/table' !== $block['blockName'] ) {
			return $block_content;
		}
		if ( ! empty( $block_content ) ) {
			$block_type = data_get( $block, 'blockName', '' );
			if ( filled( $block_type ) ) {
				$block_type = rwp_remove_prefix( $block_type, 'core/' );
			}
			$table_wrapper = rwp_extract_html_attributes( $block_content, '.wp-block-table' );
			$table_args = rwp_extract_html_attributes( $block_content, 'table' );
			$table_args = rwp_merge_args( $table_wrapper, $table_args );

			$table_classes = data_get( $table_args, 'atts.class', array() );
			$table_classes = rwp_parse_classes( $table_classes );

			$table = rwp_html( $block_content );

			$block_content = rwp_html( $table->filter( 'table' ) );

			$block_content->setAllAttributes( $table_args['atts'] );

			$block_content->addClass( 'table' );

			if ( rwp_array_has( 'is-style-stripes', $table_classes ) ) {
				$block_content->removeClass( 'is-style-stripes' );
				$block_content->addClass( 'table-striped' );
			}
			$block_content->removeClass( 'wp-block-' . $block_type );
			$block_content = $block_content->__toString();
		}
		return $block_content;
	}

	public function column_block( $block_content, $block ) {

		if ( 'core/column' !== $block['blockName'] ) {
			return $block_content;
		} else {
			$block_type = data_get( $block, 'blockName', '' );
			if ( filled( $block_type ) ) {
				$block_type = rwp_remove_prefix( $block_type, 'core/' );
			}
			if ( ! empty( $block_content ) ) {

				if ( ! empty( $block['innerBlocks'] ) ) {
					$col = rwp_extract_html_attributes( $block_content, '.wp-block-' . $block_type, true, true );

					$block_content = rwp_column( $col );
					if ( $block_content->has_style( 'flex-basis' ) ) {
						$width = $block_content->get_style( 'flex-basis' );
						$column_size = $this->bs_column_size( $width );
						$block_content->add_class( 'col-lg-' . $column_size );

					} else {
						$block_content->add_class( 'col-lg-6' );

					}
					$block_content->remove_style( 'flex-basis' );
					$block_content->remove_class( 'wp-block-' . $block_type );
					$block_content = $block_content->html();
				} else {
					$block_content = '';
				}
			}
		}
		return $block_content;
	}

	public function image_block( $block_content, $block ) {
		if ( 'core/image' !== $block['blockName'] ) {
			return $block_content;
		}
		$block_type = data_get( $block, 'blockName', '' );
		if ( filled( $block_type ) ) {
			$block_type = rwp_remove_prefix( $block_type, 'core/' );
		}
		if ( ! empty( $block_content ) ) {

			$wrapper = rwp_extract_html_attributes( $block_content, '.wp-block-' . $block_type );

			$figure = rwp_extract_html_attributes( $block_content, 'figure', true );

			$image = rwp_extract_html_attributes( $block_content, 'img', true );

			$link = rwp_extract_html_attributes( $block_content, 'a', true );

			$caption = rwp_extract_html_attributes( $block_content, 'figcaption', true, true );

			if ( rwp_array_has( 'data-link', $image['atts'] ) ) {
				$image['atts']['data-link'] = rwp_relative_url( $image['atts']['data-link'] );
			}

			if ( rwp_array_has( 'data-full-url', $image['atts'] ) ) {
				$image['atts']['data-full-url'] = rwp_relative_url( $image['atts']['data-full-url'] );
			}

			$figure = rwp_merge_args( $figure, $wrapper );

			if ( ! empty( $image ) ) {
				$figure['image'] = $image;
			}

			if ( ! empty( $link ) ) {
				$figure['inner'] = $link;
			}
			if ( ! empty( $caption ) ) {
				$figure['caption'] = $caption;
			}

			if ( rwp_array_has( 'sizeSlug', $block['attrs'] ) ) {
				$figure['size'] = $block['attrs']['sizeSlug'];
			}

			if ( rwp_array_has( 'id', $block['attrs'] ) ) {
				$figure['src'] = $block['attrs']['id'];
			} else {
				$figure['src'] = $image['atts']['src'];
			}

			$classes = data_get( $block, 'attrs.className', '' );

			if ( rwp_str_has( $classes, 'inline-svg' ) ) {
				$figure['image']['inline'] = true;
			}

			$img_id = data_get( $block, 'attrs.id', '' );

			if ( empty( $img_id ) ) {
				$img_id = intval( data_get( $image, 'atts.data-id', 0 ) );
			}

			$link_to = data_get( $image, 'atts.linkTo', 'none' );

			if ( 'file' === $link_to ) {
				$figure['zoom'] = true;
			} elseif ( 'none' !== $link_to ) {
				$img_meta = array();

				if ( ! empty( $img_id ) ) {
					$img_meta = get_post_meta( $img_id );
				}

				$custom_link = data_get( $img_meta, '_gallery_link_url', '' );
				if ( is_array( $custom_link ) ) {
					$custom_link = reset( $custom_link );
				}
				$custom_link_target = data_get( $img_meta, '_gallery_link_target', '' );
				if ( is_array( $custom_link_target ) ) {
					$custom_link_target = reset( $custom_link_target );
				}
				$custom_link_rel = data_get( $img_meta, '_gallery_link_rel', '' );
				if ( is_array( $custom_link_rel ) ) {
					$custom_link_rel = reset( $custom_link_rel );
				}

				$custom_link_atts = array(
					'tag' => 'a',
					'href' => $custom_link,
					'target' => $custom_link_target,
					'rel' => $custom_link_rel,
				);

				rwp_parse_href( $custom_link_atts );
				$figure['media']['atts'] = $custom_link_atts;
			}

			$block_content = rwp_image( $figure );
			if ( ! empty( $caption ) ) {
				$block_content->set_order( 'caption' );
				$block_content->add_class( 'has-caption' );
				if ( $block_content->has_class( array( 'alignleft', 'alignright' ) ) ) {
					$block_content->set_style( 'display', 'inline-grid' );
				}
			}

			if ( $block_content->has_class( 'alignleft' ) ) {
				$block_content->add_class( 'float-start' );
				$block_content->remove_class( 'alignleft' );
			}

			if ( $block_content->has_class( 'alignright' ) ) {
				$block_content->add_class( 'float-right' );
				$block_content->remove_class( 'alignright' );
			}
			if ( $block_content->has_class( 'is-style-rounded' ) ) {
				$block_content->inner->add_class( 'rounded-circle' );
				$block_content->set( 'ratio', '1x1' );
				$block_content->remove_class( 'is-style-rounded' );

			}
			if ( ! $block_content->has_class( array( 'w-100' ) ) ) {
				$img_width = $block_content->image->get_attr( 'width' );

				if ( $img_width ) {
					$block_content->inner->set_style( 'width', $img_width . 'px' );
				}
			}
			$block_content->remove_class( 'wp-block-' . $block_type );
			$block_content = $block_content->html();
		}
		return $block_content;
	}


}
