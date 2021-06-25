<?php

/** ============================================================================
 * RWP HtmlList
 *
 * A class for dynamically build html lists
 *
 * @package RWP\Components\HtmlList
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

class HtmlList extends Html {

    public $atts = [
        'tag' => 'ul'
    ];

    public $item_atts = [
        'atts' => [
            'tag' => 'li'
        ]
    ];

    public $items = [];

    public $wrap_items = true;

    public $inline = false;

    public function __construct($args = []) {
        parent::__construct($args);

        $this->items = new Collection($this->items);

        if ($this->inline) {
            $this->addClass('list-inline');
        }
    }

    public function formatItem($args = []) {
        $item_args = $this->item_atts;
        if (is_array($args)) {
            $args = rwp_merge_args($item_args, $args);
            $args = rwp_html($args);
        } else if (is_string($args)) {
            $item_args['content'] = $args;
            $args =  $item_args;
            $args = rwp_html($args);
        } else if (is_object($args)) {
            $args->mergeArgs($item_args);
        }

        if ($this->inline) {
            $args->addClass('list-inline-item');
        }
        return $args;
    }

    public function addItem($args = [], $i = null) {
        $args = $this->formatItem($args);
        $this->items->put($i, $args);
    }


    public function preBuild() {

        if (!$this->hasContent()) {
            if ($this->items->isNotEmpty()) {
                $this->items->transform(function ($item) {
                    $item = $this->formatItem($item);
                    $this->addContent($item);
                    return $item;
                });
            }
        }
    }
}
