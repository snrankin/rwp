<?php
/** ============================================================================
 * Functions to get company info
 *
 * @package   RWP\/includes/functions/utils/company.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2022 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

/**
 * Gets/outputs the company name
 *
 * @param bool $echo
 * @return mixed
 */
function rwp_company_name( $echo = false ) {

	$company_name = rwp_get_option( 'company_info.company_name', get_bloginfo( 'name' ) );

	if ( $echo ) {
		echo wp_kses_post( $company_name );
	} else {
		return $company_name;
	}
}

/**
 * Gets the company address
 *
 * @param mixed $location
 * @param array $args
 * @return string
 * @throws DOMException
 */
function rwp_company_address( $location = null, $args = array() ) {
	$defaults = array(
		'order' => array( 'address' ),
	);
	$args = rwp_merge_args( $defaults, $args );

	$address = rwp_location( $location, $args )->html();

	return $address;
}

/**
 * Gets the company phone
 *
 * @param mixed $location
 * @param array $args
 * @return string
 * @throws DOMException
 */
function rwp_company_phone( $location = null, $args = array() ) {
	$defaults = array(
		'order' => array( 'phone' ),
	);
	$args = rwp_merge_args( $defaults, $args );

	$phone = rwp_location( $location, $args )->html();

	return $phone;
}

/**
 * Gets the company fax
 *
 * @param mixed $location
 * @param array $args
 * @return string
 * @throws DOMException
 */
function rwp_company_fax( $location = null, $args = array() ) {
	$defaults = array(
		'order' => array( 'fax' ),
	);
	$args = rwp_merge_args( $defaults, $args );

	$fax = rwp_location( $location, $args )->html();

	return $fax;
}

/**
 * Gets the company email
 *
 * @param mixed $location
 * @param array $args
 * @return string
 * @throws DOMException
 */
function rwp_company_email( $location = null, $args = array() ) {
	$defaults = array(
		'order' => array( 'email' ),
	);
	$args = rwp_merge_args( $defaults, $args );

	$email = rwp_location( $location, $args )->html();

	return $email;
}

/**
 * Gets the company schedule
 *
 * @param mixed $location
 * @param array $args
 * @return string
 * @throws DOMException
 */
function rwp_company_schedule( $location = null, $args = array() ) {
	$defaults = array(
		'order' => array( 'schedule' ),
	);
	$args = rwp_merge_args( $defaults, $args );

	$schedule = rwp_location( $location, $args )->html();

	return $schedule;
}
