<?php

/** ============================================================================
 * Options
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/Options.php
 * @author		Jeremy Hixon <jeremy@jeremyhixon.com>
 * @copyright	Copyright (c) 2016
 * @link		https://github.com/jeremyHixon/RationalOptionPages
 * @version		1.0.0
 * @since 0.1.0
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Components\{Html, Field, Form};
use RWP\Vendor\Illuminate\Support\Collection;

trait Options {

    protected $errors;
    protected $notices;
    protected $points;

    /**
     * Get plugin option.
     *
     * @see https://developer.wordpress.org/reference/functions/get_option/
     *
     * @param string $name    The name of the option (without the prefix)
     * @param mixed  $default The default value of the option
     *
     * @return mixed $option
     */
    public function get_option($name, $default = null) {
        $name = $this->prefix($name); // how it is stored in DB

        return get_option($name, $default);
    }

    /**
     * Get plugin option.
     *
     * @see https://developer.wordpress.org/reference/functions/delete_option/
     *
     * @param string $name    The name of the option (without the prefix)
     *
     * @return bool
     *
     */
    public function delete_option($name) {
        $name = $this->prefix($name); // how it is stored in DB

        return delete_option($name);
    }

    /**
     * Update plugin option.
     *
     * @see https://developer.wordpress.org/reference/functions/update_option/
     *
     * @param string $name    The name of the option (without the prefix)
     * @param mixed setup_optionse default value of the option
     *
     * @return bool
     */
    public function update_option($name, $value) {
        $name = $this->prefix($name); // how it is stored in DB
        return update_option($name, $value);
    }
}
