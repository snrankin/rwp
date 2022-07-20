<?php

/** ============================================================================
 * Example class for REST
 *
 * @package   RWP\Rest
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Rest;

use RWP\Base\Singleton;

class Example extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		\add_action( 'rest_api_init', array( $this, 'add_custom_stuff' ) );
	}

	/**
	 * Examples
	 *
	 * @since 0.9.0
	 * @return void
	 */
	public function add_custom_stuff() {
		$this->add_custom_field();
		$this->add_custom_route();
	}

	/**
	 * Examples
	 *
	 * @since 0.9.0
	 * @return void
	 */
	public function add_custom_field() {
		\register_rest_field(
			'demo',
			RWP_PLUGIN_TEXTDOMAIN . '_text',
			array(
				'get_callback'    => array( $this, 'get_text_field' ),
				'update_callback' => array( $this, 'update_text_field' ),
				'schema'          => array(
					'description' => \__( 'Text field demo of Post type', 'rwp' ),
					'type'        => 'string',
				),
			)
		);
	}

	/**
	 * Examples
	 *
	 * @since 0.9.0
	 * @return void
	 */
	public function add_custom_route() {
		// Only an example with 2 parameters
		\register_rest_route(
			'wp/v2',
			'/calc',
			array(
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => array( $this, 'sum' ),
				'args'     => array(
					'first'  => array(
						'default'           => 10,
						'sanitize_callback' => 'absint',
					),
					'second' => array(
						'default'           => 1,
						'sanitize_callback' => 'absint',
					),
				),
			)
		);
	}

	/**
	 * Examples
	 *
	 * @since 0.9.0
	 * @param array $post_obj Post ID.
	 * @return string
	 */
	public function get_text_field( array $post_obj ) {
		$post_id = $post_obj['id'];

		return \get_post_meta( $post_id, RWP_PLUGIN_TEXTDOMAIN . '_text', true );
	}

	/**
	 * Examples
	 *
	 * @since 0.9.0
	 * @param string   $value Value.
	 * @param \WP_Post $post  Post object.
	 * @param string   $key   Key.
	 * @return bool|\WP_Error
	 */
	public function update_text_field( string $value, \WP_Post $post, string $key ) {
		$post_id = \update_post_meta( $post->ID, $key, $value );

		if ( false === $post_id ) {
			return new \WP_Error(
				'rest_post_views_failed',
				\__( 'Failed to update post views.', 'rwp' ),
				array( 'status' => 500 )
			);
		}

		return true;
	}

	/**
	 * Examples
	 *
	 * @since 0.9.0
	 * @param array $data Values.
	 * @return array
	 */
	public function sum( array $data ) {
		return array( 'result' => $data['first'] + $data['second'] );
	}
}
