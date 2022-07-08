<?php

/** ============================================================================
 * Taxonomy
 *
 * @package   RWP\/includes/engine/Abstracts/Taxonomy.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

use RWP\Internals\Taxonomies;

if ( ! \defined( 'ABSPATH' ) ) {
	die( 'FU!' );
}

abstract class Taxonomy extends Singleton {

	/**
	 * @var string $type The taxonomy type
	 */

	public $type = '';


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
	public function initialize() {
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

		$this->labels = Taxonomies::labels( $this->singular, $this->plural, $this->menu, $this->slug );

		if ( empty( $this->plural ) ) {
			$this->plural = $this->labels['names']['plural'];
		}

		if ( empty( $this->slug ) ) {
			$this->slug = $this->labels['names']['slug'];
		}

		if ( empty( $this->menu ) ) {
			$this->menu = $this->labels['labels']['menu_name'];
		}

		\add_filter( $type . '_tax_args', array( $this, 'tax_filter' ) );

		$post_types = (array) get_post_types();

		$should_register = ! count( array_intersect( $this->post_type, $post_types ) );

		if ( $should_register ) {
			\add_action( 'init', array( $this, 'load_tax' ) );
		}
	}

	/**
	 * The array of arguments passed from the filter
	 *
	 * @see RWP\Internals\Taxonomies::new_tax()
	 *
	 * @param array $args
	 * @return array
	 */

	public function tax_filter( $args = array() ) {

		$updated_args = $this->args;

		$args = rwp_merge_args( $args, $updated_args );

		return $args;
	}

	public function load_tax() {
		Taxonomies::new_tax( $this->singular, $this->post_type, $this->plural, $this->menu, $this->slug, $this->args );
	}
}
