<?php

/** ============================================================================
 * Testimonials Post Type
 *
 * @package   RWP\Internals\PostTypes
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\PostTypes\Type;

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
		'exclude_from_search' => true,
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
	);

	public function __construct() {

		$this->admin_cols['rating'] = array(
			'title'    => 'Rating',
			'function' => function () {
				$field = get_field_object( 'rating' );
				echo \StarRatingField::output_stars($field); // phpcs:ignore
			},
		);

		parent::__construct();
	}
}
