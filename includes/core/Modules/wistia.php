<?php

/** ============================================================================
 * Adds Wistia to embed providers
 *
 * @package RIESTERWP Plugin\/includes/core/Modules/wistia.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */


namespace RWP\Modules\Wistia;

if (!defined('ABSPATH')) {
	die();
}

if (!get_theme_support('rwp-wistia')) {
	return;
}

// Register Script
function enqueue_wistia() {

	wp_register_script('rwp-wistia', 'https://fast.wistia.com/assets/external/E-v1.js', false, false, false);
	wp_enqueue_script('rwp-wistia');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_wistia');
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_wistia');
add_action('enqueue_embed_scripts', __NAMESPACE__ . '\\enqueue_wistia');

function get_wistia_data($id) {
	$url = "https://fast.wistia.com/embed/medias/{$id}.json";
	$data = rwp_get_json_data($url);

	if ($data) {
		$item = $data->media;
		$assets = $item->assets;

		$wistia = [
			'name' => $item->name,
			'description' => $item->seoDescription,
			'atts' => []
		];

		$duration = $item->duration;

		$duration = mktime(null, null, $duration, null, null, null);

		$wistia['duration'] = date_i18n('\TH\Hi\Ms\S', $duration);

		foreach ($assets as $asset) {
			$url = $asset->url;

			if (property_exists($asset, 'ext')) {
				$current_ext = pathinfo($url, PATHINFO_EXTENSION);
				$new_ext = $asset->ext;
				$url = str_replace($current_ext, $new_ext, $url);
			}

			if ($asset->type === 'original') {

				$wistia['url'] = $url;
				if (property_exists($asset, 'width')) {
					$wistia['width'] = $asset->width;
				}
				if (property_exists($asset, 'height')) {
					$wistia['height'] = $asset->height;
				}

				$wistia['type'] = 'video';
			}
			if ($asset->type === 'still_image') {
				$wistia['image'] = $url;
			}
		}
		return $wistia;
	} else {
		return false;
	}
}

wp_oembed_add_provider('/https?:\/\/[^.]+\.(wistia\.com|wi\.st)\/(medias|embed)\/.*/', 'http://fast.wistia.com/oembed', true);

// function add_wistia_block_variation() {
//     wp_enqueue_script(
//         'rwp-wistia',
//         rwp_plugin_asset_uri('js/rwp-wistia.js'),
//         array('wp-block-editor', 'wp-blocks', 'wp-components', 'wp-editor', 'wp-element', 'wp-i18n', 'wp-polyfill'),
//         filemtime(plugin_dir_path(__FILE__) . '/myguten.js')
//     );
// }
// add_action('enqueue_block_editor_assets', 'add_wistia_block_variation');
