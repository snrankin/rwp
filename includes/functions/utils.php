<?php

/** ============================================================================
 * RWP utils
 *
 * @package RWP\/functions/utils.php
 * @since   0.1.0
 * ========================================================================== */



/**
 * Converts a hex string to an array with rgb info
 *
 * @link https://css-tricks.com/snippets/php/convert-hex-to-rgb/
 *
 * @param mixed $color
 * @return false|(int|float)[]
 */
function rwp_hex_to_rgb( $color ) {
	if ( '#' === $color[0] ) {
                $color = substr( $color, 1 );
	}
	if ( strlen( $color ) == 6 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
			return false;
	}
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array(
			'red' => $r,
			'green' => $g,
			'blue' => $b,
		);
}

/**
 * Returns the luminosity difference between two colors
 *
 * The returned value should be bigger than 5 for best readability.
 *
 * @link https://www.splitbrain.org/blog/2008-09/18-calculating_color_contrast_with_php
 *
 * @param string $color1
 * @param string $color2
 * @return int|float
 */
function rwp_test_color_contrast( $color1, $color2 ) {
	list($red1, $green1, $blue1) = rwp_hex_to_rgb( $color1 );
	list($red2, $green2, $blue2) = rwp_hex_to_rgb( $color2 );
    $contrast1 = 0.2126 * pow( $red1 / 255, 2.2 ) +
          0.7152 * pow( $green1 / 255, 2.2 ) +
          0.0722 * pow( $blue1 / 255, 2.2 );

    $contrast2 = 0.2126 * pow( $red2 / 255, 2.2 ) +
          0.7152 * pow( $green2 / 255, 2.2 ) +
          0.0722 * pow( $blue2 / 255, 2.2 );

    if ( $contrast1 > $contrast2 ) {
        return ( $contrast1 + 0.05 ) / ( $contrast2 + 0.05 );
    } else {
        return ( $contrast2 + 0.05 ) / ( $contrast1 + 0.05 );
    }
}

/**
 * Returns the provided light or dark color depending on which has more contrast
 *
 * @param string $color Color to compare with
 * @param string $light_color Color to return if the background is dark
 * @param string $dark_color Color to return if the background is light
 * @return string
 */
function rwp_color_contrast( $color, $light_color = '#FFFFFF', $dark_color = '#000000' ) {

	$light_contrast = rwp_hex_to_rgb( $color, $light_color );
	$dark_contrast = rwp_hex_to_rgb( $color, $dark_color );

	if ( $light_contrast > $dark_contrast ) {
		return $light_color;
	} else {
		return $dark_color;
	}
}

if ( ! function_exists( 'rwp_get_plugin_file' ) ) {
	require_once __DIR__ . '/utils/file.php';
}

if ( function_exists( 'rwp_get_plugin_file' ) ) {
	rwp_get_plugin_file(array(
		'debug.php',
		'cache.php',
		'string.php',
		'url.php',
		'array.php',
		'object.php',
		'html.php',
		'image.php',
		'acf.php',
		'post.php',
		'menu.php',
		'rest.php',
		'theme.php',
		'company.php',
	), 'includes/functions/utils/', true, true);
}
