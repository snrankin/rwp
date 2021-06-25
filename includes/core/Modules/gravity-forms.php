<?php

/** ============================================================================
 * RWP GravityForms
 *
 * @package RWP\Modules\GravityForms
 * @since   0.1.0
 * ========================================================================== */


namespace RWP\Modules\GravityForms;

use function RWP\Modules\Plugins\enqueue_select2;

if (!defined('ABSPATH')) {
	die();
}

if (is_admin()) {
	return;
}

if (!is_plugin_active('gravityforms/gravityforms.php') || !get_theme_support('rwp-gravity-forms')) {
	return;
}

use GFAPI;
use GF_Fields;
use GF_Field_Address;
use GFCommon;

$options = get_theme_support('rwp-gravity-forms')[0];


/**
 * Function to add gravity forms styles to front and backend
 *
 * @param array $styles Array of style handles to be enqueued.
 * @param array $form Current form.
 * @return array
 *
 * @see https://docs.gravityforms.com/gform_preview_styles/
 */
function bootstrap_gravity_styles($styles, $form = array()) {
	if (!wp_style_is('rwp-gravity-forms', 'registered')) {
		rwp()->register_assets('gravity-forms');
	}

	rwp()->enqueue_assets('gravity-forms');

	enqueue_select2();

	if (!is_array($styles)) {
		$styles = array('rwp-gravity-forms');
	} else {
		$styles[] = 'rwp-gravity-forms';
	}
	$styles[] = 'select2';

	return $styles;
}


if (in_array('bootstrap-markup', $options)) {
	add_filter('gform_disable_form_theme_css', '__return_true');
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\bootstrap_gravity_styles');
	add_action('gform_enqueue_scripts', __NAMESPACE__ . '\\bootstrap_gravity_styles');
	add_filter('gform_preview_styles', __NAMESPACE__ . '\\bootstrap_gravity_styles', 10, 2);
	add_filter('gform_noconflict_styles', __NAMESPACE__ . '\\bootstrap_gravity_styles', 10, 2);
}

/**
 * Filters the next, previous and submit buttons.
 *
 * Replaces the forms <input> buttons with <button> while maintaining attributes
 * from original <input>.
 *
 * @param string $button Contains the <input> tag to be filtered.
 * @param object $form Contains all the properties of the current form.
 *
 * @see https://docs.gravityforms.com/gform_submit_button/
 *
 * @return string The filtered button.
 */

function input_to_button($button, $form) {

	$button = rwp_input_to_button($button);

	return apply_filters('rwp_gravity_form_button_args', $button, $form);
}

if (in_array('bootstrap-markup', $options)) {
	add_filter('gform_next_button', __NAMESPACE__ . '\\input_to_button', 30, 2);
	add_filter('gform_previous_button', __NAMESPACE__ . '\\input_to_button', 30, 2);
	add_filter('gform_submit_button', __NAMESPACE__ . '\\input_to_button', 30, 2);
}

/**
 * Modify the field container markup
 *
 * This filter can be used to modify the markup used for the field container.
 *
 * @param string     $field_container  The field container markup. The
 *                                     placeholder {FIELD_CONTENT} indicates
 *                                     where the markup for the field content
 *                                     should be located.
 * @param \GF_Field  $field            The field currently being processed.
 * @param array      $form             The Form currently being processed.
 * @param string     $css_class        The CSS classes to be assigned to the
 *                                     container element.
 * @param string     $style            An empty string as of 1.9.4.4. Was
 *                                     previously used to hold the conditional
 *                                     logic display style.
 * @param string     $field_content    The markup for the field content (label,
 *                                     description, and inputs etc) which will
 *                                     replace the {FIELD_CONTENT} placeholder.
 * @return string
 *
 * @see https://docs.gravityforms.com/gform_field_container/
 */
