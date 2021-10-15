<?php

class StarRatingField extends acf_field {
	public $frontend_classes = array(
		'empty' => 'star-empty',
		'half' => 'star-half',
		'full' => 'star-filled'
	);

	public $backend_classes = array(
		'empty' => 'dashicons dashicons-star-empty',
		'half' => 'dashicons dashicons-star-half',
		'full' => 'dashicons dashicons-star-filled'
	);

	public $wrapper_classes = array(
		'star-rating',
		'hstack',
		'gap-3'
	);

	public $frontend_markup = array(
		'empty' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star %s star-icon" viewBox="0 0 16 16"><path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/></svg>',
		'half' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half %s star-icon" viewBox="0 0 16 16"><path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/></svg>',
		'full' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill %s star-icon" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'
	);

	public $backend_markup = array(
		'empty' => '<i class="%s star-icon"></i>',
		'half' => '<i class="%s star-icon"></i>',
		'full' => '<i class="%s star-icon"></i>'
	);

	/**
	 *  __construct
	 *
	 *  This function will setup the field type data
	 *
	 *  @type  function
	 *  @date  5/03/2014
	 *  @since 5.0.0
	 *
	 *  @return void
	 */
	public function __construct() {
		$this->name = 'star_rating_field';

		$this->label = __('Star Rating', 'acf-star_rating_field');

		$this->category = 'content';

		$this->defaults = array(
			'max_stars'  => 5,
		);

		$this->l10n = array(
			'error' => __('Error! Please enter a higher value', 'acf-star_rating_field'),
		);

		$this->backend_classes = apply_filters(
			'star_rating_field_admin_star_classes',
			$this->backend_classes
		);

		$this->frontend_classes = apply_filters(
			'star_rating_field_public_star_classes',
			$this->frontend_classes
		);

		$this->backend_markup = apply_filters(
			'star_rating_field_admin_star_markup',
			$this->backend_markup
		);

		$this->frontend_markup = apply_filters(
			'star_rating_field_public_star_markup',
			$this->frontend_markup
		);
		$this->wrapper_classes = apply_filters(
			'star_rating_field_wrapper_classes',
			$this->wrapper_classes
		);
		parent::__construct();
	}

	/**
	 *  render_field_settings()
	 *
	 *  Create extra settings for your field. These are visible when editing a field
	 *
	 *  @type  action
	 *  @since 3.6
	 *  @date  23/01/13
	 *
	 *  @param $field (array) the $field being edited
	 *
	 *  @return void
	 */
	public function render_field_settings($field) {
		acf_render_field_setting($field, array(
			'label' => __('Maximum Rating', 'acf-star_rating_field'),
			'instructions' => __('Maximum number of stars', 'acf-star_rating_field'),
			'type' => 'number',
			'name' => 'max_stars'
		));

		acf_render_field_setting($field, array(
			'label' => __('Return Type', 'acf-star_rating_field'),
			'instructions' => __('What should be returned?', 'acf-star_rating_field'),
			'type' => 'select',
			'layout' => 'horizontal',
			'choices' => array(
				'0'  => __('Number', 'num'),
				'1' => __('List (unstyled)', 'list_u'),
				'2' => __('List (fa-awesome)', 'list_fa'),
			),
			'name' => 'return_type'
		));

		acf_render_field_setting($field, array(
			'label' => __('Allow Half Rating', 'acf-star_rating_field'),
			'instructions' => __('Allow half ratings?', 'acf-star_rating_field'),
			'type' => 'true_false',
			'name' => 'allow_half'
		));
	}

	/**
	 *  render_field()
	 *
	 *  Create the HTML interface for your field
	 *
	 *  @type action
	 *  @since 3.6
	 *  @date 23/01/13
	 *
	 *  @param array $field the $field being rendered
	 *
	 *  @return string
	 */
	public function render_field($field) {
		$html = '
            <div class="star_rating_field_wrapper"><div class="field_type-star_rating_field">%s</div>
            <a href="#clear-stars" class="button button-small clear-button">%s</a></div>
            <input type="hidden" id="star-rating" data-allow-half="%s" name="%s" value="%s">
        ';

		$starClasses = $this->backend_classes;

		if (count($starClasses) !== 3) {
			return "Error: 3 classes are required to display rating field: blank class, half class and full class.";
		}

		printf(
			'<script>window.starClasses = %s</script>',
			json_encode($starClasses)
		);

		print sprintf(
			$html,
			$this->make_list(
				$field['max_stars'],
				$field['value'],
				$field['allow_half']
			),
			__('Clear', 'acf-star_rating_field'),
			$field['allow_half'],
			esc_attr($field['name']),
			esc_attr($field['value'])
		);
	}

