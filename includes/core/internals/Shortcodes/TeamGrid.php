<?php

/** ============================================================================
 * Team Grid
 *
 * @package   RWP\Internals\Shortcodes
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Internals\Shortcodes;

class TeamGrid extends Shortcode {

	public $defaults = array(
		'cat'     => '',
		'd_cols'  => '3',
		't_cols'  => '2',
		'num'     => '-1',
		'order'   => 'ASC',
		'orderby' => 'menu_order',
		'id'      => '',
		'class'   => '',
	);

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		$cpts = rwp_get_option( 'cpt_options.cpts' );

		if ( rwp_is_collection( $cpts ) && $cpts->has( 'team_members' ) ) {

			parent::initialize();
		}
	}

	/**
	 * Wrap the content in a standard wrapper
	 *
	 * @param string $content
	 * @param array $args
	 * @return \RWP\Html\Row
	 */
	public function wrapper( $content = '', $args = array() ) {
		$categories      = data_get( $args, 'cat' );
		$desktop_columns = data_get( $args, 'd_cols', '' );
		$tablet_columns  = data_get( $args, 't_cols', '' );

		$classes = array();

		if ( ! empty( $categories ) ) {
			$categories = explode( ',', $categories );
			array_map( 'rwp_change_case', $categories );
			$classes = $categories;
		}

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
	 * Easily add copyright info with an auto-updating year
	 *
	 * @param array $atts
	 * @return string
	 */

	public function output( $atts ) {

		$atts = rwp_process_shortcode( $atts, $this->defaults );

		$categories      = data_get( $atts, 'cat' );
		$num             = data_get( $atts, 'num', '-1' );
		$orderby         = data_get( $atts, 'orderby', 'ASC' );
		$order           = data_get( $atts, 'order', 'menu_order' );

		// WP_Query arguments
		$args = array(
			'post_status'    => array( 'publish' ),
			'post_type'      => array( 'rwp_team_member' ),
			'posts_per_page' => $num,
			'order'          => $order,
			'orderby'        => $orderby,
		);

		if ( ! empty( $categories ) ) {
			$categories = explode( ',', $categories );

			$args['tax_query'][] = array(
				'taxonomy' => 'rwp_team_category',
				'field'    => 'slug',
				'terms'    => $categories,
			);
		}

		$output = '';

		/**
		 * @var \WP_Query $posts
		 */
		$posts = wp_cache_remember('rwp_team_members', function () use ( $args ) {
			return new \WP_Query( $args );
		}, 'rwp_team_members', HOUR_IN_SECONDS);

		if ( $posts->have_posts() ) {
			$grid = $this->wrapper( '', $atts );

			while ( $posts->have_posts() ) {
				$posts->the_post();
				$item = get_post();
				$is_protected = post_password_required( $item->ID );
				if ( ! $is_protected ) {
					$item = rwp_post_card( $item )->html();
					$grid->add_item( array( 'content' => $item ) );
				}
			}
			$output = $grid->html();
		}
		wp_reset_postdata();

		return $output;
	}
}
