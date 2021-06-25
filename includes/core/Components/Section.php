<?php

/** ============================================================================
 * RWP Section
 *
 * @package RWP\Components\Section
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

/**
 * A class for dynamically building rows
 *
 * @package App\Modules\Section
 *
 * @inheritDoc App\Modules\Html
 */

class Section extends Html {

    /**
     * @var array $order The order of content items;
     */
    public $order = [
        'before',
        'background',
        'inner',
        'after'
    ];

    /**
     * @var array $atts The outer wrapper attributes
     */

    public $atts = [
        'tag' => 'section',
        'class' => [
            'section-wrapper'
        ]
    ];

    /**
     * @var array|Html $inner
     */

    public $inner = [
        'atts' => [
            'tag' => 'div',
            'class' => [
                'section-inner'
            ]
        ],
    ];

    /**
     * @var array|Collection $rows
     */

    public $rows = [];


    /**
     * @var array|bool|null|Media $background
     */
    public $background = [
        'is_bg' => 'cover',
    ];

    public function __construct($args = []) {
        parent::__construct($args);
        $this->rows = rwp_collection($this->rows);
        $this->inner = rwp_html($this->inner);

        if (is_array($this->background) && rwp_array_has('src', $this->background)) {
            $this->background['is_bg'] = 'cover';
            $this->background = new Media($this->background);
        }
    }

    public function addContent($value, $i = null) {
        $this->inner->addContent($value, $i);
    }

    public function addRow($args = [], $row_index = null) {
        if (!empty($args)) {
            if ($args instanceof Row) {
                $row = $args;
            } else {
                $row = new Row($args);
            }
        } else {
            $row = new Row();
        }

        $this->rows->put($row_index, $row);
    }

    public function preBuild() {

        if (rwp_is_collection($this->rows) && $this->rows->isNotEmpty()) {
            foreach ($this->rows->all() as $i => $row) {
                $this->addContent($row, $i);
            }
        }

        if (is_array($this->background) && rwp_array_has('src', $this->background)) {
            $this->background['is_bg'] = 'cover';
            $this->background = new Media($this->background);
        }

        if (is_object($this->background)) {
            if ($this->background->hasArg('src')) {
                $this->content->put('background', $this->background->__toString());
            }
        }

        if (is_string($this->background) && !empty($this->background)) {
            $this->content->put('background', $this->background);
        }


        $this->inner->preBuild();

        if ($this->inner->content->isNotEmpty()) {
            $this->content->put('inner', $this->inner->__toString());
        }
    }
}
