<?php

/** ============================================================================
 * CompanyInfo
 *
 * @package RIESTERWP Plugin\/includes/core/Widgets/CompanyInfo.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */


namespace RWP\Widgets;

use RWP\Components\{Html, SchemaItem, Field};

// Creating the widget
class CompanyInfo extends WidgetBase {

    // The construct part
    function __construct() {
        parent::__construct('Company Info');
    }
    // Creating widget front-end

    public $widget_fields = array(
        array(
            'label' => 'Which Location',
            'id' => 'location',
            'type' => 'select',
            'multiple' => false,
            'options' => [],
        ),
        array(
            'label' => 'Which Items',
            'id' => 'items',
            'type' => 'select',
            'multiple' => true,
            'options' => array(
                'address' => 'Address',
                'phone' => 'Phone',
                'email' => 'Email',
                'fax' => 'Fax',
                'social_profiles' => 'Social Profiles',
                'hours' => 'Business Hours',
            ),
        ),
    );

    public function widget(
        $args,
        $instance
    ) {
        echo $args['before_widget'];

        if ($instance['location'] === 'no-location') {
            $instance['location'] = null;
        }

        echo new SchemaItem($instance);

        echo $args['after_widget'];
    }

    public function init_options() {
        foreach ($this->widget_fields as $i => $widget_field) {
            if ($widget_field['id'] === 'location') {
                $company_info = SchemaItem::getLocation();
                $locations = $company_info->get('locations')->keys();

                $all_locations = [
                    'no-location' => 'No Location'
                ];

                foreach ($locations->all() as $location) {
                    $key = $location;
                    $label = rwp_change_case($key, 'title');
                    $all_locations[$key] = $label;
                }

                $widget_field['options'] = $all_locations;
            }
            $this->widget_fields[$i] = $widget_field;
        }
    }

    public function form($instance) {
        $this->init_options();
        $this->field_generator($instance);
    }
}
