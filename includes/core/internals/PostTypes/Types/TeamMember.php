<?php

/** ============================================================================
 * Team Member Post Type
 *
 * @package   RWP\Internals\PostTypes
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\PostTypes\Type;

class TeamMember extends PostType {


	/**
	 * @var string $menu_icon The post type admin menu icon (dashicons)
	 */

	public $menu_icon = 'dashicons-groups';

	public $admin_cols = array(
		// A featured image column:
		'featured_image'    => array(
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
		'hierarchical'      => false,
	);

	public function __construct() {

		parent::__construct();

		add_filter('the_title', function ( $title, $id = null ) {
			$type = get_post_type( $id );

			if ( $type === $this->type ) {
				$prefix = rwp_get_field( 'prefix', $id, '' );
				$suffix = rwp_get_field( 'suffix', $id, '' );

				$title = rwp_add_prefix( $title, $prefix );
				$title = rwp_add_suffix( $title, $suffix );
			}

			return $title;
		}, 10, 2);

		add_filter("rwp_{$this->type}_card_defaults", function ( array $defaults, \WP_Post $post ) {
			$job_title = rwp_get_field( 'job_title', $post, '' );

			if ( ! empty( $job_title ) ) {
				$defaults['subtitle'] = array(
					'content' => $job_title,
				);
			}

			return $defaults;
		}, 10, 2);
	}
}
