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


class TeamMember extends PostType {


	/**
	 * @var string $menu_icon The post type admin menu icon (dashicons)
	 */

	public $menu_icon = 'dashicons-groups';

	public $admin_cols = array(
		// A featured image column:
		'featured_image' => array(
			'title'          => 'Profile Image',
			'featured_image' => 'thumbnail',
			'width'          => 80,
			'height'         => 80,
		),
		// The default Title column:
		'title',
		// A taxonomy terms column:
		'rwp_team_category' => array(
			'title'    => 'Category',
			'taxonomy' => 'rwp_team_category',
		),
	);


	public $args = array(
		'show_in_nav_menus' => false,
		'hierarchical' => false,
	);
}
