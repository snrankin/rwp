<?php

/** ============================================================================
 * RWP Helpers
 *
 * @package RWP\Components\Helpers
 * @since   0.1.0
 * ========================================================================== */

namespace RWP\Components;

trait Helpers {
    /**
     * Add prefix to string
     *
     * @param  string  $string  The string to prefix.
     * @param  string  $prefix  The prefix to add
     *
     * @return string
     */
    public function prefix($string = '', $prefix = '') {
        if (empty($prefix) || empty($string)) return;

        $pattern = "/^({$prefix})/";

        if (!preg_match($pattern, $string)) {

            $string = $prefix . $string;
        }
        return $string;
    }

    /**
     * Remove prefix from string.
     *
     * @param  string  $string  The string to prefix.
     * @param  string  $prefix  The prefix to remove
     *
     * @return string
     */
    public function unprefix($string = '', $prefix = '') {
        if (empty($prefix) || empty($string)) return;
        $pattern = "/^({$prefix})/";
        if (preg_match($pattern, $string)) {
            preg_match($pattern, $string, $matches);
            $prefix = reset($matches);
            $string = substr($string, strlen($prefix));
        }
        return $string;
    }

    /**
     * Add suffix to string
     *
     * @param  string  $string  The string to prefix.
     * @param  string  $suffix  The suffix to use
     *
     * @return string
     */
    public function suffix($string = '', $suffix = '') {
        if (empty($suffix) || empty($string)) return;

        $pattern = "/({$suffix})$/";

        if (!preg_match($pattern, $string)) {

            $string = $string . $suffix;
        }
        return $string;
    }

    /**
     * Remove suffix from string
     *
     * @param  string  $string  The string to prefix.
     * @param  string  $suffix  The suffix to remove
     *
     * @return string
     */
    public function unsuffix($string = '', $suffix = '') {
        if (empty($suffix)) return;
        $pattern = "/^({$suffix})/";
        if (preg_match($pattern, $string)) {
            preg_match($pattern, $string, $matches);
            $suffix = reset($matches);
            $suffix = strlen($suffix);
            $string = substr($string, 0, -$suffix);
        }
        return $string;
    }
}
