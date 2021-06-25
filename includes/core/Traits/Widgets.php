<?php

/** ============================================================================
 * Widgets
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/Widgets.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\{Html, SchemaItem, Grid, Row, Column};

trait Widgets {

    /**
     * Registered Widgets
     *
     * @var array|Collection $widgets
     */
    protected $widgets = [
        'Logo',
        'Shortcode'
    ];

    // Register and load the widget
    function init_widgets() {
        $this->add_action('widgets_init', $this, 'register_widgets');
    }

    // Register and load the widget
    function register_widgets() {
        if ($this->widgets->isNotEmpty()) {
            $this->widgets->each(function ($widget) {
                $widget = '\\RWP\\Widgets\\' . $widget;
                register_widget($widget);
            });
        }
    }
}
