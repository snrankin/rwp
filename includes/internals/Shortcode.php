<?php
/** ============================================================================
 * Shortcodes of this plugin
 *
 * @package   RWP\Internals
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Internals;

use RWP\Engine\Abstracts\Singleton;

/**
 * Shortcodes of this plugin
 */
class Shortcode extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		\add_shortcode( 'copyright', array( $this, 'copyright' ) );
	}

	/**
	 * Easily add copyright info with an auto-updating year
	 *
	 * @param array $atts
	 * @return string
	 */

	public static function copyright( $atts ) {
        $defaults = array(
            'before' => '&copy; Copyright ',
			'after' => ', All Rights Reserved.',
		);

        $atts = self::process_shortcode( $atts, $defaults );

		return wp_sprintf( '%s%d%s', $atts['before'], date( 'Y' ), $atts['after'] );
    }

	/**
	 * Process a shortcode
	 *
	 * @param mixed $atts The shortcode atts
	 * @param array $defaults
	 * @return array
	 */

	public static function process_shortcode( $atts, $defaults = array() ) {
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
                    if ( is_string( $value ) && ( $value === 'true' || $value === 'false' ) ) {
                        $args[ $key ] = boolval( $value );
                    } else if ( ! empty( $value ) ) {
                        $args[ $key ] = $value;
                    }

                    break;
            }
        }
        $args['atts'] = rwp_prepare_args( $args['atts'] );
        return $args;
    }

}
