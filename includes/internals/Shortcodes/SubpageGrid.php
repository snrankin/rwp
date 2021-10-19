<?php
/** ============================================================================
 * TeamGrid
 *
 * @package   RWP\/includes/internals/Shortcodes/TeamGrid.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\Shortcodes;

use RWP\Engine\Abstracts\Shortcode;

class SubpageGrid extends Shortcode {

	public $defaults = array(
		'parent'         => '',
		'd_cols'         => '3',
		't_cols'         => '2',
		'num'            => '-1',
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
		'exclude_active' => false,
	);

	/**
	 * Wrap the content in a standard wrapper
	 *
	 * @param string $content
	 * @param array $args
	 * @return \RWP\Components\Row
	 */
	public function wrapper( $content = '', $args = array() ) {
		$desktop_columns = data_get( $args, 'd_cols', '' );
		$tablet_columns  = data_get( $args, 't_cols', '' );

		$classes = array();

		if ( ! empty( $desktop_columns ) ) {
			$classes[] = 'row-cols-lg-' . $desktop_columns;
		}

		if ( ! empty( $tablet_columns ) ) {
			$classes[] = 'row-cols-md-' . $tablet_columns;
		}

		$classes[] = rwp_change_case( $this->tag );

		$wrapper = array(
			'atts' => array(
				'class' => rwp_parse_classes( $classes ),
			),
		);

		$wrapper = rwp_merge_args( $wrapper, $args );

		$wrapper['content'] = $content;

		return rwp_row( $wrapper );
	}

	/**
	 * Shortcut output
	 *
	 * @param array $atts
	 * @return string
	 */

	public function output( $atts ) {

		$atts = rwp_process_shortcode( $atts, $this->defaults );

		$parent_id      = data_get( $atts, 'parent' );
		$exclude_active = data_get( $atts, 'exclude_active', false );
		$orderby        = data_get( $atts, 'orderby', 'ASC' );
		$order          = data_get( $atts, 'order', 'menu_order' );

		$parent = get_post();

		$output  = '';

		if ( ! empty( $parent_id ) ) {
			$parent = get_post( $parent_id );
		}

		// Get the sibling posts if the current post has no children
		if ( ! rwp_post_has_children( $parent ) ) {
			$parent = rwp_post_parent( $parent );
			if ( $parent ) {
				/**
				 * @var \WP_Post $parent
				 */
				$parent = data_get( $parent, 'object' );
			}
		}

		if ( $parent instanceof \WP_Post ) {
			// WP_Query arguments
			$args = array(
				'post_type'      => $parent->post_type,
				'post_parent'    => $parent->ID,
				'order'          => $order,
				'orderby'        => $orderby,
			);

			/**
			 * @var \WP_Post[] $posts
			 */
			$posts = get_posts( $args );

			$current_post = get_post();
			if ( ! empty( $posts ) ) {
				$team = $this->wrapper( '', $atts );

				foreach ( $posts as $post ) {
					if ( $exclude_active && $current_post !== $post->ID ) {
						$post = rwp_post_card( $post )->html();
						$team->add_item( array( 'content' => $post ) );
					} else if ( ! $exclude_active ) {
						$post = rwp_post_card( $post )->html();
						$team->add_item( array( 'content' => $post ) );
					}
				}
				$output = $team->html();
			}
		}

		return $output;
    }

}
