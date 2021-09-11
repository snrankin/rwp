<?php

namespace RWP\Vendor\SafeSVG;

class Tags extends Data\AllowedTags {
	/**
	 * Returns an array of tags
	 *
	 * @return array
	 */
	public static function getTags() {
		/**
		 * var  array Tags that are allowed.
		 */
		return \apply_filters('svg_allowed_tags', parent::getTags());
	}
}
\class_alias(__NAMESPACE__ . '\\Tags', 'SafeSVGTags', \false);
