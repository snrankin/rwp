<?php

/** ============================================================================
 * RWP Field
 *
 * @package    RWP\Components\Field
 * @since      0.1.0
 * @inheritDoc \RWP\Components\Html
 * ========================================================================== */

namespace RWP\Components;

class Field extends Html {

    public $type;
    public $order = ['before', 'label', 'input', 'description', 'feedback', 'after'];
    public $atts = [
        'tag' => 'div',
        'class' => [
            'form-group'
        ]
    ];
    public $input = [
        'atts'    => [
            'tag' => 'input',
        ],
    ];
    public $group = [
        'order' => ['prepend', 'input', 'append'],
        'atts' => [
            'tag' => 'div',
            'class' => [
                'input-group',
            ],
        ]
    ];
    public $prepend = [
        'atts' => [
            'tag' => 'span',
            'class' => [
                'input-group-prepend'
            ]
        ]
    ];
    public $append = [
        'atts' => [
            'tag' => 'span',
            'class' => [
                'input-group-append'
            ]
        ]
    ];
    public $label = [
        'atts' => [
            'for' => '',
            'tag' => 'label'
        ]
    ];
    public $options = [];
    public $description = [
        'atts' => [
            'tag' => 'small',
            'class' => [
                'form-text text-muted'
            ]
        ]
    ];

    public $feedback = [];

    public $col = 0;

    public $row = 'body';

    public $index = null;

    public function __construct($args = []) {

        parent::__construct($args);
        $this->options     = rwp_collection($this->options);
        $this->input       = rwp_html($this->input);
        $this->group       = rwp_html($this->group);
        $this->label       = rwp_text($this->label);
        $this->prepend     = rwp_html($this->prepend);
        $this->append      = rwp_html($this->append);
        $this->description = rwp_html($this->description);

        if (!empty($this->feedback)) {
            $this->feedback = rwp_html($this->feedback);
        }

        $this->setupInput();
    }

