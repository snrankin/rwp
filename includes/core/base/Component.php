<?php

/** ============================================================================
 * ComponentInterface
 *
 * @package   RWP\/includes/engine/Interfaces/ComponentInterface.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Base;

if ( ! \defined( 'ABSPATH' ) ) {
	exit;
}
abstract class Component extends Singleton {

	/**
	 * Called on plugin activation
	 *
	 * @param bool $network_wide True if active in a multiste, false if classic
	 *                           site.
	 *
	 * @return array {
	 *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
	 * }
	 */
	public static function activate( $network_wide = false ) {

		$result = array(
			'success'  => \true,
			'messages' => array(),
		);

		if ( \function_exists( 'is_multisite' ) && \is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				/** @var array<\WP_Site> $blogs */
				$blogs = \get_sites();

				foreach ( $blogs as $blog ) {
					\switch_to_blog( (int) $blog->blog_id );
					$result = self::single_activate();
					$result['success'] &= $result['success'];
					$result['messages'] = \array_merge( $result['messages'], $result['message'] );
					\restore_current_blog();
				}

				return $result;
			}
		}

		$result = self::single_activate();
		$result['success'] &= $result['success'];
		$result['messages'] = \array_merge( $result['messages'], $result['message'] );

		return $result;
	}

	/**
	 * Called on plugin upgrade
	 *
	 * @param  string  $new_version
	 * @param  string  $old_version Version stored in the database
	 *
	 * @return array {
	 *    @type bool     $success   Was the upgrade successful
	 *    @type string[] $messages  An array of messages
	 * }
	 */

	public static function upgrade( $new_version, $old_version ) {
		$result = array(
			'success'  => \true,
			'messages' => array(),
		);

		return $result;
	}

	/**
	 * Called on plugin deactivation
	 *
	 * @param bool $network_wide True if WPMU superadmin uses "Network
	 *                           Deactivate" action, false if WPMU is disabled
	 *                           or plugin is deactivated on an individual blog.
	 * @return array {
	 *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
	 * }
	 */
	public static function deactivate( $network_wide = false ) {
		$result = array(
			'success'  => \true,
			'messages' => array(),
		);

		if ( \function_exists( 'is_multisite' ) && \is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				/** @var array<\WP_Site> $blogs */
				$blogs = \get_sites();

				foreach ( $blogs as $blog ) {
					\switch_to_blog( (int) $blog->blog_id );
					$result = self::single_deactivate();
					$result['success'] &= $result['success'];
					$result['messages'] = \array_merge( $result['messages'], $result['message'] );
					\restore_current_blog();
				}

				return $result;
			}
		}

		$result = self::single_deactivate();
		$result['success'] &= $result['success'];
		$result['messages'] = \array_merge( $result['messages'], $result['message'] );

		return $result;
	}

	/**
	 * Called on plugin uninstall
	 *
	 * @return array {
	 *     @type bool     $success   Was the uninstall successful
	 *     @type string[] $messages  An array of messages
	 * }
	 */
	public static function uninstall() {
		$result = array(
			'success'  => \true,
			'messages' => array(),
		);

		return $result;
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 0.9.0
	 * @return array {
	 *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
	 * }
	 */

	public static function single_activate() {
		$result = array(
			'success'  => \true,
			'messages' => array(),
		);

		return $result;
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 0.9.0
	 * @return array {
	 *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
	 * }
	 */
	public static function single_deactivate() {
		$result = array(
			'success'  => \true,
			'messages' => array(),
		);

		return $result;
	}
}
