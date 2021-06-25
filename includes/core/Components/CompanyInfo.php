<?php

/** ============================================================================
 * CompanyInfo
 *
 * @package RWP\Components
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Components;


class CompanyInfo extends Html {

    public $order = [
        'address',
        'phone',
        'email',
        'fax',
        'hours',
        'social',
    ];

    public $items = [];

    public $phone = [
        'label' => null,
        'link'  => true,
        'atts' => [
            'tag' => 'span',
        ]
    ];

    public $fax = [
        'label' => null,
        'atts'  => [
            'tag' => 'span',
        ]
    ];

    public $address = [
        'items' => ['street', 'unit', 'locality', 'region', 'postal', 'country'],
        'label' => null,
        'link'  => true,
        'atts'  => [
            'tag' => 'address',
        ],
        'separators' => [
            'street_unit' => ',',
            'line1_line2' => ',',
            'locality_region' => ',',
            'postal_country' => ','
        ]
    ];

    public $email = [
        'label' => null,
        'link'  => true,
        'atts'  => [
            'tag' => 'span',
        ]
    ];

    public $wrapper = true;

    public $hours = [
        'label'              => null,
        'schedules'          => [],
        'type'               => 'open',
        'display'            => 'date_time',
        'separator'          => ': ',
        'time_args' => [
            'times'         => [],
            'format'        => 'g:ia',
            'separator'     => '&ndash;',
            'all_day'       => false,
            'all_day_label' => 'All Day',
            'atts' => [
                'tag' => 'span',
                'class' => ['times']
            ]
        ],
        'day_args' => [
            'days'           => [],
            'format'         => 'l',
            'separator'      => '&ndash;',
            'everyday_label' => 'Daily',
            'atts' => [
                'tag' => 'span',
                'class' => ['days']
            ]
        ],
        'atts'    => [
            'tag'   => 'span',
        ]
    ];

    public $location;
    public $location_info;

    public $atts = [
        'tag'   => 'div',
        'class' => [
            'schema-item'
        ]
    ];

    public function __construct($args = []) {

        parent::__construct($args);

        if (!empty($this->location)) {
            $this->addClass($this->location . '-info');
            $this->location_info = self::get_location($this->location);
        } else {
            $this->addClass('company-info');
            $this->location_info = self::get_location();
        }
    }

    public static function get_location($location = null) {

        $company_info = rwp_acf_field('company_info', 0);

        if ($company_info) {
            $locations = $company_info->get('locations');

            if ($locations->has($location)) {
                return $locations->get($location);
            } else {
                return $company_info;
            }
        }
    }
}
