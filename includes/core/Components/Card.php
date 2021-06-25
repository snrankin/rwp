<?php

/** ============================================================================
 * RWP Card
 *
 * @package RWP\Components\Card
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Components\{Html, Media, Button, HtmlList};

class Card extends Html {

    public $order = ['before', 'header', 'media', 'body', 'footer', 'after'];

    public $atts = [
        'tag' => 'div',
        'class' => [
            'card'
        ]
    ];


    public $header = [
        'content' => null,
        'atts' => [
            'tag' => 'header',
            'class' => ['card-header']
        ]
    ];

    /**
     * $media
     *
     * @var array|bool|null|Media $media
     */
    public $media = [
        'size' => 'medium',
        'atts' => [
            'class'     => [
                'card-img',
            ]
        ]
    ];

    public $body = [
        'content' => null,
        'order' => ['title', 'subtitle', 'text', 'buttons'],
        'atts'    => [
            'tag' => 'div',
            'class' => [
                'card-body'
            ]
        ]
    ];

    public $title = [
        'content' => null,
        'atts'    => [
            'tag'   => 'h4',
            'class' => ['card-title']
        ]
    ];

    public $subtitle = [
        'content' => null,
        'atts'    => [
            'tag'   => 'h5',
            'class' => ['card-subtitle']
        ]
    ];

    public $text = [
        'content' => null,
        'atts'    => [
            'tag'   => 'p',
            'class' => ['card-text']
        ]
    ];

    public $buttons = [
        'inline' => true,
        'items' => []
    ];

    public $footer = [
        'content' => null,
        'atts'    => [
            'tag'   => 'footer',
            'class' => ['card-footer']
        ]
    ];

    public function __construct($args = []) {

        parent::__construct($args);

        $this->header   = new Html($this->header);
        $this->media    = new Media($this->media);
        if (empty($this->media->src)) {
            $this->media = false;
        }
        $this->body     = new Html($this->body);
        $this->title    = new Html($this->title);
        $this->subtitle = new Html($this->subtitle);
        $this->text     = new Html($this->text);
        $this->buttons  = new HtmlList($this->buttons);
        $this->footer   = new Html($this->footer);
        $this->setupLinks();
    }

    public function setupLinks() {
        if (empty($this->buttons->items)) return;

        $this->buttons->items->transform(function ($item) {
            if (!($item instanceof Html)) {
                if (is_array($item)) {
                    if (rwp_array_has('button', $item)) {
                        $item = $item['button'];
                    }
                    if (rwp_array_has('atts', $item)) {
                        if (rwp_array_has('class', $item['atts'])) {
                            if ((is_array($item['atts']['class']) && preg_grep('/[\w\-]*btn[\w\-]*/i', $item['atts']['class'])) || is_string($item['atts']['class']) && preg_match('/[\w\-]*btn[\w\-]*/i', $item['atts']['class'])) {
                                $item = rwp_button($item);
                            }
                        } else {
                            $item = rwp_link($item);
                            $item->addClass('card-link');
                        }
                    } else {
                        $item = rwp_link($item);
                        $item->addClass('card-link');
                    }
                }
            }
            if ($item instanceof Html) {
                if (count($this->buttons->items) == 1) {
                    $item->addClass('stretched-link');
                }
                return [
                    'content' => $item->__toString()
                ];
            } else if (is_string($item)) {
                return [
                    'content' => $item
                ];
            }
        });

        $this->buttons->preBuild();
    }

    public function preBuild() {


        if (!empty($this->order)) {
            // Make sure content items appear in the right order
            foreach (['header', 'body', 'footer'] as $location) {
                $location = $this->$location;
                if (is_object($location)) {
                    if (!empty($location->order)) {
                        // Make sure content items appear in the right order
                        foreach ($location->order as $sublocation) {
                            if (!in_array($sublocation, ['before', 'content', 'after'])) {
                                if (property_exists($this, $sublocation) && !in_array($sublocation, $this->order)) {

                                    $location->$sublocation = $this->$sublocation;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
