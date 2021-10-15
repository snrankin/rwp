<?php
/** ============================================================================
 * Gravity Forms Integration
 *
 * @package   RWP\/includes/integrations/GravityForms.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;
use GFAPI;
use GF_Fields;
use GF_Field_Address;
use GFCommon;
use RWP\Components\Button;

/**
 * Fake Pages inside WordPress
 */
class GravityForms extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! is_plugin_active( 'gravityforms/gravityforms.php' ) || ! rwp_get_option( 'modules.bootstrap.gravityforms', false ) ) {
			return;
		}

		add_filter( 'gform_disable_form_theme_css', '__return_true' );
		add_action( 'gform_enqueue_scripts', array( $this, 'enqueue_gravity_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_gravity_styles' ) );

		rwp_add_filters(array(
			'gform_preview_styles',
			'gform_noconflict_styles',
		), array( $this, 'add_gravity_styles' ), 30, 2);

		rwp_add_filters(array(
			'gform_next_button',
			'gform_previous_button',
			'gform_submit_button',
		), array( $this, 'input_to_button' ), 30, 2);

		add_filter( 'gform_field_content', array( $this, 'field_content' ), 20, 5 );
		add_filter( 'gform_field_container', array( $this, 'field_container' ), 30, 6 );
		add_filter( 'gform_progress_bar', array( $this, 'progress_bar' ), 30, 3 );
		add_filter( 'gform_validation_message', array( $this, 'validation_message' ), 20, 2 );
		add_filter( 'gform_us_states', array( $this, 'use_state_abbreviations' ) );

	}

	/**
	 * Function to add gravity forms styles to front and backend
	 *
	 * @return void
	 *
	 * @see https://docs.gravityforms.com/gform_preview_styles/
	 */
	public function enqueue_gravity_styles() {
		if ( ! wp_style_is( 'rwp-gravity-forms', 'registered' ) ) {
			rwp()->register_assets( 'gravity-forms' );
		}

		rwp()->enqueue_assets( 'gravity-forms' );
	}

	/**
	 * Function to add gravity forms styles to front and backend
	 *
	 * @param array $styles Array of style handles to be enqueued.
	 * @param array $form Current form.
	 * @return array
	 *
	 * @see https://docs.gravityforms.com/gform_preview_styles/
	 */
	public function add_gravity_styles( $styles, $form = array() ) {

		$this->enqueue_gravity_styles();

		if ( ! is_array( $styles ) ) {
			$styles = array( 'rwp-gravity-forms' );
		} else {
			$styles[] = 'rwp-gravity-forms';
		}
		$styles[] = 'select2';

		return $styles;
	}


	/**
	* Function to change the quote types for string to match gravity forms
	*
	* @param mixed $string
	* @return string
	*/
	public static function gravity_forms_string_filter( $string ) {
		$string = trim( str_replace( '"', "'", $string ) );
		$string = str_replace( "\'", '"', $string );
		return $string;
	}

	/**
	 * Filters the next, previous and submit buttons.
	 *
	 * Replaces the forms <input> buttons with <button> while maintaining attributes
	 * from original <input>.
	 *
	 * @param string $button Contains the <input> tag to be filtered.
	 * @param array  $form Contains all the properties of the current form.
	 *
	 * @see https://docs.gravityforms.com/gform_submit_button/
	 *
	 * @return string The filtered button.
	 */

	public function input_to_button( $button, $form ) {

		$button = rwp_input_to_button( $button );

		if ( $button instanceof Button ) {
			$onclick = $button->get_attr( 'onclick' );

			$pattern = '/(.*(?=return false\;))(return false\;)(.*(?=\=true\;)\=true\;)(.*)/m';
			$add_class = 'jQuery(this).addClass(\'submitting\');';
			$remove_class = 'jQuery(this).removeClass(\'submitting\');';

			if ( ! empty( $onclick ) ) {

				$onclick = preg_replace( $pattern, "$1$2$remove_class$3$add_class$4", $onclick );

				$button->set_attr( 'onclick', $onclick, true );
			}
			$onkeypress = $button->get_attr( 'onkeypress' );
			if ( ! empty( $onkeypress ) ) {

				$onkeypress = preg_replace( $pattern, "$1$2$remove_class$3$add_class$4", $onkeypress );

				$button->set_attr( 'onkeypress', $onkeypress, true );
			}

			$button->order[] = 'spinner';

			$button->set_content( '<span class="btn-icon icon-right has-spinner"><span class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></span></span>', 'spinner' );

			/**
			 * Allow filtering of Gravity Form Buttons
			 *
			 * Provides a filter for all gravity form buttons. Should return an
			 * updated Button object.
			 *
			 * @since 1.0.0
			 *
			 * @param Button  $button  The button object
			 * @param array   $form    Contains all the properties of the current
			 *                         Gravity form.
			 *
			 * @return Button
			 */

			$button = apply_filters( 'rwp_gravity_form_button', $button, $form );

			/**
			 * @var Button $button
			 */

			$button = $button->html();
		}

		$button = self::gravity_forms_string_filter( $button );

		return $button;
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
	public function field_container( $field_container, $field, $form, $css_class, $style, $field_content ) {

		$field_container_html = rwp_html( $field_container );

		if ( $field_container_html->hasClass( 'gfield_error' ) ) {
			$field_container_html->addClass( 'is-invalid' );
		}

		$field_container = $field_container_html->__toString();

		return $field_container;
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

	public function progress_bar( $progress_bar, $form, $confirmation_message ) {

		$progress_bar = rwp_html( $progress_bar );

		$progress_bar->filter( '.gf_progressbar' )->addClass( 'progress' );
		$progress_bar->filter( '.gf_progressbar_percentage' )->addClass( 'progress-bar' );

		return $progress_bar->saveHTML();
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
	public function validation_message( $message, $form ) {

		if ( gf_upgrade()->get_submissions_block() ) {
			return $message;
		}

		if ( $form['validationSummary'] ) {
			$message = str_replace( 'h2', 'div', $message );

			$message = rwp_html( $message );

			$message->wrapInner( '<h3></h3>' );

			$message->addClass( 'alert alert-danger' );

			$message_errors = rwp_list(array(
				'tag' => 'ol',
				'atts' => array(
					'class' => array(
						'gform_errors',
					),
				),
			));

			$failed_fields = wp_filter_object_list( $form['fields'], array( 'failed_validation' => true ) );

			foreach ( $failed_fields as $i => $field ) {
				if ( $field->failed_validation ) {
					$field_id = 'field_' . $form['id'] . '_' . $field->id;
					$message_error = wp_sprintf( '<span><a href="#%s" class="alert-link">%s</a> - %s</span>', $field_id, GFCommon::get_label( $field ), $field->validation_message );
					$message_error = array(
						'content' => array( $message_error ),
					);
					$message_errors->add_item( $message_error, $i, true );
				}
			}

			$message_errors = $message_errors->__toString();

			$message->append( $message_errors );

			$message = $message->saveHTML();
		} else {
			$message = '';
		}

		return $message;
	}


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

	public function use_state_abbreviations( $states ) {
		/**
		 * @var GF_Field_Address $address
		 */
		$address = GF_Fields::get( 'address' );

		$state_codes = array();
		foreach ( $states as $state ) {
			$state_codes[ $state ] = $address->get_us_state_code( $state );
		}

		return $state_codes;
	}


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

	public function field_content( $field_content, $field, $value, $entry_id, $form_id ) {

		$is_error = $field->failed_validation;

		$css_class = rwp_parse_classes( data_get( $field, 'cssClass', '' ) );

		$size = $field->size;
		$select2_size = "select2--$size";

		$field_input = rwp_html( $field_content );

		$form = GFAPI::get_form( $form_id );

		$form_class = rwp_parse_classes( data_get( $form, 'cssClass', '' ) );

		if ( in_array( 'use-select2', $css_class ) ) {

			$input_id = $field_input->filter( 'select' )->getAttribute( 'id' );
			$field_input->filter( '#' . $input_id )->addClass( 'select2' )->setAttribute( 'data-dropdown-parent', '#' . $input_id . '_container' )->setAttribute( 'data-theme', 'bootstrap-5' )->setAttribute( 'data-selection-css-class', $select2_size )->setAttribute( 'data-dropdown-css-class', $select2_size );

			$field_input->filter( 'select' )->ancestors();

			$parent = $field_input->filter( '#' . $input_id )->ancestors()->first();
			if ( ! empty( $parent ) ) {
				$parent->setAttribute( 'id', $input_id . '_container' );
			}
		}

		$field_input->filter( 'div.validation_message' )->addClass( 'invalid-feedback d-block' );

		$field_input->filter( 'div.ginput_complex' )->addClass( 'row flex-wrap' );

		$field_input->filter( 'div.ginput_complex > span' )->addClass( 'col col-md-auto flex-fill' );
		$field_input->filter( 'input:not([type="hidden"]):not([type="radio"]):not([type="checkbox"])' )->addClass( 'form-control' );
		$field_input->filter( 'textarea' )->addClass( 'form-control' );

		$field_input->filter( 'input[type="checkbox"]' )->addClass( 'form-check-input' );
		$field_input->filter( 'input[type="radio"]' )->addClass( 'form-check-input' );
		$field_input->filter( 'div.gchoice label' )->addClass( 'form-check-label' );

		$field_input->filter( 'select' )->addClass( 'form-select' );
		$field_input->filter( 'button' )->addClass( 'btn' );

		$field_input->filter( '.gfield_description' )->addClass( 'form-text' );

		$field_input->filter( '.gfield_label' )->addClass( 'form-label' );

		if ( in_array( 'medium', $css_class ) ) {
			$field->size = 'medium';
		}

		switch ( $field->size ) {
			case 'small':
				$field_input->filter( '.small.form-control' )->removeClass( 'small' )->addClass( 'form-control-sm' );
				$field_input->filter( '.small.form-select' )->removeClass( 'small' )->addClass( 'form-select-sm' );
				break;

			case 'large':
				$field_input->filter( '.large.form-control' )->removeClass( 'large' )->addClass( 'form-control-lg' );
				$field_input->filter( '.large.form-select' )->removeClass( 'large' )->addClass( 'form-select-lg' );
				break;

			default:
				$field_input->filter( '.medium' )->removeClass( 'medium' );
				$field_input->filter( '.small.form-control' )->removeClass( 'small' )->addClass( 'form-control' );
				$field_input->filter( '.form-control-sm' )->removeClass( 'form-control-sm' )->addClass( 'form-control' );
				$field_input->filter( '.large.form-control' )->removeClass( 'large' )->addClass( 'form-control' );
				$field_input->filter( '.form-control-lg' )->removeClass( 'form-control-lg' )->addClass( 'form-control' );
				break;
		}

		if ( in_array( 'medium', $css_class ) ) {
			$field_input->filter( '.small.form-control' )->removeClass( 'small' )->addClass( 'form-control' );
			$field_input->filter( '.form-control-sm' )->removeClass( 'form-control-sm' )->addClass( 'form-control' );
			$field_input->filter( '.large.form-control' )->removeClass( 'large' )->addClass( 'form-control' );
			$field_input->filter( '.form-control-lg' )->removeClass( 'form-control-lg' )->addClass( 'form-control' );
		}

		switch ( $field->type ) {
			case 'address':
				if ( $field_input->filter( '.ginput_complex' )->hasClass( 'has_street2' ) ) {
					$field_input->filter( '.address_line_1 input' )->setAttribute( 'autocomplete', 'address-line1' );
				} else {
					$field_input->filter( '.address_line_1 input' )->setAttribute( 'autocomplete', 'street-address' );
				}
				$field_input->filter( '.address_line_2' )->removeClass( 'flex-fill' );
				$field_input->filter( '.address_line_2 input' )->setAttribute( 'autocomplete', 'address-line2' );

				$field_input->filter( '.address_city' )->before( '<span class="w-100 d-block"></span>' );
				$field_input->filter( '.address_city input' )->setAttribute( 'autocomplete', 'address-level2' );

				$field_input->filter( '.address_state' )->removeClass( 'flex-fill' );

				$field_input->filter( '.address_state *:not(label):not(option)' )->setAttribute( 'autocomplete', 'address-level1' );

				$field_input->filter( '.address_zip' )->removeClass( 'flex-fill' );
				$field_input->filter( '.address_zip input' )->setAttribute( 'autocomplete', 'postal-code' );

				$field_input->filter( '.address_country select' )->setAttribute( 'autocomplete', 'country' );

				break;
			case 'email':
				$field_input->filter( 'input' )->setAttribute( 'autocomplete', 'email' );
				break;
			case 'phone':
				$field_input->filter( 'input' )->setAttribute( 'autocomplete', 'tel' );
				break;
			case 'name':
				if ( $field_input->filter( '.ginput_complex' )->hasClass( 'gf_name_has_1' ) ) {
					$field_input->filter( '.name_first input' )->setAttribute( 'autocomplete', 'name' );
				} else {
					$field_input->filter( '.name_first input' )->setAttribute( 'autocomplete', 'given-name' );
				}
				$field_input->filter( '.name_prefix' )->removeClass( 'flex-fill' )->setAttribute( 'autocomplete', 'honorific-prefix' );
				$field_input->filter( '.name_prefix select' )->setAttribute( 'autocomplete', 'honorific-prefix' );

				$field_input->filter( '.name_middle input' )->setAttribute( 'autocomplete', 'additional-name' );
				$field_input->filter( '.name_last input' )->setAttribute( 'autocomplete', 'family-name' );
				$field_input->filter( '.name_suffix' )->removeClass( 'flex-fill' );

				$field_input->filter( '.name_suffix select' )->setAttribute( 'autocomplete', 'honorific-suffix' );
				break;
			case 'textarea':
				$field_content = str_replace( "class='textarea", "class='form-control textarea$is_error", $field_content );
				break;
			case 'fileupload':
				$field_input->filter( 'input[type="file"]' )->addClass( 'form-control' );
				$field_input->filter( '.ginput_container_fileupload' )->addClass( 'custom-file' );
				$field_input->filter( '.gform_fileupload_rules' )->addClass( 'form-label' );
				break;
			case 'checkbox':
			case 'radio':
				$field_input->filter( '.gchoice' )->addClass( 'form-check' );

				break;
			case 'consent':
				$field_input->filter( '.ginput_container_consent' )->addClass( 'form-check' );

				$field_input->filter( 'input[type="checkbox"]' )->addClass( 'form-check-input' );

				$field_input->filter( '.gfield_consent_label' )->addClass( 'form-check-label' );

				break;

			case 'time':
				$field_input->filter( '.ginput_complex' )->removeClass( 'flex-wrap' )->addClass( 'flex-nowrap align-items-center' );
				$field_input->filter( '.ginput_container_time' )->addClass( 'col-auto' );
				$field_input->filter( '.hour_minute_colon' )->addClass( 'col-auto p-0' );
				break;
			case 'date':
				$field_input->filter( '.datepicker' )->addClass( 'form-control' );
				break;
			case 'list':
				$field_input->filter( '.gfield_list_group' )->addClass( 'input-group' );

				$button_classes = 'btn btn-primary';
				$button_classes = apply_filters( 'rwp_gravity_forms_list_button_classes', $button_classes, $form );

				$field_input->filter( 'button' )->addClass( $button_classes )->wrapInner( '<span class="btn-text screen-reader-text">' );
				$field_input->filter( 'button' )->append( '<span class="btn-icon"><i aria-hidden="true" role="presentation"></i></span>' );
				$field_input->filter( '.gfield_list_cell' )->addClass( 'form-control flex-fill' );

				$add_item_icon_classes = '';
				$add_item_icon_classes = apply_filters( 'rwp_gravity_forms_list_add_item_icon_classes', $add_item_icon_classes, $form );

				if ( ! empty( $add_item_icon_classes ) ) {
					$field_input->filter( 'button.add-item i' )->addClass( $add_item_icon_classes );
				}

				$delete_item_icon_classes = '';
				$delete_item_icon_classes = apply_filters( 'rwp_gravity_forms_list_delete_item_icon_classes', $delete_item_icon_classes, $form );

				if ( ! empty( $delete_item_icon_classes ) ) {
					$field_input->filter( 'button.delete-item i' )->addClass( $delete_item_icon_classes );
				}

				$field_input->filter( '.gfield_list_icons' )->unwrapInner();

				break;
		}

		if ( $field->failed_validation ) {
			$field_input->filter( 'select' )->addClass( 'is-invalid' );
			$field_input->filter( 'textarea' )->addClass( 'is-invalid' );
			$field_input->filter( 'input' )->addClass( 'is-invalid' );
		}

		if ( in_array( 'form-floating', $form_class, true ) || in_array( 'form-floating', $css_class, true ) ) {
			$label = $field_input->filter( 'label' )->makeClone();
			$label = $label->getNode( 0 );
			$field_input = $field_input->removeElementByTag( 'label' );

			$field_input->filter( '.ginput_container' )->addClass( 'form-floating' )->append( $label );
		}

		$field_input = $field_input->saveHTML();

		$field_input = self::gravity_forms_string_filter( $field_input );

		$field_content = $field_input;

		return $field_content;
	}
}
