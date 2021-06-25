<?php

/** ============================================================================
 * RWP CategoryWalker
 *
 * Adds Bootstrap 4 classes/structure to the category walker. Based on
 * https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 *
 * @package RWP\Components\CategoryWalker
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

use RWP\Components\{Nav, NavItem};


/**
 * Category Walker Class
 *
 * @see        Walker_Category
 * @link       https://developer.wordpress.org/reference/classes/walker_nav_menu/
 *
 * @inheritDoc
 */
class CategoryWalker extends \Walker_Category {

    private $cpt; // Boolean, is current post a custom post type
    private $archive; // Stores the archive page for current URL
    private $ancestors;

    public function __construct() {
        add_filter('category_css_class', array($this, 'cssClasses'), 20, 5);
        $cpt           = get_post_type();
        $this->cpt     = in_array($cpt, get_post_types(array('_builtin' => false)));
        $this->archive = get_post_type_archive_link($cpt);
    }

    public function cssClasses($classes, $term, $args, $depth = 0) {
        $slug = $term->slug;
        $_current_page = get_post();
        if (!empty($_current_page)) {
            if (empty($this->ancestors)) {
                $ancestors = rwp_ancestors($_current_page);
                // if ($ancestors) {
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
        }

        if (!empty($args['current_category'])) {
            // 'current_category' can be an array, so we use `get_terms()`.
            $_current_terms = get_terms(
                array(
                    'taxonomy'   => $term->taxonomy,
                    'include'    => $args['current_category'],
                    'hide_empty' => false,
                )
            );

            foreach ($_current_terms as $_current_term) {
                if ($term->term_id == $_current_term->term_id) {
                    $classes[] = 'current-term';
                } elseif ($term->term_id == $_current_term->parent) {
                    $classes[] = 'current-term-parent';
                }
                while ($_current_term->parent) {
                    if ($term->term_id == $_current_term->parent) {
                        $classes[] = 'current-term-ancestor';
                        break;
                    }
                    $_current_term = get_term($_current_term->parent, $term->taxonomy);
                }
            }
        }

        $url = parse_url(get_permalink());
        $url = explode('/', $url['path']);

        if (array_search($slug, $url)) {
            $classes[] = 'active';
        }


        // $level = $depth + 1;

        // $classes[] = "level-$level-menu-item";

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
     * @see  Walker_Category::start_lvl()
     * @link https://developer.wordpress.org/reference/classes/walker_category/start_lvl/
     *
     * @inheritDoc
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        if ('list' != $args['style']) {
            return;
        }

        $t = "\t";
        $n = "\n";
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $output .= $indent;

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
     * @see  Walker_Category::end_lvl()
     * @link https://developer.wordpress.org/reference/classes/walker_category/end_lvl/
     *
     * @inheritDoc
     */

    public function end_lvl(&$output, $depth = 0, $args = null) {
        if ('list' != $args['style']) {
            return;
        }
        $t = "\t";
        $n = "\n";
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $output .= $indent;
        $output .= $this->sub_menu->navEndTag();
    }

    /**
     * Starts the element output.
     *
     * @see  Walker_Category::start_el()
     * @link https://developer.wordpress.org/reference/classes/walker_category/start_el/
     *
     * @inheritDoc
     */
    public function start_el(&$output, $term, $depth = 0, $args = null, $id = 0) {
        if ('list' != $args['style']) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        if (isset($args['title_li']) && !empty($args['title_li'])) {
            $depth = $depth + 1;
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $title = apply_filters('list_cats', esc_attr($term->name), $term);

        // Don't generate an element if the category name is empty.
        if ('' === $title) {
            return;
        }

        $link_atts         = [];
        $link_atts['href'] =  rwp_relative_url(get_term_link($term));

        if (
            $args['use_desc_for_title'] && !empty($term->description)
        ) {
            /**
             * Filters the category description for display.
             */
            $link_atts['title'] = strip_tags(apply_filters('category_description', $term->description, $term));
        } else {
            $link_atts['title'] = strip_tags($title);
        }
        $link_atts['title'] = strip_tags($title);

        $classes = [
            $term->taxonomy . '-term',
        ];




        /**
         * Filters the list of CSS classes to include with each category in the list.
         *
         * @since 4.2.0
         *
         * @see wp_list_categories()
         *
         * @param array  $css_classes An array of CSS classes to be applied to each list item.
         * @param object $category    Category data object.
         * @param int    $depth       Depth of page, used for padding.
         * @param array  $args        An array of wp_list_categories() arguments.
         */

        $classes = apply_filters('category_css_class', $classes, $term, $args, $depth);

        // Allow filtering of the $atts array before using it.
        $link_atts = apply_filters('category_list_link_attributes', $link_atts, $term, $args, $depth);


        $nav_item = [
            'nav_item'   => $term,
            'depth'      => $depth,
            'parent'     => $args['menu_parent'] ?? '#menu-item-page-' . $term->parent,
            'child_type' => $args['child_type'] ?? 'collapse',
            'toggle'     => $args['toggle'] ?? [],
            'link'       => [
                'atts' => $link_atts,
                'text'       => [
                    'content' => rwp_title($term),
                ],
                'active' => self::checkCurrent($classes),
            ],
            'content' => [
                'after'  => $args['separator'],
            ],
            'atts' => [
                'id'    => $term->taxonomy . '-term-' . $term->term_id,
                'class' => $classes
            ]
        ];

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
