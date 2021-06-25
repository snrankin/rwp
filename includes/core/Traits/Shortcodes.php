<?php

/** ============================================================================
 * Shortcodes
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/Shortcodes.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\{Html, SchemaItem, Grid, Row, Column};

trait Shortcodes {

    /**
     * Registered Shortcodes
     *
     * @var array|Collection $shortcodes
     */
    protected $shortcodes = [
        'copyright'       => 'copyright',
        'company_info'    => 'schema_item',
        'address'         => 'schema_item',
        'email'           => 'schema_item',
        'hours'           => 'schema_item',
        'phone'           => 'schema_item',
        'social_profiles' => 'schema_item',
        'logo'            => 'logo',

    ];

    public static function process_shortcode($atts, $defaults = []) {
        $atts = shortcode_atts(
            $defaults,
            $atts
        );
        $args = [
            'atts' => []
        ];
        foreach ($atts as $key => $value) {
            switch ($key) {
                case 'class':
                    if (!empty($value)) {
                        $value = rwp_parse_classes($value);
                        $args['atts']['class'] = $value;
                    }
                    break;
                case 'id':
                    if (!empty($value)) {
                        $args['atts']['id'] = $value;
                    }
                    break;

                default:
                    if (is_string($value) && ($value === 'true' || $value === 'false')) {

                        $args[$key] = boolval($value);
                    } else if (!empty($value)) {
                        $args[$key] = $value;
                    }

                    break;
            }
        }
        $args['atts'] = rwp_prepare_atts($args['atts']);
        return $args;
    }

    public function add_shortcode($tag, $callback = null) {
        if (empty($callback)) {
            $callback = $tag;
        }
        $this->shortcodes->put($this->prefix($tag), [$this, $callback]);
    }
    public function register_shortcodes() {
        if ($this->shortcodes->isNotEmpty()) {
            $this->shortcodes->transform(function ($callback, $tag) {
                if (empty($callback)) {
                    $callback = $tag;
                }
                add_shortcode($this->prefix($tag), [$this, $callback]);

                return $callback;
            });
        }
    }
    public function init_shortcodes() {
        $this->add_action('init', $this, 'register_shortcodes');
    }

    public function schema_item($atts, $content = '', $tag) {
        $tag = $this->unprefix($tag);
        $item = SchemaItem::shortcode($atts, $content, $tag);

        return $item->__toString();
    }


    public function logo() {

        return rwp_get_logo();
    }
    public function copyright($atts) {
        $defaults = [
            'class'   => 'copyright',
            'content' => '&copy; Copyright {year}, All Rights Reserved.'
        ];

        $atts = self::process_shortcode($atts, $defaults);

        $atts['content'] = str_replace('{year}', date('Y'), $atts['content']);

        $args = [
            'content' => $atts['content'],
            'atts' => $atts['atts'],
        ];

        $args['atts']['tag'] = 'span';

        $copyright = new Html($args);

        return $copyright->__toString();
    }
}
