<?php

namespace RWP\Vendor\ACFQuickEdit\Fields;

if (!\defined('ABSPATH')) {
    die('Nope.');
}
class TextField extends \RWP\Vendor\ACFQuickEdit\Fields\Field
{
    /**
     *	@inheritdoc
     */
    public function render_column($object_id)
    {
        $value = $this->get_value($object_id);
        if ($value !== '') {
            return \sprintf('<div class="qef-text">%s</div>', esc_html($value));
        }
        return '';
    }
    /**
     *	@inheritdoc
     */
    public function is_sortable()
    {
        return \true;
    }
}
