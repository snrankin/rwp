<?php

/** ============================================================================
 * ACF
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/ACF.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;

trait ACF {
	/**
	 * Advanced Custom Fields Option Pages
	 *
	 * @link https://www.advancedcustomfields.com/resources/acf_add_options_page/
	 *
	 * @var array|Collection $acf_pages
	 */
	protected $acf_pages = [];


	/**
	 * Advanced Custom Fields Blocks
	 *
	 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
	 *
	 * @var array|Collection $acf_blocks
	 */

	protected $acf_blocks = [];

	protected $acf_save_path;


	public function add_acf_options_page($menu_title, $args = []) {
		$menu_slug = $this->prefix($menu_title);
		$defaults = [
			'page_title' => '',
			'menu_title' => $menu_title,
			'menu_slug' => $menu_slug,
			'capability' => 'edit_posts',
			'position' => '',
			'parent_slug' => '',
			'icon_url' => '',
			'redirect' => true,
			'post_id' => 'options',
			'autoload' => true,
			'update_button' => __('Update', 'rwp'),
			'updated_message' => __("Options Updated", 'rwp'),
		];

		$args = wp_parse_args($args, $defaults);

		if (rwp_array_has('parent_slug', $args)) {
			$args['parent_slug'] = $this->prefix($args['parent_slug']);
		}
		if (function_exists('acf_add_options_page')) {
			acf_add_options_page($args);
		}
	}

	public function add_acf_option($field_name, $type = 'text', $args = []) {
		$field_label = rwp_change_case($field_name, 'title');
		$field_name = $this->prefix($field_name);
		$field_key = 'field_' . $field_name;

		$defaults = [
			'key' => $field_key,
			'label' => $field_label,
			'name' => $field_name,
			'type' => $type
		];

		if ($this->acf_type_defaults->has($type)) {
			$type_args = $this->acf_type_defaults->get($type);
			$defaults = wp_parse_args($type_args, $defaults);
		}

		$args = wp_parse_args($args, $defaults);

		$field = rwp_collection($args);
		$parent_field_key = null;
		if ($field->has('parent')) {
			$parent = $field->get('parent');
			$parent_field_name = $this->prefix($parent);
			$parent_field_key = 'field_' . $parent_field_name;
		}
		if (!empty($parent_field_key)) {
			if ($this->acf_options->contains($parent_field_key)) {
				$parent_field = $this->acf_options->get($parent_field_key);
				if (!$parent_field->has('sub_fields')) {
					$sub_fields = rwp_collection([
						$field_key => $field
					]);
					$parent_field->put('sub_fields', $sub_fields);
				} else {
					$sub_fields = $parent_field->get('sub_fields');
					if (!$sub_fields->has($field_key)) {
						$sub_fields->put($field_key, $field);
					}
					$parent_field->put('sub_fields', $sub_fields);
				}
				$this->acf_options->put($parent_field_key, $parent_field);
			}
		} else if (!$this->acf_options->has($field_key)) {
			$this->acf_options->put($field_key, $field);
		}
	}

	public function setup_acf() {

		foreach ($this->acf_pages->all() as $title => $args) {
			$this->add_acf_options_page($title, $args);
		}

		if ($this->acf_pages->isNotEmpty()) {
			$this->acf_pages->each(function ($args, $title) {
				$this->add_acf_options_page($title, $args);
			});
		}
		$this->register_assets('acf');

		foreach (glob($this->acf_save_path . '/*.*') as $file) {
			require_once $file;
		}
	}

	public function enqueue_acf_assets() {
		$this->enqueue_assets('acf');
	}

	public function init_acf() {
\add_action('acf/init', array($this, 'setup_acf'));
		// \add_action('save_post', array($this, 'save_fields'));
		// \add_action('saved_term', array($this, 'save_fields'));
		\add_action('acfe/init', array($this, 'init_acfe'));
		\add_action('acfe/save_option/slug=general-site-settings', array( $this, 'save_acf_options' ), 10, 2);
		\add_action('acfe/save_term', array( $this, 'save_acf_term_fields' ), 10, 2);
		\add_action('acfe/save_post', array( $this, 'save_acf_post_fields' ), 10, 2);
		\add_action('acf/admin_enqueue_scripts', array($this, 'enqueue_acf_assets'), 999);

	}

	/**
     * ACFE Save Post Fields
	 *
	 * @link https://www.acf-extended.com/features/hooks-helpers/save-post
     *
     * @param string  $post_id  The ACF Options Page Post ID
     * @param array   $object   The ACF Options Page Settings array
     */

	public function save_acf_post_fields( $post_id, $object = array() ) {

		$acf_id = $post_id;

		if(function_exists('acfe_get_post_id')){
			$acf_id = acfe_get_post_id();
		}

		$fields = get_fields( $post_id );

		$fields = self::sanitize_acf_array( $fields, $post_id ); // phpcs:ignore
		if ( ! empty( $fields ) ) {
			update_post_meta($post_id, '_rwp_acf', $fields);
		}
	}

	/**
     * ACFE Save Term Fields
	 *
	 * @link https://www.acf-extended.com/features/hooks-helpers/save-post
     *
     * @param string  $post_id  The ACF Options Page Post ID
     * @param array   $object   The ACF Options Page Settings array
     */

	public function save_acf_term_fields( $post_id, $object ) {

		$acf_id = $post_id;

		if(function_exists('acfe_get_post_id')){
			$acf_id = acfe_get_post_id();
		}

		$fields = get_fields( $acf_id );

		$fields = self::sanitize_acf_array( $fields, $post_id ); // phpcs:ignore
		if ( ! empty( $fields ) ) {
			update_term_meta($post_id, '_rwp_acf', $fields);
		}
	}

	/**
     * ACFE Save Options Page
	 *
	 * @link https://www.acf-extended.com/features/hooks-helpers/save-post
     *
     * @param string  $post_id  The ACF Options Page Post ID
     * @param array   $object   The ACF Options Page Settings array
     */

	public function save_acf_options($post_id, $object){

		if(function_exists('acfe_get_post_id')){
			$post_id = acfe_get_post_id();
		}

		$fields = get_fields( $post_id );

		$fields = self::sanitize_acf_array( $fields, $post_id ); // phpcs:ignore
		if ( ! empty( $fields ) ) {
			$this->update_option( 'options', $fields );
		}
	}


	public static function sanitize_acf_array($fields) {
		$acf_fields = rwp_collection();
		$components = [
			'button',
			'email_button',
			'phone_button',
			'buttons',
			'image',
			'gallery',
			'background',
			'nav_options'
		];
		if (!empty($fields)) {
			foreach ($fields as $key => $field) {
				if (!empty($key) || !empty($field)) {
					if ($key === 'custom_archive_pages') {
						$test = true;
					}
					if (in_array($key, $components)) {
						$field = self::process_component_acf_field($key, $field);
					}
					if (is_array($field)) {
						if (count($field) == 1 && rwp_array_has($key, $field)) {
							$field = $field[$key];
							if (in_array($key, $components)) {
								$field = self::process_component_acf_field($key, $field);
							}
							$field = self::sanitize_acf_array($field);
						} else {
							$field = self::process_acf_field($field);
						}
					}
					$acf_fields->put($key, $field);
				}
			}
		}
		return $acf_fields;
	}


	/**
	 * @param mixed $post
	 * @return Collection
	 */
	public function get_acf_fields($post = null) {

		if ('options' === $post) {
			$fields = $this->get_option('options');
			return $fields;
		}

		$post_type = rwp_object_type($post);
		$post_id = rwp_id($post);

		$fields = false;

		if (0 !== $post_id) {
			if ('post' === $post_type['type'] ) {
				$fields = get_post_meta($post_id, '_rwp_acf', true);
				if (empty($fields)) {
					$fields = get_post_meta($post_id, 'acf', true);
				}
			} elseif ('term' === $post_type['type']) {
				$fields = get_term_meta($post_id, '_rwp_acf', true);
				if (empty($fields)) {
					$fields = get_term_meta($post_id, 'acf', true);
				}

			}
			if (empty($fields)) {
				if(function_exists('get_fields')){
					$fields = get_fields(rwp_id($post, 'acf'));
				}

			}
		} else {
			$fields = $this->get_option('options');
		}

		if (is_array($fields)) {
			$fields = rwp_collection($fields);
		}

		return $fields;
	}

	public function sanitize_fields($option, $value) {

		if (is_object($value)) {
			$value = clone $value;
		}

		$value = sanitize_option($option, $value);

		$serialized_value = maybe_serialize($value);

		return $serialized_value;
	}

	public function get_acf_field($field, $post = null, $default = null) {

		$acf_fields = $this->get_acf_fields($post);
		if (rwp_is_collection($acf_fields) && $acf_fields->isNotEmpty()) {
			return rwp_get_option($acf_fields, $field, $default);
		} else {
			return get_field($field, $post);
		}
	}

	/**
	 * Initialize ACF Extended plugin settings
	 *
	 * @link https://www.acf-extended.com/
	 */

	public function init_acfe() {
		if (function_exists('acfe_update_setting')) {
			\acfe_update_setting('modules/single_meta', true);
			if (true === WP_DEBUG) {
				\acfe_update_setting('dev', true);
			}

			$path = $this->acf_save_path;
			\acfe_update_setting('php_save', $path);

			$load_paths = acf_get_setting('php_load');
			$load_paths[] = $path;
			\acfe_update_setting('php_load', $load_paths);
		}
	}

	public static function process_acf_field($field = []) {

		$components = [
			'button',
			'email_button',
			'phone_button',
			'buttons',
			'image',
			'gallery',
			'background',
			'nav_options'
		];

		if (is_array($field)) {
			$new_field = rwp_collection();

			foreach ($field as $sub_key => $sub_field) {
				if ($sub_key !== '' && $sub_field !== '') {
					$label = $sub_key;
					if (is_array($sub_field)) {
						$sub_field_keys = array_keys($sub_field);
						if (count($sub_field) == 1 && reset($sub_field_keys) === $label) {
							$sub_field = reset($sub_field);
						}
						if (in_array($sub_key, $components, true)) {
							$sub_field = self::process_component_acf_field($sub_key, $sub_field);
						} else {
							$sub_field = self::process_acf_field($sub_field);
						}

						if ($sub_key === 'social_profiles') {
							if (rwp_is_collection($sub_field) && $sub_field->has('buttons')) {
								// $buttons = $sub_field->get('buttons');
								// $buttons = self::process_component_acf_field('buttons', $buttons);
								//$sub_field->put('buttons', $buttons);
								if ($sub_field->count() == 1) {
									$sub_field = $sub_field->first();

									if (rwp_is_collection($sub_field)) {
										$sub_field = $sub_field->all();
									}
								}
							}
						}

						if (rwp_is_collection($sub_field) && $sub_field->has('label')) {
							$label = $sub_field->pull('label');
							if ($sub_field->count() == 1) {
								$sub_field = $sub_field->all();
								$sub_field = reset($sub_field);
							}
						}
					}

					$label = rwp_change_case($label, 'snake');

					$new_field->put($label, $sub_field);
				}
			}
			if ($new_field->isNotEmpty()) {
				$field = $new_field;
			} else {
				$field = false;
			}
		}

		return $field;
	}

	public static function process_component_acf_field($key = '', $args = []) {

		if ($key !== '' && !empty($args)) {

			$args = rwp_prepare_args($args);

			if (rwp_array_has('items', $args) && wp_is_numeric_array($args['items'])) {
				foreach ($args['items'] as $index => $value) {
					if (rwp_array_has('label', $value)) {
						unset($args['items'][$index]);
						$index = rwp_change_case($value['label'], 'snake');
						unset($value['label']);

						$args['items'][$index] = $value;
					}
				}
			}
			switch ($key) {
				case 'buttons':
					if (rwp_array_has('items', $args)) {
						foreach ($args['items'] as $label => $button) {
							$args['items'][$label] = self::process_component_acf_field('button', $button['button']);
						}
					}
					break;
				case 'button':
				case 'email_button':
				case 'phone_button':
					$add_icon = rwp_get_option($args, 'add_icon', false);
					if (false === $add_icon) {
						unset($args['icon']);
						unset($args['add_icon']);
					} else {
						$args['icon'] = self::process_component_acf_field('icon', $args['icon']['icon']);
					}
					if ($key === 'email_button' || $key === 'phone_button') {
						$args['atts']['href'] = $args['text']['content'];
						$args['atts']['tag'] = 'a';
						$args['atts'] = rwp_prepare_args($args['atts']);
					}

					if (rwp_array_has('atts', $args)) {
						$args['atts'] = rwp_prepare_args($args['atts']);
					} else {
						$args['atts'] = [
							'class' => []
						];
					}

					if (rwp_array_has('before', $args)) {
						$args['content']['before'] = $args['before'];
						unset($args['before']);
					}
					if (rwp_array_has('after', $args)) {
						$args['content']['after'] = $args['after'];
						unset($args['after']);
					}

					if (rwp_array_has('btn_style', $args['atts'])) {

						$btn_class = 'btn';

						if ($args['atts']['btn_style'] !== 'solid') {
							$btn_class .= '-' . $args['atts']['btn_style'];
						}

						if (rwp_array_has('btn_theme', $args['atts']) && $args['atts']['btn_style'] !== 'link') {
							$btn_class .= '-' . $args['atts']['btn_theme'];
						}

						unset($args['atts']['btn_style']);
						$args['atts']['class'][] = $btn_class;
					}
					unset($args['atts']['btn_theme']);
					if (rwp_array_has('btn_size', $args['atts'])) {
						$btn_class = 'btn-' . $args['atts']['btn_size'];

						unset($args['atts']['btn_size']);
						$args['atts']['class'][] = $btn_class;
					}



					unset($args['add_icon']);
					break;
				case 'icon':
					if (isset($args['type']) && $args['type'] === 'image') {
						$icon = rwp_media(['src' => $args['image']]);
						$icon = $icon->image->__toString();
						$args['content'] = [$icon];
						$args['atts']['tag'] = 'span';
					} else if (isset($args['atts']) && !empty($args['atts']['class'])) {
						$args['atts']['tag'] = 'i';
					}
					unset($args['type']);
					unset($args['image']);
					$args = rwp_icon($args);
					break;
				case 'background':
					if (rwp_array_has('type', $args)) {
						switch ($args['type']) {
							case 'image':
								$args['src'] = $args['image'];
								unset($args['image']);
								unset($args['video']);
								unset($args['color']);
								break;

							case 'video':
								$args['video'] = self::process_component_acf_field('video', $args['video']);
								unset($args['image']);
								unset($args['color']);
								break;
							case 'color':
								if (rwp_array_has('atts', $args)) {
									if (!rwp_array_has('class', $args['atts'])) {
										$args['atts']['class'] = [];
									}
								} else {
									$args['atts'] = [
										'class' => []
									];
								}
								$args['atts']['class'][] = $args['color'];
								unset($args['image']);
								unset($args['video']);
								unset($args['color']);
								break;
						}
					} else {
						$args = false;
					}
					break;
				case 'nav_options':
					if (rwp_array_has('background_color', $args)) {
						$color = $args['background_color'];
						if ($args['background_color'] === 'custom' && rwp_array_has('custom_background_color', $args)) {
							$color = $args['custom_background_color'];
							unset($args['custom_background_color']);
						}
						if ($args['background_color'] === 'transparent') {
							$color = null;
						}
						$args['color'] = $color;
						unset($args['background_color']);
					}

					if (rwp_array_has('navbar_options', $args) && $args['type'] === 'navbar') {
						$navbar = $args['navbar_options'];

						if (rwp_array_has('navbar_items', $navbar)) {
							$items = ['brand', 'search', 'text'];
							$navbar_items = $navbar['navbar_items'];

							foreach ($items as $item) {
								if (!in_array($item, $navbar_items)) {
									unset($navbar[$item]);
								}
							}
						}

						$args = rwp_merge_args($navbar, $args);
					}

					unset($args['navbar_options']);


					break;
			}
			if (is_object($args)) {
				$args = rwp_object_to_array($args);
			}
			if (is_array($args)) {
				foreach ($args as $key => $value) {
					if ($key === '' || $value === '') {
						unset($args[$key]);
					}
				}
			}
		}

		return $args;
	}
}
