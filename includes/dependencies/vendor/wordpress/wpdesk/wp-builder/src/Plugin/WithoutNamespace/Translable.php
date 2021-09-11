<?php

namespace RWP\Vendor;

/**
 * @deprecated Have typo so better use WPDesk_Translatable
 */
interface WPDesk_Translable {
    /** @return string */
    public function get_text_domain();
}
/**
 * @deprecated Have typo so better use WPDesk_Translatable
 */
\class_alias(__NAMESPACE__ . '\\WPDesk_Translable', 'WPDesk_Translable', \false);
