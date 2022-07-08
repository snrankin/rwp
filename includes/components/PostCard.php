<?php

/** ============================================================================
 * Card
 *
 * @package   RWP\/includes/components/Card.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

class PostCard extends Card {

	/**
	 * @var int The current post id
	 */
	public $post_id;

	/**
	 * @var array The current post info
	 */
	public $post;

	/**
	 * @var string The current post type
	 */
	public $post_type;


	public function __construct( $post = null, $args = [] ) {

		$this->post = rwp_post( $post );
		$post_type  = data_get( $this->post, 'subtype', 'post' );
		$post_type = rwp_remove_prefix( $post_type, 'rwp_' ); // Remove rwp_ to prevent double rwp_rwp_ below
		$post_id    = data_get( $this->post, 'id', 0 );

		$url = rwp_post_link( $post );

		$title = rwp_post_title( $post );

		$image_size = apply_filters( 'rwp_card_image_size', 'medium' ); // Adjust size for post card images globally
		$image_size = apply_filters( "rwp_{$post_type}_image_size", $image_size, $post ); // Adjust size of post card images per post type

		$image_id = rwp_featured_image_id( $post );

		if ( $image_id ) {
			$image = rwp_get_featured_image($post, $image_size, array(
				'link' => $url,
				'ratio' => '3x2',
				'atts' => array(
					'class' => array(
						'post-image',
					),
				),
			));
			$image = $image->toArray();

		} else {
			$image = false;
		}

		$image = apply_filters( 'rwp_card_image_args', $image ); // Adjust post card image defaults  globally
		$image = apply_filters( "rwp_{$post_type}_card_image_args", $image, $post ); // Adjust post card subtitle defaults per post type

		$title_defaults = array(
			'content' => wp_sprintf( '<a href="%s" itemprop="url" class="post-title-link">%s</a>', $url, $title ),
			'location' => 'body',
			'key' => null,
			'tag' => 'h3',
			'atts' => array(
				'class' => array(
					'card-title',
				),
			),
		);

		$title = apply_filters( 'rwp_card_title_args', $title_defaults ); // Adjust post card title defaults  globally
		$title = apply_filters( "rwp_{$post_type}_card_title_args", $title, $post ); // Adjust post card title defaults per post type

		$subtitle_defaults = false; // no subtitle added by default

		$subtitle = apply_filters( 'rwp_card_subtitle_args', $subtitle_defaults ); // Adjust post card subtitle defaults  globally
		$subtitle = apply_filters( "rwp_{$post_type}_card_subtitle_args", $subtitle, $post ); // Adjust post card subtitle defaults per post type

		$excerpt_defaults = rwp_post_excerpt( $post ); // no excerpt added by default

		$excerpt = apply_filters( 'rwp_card_excerpt_args', $excerpt_defaults ); // Adjust post card excerpt defaults  globally
		$excerpt = apply_filters( "rwp_{$post_type}_card_excerpt_args", $excerpt, $post ); // Adjust post card subtitle defaults per post type

		$link_defaults = array(
			'text' => 'Read More',
			'link' => $url,
		);

		$link = apply_filters( 'rwp_card_link_args', $link_defaults ); // Adjust post card link defaults  globally
		$link = apply_filters( "rwp_{$post_type}_card_link_args", $link, $post ); // Adjust post card subtitle defaults per post type

		$defaults = array(
			'atts' => array(
				'id' => rwp_post_id_html( $post ),
				'class' => rwp_get_post_class( $post_id, 'card' ),
			),
			'image'    => $image,
			'title'    => $title,
			'subtitle' => $subtitle,
			'text'     => $excerpt,
			'links'    => $link,
		);

		$this->post_type = $post_type;

		$defaults = apply_filters( "rwp_{$post_type}_card_defaults", $defaults, $post );

		$args = rwp_merge_args( $defaults, $args );

		parent::__construct( $args );
	}

	public function setup_html() {

		parent::setup_html();

		$post_type = rwp()->unprefix( $this->post_type );
		$post_id = $this->post_id;

		apply_filters( "rwp_{$post_type}_card", $this );
		apply_filters( "rwp_{$post_type}_{$post_id}_card", $this );
	}
}