function field_container($field_container, $field, $form, $css_class, $style, $field_content) {

	$classes = explode(' ', $css_class);

	$field_container_html = rwp_extract_html_atts($field_container);
	$field_container_html = rwp_html($field_container_html);


	if (GFCommon::get_version_info() < 2.5) {


		if (!in_array('gform_validation_container', $classes) && $field->visibility === 'visible' && $field->type !== 'captcha') {
			$field_container_html->addClass('col');
		} else {
			$field_container_html->addClass('hidden-field');
		}
	} else {

		if ($field_container_html->hasClass('gfield_error')) {
			$field_container_html->addClass('is-invalid');
		}

		$field_container_html->removeClass('select2');
	}

	$field_container = $field_container_html->__toString();


	return $field_container;
}

if (in_array('bootstrap-markup', $options)) {
	add_filter('gform_field_container', __NAMESPACE__ . '\\field_container', 30, 6);
}

/**
 * Filter the multi-page progress bar markup.
 *
 * @since 2.0
 *
 * @param string $progress_bar         Progress bar markup as an HTML string.
 * @param array  $form                 Current form object.
 * @param string $confirmation_message The confirmation message to be displayed
 *                                     on the confirmation page.
 *
 * @see   https://docs.gravityforms.com/gform_progress_bar/
 */

function progress_bar($progress_bar, $form, $confirmation_message) {

	$progress_bar = rwp_html2($progress_bar);

	$progress_bar->filter('.gf_progressbar')->addClass('progress');
	$progress_bar->filter('.gf_progressbar_percentage')->addClass('progress-bar');


	return $progress_bar->saveHTML();
}
if (in_array('bootstrap-markup', $options)) {
	add_filter('gform_progress_bar', __NAMESPACE__ . '\\progress_bar', 30, 3);
}


/**
 * Update the validation message html
 *
 * Updates the validation message to use Bootstrap alert styles, adds list of
 * fields that failed validation and anchor links to those fields
 *
 * @param string $message  The validation message to be filtered.
 * @param array  $form     Current form object.
 *
 * @return string
 *
 * @see https://docs.gravityforms.com/gform_validation_message/
 */
function validation_message($message, $form) {

	if (gf_upgrade()->get_submissions_block()) {
		return $message;
	}

	$message = str_replace('h2', 'div', $message);

	$message = rwp_html2($message);

	$message->addClass('alert alert-danger');

	$message_errors = rwp_htmllist(array(
		'atts' => array(
			'tag' => 'ol',
			'class' => array(
				'gform_errors'
			)
		)
	));

	foreach ($form['fields'] as $field) {
		if ($field->failed_validation) {
			$field_id = 'field_' . $form['id'] . '_' . $field->id;
			$message_error = wp_sprintf('<a href="#%s" class="alert-link">%s</a> - %s', $field_id, GFCommon::get_label($field), $field->validation_message);
			$message_errors->addItem($message_error);
		}
	}

	$message_errors = $message_errors->__toString();

	$message->append($message_errors);

	return $message->saveHTML();
}

add_filter('gform_validation_message', __NAMESPACE__ . '\\validation_message', 20, 2);

/**
 * Use state abbreviation
 *
 * Use the two letter state code as the choice display and the full name as
 * the submitted value.
 *
 * @param array $states The array of states
 *
 * @return array
 *
 * @see https://docs.gravityforms.com/gform_us_states/#1-use-state-code
 */

function use_state_abbreviations($states) {
	/**
	 * @var GF_Field_Address $address
	 */
	$address = GF_Fields::get('address');

	$state_codes = array();
	foreach ($states as $state) {
		$state_codes[$state] = $address->get_us_state_code($state);
	}

	return $state_codes;
}

add_filter('gform_us_states', __NAMESPACE__ . '\\use_state_abbreviations');

/**
 * Update field content
 *
 * Updates field content with Bootstrap classes and autocomplete
 *
 * @param string     $field_content  The field content to be filtered.
 * @param \GF_Field  $field          The field that this input tag applies to.
 * @param string     $value          The default/initial value that the field
 *                                   should be pre-populated with.
 * @param int        $entry_id       When executed from the entry detail screen,
 *                                   $entry_id will be populated with the Entry
 *                                   ID. Otherwise, it will be 0.
 * @param int        $form_id        The current Form ID.
 *
 * @return string
 *
 * @see https://docs.gravityforms.com/gform_field_content/
 */

