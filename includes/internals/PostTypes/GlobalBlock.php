<?php
/** ============================================================================
 * TeamMember
 *
 * @package   RWP\/includes/internals/PostTypes/TeamMember.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\PostTypes;

use RWP\Engine\Abstracts\PostType;


class GlobalBlock extends PostType {

	/**
	 * @var array $supports The post type supports
	 */

	public $supports = array(
		'title',
		'editor',
		'custom-fields',
	);

	/**
	 * @var string $menu_icon The post type admin menu icon (dashicons)
	 */

	public $menu_icon = 'dashicons-admin-site';

	public $args = array(
		'has_archive'         => false,
		'public'              => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
	);

}
