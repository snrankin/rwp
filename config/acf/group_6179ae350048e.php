<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6179ae350048e',
	'title' => 'Company Schema Information',
	'fields' => array(
		array(
			'key' => 'field_6179ae42eb176',
			'label' => 'Locations',
			'name' => 'locations',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'acfe_save_meta' => 0,
			'acfe_repeater_stylised_button' => 0,
			'collapsed' => 'field_6179aecfeb178',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add Location',
			'sub_fields' => array(
				array(
					'key' => 'field_6179aecfeb178',
					'label' => 'Location Name',
					'name' => 'label',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'default_value' => 'Main',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_6179aeb1eb177',
					'label' => 'Address',
					'name' => 'address',
					'type' => 'google_map',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'center_lat' => '',
					'center_lng' => '',
					'zoom' => '',
					'height' => '',
				),
				array(
					'key' => 'field_6179b6bc8808f',
					'label' => 'Unit Number',
					'name' => 'unit',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
				),
				array(
					'key' => 'field_6179aee8eb179',
					'label' => 'Phone',
					'name' => 'phone',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_6179aef6eb17a',
					'label' => 'Email',
					'name' => 'email',
					'type' => 'email',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
				),
				array(
					'key' => 'field_6179af02eb17b',
					'label' => 'Page Url',
					'name' => 'page_url',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'return_format' => 'array',
					'show_column' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
				),
				array(
					'key' => 'field_6179b33a284ef',
					'label' => 'Map Url',
					'name' => 'map_url',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'return_format' => 'array',
					'show_column' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
				),
				array(
					'key' => 'field_6179f9f084d2a',
					'label' => 'Main Location',
					'name' => 'main_location',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
			),
		),
		array(
			'key' => 'field_6179f7715bdff',
			'label' => 'Company Info',
			'name' => 'company_info',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'acfe_seamless_style' => 0,
			'acfe_group_modal' => 0,
			'sub_fields' => array(
				array(
					'key' => 'field_6179f6f49fcb2',
					'label' => 'Schema Type',
					'name' => 'schema_type',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'default_value' => 'LocalBusiness',
					'placeholder' => '',
					'prepend' => 'https://schema.org/',
					'append' => '',
					'maxlength' => '',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'rwp-company-info',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'acfe_display_title' => '',
	'acfe_autosync' => array(
		0 => 'php',
	),
	'acfe_form' => 0,
	'acfe_meta' => '',
	'acfe_note' => '',
	'acfe_categories' => array(
		'plugin' => 'Plugin',
	),
	'modified' => 1635383836,
));

endif;