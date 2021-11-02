<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_rwp_company_info',
	'title' => 'Company Schema Information',
	'fields' => array(
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
				'class' => 'acfe-seamless-style',
				'id' => '',
			),
			'acfe_save_meta' => 0,
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
						'class' => 'border-0',
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
				'class' => 'label-lg',
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
					'key' => 'field_617eefb4a69af',
					'label' => '(Column 6/12)',
					'name' => '',
					'type' => 'acfe_column',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'columns' => '6/12',
					'endpoint' => 0,
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
					'acfe_save_meta' => 0,
					'center_lat' => '',
					'center_lng' => '',
					'zoom' => '',
					'height' => '',
				),
				array(
					'key' => 'field_617eefcda69b0',
					'label' => '(Column 6/12)',
					'name' => '',
					'type' => 'acfe_column',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'columns' => '6/12',
					'endpoint' => 0,
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
						'class' => 'col-md-auto flex-fill',
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
					'key' => 'field_617efeb141c6e',
					'label' => '(Column 12/12)',
					'name' => '',
					'type' => 'acfe_column',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'columns' => '12/12',
					'endpoint' => 0,
				),
				array(
					'key' => 'field_617efebe41c6f',
					'label' => 'Operating Hours',
					'name' => 'schedules',
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
					'collapsed' => 'field_617efee041c70',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_617efee041c70',
							'label' => 'Label',
							'name' => 'label',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'col-md auto flex-fill',
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
							'key' => 'field_617effdd41c76',
							'label' => 'Add to Schema',
							'name' => 'add_to_schema',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'col-md-auto',
								'id' => '',
							),
							'acfe_save_meta' => 0,
							'message' => '',
							'default_value' => 0,
							'ui' => 1,
							'ui_on_text' => '',
							'ui_off_text' => '',
							'show_column' => 0,
							'show_column_sortable' => 0,
							'show_column_weight' => 1000,
							'allow_quickedit' => 0,
							'allow_bulkedit' => 0,
						),
						array(
							'key' => 'field_617f031d7394d',
							'label' => 'Hours',
							'name' => 'hours',
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
							'collapsed' => '',
							'min' => 0,
							'max' => 0,
							'layout' => 'block',
							'button_label' => 'Add Hours',
							'sub_fields' => array(
								array(
									'key' => 'field_617f047e07b9c',
									'label' => 'Type',
									'name' => 'type',
									'type' => 'button_group',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => 'col-md-auto',
										'id' => '',
									),
									'choices' => array(
										'opened' => 'Open',
										'closed' => 'Closed',
									),
									'allow_null' => 0,
									'default_value' => '',
									'layout' => 'horizontal',
									'return_format' => 'value',
								),
								array(
									'key' => 'field_617f043907b9b',
									'label' => 'Days',
									'name' => 'days',
									'type' => 'checkbox',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => 'col-md-auto flex-fill',
										'id' => '',
									),
									'acfe_save_meta' => 0,
									'choices' => array(
										'Monday' => 'Monday',
										'Tuesday' => 'Tuesday',
										'Wednesday' => 'Wednesday',
										'Thursday' => 'Thursday',
										'Friday' => 'Friday',
										'Saturday' => 'Saturday',
										'Sunday' => 'Sunday',
									),
									'allow_custom' => 0,
									'default_value' => array(
									),
									'layout' => 'horizontal',
									'toggle' => 1,
									'return_format' => 'value',
									'show_column' => 0,
									'show_column_weight' => 1000,
									'allow_quickedit' => 0,
									'allow_bulkedit' => 0,
									'save_custom' => 0,
								),
								array(
									'key' => 'field_617f041307b9a',
									'label' => 'All Day',
									'name' => 'all_day',
									'type' => 'true_false',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => 'col-md-auto',
										'id' => '',
									),
									'message' => '',
									'default_value' => 0,
									'ui' => 1,
									'ui_on_text' => '',
									'ui_off_text' => '',
								),
								array(
									'key' => 'field_617f03c907b97',
									'label' => 'Times',
									'name' => 'times',
									'type' => 'group',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_617f041307b9a',
												'operator' => '!=',
												'value' => '1',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => 'label-none col-md-auto flex-fill',
										'id' => '',
									),
									'acfe_save_meta' => 0,
									'layout' => 'block',
									'acfe_seamless_style' => 1,
									'acfe_group_modal' => 0,
									'sub_fields' => array(
										array(
											'key' => 'field_617f03d907b98',
											'label' => 'Start',
											'name' => 'start',
											'type' => 'time_picker',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => 'col-md-6',
												'id' => '',
											),
											'display_format' => 'g:i a',
											'return_format' => 'g:i a',
										),
										array(
											'key' => 'field_617f03f907b99',
											'label' => 'End',
											'name' => 'end',
											'type' => 'time_picker',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => 'col-md-6',
												'id' => '',
											),
											'display_format' => 'g:i a',
											'return_format' => 'g:i a',
										),
									),
								),
							),
						),
					),
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
	'modified' => 1635715344,
));

endif;