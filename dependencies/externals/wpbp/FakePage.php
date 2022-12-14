<?php
/**
 * Simple class that generate a fake page on the fly
 * Based on https://coderwall.com/p/fwea7g
 * Update to work on last Wordpress version
 *
 * @author    Ohad Raz & Mte90 <mte90net@gmail.com>
 * @license   GPL-2.0+
 * @copyright 2014-2015
 */

namespace RWP\Vendor\WPBP;

if ( !class_exists( 'RWP\\Vendor\\WPBP\\FakePage' ) ) {

	class FakePage {

		/**
		 *
		 * @var string
		 */
		public $slug = '';

		/**
		 *
		 * @var array
		 */
		public $args = array();

		/**
		 *
		 * @var integer
		 */
		public $id;

		public $footer;

		/**
		 * initialize the Fake Page
		 * @param array $args
		 * @author Ohad Raz
		 *
		 * @param array $args
		 *
		 */
		function __construct( $args ) {
			add_filter( 'the_posts', array( $this, 'fake_page_filter' ) );
			$this->args = $args;
			$this->slug = $args[ 'slug' ];
			$this->id = '-1';

			if ($this->is_fake_page()){
				add_action( 'wp_footer', function () {
					echo $this->footer;
				}, 100 );
			}

		}

		public function is_fake_page(){
			global $wp;
			return ('404' === $wp->query_vars[ 'error' ] ) &&
				(strtolower( $wp->request ) === $this->slug ||
				isset( $wp->query_vars[ 'page_id' ] ) && $wp->query_vars[ 'page_id' ] === $this->slug );
		}

		/**
		 * Catches the request and returns the page as if it was retrieved from
		 * the database
		 *
		 * @param  array $posts
		 * @return array
		 * @author Ohad Raz & Mte90
		 */
		public function fake_page_filter( $posts ) {
			global $wp_query;

			// Check if user is requesting our fake page

			if ($this->is_fake_page()) {
				// Create a fake post
				$post = new \stdClass;
				$post->ID = $this->id;
				$post->post_author = 1;
				// Dates may need to be overwritten if you have a "recent posts" widget or similar - set to whatever you want
				$post->post_date = current_time( 'mysql' );
				$post->post_date_gmt = current_time( 'mysql', 1 );
				$post->post_title = $this->args[ 'post_title' ];
				$post->post_content = $this->args[ 'post_content' ];
				$post->comment_status = 'closed';
				$post->ping_status = 'closed';
				$post->post_parent = 0;
				$post->menu_item_parent = 0;
				$post->post_password = '';
				$post->post_name = $this->slug;
				$post->to_ping = '';
				$post->pinged = '';
				$post->modified = $post->post_date;
				$post->modified_gmt = $post->post_date_gmt;
				$post->guid = get_bloginfo( 'wpurl' . '/' . $this->slug );
				$post->url = get_bloginfo( 'wpurl' . '/' . $this->slug );
				$post->menu_order = 0;
				$post->post_type = 'page';
				$post->post_status = 'publish';
				$post->post_mime_type = '';
				$post->comment_count = 0;
				$post->description = '';
				$post->filter = 'raw';
				$post->ancestors = array();

				$post = ( object ) array_merge( ( array ) $post, ( array ) $this->args );

				if ( is_admin() ) {
					$post = new \WP_Post( $post );
				}
				$GLOBALS[ 'post' ] = $post;
				$posts = array( $post );

				$wp_query->is_page = true;
				$wp_query->is_singular = true;
				$wp_query->is_home = false;
				$wp_query->is_archive = false;
				$wp_query->is_category = false;
				$wp_query->is_404 = false;
				unset( $wp_query->query[ "error" ] );
				$wp_query->query_vars[ "error" ] = "";
				$wp_query->found_posts = 1;
				$wp_query->post_count = 1;
				$wp_query->comment_count = 0;
				$wp_query->current_comment = null;
				$wp_query->queried_object = $post;
				$wp_query->queried_object_id = $post->ID;
				$wp_query->current_post = $post->ID;
			}

			return $posts;
		}

	}

}
