<?php

/** ============================================================================
 * Wistia
 *
 * @package   RWP\Integrations
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use JsonException;
use RWP\Base\Singleton;
use RWP\Vendor\Exceptions\Http\HttpException;
use RWP\Html\Embed;

class Wistia extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! rwp_get_option( 'modules.wistia', false ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_wistia' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_wistia' ) );
		add_action( 'enqueue_embed_scripts', array( $this, 'enqueue_wistia' ) );

		wp_oembed_add_provider( '/https?:\/\/[^.]+\.(wistia\.com|wi\.st)\/(medias|embed)\/.*/', 'http://fast.wistia.com/oembed', true );
	}

	/**
	 * Enqueue the Wistia script
	 * @return void
	 */
	public function enqueue_wistia() {

		wp_register_script( 'rwp-wistia', 'https://fast.wistia.com/assets/external/E-v1.js', array(), 'v1', false );
		wp_enqueue_script( 'rwp-wistia' );
	}

	/**
	 * Display Wistia Video
	 *
	 * @param string|array $args
	 *
	 * @return string
	 */
	public static function display_wistia( $args ) {

		$video = new Embed( $args );
		return $video->html();
	}

	/**
	 * Get data from Wistia API
	 * @param mixed $id
	 * @return array|false
	 * @throws HttpException
	 * @throws JsonException
	 */

	public static function get_wistia_data( $id ) {
		$url = "https://fast.wistia.com/embed/medias/{$id}.json";
		$data = rwp_get_file_data( $url );

		if ( $data ) {
			$item = data_get( $data, 'media', new \stdClass() );
			$image = data_get( $item, 'embed_options.unalteredStillImageAsset.url', new \stdClass() );
			$assets = data_get( $item, 'assets', array() );
			$name = data_get( $item, 'name', array() );
			$description = data_get( $item, 'seoDescription', array() );

			$assets = rwp_collection( $assets );

			$assets = $assets->sole( 'type', '===', 'original' );

			$width = data_get( $assets, 'width', 0 );
			$height = data_get( $assets, 'height', 0 );
			$src = data_get( $assets, 'url', '' );

			$wistia = [
				'name'        => $name,
				'description' => $description,
				'atts'        => array(
					'src'    => $src,
					'width'  => $width,
					'height' => $height,
					'poster' => $image,
				),

			];

			return $wistia;
		} else {
			return false;
		}
	}
}
