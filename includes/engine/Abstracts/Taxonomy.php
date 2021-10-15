<?php
/** ============================================================================
 * Taxonomy
 *
 * @package   RWP\/includes/engine/Abstracts/Taxonomy.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

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
	 * @var array $post_type The post type(s) this taxonomy is linked to
	 */

	public $post_type = array();

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

		\add_filter( $type . '_tax_args', array( $this, 'tax_filter' ) );
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
}
