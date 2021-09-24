<?php
/**
 * ============================================================================
 * image
 *
 * @package   RWP\/includes/functions/utils/image.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== 
 */

use RWP\Components\Element;
use RWP\Components\Html;
/**
 * Get all the registered image sizes along with their dimensions
 *
 * @global array $_wp_additional_image_sizes
 *
 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
 *
 * @return array $image_sizes The image sizes
 */
function rwp_registered_image_sizes() {
     $wp_additional_image_sizes = wp_get_additional_image_sizes();

    $sizes = array();
    $registered_sizes = get_intermediate_image_sizes();
    // Create the full array with sizes and crop info
    foreach ( $registered_sizes as $_size ) {
        if ( ! rwp_array_has( $_size, $wp_additional_image_sizes ) ) {
            $sizes[ $_size ]['width'] = intval( get_option( $_size . '_size_w' ) );
            $sizes[ $_size ]['height'] = intval( get_option( $_size . '_size_h' ) );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
				'width'  => intval( $wp_additional_image_sizes[ $_size ]['width'] ),
				'height' => intval( $wp_additional_image_sizes[ $_size ]['height'] ),
				'crop'   => boolval( $wp_additional_image_sizes[ $_size ]['crop'] ),
            );
        }
    }

    $sizes = rwp_collection( $sizes );
    $sizes = $sizes->sortBy( 'width' );
    $sizes = $sizes->all();
    $sizes['full'] = [ 'crop' => false ];
    return $sizes;
}

/**
 * Check if the variable is an image url, id or instance of WP_Post
 *
 * @param  mixed $image
 * @return bool
 */

function rwp_is_image( $image ) {
	if ( empty( $image ) ) {
        return false;
	}

    $image_types = array(
		// Jpeg
		'jpg',
		'jpeg',
		'jpe',
		'jif',
		'jfif',
		'jfi',
		// PNG
		'png',
		// GIF
		'gif',
		// Google Webp
		'webp',
		// SVGS
		'svg',
		'svgz',
		// iOS High Efficiency Image File
		'heif',
		'heic',
		// Jpeg 2000
		'jp2',
		'j2k',
		'jpf',
		'jpx',
		'jpm',
		'mj2',
		// TIFF
		'tiff',
		'tif',
		// Icons
		'ico',
		// Windows
		'bmp',
		'dib',
    );

    if ( is_string( $image ) ) {
        if ( rwp_is_url( $image ) ) {
            $ext = pathinfo( $image, PATHINFO_EXTENSION );
            return in_array( $ext, $image_types );
        } else {
            return rwp_is_element( $image, 'img' );
        }
    } elseif ( $image instanceof \WP_Post ) {
        return wp_attachment_is_image( $image );
    } elseif ( is_int( $image ) ) {
        return wp_attachment_is_image( $image );
    } elseif ( $image instanceof Element ) {
        return 'img' === $image->tag ? true : false;
    } elseif ( $image instanceof Html ) {
        return 'img' === $image->getTag() ? true : false;
    }

    return false;

}

/**
 * Extracts an image src
 *
 * @param  mixed  $image
 * @param  string $size
 * @return string|false
 */

function rwp_extract_img_src( $image, $size = 'full' ) {
     $src = false;

    if ( is_string( $image ) ) {
        if ( rwp_is_url( $image ) ) {
            $src = $image;
        } elseif ( is_numeric( $image ) ) {
            $image = attachment_url_to_postid( $image );
            $src = wp_get_attachment_image_url( $image, $size, false );
        } elseif ( rwp_string_is_html( $image ) ) {
            $image = rwp_html( $image );
            $src = $image->getAttribute( 'src' );
            if ( empty( $src ) ) {
                $src = $image->getAttribute( 'data-src' );
            }
        }
    } elseif ( ( $image instanceof \WP_Post ) ) {
        $src = wp_get_attachment_image_url( $image->ID, $size, false );
    } elseif ( is_int( $image ) ) {
        $src = wp_get_attachment_image_url( $image, $size, false );
    } elseif ( $image instanceof Element ) {
        $src = $image->get_attr( 'src', $src );
        if ( empty( $src ) ) {
            $src = $image->get_attr( 'data-src', $src );
        }
    } elseif ( $image instanceof Html ) {
        $src = $image->getAttribute( 'src' );
        if ( empty( $src ) ) {
            $src = $image->getAttribute( 'data-src' );
        }
    }
    return $src;
}

/**
 * Checks if the variable is an image in the WordPress Media Library
 *
 * @param  mixed $image
 * @return bool
 * @throws InvalidArgumentException
 */

function rwp_is_wp_image( $image ) {
     $image = rwp_extract_img_src( $image );
    if ( rwp_is_url( $image ) ) {
        return 0 !== attachment_url_to_postid( $image );
    }

    return false;

}

/**
 * Get the ID of an image from the WordPress Media Library
 *
 * @param  mixed $image
 * @return int
 * @throws InvalidArgumentException
 */
function rwp_image_id( $image ) {
     $id = 0;
    if ( rwp_is_wp_image( $image ) ) {
        $image = rwp_extract_img_src( $image );
        if ( rwp_is_url( $image ) ) {
            $id = attachment_url_to_postid( $image );
        }
    }

    return $id;
}

/**
 * Get the linked site title or the custom logo
 *
 * @param array $args
 *
 * @return string
 */
function rwp_get_logo( $args = array() ) { 
    $content = get_bloginfo( 'name', 'display' );

    $unlink_homepage_logo = (bool) get_theme_support( 'custom-logo', 'unlink-homepage-logo' );

    if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
        // If on the home page, don't link the logo to home.
        $content = sprintf(
            '<span class="custom-logo-link">%1$s</span>',
            $content
        );
    } else {
        $aria_current = is_front_page() && ! is_paged() ? ' aria-current="page"' : '';

        $content = sprintf(
            '<a href="%1$s" class="custom-logo-link" rel="home"%2$s>%3$s</a>',
            esc_url( home_url( '/' ) ),
            $aria_current,
            $content
        );
    }

    if ( has_custom_logo() ) {
        $content = get_custom_logo();
    }

    $html = rwp_html( $content );

    if ( ! empty( $args ) ) {
        $html->setAllAttributes( $args );
    }

    return $html->saveHTML();
}
