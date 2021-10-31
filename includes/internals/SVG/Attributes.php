<?php

namespace RWP\Internals\SVG;

class Attributes extends Data\AllowedAttributes {
	/**
	 * Returns an array of attributes
	 *
	 * @return array
	 */
	public static function getAttributes() {
		/**
		 * var  array Attributes that are allowed.
		 */
		return \apply_filters('svg_allowed_attributes', parent::getAttributes());
	}
}
\class_alias(__NAMESPACE__ . '\\Attributes', 'SafeSVGAttributes', \false);
