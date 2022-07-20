<?php

/** ============================================================================
 * Convert all helper classes into to easy to call functions
 *
 * @package   RWP
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */




// ============================ Vendor Components =========================== //

/**
 * Function wrapper for Collection class
 *
 * @param mixed $args The Collection class arguments
 *
 * @return Collection
 */

function rwp_collection( $args = array() ) {
	return new RWP\Helpers\Collection( $args );
}

/**
 * Create a new configuration repository.
 * @param array $args
 * @return Repository
 */
function rwp_config( $args = [] ) {
	return new RWP\Vendor\Illuminate\Config\Repository( $args );
}

/**
 * Get hierarchy.
 *
 * @link https://github.com/Brain-WP/Hierarchy
 *
 * @param WP_Query|null $query
 * @return array
 */
function rwp_hierarchy( $query = null ) {
	$hierarchy = new RWP\Vendor\Brain\Hierarchy\Hierarchy( RWP\Vendor\Brain\Hierarchy\Hierarchy::NOT_FILTERABLE );
	return $hierarchy->getHierarchy( $query );
}

/**
 * Class to manipulate html strings
 *
 * @link https://github.com/wasinger/htmlpagedom
 *
 * @param mixed $html
 * @return RWP\Html\Html
 */
function rwp_html( $html ) {
	return new RWP\Html\Html( $html );
}

/**
 * Class to manipulate html pages
 *
 * @link https://github.com/wasinger/htmlpagedom
 *
 * @param string $html
 * @return RWP\Vendor\Wa72\HtmlPageDom\HtmlPage
 */
function rwp_html_page( $html ) {
	return new RWP\Vendor\Wa72\HtmlPageDom\HtmlPage( $html );
}



function rwp_element( $args = array() ) {
	return new RWP\Html\Element( $args );
}

function rwp_icon( $args = array() ) {
	return new RWP\Html\Icon( $args );
}

function rwp_button( $args = array() ) {
	return new RWP\Html\Button( $args );
}

function rwp_image( $args = array() ) {
	return new RWP\Html\Image( $args );
}

function rwp_svg( $args = array() ) {
	return new RWP\Html\SVG( $args );
}

function rwp_nav_item( $args = array() ) {
	return new RWP\Html\NavItem( $args );
}

function rwp_list( $args = array() ) {
	return new RWP\Html\HtmlList( $args );
}

function rwp_nav( $args = array() ) {
	return new RWP\Html\Nav( $args );
}

function rwp_column( $args = array() ) {
	return new RWP\Html\Column( $args );
}

function rwp_row( $args = array() ) {
	return new RWP\Html\Row( $args );
}

function rwp_container( $args = array() ) {
	return new RWP\Html\Container( $args );
}

function rwp_section( $args = array() ) {
	return new RWP\Html\Section( $args );
}

function rwp_embed( $args = array() ) {
	return new RWP\Html\Embed( $args );
}

function rwp_card( $args = array() ) {
	return new RWP\Html\Card( $args );
}

function rwp_post_card( $post = null, $args = [] ) {
	return new RWP\Html\PostCard( $post, $args );
}

function rwp_modal( $args = array() ) {
	return new RWP\Html\Modal( $args );
}

function rwp_location( $location = null, $args = [] ) {
	return new RWP\Html\Location( $location, $args );
}

function rwp_locations( $locations = array(), $args = [] ) {
	return RWP\Html\Location::output_locations( $locations, $args );
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
