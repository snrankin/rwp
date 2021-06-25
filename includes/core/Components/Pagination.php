<?php

/** ============================================================================
 * RWP Pagination
 *
 * @package RWP\Components\Pagination
 * @since   0.1.0
 * ========================================================================== */


namespace RWP\Components;

use RWP\Components\{Nav, NavItem};

class Pagination extends Nav {

    public $direction = 'horizontal';

    public $query  = null;

    public $count = 6;

    public $type = 'archive';

    public $ajax = false;

    public $ajax_target = null;

    /**
     * @var array|NavItem $prev The previous link (previous page or previous post)
     * @link https://developer.wordpress.org/reference/functions/get_previous_post/
     */

    public $prev = [
        'in_same_term' => false,
        'excluded_terms' => '',
        'taxonomy' => 'category',

        'link' => [
            'atts' => [
                'rel' => 'prev'
            ],
            'text' => [
                'content' => 'Previous',
            ],
        ],
        'atts' => [
            'class' => 'prev'
        ]
    ];

    /**
     * @var array|NavItem $next The next link (next page or next post)
     * @link https://developer.wordpress.org/reference/functions/get_next_post/
     */

    public $next = [
        'in_same_term' => false,
        'excluded_terms' => '',
        'taxonomy' => 'category',

        'link' => [
            'atts' => [
                'rel' => 'next'
            ],
            'text' => [
                'content' => 'Next',
            ],
        ],
        'atts' => [
            'class' => 'next'
        ]
    ];

    public $current = [
        'link' => [
            'atts' => [
                'aria-current' => 'page'
            ]
        ],
        'atts' => [
            'class' => 'current'
        ]
    ];

    public $items = [];

    public $list = [
        'atts' => [
            'class' => [
                'pagination'
            ]
        ]
    ];

    public $atts = [
        'tag'   => 'nav',
        'class' => [
            'pagination-wrapper',
        ],
        'role' => 'navigation'
    ];

    public $item_atts = [
        'tag'       => 'li',
        'itemscope' => '',
        'itemtype'  => '',
        'role'      => '',
        'class'     => [
            'page-item',
        ]
    ];

    /**
     * @var array|Html $link The link item attributes
     */
    public $link_atts = [
        'atts' => [
            'tag' => 'a',
            'class' => [
                'page-link'
            ]
        ],
        'text' => [
            'atts' => [
                'tag' => 'span',
                'class' => [
                    'page-text'
                ]
            ],
        ]
    ];

    public function __construct($args = []) {

        $type = rwp_array_has('type', $args) ? $args['type'] : $this->type;

        if (empty($this->id) && !rwp_array_has('id', $args)) {
            $this->id = rwp_item_type() . '-' . $type . '-pagination';
        }

        if (!$this->hasAttr('id')) {
            $this->addAttr('id', rwp_item_type() . '-' . $type . '-pagination');
        }

        if ($this->hasAttr('id') && !$this->hasAttr('aria-label')) {
            $nav_id = $this->getAttr('id');
            $this->setAttr('aria-label', rwp_change_case($nav_id, 'title'));
        }

        parent::__construct($args);

        if ($this->ajax && empty($this->ajax_target)) {
            $this->ajax = false;
        } elseif ($this->ajax && !empty($this->ajax_target)) {
            $this->addAttr('data-target', $this->ajax_target);
        }



        if (empty($this->query)) {
            global $wp_query;
            $this->query = $wp_query;
        }

        if ($this->type === 'archive') {
            $this->archivePagination();
        } else {
            $this->singlePagination();
        }
    }

