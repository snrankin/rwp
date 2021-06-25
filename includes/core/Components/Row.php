<?php

/** ============================================================================
 * RWP Row
 *
 * @package RWP\Components\Row
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

class Row extends Html {

    public $atts = [
        'tag' => 'div',
        'class' => [
            'row'
        ]
    ];

    public $wrapper = [
        'atts' => [
            'tag' => 'div',
            'class' => [
                'container'
            ]
        ],
    ];

    public $remove_wrapper = false;

    public $remove_gutters = false;

    public $fluid = false;

    public $section = 0;

    public $columns = [];

    public function __construct($args = []) {
        parent::__construct($args);

        $this->columns = rwp_collection($this->columns);
        if ($this->columns->isNotEmpty()) {
            $this->columns = $this->columns->mapInto(__NAMESPACE__ . '\\Column');
        }
        $this->wrapper = new Html($this->wrapper);
    }

    public function addCol($value, $i = null) {

        if (!$value instanceof Column) {
            $value = rwp_column($value);
        }

        $this->columns->put($i, $value);
    }

    public static function addColumn($value, $i = null, $obj) {

        if (!$value instanceof Column) {
            $value = rwp_column($value);
        }

        $obj->columns->put($i, $value);
    }

    public function addColContent($content, $col_index = 0, $content_index = null) {

        if (!$this->columns->has($col_index)) {
            $this->addCol(null, $col_index);
        }

        $col = $this->columns->get($col_index);

        $col->addContent($content, $content_index);

        $this->columns->put($col_index, $col);
    }

    public function preBuild() {

        if (rwp_is_collection($this->columns) && $this->columns->isNotEmpty()) {
            foreach ($this->columns->all() as $i => $col) {
                $this->addContent($col, $i);
            }
        }

        if ($this->remove_gutters) {
            if (!$this->remove_wrapper) {
                $this->wrapper->addClass('no-gutters');
            } else {
                $this->addClass('no-gutters');
            }
            if (!empty($this->background)) {
                $this->content->prepend($this->background);
            }
        }

        if (!$this->remove_wrapper) {
            if (!empty($this->background)) {
                $this->wrapper->content->prepend($this->background);
            }
            $row = $this->build();
            $this->wrapper->content->push($row);
            $this->content = $this->wrapper->content;
            $this->atts = $this->wrapper->atts;
            if ($this->fluid) {
                $this->removeClass('container');
                $this->addClass('container-fluid');
            }
        }
    }
}
