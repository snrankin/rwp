<?php

/** ============================================================================
 * Register all actions and filters for the plugin.
 *
 * @version    0.1.0
 * @link       https://developer.wordpress.org/plugins/hooks/
 * @package    RWP
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    RWP
 * @author     RIESTER <wordpress@riester.com>
 */
trait Loader {

    /**
     * The array of actions registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array|Collection $actions The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array|Collection $filters The filters registered with WordPress to fire when the plugin loads.
     */
    protected $filters;


    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     * @param    string               $hook             The name of the WordPress action that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the action is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->add_hook('actions', $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     * @param    string               $hook             The name of the WordPress filter that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->add_hook('filters', $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @since    1.0.0
     * @access   private
     * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
     * @param    string               $hook             The name of the WordPress filter that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         The priority at which the function should be fired.
     * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
     * @return   array                                  The collection of actions and filters registered with WordPress.
     */
    private function add_hook($hooks, $hook, $component, $callback, $priority, $accepted_args) {

        if (!($this->$hooks instanceof Collection)) {
            $this->$hooks = new Collection($this->$hooks);
        }

        $this->$hooks->push([
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args,
            'added'         => false,
        ]);
    }


    /**
     * Register the filters and actions with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        if ($this->filters->isNotEmpty()) {
            $this->filters->each(function ($hook) {
                if (!$hook['added']) {
                    add_filter($hook['hook'], array(&$hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
                    $hook['added'] = true;
                }
            });
        }


        if ($this->actions->isNotEmpty()) {
            $this->actions->each(function ($hook) {
                if (!$hook['added']) {
                    add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
                    $hook['added'] = true;
                }
            });
        }
    }
}
