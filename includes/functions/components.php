<?php
/** ============================================================================
 * Convert all component classes into to easy to call functions
 *
 * @package   RWP
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

use RWP\Vendor\Illuminate\Config\Repository;
use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Vendor\Brain\Hierarchy\Hierarchy;
use RWP\Components\Html;

// ============================ Vendor Components =========================== //


/**
 * Create a new configuration repository.
 * @param array $args
 * @return Repository
 */
function rwp_config( $args = [] ) {
	return new Repository( $args );
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
	$hierarchy = new Hierarchy( Hierarchy::NOT_FILTERABLE );
	return $hierarchy->getHierarchy( $query );
}

/**
 * Class to manipulate html strings
 *
 * @link https://github.com/wasinger/htmlpagedom
 *
 * @param mixed $html
 * @return Html
 */
function rwp_html( $html ) {
	return new Html( $html );
}

function rwp_icon( $args = array() ) {
	return new RWP\Components\Icon( $args );
}

function rwp_button( $args = array() ) {
	return new RWP\Components\Button( $args );
}

function rwp_image( $args = array() ) {
	return new RWP\Components\Image( $args );
}

function rwp_svg( $args = array() ) {
	return new RWP\Components\SVG( $args );
}

function rwp_nav_item( $args = array() ) {
	return new RWP\Components\NavItem( $args );
}

function rwp_list( $args = array() ) {
	return new RWP\Components\HtmlList( $args );
}

function rwp_nav( $args = array() ) {
	return new RWP\Components\Nav( $args );
}

function rwp_column( $args = array() ) {
	return new RWP\Components\Column( $args );
}

function rwp_row( $args = array() ) {
	return new RWP\Components\Row( $args );
}

function rwp_container( $args = array() ) {
	return new RWP\Components\Container( $args );
}

function rwp_section( $args = array() ) {
	return new RWP\Components\Section( $args );
}

function rwp_embed( $args = array() ) {
	return new RWP\Components\Embed( $args );
}
