<?php

/** ============================================================================
 * Elementor
 *
 * @package   RWP\/includes/integrations/Elementor.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;
use RWP\Integrations\Bootstrap;
use Elementor\Element_Base;
use Elementor\Plugin as Elementor_Instance;
use Elementor\Core\Files\CSS\Post as CSS_File;
use Elementor\Core\Files as File_Base;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use Elementor\Core\Experiments\Manager as Experiments_Manager;
use Elementor\Group_Control_Flex_Item;
use Elementor\Group_Control_Flex_Container;
use Elementor\Controls_Manager as Controls_Manager;
use RWP\Components\Image;

class Elementor extends Singleton {

	public $widgets = array();

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
			return;
		}

		if ( rwp_get_option( 'modules.bootstrap.elementor', false ) ) {

			add_action( 'elementor/element/column/layout/before_section_end', array( $this, 'add_column_options' ), 10, 2 );
			add_action( 'elementor/element/section/section_layout/before_section_end', array( $this, 'add_section_options' ), 10, 2 );

			add_action( 'elementor/element/button/section_button/before_section_end', array( $this, 'add_button_options' ), 10, 2 );

			add_action( 'elementor/element/parse_css', array( $this, 'add_color_contrast' ), 10, 2 );

			add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_elementor_assets' ) );
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_elementor_assets' ) );
			add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_elementor_assets' ) );
		}
		if ( rwp_get_option( 'modules.relative_urls', false ) ) {
			add_action( 'elementor/element/parse_css', array( $this, 'make_urls_relative' ), 10, 2 );
			add_filter( 'elementor/utils/get_placeholder_image_src', array( $this, 'relative_placeholder_image_src' ), 50 );
		}

		if ( rwp_get_option( 'modules.lazysizes.lazyload', false ) ) {
			add_filter( 'elementor/image_size/get_attachment_image_html', array( $this, 'add_lazysizes' ), 10, 4 );
		}

		// add_action('elementor/preview/enqueue_styles', function() {
		// 	wp_enqueue_style( 'gform_basic' );
		// });

		add_filter( 'elementor/files/file_name', array( $this, 'update_file_name' ), 10, 2 );

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );

	}

	/**
	 * Adjust lazysizes for elementor
	 *
	 * @param mixed $html
	 * @param mixed $settings
	 * @param mixed $image_size_key
	 * @param mixed $image_key
	 * @return mixed
	 */
	public function add_lazysizes( $html, $settings, $image_size_key, $image_key ) {
		if ( ! empty( $html ) ) {
			$html = Image::add_lazysizes( $html );
			$html->set_attr( 'data-parent', '.elementor-image', true );
			$html = $html->html();
		}
		return $html;
	}

	/**
	 * Get placeholder image source.
	 *
	 * Make the placeholder image source relative
	 *
	 * @since 0.9.0
	 * @access public
	 *
	 * @param string $placeholder_image The source of the default placeholder image.
	 *
	 * @return string The source of the default placeholder image used by Elementor.
	 */
	public function relative_placeholder_image_src( $placeholder_image ) {
		return rwp_relative_url( $placeholder_image );
	}

	/**
	 * Make the file name more understandable
	 *
	 * @param string $file_name
	 * @param File_Base $file The file instance
	 * @return void
	 */

	public function update_file_name( $file_name, $file ) {
		if ( rwp_str_starts_with( $file_name, 'post' ) ) {
			$post_id = $file->get_post_id();
			$ext = rwp_file_ext( $file_name );
			$file_name = rwp_post_id_html( $post_id ) . ".$ext";
		}

		return $file_name;
	}

	/**
	 * Make all urls in css relative
	 *
	 * @since 0.9.0
	 * @param CSS_File     $post_css_file The post CSS file instance.
	 * @param Element_Base $element       The element instance.
	 */
	public function make_urls_relative( $post_css_file, $element ) {
		$stylesheet = $post_css_file->get_stylesheet();
		$rules = $stylesheet->get_rules();

		foreach ( $rules as $device => $elements ) {
			foreach ( $elements as $selector => $styles ) {
				foreach ( $styles as $style => $value ) {
					if ( rwp_str_has( $value, 'http' ) ) {
						$value = \preg_replace( '/(url\(["|\'])(https?:\/\/.*(?=\/wp-content))(.*)/', '$1$3', $value );
					}
					if ( 'all' === $device ) {
						$post_css_file->get_stylesheet()->add_rules( $selector, array( $style => $value ) );
					} else {
						$post_css_file->get_stylesheet()->add_rules( $selector, array( $style => $value ), $this->hash_to_query( $device ) );
					}
				}
			}
		}
	}

	/**
	 * Hash to query.
	 *
	 * Turns the hashed string to an array that contains the data of the query
	 * endpoint.
	 *
	 * @since 1.2.0
	 * @access private
	 *
	 * @param string $hash Hashed string of the query.
	 *
	 * @return array Media query data.
	 */
	private function hash_to_query( $hash ) {
		$query = [];

		preg_match( '/(min|max)_(.*)/', $hash, $query_parts );

		$end_point = $query_parts[1];

		$device_name = $query_parts[2];

		$query[ $end_point ] = $device_name;

		return $query;
	}

	/**
	 * Add assets to elementor
	 *
	 * @return void
	 */
	public function enqueue_elementor_assets() {
		rwp()->add_assets( 'elementor' );
	}

	/**
	 * Add Custom widgets to Elementor
	 *
	 * @return void
	 */
	public function init_widgets() {
		$class = get_called_class();
		$widgets = rwp()->get_component( $class );

		if ( ! empty( $widgets ) ) {

			foreach ( $widgets as $widget ) {
				if ( $class !== $widget && ! empty( $widget ) ) {
					Elementor_Instance::instance()->widgets_manager->register( new $widget() );
				}
			}
		}
	}

	/**
	 * Get the elementor plugin instance
	 * @return Elementor_Instance
	 */
	public static function plugin() {
		return Elementor_Instance::instance();
	}

	/**
	 * Auto update Elementor expirimental features
	 *
	 * * Turn off dom optimization (for better Bootstrap grid integration)
	 * * Turn on optimized css loading
	 * * Turn on optimized assets loading
	 * * Turn on additional custom breakpoints
	 *
	 * @param Experiments_Manager $elementor
	 * @return Experiments_Manager
	 */

	public function update_elementor_features( $elementor ) {
		$elementor->set_feature_default_state( 'e_dom_optimization', $elementor::STATE_INACTIVE );
		$elementor->set_feature_default_state( 'e_optimized_css_loading', $elementor::STATE_ACTIVE );
		$elementor->set_feature_default_state( 'e_optimized_assets_loading', $elementor::STATE_ACTIVE );
		$elementor->set_feature_default_state( 'additional_custom_breakpoints', $elementor::STATE_ACTIVE );

		return $elementor;
	}


	/**
	 * Auto update Elementor breakpoints
	 *
	 * Update elementor breakpoints so that they match Bootstrap breakpoints
	 *
	 * array(
	 *     'viewport_mobile'        => 576,
	 *     'viewport_tablet'        => 768,
	 *     'viewport_tablet_extra'  => 992,
	 *     'viewport_desktop'       => 1200,
	 *     'viewport_laptop'        => 1400
	 * )
	 *
	 *
	 * @return void
	 */
	public function auto_add_bs_breakpoints() {
		$kit_active_id = self::plugin()->kits_manager->get_active_id();
		// Get the breakpoint settings saved in the kit directly from the DB to avoid initializing the kit too early.
		$raw_kit_settings = (array) get_post_meta( $kit_active_id, '_elementor_page_settings', true );

		$kit_settings = $raw_kit_settings;

		$kit_settings['active_breakpoints'] = array(
			'viewport_mobile'       => Bootstrap::bs_atts( 'breakpoints.sm.value' ),
			'viewport_tablet'       => Bootstrap::bs_atts( 'breakpoints.md.value' ),
			'viewport_tablet_extra' => Bootstrap::bs_atts( 'breakpoints.lg.value' ),
			'viewport_laptop'       => Bootstrap::bs_atts( 'breakpoints.xl.value' ),
			'viewport_desktop'      => Bootstrap::bs_atts( 'breakpoints.xxl.value' ),
		);

		update_post_meta( $kit_active_id, '_elementor_page_settings', $kit_settings, $raw_kit_settings );
	}


	/**
	 * Filter to add certain options from Elementor columns
	 *
	 * @param Element_Base $section
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_column_options( $section, $args ) {
		if ( 'column' === $section->get_name() ) {
			$col_class = $section->get_render_attributes( '_wrapper', 'class' );

			if ( empty( $col_class ) || ! in_array( 'e-col', $col_class, true ) ) {
				$section->add_render_attribute( '_wrapper', 'class', 'e-col' );
			}

			$section->add_responsive_control('_inline_size',
				array(
					'label' => esc_html__( 'Column Width', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control('align',
				array(
					'label' => esc_html__( 'Column Width', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control('content_position',
				array(
					'label' => esc_html__( 'Column Width', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control('space_between_widgets',
				array(
					'label' => esc_html__( 'Column Width', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control('_col_size', array(
				'label'        => 'Column Width',
				'type'         => Controls_Manager::TEXT,
				'prefix_class' => 'e-col%s-',
				'mobile_default' => '12',

			));

			$section->add_group_control(
			Group_Control_Flex_Container::get_type(),
			[
				'name' => 'flex',
				'selector' => '{{WRAPPER}} > .elementor-column-wrap > .elementor-widget-wrap',
				'exclude' => array( 'gap' ),
			]
			);

			$section->add_responsive_control('gap_x', [
				'label' => esc_html_x( 'Items Horizontal Gap', 'Flex Item Control', 'rwp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 15,
						'step' => 1,
					],
				],

				'selectors' => [
					'{{WRAPPER}} > .elementor-column-wrap > .elementor-widget-wrap' => '--gap-x: var(--bs-gutter-{{SIZE}});',
				],
			]);

			$section->add_responsive_control('gap_y', [
				'label' => esc_html_x( 'Items Vertical Gap', 'Flex Item Control', 'rwp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 15,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-column-wrap > .elementor-widget-wrap' => '--gap-x: var(--bs-gutter-{{SIZE}});',
				],
			]);

			$section->add_responsive_control('page_gutter_padding', [
				'label' => 'Page Gutter Padding',
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'description' => 'Add padding to the column equal to the width of the main grid gutter',
				'separator' => 'before',
				'prefix_class' => 'e-pg%s-',
				'options' => [
					'left' => [
						'title' => esc_html( 'Left', 'rwp' ),
						'icon' => 'eicon-flex eicon-align-start-h',
					],
					'right' => [
						'title' => esc_html( 'Right', 'rwp' ),
						'icon' => 'eicon-flex eicon-align-end-h',
					],
					'both' => [
						'title' => esc_html( 'Both', 'rwp' ),
						'icon' => 'eicon-flex eicon-align-stretch-h',
					],
				],
				'default' => '',
				'toggle' => true,
			]);

			$section->add_responsive_control('stretch_col', [
				'label' => 'Stretched Column',
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'description' => 'Stretch the column to the edge of the page.',
				'options' => [
					'left' => [
						'title' => esc_html( 'Left', 'rwp' ),
						'icon' => 'eicon-flex eicon-align-start-h',
					],
					'right' => [
						'title' => esc_html( 'Right', 'rwp' ),
						'icon' => 'eicon-flex eicon-align-end-h',
					],
					'both' => [
						'title' => esc_html( 'Both', 'rwp' ),
						'icon' => 'eicon-flex eicon-align-stretch-h',
					],
				],
				'prefix_class' => 'e-col-stretched%s-',
				'separator' => 'after',
				'default' => '',
				'toggle' => true,
			]);

		}
	}

	/**
	 * Add custom CSS rule.
	 *
	 * @since 1.0.0
	 * @param \Elementor\Core\Files\CSS\Post $post_css_file The post CSS file instance.
	 * @param \Elementor\Element_Base        $element       The element instance.
	 */
	public function add_color_contrast( $post_css_file, $element ) {
		if ( 'column' === $element->get_name() || 'section' === $element->get_name() ) {

			$background = $element->get_parsed_dynamic_settings( 'background_color' );

			$text = $element->get_parsed_dynamic_settings( 'color_text' );

			if ( empty( $background ) ) {
				$background = $element->get_parsed_dynamic_settings( 'background_color_b' );
			}

			if ( ! empty( $background ) && empty( $text ) ) {
				$text = rwp_color_contrast( $background );
				$post_css_file->get_stylesheet()->add_rules(
				$element->get_unique_selector(),
				[
					'color' => $text,
				]
				);
			}
		}

	}

	public static function add_device_condition( $conditions, $args = array() ) {
		$devices = \Elementor\Plugin::$instance->breakpoints->get_active_devices_list( [
			'reverse' => true,
		] );

		$conditions = rwp_collection( $conditions );

		foreach ( $devices as $device ) {
			if ( 'desktop' !== $device ) {
				$device = '_' . $device;
			} else {
				$device = '';
			}
			$new_conditions = $conditions->mapWithKeys(function( $value, $key ) use ( $device ) {
				$key = wp_sprintf( $key, $device );
				return [ $key => $value ];
			})->all();

			$args[ $device ]['condition'] = $new_conditions;
		}

		return $args;
	}

	/**
	 * Filter to add certain options from Elementor sections
	 *
	 * @param Element_Base $section
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_section_options( $section, $args ) {
		if ( 'section' === $section->get_name() ) {

			$section->add_responsive_control('column_position',
				array(
					'label' => esc_html__( 'Column Width', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control('content_position',
				array(
					'label' => esc_html__( 'Column Width', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_control(
			'container_type',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'flex',
				'selectors' => [
					'{{WRAPPER}}' => '--display: {{VALUE}}',
				],
			]
			);

			$section->add_control(
			'content_width',
			[
				'label' => esc_html__( 'Content Width', 'rwp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'boxed',
				'options' => [
					'boxed' => esc_html__( 'Boxed', 'rwp' ),
					'full' => esc_html__( 'Full Width', 'rwp' ),
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} > .elementor-container' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'boxed' => '--width: 100%;',
					'full' => '--content-width: 100%;',
				],
			],
			array(
				'overwrite' => true,
			)
			);

			$section->add_responsive_control('gap',
				array(
					'label' => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_group_control(
			Group_Control_Flex_Container::get_type(),
			[
				'name' => 'flex',
				'selector' => '{{WRAPPER}} > .elementor-container > .elementor-row',
				'exclude' => array( 'gap' ),
			]
			);

			$section->add_responsive_control('gap_x', [
				'label' => esc_html_x( 'Columns Horizontal Gap', 'Flex Item Control', 'rwp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 15,
						'step' => 1,
					],
				],
				'default' => array(
					'unit' => 'px',
					'size' => 4,
				),
				'selectors' => [
					'{{WRAPPER}} > .elementor-container > .elementor-row' => '--gap-x: var(--bs-gutter-{{SIZE}});',
				],
			]);

			$section->add_responsive_control('gap_y', [
				'label' => esc_html_x( 'Columns Vertical Gap', 'Flex Item Control', 'rwp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 15,
						'step' => 1,
					],
				],
				'default' => array(
					'unit' => 'px',
					'size' => 4,
				),
				'selectors' => [
					'{{WRAPPER}} > .elementor-container > .elementor-row' => '--gap-y: var(--bs-gutter-{{SIZE}});',
				],
			]);

		}
	}


	/**
	 * Filter to add certain options from Elementor buttons
	 *
	 * @param Element_Base $section
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_button_options( $section, $args ) {
		if ( 'button' === $section->get_name() ) {
			// Adding Bootstrap button types to elementor buttons

			$btn_options_solid = rwp_collection( rwp_bootstrap_colors( 'btn-' ) )->mapWithKeys( function( $item ) {
				return array( $item['class'] => $item );
			});
			$btn_options_outline = rwp_collection( rwp_bootstrap_colors( 'btn-outline-', '', '', ' Outline' ) )->mapWithKeys( function( $item ) {
				return array( $item['class'] => $item );
			});

			$colors = $btn_options_solid->merge( $btn_options_outline );

			$colors = $colors->mapWithKeys( function( $item ) {
				return [ $item['class'] => $item['label'] ];
			});

			$btn_options = $colors->prepend( 'Default', 'default' )->all();

			$section->add_control(
				'button_type',
				array(
					'label'        => 'Type',
					'type'         => Controls_Manager::SELECT,
					'default'      => 'default',
					'options'      => $btn_options,
					'prefix_class' => 'elementor-button-',
				),
				array(
					'overwrite' => true,
				)
			);
		}
	}
}
