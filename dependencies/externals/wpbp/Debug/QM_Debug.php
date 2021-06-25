<?php

/** ============================================================================
 * debug
 *
 * @package   RWP_Vendor\WPBP\Debug
 * @since     0.2.0
 * @author    Mte90 <mte90net@gmail.com>
 * @copyright 2018
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Vendor\WPBP\Debug;

class QM_Debug extends \QM_Collector
{
    /**
     * Register with WordPress API on construct
     */
    public function __construct($title, $parent)
    {
        $this->title = $title;
        $this->parent = $parent;
        $this->id = \strtolower(\str_replace(' ', '-', $title));
    }
    public function name()
    {
        return $this->title;
    }
    public function process()
    {
        if (\is_array($this->parent->output)) {
            $this->data['log'] = $this->parent->output;
        }
    }
}
