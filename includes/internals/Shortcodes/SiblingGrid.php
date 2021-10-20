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

class SiblingGrid extends Shortcode {

	public $defaults = array(
		'parent'         => '',
		'd_cols'         => '3',
		't_cols'         => '2',
		'num'            => '-1',
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
		'exclude_active' => true,
		'id'             => '',
		'class'          => '',
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
		$exclude_active = data_get( $atts, 'exclude_active', true );
		$num            = data_get( $atts, 'num', '-1' );
		$orderby        = data_get( $atts, 'orderby', 'ASC' );
		$order          = data_get( $atts, 'order', 'menu_order' );

		$current_post = get_post();
		$parent = null;
		$output  = '';

		if ( ! empty( $parent_id ) ) {
			$parent = get_post( $parent_id );
		} else {
			$parent = rwp_post_parent( $parent_id );
			if ( $parent ) {
				$parent = data_get( $parent, 'object' );
			}
		}

		if ( $parent instanceof \WP_Post ) {
			// WP_Query arguments
			$args = array(
				'post_type'      => $parent->post_type,
				'post_parent'    => $parent->ID,
				'posts_per_page' => $num,
				'order'          => $order,
				'orderby'        => $orderby,
			);

			if ( $exclude_active ) {
				$args['post__not_in'] = array( $current_post->ID );
			}

			/**
			 * @var \WP_Query $grid_posts
			 */
			$grid_posts = wp_cache_remember($current_post->ID . '_siblings', function () use ( $args ) {
				return new \WP_Query( $args );
			}, $current_post->post_type . '_siblings', HOUR_IN_SECONDS);

			if ( $grid_posts->have_posts() ) {
				$grid = $this->wrapper( '', $atts );

				while ( $grid_posts->have_posts() ) {
					$grid_posts->the_post();
					$item = get_post();
					$item = rwp_post_card( $item );
					$item = $item->html();
					$grid->add_item( array( 'content' => $item ) );
				}
				$output = $grid->html();
			}
			wp_reset_postdata();
		}

		return $output;
	}
}
