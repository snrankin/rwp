<?php

/** ============================================================================
 * RWP favicons
 *
 * Add more favicons from a specific theme folder
 *
 * @package RWP\Modules\Favicons
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Modules\Favicons;

if (!defined('ABSPATH')) {
	die();
}

if (!get_theme_support('rwp-favicons')) {
	return;
}

function favicons($meta_tags) {

	$folder = null;

	if (!defined('THEME_FAVICON_FOLDER')) {
		return;
	}

	$folder = trailingslashit(THEME_FAVICON_FOLDER);

	$uri = trailingslashit(rwp_theme_uri($folder));

	$favicons = [
		'<meta name="apple-mobile-web-app-capable" content="yes">' . "\n",
		'<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n",
		'<meta name="apple-mobile-web-app-title" content="' . rwp_change_case(get_bloginfo('name')) . '">' . "\n",
		'<meta name="application-name" content="' . esc_attr__(get_bloginfo('name'), 'rwp') . '">' . "\n",
		'<meta name="mobile-web-app-capable" content="yes">' . "\n",
	];

	$sizes = [
		'apple-touch-icon-57x57.png',
		'apple-touch-icon-60x60.png',
		'apple-touch-icon-72x72.png',
		'apple-touch-icon-76x76.png',
		'apple-touch-icon-114x114.png',
		'apple-touch-icon-120x120.png',
		'apple-touch-icon-144x144.png',
		'apple-touch-icon-152x152.png',
		'apple-touch-icon-167x167.png',
		'apple-touch-icon-180x180.png',
		'apple-touch-icon-1024x1024.png',
		'apple-touch-icon-precomposed.png',
		'apple-touch-icon.png',
		'apple-touch-startup-image-320x460.png',
		'apple-touch-startup-image-640x920.png',
		'apple-touch-startup-image-640x1096.png',
		'apple-touch-startup-image-750x1294.png',
		'apple-touch-startup-image-1182x2208.png',
		'apple-touch-startup-image-1242x2148.png',
		'apple-touch-startup-image-748x1024.png',
		'apple-touch-startup-image-1496x2048.png',
		'apple-touch-startup-image-768x1004.png',
		'apple-touch-startup-image-1536x2008.png',
		'favicon-16x16.png',
		'favicon-32x32.png',
		'favicon-48x48.png',
		'coast-228x228.png',
		'favicon.ico'
	];


	$size = null;

	$generated_sizes = [
		16  => 'favicon-16x16.png',
		32  => 'favicon-32x32.png',
		180 => 'apple-touch-icon.png',
		192 => 'android-chrome-192x192.png',
		194 => 'favicon-194x194.png',
	];

	foreach ($sizes as $name) {

		preg_match('/(\d{2,4})(x)(\d{2,4})/', $name, $size_ext);
		if (!empty($size_ext)) {
			$size = $size_ext;
		}

		$favicon = rwp_html();
		$path = null;
		$url = null;
		if (in_array($name, $generated_sizes)) {
			$url = get_site_icon_url($size[1]);
			if (!empty($url)) {
				preg_match('/(\-\d{2,4}x\d{2,4})\.(png|jpe?g|gif|svg|ico|bin)$/', $url, $size_ext);
				if (!empty($size_ext)) {
					$size_ext = $size_ext[1];
					$url = str_replace($size_ext, '', $url);
				}
				$id = attachment_url_to_postid(get_home_url() . $url);
				$path = wp_get_original_image_path($id);
			}
		}

		if (empty($url) && rwp_theme_path($folder . $name)) {
			$url = $uri . $name;
			$path = rwp_theme_path($folder . $name);
		}
		if (!empty($url)) {
			$favicon->addAttr('tag', 'link');
			$url = rwp_relative_url($url);
			$favicon->addAttr('href', $url);
			if (preg_match('/apple\-touch\-icon/', $name)) {
				$favicon->addAttr('rel', 'apple-touch-icon');
			} elseif (preg_match('/apple\-touch\-startup\-image/', $name)) {
				$favicon->addAttr('rel', 'apple-touch-startup-image');

				switch ($name) {
					case 'apple-touch-startup-image-320x460.png':
						$favicon->addAttr('media', '(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)');
						break;
					case 'apple-touch-startup-image-640x920.png':
						$favicon->addAttr('media', '(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)');
						break;
					case 'apple-touch-startup-image-640x1096.png':
						$favicon->addAttr('media', '(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)');
						break;
					case 'apple-touch-startup-image-750x1294.png':
						$favicon->addAttr('media', '(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)');
						break;
					case 'apple-touch-startup-image-1182x2208.png':
						$favicon->addAttr('media', '(device-width: 414px) and (device-height: 736px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 3)');
						break;
					case 'apple-touch-startup-image-1242x2148.png':
						$favicon->addAttr('media', '(device-width: 414px) and (device-height: 736px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 3)');
						break;
					case 'apple-touch-startup-image-748x1024.png':
						$favicon->addAttr('media', '(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)');
						break;
					case 'apple-touch-startup-image-1496x2048.png':
						$favicon->addAttr('media', '(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)');
						break;
					case 'apple-touch-startup-image-768x1004.png':
						$favicon->addAttr('media', '(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)');
						break;
					case 'apple-touch-startup-image-1536x2008.png':
						$favicon->addAttr('media', '(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)');
						break;
				}
			} else {

				if ($path) {
					$type = mime_content_type($path);

					if ($type) {
						if ($type === 'image/vnd.microsoft.icon') {
							$favicon->addAttr('rel', 'shortcut icon');
						} else {
							$favicon->addAttr('rel', 'icon');
							$favicon->addAttr('sizes', $size[0]);
							$favicon->addAttr('type', $type);
						}
					}
				}
			}
			$favicons[] = $favicon->__toString();
		}
	}

	if (rwp_theme_uri($folder . 'manifest.json')) {
		$favicons[] = '<link rel="manifest" href="' . rwp_theme_uri($folder . 'manifest.json') . '">';
	}

	if (rwp_theme_uri($folder . 'manifest.webapp')) {
		$favicons[] = '<link rel="manifest" href="' . rwp_theme_uri($folder . 'manifest.webapp') . '">';
	}

	if (rwp_theme_uri($folder . 'yandex-browser-manifest.json')) {
		$favicons[] = '<link rel="yandex-tableau-widget" href="' . rwp_theme_uri($folder . 'yandex-browser-manifest.json') . '">' . "\n";
	}
	if (rwp_theme_uri($folder . 'mstile-144x144.png')) {

		$favicons[] = '<meta name="msapplication-TileImage" content="' . rwp_theme_uri($folder . 'mstile-144x144.png') . '">' . "\n";
	}

	if (rwp_theme_uri($folder . 'browserconfig.xml')) {

		$favicons[] = '<link name="msapplication-config" content="' . rwp_theme_uri($folder . 'browserconfig.xml') . '">' . "\n";
	}

	$meta_tags = $favicons;

	return $meta_tags;
}
add_filter('site_icon_meta_tags', __NAMESPACE__ . '\\favicons', 10, 1);
