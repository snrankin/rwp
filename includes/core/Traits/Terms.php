<?php

/** ============================================================================
 * Terms
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/Terms.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;


trait Terms {

    /**
     * Registered Post Types
     *
     *
     * @var array|Collection $terms
     */
    public $terms = [];

    /**
     * Post Type Labels Generator
     *
     * @param string $singular (Required) The singular version of the post type
     * @param string $plural   (Required) The plural version of the post type
     * @param string $menu     (Optional) The admin menu name. Defaults to $plural
     *
     * @return array The array of post type labels
     */
    public static function term_labels($singular, $plural = '', $menu = '') {

        $singular = rwp_singulizer($singular);

        if (empty($plural)) {
            $plural = rwp_pluralizer($singular);
        }

        $lower_singular = strtolower($singular);
        $lower_plural = strtolower($plural);

        $title_singular = ucwords($singular);
        $title_plural = ucwords($plural);

        $menu = $menu ?: $title_plural;

        return [
            'name'                       => _x($title_plural, 'Taxonomy General Name', 'rwp'),
            'singular_name'              => _x($title_singular, 'Taxonomy Singular Name', 'rwp'),
            'menu_name'                  => __($menu, 'rwp'),
            'all_items'                  => __('All ' . $title_plural, 'rwp'),
            'parent_item'                => __('Parent ' . $title_plural, 'rwp'),
            'parent_item_colon'          => __('Parent ' . $title_singular . ':', 'rwp'),
            'new_item_name'              => __('New ' . $title_singular . ' Name', 'rwp'),
            'add_new_item'               => __('Add New ' . $title_plural, 'rwp'),
            'edit_item'                  => __('Edit ' . $title_plural, 'rwp'),
            'update_item'                => __('Update ' . $title_plural, 'rwp'),
            'view_item'                  => __('View ' . $title_plural, 'rwp'),
            'separate_items_with_commas' => __('Separate ' . $lower_plural . ' with commas', 'rwp'),
            'add_or_remove_items'        => __('Add or remove ' . $lower_plural, 'rwp'),
            'popular_items'              => __('Popular ' . $title_plural, 'rwp'),
            'search_items'               => __('Search ' . $title_plural, 'rwp'),
            'no_terms'                   => __('No ' . $title_plural, 'rwp'),
            'items_list'                 => __($title_plural . ' list', 'rwp'),
            'items_list_navigation'      => __($title_plural . ' list navigation', 'rwp'),
        ];
    }

    public function new_term($singular, $plural = '', $menu = '', $post_types = ['post'], $args = []) {

        $singular = rwp_change_case(rwp_singulizer($singular), 'title');

        $defaults = [
            'labels'            => self::term_labels($singular, $plural, $menu),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'show_in_rest'      => true,
        ];

        $args = wp_parse_args($args, $defaults);

        $type = $this->prefix($singular, 'snake');

        register_taxonomy($type, $post_types, $args);

        flush_rewrite_rules();
    }

    public function init_terms() {
        $this->add_action('init', $this, 'register_terms');
    }

    public function register_terms() {

        if ($this->terms->isNotEmpty()) {
            $this->terms->each(function ($args) {
                return $this->new_term($args['label'], $args['plural'], $args['menu'], $args);
            });
        }
    }
}
