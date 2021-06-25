<?php

/** ============================================================================
 * RWP Form
 *
 * @package RWP\Components\Form
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

class Form extends Html {
    public $atts = [
        'tag' => 'form',
    ];

    public $inputs = [];
    public $inline = false;
    public $submit = [
        'atts'    => [
            'tag' => 'button',

        ],
        'row' => 'footer'
    ];


    public $grid = [
        'rows' => [
            'header' => [
                'atts' => [
                    'class' => [
                        'form-header'
                    ]
                ],
                'remove_wrapper' => true
            ],
            'body' => [
                'atts' => [
                    'class' => [
                        'form-body'
                    ]
                ],
                'remove_wrapper' => true
            ],
            'footer' => [
                'atts' => [
                    'tag' => 'footer',
                    'class' => [
                        'form-footer'
                    ]
                ],
                'remove_wrapper' => true
            ]
        ]
    ];

    public function __construct($args = []) {

        parent::__construct($args);

        $this->inputs = new Collection($this->inputs);
        if (!empty($this->submit)) {
            if (is_array($this->submit)) {
                $this->submit = new Button($this->submit);
            }
        }

        if ($this->inputs->isNotEmpty()) {
            $this->inputs = $this->inputs->mapInto(__NAMESPACE__ . '\\Field');
        }

        $this->grid = rwp_grid($this->grid);
    }

    public function addInput($input, $i = null) {
        if (!($input instanceof Field)) {
            $input = new Field($input);
        }
        $this->inputs->put($i, $input);
    }

    public function preBuild() {
        if ($this->inputs->isEmpty()) return;

        if ($this->inline) {
            $this->addClass('form-inline');
        }


        foreach ($this->inputs->all() as $input) {
            $input = (!is_string($input)) ? $input->__toString() : $input;
            if (!$this->inline) {
                $this->grid->addCol([
                    'row' => $input->row,
                    'content' => [
                        'content' => $input,
                    ]
                ]);
            } else {
                $this->addContent($input);
            }
        }

        if (!$this->inline) {
            $submit = $this->submit->__toString();

            $this->grid->addCol([
                'row' => 'footer',
                'content' => [
                    'content' => $submit
                ]
            ]);


            $this->addContent($this->grid);
        } else {

            $this->addContent($this->submit);
        }
    }
}
