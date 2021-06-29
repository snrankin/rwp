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

use RWP\Engine\Base;

class ACF extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		\add_action( 'acf/init', array( $this, 'add_plugin_admin_menu' ) );
		\add_action( 'acf/init', array( $this, 'setup_acf' ) );
		\add_action( 'acfe/init', array( $this, 'init_acfe' ) );
		\add_action( 'acfe/save_option/slug=' . $this->prefix( 'options', '-' ), array( $this, 'save_acf_options' ), 10, 2 );
		\add_action( 'acfe/save_term', array( $this, 'save_acf_term_fields' ), 10, 2 );
		\add_action( 'acfe/save_post', array( $this, 'save_acf_post_fields' ), 10, 2 );
		\add_action( 'acf/admin_enqueue_scripts', array( $this, 'enqueue_acf_assets' ), 999 );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress
	 * Dashboard menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function add_plugin_admin_menu() {
		// Check function exists.
		if ( function_exists( 'acf_add_options_page' ) ) {

			// Register options page.
			acf_add_options_page(array(
				'page_title' => __( 'RIESTERWP Core General Settings', 'rwp' ),
				'menu_title' => __( 'RIESTERWP Core', 'rwp' ),
				'menu_slug'  => $this->prefix( 'options', '-' ),
				'capability' => $this->get_setting( 'capability' ),
				'icon_url'   => $this->get_setting( 'icon' ),
				'autoload'   => true,
			));
		}
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
			require_once $file;
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
		$this->register_assets( 'acf' );
		$this->enqueue_assets( 'acf' );
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

			$load_paths = \acf_get_setting( 'php_load' );
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
		if ( ! empty( $fields ) ) {
			\update_post_meta( $object->ID, '_rwp_acf', $fields );
		}
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
		if ( ! empty( $fields ) ) {
			\update_term_meta( $object->term_id, '_rwp_acf', $fields );
		}
	}

	/**
     * ACFE Save Options Page
	 *
	 * @link https://www.acf-extended.com/features/hooks-helpers/save-post
     *
     * @param string  $post_id  The ACF Options Page Post ID
     * @param array   $object   The ACF Options Page Settings array
     */

	public function save_acf_options( $post_id, $object ) {

		$fields = \get_fields( $post_id );

		$fields = self::sanitize_acf_array( $fields, $post_id ); // phpcs:ignore
		if ( ! empty( $fields ) ) {
			$this->update_option( 'options', $fields );
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

}
