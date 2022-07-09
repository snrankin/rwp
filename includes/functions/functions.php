<?php
/** ============================================================================
 * functions
 *
 * @package   RWP\functions
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

use RWP\Components\Collection;
use RWP\Engine\Plugin;
use RWP\Vendor\PUC\Factory;
use RWP\Integrations\Bootstrap;
/**
 * Grab the RWP object and return it.
 * Wrapper for RWP::get_instance().
 *
 * @since  0.9.0
 * @return RWP\Engine\Plugin
 */
function rwp() {
	return Plugin::instance();

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
 * Hooks a single callback to multiple tags
 *
 * @param array    $tags            An array of filter tags to add the function to
 * @param callable $function        The callback to be run when the filter is applied.
 * @param int      $priority        Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action. Default 10.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 *
 * @return void
 */
function rwp_add_filters( $tags, $function, $priority = 10, $accepted_args = 1 ) {
	foreach ( (array) $tags as $tag ) {
		add_filter( $tag, $function, $priority, $accepted_args );
	}
}

/**
 * Applies multiple filter to the same set of arguments
 *
 * @param array $tags            An array of filter tags to add the function to
 * @param mixed $accepted_args
 * @return void
 */
function rwp_apply_filters( $tags, ...$accepted_args ) {
	foreach ( (array) $tags as $tag ) {
		apply_filters( $tag, ...$accepted_args );
	}
}

/**
 * Check if a variable had value
 *
 * @param mixed $input
 *
 * @return bool
 */

function rwp_has_value( $input ) {
	return filled( $input );
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
	return Bootstrap::instance()->columns;
}

/**
 * Get an array of column sizes/percentages
 *
 * @return array
 */
function rwp_bootstrap_colors( $class_prefix = '', $class_suffix = '', $label_prefix = '', $label_suffix = '' ) {
	return Bootstrap::bs_atts( 'colors', $class_prefix, $class_suffix, $label_prefix, $label_suffix );
}

/**
 * Get an array of breakpoints
 *
 * @return array
 */
function rwp_bootstrap_breakpoints( $class_prefix = '', $class_suffix = '', $label_prefix = '', $label_suffix = '' ) {
	return Bootstrap::bs_atts( 'breakpoints', $class_prefix, $class_suffix, $label_prefix, $label_suffix );
}

/**
 * Returns breakpoint value (in pixels)
 * @param string $breakpoint
 * @return int|false
 */
function rwp_bootstrap_breakpoint( $breakpoint ) {
	return Bootstrap::breakpoint( $breakpoint );
}

/**
 * Get the prev breakpoint
 * @param string $breakpoint
 * @param string|null $type The return type. Can be one of `value`, `key` or null for both
 * @return mixed
 */
function rwp_bootstrap_breakpoint_prev( $breakpoint, $type = null ) {
	$breakpoints = rwp_collection( Bootstrap::instance()->breakpoints );
	$value = $breakpoints->previous( $breakpoint, $type );
	if ( 'value' === $type ) {
		$value = $value['value'];
	} else if ( empty( $type ) ) {
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
	$breakpoints = rwp_collection( Bootstrap::instance()->breakpoints );
	$value = $breakpoints->next( $breakpoint, $type );
	if ( 'value' === $type ) {
		$value = $value['value'];
	} else if ( empty( $type ) ) {
		$value['value'] = $value['value']['value'];
	}
	return $value;
}

/**
 * Checks if we are currently in elementor preview mode
 *
 * @return bool
 */
function rwp_is_elementor_preview() {
	if ( is_plugin_active( 'elementor/elementor.php' ) && class_exists( '\\Elementor\\Plugin' ) ) {
		$elementor_instance = \Elementor\Plugin::instance();
		if ( ! empty( $elementor_instance ) ) {
			$preview = $elementor_instance->preview;
			if ( $preview instanceof \Elementor\Preview ) {
				return $preview->is_preview_mode();
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
			return false;
	}
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
				} else if ( ! empty( $value ) ) {
					$args[ $key ] = $value;
				}

				break;
		}
	}
	$args['atts'] = rwp_prepare_args( $args['atts'] );
	return $args;
}


function rwp_custom_bulk_action( $post_type, $actions = [] ) {
	$bulk_actions = new \RWP\Internals\CustomBulkAction( array( 'post_type' => $post_type ) );

	if ( wp_is_numeric_array( $actions ) ) {
		foreach ( $actions as $action ) {
			$bulk_actions->register_bulk_action( $action );
		}
	} else {
		$bulk_actions->register_bulk_action( $actions );
	}
	$bulk_actions->init();
}