function field_content($field_content, $field, $value, $entry_id, $form_id) {

	$is_error = '';

	$field_input = rwp_html2($field_content);

	$form = GFAPI::get_form($form_id);



	if (rwp_string_has($field->cssClass, 'use-select2')) {
		$input_id = $field_input->filter('select')->getAttribute('id');
		$field_input->filter('select')->addClass('select2')->setAttribute('data-dropdown-parent', '#' . $input_id . '_container')->setAttribute('data-theme', 'bootstrap4');


		$parent = $field_input->filter('#' . $input_id)->closest('.ginput_container_select');
		if (!empty($parent)) {
			$field_input->filter('#' . $input_id)->closest('.ginput_container_select')->setAttribute('id', $input_id . '_container');
		}
	}

	$field_input->filter('div.validation_message')->addClass('invalid-feedback d-block');

	$field_input->filter('div.ginput_complex')->addClass('form-row flex-wrap');

	$field_input->filter('div.ginput_complex > span')->addClass('col col-md-auto flex-fill');
	$field_input->filter('input:not([type="hidden"]):not([type="radio"]):not([type="checkbox"]):not([type="file"])')->addClass('form-control');
	$field_input->filter('textarea')->addClass('form-control');

	$field_input->filter('input.gfield-choice-input')->addClass('custom-control-input');

	$field_input->filter('div.gchoice label')->addClass('custom-control-label');

	$field_input->filter('select')->addClass('custom-select');
	$field_input->filter('button')->addClass('btn');

	$field_input->filter('.gfield_description')->addClass('form-text');

	switch ($field->size) {
		case 'small':
			$field_input->filter('.small.form-control')->removeClass('small')->addClass('form-control-sm');
			$field_input->filter('.small.custom-select')->removeClass('small')->addClass('custom-select-sm');
			break;

		case 'large':
			$field_input->filter('.large.form-control')->removeClass('large')->addClass('form-control-lg');
			$field_input->filter('.large.custom-select')->removeClass('large')->addClass('custom-select-lg');
			break;

		default:
			$field_input->filter('.medium')->removeClass('medium');
			break;
	}

	switch ($field->type) {
		case 'address':
			if ($field_input->filter('.ginput_complex')->hasClass('has_street2')) {
				$field_input->filter('.address_line_1 input')->setAttribute('autocomplete', 'address-line1');
			} else {
				$field_input->filter('.address_line_1 input')->setAttribute('autocomplete', 'street-address');
			}
			$field_input->filter('.address_line_2')->removeClass('flex-fill');
			$field_input->filter('.address_line_2 input')->setAttribute('autocomplete', 'address-line2');

			$field_input->filter('.address_city')->before('<span class="w-100 d-block"></span>');
			$field_input->filter('.address_city input')->setAttribute('autocomplete', 'address-level2');

			$field_input->filter('.address_state')->removeClass('flex-fill');

			$field_input->filter('.address_state *:not(label)')->setAttribute('autocomplete', 'address-level1');

			$field_input->filter('.address_zip')->removeClass('flex-fill');
			$field_input->filter('.address_zip input')->setAttribute('autocomplete', 'postal-code');

			$field_input->filter('.address_country select')->setAttribute('autocomplete', 'country');

			break;
		case 'select':
			$field_content = str_replace("gfield_select", "custom-select", $field_content);
			break;
		case 'email':
			$field_input->filter('input')->setAttribute('autocomplete', 'email');

			break;
		case 'phone':
			$field_input->filter('input')->setAttribute('autocomplete', 'tel');
			break;
		case 'name':
			if ($field_input->filter('.ginput_complex')->hasClass('gf_name_has_1')) {
				$field_input->filter('.name_first input')->setAttribute('autocomplete', 'name');
			} else {
				$field_input->filter('.name_first input')->setAttribute('autocomplete', 'given-name');
			}
			$field_input->filter('.name_prefix')->removeClass('flex-fill')->setAttribute('autocomplete', 'honorific-prefix');
			$field_input->filter('.name_prefix select')->setAttribute('autocomplete', 'honorific-prefix');

			$field_input->filter('.name_middle input')->setAttribute('autocomplete', 'additional-name');
			$field_input->filter('.name_last input')->setAttribute('autocomplete', 'family-name');
			$field_input->filter('.name_suffix')->removeClass('flex-fill');

			$field_input->filter('.name_suffix select')->setAttribute('autocomplete', 'honorific-suffix');
			break;
		case 'textarea':
			$field_content = str_replace("class='textarea", "class='form-control textarea$is_error", $field_content);
			break;
		case 'fileupload':
			$field_input->filter('input[type="file"]')->addClass('custom-file-input');
			$field_input->filter('.ginput_container_fileupload')->addClass('custom-file');
			$field_input->filter('.gform_fileupload_rules')->addClass('custom-file-label');
			break;
		case 'checkbox':
			$field_input->filter('div.gfield_checkbox .gchoice')->addClass('custom-control custom-checkbox');

			break;

		case 'radio':
			$field_input->filter('div.gfield_radio .gchoice')->addClass('custom-control custom-radio');

			break;
		case 'consent':

			$field_input->filter('.ginput_container_consent')->addClass('custom-control custom-checkbox');

			$field_input->filter('input[type="checkbox"]')->addClass('custom-control-input');

			$field_input->filter('.gfield_consent_label')->addClass('custom-control-label');

			break;

		case 'time':
			$field_input->filter('.ginput_complex')->removeClass('flex-wrap')->addClass('flex-nowrap align-items-center');
			$field_input->filter('.ginput_container_time')->addClass('col-auto');
			$field_input->filter('.hour_minute_colon')->addClass('col-auto p-0');
			break;
		case 'date':
			$field_input->filter('.datepicker')->addClass('form-control');
			break;
		case 'html':
			if (rwp_string_has($field->cssClass, 'inline-submit') && 'text' === $form['buttonType']) {
				$button = rwp_button(array(
					'text' => array(
						'content' => $form['buttonText']
					),
					'atts' => array(
						'tag' => 'button',
						'onclick' => "document.getElementById( 'gform_submit_button_$form_id' ).click();",
						'class' => array(
							'btn-block'
						)
					)
				))->__toString();

				$button = apply_filters('rwp_gravity_form_button_args', $button, $form);

				$button = apply_filters("gform_submit_button_$form_id", $button, $form);

				$field_input = rwp_html2('<div class="ginput_container ginput_submit">' . $button . '</div><style type="text/css">#gform_wrapper_' . $form_id . ' .gform_footer { visibility: hidden; position: absolute; left: -100vw; }</style>');
			}

			break;
		case 'list':
			$field_input->filter('.gfield_list_group')->addClass('input-group');
			$field_input->filter('.gfield_list_icons')->addClass('input-group-append');
			$button_classes = 'btn';
			$button_classes = apply_filters('rwp_gravity_forms_list_button_classes', $button_classes, $form);

			$field_input->filter('button')->addClass($button_classes)->wrapInner('<span class="btn-text screen-reader-text">')->append('<span class="btn-icon"><i aria-hidden="true" role="presentation"></i></span>');
			$field_input->filter('.gfield_list_cell')->addClass('form-control flex-fill');
			$field_input->filter('.add_list_item')->removeClass('add_list_item')->addClass('add-item');
			$field_input->filter('.delete_list_item')->removeClass('delete_list_item')->addClass('delete-item');

			$add_item_icon_classes = '';
			$add_item_icon_classes = apply_filters('rwp_gravity_forms_list_add_item_icon_classes', $add_item_icon_classes, $form);

			if (!empty($add_item_icon_classes)) {
				$field_input->filter('button.add-item i')->addClass($add_item_icon_classes);
			}

			$delete_item_icon_classes = '';
			$delete_item_icon_classes = apply_filters('rwp_gravity_forms_list_delete_item_icon_classes', $delete_item_icon_classes, $form);

			if (!empty($delete_item_icon_classes)) {
				$field_input->filter('button.delete-item i')->addClass($delete_item_icon_classes);
			}

			break;
	}

	if ($field->failed_validation) {
		$field_input->filter('input')->addClass('is-invalid');
	}

	$field_content = $field_input->saveHTML();

	return $field_content;
}

if (in_array('bootstrap-markup', $options)) {
	add_filter('gform_field_content', __NAMESPACE__ . '\\field_content', 20, 5);
}
