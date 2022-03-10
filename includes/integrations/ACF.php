<?php
/** ============================================================================
 * ACF
 *
 * @package   RWP\Integrations
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;
use RWP\Integrations\Bootstrap;
use RWP\Vendor\Exceptions\IO\Filesystem\FileNotFoundException;
use RWP\Components\Str;
use RWP\Components\Collection;
class ACF extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
			return;
		}

		\add_action( 'acf/init', array( $this, 'setup_acf' ) );
		\add_action( 'acfe/init', array( $this, 'init_acfe' ) );
		\add_action( 'acfe/save_option', array( $this, 'save_acf_options_page' ), 10, 2 );
		\add_action( 'acfe/save_term', array( $this, 'save_acf_term_fields' ), 10, 2 );
		\add_action( 'acfe/save_post', array( $this, 'save_acf_post_fields' ), 10, 2 );
		\add_action( 'acf/admin_enqueue_scripts', array( $this, 'enqueue_acf_assets' ), 999 );

		// Field Filters

		\add_filter( 'acf/load_field/name=sidebar_id', array( $this, 'add_widget_area_choices' ) );
		\add_filter( 'acf/load_field/name=bs_bg_color', array( $this, 'add_color_choices' ) );
		\add_filter( 'acf/load_field/name=bs_text_color', array( $this, 'add_color_choices' ) );
		\add_filter( 'acf/load_field/name=bs_border_color', array( $this, 'add_color_choices' ) );
		\add_filter( 'acf/load_field/name=bs_btn_style', array( $this, 'add_color_choices' ) );

		$this->include_acf_extras();
	}

	/**
	 * Register and enqueue admin-specific styles and scripts.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */

	public function setup_acf() {

		$path = RWP_PLUGIN_ROOT . 'config/acf/';

		foreach ( glob( $path . '/*.php' ) as $file ) {
			require_once $file;
		}

		acf_update_setting( 'google_api_key', 'AIzaSyDJMJ6Ah3VGf2pLLJlI0qyT6qizD4tTj1M' );

		if ( function_exists( 'acf_add_options_page' ) ) {

			// Register options page.
			acf_add_options_page(array(
				'page_title' => __( 'RIESTERWP Core General Settings', 'rwp' ),
				'menu_title' => __( 'RIESTERWP Core', 'rwp' ),
				'menu_slug'  => rwp()->prefix( 'options', '-' ),
				'capability' => rwp()->get( 'capability' ),
				'icon_url'   => rwp()->get( 'icon' ),
				'autoload'   => true,
			));

			acf_add_options_page(array(
				'page_title' => __( 'Company Schema Information', 'rwp' ),
				'menu_title' => __( 'Company Info', 'rwp' ),
				'menu_slug'  => rwp()->prefix( 'company-info', '-' ),
				'icon_url'   => 'dashicons-building',
				'autoload'   => true,
			));
		}
	}

	/**
	 * Get ACF Addons
	 *
	 * @return void
	 * @throws FileNotFoundException
	 */
	public function include_acf_extras() {
		rwp_get_dependency_file( 'index.php', 'externals/acf/acf-quick-edit-fields', true, true );
		rwp_get_dependency_file( 'class-acf-to-rest-api.php', 'externals/acf/acf-to-rest-api', true, true );
		rwp_get_dependency_file( 'acf-star_rating_field.php', 'externals/acf/acf-star-rating-field', true, true );
		rwp_get_dependency_file( 'acf-svg-icon.php', 'externals/acf/acf-svg-icon-field', true, true );
		rwp_get_dependency_file( 'acf-background.php', 'externals/acf/acf-background-field', true, true );
		rwp_get_dependency_file( 'acf-admin-divider.php', 'externals/acf/acf-admin-divider', true, true );

	}

	/**
	 * Register and enqueue acf-specific styles and scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */

	public function enqueue_acf_assets() {
		rwp()->register_assets( 'acf' );
		rwp()->enqueue_assets( 'acf' );
	}

	/**
	 * Update settings for ACF Extended
	 *
	 * @return void
	 */

	public function init_acfe() {
		if ( function_exists( 'acfe_update_setting' ) ) {
			\acfe_update_setting( 'modules/single_meta', true );
			if ( true === WP_DEBUG ) {
				\acfe_update_setting( 'dev', true );
			}

			$path = RWP_PLUGIN_ROOT . 'config/acf/';
			\acfe_update_setting( 'php_save', $path );

			$load_paths = \acfe_get_setting( 'php_load' );
			$load_paths[] = $path;
			\acfe_update_setting( 'php_load', $load_paths );
		}
	}

	/**
     * ACFE Save Post Fields
	 *
	 * @link https://www.acf-extended.com/features/hooks-helpers/save-post
     *
     * @param string    $post_id  The Post ID
     * @param \WP_Post  $object   The WP Post Object
     */

	public function save_acf_post_fields( $post_id, $object ) {

		$fields = \get_fields( $post_id );

		$fields = self::sanitize_acf_array( $fields, '', $post_id ); // phpcs:ignore
		\update_post_meta( $object->ID, '_rwp_acf', $fields );
	}

	/**
     * ACFE Save Term Fields
	 *
	 * @link https://www.acf-extended.com/features/hooks-helpers/save-post
     *
     * @param string    $term_id  The ACF Term ID (term_{$id})
     * @param \WP_Term  $object   The WP Term Object
     */

	public function save_acf_term_fields( $term_id, $object ) {

		$fields = \get_fields( $term_id );

		$fields = self::sanitize_acf_array( $fields, '', $term_id ); // phpcs:ignore

		\update_term_meta( $object->term_id, '_rwp_acf', $fields );
	}

	/**
     * ACFE Save Options Page
	 *
	 * @link https://www.acf-extended.com/features/hooks-helpers/save-post
     *
     * @param string  $post_id  The ACF Options Page Post ID
     * @param array   $object   The ACF Options Page Settings array
     */

	public function save_acf_options_page( $post_id, $object ) {

		$option = data_get( $object, 'menu_slug', 'acf' );

		$fields = \get_fields( $post_id );

		$fields = self::sanitize_acf_array( $fields, '', $post_id ); // phpcs:ignore

		if ( rwp_str_has( $option, 'rwp-' ) ) {
			rwp()->update_option( 'options', $fields );

        } else {
			$option = rwp_change_case( $option, 'snake' );
			update_option( $option, $fields );
		}

	}

	/**
	 *
	 * @param array $fields
	 * @param string $key
	 * @param mixed $post_id
	 * @return mixed
	 */

	public static function sanitize_acf_array( $fields, $key = '', $post_id = 'options' ) {
		$acf_fields = rwp_prepare_args( $fields );

		$acf_fields = rwp_collection( $acf_fields );

		$acf_fields = $acf_fields->reject( function ( $item ) {
            return blank( $item );
		});

		if ( $acf_fields->isNotEmpty() ) {

			if ( $acf_fields->containsOneItem() ) {
				$first_item_key = $acf_fields->keys()->first();
				if ( $first_item_key === $key ) {
					$acf_fields = $acf_fields->first();

					if ( is_array( $acf_fields ) ) {
						$acf_fields = rwp_collection( $acf_fields );
					}
				}
			}

			if ( wp_is_numeric_array( $fields ) && rwp_array_is_multi( $fields ) ) {
				$acf_fields = $acf_fields->mapWithKeys(function ( $item, $key ) {
					if ( is_array( $item ) && rwp_array_has( 'label', $item ) ) {
						return [ rwp_change_case( $item['label'], 'snake' ) => $item ];
					} else {
						return [ $key => $item ];
					}
				});
			}

			$acf_fields->transform( function( $value, $key ) use ( $post_id ) {
				if ( is_array( $value ) ) {
					$value = self::sanitize_acf_array( $value, $key, $post_id );
				}

				return $value;
			} );

			switch ( $key ) {
				case 'locations':
					$acf_fields->transform( function( $value ) {
						if ( rwp_is_collection( $value ) ) {
							if ( $value->has( 'unit' ) ) {
								$unit = $value->pull( 'unit' );
								$value = data_set( $value, 'address.unit', $unit );
								$address = data_get( $value, 'address.address' );
								$street = data_get( $value, 'address.name' );
								$street_with_unit = $street . ' ' . $unit;
								$address = Str::replace( $street, $street_with_unit, $address );
								$value = data_set( $value, 'address.address', $address );
								$value = data_set( $value, 'address.name', $street_with_unit );
							}
						}

						return $value;
					} );
					break;

				case 'icon':
					$type = data_get( $acf_fields, 'type', '' );
					if ( empty( $type ) ) {
						$acf_fields = false;
					}
					break;
				case 'button':
					/**
					 * @var Collection $acf_fields
					 */
					$style = data_get( $acf_fields, 'bs_btn_style', '' );
					if ( filled( $style ) ) {
						$classes = data_get( $acf_fields, 'atts.class', array() );
						$classes[] = $style;

						$atts = $acf_fields->get( 'atts', array() );

						$atts['class'] = $classes;

						$acf_fields->put( 'atts', $atts );
					}
					break;
			}

			$fields = $acf_fields;
		}

		$fields = apply_filters( 'rwp_format_fields', $fields, $key, $post_id );

        return $fields;
    }

	/**
	 * Adding registered widget areas to fields with the name `sidebar_id`
	 *
	 * @param array $field
	 * @return array
	 */

	public function add_widget_area_choices( $field ) {
		global $wp_registered_sidebars;

		foreach ( $wp_registered_sidebars as $name => $args ) {
			$field['choices'][ $name ] = $args['name'];
		}

		// return the field
		return $field;
	}

	/**
	 * Adding colors to fields with the name `bs_colors`
	 *
	 * @param array $field
	 * @return array
	 */

	public function add_color_choices( $field ) {

		if ( isset( $field['choices'] ) ) {

			if ( rwp_str_has( $field['name'], 'bs_bg_' ) ) {
				$colors = rwp_collection( Bootstrap::bs_atts( 'colors', 'bg-' ) );
			} else if ( rwp_str_has( $field['name'], 'bs_border_' ) ) {
				$colors = rwp_collection( Bootstrap::bs_atts( 'colors', 'border-' ) );
			} else if ( rwp_str_has( $field['name'], 'bs_text_' ) ) {
				$colors = rwp_collection( Bootstrap::bs_atts( 'colors', 'text-' ) );
			} else if ( rwp_str_has( $field['name'], 'bs_btn_style' ) ) {
				$btn_options_solid = rwp_collection( Bootstrap::bs_atts( 'colors', 'btn-' ) )->mapWithKeys( function( $item ) {
					return array( $item['value'] => $item );
				});
				$btn_options_outline = rwp_collection( Bootstrap::bs_atts( 'colors', 'btn-outline-', '', '', ' Outline' ) )->mapWithKeys( function( $item ) {
					return array( $item['value'] => $item );
				});

				$colors = $btn_options_solid->merge( $btn_options_outline );

			} else {
				$colors = rwp_collection( Bootstrap::bs_atts( 'colors' ) );
			}

			$colors = $colors->mapWithKeys( function( $item ) {
				return [ $item['value'] => $item['label'] ];
			});

			$choices = rwp_collection( $field['choices'] );

			$choices = $choices->merge( $colors )->put( 'custom', 'Custom' )->unique()->all();

			$field['choices'] = $choices;
		}

		return $field;
	}

}
