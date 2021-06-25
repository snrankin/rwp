<?php

/** ============================================================================
 * WidgetBase
 *
 * @package RIESTERWP Plugin\/includes/core/Widgets/WidgetBase.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Widgets;

use RWP\Vendor\Illuminate\Support\Collection;
use Illuminate\Config\Repository as Config;

class WidgetBase extends \WP_Widget {

	use \RWP\Traits\Helpers;

	public $widget_fields = [];

	// The construct part
	function __construct($name, $widget_options = array(), $control_options = array()) {
		if (defined('RWP_PLUGIN_VERSION')) {
			$this->version = RWP_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		if (defined('RWP_PLUGIN_PATH')) {
			$this->path = RWP_PLUGIN_PATH;
		}
		if (defined('RWP_PLUGIN_URL')) {
			$this->url = RWP_PLUGIN_URL;
		}
		if (defined('RWP_PLUGIN_NAME')) {
			$this->name = RWP_PLUGIN_NAME;
		}
		if (defined('RWP_PLUGIN_PREFIX')) {
			$this->prefix = RWP_PLUGIN_PREFIX;
		}
		if (defined('RWP_PLUGIN_FILE')) {
			$this->file = RWP_PLUGIN_FILE;
		}

		$id_base = $this->prefix($name);

		$name = $this->prefix($name, 'title');

		parent::__construct($id_base, $name, $widget_options, $control_options);
	}

	public function output_field($field = [], $instance) {
		$output = '';
		$default = '';
		if (isset($field['default'])) {
			$default = $field['default'];
		}
		$field_id = esc_attr($this->get_field_id($field['id']));
		$field_name = esc_attr($this->get_field_name($field['id']));
		$field_value = !empty($instance[$field['id']]) ? $instance[$field['id']] : esc_html__($default, 'rwp');

		$output .= '<p>';
		if ($field['type'] !== 'checkbox' && $field['type'] !== 'radio') {
			$output .= wp_sprintf('<label for="%s">%s</label>', $field_id, esc_attr($field['label'], 'rwp'));
		}


		switch ($field['type']) {
			case 'select':

				if ($field['multiple']) {
					$output .= wp_sprintf('<select data-width="%s" multiple data-multiple="true" name="%s[]" id="%s" class="widefat select2">', '100%', $field_name, $field_id);
				} else {
					$output .= wp_sprintf('<select name="%s" id="%s" class="widefat select2">', $field_name, $field_id);
				}

				foreach ($field['options'] as $i => $option) {
					if (wp_is_numeric_array($field['options'])) {
						$option_value = $option;
					} else {
						$option_value = $i;
					}
					$output .= wp_sprintf(
						'<option value="%s" %s>%s</option>',
						$option_value,
						rwp_array_has('items', $instance) && in_array($option_value, $instance['items']) ? 'selected="selected"' : '',
						$option
					);
				}
				$output .= '</select>';

				break;
			case 'checkbox':

				$output .= wp_sprintf('<input name="%s[]" %s id="%s" type="%s" value="%s" class="%s">', $field_name, checked($field_value, true, false), $field_id, $field['type'], 1, $field['type']);
				$output .= wp_sprintf('<label for="%s">%s</label>', $field_id, esc_attr($field['label'], 'rwp'));
				break;
			default:
				$output .= wp_sprintf('<input name="%s[]" id="%s" type="%s" value="%s" class="widefat">', $field_name, $field_id, $field['type'], $field_value);
		}
		$output .= '</p>';

		echo $output;
	}

	public function field_generator($instance) {

		foreach ($this->widget_fields as $widget_field) {
			$this->output_field($widget_field, $instance);
		}
	}

	public function form($instance) {

		$this->field_generator($instance);
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

		foreach ($this->widget_fields as $widget_field) {
			$field_value = $new_instance[$widget_field['id']];
			switch ($widget_field['type']) {
				case 'select':
					if ($widget_field['multiple']) {
						$instance['items'] = esc_sql($new_instance['items']);
					} else {
						$instance[$widget_field['id']] = !empty($field_value) ? strip_tags($field_value) : '';
					}

					break;

				default:
					if (is_array($field_value) && count($field_value) == 1) {
						$field_value =  $field_value[0];
					}
					$instance[$widget_field['id']] = !empty($field_value) ? $field_value : '';
			}
		}
		return $instance;
	}

	public function widget($args, $instance) {
		echo $args['before_widget'];

		foreach ($instance as $field) {
			echo '<p>' . $field . '</p>';
		}

		echo $args['after_widget'];
	}
}
