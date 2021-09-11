<?php

namespace RWP\Vendor;

if (!\interface_exists('RWP\\Vendor\\WPDesk_Translatable')) {
    require_once __DIR__ . '/Translatable.php';
}
interface WPDesk_Has_Plugin_Info extends WPDesk_Translatable {
    /**
     * @return string
     */
    public function get_plugin_file_name();
    /**
     * @return string
     */
    public function get_plugin_dir();
    /**
     * @return string
     */
    public function get_version();
}
\class_alias(__NAMESPACE__ . '\\WPDesk_Has_Plugin_Info', 'WPDesk_Has_Plugin_Info', \false);
