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

	public function initialize() {
		$this->admin_cols['rating'] = array(
			'title'       => 'Rating',
			'function' => function () {
				$field = get_field_object( 'rating' );
				echo \StarRatingField::output_stars($field); // phpcs:ignore
			},
		);
	}

}
