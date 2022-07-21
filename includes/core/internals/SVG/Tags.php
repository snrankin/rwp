<?php

namespace RWP\Internals\SVG;

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
		return \apply_filters( 'svg_allowed_tags', parent::getTags() ); // phpcs:ignore
	}
}
\class_alias( __NAMESPACE__ . '\\Tags', 'SafeSVGTags', \false );
