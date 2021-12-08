<?php
/** ============================================================================
 * TeamMember
 *
 * @package   RWP\/includes/internals/PostTypes/TeamMember.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\PostTypes;

use RWP\Engine\Abstracts\PostType;


class LandingPage extends PostType {

	/**
	 * @var string $menu_icon The post type admin menu icon (dashicons)
	 */

	public $menu_icon = 'dashicons-welcome-widgets-menus';

	public $args = array(
		'has_archive' => false,
		'rewrite'     => array(
			'slug'       => '/',
		),
	);

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		parent::initialize();

		/**
		 * Remove the slug from published post permalinks.
		 * Only affect landing pages.
		 *
		 * @link https://gist.github.com/kellenmace/a79dfde1e5a14d51a8014d880dac52e7
		 */

		\add_filter( 'post_type_link', function ( $post_link, $post ) {

			if ( $this->type === $post->post_type && 'publish' === $post->post_status ) {
				$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
			}

			return $post_link;
		}, 10, 2 );

		/**
		 * Have WordPress match postname to any of our public post types
		 * All of our public post types can have /post-name/ as the slug, so
		 * they need to be unique across all posts. By default, WordPress only
		 * accounts for posts and pages where the slug is /post-name/.
		 *
		 * @link https://gist.github.com/kellenmace/fae42a47342d0ee4fe4a
		 *
		 * @param $query The current query.
		 */

		\add_action('pre_get_posts', function ( $wp_query ) {

			/**
			 * @var \WP_Query $query
			 */

			$query = $wp_query;

			// Bail if this is not the main query.
			if ( ! $query->is_main_query() ) {
				return;
			}

			// Bail if this query doesn't match our very specific rewrite rule.
			if ( ! isset( $query->query['page'] ) ) {
				return;
			}

			// Bail if we're not querying based on the post name.
			if ( empty( $query->query['name'] ) ) {
				return;
			}

			$post_types = array_keys( get_post_types( array(
				'public' => true,
				'publicly_queryable' => true,
			) ) );

			$post_types[] = 'page';

			// // Add CPT to the list of post types WP will include when it queries based on the post name.
			// $post_types = $query->get( 'post_type', $post_types );

			// if ( is_string( $post_types ) ) {
			// 	$post_types = explode( ', ', $post_types );
			// }

			// if ( ! rwp_array_has( $this->type, $post_types ) ) {

			// 	$post_types[] = $this->type;

            // }
			$query->set( 'post_type', $post_types );
		});
	}
}
