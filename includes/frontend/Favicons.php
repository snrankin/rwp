<?php
/** ============================================================================
 * Favicons
 *
 * @package   RWP\/includes/frontend/Favicons.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Frontend;

use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Str;
class Favicons extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		//\add_action( 'customize_register', array( $this, 'customizer' ) );

		\add_filter( 'site_icon_meta_tags', array( $this, 'site_meta_tags' ) );
	}

	/**
	 *
	 * @param \WP_Customize $wp_customize
	 * @return void
	 */
	public function customizer( $wp_customize ) {
		// add a setting for the site logo
		$wp_customize->add_setting( 'site_icon_svg' );
		// Add a control to upload the logo
		$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'site_icon_svg',
		array(
			'label' => 'Upload SVG Icon',
			'section' => 'site_icon',
			'settings' => 'site_icon_svg',
		) ) );
	}

	public function site_meta_tags( array $meta_tags ) {

		$path = (string) apply_filters( 'rwp_favicons_path', '' );

		if ( ! empty( $path ) ) {

			$icons = array();

			$icon_32 = preg_grep( '/sizes="32x32"/', $meta_tags );

			if ( $icon_32 ) {

				$icons['icon-32'] = reset( $icon_32 );
			}

			$icon_192 = preg_grep( '/sizes="192x192"/', $meta_tags );

			if ( $icon_192 ) {

				$icons['icon-192'] = reset( $icon_192 );
			}

			$apple_icon = preg_grep( '/rel="apple-touch-icon"/', $meta_tags );

			if ( $apple_icon ) {

				$icons['apple-touch-icon-180'] = reset( $apple_icon );
			}

			$tile_icon = preg_grep( '/name="msapplication-TileImage"/', $meta_tags );

			if ( $tile_icon ) {

				$icons['tile-icon'] = reset( $tile_icon );
			}

			$theme_color = (string) apply_filters( 'rwp_favicons_theme_color', '' );

			$custom_icons = rwp_collection(array(

				'svg' => 'favicon.svg',
				'png' => 'favicon.png',
				'apple-touch-icon-57' => 'apple-touch-icon-57x57.png',
				'apple-touch-icon-60' => 'apple-touch-icon-60x60.png',
				'apple-touch-icon-72' => 'apple-touch-icon-72x72.png',
				'apple-touch-icon-76' => 'apple-touch-icon-76x76.png',
				'apple-touch-icon-114' => 'apple-touch-icon-114x114.png',
				'apple-touch-icon-120' => 'apple-touch-icon-120x120.png',
				'apple-touch-icon-144' => 'apple-touch-icon-144x144.png',
				'apple-touch-icon-152' => 'apple-touch-icon-152x152.png',
				'apple-touch-icon-180' => 'apple-touch-icon-180x180.png',
				'icon-32' => 'favicon-32x32.png',
				'icon-192' => 'android-chrome-192x192.png',
				'icon-16' => 'favicon-16x16.png',
				'manifest' => 'site.webmanifest',
				'mask-icon' => 'safari-pinned-tab.svg',
				'ico' => 'favicon.ico',
				'tile-icon' => 'mstile-144x144.png',
				'config' => 'browserconfig.xml',
			))->transform(function ( $item, $key ) use ( $theme_color, $icons, $path ) {
				$atts = array(
					'tag' => 'link',
					'atts' => array(),
				);

				preg_match( '/\d{2,3}x\d{2,3}/', $item, $sizes );

				if ( ! empty( $sizes ) ) {
					$sizes = reset( $sizes );
					$atts['atts']['sizes'] = $sizes;
				}

				$ext = pathinfo( $item, PATHINFO_EXTENSION );

				$type = '';

				if ( 'svg' === $ext ) {
					$type = 'image/svg+xml';
				} else if ( 'png' === $ext ) {
					$type = 'image/png';
				}

				if ( ! empty( $type ) ) {
					$atts['atts']['type'] = $type;
				}

				if ( rwp_str_has( $item, 'apple-touch-icon' ) ) {
					$atts['atts']['rel'] = 'apple-touch-icon';
				}

				if ( rwp_str_has( $item, 'favicon' ) ) {
					$atts['atts']['rel'] = 'icon';
				}

				switch ( $item ) {
					case 'android-chrome-192x192.png':
						$atts['atts']['rel'] = 'icon';
						break;
					case 'site.webmanifest':
						$atts['atts']['rel'] = 'manifest';
						break;
					case 'safari-pinned-tab.svg':
						$atts['atts']['rel'] = 'mask-icon';
						$atts['atts']['color'] = $theme_color;
						break;
					case 'favicon.ico':
						$atts['atts']['rel'] = 'shortcut icon';
						break;
					case 'mstile-144x144.png':
						$atts['tag'] = 'meta';
						$atts['atts']['name'] = 'msapplication-TileImage';
						break;
					case 'browserconfig.xml':
						$atts['tag'] = 'meta';
						$atts['atts']['name'] = 'msapplication-config';
						break;
				}

				$item = apply_filters( 'rwp_favicon_path', $item );

				$item = rwp_get_file( $item, '', $path );

				if ( $item ) {
					$item = '/wp-content' . Str::after( $item, 'wp-content' );

					if ( 'meta' === $atts['tag'] ) {
						$atts['atts']['content'] = $item;
					} else {
						$atts['atts']['href'] = $item;
					}

					$item = rwp_element( $atts )->html();
				} elseif ( in_array( $key, $icons ) ) {
					$item = $icons[ $key ];
				} else {
					$item = '';
				}
				return $item;
			})->reject(function ( $item ) {
				return empty( $item );
			});

			if ( $custom_icons->isNotEmpty() ) {
				$meta_tags = $custom_icons->values()->all();
			}

			if ( ! empty( $theme_color ) ) {
				$meta_tags[] = '<meta name="msapplication-TileColor" content="' . $theme_color . '">';
				$meta_tags[] = '<meta name="theme-color" content="' . $theme_color . '">';
			}
		}

		return $meta_tags;

	}
}
