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

if ( ! \defined( 'ABSPATH' ) ) {
    die( 'FU!' );
}

abstract class PostType extends Singleton {

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
	 * @var array $args An array of additional arguments for the post type
	 */
	public $args = array();

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
			$type = rwp()->prefix( $type );
			$this->type = $type;
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
		$updated_args['menu_icon'] = $this->menu_icon;
		$updated_args['supports'] = $this->supports;

		$args = rwp_merge_args( $args, $updated_args );

		return $args;
	}
}