    public function archivePagination() {

        $wp_query = $this->query;

        $total = ($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        $current = ($wp_query->query_vars['paged']) ? $wp_query->query_vars['paged'] : 1;

        $query = $wp_query->query;

        if (!isset($query['post_type']) || empty($query['post_type'])) {
            $query['post_type'] = $wp_query->query_vars['post_type'];
        }

        if (is_array($wp_query->query_vars['post_type'])) {
            $post_type = reset($wp_query->query_vars['post_type']);
        } else {
            $post_type = $wp_query->query_vars['post_type'];
        }

        if (is_search()) {
            $post_type = 'search';
        }


        if (empty($post_type)) {
            $post_type = rwp_item_type();
        }


        $count = $this->count;

        $items = [];

        $item = [];

        // -------------------------------- Previous -------------------------------- //

        $prev_args = $this->prev;
        $prev_index = $current - 1;

        $prev = [
            'link' => [
                'atts' => [
                    'href' => rwp_relative_url(get_pagenum_link($prev_index, false)),
                    'aria-label' => wp_sprintf('%s %d', __('Go to page', 'rwp'), $prev_index),
                    'title' => wp_sprintf('%s %d', __('Go to page', 'rwp'), $prev_index)
                ]
            ]
        ];

        if ($prev_index == 0) {
            $prev['disabled'] = true;
        }

        $prev = rwp_merge_args($prev, $prev_args);

        $items[] = $prev;


        // --------------------------------- Current -------------------------------- //

        $current_item = $this->current;
        if ($count == 3) {
            if (!rwp_array_has('disabled', $current_item)) {
                $current_item['disabled'] = true;
            }

            if (!rwp_array_has('text', $current_item['link'])) {
                $current_item['link']['text'] = [];
            }

            if (!rwp_array_has('content', $current_item['link']['text'])) {
                $current_item['link']['text']['content'] = wp_sprintf('Page %1$d of %2$d', $current, $total);
            }

            $items[] = $current_item;
        } else if ($count > 3) {
            if (!rwp_array_has('active', $current_item)) {
                $current_item['active'] = true;
            }


            if (!rwp_array_has('text', $current_item['link'])) {
                $current_item['link']['text'] = [];
            }

            if (!rwp_array_has('content', $current_item['link']['text'])) {
                $current_item['link']['text']['content'] = wp_sprintf('<span class="sr-only">Current Page, Page </span>%d', $current);
            }

            if (!rwp_array_has('href', $current_item['link']['atts'])) {
                $current_item['link']['atts'] = get_pagenum_link($current, false);
            }

            $items[] = $current_item;
        }


        // ------------------------------- Next Pages ------------------------------- //

        if ($count > 3) {
            for ($i = 1; $i < $count; $i++) {
                $page = $current + $i;
                $item = [

                    'link' => [
                        'text' => [
                            'content' => $page,
                        ],
                        'atts' => [
                            'href' => rwp_relative_url(get_pagenum_link($page, false)),
                            'aria-label' => wp_sprintf('Page %1$d of %2$d', $page, $total)
                        ]
                    ]
                ];
                if ($page <= $total) {
                    $items[] = $item;
                }
            }
        }


        // ---------------------------------- Next ---------------------------------- //


        $next_args = $this->next;
        $next_index = $current + 1;

        $next = [
            'link' => [
                'atts' => [
                    'href' => rwp_relative_url(get_pagenum_link($next_index, false)),
                    'aria-label' => wp_sprintf('%s %d', __('Go to page', 'rwp'), $next_index),
                    'title' => wp_sprintf('%s %d', __('Go to page', 'rwp'), $next_index)
                ]
            ]
        ];

        $next = rwp_merge_args($next, $next_args);

        if ($current == $total) {
            $next['disabled'] = true;
        }

        $items[] = $next;

        if (!empty($items)) {
            foreach ($items as $item) {
                $item = rwp_nav_item($item);
                $item->link->removeClass('nav-link');
                $item->removeClass('nav-item');
                $this->addItem($item);
            }
        }
    }

    public function singlePagination() {

        $items = [];

        // -------------------------------- Previous -------------------------------- //

        if (!rwp_array_has('in_same_term', $this->prev)) {
            $this->prev['in_same_term'] = false;
        }

        if (!rwp_array_has('excluded_terms', $this->prev)) {
            $this->prev['excluded_terms'] = null;
        }

        if (!rwp_array_has('taxonomy', $this->prev)) {
            $this->prev['taxonomy'] = 'category';
        }

        $prev_post = get_previous_post($this->prev['in_same_term'], $this->prev['excluded_terms'], $this->prev['taxonomy']);


        if (!empty($prev_post)) {
            $this->prev['link']['atts']['aria-label'] = __('View Next: ' . rwp_title($prev_post->ID));
            $this->prev['link']['atts']['title'] = rwp_title($prev_post->ID);
            $this->prev['link']['atts']['href'] = rwp_relative_url(get_permalink($prev_post->ID));
        } else {
            $this->prev['disabled'] = true;
        }

        $items[] = $this->prev;


        // ---------------------------------- Next ---------------------------------- //

        if (!rwp_array_has('in_same_term', $this->next)) {
            $this->next['in_same_term'] = false;
        }

        if (!rwp_array_has('excluded_terms', $this->next)) {
            $this->next['excluded_terms'] = null;
        }

        if (!rwp_array_has('taxonomy', $this->next)) {
            $this->next['taxonomy'] = 'category';
        }
        $next_post = get_next_post($this->next['in_same_term'], $this->next['excluded_terms'], $this->next['taxonomy']);

        if (!empty($next_post)) {
            $this->next['link']['atts']['aria-label'] = __('View Next: ' . rwp_title($next_post->ID));
            $this->next['link']['atts']['title'] = rwp_title($next_post->ID);
            $this->next['link']['atts']['href'] = rwp_relative_url(get_permalink($next_post->ID));
        } else {
            $this->next['disabled'] = true;
        }

        $items[] = $this->next;

        if (!empty($items)) {
            foreach ($items as $item) {
                $item = new NavItem($item);
                $item->addClass('page-link');
                $item->preBuild();
                $this->addItem($item);
            }
        }
    }

    public function __toString() {
        if ($this->query->max_num_pages > 1 && $this->type === 'archive') {
            $this->preBuild();
            return $this->build();
        } elseif ($this->type === 'singular') {
            $this->preBuild();
            return $this->build();
        } else {
            return false;
        }
    }
}
