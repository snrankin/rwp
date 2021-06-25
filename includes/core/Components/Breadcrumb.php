<?php

/** ============================================================================
 * RWP Breadcrumb
 *
 * @package RWP\Components\Breadcrumb
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Components\{Nav, NavItem};

class Breadcrumb extends Nav {

    public $direction = 'horizontal';

    public $item_args = [
        'atts' => [
            'tag' => 'li',
            'class' => [
                'breadcrumb-item'
            ]
        ]
    ];

    public $items = [];

    public $list = [
        'atts' => [
            'tag' => 'ol',
            'class' => [
                'breadcrumb'
            ]
        ]
    ];

    public $atts = [
        'tag'   => 'nav',
        'id'    => 'breadcrumb',
        'class' => [
            'breadcrumb-wrapper',
        ],
        'role' => 'navigation',
        'aria-label' => 'breadcrumb'
    ];

    public function __construct($args = []) {

        parent::__construct($args);

        $this->items = rwp_collection($this->items);

        $this->list->item_atts = $this->item_args;

        $this->setupLinks();
    }

    public function setupLinks() {

        if ($this->items->isNotEmpty()) {

            $this->items->transform(function ($item, $i) {
                $item_args = $this->item_args;
                $active_id = $this->items->keys()->last();

                if ($i !== $active_id) {
                    $breadcrumb = rwp_link([
                        'content' => $item['text'],
                        'atts' => [
                            'href' => rwp_relative_url($item['url'])
                        ],
                    ]);
                    $item_args['content'] = $breadcrumb->__toString();
                } else {
                    $item_args['content'] = $item['text'];
                    $item_args['atts']['aria-current'] = 'location';
                    $item_args['atts']['class'][] = 'active';
                }

                return $item_args;
            });

            $this->list->items = $this->items;
            $this->list->preBuild();
        }
    }
}
