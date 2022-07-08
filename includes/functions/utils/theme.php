<?php
/**
 * ============================================================================
 * theme
 *
 * @package   RWP\/includes/functions/utils/theme.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ==========================================================================
 */
use RWP\Components\Html;


/**
 * Get a search form with custom arguments
 *
 * @param string $form
 * @param array $args
 * @return string
 * @throws Exception
 * @throws RuntimeException
 */

function rwp_search_form( $form = '', $args = array() ) {

	if ( empty( $form ) ) {
		$form = get_search_form(
			array(
				'echo' => 0,
			)
		);
	}

	$content = $form;

	$form = rwp_html( $form );

	$floating = data_get( $args, 'floating', true );

	$label = $form->filter( 'label' )->text( '' );

	// if ( empty( $label ) ) {
	// 	return $content;
	// }

	$label = rwp_element( '<label class="form-label" for="s">' . $label . '</label>' );

	$label_args = data_get( $args, 'label', array() );

	$label->merge_args( $label_args );

	$input = $form->filter( 'input.search-field' )->addClass( 'form-control' )->saveHTML();

	$input = rwp_element( $input );

	$input_args = data_get( $args, 'input', array() );

	$input->merge_args( $input_args );

	$btn_args = data_get( $args, 'button' );

	$btn_icon = rwp_collection( data_get( $args, 'button.icon' ) );

	if ( $btn_icon->isNotEmpty() ) {
		$btn_icon = rwp_get_icon_from_acf( $btn_icon );
		$btn_args['icon'] = $btn_icon;
	}

	$btn_args = apply_filters( 'rwp_search_form_btn_args', $btn_args );

	$btn = $form->filter( '[type="submit"]' )->saveHTML();

	if ( rwp_str_is_element( $btn, 'input' ) ) {
		$btn = rwp_input_to_button( $btn, 'input.search-submit', $btn_args );
	} else {
		$btn = rwp_button( $btn );
		$btn->merge_args( $btn_args );
		$btn = $btn->html();
	}

	$input_wrapper_defaults = array(
		'tag' => 'div',
		'atts' => array(
			'class' => array(
				'form-input-wrap',
			),
		),
	);

	$input_wrapper_args = data_get( $args, 'input_wrapper', array() );

	$input_wrapper_args = rwp_merge_args( $input_wrapper_defaults, $input_wrapper_args );

	$input_wrapper = rwp_element( $input_wrapper_args );

	$input_wrapper->set_content( $label->html(), 'label' );

	$input_wrapper->set_content( $input->html(), 'input' );

	if ( $floating ) {
		$input_wrapper->order = array( 'input', 'label' );

		$input_wrapper->add_class( 'form-floating' );
	}

	$default_form_args = Html::extractAllAtts( $form, true );

	$form_args = data_get( $args, 'form', array() );

	$form_args = rwp_merge_args( $default_form_args, $form_args );

	$form = rwp_element( $form_args );

	$form->set_content( $input_wrapper->html() );

	$form->set_content( $btn );

	/**
	* Filters the search form output
	*
	* Should return an Html class
	*
	* @var Element $form
	*/
	$form = apply_filters( 'rwp_search_form_html', $form );

	/**
	* @var Element $form
	*/

	return $form->html();

}
