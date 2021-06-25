<?php

/** ============================================================================
 * RWP Column
 *
 * A class for creating grid columns
 *
 * @package    RWP\Components\Column
 * @since      0.1.0
 * @inheritDoc \RWP\Components\Html
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

class Column extends Html {

    public $order = ['before', 'background', 'inner', 'after'];

    public $atts = [
        'tag' => 'div',
        'class' => [
            'col'
        ]
    ];

    public $inner = [
        'atts' => [
            'tag' => 'div',
            'class' => [
                'content-wrapper'
            ]
        ],
    ];

    public $row = 0;

    public $background;


    public function __construct($args = []) {

        parent::__construct($args);

        $this->inner = new Html($this->inner);
        if ($this->content->isNotEmpty()) {
            $this->inner->content = $this->content;
            $this->content = new Collection();
        }
        if (is_array($this->background)) {
            $this->background = new Media($this->background);
        }
    }

    public function addContent($value, $i = null) {
        $this->inner->addContent($value, $i);
    }

    public function preBuild() {

        if (is_array($this->background)) {
            $this->background = new Media($this->background);
        }

        $this->inner->preBuild();

        if ($this->inner->content->isNotEmpty()) {
            $this->content->put('inner', $this->inner->__toString());
        }
    }
}
