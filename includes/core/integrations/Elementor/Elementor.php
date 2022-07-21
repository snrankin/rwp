<?php

/** ============================================================================
 * Elementor
 *
 * @package   RWP\Integrations
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\Elementor;

use RWP\Base\Singleton;
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
use RWP\Html\Image;

class Elementor extends Singleton {

	public $widgets = array();

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! function_exists( 'is_plugin_active' ) || ! is_plugin_active( 'elementor/elementor.php' ) ) {
			return;
		}

		if ( rwp_get_option( 'modules.bootstrap.elementor', false ) ) {
			//\add_filter( 'body_class', array( $this, 'add_body_class' ), 10 );

			if ( rwp_get_option( 'modules.bootstrap.elementor_v2', false ) ) { // adding for backwards compatibility
				add_action( 'elementor/element/column/layout/before_section_end', array( $this, 'add_column_options_v2' ), 10, 2 );
				add_action( 'elementor/element/section/section_layout/before_section_end', array( $this, 'add_section_options_v2' ), 10, 2 );
			} else {
				add_action( 'elementor/element/column/layout/before_section_end', array( $this, 'add_column_options' ), 10, 2 );
				add_action( 'elementor/element/section/section_layout/before_section_end', array( $this, 'add_section_options' ), 10, 2 );
			}

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
	 *
	 * @param array $classes
	 * @return string[]
	 */
	public function add_body_class( array $classes = [] ) {
		if ( rwp_get_option( 'modules.bootstrap.elementor_v2', false ) ) {
			$classes = rwp_parse_classes( $classes, rwp()->prefix( 'elementor-grid-v2', 'slug' ) );
		}
		$classes = rwp_parse_classes( $classes, rwp()->prefix( 'elementor', 'slug' ) );

		return $classes;
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

	/**
	 * Add responsive options to elementor elements based on bootstrap breakpoints
	 *
	 * @param Element_Base $section
	 * @param string $id
	 * @param array $args
	 * @param array $options
	 *
	 * @return void
	 */
	public static function add_responsive_control_to_elementor( &$section, $id, $args, $options = array() ) {
		$args['responsive'] = array();

		$active_breakpoints = (array) self::plugin()->breakpoints->get_active_breakpoints();

		$devices = self::plugin()->breakpoints->get_active_devices_list( array( 'reverse' => true ) );

		if ( isset( $args['devices'] ) ) {
			$devices = array_intersect( $devices, $args['devices'] );

			$args['responsive']['devices'] = $devices;

			unset( $args['devices'] );
		}

		$breakpoints = array(
			'widescreen'   => 'xxl',
			'desktop'      => 'xl',
			'laptop'       => 'lg',
			'tablet_extra' => 'ml',
			'tablet'       => 'md',
			'mobile_extra' => 'sm',
			'mobile'       => '',
		);

		$breakpoints = array_filter($breakpoints, function ( $device ) use ( $devices ) {
			return in_array( $device, $devices, true );
		}, ARRAY_FILTER_USE_KEY);

		$responsive_duplication_mode   = self::plugin()->breakpoints->get_responsive_control_duplication_mode();
		$additional_breakpoints_active = self::plugin()->experiments->is_feature_active( 'additional_custom_breakpoints' );
		$control_is_dynamic            = ! empty( $args['dynamic']['active'] );
		$is_frontend_available         = ! empty( $args['frontend_available'] );
		$has_prefix_class              = ! empty( $args['prefix_class'] );

		// If the new responsive controls experiment is active, create only one control - duplicates per device will
		// be created in JS in the Editor.
		if ( $additional_breakpoints_active && ( 'off' === $responsive_duplication_mode || ( 'dynamic' === $responsive_duplication_mode && ! $control_is_dynamic ) ) && ! $is_frontend_available && ! $has_prefix_class ) {
			$args['is_responsive'] = true;

			if ( ! empty( $options['overwrite'] ) ) {
				$section->update_control($id, $args, array(
					'recursive' => ! empty( $options['recursive'] ),
				));
			} else {
				$section->add_control( $id, $args, $options );
			}

			return;
		}

		if ( isset( $args['default'] ) ) {
			$args['desktop_default'] = $args['default'];

			unset( $args['default'] );
		}

		if ( ! empty( $breakpoints ) ) {
			foreach ( $breakpoints as $device_name => $device_class ) {
				$control_args = $args;

				// Set parent using the name from previous iteration.
				$control_args['parent'] = isset( $control_name ) ? $control_name : null;

				if ( isset( $control_args['device_args'] ) ) {
					if ( ! empty( $control_args['device_args'][ $device_name ] ) ) {
						$control_args = array_merge( $control_args, $control_args['device_args'][ $device_name ] );
					}

					unset( $control_args['device_args'] );
				}

				if ( ! empty( $args['prefix_class'] ) ) {
					$device_prefix_class = $device_class;
					if ( ! empty( $device_prefix_class ) ) {
						$device_prefix_class = '-' . $device_prefix_class;
					}
					$control_args['prefix_class'] = wp_sprintf( $args['prefix_class'], $device_prefix_class );
				}

				$direction = 'max';

				if ( Breakpoints_Manager::BREAKPOINT_KEY_DESKTOP !== $device_name ) {
					if ( rwp_array_has( $device_name, $active_breakpoints ) ) {
						$direction = $active_breakpoints[ $device_name ]->get_direction();
					}
				}

				$control_args['responsive'][ $direction ] = $device_name;

				if ( isset( $control_args['min_affected_device'] ) ) {
					if ( ! empty( $control_args['min_affected_device'][ $device_name ] ) ) {
						$control_args['responsive']['min'] = $control_args['min_affected_device'][ $device_name ];
					}

					unset( $control_args['min_affected_device'] );
				}

				if ( isset( $control_args[ $device_name . '_default' ] ) ) {
					$control_args['default'] = $control_args[ $device_name . '_default' ];
				}

				foreach ( $devices as $device ) {
					unset( $control_args[ $device . '_default' ] );
				}

				$id_suffix = '_' . $device_class;

				$control_name = $id . $id_suffix;

				if ( ! empty( $control_args['parent'] ) ) {
					$section->update_control( $control_args['parent'], array( 'inheritors' => array( $control_name ) ) );
				}
				$control_exists = false;
				$section_name = $section->get_unique_name();
				$existing_control = self::plugin()->controls_manager->get_control_from_stack( $section_name, $control_name );

				if ( ! is_wp_error( $existing_control ) ) {
					$control_exists = true;
				}

				if ( ! empty( $options['overwrite'] ) || $control_exists ) {
					$section->update_control( $control_name, $control_args, $options );
				} else {
					$section->add_control( $control_name, $control_args, $options );
				}
			}
		}
	}

	/**
	 * Filter to remove certain options from Elementor columns
	 *
	 * @param Element_Base $section
	 * @param string $section_id
	 * @param array $args
	 *
	 * @return void
	 */
	public function remove_column_options( $section, $args ) {
		if ( 'column' === $section->get_name() ) {
			$section->remove_responsive_control( '_inline_size' );
			$section->remove_responsive_control( 'align' );
			$section->remove_responsive_control( 'content_position' );
		}
	}

	/**
	 * Filter to add certain options from Elementor columns
	 *
	 * @param Element_Base $section
	 * @param string $section_id
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_column_options( $section, $args ) {
		if ( 'column' === $section->get_name() ) {
			$col_class = $section->get_render_attributes( '_wrapper', 'class' );

			if ( empty( $col_class ) || ! in_array( 'col', $col_class, true ) ) {
				$section->add_render_attribute( '_wrapper', 'class', 'col' );
			}

			self::add_responsive_control_to_elementor(
				$section,
				'_col_size',
				array(
					'label'        => 'Column Width',
					'type'         => Controls_Manager::TEXT,
					'prefix_class' => 'col%s-',
				),
			);

			self::add_responsive_control_to_elementor(
				$section,
				'content_direction',
				array(
					'label'        => esc_html__( 'Flex: Direction', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						''       => esc_html__( 'Default', 'rwp' ),
						'row'    => esc_html__( 'Horizontal', 'rwp' ),
						'column' => esc_html__( 'Vertical', 'rwp' ),
					),
					'prefix_class' => 'elementor-column-align%s-',
				),
			);

			self::add_responsive_control_to_elementor(
				$section,
				'content_horizontal_alignment',
				array(
					'label'        => esc_html__( 'Flex: Justify Content', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						''              => esc_html__( 'Default', 'rwp' ),
						'start'         => esc_html__( 'Left', 'rwp' ),
						'center'        => esc_html__( 'Center', 'rwp' ),
						'end'           => esc_html__( 'Right', 'rwp' ),
						'space-between' => esc_html__( 'Space Between', 'rwp' ),
						'space-around'  => esc_html__( 'Space Around', 'rwp' ),
						'space-evenly'  => esc_html__( 'Space Evenly', 'rwp' ),
					),
					'prefix_class' => 'elementor-column-h-align%s-',
				),
			);
			self::add_responsive_control_to_elementor(
				$section,
				'content_vertical_alignment',
				array(
					'label'        => esc_html__( 'Flex: Align Items', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						''        => esc_html__( 'Default', 'rwp' ),
						'start'   => esc_html__( 'Top', 'rwp' ),
						'center'  => esc_html__( 'Center', 'rwp' ),
						'end'     => esc_html__( 'Bottom', 'rwp' ),
						'stretch' => esc_html__( 'Full Width', 'rwp' ),
					),
					'prefix_class' => 'elementor-column-v-align%s-',
				),
			);

			self::add_responsive_control_to_elementor(
				$section,
				'content_vertical_wrap',
				array(
					'label'        => esc_html__( 'Flex: Align Content', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						''              => esc_html__( 'Default', 'rwp' ),
						'start'         => esc_html__( 'Top', 'rwp' ),
						'center'        => esc_html__( 'Center', 'rwp' ),
						'end'           => esc_html__( 'Bottom', 'rwp' ),
						'space-between' => esc_html__( 'Space Between', 'rwp' ),
						'space-around'  => esc_html__( 'Space Around', 'rwp' ),
						'stretch'       => esc_html__( 'Fill Rows', 'rwp' ),
					),
					'prefix_class' => 'elementor-column-v-wrap%s-',
				),
			);
		}
	}

	/**
	 * Filter to add certain options from Elementor columns
	 *
	 * @param Element_Base $section
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_column_options_v2( $section, $args ) {
		if ( 'column' === $section->get_name() ) {
			$col_class = $section->get_render_attributes( '_wrapper', 'class' );

			if ( empty( $col_class ) || ! in_array( 'e-col', $col_class, true ) ) {
				$section->add_render_attribute( '_wrapper', 'class', 'e-col' );
			}

			$section->add_responsive_control(
				'_inline_size',
				array(
					'label'   => esc_html__( 'Column Width', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control(
				'align',
				array(
					'label'   => esc_html__( 'Column Width', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control(
				'content_position',
				array(
					'label'   => esc_html__( 'Column Width', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control(
				'space_between_widgets',
				array(
					'label'   => esc_html__( 'Column Width', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control('_col_size', array(
				'label'          => 'Column Width',
				'type'           => Controls_Manager::TEXT,
				'prefix_class'   => 'e-col%s-',
				'mobile_default' => '12',

			));

			$section->add_group_control(
				Group_Control_Flex_Container::get_type(),
				[
					'name'     => 'flex',
					'selector' => '{{WRAPPER}} > .elementor-column-wrap > .elementor-widget-wrap',
					'exclude'  => array( 'gap' ),
				]
			);

			$section->add_responsive_control('gap_x', [
				'label'     => esc_html_x( 'Items Horizontal Gap', 'Flex Item Control', 'rwp' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 15,
						'step' => 1,
					],
				],

				'selectors' => [
					'{{WRAPPER}} > .elementor-column-wrap > .elementor-widget-wrap' => '--gap-x: var(--bs-gutter-x-{{SIZE}});',
				],
			]);

			$section->add_responsive_control('gap_y', [
				'label'     => esc_html_x( 'Items Vertical Gap', 'Flex Item Control', 'rwp' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 15,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-column-wrap > .elementor-widget-wrap' => '--gap-y: var(--bs-gutter-y-{{SIZE}});',
				],
			]);

			$section->add_responsive_control('page_gutter_padding', [
				'label'        => 'Page Gutter Padding',
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'description'  => 'Add padding to the column equal to the width of the main grid gutter',
				'separator'    => 'before',
				'prefix_class' => 'e-pg%s-',
				'options'      => [
					'left'  => [
						'title' => esc_html( 'Left', 'rwp' ),
						'icon'  => 'eicon-flex eicon-align-start-h',
					],
					'right' => [
						'title' => esc_html( 'Right', 'rwp' ),
						'icon'  => 'eicon-flex eicon-align-end-h',
					],
					'both'  => [
						'title' => esc_html( 'Both', 'rwp' ),
						'icon'  => 'eicon-flex eicon-align-stretch-h',
					],
				],
				'default'      => '',
				'toggle'       => true,
			]);

			$section->add_responsive_control('stretch_col', [
				'label'        => 'Stretched Column',
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'description'  => 'Stretch the column to the edge of the page.',
				'options'      => [
					'left'  => [
						'title' => esc_html( 'Left', 'rwp' ),
						'icon'  => 'eicon-flex eicon-align-start-h',
					],
					'right' => [
						'title' => esc_html( 'Right', 'rwp' ),
						'icon'  => 'eicon-flex eicon-align-end-h',
					],
					'both'  => [
						'title' => esc_html( 'Both', 'rwp' ),
						'icon'  => 'eicon-flex eicon-align-stretch-h',
					],
				],
				'prefix_class' => 'e-col-stretched%s-',
				'separator'    => 'after',
				'default'      => '',
				'toggle'       => true,
			]);
		}
	}

	/**
	 * Filter to remove certain options from Elementor sections
	 *
	 * @param Element_Base $section
	 * @param string $section_id
	 * @param array $args
	 *
	 * @return void
	 */
	public function remove_section_options( $section, $args ) {
		if ( 'section' === $section->get_name() ) {
			$section->remove_control( 'column_position' );
			$section->remove_control( 'content_position' );
		}
	}

	/**
	 * Filter to add certain options from Elementor sections
	 *
	 * @param Element_Base $section
	 * @param string $section_id
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_section_options( $section, $args ) {
		if ( 'section' === $section->get_name() ) {
			self::add_responsive_control_to_elementor(
				$section,
				'column_horizontal_alignment',
				array(
					'label'        => esc_html__( 'Column Horizontal Alignment', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						''              => esc_html__( 'Default', 'rwp' ),
						'start'         => esc_html__( 'Start', 'rwp' ),
						'center'        => esc_html__( 'Center', 'rwp' ),
						'end'           => esc_html__( 'End', 'rwp' ),
						'space-between' => esc_html__( 'Space Between', 'rwp' ),
						'space-around'  => esc_html__( 'Space Around', 'rwp' ),
						'space-evenly'  => esc_html__( 'Space Evenly', 'rwp' ),
					),
					'prefix_class' => 'elementor-row-h-align%s-',
				),
			);
			self::add_responsive_control_to_elementor(
				$section,
				'column_vertical_alignment',
				array(
					'label'        => esc_html__( 'Column Vertical Alignment', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						''         => esc_html__( 'Default', 'rwp' ),
						'start'    => esc_html__( 'Top', 'rwp' ),
						'center'   => esc_html__( 'Center', 'rwp' ),
						'end'      => esc_html__( 'Bottom', 'rwp' ),
						'baseline' => esc_html__( 'Baseline', 'rwp' ),
						'stretch'  => esc_html__( 'Stretch', 'rwp' ),
					),
					'prefix_class' => 'elementor-row-v-align%s-',
				),
			);

			self::add_responsive_control_to_elementor(
				$section,
				'row-gap',
				array(
					'label'        => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => [
						'default'  => esc_html__( 'Default', 'rwp' ),
						'no'       => esc_html__( 'No Gap', 'rwp' ),
						'narrow'   => esc_html__( 'Narrow', 'rwp' ),
						'extended' => esc_html__( 'Extended', 'rwp' ),
						'wide'     => esc_html__( 'Wide', 'rwp' ),
						'wider'    => esc_html__( 'Wider', 'rwp' ),
						'custom'   => esc_html__( 'Custom', 'rwp' ),
					],
					'prefix_class' => 'elementor-row-gap-%s-',
				),
				array(
					'overwrite' => true,
				)
			);

			self::add_responsive_control_to_elementor(
				$section,
				'gap',
				array(
					'label'   => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			self::add_responsive_control_to_elementor(
				$section,
				'row-gap-x',
				array(
					'label'        => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => [
						''         => esc_html__( 'Default', 'rwp' ),
						'no'       => esc_html__( 'No Gap', 'rwp' ),
						'narrow'   => esc_html__( 'Narrow', 'rwp' ),
						'extended' => esc_html__( 'Extended', 'rwp' ),
						'wide'     => esc_html__( 'Wide', 'rwp' ),
						'wider'    => esc_html__( 'Wider', 'rwp' ),
						'custom'   => esc_html__( 'Custom', 'rwp' ),
					],
					'prefix_class' => 'elementor-row-gap-x%s-',
				),
			);

			self::add_responsive_control_to_elementor(
				$section,
				'row-gap-y',
				array(
					'label'        => esc_html__( 'Columns Vertical Gap', 'rwp' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => [
						''         => esc_html__( 'Default', 'rwp' ),
						'no'       => esc_html__( 'No Gap', 'rwp' ),
						'narrow'   => esc_html__( 'Narrow', 'rwp' ),
						'extended' => esc_html__( 'Extended', 'rwp' ),
						'wide'     => esc_html__( 'Wide', 'rwp' ),
						'wider'    => esc_html__( 'Wider', 'rwp' ),
						'custom'   => esc_html__( 'Custom', 'rwp' ),
					],
					'prefix_class' => 'elementor-row-gap-y%s-',
				),
			);
		}
	}

	/**
	 * Filter to add certain options from Elementor sections
	 *
	 * @param Element_Base $section
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_section_options_v2( $section, $args ) {
		if ( 'section' === $section->get_name() ) {

			$section->add_responsive_control(
				'column_position',
				array(
					'label'   => esc_html__( 'Column Width', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control(
				'content_position',
				array(
					'label'   => esc_html__( 'Column Width', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_control(
				'container_type',
				[
					'type'      => Controls_Manager::HIDDEN,
					'default'   => 'flex',
					'selectors' => [
						'{{WRAPPER}}' => '--display: {{VALUE}}',
					],
				]
			);

			$section->add_control(
				'content_width',
				[
					'label'                => esc_html__( 'Content Width', 'rwp' ),
					'type'                 => Controls_Manager::SELECT,
					'default'              => 'boxed',
					'options'              => [
						'boxed' => esc_html__( 'Boxed', 'rwp' ),
						'full'  => esc_html__( 'Full Width', 'rwp' ),
					],
					'render_type'          => 'ui',
					'selectors'            => [
						'{{WRAPPER}} > .elementor-container' => '{{VALUE}}',
					],
					'selectors_dictionary' => [
						'boxed' => '--width: 100%;',
						'full'  => '--content-width: 100%;',
					],
				],
				array(
					'overwrite' => true,
				)
			);

			$section->add_responsive_control(
				'gap',
				array(
					'label'   => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			$section->add_group_control(
				Group_Control_Flex_Container::get_type(),
				[
					'name'     => 'flex',
					'selector' => '{{WRAPPER}} > .elementor-container > .elementor-row',
					'exclude'  => array( 'gap' ),
				]
			);

			$section->add_responsive_control('gap_x', [
				'label'     => esc_html_x( 'Columns Horizontal Gap', 'Flex Item Control', 'rwp' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 15,
						'step' => 1,
					],
				],
				'default'   => array(
					'unit' => 'px',
					'size' => 4,
				),
				'selectors' => [
					'{{WRAPPER}} > .elementor-container > .elementor-row' => '--gap-x: var(--bs-gutter-x-{{SIZE}});',
				],
			]);

			$section->add_responsive_control('gap_y', [
				'label'     => esc_html_x( 'Columns Vertical Gap', 'Flex Item Control', 'rwp' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 15,
						'step' => 1,
					],
				],
				'default'   => array(
					'unit' => 'px',
					'size' => 4,
				),
				'selectors' => [
					'{{WRAPPER}} > .elementor-container > .elementor-row' => '--gap-y: var(--bs-gutter-y-{{SIZE}});',
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

			$btn_options_solid = rwp_collection( rwp_bootstrap_colors() )->mapWithKeys(function ( $item ) {
				return array( $item['class'] => $item );
			});
			$btn_options_outline = rwp_collection( rwp_bootstrap_colors( 'outline-', '', '', ' Outline' ) )->mapWithKeys(function ( $item ) {
				return array( $item['class'] => $item );
			});

			$colors = $btn_options_solid->merge( $btn_options_outline );

			$colors = $colors->mapWithKeys(function ( $item ) {
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
