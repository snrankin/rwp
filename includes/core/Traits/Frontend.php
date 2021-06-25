<?php

/** ============================================================================
 * The public-facing functionality of the plugin.
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/Frontend.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

trait Frontend {


    public function frontend_hooks() {
        $this->add_action('wp_enqueue_scripts', $this, 'frontend_assets');
    }

    /**
     * Register the styles and scripts for the frontend area.
     *
     * @since    0.1.0
     */
    public function frontend_assets() {
        $this->register_assets('public');
        $this->enqueue_assets('public');
    }
}
