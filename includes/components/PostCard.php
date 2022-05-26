<?php

/** ============================================================================
 * Card
 *
 * @package   RWP\/includes/components/Card.php
 * @since     1.0.1
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
		$post_id    = data_get( $this->post, 'id', 0 );

		$url = rwp_post_link( $post );

		$title = rwp_post_title( $post );

		$image = rwp_get_featured_image($post, 'thumbnail', array(
			'inner' => array(
				'tag' => 'a',
				'atts' => array(
					'href' => $url,
				),
			),
			'atts' => array(
				'class' => array(
					'post-image',
				),
			),
		));

		if ( $image ) {
			$image = $image->toArray();
		}

		$defaults = array(
			'atts' => array(
				'id' => rwp_post_id_html( $post ),
				'class' => rwp_get_post_class( $post_id, 'card' ),
			),
			'image' => $image,
			'title' => array(
				'content' => wp_sprintf( '<a href="%s" itemprop="url" class="post-title-link">%s</a>', $url, $title ),
			),
			'text'  => rwp_post_excerpt( $post ),
			'links' => array(
				'text' => 'Read More',
				'link' => $url,
			),
		);

		$this->post_type = $post_type;

		$post_type = rwp_remove_prefix( $post_type, 'rwp_' ); // Remove rwp_ to prevent double rwp_rwp_ below

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
