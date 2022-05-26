<?php

namespace ACFQuickEdit\Fields;

if ( ! defined( 'ABSPATH' ) )
	die('Nope.');

abstract class ChoiceField extends Field {

	/**
	 *	@inheritdoc
	 */
	public function render_column( $object_id ) {



		$output				= '';
		$is_multiple 		= ( isset( $this->acf_field['multiple'] ) && $this->acf_field['multiple'] ) || $this->acf_field['type'] === 'checkbox';
		$is_return_array	= 'array' === $this->acf_field['return_format'];

		/*
		$field_value = get_field( $this->acf_field['key'], $object_id );
		/*/
		$field_value = $this->get_value( $object_id );
		//*/

		if ( '' === $field_value ) {
			$field_value = [];
		}
		if ( is_string( $field_value ) || ( $is_return_array && isset( $field_value['value'] ) ) ) {
			$field_value = [ $field_value ];
		}

		$values = [];

		if ( empty( $field_value ) ) {
			$field_value = [];
		}
		if ( ! is_array( $field_value ) ) {
			$field_value = [ $field_value ];
		}

		foreach ( $field_value as $value ) {

			if ( $is_return_array ) {
				$values[] = sprintf('%s =&gt; %s', $value['value'], $value['label'] );
			} else {
				if ( isset( $this->acf_field['choices'][ $value ] ) ) {
					$value = $this->acf_field['choices'][ $value ];
				}
				$values[] = $value;
			}
		}

		if ( empty( $values ) ) {
			$output .= '<p>';
			$output .= __('(No value)', 'acf-quickedit-fields');
			$output .= '</p>';
		} else {
			$output .= sprintf( '<ol class="acf-qef-value-list" data-count-values="%d">', count( $values ) );
			foreach ( $values as $val ) {
				$output .= sprintf( '<li>%s</li>', acf_esc_html( $val ) ); //implode( __(', ', 'acf-quickedit-fields' ) , $values );
			}
			$output .= '</ol>';
		}
		return $output;

	}

	/**
	 *	@inheritdoc
	 */
	public function sanitize_value( $value, $context = 'db' ) {
		if ( is_array( $value ) ) {
			return $this->sanitize_strings_array( $value, $context );
		} else {
			return sanitize_text_field( $value );
		}
	}


}