	/**
	 *  input_admin_enqueue_scripts()
	 *
	 *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	 *  Use this action to add CSS + JavaScript to assist your render_field() action.
	 *
	 *  @type    action (admin_enqueue_scripts)
	 *  @since   3.6
	 *  @date    23/01/13
	 *
	 *  @return void
	 */
	public function input_admin_enqueue_scripts() {
		$dir = plugin_dir_url(__FILE__);

		wp_enqueue_script('acf-input-star_rating', "{$dir}js/input.js");
		// wp_enqueue_style(
		//     'font-awesome',
		//     "//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"
		// );
		wp_enqueue_style('acf-input-star_rating', "{$dir}css/input.css");
	}

	/**
	 *  load_value()
	 *
	 *  This filter is applied to the $value after it is loaded from the db
	 *
	 *  @type    filter
	 *  @since   3.6
	 *  @date    23/01/13
	 *
	 *  @param mixed $value the value found in the database
	 *  @param mixed $post_id the $post_id from which the value was loaded
	 *  @param array $field the field array holding all the field options
	 *
	 *  @return float $value
	 */
	public function load_value($value, $post_id, $field) {
		return floatval($value);
	}

	/**
	 *  update_value()
	 *
	 *  This filter is applied to the $value before it is saved in the db
	 *
	 *  @type    filter
	 *  @since   3.6
	 *  @date    23/01/13
	 *
	 *  @param mixed $value the value found in the database
	 *  @param mixed $post_id the $post_id from which the value was loaded
	 *  @param array $field the field array holding all the field options
	 *  @return float $value
	 */
	public function update_value($value, $post_id, $field) {
		return floatval($value);
	}

	/**
	 *  format_value()
	 *
	 *  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	 *
	 *  @type    filter
	 *  @since   3.6
	 *  @date    23/01/13
	 *
	 *  @param mixed $value the value which was loaded from the database
	 *  @param mixed $post_id the $post_id from which the value was loaded
	 *  @param array $field the field array holding all the field options
	 *
	 *  @return mixed $value the modified value
	 */
	public function format_value($value, $post_id, $field) {
		if (empty($value)) {
			return $value;
		}

		switch ($field['return_type']) {
			case 0:
				return floatval($value);
				break;
			case 1:
				return $this->make_list(
					$field['max_stars'],
					$value,
					$field['allow_half']
				);
				break;
			case 2:
				$dir = plugin_dir_url(__FILE__);

				wp_enqueue_style('acf-input-star_rating', "{$dir}css/input.css");

				$html = '<div class="field_type-star_rating_field">%s</div>';

				return sprintf(
					$html,
					$this->make_list(
						$field['max_stars'],
						$value,
						$field['allow_half']
					)
				);
				break;
		}
	}

	/**
	 *  validate_value()
	 *
	 *  This filter is used to perform validation on the value prior to saving.
	 *  All values are validated regardless of the field's required setting. This allows you to validate and return
	 *  messages to the user if the value is not correct
	 *
	 *  @type    filter
	 *  @date    11/02/2014
	 *  @since   5.0.0
	 *
	 *  @param bool $valid validation status based on the value and the field's required setting
	 *  @param mixed $value the $_POST value
	 *  @param array $field the field array holding all the field options
	 *  @param string $input the corresponding input name for $_POST value
	 *  @return string $valid
	 */
	public function validate_value($valid, $value, $field, $input) {
		if ($value > $field['max_stars']) {
			$valid = __('The value is too large!', 'acf-star_rating_field');
		}

		if ($field['required'] == 1 && $value == 0) {
			$valid = sprintf(__('Please enter a value clicking on stars form 1 to %s', 'acf-star_rating_field'), $field['max_stars']);
		}

		return $valid;
	}

