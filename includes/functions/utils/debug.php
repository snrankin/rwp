<?php

/** ============================================================================
 * debug
 *
 * @package   RWP\functions\debug
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


use RWP\Integrations\QM\QM;
use RWP\Vendor\Symfony\Component\VarDumper\VarDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Cloner\VarCloner;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\AbstractDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Caster\{LinkStub, ClassStub, ImgStub, TraceStub};

/**
 * A wrapper for Symfony VarDumper
 *
 * @see https://symfony.com/doc/current/components/var_dumper.html
 *
 * @param mixed $var The variable to dump
 *
 * @return VarDumper
 */
function rwp_dump( $var, $theme = 'dark' ) {
	$output = '';
	$cloner = new VarCloner();
	$dumper = new HtmlDumper( null, null, AbstractDumper::DUMP_LIGHT_ARRAY );
	$file_link_format = QM::get_file_link_format();
	$dumper->setDisplayOptions(array(
		'fileLinkFormat' => $file_link_format,
	));

	$dumper->setTheme( $theme );

	$output = $dumper->dump($cloner->cloneVar( $var ), true, [
		'maxDepth' => -1,
	]);

	return $output;
}



function rwp_caster( $object, $array, $stub, $is_nested, $filter = 0 ) {

	//$array = rwp_object_to_array( $object );

	$file = data_get( $array, '-file', RWP_PLUGIN_FILE );

	if ( ! blank( $file ) ) {
		$array['-file'] = new LinkStub( "file:/$file" );
	}

	$settings = rwp()->get_settings_uri();

	if ( ! blank( $settings ) ) {
		$components = parse_url( $settings );
		parse_str( $components['query'], $results );
		$settings = data_get( $results, 'page', false );
		if ( $settings ) {
			$settings = esc_url(add_query_arg(
				'page',
				'rwp-options',
				get_admin_url() . 'admin.php'
			));
			$array['#settings_uri'] = new LinkStub( $settings );
		}
	}

	$icon = rwp()->get_settings_icon( true );

	if ( $icon ) {
		$array['*icon'] = new ImgStub( $icon, 'image/svg+xml' );
	}

	return $array;
}

/**
 * Add a variable to Query Monitor
 *
 * Only visible to admins if WP_DEBUG is on
 *

 * @return void
 */
function rwp_log() {

	if ( class_exists( 'QM' ) && is_plugin_active( 'query-monitor/query-monitor.php' ) ) {
		$vars = func_get_args();
		foreach ( $vars as $var ) {
			/**
			 * @var RWP\Integrations\QM\QM $qm
			 */
			$qm = QM::instance();
			$qm->log( $var, false, 'rwp_dump' );
		}
	}
}



/**
 * Print to the in Query Monitor Log panel
 *
 * @link https://querymonitor.com/blog/2018/07/profiling-and-logging/
 *
 * @param mixed  $message The message. Can also be a WP_Error or Exception
 *                        object
 *
 * @param string $level   The log level for Query Monitor. A log level of
 *                        warning or higher will trigger a notification
 *                        in Query Monitor’s admin toolbar. Can be one
 *                        of: * emergency * alert * critical * error *
 *                        warning * notice * info * debug
 *
 * @param array  $context Contextual interpolation can be used via the curly
 *                        brace syntax: `do_action( 'qm/warning',
 *                        'Unexpected value of {foo} encountered', [ 'foo'
 *                        => $foo, ] );`
 *
 * @return void
 */

function rwp_qm_log( $message, $level = 'error', $context = array() ) {
	do_action( "qm/$level", $message, $context ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
}

/**
 * Function for seeing all registered shortcodes
 *
 * @return int[]|string[]
 */
function rwp_get_list_of_shortcodes() {

	// Get the array of all the shortcodes
	global $shortcode_tags;

	$shortcodes = $shortcode_tags;

	// sort the shortcodes with alphabetical order
	ksort( $shortcodes );

	return array_keys( $shortcodes );
}

/**
 * Function for seeing all registered post types
 *
 * @return string[]|WP_Post_Type[]
 */
function rwp_get_registered_post_types() {
	$get_cpt_args = array(
		'public'   => true,
		'_builtin' => false,
	);
	return get_post_types( $get_cpt_args, 'names' ); // use 'names' if you want to get only name of the post type.
}
