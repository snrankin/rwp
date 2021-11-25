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


class Testimonial extends PostType {

	/**
	 * @var string $menu_icon The post type admin menu icon (dashicons)
	 */

	public $menu_icon = 'dashicons-star-filled';

	public $admin_cols = array(
		// The default Title column:
		'title',
		// A meta field column:
		'rating' => array(),
	);

	public $args = array(
		'has_archive'         => false,
		'public'              => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
	);

	public function initialize() {

		$this->admin_cols['rating'] = array(
			'title'       => 'Rating',
			'function' => function () {
				$field = get_field_object( 'rating' );
				echo \StarRatingField::output_stars($field); // phpcs:ignore
			},
		);

		parent::initialize();
	}

}
