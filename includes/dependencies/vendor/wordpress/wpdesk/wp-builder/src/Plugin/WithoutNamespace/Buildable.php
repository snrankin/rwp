<?php

namespace RWP\Vendor;

/**
 * Have info about what class should be built by WPDesk_Builder
 *
 * have to be compatible with PHP 5.2.x
 */
interface WPDesk_Buildable {
    /** @return string */
    public function get_class_name();
}
/**
 * Have info about what class should be built by WPDesk_Builder
 *
 * have to be compatible with PHP 5.2.x
 */
\class_alias(__NAMESPACE__ . '\\WPDesk_Buildable', 'WPDesk_Buildable', \false);
