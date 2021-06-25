<?php

/** ============================================================================
 * RWP Button
 *
 * @package RWP\Components\Button
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

class Button extends Html {
    public $order = ['before', 'text',  'after'];

    public $link, $target, $toggle;

    public $atts = [
        'tag' => 'a',
        'class' => [
            'btn',
        ]
    ];

    public $text;

    public $icon = [
        'order' => ['icon-opened', 'icon-closed', 'content'],
        'atts' => [
            'tag' => 'span',
            'class' => [
                'btn-icon'
            ]
        ]
    ];

    public $icon_opened = [
        'atts' => [
            'tag' => 'span',
            'class' => [
                'btn-icon-opened'
            ],
        ]
    ];

    public $icon_closed = [
        'atts' => [
            'tag' => 'span',
            'class' => [
                'btn-icon-closed'
            ],
        ]
    ];

    /**
     * @var bool $active Whether or not the item is currently active
     */
    public $active = false;

    /**
     * @var bool $disabled Whether or not the item is currently disabled
     */
    public $disabled = false;

    public function __construct($args = []) {


        parent::__construct($args);

        $this->text = self::text($this->text);
        $this->icon = rwp_icon($this->icon);
    }


    public function setupIcon() {
        if (!($this->icon instanceof Html)) {
            $this->icon = rwp_icon($this->icon);
        }

        if ($this->icon->hasArg('bars') && !$this->icon->hasContent()) {
            $this->icon->addContent(self::toggleBars($this->icon->bars));
        }


        if ($this->icon->hasContent()) {
            if ($this->text->hasContent()) {
                if ($this->icon->hasClass('icon-left')) {
                    $this->order = ['before', 'icon', 'text', 'after'];
                } else {
                    $this->order = ['before', 'text', 'icon', 'after'];
                    $this->icon->addClass('icon-right');
                }
            } else {
                $this->order = ['before', 'icon', 'after'];
            }
        }
    }

    public function preBuild() {
        if (!empty($this->target) || !empty($this->toggle)) {
            $this->toggleAtts();
        }

        if ($this->disabled) {
            $this->addClass('disabled');
            $this->setAttr('aria-disabled', 'true');
            $this->setAttr('tabindex', '-1');
        }

        if ($this->active) {
            $this->addClass('active');
        }
        $this->addContent($this->text, 'text');
        $this->setupIcon();
    }

    public function toggleAtts() {
        $target = $this->unprefix($this->target, '#');
        $prefixed_target = $this->prefix($this->target, '#');
        if (!rwp_is_url($target)) {
            if (!$this->hasAttr('id')) {
                $this->setAttr('id', $target . '-btn');
            }
            //$target = "#$target";
        }

        $this->addClass('btn-toggle');
        $this->setAttr('tag', 'button');


        switch ($this->toggle) {
            case 'dropdown':
                $this->setAttr('data-toggle', $this->toggle);
                $this->setAttr('aria-haspopup', 'true');
                if (!$this->hasAttr('aria-expanded')) {
                    $this->setAttr('aria-expanded', 'false');
                }
                $this->addClass('dropdown-toggle');

                break;
            case 'tab':
                $this->setAttr('data-toggle', $this->toggle);
                $this->setAttr('href', $prefixed_target);
                $this->setAttr('aria-controls', $target);
                $this->setAttr('role', 'tab');
                $this->setAttr('data-target', $prefixed_target);
                $this->addClass('tab-toggle');
                if (!$this->hasAttr('aria-selected')) {
                    $this->setAttr('aria-selected', 'false');
                }

                break;
            case 'pill':
                $this->setAttr('aria-controls', $target);
                $this->setAttr('role', 'tab');
                $this->setAttr('data-target', $prefixed_target);
                $this->addClass('tab-toggle');
                if (!$this->hasAttr('aria-selected')) {
                    $this->setAttr('aria-selected', 'false');
                }
                break;
            case 'collapse':
                $this->setAttr('data-toggle', $this->toggle);
                $this->setAttr('data-target', $prefixed_target);
                $this->setAttr('aria-controls', $target);
                if (!$this->hasAttr('aria-expanded')) {
                    $this->setAttr('aria-expanded', 'false');
                }
                break;
            case 'modal':
                $this->setAttr('data-fancybox', '');
                $this->setAttr('data-src', $prefixed_target);
                $this->setAttr('data-modal', 'true');
                break;
            case 'close':
                $this->setAttr('data-fancybox-close', 'modal');
                $this->addClass('close');
                $this->setAttr('aria-label', __('Close', 'rwp'));
                break;
        }

        if ($this->toggle !== 'dropdown' && $this->toggle !== 'close' && !$this->icon->hasContent()) {
            if (!($this->icon_opened instanceof Html)) {
                if (empty($this->icon_opened['content'])) {
                    if (rwp_array_has('atts', $this->icon_opened) && rwp_array_has('tag', $this->icon_opened['atts']) && $this->icon_opened['atts']['tag'] !== 'i') {
                        $this->icon_opened['content'] = ['&minus;'];
                        $this->icon_opened['atts']['tag'] = 'span';
                    }
                }

                $this->icon_opened = rwp_icon($this->icon_opened);
            }
            if ($this->icon_opened instanceof Html) {
                if ($this->icon_opened->content->isEmpty() && $this->icon_opened->getAttr('tag') !== 'i') {
                    $this->icon_opened->addContent('&minus;');
                    $this->icon_opened->setAttr('tag', 'span');
                }
            }

            $this->icon->addContent($this->icon_opened, 'icon_opened');

            if (!($this->icon_closed instanceof Html)) {
                if (rwp_array_has('atts', $this->icon_closed) && rwp_array_has('tag', $this->icon_closed['atts']) && $this->icon_closed['atts']['tag'] !== 'i') {
                    $this->icon_closed['content'] = ['&plus;'];
                    $this->icon_closed['atts']['tag'] = 'span';
                }

                $this->icon_closed = rwp_icon($this->icon_closed);
            }
            if ($this->icon_closed instanceof Html) {
                if ($this->icon_closed->content->isEmpty() && $this->icon_closed->getAttr('tag') !== 'i') {
                    $this->icon_closed->addContent('&plus;');
                    $this->icon_closed->setAttr('tag', 'span');
                }
            }

            $this->icon->addContent($this->icon_closed, 'icon_closed');
        }
        $this->setupIcon();
    }

    public static function toggleBars($bars = 3) {

        $content = '';
        if ($bars >= 1) {
            for ($i = 0; $i < $bars; $i++) {
                $bar_num = $i + 1;
                $bar = new Html([
                    'atts' => [
                        'tag'   => 'span',
                        'class' => [
                            'toggle-bar',
                            'bar-' . $bar_num
                        ]
                    ]
                ]);
                $content .= $bar->__toString();
            }
        }
        return $content;
    }

    /**
     * Wrapper for button text.
     *
     * @param string|array $args Item arguments
     * ```
     * $args = [
     *   'content' => [], // @param string|array|Collection $content The inner content of the element.
     *   'atts'    => [ // @param array|Collection $atts The attributes to apply to the element (including the html tag).
     *      'tag' => 'span', // Default tag
     *    ],
     *   'screen_reader' => false // @param bool $screen_reader Is the content for screen readers?
     * ];
     *```
     *
     * @uses self::parseArgs
     * @uses self::make
     *
     * @return Html The html class instance
     */

    public static function text($args = []) {

        if (is_string($args)) {
            $args = [
                'content' => $args
            ];
        }
        $atts = [
            'atts' => [
                'tag' => 'span',
                'class' => [
                    'btn-text'
                ]
            ],
            'screen_reader' => false
        ];
        $atts = rwp_merge_args($atts, $args);
        $text = self::make($atts);
        if ($atts['screen_reader']) {
            $text->addClass('sr-only');
        }
        return $text;
    }

    public static function buttonGroup($args = []) {

        $defaults = [
            'spacing' => true,
        ];

        $args = rwp_merge_args($defaults, $args);

        foreach ($args['items'] as $i => $button) {

            if (is_object($button)) {
                $button = $button->__toString();
            }
            if ($args['spacing']) {
                unset($args['items'][$i]);
                $args['items'][]['content'] = $button;
            } else {
                $args['content'][] = $button;
            }
        }

        if ($args['spacing']) {
            $args['inline'] = true;
            $button_group = new HtmlList($args);
            $button_group->inline = true;
        } else {
            $button_group = new Html($args);
            $button_group->addAttr('tag', 'div');
            $button_group->addClass('btn-group');
            $button_group->addAttr('role', 'group');
        }

        return $button_group;
    }
}
