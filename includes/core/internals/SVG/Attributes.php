<?php

namespace RWP\Internals\SVG;

if ( ! class_exists( 'RWP\Internals\SVG\Data\AllowedAttributes' ) ) {
	require __DIR__ . '/Data/AllowedAttributes.php';
}

class Attributes extends \RWP\Internals\SVG\Data\AllowedAttributes {
	/**
	 * Returns an array of attributes
	 *
	 * @return array
	 */
	public static function getAttributes() {
		/**
		 * var  array Attributes that are allowed.
		 */
		return \apply_filters( 'svg_allowed_attributes', parent::getAttributes() ); // phpcs:ignore
	}
}
\class_alias( __NAMESPACE__ . '\\Attributes', 'SafeSVGAttributes', \false );
