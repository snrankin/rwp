<?php

/** ============================================================================
 * Elementor
 *
 * @package   RWP\/includes/integrations/Elementor.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;
use RWP\Integrations\Bootstrap;
use Elementor\Element_Base;
use Elementor\Plugin as Elementor_Instance;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use Elementor\Core\Experiments\Manager as Experiments_Manager;
use Elementor\Controls_Manager as Controls_Manager;


class Elementor extends Singleton {

	public $widgets = array();

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( is_plugin_active( 'elementor/elementor.php' ) ) {
			if ( rwp_get_option( 'modules.bootstrap.elementor', false ) ) {
				add_action( 'elementor/element/after_section_start', array( $this, 'remove_column_options' ), 10, 3 );
				add_action( 'elementor/element/after_section_start', array( $this, 'remove_section_options' ), 10, 3 );

				add_action( 'elementor/element/after_section_start', array( $this, 'add_column_options' ), 10, 3 );
				add_action( 'elementor/element/after_section_start', array( $this, 'add_section_options' ), 10, 3 );
				add_action( 'elementor/element/before_section_end', array( $this, 'add_button_options' ), 10, 3 );
			}
		}

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );

	}

	public function init_widgets() {
        $class = get_called_class();
		$widgets = rwp()->get_component( $class );

		if ( ! empty( $widgets ) ) {

			foreach ( $widgets as $widget ) {
				if ( $class !== $widget && ! empty( $widget ) ) {
					Elementor_Instance::instance()->widgets_manager->register_widget_type( new $widget() );
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

		$controls = $section->get_controls();

		$active_breakpoints = (array) self::plugin()->breakpoints->get_active_breakpoints();

		$devices = self::plugin()->breakpoints->get_active_devices_list( array( 'reverse' => true ) );

		if ( isset( $args['devices'] ) ) {
			$devices = array_intersect( $devices, $args['devices'] );

			$args['responsive']['devices'] = $devices;

			unset( $args['devices'] );
		}

		$breakpoints = array(
			'desktop' => 'lg',
			'tablet'  => 'md',
			'mobile'  => '',
		);

		if ( in_array( 'mobile_extra', $devices, true ) ) {
			$breakpoints['mobile_extra'] = 'sm';
		}

		if ( in_array( 'tablet_extra', $devices, true ) ) {
			$breakpoints['tablet_extra'] = 'lg';
		}

		if ( in_array( 'laptop', $devices, true ) ) {
			$breakpoints['laptop']  = 'lg';
			$breakpoints['desktop'] = 'xl';
		}

		if ( in_array( 'widescreen', $devices, true ) ) {
			$breakpoints['widescreen'] = 'xxl';
		}

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

				$direction = 'min';

				if ( Breakpoints_Manager::BREAKPOINT_KEY_DESKTOP !== $device_name ) {
					$direction = $active_breakpoints[ $device_name ]->get_direction();
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

				$section->update_control( $control_args['parent'], array( 'inheritors' => array( $control_name ) ) );

				if ( ! empty( $options['overwrite'] ) ) {
					$section->update_control($control_name, $control_args, array(
						'recursive' => ! empty( $options['recursive'] ),
					));
				} else {
					if ( rwp_array_has( $control_name, $controls ) ) {
						$section->update_control($control_name, $control_args, array(
							'recursive' => ! empty( $options['recursive'] ),
						));
					} else {
						$section->add_control( $control_name, $control_args, $options );
					}
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
	public function remove_column_options( $section, $section_id, $args ) {
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
	public function add_column_options( $section, $section_id, $args ) {
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
				)
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
				)
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
				)
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
				)
			);
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
	public function remove_section_options( $section, $section_id, $args ) {
		if ( 'section' === $section->get_name() ) {
			// $section->remove_control('gap');
			// $section->remove_responsive_control('gap_columns_custom',);
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
	public function add_section_options( $section, $section_id, $args ) {
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
				)
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
				)
			);

			self::add_responsive_control_to_elementor(
				$section,
				'gap',
				array(
					'label' => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html__( 'Default', 'rwp' ),
						'no' => esc_html__( 'No Gap', 'rwp' ),
						'narrow' => esc_html__( 'Narrow', 'rwp' ),
						'extended' => esc_html__( 'Extended', 'rwp' ),
						'wide' => esc_html__( 'Wide', 'rwp' ),
						'wider' => esc_html__( 'Wider', 'rwp' ),
						'custom' => esc_html__( 'Custom', 'rwp' ),
					],
					'prefix_class' => 'elementor-row-gap-x%s-',
				),
				array(
					'overwrite' => true,
				)
			);

			self::add_responsive_control_to_elementor(
				$section,
				'gap',
				array(
					'label' => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
				),
				array(
					'overwrite' => true,
				)
			);

			self::add_responsive_control_to_elementor(
				$section,
				'gap-x',
				array(
					'label' => esc_html__( 'Columns Horizontal Gap', 'rwp' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html__( 'Default', 'rwp' ),
						'no' => esc_html__( 'No Gap', 'rwp' ),
						'narrow' => esc_html__( 'Narrow', 'rwp' ),
						'extended' => esc_html__( 'Extended', 'rwp' ),
						'wide' => esc_html__( 'Wide', 'rwp' ),
						'wider' => esc_html__( 'Wider', 'rwp' ),
						'custom' => esc_html__( 'Custom', 'rwp' ),
					],
					'prefix_class' => 'elementor-row-gap-x%s-',
				)
			);

			self::add_responsive_control_to_elementor(
				$section,
				'gap-y',
				array(
					'label' => esc_html__( 'Columns Vertical Gap', 'rwp' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html__( 'Default', 'rwp' ),
						'no' => esc_html__( 'No Gap', 'rwp' ),
						'narrow' => esc_html__( 'Narrow', 'rwp' ),
						'extended' => esc_html__( 'Extended', 'rwp' ),
						'wide' => esc_html__( 'Wide', 'rwp' ),
						'wider' => esc_html__( 'Wider', 'rwp' ),
						'custom' => esc_html__( 'Custom', 'rwp' ),
					],
					'prefix_class' => 'elementor-row-gap-y%s-',
				)
			);
		}
	}

	/**
	 * Filter to add certain options from Elementor buttons
	 *
	 * @param Element_Base $section
	 * @param string $section_id
	 * @param array $args
	 *
	 * @return void
	 */
	public function add_button_options( $section, $section_id, $args ) {
		if ( 'button' === $section->get_name() && 'section_button' === $section_id ) {
			// Adding Bootstrap button types to elementor buttons

			$btn_options_solid = rwp_collection( Bootstrap::bs_atts( 'colors' ) );
			$btn_options_outline = rwp_collection( Bootstrap::bs_atts( 'colors', 'outline-', '', '', ' Outline' ) );

			$btn_options_solid = $btn_options_solid->mapWithKeys(function ( $item ) {
				return [ $item['value'] => $item['label'] ];
			});

			$btn_options_outline = $btn_options_outline->mapWithKeys(function ( $item ) {
				return [ $item['value'] => $item['label'] ];
			});

			$btn_options = $btn_options_solid->merge( $btn_options_outline )->prepend( 'Default', 'default' )->all();

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
