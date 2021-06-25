<?php

/** ============================================================================
 * CompanyInfo
 *
 * @package RIESTERWP Plugin\/includes/core/Widgets/CompanyInfo.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */


namespace RWP\Widgets;

// Creating the widget
class Logo extends WidgetBase {

    // The construct part
    function __construct() {
        parent::__construct('Logo');
    }
    // Creating widget front-end

    public $widget_fields = [
        [
            'label' => 'Add widget wrapper',
            'id' => 'wrapper',
            'type' => 'checkbox',
        ],
    ];

    public function widget($args, $instance) {

        echo $args['before_widget'];

        echo rwp_get_logo();


        echo $args['after_widget'];
    }
}
