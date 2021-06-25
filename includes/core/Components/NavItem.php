<?php

/** ============================================================================
 * RWP NavItem
 *
 * Generate navigational item html
 *
 * @package RWP\Components\NavItem
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Components\{Html, Button};

class NavItem extends Html {

    public $order = ['before', 'link', 'after'];

    /**
     * @var Wordpress\WP_Post $nav_item The associated WordPress nav item
     */
    public $nav_item;

    /**
     * @var string|Wordpress\WP_Term $menu The menu (or sub-menu) to which the item belongs
     */
    public $menu;

    /**
     * @var array|Html $toggle The toggle button attributes (if there is a submenu)
     */
    public $toggle;

    /**
     * @var string $children Item child menu css id
     */
    public $children;

    /**
     * @var string $child_type Item child menu dropdown type
     */

    public $child_type = 'collapse';


    /**
     * @var int $depth The depth or level of the menu-item
     */
    public $depth = 0;

    /**
     * @var bool $disabled Is item disabled?
     */
    public $disabled = false;

    /**
     * @var bool $active Is item active?
     */
    public $active = false;

    /**
     * @var array|Html $link The link item attributes
     */
    public $link = [
        'atts' => [
            'tag' => 'a',
            'class' => [
                'nav-link'
            ]
        ],
        'text' => [
            'atts' => [
                'tag' => 'span',
                'class' => [
                    'nav-text'
                ]
            ],
        ]
    ];

    /**
     * @var array|Html $list_atts The list item attributes
     */
    public $atts = [
        'tag'       => 'li',
        'itemscope' => '',
        'itemtype'  => 'https://www.schema.org/SiteNavigationElement',
        'role'      => 'none',
        'class'     => [
            'nav-item',
        ]
    ];

    public function __construct($args = []) {

        parent::__construct($args);

        if (!empty($this->children)) {
            $this->order = ['before', 'link', 'toggle', 'after', 'submenu'];
            if ($this->child_type === 'dropdown' && $this->depth == 0) {
                $this->addClass('dropdown');
            }
        }


        $this->toggle = new Button($this->toggle);

        $this->link = new Button($this->link);
    }


    public function preBuild() {

        if ($this->disabled) {
            $this->addClass('disabled');
            $this->link->disabled = true;
        }

        if ($this->active) {
            $this->addClass('active');
            $this->link->active = true;
        }

        if (is_object($this->link)) {
            $this->link->removeClass('btn');
            $this->link->text->removeClass('btn-text');
            if ($this->link->hasAttr('href')) {
                $this->link->addAttr('role', 'menuitem');
            }
        }
    }

    public function removeNavAtts() {
        $this->removeAttr('itemtype');
        $this->removeAttr('itemscope');
        $this->removeAttr('role');
        $this->removeAttr('id');
        $this->link->removeAttr('href');
        $this->link->removeAttr('target');
        $this->link->removeAttr('rel');
        $this->link->removeAttr('title');
        $this->link->removeAttr('role');
    }
}
