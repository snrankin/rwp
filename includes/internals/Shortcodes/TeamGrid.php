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
use RWP\Internals\PostTypes;

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

		if ( PostTypes::registered_cpts()->has( 'team_member' ) ) {

			parent::initialize();
        }

	}

	/**
	 * Wrap the content in a standard wrapper
	 *
	 * @param string $content
	 * @param array $args
	 * @return \RWP\Components\Row
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

		/**
		 * @var \WP_Post[] $members
		 */
		$members = get_posts( $args );
		$output  = '';
		if ( ! empty( $members ) ) {
			$team = $this->wrapper( '', $atts );
			foreach ( $members as $member ) {
				$member = rwp_post_card( $member )->html();
				$team->add_item( array( 'content' => $member ) );
			}
			$output = $team->html();
		}

		return $output;
    }

}