    public function setupInput() {
        $type = $this->type;

        if ($this->options->isNotEmpty()) {
            foreach ($this->options->all() as $i => $option) {
                if (!is_array($option)) {
                    if (wp_is_numeric_array($this->options->all())) {
                        $option_value = $option;
                    } else {
                        $option_value = $i;
                    }
                    $option_tag = $this->type === 'select' ? 'option' : 'input';
                    $option = [
                        'input' => [
                            'content' => $option,
                            'atts' => [
                                'tag' => $option_tag,
                                'value' => $option_value,
                            ]
                        ]
                    ];
                }
                $option = new self($option);
                $option->preBuild();
                if ($option->input->getAttr('tag') === 'option') {
                    $option = $option->buildContent();
                }
                $this->input->addContent($option, $i);
            }

            $type = 'group';
        } elseif (empty($type)) {
            if ($this->input->hasAttr('type')) {
                $type = $this->input->getAttr('type');
            } else {
                $type = $this->input->getAttr('tag');
            }
        }

        if ($this->input->getAttr('tag') === 'select') {
            $type = 'select';
        }

        switch ($type) {
            case 'textarea':

                $this->input->setAttr('tag', $type);
                $this->input->addClass('form-control');

                break;

            case 'select':

                $this->input->setAttr('tag', $type);
                $this->input->addClass('custom-' . $type);
                //$this->input->addClass('select2');

                break;

            case 'file':
                $this->addClass("custom-$type");
                $this->input->addClass("custom-$type-input");
                $this->label->addClass("custom-$type-label");

                break;

            case 'range':
                $this->input->addClass('custom-' . $type);

                break;

            case 'switch':
                $this->input->addClass('custom-' . $type);
                $this->input->setAttr('type', 'checkbox');
                break;

            case 'radio':
            case 'checkbox':
                $this->order = ['before', 'group', 'input', 'label', 'description', 'feedback', 'after'];
                $this->addClasses(["custom-$type", 'form-choices', 'custom-control']);
                $this->input->setAttr('type', $type);
                $this->input->addClass("custom-control-input");
                $this->label->addClass("custom-control-label");

                break;

            case 'date':
            case 'datetime-local':
            case 'month':
            case 'week':
                $this->input->setAttr('type', $type);
                $this->input->addClass('form-control');
                $this->input->removeClass('datepicker');
                break;
            case 'date':
            case 'datetime-local':
            case 'email':
            case 'month':
            case 'number':
            case 'password':
            case 'search':
            case 'tel':
            case 'text':
            case 'time':
            case 'url':
            case 'week':
                $this->input->setAttr('type', $type);
                $this->input->addClass('form-control');

                break;
        }

        if (!$this->input->hasAttr('type')) {
            $this->input->setAttr('type', $type);
        }

        if ($this->prepend->hasContent()) {
            $this->prepend->content->transform(function ($item) {
                if (is_string($item)) {

                    if (strpos($item, 'input-group-text') === false) {
                        $content = rwp_text([
                            'content' => $item,
                            'atts' => [
                                'tag' => 'span',
                                'class' => [
                                    'input-group-text'
                                ]
                            ]
                        ]);
                        $item = $content->__toString();
                    }
                } elseif (is_object($item)) {
                    $item = $item->__toString();
                } elseif (is_array($item)) {
                    $item = new Html($item);

                    $item = $item->__toString();
                }
                return $item;
            });
        }
        if ($this->append->hasContent()) {
            $this->append->content->transform(function ($item) {
                if (is_string($item)) {

                    if (strpos($item, 'input-group-text') === false && strpos($item, 'btn') === false) {
                        $content = rwp_text([
                            'content' => $item,
                            'atts' => [
                                'tag' => 'span',
                                'class' => [
                                    'input-group-text'
                                ]
                            ]
                        ]);
                        $item = $content->__toString();
                    }
                } elseif (is_object($item)) {
                    $item = $item->__toString();
                } elseif (is_array($item)) {
                    $item = new Html($item);
                    $item = $item->__toString();
                }
                return $item;
            });
        }
        if (!$this->label->hasAttr('for') && $this->input->hasAttr('id')) {
            $this->label->setAttr('for', $this->input->getAttr('id'));
        }
        if ($this->prepend->hasContent() || $this->append->hasContent()) {
            $this->group->input = $this->input;
            $this->group->prepend = $this->prepend;
            $this->group->append = $this->append;
            $this->order = preg_replace('/input/', 'group', $this->order);
        }
    }

    public function __toString() {
        $this->preBuild();
        return $this->build();
    }

    public static function progress_bar($args = []) {
        $defaults = [
            'now' => '',
            'min' => '',
            'max' => '',
            'label' => [
                'atts' => [
                    'tag' => 'span',
                    'class' => [
                        'progress-bar-label'
                    ]
                ]
            ],
            'bar' => [
                'atts' => [
                    'tag' => 'div',
                    'role' => 'progressbar',
                    'class' => [
                        'progress-bar'
                    ]
                ]
            ],
            'atts' => [
                'tag' => 'div',
                'class' => [
                    'progress'
                ]
            ]
        ];
        $args = rwp_merge_args($defaults, $args);
        $progress = rwp_html($args);

        $bar = rwp_html($args['bar']);
        $min = rwp_array_has('min', $args) ? $args['min'] : null;
        $max = rwp_array_has('max', $args) ? $args['max'] : null;
        $now = rwp_array_has('now', $args) ? $args['now'] : null;

        if (!empty($min)) {
            $bar->setAttr('aria-valuemin', $min);
        }
        if (!empty($max)) {
            $bar->setAttr('aria-valuemax', $max);
        }

        if (empty($min) && empty($max)) {
            $bar->setAttr('aria-valuemax', $max);
        }

        if (!empty($now)) {
            if (!empty($max)) {
                $width = intval($now) / intval($max) * 100;
                $bar->addStyle('width', "$width%");
            }
            $bar->setAttr('aria-valuenow', $now);
        }

        $label = rwp_text($args['label']);
        $bar->addContent($label);

        $progress->addContent($bar);

        return $progress;
    }
}
