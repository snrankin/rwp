<?php

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\{Collection as Collection};

class Grid {

    use Helpers;

    public $sections = [];
    public $rows = [];
    public $columns = [];

    public function __construct($args = []) {

        $properties = get_object_vars($this);

        if (!empty($args)) {
            $properties = rwp_merge_args($properties, $args);
            foreach ($properties as $key => $value) {
                $this->$key = $value;
            }
        }

        $this->columns = new Collection($this->columns);

        if ($this->columns->isNotEmpty()) {
            $this->columns = $this->columns->mapInto(__NAMESPACE__ . '\\Column');
        }


        $this->rows = new Collection($this->rows);

        if ($this->rows->isNotEmpty()) {
            $this->rows = $this->rows->mapInto(__NAMESPACE__ . '\\Row');
        }

        $this->sections = new Collection($this->sections);

        if ($this->sections->isNotEmpty()) {
            $this->sections = $this->sections->mapInto(__NAMESPACE__ . '\\Section');
        }

        $this->output = rwp_array_to_object([
            'columns' => new Collection,
            'rows' => new Collection,
            'sections' => new Collection
        ]);
    }

    public function addCol($column = null, $col_index = null) {

        if (!$column instanceof Column) {
            $column = new Column($column);
        }

        if (!$this->rows->has($column->row)) {
            $this->addRow(null, $column->row);
        }

        $this->columns->put($col_index, $column);
    }

    public function addColContent($content, $col_index = 0, $content_index = null) {

        if (!$this->columns->has($col_index)) {
            $this->addCol(null, $col_index);
        }

        $col = $this->columns->get($col_index);

        if (!empty($col)) {
            $col->addContent($content, $content_index);

            $this->columns->put($col_index, $col);
        }
    }

    public function addRow($row = null, $row_index = 0) {

        if (!$row instanceof Row) {
            $row = new Row($row);
        }

        if (!$this->sections->has($row->section)) {
            $this->addSection(null, $row->section);
        }

        $this->rows->put($row_index, $row);
    }

    public function addSection($section = null, $section_index = 0) {

        if (!$section instanceof Section) {
            $section = new Section($section);
        }

        $this->sections->put($section_index, $section);
    }

    public function preBuild() {


        if ($this->columns->isNotEmpty()) {
            $this->output->columns = $this->columns->groupBy(function ($item, $key) {
                if (!$this->rows->has($item->row)) {
                    $this->addRow(null, $item->row);
                }
                return $item->row;
            }, true);
        }

        if ($this->rows->isNotEmpty()) {
            $this->output->rows = $this->rows->groupBy(function ($item, $key) {
                if (!$this->sections->has($item->section)) {
                    $this->addSection(null, $item->section);
                }

                if ($this->output->columns instanceof Collection && $this->output->columns->has($key)) {
                    $item->columns = $this->output->columns->get($key);
                }
                return $item->section;
            });
        }
        if (!($this->output->sections instanceof Collection)) {
            $this->output->sections = new Collection($this->output->sections);
        }
        if ($this->sections->isNotEmpty()) {
            $this->sections->each(function ($item, $key) {

                if ($this->output->rows instanceof Collection && $this->output->rows->has($key)) {
                    $item->rows = $this->output->rows->get($key);
                    $this->output->sections->put($key, $item);
                }
            });
        }
    }


    public function __toString() {
        $output = '';
        $this->preBuild();
        foreach ($this->sections->all() as $key => $section) {
            $output .= $section->__toString();
        }
        return $output;
    }
}
