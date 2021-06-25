<?php

/** ============================================================================
 * RWP acf
 *
 * @package RWP\/includes/functions/utils/acf.php
 * @since   0.1.0
 * ========================================================================== */

use RWP\Vendor\Illuminate\Support\Collection;

function rwp_get_acf_fields($post = null){
	if(function_exists('acfe_get_fields')){
		return acfe_get_fields($post);

	} else if(function_exists('get_fields')){
		return get_fields(rwp_id($post, 'acf'));
	}
}

function rwp_get_fields($post = null) {
	return rwp()->get_acf_fields($post);
}

function rwp_get_field($field, $post = null, $default = null) {
	return rwp()->get_acf_field($field, $post, $default);
}

/**
 * Helper to extract a specific field from an array or collection of settings
 *
 * @param mixed $field
 * @param string $setting
 * @param mixed|null $default
 * @param mixed|null $post
 *
 * @return mixed
 */

function rwp_get_option($field = '', $setting = '', $default = null, $post = null) {
	if (empty($field)) {
		if (empty($post)) {
			$field = rwp_get_fields('options');
		} else {
			$field = rwp_get_fields($post);
		}
	}
	if (!empty($field) && is_string($field)) {
		if (!empty($post)) {
			$field = rwp_get_field($field, $post);
		} else {
			$field = rwp_get_field($field, 'options');
		}
	}

	if (rwp_is_collection($field) && !empty($setting)) {
		if ($field->has($setting)) {
			return $field->get($setting);
		} else {
			return $default;
		}
	} elseif (is_array($field)  && !empty($setting)) {
		if (rwp_array_has($setting, $field)) {
			return $field[$setting];
		} else {
			return $default;
		}
	} elseif (is_object($field)  && !empty($setting)) {
		if (rwp_object_has($setting, $field)) {
			return $field->$setting;
		} else {
			return $default;
		}
	} else {
		if(!empty($field)){
			return $field;
		} else {
return $default;
		}

	}
}

function rwp_get_acf_rest_field($field = '', $post = null) {
	if (!($post instanceof \WP_Post)) {
		$post = get_post($post);
	}
	if ($post instanceof \WP_Post) {
		$acf = get_post_meta($post->ID, 'acf', true);
		if (rwp_array_has($field, $acf)) {
			$field = $acf[$field];
		} else {
			$field = get_field($field, $post);
		}
	}

	return $field;
}


function rwp_set_row_columns($settings = []) {
	if ($settings instanceof Collection) {
		$settings = $settings->all();
	}
	if (!empty($settings)) {
		$row_cols = [];
		foreach ($settings as $key => $value) {
			if (!empty($value)) {
				$row_cols[] = "row-cols-$key-$value";
			}
		}
		return $row_cols;
	} else {
		return false;
	}
}
