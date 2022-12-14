<?php

/** ============================================================================
 * CustomBulkActions
 *
 * @package   RWP\Internals
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals;

class CustomBulkAction {


	public $bulk_action_post_type;
	private $actions = array();

	public function __construct( $args = '' ) {
		//Define which post types these bulk actions affect.
		$defaults = array( 'post_type' => 'post' );
		$args = \wp_parse_args( $args, $defaults );
		//Define args as their own variables as well eg. $post_type
		\extract($args, \EXTR_SKIP);  //phpcs:ignore
		$this->bulk_action_post_type = $post_type;
	}

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function init() {
		if ( \is_admin() ) {
			// admin actions/filters
			\add_action( 'admin_footer-edit.php', array( $this, 'custom_bulk_admin_footer' ) );
			\add_action( 'load-edit.php', array( $this, 'custom_bulk_action' ) );
			\add_action( 'admin_notices', array( $this, 'custom_bulk_admin_notices' ) );
		}
	}
	/**
	 * Define all your custom bulk actions and corresponding callbacks
	 * Define at least $menu_text and $callback parameters
	 */
	public function register_bulk_action( $args = '' ) {
		$defaults = array( 'action_name' => '' );
		$args = \wp_parse_args( $args, $defaults );
		//Define args as their own variables as well eg. $post_type
		\extract($args, \EXTR_SKIP); // phpcs:ignore
		$func = array();
		$func['callback'] = $callback;
		$func['menu_text'] = $menu_text;
		$func['admin_notice'] = $admin_notice;
		if ( '' === $action_name ) {
			//Convert menu text to action_name 'Mark as sold' => 'mark_as_sold'
			$action_name = \lcfirst( \str_replace( ' ', '_', $menu_text ) );
		}
		$this->actions[ $action_name ] = $func;
	}

	/**
	 * Step 1: add the custom Bulk Action to the select menus
	 */
	public function custom_bulk_admin_footer() {
		global $post_type;
		//Only permit actions with defined post type
		if ( $post_type == $this->bulk_action_post_type ) {

			$js = '<script type="text/javascript">';
			$js .= 'jQuery(document).ready(function() {';
			foreach ( $this->actions as $action_name => $action ) {
				$js .= "jQuery('<option>').val('$action_name').text('{$action['menu_text']}').appendTo('select[name='action']')";
				$js .= "jQuery('<option>').val('$action_name').text('{$action['menu_text']}').appendTo('select[name='action2']')";
			}
			$js .= '});';
			$js .= '</script>';

			echo $js; //phpcs:ignore
		}
	}
	/**
	 * Step 2: handle the custom Bulk Action
	 *
	 * @link http://wordpress.stackexchange.com/questions/29822/custom-bulk-action
	 */
	public function custom_bulk_action() {
		global $typenow;
		$post_type = $typenow;
		if ( $post_type == $this->bulk_action_post_type ) {
			// get the action
			$wp_list_table = \_get_list_table( 'WP_Posts_List_Table' );
			// depending on your resource type this could be\WP_Users_List_Table,\WP_Comments_List_Table, etc
			$action = $wp_list_table->current_action();
			// allow only defined actions
			$allowed_actions = \array_keys( $this->actions );
			if ( ! \in_array( $action, $allowed_actions ) ) {
				return;
			}
			// security check
			\check_admin_referer( 'bulk-posts' );
			// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
			if ( isset( $_REQUEST['post'] ) ) {
				$post_ids = \array_map( 'intval', $_REQUEST['post'] );
			}
			if ( empty( $post_ids ) ) {
				return;
			}
			// this is based on wp-admin/edit.php
			$sendback = \remove_query_arg( array( 'exported', 'untrashed', 'deleted', 'ids' ), wp_get_referer() );
			if ( ! $sendback ) {
				$sendback = \admin_url( "edit.php?post_type={$post_type}" );
			}
			$pagenum = $wp_list_table->get_pagenum();
			$sendback = \add_query_arg( 'paged', $pagenum, $sendback );
			if ( \version_compare( \PHP_VERSION, '5.3.0' ) >= 0 ) {
				//check that we have anonymous function as a callback
				$anon_fns = \array_filter($this->actions[ $action ], function ( $el ) {
					return $el instanceof \Closure;
				});
				if ( \count( $anon_fns ) != 0 ) {
					//Finally use the callback
					$result = $this->actions[ $action ]['callback']( $post_ids );
				} else {
					$result = \call_user_func( $this->actions[ $action ]['callback'], $post_ids );
				}
			} else {
				$result = \call_user_func( $this->actions[ $action ]['callback'], $post_ids );
			}
			$sendback = \add_query_arg(array(
				'success_action' => $action,
				'ids'            => \join( ',', $post_ids ),
			), $sendback);
			$sendback = \remove_query_arg( array( 'action', 'paged', 'mode', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status', 'post', 'bulk_edit', 'post_view' ), $sendback );
			\wp_redirect( $sendback );
			exit;
		}
	}
	/**
	 * Step 3: display an admin notice after action
	 */
	public function custom_bulk_admin_notices() {
		global $post_type, $pagenow;
		if ( isset( $_REQUEST['ids'] ) ) {
			$post_ids = data_get( $_REQUEST, 'ids', '' );
			$post_ids = \explode( ',', $post_ids );
		}
		// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
		if ( empty( $post_ids ) ) {
			return;
		}
		$post_ids_count = 1;
		if ( \is_array( $post_ids ) ) {
			$post_ids_count = \count( $post_ids );
		}
		if ( 'edit.php' === $pagenow && $post_type == $this->bulk_action_post_type ) {
			if ( isset( $_REQUEST['success_action'] ) ) {
				//Print notice in admin bar
				$success_action = data_get( $_REQUEST, 'success_action', '' );
				$message = $this->actions[ $success_action ]['admin_notice'];
				if ( \is_array( $message ) ) {
					$single = $message['single'];
					$plural = $message['plural'];
					$message = \sprintf(\_n($single, $plural, $post_ids_count, 'rwp'), $post_ids_count); //phpcs:ignore
				}
				$class = 'updated notice is-dismissible above-h2';
				if ( ! empty( $message ) ) {
					echo "<div class=\"{$class}\"><p>{$message}</p></div>"; //phpcs:ignore
				}
			}
		}
	}
}
