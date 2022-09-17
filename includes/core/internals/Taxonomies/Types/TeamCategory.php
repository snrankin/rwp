<?php

/** ============================================================================
 * Team Category Taxonomy
 *
 * @package   RWP\Internals\Taxonomies
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\Taxonomies\Types;

class TeamCategory extends Taxonomy {

	/**
	 * @var array $post_type The post type(s) this taxonomy is linked to
	 */

	public $post_type = array(
		'rwp_team_member',
	);

	/**
	 * @var array $args An array of additional arguments for the taxonomy
	 */
	public $args = array(
		'show_in_nav_menus' => false,
		'show_in_rest'      => true,
	);

	/**
	 * @var string $singular The taxonomy type
	 */

	public $singular = 'Team Category';

	/**
	 * @var string $plural The taxonomy type in plural form
	 */

	public $plural = 'Team Categories';

	/**
	 * @var string $menu The taxonomy menu title
	 */

	public $menu = 'Team Categories';

	/**
	 * @var string $slug The taxonomy url slug
	 */

	public $slug = 'team-categories';
}
