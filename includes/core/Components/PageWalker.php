<?php

/** ============================================================================
 * RWP PageWalker
 *
 * @package    RWP\Components\PageWalker
 * @since      0.1.0
 * @see        Walker_Page
 * @link       https://developer.wordpress.org/reference/classes/walker_nav_menu/
 *
 * @inheritDoc
 * ========================================================================== */


namespace RWP\Components;


use RWP\Components\{Nav, NavItem};

class PageWalker extends \Walker_Page {
    private $cpt; // Boolean, is current post a custom post type
    private $archive; // Stores the archive page for current URL
    private $ancestors;
    public function __construct() {
        add_filter('page_css_class', array($this, 'cssClasses'), 20, 5);
        $cpt           = get_post_type();
        $this->cpt     = in_array($cpt, get_post_types(array('_builtin' => false)));
        $this->archive = get_post_type_archive_link($cpt);
    }

    public function cssClasses($classes, $page, $depth, $args, $current_page) {
        $slug = $page->post_name;
        $_current_page = get_post();
        if (!empty($_current_page)) {
            // if (empty($this->ancestors)) {
            //     $ancestors = rwp_ancestors($_current_page);
            //     $ancestors = $ancestors->transform(function ($item) {
            //         if (!is_numeric($item)) {
            //             return rwp_id($item);
            //         } else {
            //             return $item;
            //         }
            //     });
            //     $ancestors = $ancestors->all();
            // }
        }

        $url = parse_url(get_permalink());
        $url = explode('/', $url['path']);

        if (array_search($slug, $url)) {
            $classes[] = 'active';
        }


        $level = $depth + 1;

        $classes[] = "level-$level-menu-item";

        // Fix core `active` behavior for custom post types
        if ($this->cpt) {
            if ($this->archive) {
                if (rwp_url_compare($this->archive, get_permalink())) {
                    $classes[] = 'active';
                }
            }
        }

        if (is_search() || is_404()) {
            $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', '', $classes);
        }

        // Remove most core classes
        $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
        $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

        // Re-add core `menu-item` class
        $classes[] = 'menu-item';

        if (isset($args['pages_with_children'][$page->ID])) {
            $classes[] = 'has-children';
        }

        // Add `menu-<slug>` class
        $classes[] = 'menu-' . $slug;

        $classes = array_unique($classes);
        $classes = array_map('trim', $classes);

        return array_filter($classes);
    }

    public static function checkCurrent($classes) {
        if (is_string($classes)) {
            return preg_match('/(current[-_])|active/', $classes);
        }
        if (is_array($classes)) {
            return preg_grep('/(current[-_])|active/', $classes);
        }
    }


    /**
     * Starts the list before the elements are added.
     *
     * @see  Walker_Page::start_lvl()
     * @link https://developer.wordpress.org/reference/classes/walker_page/start_lvl/
     *
     * @inheritDoc
     */
    public function start_lvl(&$output, $depth = 0, $args = []) {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $output .= $indent;

        $id = sanitize_html_class($this->nav_item->children);

        $sub_menu_args = [
            'depth'      => $depth + 1,
            'parent'     => $this->nav_item->parent,
            'child_type' => $this->nav_item->child_type,
            'id'         => $this->nav_item->children
        ];

        $sub_menu = new Nav($sub_menu_args);

        $this->sub_menu = $sub_menu;

        $nav_output = $sub_menu->navStartTag();

        $output .= $nav_output;
    }

    /**
     * Ends the list after the elements are added.
     *
     * @see  Walker_Page::end_lvl()
     * @link https://developer.wordpress.org/reference/classes/walker_page/end_lvl/
     *
     * @inheritDoc
     */

    public function end_lvl(&$output, $depth = 0, $args = []) {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $indent  = str_repeat($t, $depth);

        $output .= $indent;
        $output .= $this->sub_menu->navEndTag();
    }

    /**
     * Starts the element output.
     *
     * @see  Walker_Page::start_el()
     * @link https://developer.wordpress.org/reference/classes/walker_page/start_el/
     *
     * @inheritDoc
     */
    public function start_el(&$output, $page, $depth = 0, $args = [], $current_page = 0) {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        $output .= $n . $indent;
        $css_class = array('page_item', 'page-item-' . $page->ID);


        $css_class = apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page);

        $link_atts = [
            'href'         => rwp_relative_url(get_permalink($page->ID)),
            'aria-current' => ($page->ID == $current_page) ? 'page' : '',
        ];

        $link_atts = apply_filters('page_menu_link_attributes', $link_atts, $page, $depth, $args, $current_page);

        if ($link_atts['href'] === home_url('/')) {
            $link_atts['rel'] = 'home';
            $link_atts['itemprop'] = 'url';
        }



        $nav_item = [
            'nav_item'   => $page,
            'depth'      => $depth,
            'parent'     => rwp_array_has('menu_parent', $args) ? $args['menu_parent'] : '#menu-item-page-' . $page->post_parent,
            'children'   => isset($args['pages_with_children'][$page->ID]) ? "#submenu-" . $page->ID : null,
            'child_type' => rwp_array_has('child_type', $args) ? $args['child_type'] : 'collapse',
            'toggle'     => rwp_array_has('toggle', $args) ? $args['toggle'] :  [],
            'link'       => [
                'atts' => $link_atts,
                'text'       => [
                    'content' => rwp_title($page),
                ],
                'active' => self::checkCurrent($css_class),
            ],
            'content' => [
                'before' => $args['link_before'],
                'after'  => $args['link_after'],
            ],
            'atts' => [
                'id'    => 'menu-item-page-' . $page->ID,
                'class' => $css_class
            ]
        ];


        if (rwp_array_has('child_type', $args) && $args['child_type'] === 'tab') {
            $children = get_pages(['child_of' => $page->ID, 'parent' => $page->ID]);
            if (!empty($children)) {
                $nav_item['children']   =  "submenu-" . $page->ID . '-wrapper';
                $nav_item['toggle']['atts']['tag'] = 'a';
                $nav_item['toggle']['toggle'] = 'tab';
                $nav_item['toggle']['target'] = "submenu-" . $page->ID . '-wrapper';
                $nav_item['toggle']['text']['content'] = __("Toggle $page->post_title subnav", 'rwp');
                $nav_item['toggle']['text']['screen_reader'] = true;
                $nav_item['toggle']['atts']['class'][] = 'nav-item-toggle';
            }
        } else {
            if (isset($args['pages_with_children'][$page->ID])) {
                $nav_item['children']   =  "submenu-" . $page->ID;
                $nav_item['toggle']['toggle'] = rwp_array_has('child_type', $args) ? $args['child_type'] : 'collapse';
                $nav_item['toggle']['target'] = "submenu-" . $page->ID . '-wrapper';
                $nav_item['toggle']['text']['content'] = __("Toggle $page->post_title subnav", 'rwp');
                $nav_item['toggle']['text']['screen_reader'] = true;
                $nav_item['toggle']['atts']['class'][] = 'nav-item-toggle';
            }
        }

        /**
         * This is the end of the internal nav item. We need to close the
         * correct element depending on the type of link or link mod.
         */

        $nav_item = new NavItem($nav_item);
        $nav_item->preBuild();
        $this->nav_item = $nav_item;
        $item_output = $nav_item->buildContent($nav_item);
        // END appending the internal item contents to the output.
        $output .= $nav_item->startTag() . $item_output;
    }
}
