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
use RWP\Internals\Bootstrap;
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

		define( 'DHZ_SHOW_DONATION_LINK', false ); //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound

		rwp_get_plugin_file( 'acf-rgba-color-picker.php', 'includes/dependencies/externals/plugins/acf/rgba-color-picker', true, true );

		\add_action( 'acf/init', array( $this, 'setup_acf' ) );
		\add_action( 'acfe/init', array( $this, 'init_acfe' ) );
		\add_action( 'acfe/save_option', array( $this, 'save_acf_options_page' ), 10, 2 );
		\add_action( 'acfe/save_term', array( $this, 'save_acf_term_fields' ), 10, 2 );
		\add_action( 'acfe/save_post', array( $this, 'save_acf_post_fields' ), 10, 2 );
		\add_action( 'acf/admin_enqueue_scripts', array( $this, 'enqueue_acf_assets' ), 999 );

		// Field Filters

		\add_filter( 'acf/load_field/name=sidebar_id', array( $this, 'add_widget_area_choices' ) );
		\add_filter( 'acf/load_field/name=bs_colors', array( $this, 'add_color_choices' ) );
		\add_action( 'acf/render_field/name=bs_colors', array( $this, 'add_color_values' ) );
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

		foreach ( glob( $path . '/*.*' ) as $file ) {
			$filename = basename( $file );
			if ( 'group_nav_item_options.php' === $filename || 'group_nav_options.php' === $filename ) {
				if ( rwp_get_option( 'modules.bootstrap.nav_menus', false ) ) {
					require_once $file;
				}
			} else {
				require_once $file;
			}
		}

		if ( function_exists( 'acf_add_options_page' ) ) {

			// Register options page.
			acf_add_options_page(array(
				'page_title' => __( 'RIESTERWP Core General Settings', 'rwp' ),
				'menu_title' => __( 'RIESTERWP Core', 'rwp' ),
				'menu_slug'  => rwp()->prefix( 'options', '-' ),
				'capability' => rwp()->get_setting( 'capability' ),
				'icon_url'   => rwp()->get_setting( 'icon' ),
				'autoload'   => true,
			));
		}
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

		$fields = self::sanitize_acf_array( $fields, $post_id ); // phpcs:ignore
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

		$fields = self::sanitize_acf_array( $fields, $term_id ); // phpcs:ignore
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

		$fields = self::sanitize_acf_array( $fields, $post_id ); // phpcs:ignore

		if ( rwp()->prefix( 'options', '-' ) === $option ) {
			rwp()->update_option( 'options', $fields );
        } else {
			$option = rwp_change_case( $option, 'snake' );
			update_option( $option, $fields );
		}

	}

	/**
	 *
	 * @param array $fields
	 * @param mixed $post_id
	 * @return mixed
	 */

	public static function sanitize_acf_array( $fields, $post_id ) {
		$acf_fields = array();

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $key => $field ) {
				if ( rwp_has_value( $key ) && rwp_has_value( $field ) ) {

					if ( \have_rows( $key, $post_id ) ) {
						if ( rwp_array_has( 'label', $field ) && is_numeric( $key ) ) {
							$key = $field['label'];
							unset( $field['label'] );
						}

						if ( 1 === count( $field ) && ! rwp_array_has( 'label', $field[0] ) && wp_is_numeric_array( $field ) ) {
							$field = reset( $field );
						}

						if ( is_array( $field ) ) {
							$field = self::sanitize_acf_array( $field, $post_id );
						}
					}
                    $acf_fields[ $key ] = $field;
				}
			}

			$fields = $acf_fields;
		}

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
		$colors = Bootstrap::bs_atts( 'colors' );

		if ( isset( $field['choices'] ) ) {

			foreach ( $colors as $color ) {
				$name = rwp_change_case( $color, 'title' );
				$field['choices'][ $color ] = $name;
			}
		}

		return $field;
	}

}
