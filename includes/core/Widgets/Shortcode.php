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
class Shortcode extends WidgetBase {

    // The construct part
    function __construct() {
        parent::__construct('Shortcode');
    }
    // Creating widget front-end

    public $widget_fields = [
        [
            'label' => 'Shortcode',
            'id' => 'shortcode',
            'type' => 'text',
        ],
        [
            'label' => 'Add widget wrapper',
            'id' => 'wrapper',
            'type' => 'checkbox',
        ],
    ];

    public function widget($args, $instance) {


        if ($instance['wrapper']) {
            echo $args['before_widget'];
        }

        if (!empty($instance['shortcode'])) {

            echo do_shortcode($instance['shortcode']);
        }


        if ($instance['wrapper']) {
            echo $args['after_widget'];
        }
    }
}
