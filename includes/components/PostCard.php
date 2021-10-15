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


	public function __construct( $post = null, $args = [] ) {

		$this->post = rwp_object_type( $post );
		$post_type  = data_get($this->post, 'subtype', 'post');
		$post_id    = data_get($this->post, 'id', 0);

		$url = rwp_post_link( $post );

		$title = rwp_title( $post );

		$image = rwp_get_featured_image($post, 'medium', array(
			'inner' => array(
				'tag' => 'a',
				'atts' => array(
					'href' => $url
				)
			),
			'atts' => array(
				'class' => array(
					'post-image'
				)
			)
		));

		if( $image ){
			$image = $image->toArray();
		}

		$defaults = array(
			'atts' => array(
				'id' => rwp_post_id( $post ),
				'class' => rwp_parse_classes( get_post_class( 'card', $post_id ) ),
			),
			'image' => $image,
			'title' => array(
				'content' => wp_sprintf( '<a href="%s" itemprop="url" class="post-title-link">%s</a>', $url, $title ),
			),
			'text'  => rwp_post_excerpt( $post ),
			'links' => array(
				'text' => 'Read More',
				'link' => $url,
			)
		);

		$defaults = apply_filters( "rwp_{$post_type}_card_defaults", $defaults, $post );

		$args = rwp_merge_args( $defaults, $args );

		parent::__construct( $args );

    }

}
