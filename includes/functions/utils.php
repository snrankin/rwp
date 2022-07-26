<?php

/** ============================================================================
 * RWP utils
 *
 * @package RWP\/functions/utils.php
 * @since   0.1.0
 * ========================================================================== */


/**
 * Grab the RWP object and return it.
 * Wrapper for RWP::get_instance().
 *
 * @since  0.9.0
 * @return RWP\Plugin
 */
function rwp() {
	if ( ! class_exists( '\\RWP\\Plugin' ) ) {
		require RWP_PLUGIN_ROOT . 'includes/plugin.php';
	}
	return \RWP\Plugin::instance();
}

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 0.9.0
 * @param bool $global
 * @return Collection
 */
function rwp_get_options( $global = false ) {
	return rwp()->get_options( $global );
}


/**
 * Get a plugin option
 *
 * @param mixed $key
 * @param mixed $default
 * @param bool $global
 * @return mixed
 */
function rwp_get_option( $key, $default = null, $global = false ) {
	return rwp()->get_option( $key, $default, $global );
}


/**
 * Get the absolute path of an asset
 *
 * @param string $asset   The asset file name base (including extension but
 *                        not the plugin prefix)
 * @param string $folder  The sub folder the asset is in
 *
 * @param bool   $prefix  Whether to add the plugin prefix to the asset name
 *
 * @return string|false
 */

function rwp_plugin_asset_path( $asset, $folder = '', $prefix = true ) {
	return rwp()->asset_path( $asset, $folder, $prefix );
}

/**
 * Get the relative path of an asset
 *
 * @param string $asset   The asset file name base (including extension but
 *                        not the plugin prefix)
 * @param string $folder  The sub folder the asset is in
 *
 * @param bool   $prefix  Whether to add the plugin prefix to the asset name
 *
 * @return string|false
 */

function rwp_plugin_asset_uri( $asset, $folder = '', $prefix = true ) {
	return rwp()->asset_uri( $asset, $folder, $prefix );
}


/**
 * Get an array of column sizes/percentages
 *
 * @return array
 */
function rwp_bootstrap_columns() {
	if ( ! class_exists( '\\RWP\\Integrations\\Bootstrap' ) ) {
		require RWP_PLUGIN_ROOT . 'includes/core/integrations/Bootstrap.php';
	}
	return \RWP\Integrations\Bootstrap::instance()->columns;
}

/**
 * Get an array of column sizes/percentages
 *
 * @return array
 */
function rwp_bootstrap_colors( $class_prefix = '', $class_suffix = '', $label_prefix = '', $label_suffix = '' ) {
	if ( ! class_exists( '\\RWP\\Integrations\\Bootstrap' ) ) {
		require RWP_PLUGIN_ROOT . 'includes/core/integrations/Bootstrap.php';
	}
	return \RWP\Integrations\Bootstrap::bs_atts( 'colors', $class_prefix, $class_suffix, $label_prefix, $label_suffix );
}

/**
 * Get an array of breakpoints
 *
 * @return array
 */
function rwp_bootstrap_breakpoints( $class_prefix = '', $class_suffix = '', $label_prefix = '', $label_suffix = '' ) {
	if ( ! class_exists( '\\RWP\\Integrations\\Bootstrap' ) ) {
		require RWP_PLUGIN_ROOT . 'includes/core/integrations/Bootstrap.php';
	}
	return \RWP\Integrations\Bootstrap::bs_atts( 'breakpoints', $class_prefix, $class_suffix, $label_prefix, $label_suffix );
}

/**
 * Returns breakpoint value (in pixels)
 *
 * @param string  $name  Breakpoint name
 * @param bool    $unit  Whether or not to include the `px` suffix
 * @param bool    $max   Whether to return the max-width value `($breakpoint - 0.02)`
 *
 * @return int|string|false
 */
function rwp_bootstrap_breakpoint( $breakpoint, $unit = false, $max = false ) {
	if ( ! class_exists( '\\RWP\\Integrations\\Bootstrap' ) ) {
		require RWP_PLUGIN_ROOT . 'includes/core/integrations/Bootstrap.php';
	}
	return \RWP\Integrations\Bootstrap::breakpoint( $breakpoint, $unit, $max );
}

/**
 * Get the prev breakpoint
 * @param string $breakpoint
 * @param string|null $type The return type. Can be one of `value`, `key` or null for both
 * @return mixed
 */
function rwp_bootstrap_breakpoint_prev( $breakpoint, $type = null ) {
	if ( ! class_exists( '\\RWP\\Integrations\\Bootstrap' ) ) {
		require RWP_PLUGIN_ROOT . 'includes/core/integrations/Bootstrap.php';
	}
	$breakpoints = rwp_collection( \RWP\Integrations\Bootstrap::instance()->breakpoints );
	$value = $breakpoints->previous( $breakpoint, $type );
	if ( 'value' === $type ) {
		$value = $value['value'];
	} elseif ( empty( $type ) ) {
		$value['value'] = $value['value']['value'];
	}
	return $value;
}


/**
 * Get the next breakpoint
 * @param string $breakpoint
 * @param string|null $type The return type. Can be one of `value`, `key` or null for both
 * @return mixed
 */
function rwp_bootstrap_breakpoint_next( $breakpoint, $type = null ) {
	if ( ! class_exists( '\\RWP\\Integrations\\Bootstrap' ) ) {
		require RWP_PLUGIN_ROOT . 'includes/core/integrations/Bootstrap.php';
	}
	$breakpoints = rwp_collection( \RWP\Integrations\Bootstrap::instance()->breakpoints );
	$value = $breakpoints->next( $breakpoint, $type );
	if ( 'value' === $type ) {
		$value = $value['value'];
	} elseif ( empty( $type ) ) {
		$value['value'] = $value['value']['value'];
	}
	return $value;
}



/**
 * Check if a variable is an instance of Element class
 * @param mixed $item
 * @return bool
 */
function rwp_is_element( $item ) {
	return ( $item instanceof \RWP\Html\Element );
}

/**
 * Process a shortcode
 *
 * @param mixed $atts The shortcode atts
 * @param array $defaults
 * @return array
 */

function rwp_process_shortcode( $atts, $defaults = array() ) {
	$atts = shortcode_atts(
		$defaults,
		$atts
	);
	$args = array(
		'atts' => array(),
	);
	foreach ( $atts as $key => $value ) {
		switch ( $key ) {
			case 'class':
				if ( ! empty( $value ) ) {
					$value = rwp_parse_classes( $value );
					$args['atts']['class'] = $value;
				}
				break;
			case 'id':
				if ( ! empty( $value ) ) {
					$args['atts']['id'] = $value;
				}
				break;

			default:
				if ( is_string( $value ) && ( 'true' === $value || 'false' === $value ) ) {
					if ( 'true' === $value ) {
						$value = true;
					} else {
						$value = false;
					}
					$args[ $key ] = $value;
				} elseif ( ! empty( $value ) ) {
					$args[ $key ] = $value;
				}

				break;
		}
	}
	$args['atts'] = rwp_prepare_args( $args['atts'] );
	return $args;
}


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
	if ( strlen( $color ) === 6 ) {
		list($r, $g, $b) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) === 3 ) {
		list($r, $g, $b) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
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
