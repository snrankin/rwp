<?php

/** ============================================================================
 * CPT
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/CPT.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;

trait CPT {

	/**
	 * Registered Post Types
	 *
	 *
	 * @var array|Collection $cpts
	 */
	public $cpts = [
		'global_content' => [
			'singular' => 'Global Block',
			'plural'   => 'Global Blocks',
			'menu'     => 'Global Blocks',
			'args'     => [
				'menu_icon'   => 'dashicons-admin-site',
				'has_archive' => false,
				'public' => false,
				'exclude_from_search' => true,
				'publicly_queryable' => true,
				'supports'    => [
					'title',
					'editor',
					'page-attributes',
				],
			]
		]
	];

	/**
	 * Post Type Labels Generator
	 *
	 * @param string $singular (Required) The singular version of the post type
	 * @param string $plural   (Required) The plural version of the post type
	 * @param string $menu     (Optional) The admin menu name. Defaults to $plural
	 *
	 * @return array The array of post type labels
	 */
	public static function cpt_labels($singular, $plural = '', $menu = '') {

		$singular = rwp_singulizer($singular);

		if (empty($plural)) {
			$plural = rwp_pluralizer($singular);
		}


		$lower_singular = strtolower($singular);
		$lower_plural = strtolower($plural);

		$title_singular = rwp_change_case($singular, 'title');
		$title_plural = rwp_change_case($plural, 'title');

		$menu = $menu ?: $title_plural;

		return [
			'name'                  => _x($title_plural, 'Post Type General Name', 'rwp'),
			'singular_name'         => _x($title_singular, 'Post Type Singular Name', 'rwp'),
			'menu_name'             => __($menu, 'rwp'),
			'name_admin_bar'        => __($title_singular, 'rwp'),
			'archives'              => __($title_singular . ' Archives', 'rwp'),
			'attributes'            => __($title_singular . ' Attributes', 'rwp'),
			'parent_item_colon'     => __('Parent ' . $title_singular . ':', 'rwp'),
			'all_items'             => __('All ' . $title_plural, 'rwp'),
			'add_new_item'          => __('Add New ' . $title_singular, 'rwp'),
			'add_new'               => __('Add New', 'rwp'),
			'new_item'              => __('New ' . $title_singular, 'rwp'),
			'edit_item'             => __('Edit ' . $title_singular, 'rwp'),
			'update_item'           => __('Update ' . $title_singular, 'rwp'),
			'view_item'             => __('View ' . $title_singular, 'rwp'),
			'view_items'            => __('View ' . $title_plural, 'rwp'),
			'search_items'          => __('Search ' . $title_plural, 'rwp'),
			'insert_into_item'      => __('Insert into ' . $lower_singular, 'rwp'),
			'uploaded_to_this_item' => __('Uploaded to this ' . $lower_singular, 'rwp'),
			'items_list'            => __($title_plural . ' list', 'rwp'),
			'items_list_navigation' => __($title_plural . ' list navigation', 'rwp'),
			'filter_items_list'     => __('Filter ' . $lower_singular . ' list', 'rwp'),
		];
	}

	public function new_cpt($singular, $plural = '', $menu = '', $args = []) {


		$singular = rwp_change_case(rwp_singulizer($singular), 'title');

		$defaults = [
			'label'               => __($singular, 'rwp'),
			'labels'              => self::cpt_labels($singular, $plural, $menu),
			'capability_type'     => 'page',
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
		];

		$args = wp_parse_args($args, $defaults);

		$args = $this->cpt_acf_args($args);

		$type = $this->prefix($singular, 'snake');

		register_post_type($type, $args);

		flush_rewrite_rules();
	}

	public function init_cpts() {
		$this->add_action('init', $this, 'register_cpts');
	}

	public function cpt_acf_args($args) {

		if (isset($args['customize'])) {
			if (!$args['customize']) {
				if (rwp_array_has('rewrite', $args)) {
					unset($args['rewrite']);
				}
			}
			unset($args['customize']);
		}

		if (rwp_array_has('plural', $args)) {
			unset($args['plural']);
		}

		return $args;
	}


	public function register_cpts() {

		if ($this->cpts->isNotEmpty()) {
			$this->cpts->each(function ($args) {
				$this->new_cpt($args['singular'], $args['plural'], $args['menu'], $args);
			});
		}
	}
}
