<?php

/** ============================================================================
 * Define the internationalization functionality.
 *
 *
 * @version    0.1.0
 * @link       https://developer.wordpress.org/plugins/internationalization/
 * @package    RWP
 * ========================================================================== */

namespace RWP\Traits;

/**
 * Class RWP_i18n
 *
 * Loads and defines the internationalization files for this plugin so that it
 * is ready for translation.
 *
 * @since      0.1.0
 * @package    RWP
 */
trait I18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since    0.1.0
     */
    public function load_textdomain() {
        load_plugin_textdomain($this->prefix, false, dirname($this->file) . '/i18n/languages');
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the RWP_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $this->add_action('plugins_loaded', $this, 'load_plugin_textdomain');
    }
}
