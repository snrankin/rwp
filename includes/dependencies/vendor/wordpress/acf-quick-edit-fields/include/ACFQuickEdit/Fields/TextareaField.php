<?php

namespace RWP\Vendor\ACFQuickEdit\Fields;

if (!\defined('ABSPATH')) {
    die('Nope.');
}
class TextareaField extends \RWP\Vendor\ACFQuickEdit\Fields\TextField
{
    /**
     *	@inheritdoc
     */
    public function render_input($input_atts, $is_quickedit = \true)
    {
        $input_atts += ['class' => 'acf-quick-edit acf-quick-edit-' . $this->acf_field['type']];
        return '<textarea ' . acf_esc_attr($input_atts) . '></textarea>';
    }
    /**
     *	@inheritdoc
     */
    public function is_sortable()
    {
        return \false;
    }
    /**
     *	@param mixed $value
     */
    public function sanitize_value($value, $context = 'db')
    {
        return sanitize_textarea_field($value);
    }
}
