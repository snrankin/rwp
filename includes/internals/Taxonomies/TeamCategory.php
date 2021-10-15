<?php
/** ============================================================================
 * TeamCategory
 *
 * @package   RWP\/includes/internals/Taxonomies/TeamCategory.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\Taxonomies;

use RWP\Engine\Abstracts\Taxonomy;


class TeamCategory extends Taxonomy {

	/**
	 * @var array $post_type The post type(s) this taxonomy is linked to
	 */

	public $post_type = array(
		'rwp_team_member',
	);

}
