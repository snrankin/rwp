<?php
/** ============================================================================
 * Wistia
 *
 * @package   RWP\Integrations\Wistia
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use JsonException;
use RWP\Engine\Abstracts\Singleton;
use RWP\Vendor\Exceptions\Http\HttpException;
use RWP\Components\Embed;

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

		wp_register_script( 'rwp-wistia', 'https://fast.wistia.com/assets/external/E-v1.js', array(), false, false );
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
			$assets = data_get( $item, 'assets', array() );
			$name = data_get( $item, 'name', array() );
			$description = data_get( $item, 'seoDescription', array() );

			$wistia = [
				'name' => $name,
				'description' => $description,
				'atts' => array(),
			];

			foreach ( $assets as $asset ) {
				$url = data_get( $asset, 'url', '' );
				$ext = data_get( $asset, 'ext', '' );

				if ( ! empty( $ext ) ) {
					$current_ext = pathinfo( $url, PATHINFO_EXTENSION );
					$url = str_replace( $current_ext, $ext, $url );
				}

				if ( $asset->type === 'original' ) {

					$wistia['url'] = $url;
					$wistia['width'] = data_get( $asset, 'width', '' );
					$wistia['height'] = data_get( $asset, 'height', '' );
					$wistia['type'] = 'video';
				}
				// if ($asset->type === 'still_image') {
				// 	$wistia['image'] = $url;
				// }
			}
			return $wistia;
		} else {
			return false;
		}
	}
}
