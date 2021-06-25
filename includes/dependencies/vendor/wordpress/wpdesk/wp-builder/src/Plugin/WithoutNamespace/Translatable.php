<?php

namespace RWP\Vendor;

if (!\interface_exists('RWP\\Vendor\\WPDesk_Translable')) {
    require_once 'Translable.php';
}
interface WPDesk_Translatable extends WPDesk_Translable {
    /** @return string */
    public function get_text_domain();
}
\class_alias(__NAMESPACE__ . '\\WPDesk_Translatable', 'WPDesk_Translatable', \false);