	/**
	 *  load_field()
	 *
	 *  This filter is applied to the $field after it is loaded from the database
	 *
	 *  @type    filter
	 *  @date    23/01/2013
	 *  @since   3.6.0
	 *
	 *  @param array $field the field array holding all the field options
	 *  @return array $field
	 */
	public function load_field($field) {
		return $field;
	}

	/**
	 *  update_field()
	 *
	 *  This filter is applied to the $field before it is saved to the database
	 *
	 *  @type    filter
	 *  @date    23/01/2013
	 *  @since   3.6.0
	 *
	 *  @param array $field the field array holding all the field options
	 *  @return array $field
	 */
	public function update_field($field) {
		return $field;
	}

	/**
	 * make_list()
	 *
	 * Create a HTML list
	 *
	 * @param int $maxStars
	 * @param int $currentStar
	 * @return string $html
	 */
	public function make_list($maxStars = 5, $currentStar = 0, $allowHalf = false) {
		$wrapper_classes = rwp_output_classes(rwp_parse_classes($this->wrapper_classes));
		$html = '<div class="' . $wrapper_classes . '">';
		$li = '<span class="star star-%d">%s</span>';
		$star_markup = $this->frontend_markup;
		$classes = $this->frontend_classes;

		if (is_admin()) {
			$star_markup = $this->backend_markup;
			$classes = $this->backend_classes;
		}

		for ($index = 1; $index <= $maxStars; $index++) {

			$type = 'empty';

			if ($index <= $currentStar) {
				$type = 'full';
			}

			if ($allowHalf && ($index - .5 == $currentStar)) {
				$type = 'half';
			}

			$class = $classes[$type];
			$star = $star_markup[$type];

			$star = wp_sprintf($star, $class);

			$html .= wp_sprintf($li, $index, $star);
		}

		$html .= "</div>";

		return $html;
	}

	public static function output_stars($field) {
		$maxStars = data_get($field, 'max_stars', 5);
		$currentStar = data_get($field, 'value', 1);
		$li = '<span class="star star-%d">%s</span>';

		$backend_classes = apply_filters(
			'star_rating_field_admin_star_classes',
			array(
				'empty' => 'dashicons dashicons-star-empty',
				'half' => 'dashicons dashicons-star-half',
				'full' => 'dashicons dashicons-star-filled'
			)
		);

		$frontend_classes = apply_filters(
			'star_rating_field_public_star_classes',
			array(
				'empty' => 'star-empty',
				'half' => 'star-half',
				'full' => 'star-filled'
			)
		);

		$backend_markup = apply_filters(
			'star_rating_field_admin_star_markup',
			array(
				'empty' => '<i class="%s"></i>',
				'half' => '<i class="%s"></i>',
				'full' => '<i class="%s"></i>'
			)
		);

		$frontend_markup = apply_filters(
			'star_rating_field_public_star_markup',
			array(
				'empty' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star %s" viewBox="0 0 16 16"><path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/></svg>',
				'half' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half %s" viewBox="0 0 16 16"><path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/></svg>',
				'full' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill %s" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'
			)
		);
		$wrapper_classes = apply_filters(
			'star_rating_field_wrapper_classes',
			array(
				'star-rating',
				'hstack',
				'gap-3'
			)
		);

		$star_markup = $frontend_markup;
		$classes = $frontend_classes;

		if (is_admin()) {
			$star_markup = $backend_markup;
			$classes = $backend_classes;
		}
		$allowHalf = data_get($field, 'allow_half', 0);

		$wrapper_classes = rwp_output_classes(rwp_parse_classes($wrapper_classes));

		$html = '<div class="' . $wrapper_classes . '">';

		for ($index = 1; $index <= $maxStars; $index++) {
			$type = 'empty';

			if ($index <= $currentStar) {
				$type = 'full';
			}

			if ($allowHalf && ($index - .5 == $currentStar)) {
				$type = 'half';
			}

			$class = rwp_output_classes(rwp_parse_classes($classes[$type]));
			$star = $star_markup[$type];

			$star = wp_sprintf($star, $class);

			$html .= wp_sprintf($li, $index, $star);
		}

		$html .= "</div>";

		return $html;
	}
}
