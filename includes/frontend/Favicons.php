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

class Favicons extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		//\add_action( 'customize_register', array( $this, 'customizer' ) );
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
}
