<?php

/** ============================================================================
 * PostType
 *
 * @package   RWP\/includes/engine/Abstracts/PostType.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

use RWP\Internals\PostTypes;

if ( ! \defined( 'ABSPATH' ) ) {
	die( 'FU!' );
}

abstract class PostType {

	/**
	 * @var string $type The post type
	 */

	public $type = '';

	/**
	 * @var array $supports The post type supports
	 */

	public $supports = array(
		'title',
		'editor',
		'excerpt',
		'thumbnail',
		'custom-fields',
		'page-attributes',
	);

	/**
	 * @var array $admin_cols Additional admin columns
	 */

	public $admin_cols = array();

	/**
	 * @var string $menu_icon The post type admin menu icon (dashicons)
	 */

	public $menu_icon = '';

	/**
	 * @var array $args An array of additional arguments for the taxonomy
	 */
	public $args = array();

	/**
	 * @var string $singular The taxonomy type
	 */

	public $singular = '';

	/**
	 * @var array $post_type The post type(s) this taxonomy is linked to
	 */

	public $post_type = array();

	/**
	 * @var array|bool $rewrite The post type rewrite rules
	 */

	public $rewrite = true;

	/**
	 * @var string $plural The taxonomy type in plural form
	 */

	public $plural = '';

	/**
	 * @var string $menu The taxonomy menu title
	 */

	public $menu = '';

	/**
	 * @var string $slug The taxonomy url slug
	 */

	public $slug = '';

	/**
	 * @var array $labels The labels array
	 */
	public $labels = array();

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function __construct() {
		$type = $this->type;
		if ( empty( $type ) ) {
			$type = explode( '\\', get_called_class() );
			$type = end( $type );
			$type = rwp_change_case( $type, 'snake' );
		}

		if ( empty( $this->singular ) ) {
			$this->singular = $type;
		}

		$type = rwp()->prefix( $type );
		$this->type = $type;

		$this->labels = PostTypes::labels( $this->singular, $this->plural, $this->menu, $this->slug );

		if ( empty( $this->plural ) ) {
			$this->plural = $this->labels['names']['plural'];
		}

		if ( empty( $this->slug ) ) {
			$this->slug = $this->labels['names']['slug'];
		}

		if ( empty( $this->menu ) ) {
			$this->menu = $this->labels['labels']['menu_name'];
		}
		\add_filter( $type . '_cpt_args', array( $this, 'cpt_filter' ) );
	}

	/**
	 * The array of arguments passed from the filter
	 *
	 * @see RWP\Internals\PostTypes::new_cpt()
	 *
	 * @param array $args
	 * @return array
	 */

	public function cpt_filter( $args = array() ) {

		$updated_args = $this->args;
		$has_archive = data_get( $updated_args, 'has_archive', false );

		if ( $has_archive ) {
			$updated_args['has_archive'] = $this->slug;
		}

		$updated_args['menu_icon']  = $this->menu_icon;
		$updated_args['supports']   = $this->supports;
		$updated_args['admin_cols'] = $this->admin_cols;

		if ( true !== $this->rewrite ) {
			$updated_args['rewrite'] = $this->rewrite;
		}

		$args = rwp_merge_args( $args, $updated_args );

		return $args;
	}
}
