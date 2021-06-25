<?php

namespace RWP\Vendor\ACFQuickEdit\Fields;

if (!\defined('ABSPATH')) {
    die('Nope.');
}
class OembedField extends \RWP\Vendor\ACFQuickEdit\Fields\Field
{
    /**
     *	@inheritdoc
     */
    public function render_column($object_id)
    {
        if (!($value = $this->get_value($object_id, \false))) {
            return;
        }
        return \sprintf('<a href="%s">%s</a>', esc_url($value), \parse_url($value, \PHP_URL_HOST));
    }
    /**
     *	@inheritdoc
     */
    public function render_input($input_atts, $is_quickedit = \true)
    {
        return '';
    }
}
