<?php

namespace ACFQuickEdit\Fields;

if ( ! defined( 'ABSPATH' ) )
	die('Nope.');

class CheckboxField extends ChoiceField {


	/**
	 *	@inheritdoc
	 */
	public function render_input( $input_atts, $is_quickedit = true ) {
		$output = '';

		// populate $_POST if nothing is selected
		// in bulk this breaks the 'do-not-change' checkbox
		if ( $is_quickedit ) {
			$output .= sprintf( '<input %s />', acf_esc_attr( [
				'type'					=> 'hidden',
				'name'					=> $input_atts['name'],
			] ) );
		}

		$output .= sprintf( '<ul class="acf-checkbox-list" data-acf-field-key="%s">', sanitize_key( $this->acf_field['key'] ) );

		if ( $this->acf_field['toggle'] ) {
			$output .= sprintf( '<li><label><input %s/>%s</label></li>', acf_esc_attr( [
				'class' => 'acf-checkbox-toggle',
				'type' => 'checkbox',
			] ), esc_html__( ' Toggle All', 'acf-quickedit-fields' ) );
		}


		$input_atts		+= [
			'class'	=> 'acf-quick-edit',
			'id'	=> $this->core->prefix( $this->acf_field['key'] ),
		];
		$this->acf_field['value']	= acf_get_array( $this->acf_field['value'], false );

		$field_name = $input_atts['name'] . '[]';

		foreach ( $this->acf_field['choices'] as $value => $label ) {
			$atts = [
				'data-acf-field-key'	=> $this->acf_field['key'],
				'type'					=> 'checkbox',
				'value'					=> $value,
				'name'					=> $field_name,
				'id'					=> $this->core->prefix( $this->acf_field['key'] . '-'.$value ),
			];
			if ( ! $is_quickedit ) {
				$atts['disabled'] = 'disabled';
			}

			if ( in_array( $value, $this->acf_field['value'] ) ) {
				$atts['checked'] = 'checked';
			}
			$output .= sprintf( '<li><label><input %s/>%s</label></li>', acf_esc_attr( $atts ), acf_esc_html( $label ) );
		}

		$output .= '</ul>';

		if ( $this->acf_field['allow_custom'] ) {
			$output .= '<button class="button button-seconday add-choice">' . __('Add Choice','acf-quickedit-fields') . '</button>';
			$output .= sprintf( '<script type="text/html" id="tmpl-acf-qef-custom-choice-%s">', $this->acf_field['key'] );

			$id = $this->core->prefix( $this->acf_field['key'] . '-other' );

			$output .= '<li><label>';
			$output .= sprintf( '<input %s />', acf_esc_attr( [
				'type'					=> 'checkbox',
				'class'					=> 'acf-quick-edit custom',
				'checked'				=> 'checked',
			] ) );
			$output .= sprintf( '<input %s />', acf_esc_attr( [
				'type'					=> 'text',
				'class'					=> 'acf-quick-edit',
				'data-acf-field-key'	=> $this->acf_field['key'],
				'name'					=> $field_name,
				'style'					=> 'width:initial',
			] ) );

			$output .= '</label></li>';

			$output .= '</script>';
		}

		return $output;
	}


}
