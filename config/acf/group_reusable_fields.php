<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_reusable_fields',
	'title' => 'Reusable Fields',
	'fields' => array(
		array(
			'key' => 'field_61772ca5bb3c1',
			'label' => 'Background Color',
			'name' => 'background_color',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_save_meta' => 0,
			'layout' => 'block',
			'acfe_seamless_style' => 1,
			'acfe_group_modal' => 0,
			'acfe_settings' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_61772cbfbb3c2',
					'label' => 'Background Color',
					'name' => 'bs_class',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'label-none',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'choices' => array(
						'bg-primary' => 'Primary',
						'bg-secondary' => 'Secondary',
						'bg-success' => 'Success',
						'bg-info' => 'Info',
						'bg-warning' => 'Warning',
						'bg-danger' => 'Danger',
						'bg-light' => 'Light',
						'bg-dark' => 'Dark',
						'bg-blue' => 'Blue',
						'bg-indigo' => 'Indigo',
						'bg-purple' => 'Purple',
						'bg-pink' => 'Pink',
						'bg-red' => 'Red',
						'bg-orange' => 'Orange',
						'bg-yellow' => 'Yellow',
						'bg-green' => 'Green',
						'bg-teal' => 'Teal',
						'bg-cyan' => 'Cyan',
						'bg-white' => 'White',
						'bg-black' => 'Black',
						'bg-gray' => 'Gray',
						'custom' => 'Custom',
					),
					'default_value' => false,
					'allow_null' => 1,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'allow_custom' => 0,
					'placeholder' => '',
					'search_placeholder' => '',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61772cf0bb3c3',
					'label' => 'Custom Background Color',
					'name' => 'custom',
					'type' => 'color_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61772cbfbb3c2',
								'operator' => '==',
								'value' => 'custom',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => 'label-none',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'default_value' => '',
					'enable_opacity' => 1,
					'return_format' => 'string',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
			),
		),
		array(
			'key' => 'field_61acfe12f7a57',
			'label' => 'Border Color',
			'name' => 'border_color',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_save_meta' => 0,
			'layout' => 'block',
			'acfe_seamless_style' => 1,
			'acfe_group_modal' => 0,
			'acfe_settings' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_61acfe12f7a58',
					'label' => 'Border Color',
					'name' => 'bs_class',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'label-none',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'choices' => array(
						'border-primary' => 'Primary',
						'border-secondary' => 'Secondary',
						'border-success' => 'Success',
						'border-info' => 'Info',
						'border-warning' => 'Warning',
						'border-danger' => 'Danger',
						'border-light' => 'Light',
						'border-dark' => 'Dark',
						'border-blue' => 'Blue',
						'border-indigo' => 'Indigo',
						'border-purple' => 'Purple',
						'border-pink' => 'Pink',
						'border-red' => 'Red',
						'border-orange' => 'Orange',
						'border-yellow' => 'Yellow',
						'border-green' => 'Green',
						'border-teal' => 'Teal',
						'border-cyan' => 'Cyan',
						'border-white' => 'White',
						'border-black' => 'Black',
						'border-gray' => 'Gray',
						'custom' => 'Custom',
					),
					'default_value' => false,
					'allow_null' => 1,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'allow_custom' => 0,
					'placeholder' => '',
					'search_placeholder' => '',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61acfe12f7a59',
					'label' => 'Custom Border Color',
					'name' => 'custom',
					'type' => 'color_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61acfe12f7a58',
								'operator' => '==',
								'value' => 'custom',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => 'label-none',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'default_value' => '',
					'enable_opacity' => 1,
					'return_format' => 'string',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
			),
		),
		array(
			'key' => 'field_61acfdb9f7a54',
			'label' => 'Text Color',
			'name' => 'text_color',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_save_meta' => 0,
			'layout' => 'block',
			'acfe_seamless_style' => 1,
			'acfe_group_modal' => 0,
			'acfe_settings' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_61acfdb9f7a55',
					'label' => 'Text Color',
					'name' => 'bs_class',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'label-none',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'choices' => array(
						'text-primary' => 'Primary',
						'text-secondary' => 'Secondary',
						'text-success' => 'Success',
						'text-info' => 'Info',
						'text-warning' => 'Warning',
						'text-danger' => 'Danger',
						'text-light' => 'Light',
						'text-dark' => 'Dark',
						'text-blue' => 'Blue',
						'text-indigo' => 'Indigo',
						'text-purple' => 'Purple',
						'text-pink' => 'Pink',
						'text-red' => 'Red',
						'text-orange' => 'Orange',
						'text-yellow' => 'Yellow',
						'text-green' => 'Green',
						'text-teal' => 'Teal',
						'text-cyan' => 'Cyan',
						'text-white' => 'White',
						'text-black' => 'Black',
						'text-gray' => 'Gray',
						'custom' => 'Custom',
					),
					'default_value' => false,
					'allow_null' => 1,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'allow_custom' => 0,
					'placeholder' => '',
					'search_placeholder' => '',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61acfdb9f7a56',
					'label' => 'Custom Text Color',
					'name' => 'custom',
					'type' => 'color_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61acfdb9f7a55',
								'operator' => '==',
								'value' => 'custom',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => 'label-none',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'default_value' => '',
					'enable_opacity' => 1,
					'return_format' => 'string',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
			),
		),
		array(
			'key' => 'field_61940d5ca41f6',
			'label' => 'Icon',
			'name' => 'icon',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_save_meta' => 0,
			'layout' => 'block',
			'acfe_seamless_style' => 1,
			'acfe_group_modal' => 0,
			'acfe_settings' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_61940d6ea41f7',
					'label' => 'Type',
					'name' => 'type',
					'type' => 'button_group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'choices' => array(
						'icon' => 'Icon Font',
						'image' => 'Image',
						'svg' => 'SVG',
						'class' => 'Icon Class',
						'html' => 'Custom HTML',
					),
					'allow_null' => 1,
					'default_value' => 'icon : Icon Font',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61940dbda41f8',
					'label' => 'Image',
					'name' => 'src',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61940d6ea41f7',
								'operator' => '==',
								'value' => 'image',
							),
						),
						array(
							array(
								'field' => 'field_61940d6ea41f7',
								'operator' => '==',
								'value' => 'svg',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'uploader' => '',
					'acfe_thumbnail' => 0,
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'show_column' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
					'library' => 'all',
				),
				array(
					'key' => 'field_6194424409883',
					'label' => 'Class',
					'name' => 'class',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61940d6ea41f7',
								'operator' => '==',
								'value' => 'class',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
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
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_6194426009884',
					'label' => 'Custom Html',
					'name' => 'content',
					'type' => 'acfe_code_editor',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61940d6ea41f7',
								'operator' => '==',
								'value' => 'html',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'default_value' => '',
					'placeholder' => '',
					'mode' => 'text/html',
					'lines' => 1,
					'indent_unit' => 4,
					'maxlength' => '',
					'rows' => 8,
					'max_rows' => '',
					'return_entities' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61a157d11fad6',
					'label' => 'Icon',
					'name' => 'icon',
					'type' => 'svg_icon',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61940d6ea41f7',
								'operator' => '==',
								'value' => 'icon',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
					'choices' => array(
						array(
							'ID' => '123',
						),
						'activity' => array(
							'ID' => 'activity',
						),
						'alarm' => array(
							'ID' => 'alarm',
						),
						'alarm-fill' => array(
							'ID' => 'alarm-fill',
						),
						'align-bottom' => array(
							'ID' => 'align-bottom',
						),
						'align-center' => array(
							'ID' => 'align-center',
						),
						'align-end' => array(
							'ID' => 'align-end',
						),
						'align-middle' => array(
							'ID' => 'align-middle',
						),
						'align-start' => array(
							'ID' => 'align-start',
						),
						'align-top' => array(
							'ID' => 'align-top',
						),
						'alt' => array(
							'ID' => 'alt',
						),
						'app' => array(
							'ID' => 'app',
						),
						'app-indicator' => array(
							'ID' => 'app-indicator',
						),
						'apple' => array(
							'ID' => 'apple',
						),
						'archive' => array(
							'ID' => 'archive',
						),
						'archive-fill' => array(
							'ID' => 'archive-fill',
						),
						'arrow-90deg-down' => array(
							'ID' => 'arrow-90deg-down',
						),
						'arrow-90deg-left' => array(
							'ID' => 'arrow-90deg-left',
						),
						'arrow-90deg-right' => array(
							'ID' => 'arrow-90deg-right',
						),
						'arrow-90deg-up' => array(
							'ID' => 'arrow-90deg-up',
						),
						'arrow-bar-down' => array(
							'ID' => 'arrow-bar-down',
						),
						'arrow-bar-left' => array(
							'ID' => 'arrow-bar-left',
						),
						'arrow-bar-right' => array(
							'ID' => 'arrow-bar-right',
						),
						'arrow-bar-up' => array(
							'ID' => 'arrow-bar-up',
						),
						'arrow-clockwise' => array(
							'ID' => 'arrow-clockwise',
						),
						'arrow-counterclockwise' => array(
							'ID' => 'arrow-counterclockwise',
						),
						'arrow-down' => array(
							'ID' => 'arrow-down',
						),
						'arrow-down-circle' => array(
							'ID' => 'arrow-down-circle',
						),
						'arrow-down-circle-fill' => array(
							'ID' => 'arrow-down-circle-fill',
						),
						'arrow-down-left' => array(
							'ID' => 'arrow-down-left',
						),
						'arrow-down-left-circle' => array(
							'ID' => 'arrow-down-left-circle',
						),
						'arrow-down-left-circle-fill' => array(
							'ID' => 'arrow-down-left-circle-fill',
						),
						'arrow-down-left-square' => array(
							'ID' => 'arrow-down-left-square',
						),
						'arrow-down-left-square-fill' => array(
							'ID' => 'arrow-down-left-square-fill',
						),
						'arrow-down-right' => array(
							'ID' => 'arrow-down-right',
						),
						'arrow-down-right-circle' => array(
							'ID' => 'arrow-down-right-circle',
						),
						'arrow-down-right-circle-fill' => array(
							'ID' => 'arrow-down-right-circle-fill',
						),
						'arrow-down-right-square' => array(
							'ID' => 'arrow-down-right-square',
						),
						'arrow-down-right-square-fill' => array(
							'ID' => 'arrow-down-right-square-fill',
						),
						'arrow-down-short' => array(
							'ID' => 'arrow-down-short',
						),
						'arrow-down-square' => array(
							'ID' => 'arrow-down-square',
						),
						'arrow-down-square-fill' => array(
							'ID' => 'arrow-down-square-fill',
						),
						'arrow-down-up' => array(
							'ID' => 'arrow-down-up',
						),
						'arrow-left' => array(
							'ID' => 'arrow-left',
						),
						'arrow-left-circle' => array(
							'ID' => 'arrow-left-circle',
						),
						'arrow-left-circle-fill' => array(
							'ID' => 'arrow-left-circle-fill',
						),
						'arrow-left-right' => array(
							'ID' => 'arrow-left-right',
						),
						'arrow-left-short' => array(
							'ID' => 'arrow-left-short',
						),
						'arrow-left-square' => array(
							'ID' => 'arrow-left-square',
						),
						'arrow-left-square-fill' => array(
							'ID' => 'arrow-left-square-fill',
						),
						'arrow-repeat' => array(
							'ID' => 'arrow-repeat',
						),
						'arrow-return-left' => array(
							'ID' => 'arrow-return-left',
						),
						'arrow-return-right' => array(
							'ID' => 'arrow-return-right',
						),
						'arrow-right' => array(
							'ID' => 'arrow-right',
						),
						'arrow-right-circle' => array(
							'ID' => 'arrow-right-circle',
						),
						'arrow-right-circle-fill' => array(
							'ID' => 'arrow-right-circle-fill',
						),
						'arrow-right-short' => array(
							'ID' => 'arrow-right-short',
						),
						'arrow-right-square' => array(
							'ID' => 'arrow-right-square',
						),
						'arrow-right-square-fill' => array(
							'ID' => 'arrow-right-square-fill',
						),
						'arrow-up' => array(
							'ID' => 'arrow-up',
						),
						'arrow-up-circle' => array(
							'ID' => 'arrow-up-circle',
						),
						'arrow-up-circle-fill' => array(
							'ID' => 'arrow-up-circle-fill',
						),
						'arrow-up-left' => array(
							'ID' => 'arrow-up-left',
						),
						'arrow-up-left-circle' => array(
							'ID' => 'arrow-up-left-circle',
						),
						'arrow-up-left-circle-fill' => array(
							'ID' => 'arrow-up-left-circle-fill',
						),
						'arrow-up-left-square' => array(
							'ID' => 'arrow-up-left-square',
						),
						'arrow-up-left-square-fill' => array(
							'ID' => 'arrow-up-left-square-fill',
						),
						'arrow-up-right' => array(
							'ID' => 'arrow-up-right',
						),
						'arrow-up-right-circle' => array(
							'ID' => 'arrow-up-right-circle',
						),
						'arrow-up-right-circle-fill' => array(
							'ID' => 'arrow-up-right-circle-fill',
						),
						'arrow-up-right-square' => array(
							'ID' => 'arrow-up-right-square',
						),
						'arrow-up-right-square-fill' => array(
							'ID' => 'arrow-up-right-square-fill',
						),
						'arrow-up-short' => array(
							'ID' => 'arrow-up-short',
						),
						'arrow-up-square' => array(
							'ID' => 'arrow-up-square',
						),
						'arrow-up-square-fill' => array(
							'ID' => 'arrow-up-square-fill',
						),
						'arrows-angle-contract' => array(
							'ID' => 'arrows-angle-contract',
						),
						'arrows-angle-expand' => array(
							'ID' => 'arrows-angle-expand',
						),
						'arrows-collapse' => array(
							'ID' => 'arrows-collapse',
						),
						'arrows-expand' => array(
							'ID' => 'arrows-expand',
						),
						'arrows-fullscreen' => array(
							'ID' => 'arrows-fullscreen',
						),
						'arrows-move' => array(
							'ID' => 'arrows-move',
						),
						'aspect-ratio' => array(
							'ID' => 'aspect-ratio',
						),
						'aspect-ratio-fill' => array(
							'ID' => 'aspect-ratio-fill',
						),
						'asterisk' => array(
							'ID' => 'asterisk',
						),
						'at' => array(
							'ID' => 'at',
						),
						'award' => array(
							'ID' => 'award',
						),
						'award-fill' => array(
							'ID' => 'award-fill',
						),
						'back' => array(
							'ID' => 'back',
						),
						'backspace' => array(
							'ID' => 'backspace',
						),
						'backspace-fill' => array(
							'ID' => 'backspace-fill',
						),
						'backspace-reverse' => array(
							'ID' => 'backspace-reverse',
						),
						'backspace-reverse-fill' => array(
							'ID' => 'backspace-reverse-fill',
						),
						'badge-3d' => array(
							'ID' => 'badge-3d',
						),
						'badge-3d-fill' => array(
							'ID' => 'badge-3d-fill',
						),
						'badge-4k' => array(
							'ID' => 'badge-4k',
						),
						'badge-4k-fill' => array(
							'ID' => 'badge-4k-fill',
						),
						'badge-8k' => array(
							'ID' => 'badge-8k',
						),
						'badge-8k-fill' => array(
							'ID' => 'badge-8k-fill',
						),
						'badge-ad' => array(
							'ID' => 'badge-ad',
						),
						'badge-ad-fill' => array(
							'ID' => 'badge-ad-fill',
						),
						'badge-ar' => array(
							'ID' => 'badge-ar',
						),
						'badge-ar-fill' => array(
							'ID' => 'badge-ar-fill',
						),
						'badge-cc' => array(
							'ID' => 'badge-cc',
						),
						'badge-cc-fill' => array(
							'ID' => 'badge-cc-fill',
						),
						'badge-hd' => array(
							'ID' => 'badge-hd',
						),
						'badge-hd-fill' => array(
							'ID' => 'badge-hd-fill',
						),
						'badge-tm' => array(
							'ID' => 'badge-tm',
						),
						'badge-tm-fill' => array(
							'ID' => 'badge-tm-fill',
						),
						'badge-vo' => array(
							'ID' => 'badge-vo',
						),
						'badge-vo-fill' => array(
							'ID' => 'badge-vo-fill',
						),
						'badge-vr' => array(
							'ID' => 'badge-vr',
						),
						'badge-vr-fill' => array(
							'ID' => 'badge-vr-fill',
						),
						'badge-wc' => array(
							'ID' => 'badge-wc',
						),
						'badge-wc-fill' => array(
							'ID' => 'badge-wc-fill',
						),
						'bag' => array(
							'ID' => 'bag',
						),
						'bag-check' => array(
							'ID' => 'bag-check',
						),
						'bag-check-fill' => array(
							'ID' => 'bag-check-fill',
						),
						'bag-dash' => array(
							'ID' => 'bag-dash',
						),
						'bag-dash-fill' => array(
							'ID' => 'bag-dash-fill',
						),
						'bag-fill' => array(
							'ID' => 'bag-fill',
						),
						'bag-plus' => array(
							'ID' => 'bag-plus',
						),
						'bag-plus-fill' => array(
							'ID' => 'bag-plus-fill',
						),
						'bag-x' => array(
							'ID' => 'bag-x',
						),
						'bag-x-fill' => array(
							'ID' => 'bag-x-fill',
						),
						'bandaid' => array(
							'ID' => 'bandaid',
						),
						'bandaid-fill' => array(
							'ID' => 'bandaid-fill',
						),
						'bank' => array(
							'ID' => 'bank',
						),
						'bank2' => array(
							'ID' => 'bank2',
						),
						'bar-chart' => array(
							'ID' => 'bar-chart',
						),
						'bar-chart-fill' => array(
							'ID' => 'bar-chart-fill',
						),
						'bar-chart-line' => array(
							'ID' => 'bar-chart-line',
						),
						'bar-chart-line-fill' => array(
							'ID' => 'bar-chart-line-fill',
						),
						'bar-chart-steps' => array(
							'ID' => 'bar-chart-steps',
						),
						'basket' => array(
							'ID' => 'basket',
						),
						'basket-fill' => array(
							'ID' => 'basket-fill',
						),
						'basket2' => array(
							'ID' => 'basket2',
						),
						'basket2-fill' => array(
							'ID' => 'basket2-fill',
						),
						'basket3' => array(
							'ID' => 'basket3',
						),
						'basket3-fill' => array(
							'ID' => 'basket3-fill',
						),
						'battery' => array(
							'ID' => 'battery',
						),
						'battery-charging' => array(
							'ID' => 'battery-charging',
						),
						'battery-full' => array(
							'ID' => 'battery-full',
						),
						'battery-half' => array(
							'ID' => 'battery-half',
						),
						'behance' => array(
							'ID' => 'behance',
						),
						'bell' => array(
							'ID' => 'bell',
						),
						'bell-fill' => array(
							'ID' => 'bell-fill',
						),
						'bell-slash' => array(
							'ID' => 'bell-slash',
						),
						'bell-slash-fill' => array(
							'ID' => 'bell-slash-fill',
						),
						'bezier' => array(
							'ID' => 'bezier',
						),
						'bezier2' => array(
							'ID' => 'bezier2',
						),
						'bicycle' => array(
							'ID' => 'bicycle',
						),
						'binoculars' => array(
							'ID' => 'binoculars',
						),
						'binoculars-fill' => array(
							'ID' => 'binoculars-fill',
						),
						'blockquote-left' => array(
							'ID' => 'blockquote-left',
						),
						'blockquote-right' => array(
							'ID' => 'blockquote-right',
						),
						'bluetooth' => array(
							'ID' => 'bluetooth',
						),
						'body-text' => array(
							'ID' => 'body-text',
						),
						'book' => array(
							'ID' => 'book',
						),
						'book-fill' => array(
							'ID' => 'book-fill',
						),
						'book-half' => array(
							'ID' => 'book-half',
						),
						'bookmark' => array(
							'ID' => 'bookmark',
						),
						'bookmark-check' => array(
							'ID' => 'bookmark-check',
						),
						'bookmark-check-fill' => array(
							'ID' => 'bookmark-check-fill',
						),
						'bookmark-dash' => array(
							'ID' => 'bookmark-dash',
						),
						'bookmark-dash-fill' => array(
							'ID' => 'bookmark-dash-fill',
						),
						'bookmark-fill' => array(
							'ID' => 'bookmark-fill',
						),
						'bookmark-heart' => array(
							'ID' => 'bookmark-heart',
						),
						'bookmark-heart-fill' => array(
							'ID' => 'bookmark-heart-fill',
						),
						'bookmark-plus' => array(
							'ID' => 'bookmark-plus',
						),
						'bookmark-plus-fill' => array(
							'ID' => 'bookmark-plus-fill',
						),
						'bookmark-star' => array(
							'ID' => 'bookmark-star',
						),
						'bookmark-star-fill' => array(
							'ID' => 'bookmark-star-fill',
						),
						'bookmark-x' => array(
							'ID' => 'bookmark-x',
						),
						'bookmark-x-fill' => array(
							'ID' => 'bookmark-x-fill',
						),
						'bookmarks' => array(
							'ID' => 'bookmarks',
						),
						'bookmarks-fill' => array(
							'ID' => 'bookmarks-fill',
						),
						'bookshelf' => array(
							'ID' => 'bookshelf',
						),
						'boombox' => array(
							'ID' => 'boombox',
						),
						'boombox-fill' => array(
							'ID' => 'boombox-fill',
						),
						'bootstrap' => array(
							'ID' => 'bootstrap',
						),
						'bootstrap-fill' => array(
							'ID' => 'bootstrap-fill',
						),
						'bootstrap-reboot' => array(
							'ID' => 'bootstrap-reboot',
						),
						'border' => array(
							'ID' => 'border',
						),
						'border-all' => array(
							'ID' => 'border-all',
						),
						'border-bottom' => array(
							'ID' => 'border-bottom',
						),
						'border-center' => array(
							'ID' => 'border-center',
						),
						'border-inner' => array(
							'ID' => 'border-inner',
						),
						'border-left' => array(
							'ID' => 'border-left',
						),
						'border-middle' => array(
							'ID' => 'border-middle',
						),
						'border-outer' => array(
							'ID' => 'border-outer',
						),
						'border-right' => array(
							'ID' => 'border-right',
						),
						'border-style' => array(
							'ID' => 'border-style',
						),
						'border-top' => array(
							'ID' => 'border-top',
						),
						'border-width' => array(
							'ID' => 'border-width',
						),
						'bounding-box' => array(
							'ID' => 'bounding-box',
						),
						'bounding-box-circles' => array(
							'ID' => 'bounding-box-circles',
						),
						'box' => array(
							'ID' => 'box',
						),
						'box-arrow-down' => array(
							'ID' => 'box-arrow-down',
						),
						'box-arrow-down-left' => array(
							'ID' => 'box-arrow-down-left',
						),
						'box-arrow-down-right' => array(
							'ID' => 'box-arrow-down-right',
						),
						'box-arrow-in-down' => array(
							'ID' => 'box-arrow-in-down',
						),
						'box-arrow-in-down-left' => array(
							'ID' => 'box-arrow-in-down-left',
						),
						'box-arrow-in-down-right' => array(
							'ID' => 'box-arrow-in-down-right',
						),
						'box-arrow-in-left' => array(
							'ID' => 'box-arrow-in-left',
						),
						'box-arrow-in-right' => array(
							'ID' => 'box-arrow-in-right',
						),
						'box-arrow-in-up' => array(
							'ID' => 'box-arrow-in-up',
						),
						'box-arrow-in-up-left' => array(
							'ID' => 'box-arrow-in-up-left',
						),
						'box-arrow-in-up-right' => array(
							'ID' => 'box-arrow-in-up-right',
						),
						'box-arrow-left' => array(
							'ID' => 'box-arrow-left',
						),
						'box-arrow-right' => array(
							'ID' => 'box-arrow-right',
						),
						'box-arrow-up' => array(
							'ID' => 'box-arrow-up',
						),
						'box-arrow-up-left' => array(
							'ID' => 'box-arrow-up-left',
						),
						'box-arrow-up-right' => array(
							'ID' => 'box-arrow-up-right',
						),
						'box-seam' => array(
							'ID' => 'box-seam',
						),
						'boxes' => array(
							'ID' => 'boxes',
						),
						'braces' => array(
							'ID' => 'braces',
						),
						'bricks' => array(
							'ID' => 'bricks',
						),
						'briefcase' => array(
							'ID' => 'briefcase',
						),
						'briefcase-fill' => array(
							'ID' => 'briefcase-fill',
						),
						'brightness-alt-high' => array(
							'ID' => 'brightness-alt-high',
						),
						'brightness-alt-high-fill' => array(
							'ID' => 'brightness-alt-high-fill',
						),
						'brightness-alt-low' => array(
							'ID' => 'brightness-alt-low',
						),
						'brightness-alt-low-fill' => array(
							'ID' => 'brightness-alt-low-fill',
						),
						'brightness-high' => array(
							'ID' => 'brightness-high',
						),
						'brightness-high-fill' => array(
							'ID' => 'brightness-high-fill',
						),
						'brightness-low' => array(
							'ID' => 'brightness-low',
						),
						'brightness-low-fill' => array(
							'ID' => 'brightness-low-fill',
						),
						'broadcast' => array(
							'ID' => 'broadcast',
						),
						'broadcast-pin' => array(
							'ID' => 'broadcast-pin',
						),
						'brush' => array(
							'ID' => 'brush',
						),
						'brush-fill' => array(
							'ID' => 'brush-fill',
						),
						'bucket' => array(
							'ID' => 'bucket',
						),
						'bucket-fill' => array(
							'ID' => 'bucket-fill',
						),
						'bug' => array(
							'ID' => 'bug',
						),
						'bug-fill' => array(
							'ID' => 'bug-fill',
						),
						'building' => array(
							'ID' => 'building',
						),
						'bullseye' => array(
							'ID' => 'bullseye',
						),
						'calculator' => array(
							'ID' => 'calculator',
						),
						'calculator-fill' => array(
							'ID' => 'calculator-fill',
						),
						'calendar' => array(
							'ID' => 'calendar',
						),
						'calendar-check' => array(
							'ID' => 'calendar-check',
						),
						'calendar-check-fill' => array(
							'ID' => 'calendar-check-fill',
						),
						'calendar-date' => array(
							'ID' => 'calendar-date',
						),
						'calendar-date-fill' => array(
							'ID' => 'calendar-date-fill',
						),
						'calendar-day' => array(
							'ID' => 'calendar-day',
						),
						'calendar-day-fill' => array(
							'ID' => 'calendar-day-fill',
						),
						'calendar-event' => array(
							'ID' => 'calendar-event',
						),
						'calendar-event-fill' => array(
							'ID' => 'calendar-event-fill',
						),
						'calendar-fill' => array(
							'ID' => 'calendar-fill',
						),
						'calendar-minus' => array(
							'ID' => 'calendar-minus',
						),
						'calendar-minus-fill' => array(
							'ID' => 'calendar-minus-fill',
						),
						'calendar-month' => array(
							'ID' => 'calendar-month',
						),
						'calendar-month-fill' => array(
							'ID' => 'calendar-month-fill',
						),
						'calendar-plus' => array(
							'ID' => 'calendar-plus',
						),
						'calendar-plus-fill' => array(
							'ID' => 'calendar-plus-fill',
						),
						'calendar-range' => array(
							'ID' => 'calendar-range',
						),
						'calendar-range-fill' => array(
							'ID' => 'calendar-range-fill',
						),
						'calendar-week' => array(
							'ID' => 'calendar-week',
						),
						'calendar-week-fill' => array(
							'ID' => 'calendar-week-fill',
						),
						'calendar-x' => array(
							'ID' => 'calendar-x',
						),
						'calendar-x-fill' => array(
							'ID' => 'calendar-x-fill',
						),
						'calendar2' => array(
							'ID' => 'calendar2',
						),
						'calendar2-check' => array(
							'ID' => 'calendar2-check',
						),
						'calendar2-check-fill' => array(
							'ID' => 'calendar2-check-fill',
						),
						'calendar2-date' => array(
							'ID' => 'calendar2-date',
						),
						'calendar2-date-fill' => array(
							'ID' => 'calendar2-date-fill',
						),
						'calendar2-day' => array(
							'ID' => 'calendar2-day',
						),
						'calendar2-day-fill' => array(
							'ID' => 'calendar2-day-fill',
						),
						'calendar2-event' => array(
							'ID' => 'calendar2-event',
						),
						'calendar2-event-fill' => array(
							'ID' => 'calendar2-event-fill',
						),
						'calendar2-fill' => array(
							'ID' => 'calendar2-fill',
						),
						'calendar2-minus' => array(
							'ID' => 'calendar2-minus',
						),
						'calendar2-minus-fill' => array(
							'ID' => 'calendar2-minus-fill',
						),
						'calendar2-month' => array(
							'ID' => 'calendar2-month',
						),
						'calendar2-month-fill' => array(
							'ID' => 'calendar2-month-fill',
						),
						'calendar2-plus' => array(
							'ID' => 'calendar2-plus',
						),
						'calendar2-plus-fill' => array(
							'ID' => 'calendar2-plus-fill',
						),
						'calendar2-range' => array(
							'ID' => 'calendar2-range',
						),
						'calendar2-range-fill' => array(
							'ID' => 'calendar2-range-fill',
						),
						'calendar2-week' => array(
							'ID' => 'calendar2-week',
						),
						'calendar2-week-fill' => array(
							'ID' => 'calendar2-week-fill',
						),
						'calendar2-x' => array(
							'ID' => 'calendar2-x',
						),
						'calendar2-x-fill' => array(
							'ID' => 'calendar2-x-fill',
						),
						'calendar3' => array(
							'ID' => 'calendar3',
						),
						'calendar3-event' => array(
							'ID' => 'calendar3-event',
						),
						'calendar3-event-fill' => array(
							'ID' => 'calendar3-event-fill',
						),
						'calendar3-fill' => array(
							'ID' => 'calendar3-fill',
						),
						'calendar3-range' => array(
							'ID' => 'calendar3-range',
						),
						'calendar3-range-fill' => array(
							'ID' => 'calendar3-range-fill',
						),
						'calendar3-week' => array(
							'ID' => 'calendar3-week',
						),
						'calendar3-week-fill' => array(
							'ID' => 'calendar3-week-fill',
						),
						'calendar4' => array(
							'ID' => 'calendar4',
						),
						'calendar4-event' => array(
							'ID' => 'calendar4-event',
						),
						'calendar4-range' => array(
							'ID' => 'calendar4-range',
						),
						'calendar4-week' => array(
							'ID' => 'calendar4-week',
						),
						'camera' => array(
							'ID' => 'camera',
						),
						'camera-fill' => array(
							'ID' => 'camera-fill',
						),
						'camera-reels' => array(
							'ID' => 'camera-reels',
						),
						'camera-reels-fill' => array(
							'ID' => 'camera-reels-fill',
						),
						'camera-video' => array(
							'ID' => 'camera-video',
						),
						'camera-video-fill' => array(
							'ID' => 'camera-video-fill',
						),
						'camera-video-off' => array(
							'ID' => 'camera-video-off',
						),
						'camera-video-off-fill' => array(
							'ID' => 'camera-video-off-fill',
						),
						'camera2' => array(
							'ID' => 'camera2',
						),
						'capslock' => array(
							'ID' => 'capslock',
						),
						'capslock-fill' => array(
							'ID' => 'capslock-fill',
						),
						'card-checklist' => array(
							'ID' => 'card-checklist',
						),
						'card-heading' => array(
							'ID' => 'card-heading',
						),
						'card-image' => array(
							'ID' => 'card-image',
						),
						'card-list' => array(
							'ID' => 'card-list',
						),
						'card-text' => array(
							'ID' => 'card-text',
						),
						'caret-down' => array(
							'ID' => 'caret-down',
						),
						'caret-down-fill' => array(
							'ID' => 'caret-down-fill',
						),
						'caret-down-square' => array(
							'ID' => 'caret-down-square',
						),
						'caret-down-square-fill' => array(
							'ID' => 'caret-down-square-fill',
						),
						'caret-left' => array(
							'ID' => 'caret-left',
						),
						'caret-left-fill' => array(
							'ID' => 'caret-left-fill',
						),
						'caret-left-square' => array(
							'ID' => 'caret-left-square',
						),
						'caret-left-square-fill' => array(
							'ID' => 'caret-left-square-fill',
						),
						'caret-right' => array(
							'ID' => 'caret-right',
						),
						'caret-right-fill' => array(
							'ID' => 'caret-right-fill',
						),
						'caret-right-square' => array(
							'ID' => 'caret-right-square',
						),
						'caret-right-square-fill' => array(
							'ID' => 'caret-right-square-fill',
						),
						'caret-up' => array(
							'ID' => 'caret-up',
						),
						'caret-up-fill' => array(
							'ID' => 'caret-up-fill',
						),
						'caret-up-square' => array(
							'ID' => 'caret-up-square',
						),
						'caret-up-square-fill' => array(
							'ID' => 'caret-up-square-fill',
						),
						'cart' => array(
							'ID' => 'cart',
						),
						'cart-check' => array(
							'ID' => 'cart-check',
						),
						'cart-check-fill' => array(
							'ID' => 'cart-check-fill',
						),
						'cart-dash' => array(
							'ID' => 'cart-dash',
						),
						'cart-dash-fill' => array(
							'ID' => 'cart-dash-fill',
						),
						'cart-fill' => array(
							'ID' => 'cart-fill',
						),
						'cart-plus' => array(
							'ID' => 'cart-plus',
						),
						'cart-plus-fill' => array(
							'ID' => 'cart-plus-fill',
						),
						'cart-x' => array(
							'ID' => 'cart-x',
						),
						'cart-x-fill' => array(
							'ID' => 'cart-x-fill',
						),
						'cart2' => array(
							'ID' => 'cart2',
						),
						'cart3' => array(
							'ID' => 'cart3',
						),
						'cart4' => array(
							'ID' => 'cart4',
						),
						'cash' => array(
							'ID' => 'cash',
						),
						'cash-coin' => array(
							'ID' => 'cash-coin',
						),
						'cash-stack' => array(
							'ID' => 'cash-stack',
						),
						'cast' => array(
							'ID' => 'cast',
						),
						'chat' => array(
							'ID' => 'chat',
						),
						'chat-dots' => array(
							'ID' => 'chat-dots',
						),
						'chat-dots-fill' => array(
							'ID' => 'chat-dots-fill',
						),
						'chat-fill' => array(
							'ID' => 'chat-fill',
						),
						'chat-left' => array(
							'ID' => 'chat-left',
						),
						'chat-left-dots' => array(
							'ID' => 'chat-left-dots',
						),
						'chat-left-dots-fill' => array(
							'ID' => 'chat-left-dots-fill',
						),
						'chat-left-fill' => array(
							'ID' => 'chat-left-fill',
						),
						'chat-left-quote' => array(
							'ID' => 'chat-left-quote',
						),
						'chat-left-quote-fill' => array(
							'ID' => 'chat-left-quote-fill',
						),
						'chat-left-text' => array(
							'ID' => 'chat-left-text',
						),
						'chat-left-text-fill' => array(
							'ID' => 'chat-left-text-fill',
						),
						'chat-quote' => array(
							'ID' => 'chat-quote',
						),
						'chat-quote-fill' => array(
							'ID' => 'chat-quote-fill',
						),
						'chat-right' => array(
							'ID' => 'chat-right',
						),
						'chat-right-dots' => array(
							'ID' => 'chat-right-dots',
						),
						'chat-right-dots-fill' => array(
							'ID' => 'chat-right-dots-fill',
						),
						'chat-right-fill' => array(
							'ID' => 'chat-right-fill',
						),
						'chat-right-quote' => array(
							'ID' => 'chat-right-quote',
						),
						'chat-right-quote-fill' => array(
							'ID' => 'chat-right-quote-fill',
						),
						'chat-right-text' => array(
							'ID' => 'chat-right-text',
						),
						'chat-right-text-fill' => array(
							'ID' => 'chat-right-text-fill',
						),
						'chat-square' => array(
							'ID' => 'chat-square',
						),
						'chat-square-dots' => array(
							'ID' => 'chat-square-dots',
						),
						'chat-square-dots-fill' => array(
							'ID' => 'chat-square-dots-fill',
						),
						'chat-square-fill' => array(
							'ID' => 'chat-square-fill',
						),
						'chat-square-quote' => array(
							'ID' => 'chat-square-quote',
						),
						'chat-square-quote-fill' => array(
							'ID' => 'chat-square-quote-fill',
						),
						'chat-square-text' => array(
							'ID' => 'chat-square-text',
						),
						'chat-square-text-fill' => array(
							'ID' => 'chat-square-text-fill',
						),
						'chat-text' => array(
							'ID' => 'chat-text',
						),
						'chat-text-fill' => array(
							'ID' => 'chat-text-fill',
						),
						'check' => array(
							'ID' => 'check',
						),
						'check-all' => array(
							'ID' => 'check-all',
						),
						'check-circle' => array(
							'ID' => 'check-circle',
						),
						'check-circle-fill' => array(
							'ID' => 'check-circle-fill',
						),
						'check-lg' => array(
							'ID' => 'check-lg',
						),
						'check-square' => array(
							'ID' => 'check-square',
						),
						'check-square-fill' => array(
							'ID' => 'check-square-fill',
						),
						'check2' => array(
							'ID' => 'check2',
						),
						'check2-all' => array(
							'ID' => 'check2-all',
						),
						'check2-circle' => array(
							'ID' => 'check2-circle',
						),
						'check2-square' => array(
							'ID' => 'check2-square',
						),
						'chevron-bar-contract' => array(
							'ID' => 'chevron-bar-contract',
						),
						'chevron-bar-down' => array(
							'ID' => 'chevron-bar-down',
						),
						'chevron-bar-expand' => array(
							'ID' => 'chevron-bar-expand',
						),
						'chevron-bar-left' => array(
							'ID' => 'chevron-bar-left',
						),
						'chevron-bar-right' => array(
							'ID' => 'chevron-bar-right',
						),
						'chevron-bar-up' => array(
							'ID' => 'chevron-bar-up',
						),
						'chevron-compact-down' => array(
							'ID' => 'chevron-compact-down',
						),
						'chevron-compact-left' => array(
							'ID' => 'chevron-compact-left',
						),
						'chevron-compact-right' => array(
							'ID' => 'chevron-compact-right',
						),
						'chevron-compact-up' => array(
							'ID' => 'chevron-compact-up',
						),
						'chevron-contract' => array(
							'ID' => 'chevron-contract',
						),
						'chevron-double-down' => array(
							'ID' => 'chevron-double-down',
						),
						'chevron-double-left' => array(
							'ID' => 'chevron-double-left',
						),
						'chevron-double-right' => array(
							'ID' => 'chevron-double-right',
						),
						'chevron-double-up' => array(
							'ID' => 'chevron-double-up',
						),
						'chevron-down' => array(
							'ID' => 'chevron-down',
						),
						'chevron-expand' => array(
							'ID' => 'chevron-expand',
						),
						'chevron-left' => array(
							'ID' => 'chevron-left',
						),
						'chevron-right' => array(
							'ID' => 'chevron-right',
						),
						'chevron-up' => array(
							'ID' => 'chevron-up',
						),
						'circle' => array(
							'ID' => 'circle',
						),
						'circle-fill' => array(
							'ID' => 'circle-fill',
						),
						'circle-half' => array(
							'ID' => 'circle-half',
						),
						'circle-square' => array(
							'ID' => 'circle-square',
						),
						'clipboard' => array(
							'ID' => 'clipboard',
						),
						'clipboard-check' => array(
							'ID' => 'clipboard-check',
						),
						'clipboard-data' => array(
							'ID' => 'clipboard-data',
						),
						'clipboard-minus' => array(
							'ID' => 'clipboard-minus',
						),
						'clipboard-plus' => array(
							'ID' => 'clipboard-plus',
						),
						'clipboard-x' => array(
							'ID' => 'clipboard-x',
						),
						'clock' => array(
							'ID' => 'clock',
						),
						'clock-fill' => array(
							'ID' => 'clock-fill',
						),
						'clock-history' => array(
							'ID' => 'clock-history',
						),
						'cloud' => array(
							'ID' => 'cloud',
						),
						'cloud-arrow-down' => array(
							'ID' => 'cloud-arrow-down',
						),
						'cloud-arrow-down-fill' => array(
							'ID' => 'cloud-arrow-down-fill',
						),
						'cloud-arrow-up' => array(
							'ID' => 'cloud-arrow-up',
						),
						'cloud-arrow-up-fill' => array(
							'ID' => 'cloud-arrow-up-fill',
						),
						'cloud-check' => array(
							'ID' => 'cloud-check',
						),
						'cloud-check-fill' => array(
							'ID' => 'cloud-check-fill',
						),
						'cloud-download' => array(
							'ID' => 'cloud-download',
						),
						'cloud-download-fill' => array(
							'ID' => 'cloud-download-fill',
						),
						'cloud-drizzle' => array(
							'ID' => 'cloud-drizzle',
						),
						'cloud-drizzle-fill' => array(
							'ID' => 'cloud-drizzle-fill',
						),
						'cloud-fill' => array(
							'ID' => 'cloud-fill',
						),
						'cloud-fog' => array(
							'ID' => 'cloud-fog',
						),
						'cloud-fog-fill' => array(
							'ID' => 'cloud-fog-fill',
						),
						'cloud-fog2' => array(
							'ID' => 'cloud-fog2',
						),
						'cloud-fog2-fill' => array(
							'ID' => 'cloud-fog2-fill',
						),
						'cloud-hail' => array(
							'ID' => 'cloud-hail',
						),
						'cloud-hail-fill' => array(
							'ID' => 'cloud-hail-fill',
						),
						'cloud-haze' => array(
							'ID' => 'cloud-haze',
						),
						'cloud-haze-fill' => array(
							'ID' => 'cloud-haze-fill',
						),
						'cloud-haze2' => array(
							'ID' => 'cloud-haze2',
						),
						'cloud-haze2-fill' => array(
							'ID' => 'cloud-haze2-fill',
						),
						'cloud-lightning' => array(
							'ID' => 'cloud-lightning',
						),
						'cloud-lightning-fill' => array(
							'ID' => 'cloud-lightning-fill',
						),
						'cloud-lightning-rain' => array(
							'ID' => 'cloud-lightning-rain',
						),
						'cloud-lightning-rain-fill' => array(
							'ID' => 'cloud-lightning-rain-fill',
						),
						'cloud-minus' => array(
							'ID' => 'cloud-minus',
						),
						'cloud-minus-fill' => array(
							'ID' => 'cloud-minus-fill',
						),
						'cloud-moon' => array(
							'ID' => 'cloud-moon',
						),
						'cloud-moon-fill' => array(
							'ID' => 'cloud-moon-fill',
						),
						'cloud-plus' => array(
							'ID' => 'cloud-plus',
						),
						'cloud-plus-fill' => array(
							'ID' => 'cloud-plus-fill',
						),
						'cloud-rain' => array(
							'ID' => 'cloud-rain',
						),
						'cloud-rain-fill' => array(
							'ID' => 'cloud-rain-fill',
						),
						'cloud-rain-heavy' => array(
							'ID' => 'cloud-rain-heavy',
						),
						'cloud-rain-heavy-fill' => array(
							'ID' => 'cloud-rain-heavy-fill',
						),
						'cloud-slash' => array(
							'ID' => 'cloud-slash',
						),
						'cloud-slash-fill' => array(
							'ID' => 'cloud-slash-fill',
						),
						'cloud-sleet' => array(
							'ID' => 'cloud-sleet',
						),
						'cloud-sleet-fill' => array(
							'ID' => 'cloud-sleet-fill',
						),
						'cloud-snow' => array(
							'ID' => 'cloud-snow',
						),
						'cloud-snow-fill' => array(
							'ID' => 'cloud-snow-fill',
						),
						'cloud-sun' => array(
							'ID' => 'cloud-sun',
						),
						'cloud-sun-fill' => array(
							'ID' => 'cloud-sun-fill',
						),
						'cloud-upload' => array(
							'ID' => 'cloud-upload',
						),
						'cloud-upload-fill' => array(
							'ID' => 'cloud-upload-fill',
						),
						'clouds' => array(
							'ID' => 'clouds',
						),
						'clouds-fill' => array(
							'ID' => 'clouds-fill',
						),
						'cloudy' => array(
							'ID' => 'cloudy',
						),
						'cloudy-fill' => array(
							'ID' => 'cloudy-fill',
						),
						'code' => array(
							'ID' => 'code',
						),
						'code-slash' => array(
							'ID' => 'code-slash',
						),
						'code-square' => array(
							'ID' => 'code-square',
						),
						'coin' => array(
							'ID' => 'coin',
						),
						'collection' => array(
							'ID' => 'collection',
						),
						'collection-fill' => array(
							'ID' => 'collection-fill',
						),
						'collection-play' => array(
							'ID' => 'collection-play',
						),
						'collection-play-fill' => array(
							'ID' => 'collection-play-fill',
						),
						'columns' => array(
							'ID' => 'columns',
						),
						'columns-gap' => array(
							'ID' => 'columns-gap',
						),
						'command' => array(
							'ID' => 'command',
						),
						'compass' => array(
							'ID' => 'compass',
						),
						'compass-fill' => array(
							'ID' => 'compass-fill',
						),
						'cone' => array(
							'ID' => 'cone',
						),
						'cone-striped' => array(
							'ID' => 'cone-striped',
						),
						'controller' => array(
							'ID' => 'controller',
						),
						'cpu' => array(
							'ID' => 'cpu',
						),
						'cpu-fill' => array(
							'ID' => 'cpu-fill',
						),
						'credit-card' => array(
							'ID' => 'credit-card',
						),
						'credit-card-2-back' => array(
							'ID' => 'credit-card-2-back',
						),
						'credit-card-2-back-fill' => array(
							'ID' => 'credit-card-2-back-fill',
						),
						'credit-card-2-front' => array(
							'ID' => 'credit-card-2-front',
						),
						'credit-card-2-front-fill' => array(
							'ID' => 'credit-card-2-front-fill',
						),
						'credit-card-fill' => array(
							'ID' => 'credit-card-fill',
						),
						'crop' => array(
							'ID' => 'crop',
						),
						'cup' => array(
							'ID' => 'cup',
						),
						'cup-fill' => array(
							'ID' => 'cup-fill',
						),
						'cup-straw' => array(
							'ID' => 'cup-straw',
						),
						'currency-bitcoin' => array(
							'ID' => 'currency-bitcoin',
						),
						'currency-dollar' => array(
							'ID' => 'currency-dollar',
						),
						'currency-euro' => array(
							'ID' => 'currency-euro',
						),
						'currency-exchange' => array(
							'ID' => 'currency-exchange',
						),
						'currency-pound' => array(
							'ID' => 'currency-pound',
						),
						'currency-yen' => array(
							'ID' => 'currency-yen',
						),
						'cursor' => array(
							'ID' => 'cursor',
						),
						'cursor-fill' => array(
							'ID' => 'cursor-fill',
						),
						'cursor-text' => array(
							'ID' => 'cursor-text',
						),
						'dash' => array(
							'ID' => 'dash',
						),
						'dash-circle' => array(
							'ID' => 'dash-circle',
						),
						'dash-circle-dotted' => array(
							'ID' => 'dash-circle-dotted',
						),
						'dash-circle-fill' => array(
							'ID' => 'dash-circle-fill',
						),
						'dash-lg' => array(
							'ID' => 'dash-lg',
						),
						'dash-square' => array(
							'ID' => 'dash-square',
						),
						'dash-square-dotted' => array(
							'ID' => 'dash-square-dotted',
						),
						'dash-square-fill' => array(
							'ID' => 'dash-square-fill',
						),
						'device-hdd' => array(
							'ID' => 'device-hdd',
						),
						'device-hdd-fill' => array(
							'ID' => 'device-hdd-fill',
						),
						'device-ssd' => array(
							'ID' => 'device-ssd',
						),
						'device-ssd-fill' => array(
							'ID' => 'device-ssd-fill',
						),
						'diagram-2' => array(
							'ID' => 'diagram-2',
						),
						'diagram-2-fill' => array(
							'ID' => 'diagram-2-fill',
						),
						'diagram-3' => array(
							'ID' => 'diagram-3',
						),
						'diagram-3-fill' => array(
							'ID' => 'diagram-3-fill',
						),
						'diamond' => array(
							'ID' => 'diamond',
						),
						'diamond-fill' => array(
							'ID' => 'diamond-fill',
						),
						'diamond-half' => array(
							'ID' => 'diamond-half',
						),
						'dice-1' => array(
							'ID' => 'dice-1',
						),
						'dice-1-fill' => array(
							'ID' => 'dice-1-fill',
						),
						'dice-2' => array(
							'ID' => 'dice-2',
						),
						'dice-2-fill' => array(
							'ID' => 'dice-2-fill',
						),
						'dice-3' => array(
							'ID' => 'dice-3',
						),
						'dice-3-fill' => array(
							'ID' => 'dice-3-fill',
						),
						'dice-4' => array(
							'ID' => 'dice-4',
						),
						'dice-4-fill' => array(
							'ID' => 'dice-4-fill',
						),
						'dice-5' => array(
							'ID' => 'dice-5',
						),
						'dice-5-fill' => array(
							'ID' => 'dice-5-fill',
						),
						'dice-6' => array(
							'ID' => 'dice-6',
						),
						'dice-6-fill' => array(
							'ID' => 'dice-6-fill',
						),
						'disc' => array(
							'ID' => 'disc',
						),
						'disc-fill' => array(
							'ID' => 'disc-fill',
						),
						'discord' => array(
							'ID' => 'discord',
						),
						'display' => array(
							'ID' => 'display',
						),
						'display-fill' => array(
							'ID' => 'display-fill',
						),
						'displayport' => array(
							'ID' => 'displayport',
						),
						'displayport-fill' => array(
							'ID' => 'displayport-fill',
						),
						'distribute-horizontal' => array(
							'ID' => 'distribute-horizontal',
						),
						'distribute-vertical' => array(
							'ID' => 'distribute-vertical',
						),
						'door-closed' => array(
							'ID' => 'door-closed',
						),
						'door-closed-fill' => array(
							'ID' => 'door-closed-fill',
						),
						'door-open' => array(
							'ID' => 'door-open',
						),
						'door-open-fill' => array(
							'ID' => 'door-open-fill',
						),
						'dot' => array(
							'ID' => 'dot',
						),
						'download' => array(
							'ID' => 'download',
						),
						'dpad' => array(
							'ID' => 'dpad',
						),
						'dpad-fill' => array(
							'ID' => 'dpad-fill',
						),
						'dribbble' => array(
							'ID' => 'dribbble',
						),
						'droplet' => array(
							'ID' => 'droplet',
						),
						'droplet-fill' => array(
							'ID' => 'droplet-fill',
						),
						'droplet-half' => array(
							'ID' => 'droplet-half',
						),
						'ear' => array(
							'ID' => 'ear',
						),
						'ear-fill' => array(
							'ID' => 'ear-fill',
						),
						'earbuds' => array(
							'ID' => 'earbuds',
						),
						'easel' => array(
							'ID' => 'easel',
						),
						'easel-fill' => array(
							'ID' => 'easel-fill',
						),
						'easel2' => array(
							'ID' => 'easel2',
						),
						'easel2-fill' => array(
							'ID' => 'easel2-fill',
						),
						'easel3' => array(
							'ID' => 'easel3',
						),
						'easel3-fill' => array(
							'ID' => 'easel3-fill',
						),
						'egg' => array(
							'ID' => 'egg',
						),
						'egg-fill' => array(
							'ID' => 'egg-fill',
						),
						'egg-fried' => array(
							'ID' => 'egg-fried',
						),
						'eject' => array(
							'ID' => 'eject',
						),
						'eject-fill' => array(
							'ID' => 'eject-fill',
						),
						'emoji-angry' => array(
							'ID' => 'emoji-angry',
						),
						'emoji-angry-fill' => array(
							'ID' => 'emoji-angry-fill',
						),
						'emoji-dizzy' => array(
							'ID' => 'emoji-dizzy',
						),
						'emoji-dizzy-fill' => array(
							'ID' => 'emoji-dizzy-fill',
						),
						'emoji-expressionless' => array(
							'ID' => 'emoji-expressionless',
						),
						'emoji-expressionless-fill' => array(
							'ID' => 'emoji-expressionless-fill',
						),
						'emoji-frown' => array(
							'ID' => 'emoji-frown',
						),
						'emoji-frown-fill' => array(
							'ID' => 'emoji-frown-fill',
						),
						'emoji-heart-eyes' => array(
							'ID' => 'emoji-heart-eyes',
						),
						'emoji-heart-eyes-fill' => array(
							'ID' => 'emoji-heart-eyes-fill',
						),
						'emoji-laughing' => array(
							'ID' => 'emoji-laughing',
						),
						'emoji-laughing-fill' => array(
							'ID' => 'emoji-laughing-fill',
						),
						'emoji-neutral' => array(
							'ID' => 'emoji-neutral',
						),
						'emoji-neutral-fill' => array(
							'ID' => 'emoji-neutral-fill',
						),
						'emoji-smile' => array(
							'ID' => 'emoji-smile',
						),
						'emoji-smile-fill' => array(
							'ID' => 'emoji-smile-fill',
						),
						'emoji-smile-upside-down' => array(
							'ID' => 'emoji-smile-upside-down',
						),
						'emoji-smile-upside-down-fill' => array(
							'ID' => 'emoji-smile-upside-down-fill',
						),
						'emoji-sunglasses' => array(
							'ID' => 'emoji-sunglasses',
						),
						'emoji-sunglasses-fill' => array(
							'ID' => 'emoji-sunglasses-fill',
						),
						'emoji-wink' => array(
							'ID' => 'emoji-wink',
						),
						'emoji-wink-fill' => array(
							'ID' => 'emoji-wink-fill',
						),
						'envelope' => array(
							'ID' => 'envelope',
						),
						'envelope-check' => array(
							'ID' => 'envelope-check',
						),
						'envelope-check-fill' => array(
							'ID' => 'envelope-check-fill',
						),
						'envelope-dash' => array(
							'ID' => 'envelope-dash',
						),
						'envelope-dash-fill' => array(
							'ID' => 'envelope-dash-fill',
						),
						'envelope-exclamation' => array(
							'ID' => 'envelope-exclamation',
						),
						'envelope-exclamation-fill' => array(
							'ID' => 'envelope-exclamation-fill',
						),
						'envelope-fill' => array(
							'ID' => 'envelope-fill',
						),
						'envelope-open' => array(
							'ID' => 'envelope-open',
						),
						'envelope-open-fill' => array(
							'ID' => 'envelope-open-fill',
						),
						'envelope-plus' => array(
							'ID' => 'envelope-plus',
						),
						'envelope-plus-fill' => array(
							'ID' => 'envelope-plus-fill',
						),
						'envelope-slash' => array(
							'ID' => 'envelope-slash',
						),
						'envelope-slash-fill' => array(
							'ID' => 'envelope-slash-fill',
						),
						'envelope-x' => array(
							'ID' => 'envelope-x',
						),
						'envelope-x-fill' => array(
							'ID' => 'envelope-x-fill',
						),
						'eraser' => array(
							'ID' => 'eraser',
						),
						'eraser-fill' => array(
							'ID' => 'eraser-fill',
						),
						'ethernet' => array(
							'ID' => 'ethernet',
						),
						'exclamation' => array(
							'ID' => 'exclamation',
						),
						'exclamation-circle' => array(
							'ID' => 'exclamation-circle',
						),
						'exclamation-circle-fill' => array(
							'ID' => 'exclamation-circle-fill',
						),
						'exclamation-diamond' => array(
							'ID' => 'exclamation-diamond',
						),
						'exclamation-diamond-fill' => array(
							'ID' => 'exclamation-diamond-fill',
						),
						'exclamation-lg' => array(
							'ID' => 'exclamation-lg',
						),
						'exclamation-octagon' => array(
							'ID' => 'exclamation-octagon',
						),
						'exclamation-octagon-fill' => array(
							'ID' => 'exclamation-octagon-fill',
						),
						'exclamation-square' => array(
							'ID' => 'exclamation-square',
						),
						'exclamation-square-fill' => array(
							'ID' => 'exclamation-square-fill',
						),
						'exclamation-triangle' => array(
							'ID' => 'exclamation-triangle',
						),
						'exclamation-triangle-fill' => array(
							'ID' => 'exclamation-triangle-fill',
						),
						'exclude' => array(
							'ID' => 'exclude',
						),
						'explicit' => array(
							'ID' => 'explicit',
						),
						'explicit-fill' => array(
							'ID' => 'explicit-fill',
						),
						'eye' => array(
							'ID' => 'eye',
						),
						'eye-fill' => array(
							'ID' => 'eye-fill',
						),
						'eye-slash' => array(
							'ID' => 'eye-slash',
						),
						'eye-slash-fill' => array(
							'ID' => 'eye-slash-fill',
						),
						'eyedropper' => array(
							'ID' => 'eyedropper',
						),
						'eyeglasses' => array(
							'ID' => 'eyeglasses',
						),
						'facebook' => array(
							'ID' => 'facebook',
						),
						'fan' => array(
							'ID' => 'fan',
						),
						'file' => array(
							'ID' => 'file',
						),
						'file-arrow-down' => array(
							'ID' => 'file-arrow-down',
						),
						'file-arrow-down-fill' => array(
							'ID' => 'file-arrow-down-fill',
						),
						'file-arrow-up' => array(
							'ID' => 'file-arrow-up',
						),
						'file-arrow-up-fill' => array(
							'ID' => 'file-arrow-up-fill',
						),
						'file-bar-graph' => array(
							'ID' => 'file-bar-graph',
						),
						'file-bar-graph-fill' => array(
							'ID' => 'file-bar-graph-fill',
						),
						'file-binary' => array(
							'ID' => 'file-binary',
						),
						'file-binary-fill' => array(
							'ID' => 'file-binary-fill',
						),
						'file-break' => array(
							'ID' => 'file-break',
						),
						'file-break-fill' => array(
							'ID' => 'file-break-fill',
						),
						'file-check' => array(
							'ID' => 'file-check',
						),
						'file-check-fill' => array(
							'ID' => 'file-check-fill',
						),
						'file-code' => array(
							'ID' => 'file-code',
						),
						'file-code-fill' => array(
							'ID' => 'file-code-fill',
						),
						'file-diff' => array(
							'ID' => 'file-diff',
						),
						'file-diff-fill' => array(
							'ID' => 'file-diff-fill',
						),
						'file-earmark' => array(
							'ID' => 'file-earmark',
						),
						'file-earmark-arrow-down' => array(
							'ID' => 'file-earmark-arrow-down',
						),
						'file-earmark-arrow-down-fill' => array(
							'ID' => 'file-earmark-arrow-down-fill',
						),
						'file-earmark-arrow-up' => array(
							'ID' => 'file-earmark-arrow-up',
						),
						'file-earmark-arrow-up-fill' => array(
							'ID' => 'file-earmark-arrow-up-fill',
						),
						'file-earmark-bar-graph' => array(
							'ID' => 'file-earmark-bar-graph',
						),
						'file-earmark-bar-graph-fill' => array(
							'ID' => 'file-earmark-bar-graph-fill',
						),
						'file-earmark-binary' => array(
							'ID' => 'file-earmark-binary',
						),
						'file-earmark-binary-fill' => array(
							'ID' => 'file-earmark-binary-fill',
						),
						'file-earmark-break' => array(
							'ID' => 'file-earmark-break',
						),
						'file-earmark-break-fill' => array(
							'ID' => 'file-earmark-break-fill',
						),
						'file-earmark-check' => array(
							'ID' => 'file-earmark-check',
						),
						'file-earmark-check-fill' => array(
							'ID' => 'file-earmark-check-fill',
						),
						'file-earmark-code' => array(
							'ID' => 'file-earmark-code',
						),
						'file-earmark-code-fill' => array(
							'ID' => 'file-earmark-code-fill',
						),
						'file-earmark-diff' => array(
							'ID' => 'file-earmark-diff',
						),
						'file-earmark-diff-fill' => array(
							'ID' => 'file-earmark-diff-fill',
						),
						'file-earmark-easel' => array(
							'ID' => 'file-earmark-easel',
						),
						'file-earmark-easel-fill' => array(
							'ID' => 'file-earmark-easel-fill',
						),
						'file-earmark-excel' => array(
							'ID' => 'file-earmark-excel',
						),
						'file-earmark-excel-fill' => array(
							'ID' => 'file-earmark-excel-fill',
						),
						'file-earmark-fill' => array(
							'ID' => 'file-earmark-fill',
						),
						'file-earmark-font' => array(
							'ID' => 'file-earmark-font',
						),
						'file-earmark-font-fill' => array(
							'ID' => 'file-earmark-font-fill',
						),
						'file-earmark-image' => array(
							'ID' => 'file-earmark-image',
						),
						'file-earmark-image-fill' => array(
							'ID' => 'file-earmark-image-fill',
						),
						'file-earmark-lock' => array(
							'ID' => 'file-earmark-lock',
						),
						'file-earmark-lock-fill' => array(
							'ID' => 'file-earmark-lock-fill',
						),
						'file-earmark-lock2' => array(
							'ID' => 'file-earmark-lock2',
						),
						'file-earmark-lock2-fill' => array(
							'ID' => 'file-earmark-lock2-fill',
						),
						'file-earmark-medical' => array(
							'ID' => 'file-earmark-medical',
						),
						'file-earmark-medical-fill' => array(
							'ID' => 'file-earmark-medical-fill',
						),
						'file-earmark-minus' => array(
							'ID' => 'file-earmark-minus',
						),
						'file-earmark-minus-fill' => array(
							'ID' => 'file-earmark-minus-fill',
						),
						'file-earmark-music' => array(
							'ID' => 'file-earmark-music',
						),
						'file-earmark-music-fill' => array(
							'ID' => 'file-earmark-music-fill',
						),
						'file-earmark-pdf' => array(
							'ID' => 'file-earmark-pdf',
						),
						'file-earmark-pdf-fill' => array(
							'ID' => 'file-earmark-pdf-fill',
						),
						'file-earmark-person' => array(
							'ID' => 'file-earmark-person',
						),
						'file-earmark-person-fill' => array(
							'ID' => 'file-earmark-person-fill',
						),
						'file-earmark-play' => array(
							'ID' => 'file-earmark-play',
						),
						'file-earmark-play-fill' => array(
							'ID' => 'file-earmark-play-fill',
						),
						'file-earmark-plus' => array(
							'ID' => 'file-earmark-plus',
						),
						'file-earmark-plus-fill' => array(
							'ID' => 'file-earmark-plus-fill',
						),
						'file-earmark-post' => array(
							'ID' => 'file-earmark-post',
						),
						'file-earmark-post-fill' => array(
							'ID' => 'file-earmark-post-fill',
						),
						'file-earmark-ppt' => array(
							'ID' => 'file-earmark-ppt',
						),
						'file-earmark-ppt-fill' => array(
							'ID' => 'file-earmark-ppt-fill',
						),
						'file-earmark-richtext' => array(
							'ID' => 'file-earmark-richtext',
						),
						'file-earmark-richtext-fill' => array(
							'ID' => 'file-earmark-richtext-fill',
						),
						'file-earmark-ruled' => array(
							'ID' => 'file-earmark-ruled',
						),
						'file-earmark-ruled-fill' => array(
							'ID' => 'file-earmark-ruled-fill',
						),
						'file-earmark-slides' => array(
							'ID' => 'file-earmark-slides',
						),
						'file-earmark-slides-fill' => array(
							'ID' => 'file-earmark-slides-fill',
						),
						'file-earmark-spreadsheet' => array(
							'ID' => 'file-earmark-spreadsheet',
						),
						'file-earmark-spreadsheet-fill' => array(
							'ID' => 'file-earmark-spreadsheet-fill',
						),
						'file-earmark-text' => array(
							'ID' => 'file-earmark-text',
						),
						'file-earmark-text-fill' => array(
							'ID' => 'file-earmark-text-fill',
						),
						'file-earmark-word' => array(
							'ID' => 'file-earmark-word',
						),
						'file-earmark-word-fill' => array(
							'ID' => 'file-earmark-word-fill',
						),
						'file-earmark-x' => array(
							'ID' => 'file-earmark-x',
						),
						'file-earmark-x-fill' => array(
							'ID' => 'file-earmark-x-fill',
						),
						'file-earmark-zip' => array(
							'ID' => 'file-earmark-zip',
						),
						'file-earmark-zip-fill' => array(
							'ID' => 'file-earmark-zip-fill',
						),
						'file-easel' => array(
							'ID' => 'file-easel',
						),
						'file-easel-fill' => array(
							'ID' => 'file-easel-fill',
						),
						'file-excel' => array(
							'ID' => 'file-excel',
						),
						'file-excel-fill' => array(
							'ID' => 'file-excel-fill',
						),
						'file-fill' => array(
							'ID' => 'file-fill',
						),
						'file-font' => array(
							'ID' => 'file-font',
						),
						'file-font-fill' => array(
							'ID' => 'file-font-fill',
						),
						'file-image' => array(
							'ID' => 'file-image',
						),
						'file-image-fill' => array(
							'ID' => 'file-image-fill',
						),
						'file-lock' => array(
							'ID' => 'file-lock',
						),
						'file-lock-fill' => array(
							'ID' => 'file-lock-fill',
						),
						'file-lock2' => array(
							'ID' => 'file-lock2',
						),
						'file-lock2-fill' => array(
							'ID' => 'file-lock2-fill',
						),
						'file-medical' => array(
							'ID' => 'file-medical',
						),
						'file-medical-fill' => array(
							'ID' => 'file-medical-fill',
						),
						'file-minus' => array(
							'ID' => 'file-minus',
						),
						'file-minus-fill' => array(
							'ID' => 'file-minus-fill',
						),
						'file-music' => array(
							'ID' => 'file-music',
						),
						'file-music-fill' => array(
							'ID' => 'file-music-fill',
						),
						'file-pdf' => array(
							'ID' => 'file-pdf',
						),
						'file-pdf-fill' => array(
							'ID' => 'file-pdf-fill',
						),
						'file-person' => array(
							'ID' => 'file-person',
						),
						'file-person-fill' => array(
							'ID' => 'file-person-fill',
						),
						'file-play' => array(
							'ID' => 'file-play',
						),
						'file-play-fill' => array(
							'ID' => 'file-play-fill',
						),
						'file-plus' => array(
							'ID' => 'file-plus',
						),
						'file-plus-fill' => array(
							'ID' => 'file-plus-fill',
						),
						'file-post' => array(
							'ID' => 'file-post',
						),
						'file-post-fill' => array(
							'ID' => 'file-post-fill',
						),
						'file-ppt' => array(
							'ID' => 'file-ppt',
						),
						'file-ppt-fill' => array(
							'ID' => 'file-ppt-fill',
						),
						'file-richtext' => array(
							'ID' => 'file-richtext',
						),
						'file-richtext-fill' => array(
							'ID' => 'file-richtext-fill',
						),
						'file-ruled' => array(
							'ID' => 'file-ruled',
						),
						'file-ruled-fill' => array(
							'ID' => 'file-ruled-fill',
						),
						'file-slides' => array(
							'ID' => 'file-slides',
						),
						'file-slides-fill' => array(
							'ID' => 'file-slides-fill',
						),
						'file-spreadsheet' => array(
							'ID' => 'file-spreadsheet',
						),
						'file-spreadsheet-fill' => array(
							'ID' => 'file-spreadsheet-fill',
						),
						'file-text' => array(
							'ID' => 'file-text',
						),
						'file-text-fill' => array(
							'ID' => 'file-text-fill',
						),
						'file-word' => array(
							'ID' => 'file-word',
						),
						'file-word-fill' => array(
							'ID' => 'file-word-fill',
						),
						'file-x' => array(
							'ID' => 'file-x',
						),
						'file-x-fill' => array(
							'ID' => 'file-x-fill',
						),
						'file-zip' => array(
							'ID' => 'file-zip',
						),
						'file-zip-fill' => array(
							'ID' => 'file-zip-fill',
						),
						'files' => array(
							'ID' => 'files',
						),
						'files-alt' => array(
							'ID' => 'files-alt',
						),
						'film' => array(
							'ID' => 'film',
						),
						'filter' => array(
							'ID' => 'filter',
						),
						'filter-circle' => array(
							'ID' => 'filter-circle',
						),
						'filter-circle-fill' => array(
							'ID' => 'filter-circle-fill',
						),
						'filter-left' => array(
							'ID' => 'filter-left',
						),
						'filter-right' => array(
							'ID' => 'filter-right',
						),
						'filter-square' => array(
							'ID' => 'filter-square',
						),
						'filter-square-fill' => array(
							'ID' => 'filter-square-fill',
						),
						'fingerprint' => array(
							'ID' => 'fingerprint',
						),
						'flag' => array(
							'ID' => 'flag',
						),
						'flag-fill' => array(
							'ID' => 'flag-fill',
						),
						'flower1' => array(
							'ID' => 'flower1',
						),
						'flower2' => array(
							'ID' => 'flower2',
						),
						'flower3' => array(
							'ID' => 'flower3',
						),
						'folder' => array(
							'ID' => 'folder',
						),
						'folder-check' => array(
							'ID' => 'folder-check',
						),
						'folder-fill' => array(
							'ID' => 'folder-fill',
						),
						'folder-minus' => array(
							'ID' => 'folder-minus',
						),
						'folder-plus' => array(
							'ID' => 'folder-plus',
						),
						'folder-symlink' => array(
							'ID' => 'folder-symlink',
						),
						'folder-symlink-fill' => array(
							'ID' => 'folder-symlink-fill',
						),
						'folder-x' => array(
							'ID' => 'folder-x',
						),
						'folder2' => array(
							'ID' => 'folder2',
						),
						'folder2-open' => array(
							'ID' => 'folder2-open',
						),
						'fonts' => array(
							'ID' => 'fonts',
						),
						'forward' => array(
							'ID' => 'forward',
						),
						'forward-fill' => array(
							'ID' => 'forward-fill',
						),
						'front' => array(
							'ID' => 'front',
						),
						'fullscreen' => array(
							'ID' => 'fullscreen',
						),
						'fullscreen-exit' => array(
							'ID' => 'fullscreen-exit',
						),
						'funnel' => array(
							'ID' => 'funnel',
						),
						'funnel-fill' => array(
							'ID' => 'funnel-fill',
						),
						'gear' => array(
							'ID' => 'gear',
						),
						'gear-fill' => array(
							'ID' => 'gear-fill',
						),
						'gear-wide' => array(
							'ID' => 'gear-wide',
						),
						'gear-wide-connected' => array(
							'ID' => 'gear-wide-connected',
						),
						'gem' => array(
							'ID' => 'gem',
						),
						'gender-ambiguous' => array(
							'ID' => 'gender-ambiguous',
						),
						'gender-female' => array(
							'ID' => 'gender-female',
						),
						'gender-male' => array(
							'ID' => 'gender-male',
						),
						'gender-trans' => array(
							'ID' => 'gender-trans',
						),
						'geo' => array(
							'ID' => 'geo',
						),
						'geo-alt' => array(
							'ID' => 'geo-alt',
						),
						'geo-alt-fill' => array(
							'ID' => 'geo-alt-fill',
						),
						'geo-fill' => array(
							'ID' => 'geo-fill',
						),
						'gift' => array(
							'ID' => 'gift',
						),
						'gift-fill' => array(
							'ID' => 'gift-fill',
						),
						'git' => array(
							'ID' => 'git',
						),
						'github' => array(
							'ID' => 'github',
						),
						'globe' => array(
							'ID' => 'globe',
						),
						'globe2' => array(
							'ID' => 'globe2',
						),
						'google' => array(
							'ID' => 'google',
						),
						'gpu-card' => array(
							'ID' => 'gpu-card',
						),
						'graph-down' => array(
							'ID' => 'graph-down',
						),
						'graph-down-arrow' => array(
							'ID' => 'graph-down-arrow',
						),
						'graph-up' => array(
							'ID' => 'graph-up',
						),
						'graph-up-arrow' => array(
							'ID' => 'graph-up-arrow',
						),
						'grid' => array(
							'ID' => 'grid',
						),
						'grid-1x2' => array(
							'ID' => 'grid-1x2',
						),
						'grid-1x2-fill' => array(
							'ID' => 'grid-1x2-fill',
						),
						'grid-3x2' => array(
							'ID' => 'grid-3x2',
						),
						'grid-3x2-gap' => array(
							'ID' => 'grid-3x2-gap',
						),
						'grid-3x2-gap-fill' => array(
							'ID' => 'grid-3x2-gap-fill',
						),
						'grid-3x3' => array(
							'ID' => 'grid-3x3',
						),
						'grid-3x3-gap' => array(
							'ID' => 'grid-3x3-gap',
						),
						'grid-3x3-gap-fill' => array(
							'ID' => 'grid-3x3-gap-fill',
						),
						'grid-fill' => array(
							'ID' => 'grid-fill',
						),
						'grip-horizontal' => array(
							'ID' => 'grip-horizontal',
						),
						'grip-vertical' => array(
							'ID' => 'grip-vertical',
						),
						'hammer' => array(
							'ID' => 'hammer',
						),
						'hand-index' => array(
							'ID' => 'hand-index',
						),
						'hand-index-fill' => array(
							'ID' => 'hand-index-fill',
						),
						'hand-index-thumb' => array(
							'ID' => 'hand-index-thumb',
						),
						'hand-index-thumb-fill' => array(
							'ID' => 'hand-index-thumb-fill',
						),
						'hand-thumbs-down' => array(
							'ID' => 'hand-thumbs-down',
						),
						'hand-thumbs-down-fill' => array(
							'ID' => 'hand-thumbs-down-fill',
						),
						'hand-thumbs-up' => array(
							'ID' => 'hand-thumbs-up',
						),
						'hand-thumbs-up-fill' => array(
							'ID' => 'hand-thumbs-up-fill',
						),
						'handbag' => array(
							'ID' => 'handbag',
						),
						'handbag-fill' => array(
							'ID' => 'handbag-fill',
						),
						'hash' => array(
							'ID' => 'hash',
						),
						'hdd' => array(
							'ID' => 'hdd',
						),
						'hdd-fill' => array(
							'ID' => 'hdd-fill',
						),
						'hdd-network' => array(
							'ID' => 'hdd-network',
						),
						'hdd-network-fill' => array(
							'ID' => 'hdd-network-fill',
						),
						'hdd-rack' => array(
							'ID' => 'hdd-rack',
						),
						'hdd-rack-fill' => array(
							'ID' => 'hdd-rack-fill',
						),
						'hdd-stack' => array(
							'ID' => 'hdd-stack',
						),
						'hdd-stack-fill' => array(
							'ID' => 'hdd-stack-fill',
						),
						'hdmi' => array(
							'ID' => 'hdmi',
						),
						'hdmi-fill' => array(
							'ID' => 'hdmi-fill',
						),
						'headphones' => array(
							'ID' => 'headphones',
						),
						'headset' => array(
							'ID' => 'headset',
						),
						'headset-vr' => array(
							'ID' => 'headset-vr',
						),
						'heart' => array(
							'ID' => 'heart',
						),
						'heart-fill' => array(
							'ID' => 'heart-fill',
						),
						'heart-half' => array(
							'ID' => 'heart-half',
						),
						'heptagon' => array(
							'ID' => 'heptagon',
						),
						'heptagon-fill' => array(
							'ID' => 'heptagon-fill',
						),
						'heptagon-half' => array(
							'ID' => 'heptagon-half',
						),
						'hexagon' => array(
							'ID' => 'hexagon',
						),
						'hexagon-fill' => array(
							'ID' => 'hexagon-fill',
						),
						'hexagon-half' => array(
							'ID' => 'hexagon-half',
						),
						'hourglass' => array(
							'ID' => 'hourglass',
						),
						'hourglass-bottom' => array(
							'ID' => 'hourglass-bottom',
						),
						'hourglass-split' => array(
							'ID' => 'hourglass-split',
						),
						'hourglass-top' => array(
							'ID' => 'hourglass-top',
						),
						'house' => array(
							'ID' => 'house',
						),
						'house-door' => array(
							'ID' => 'house-door',
						),
						'house-door-fill' => array(
							'ID' => 'house-door-fill',
						),
						'house-fill' => array(
							'ID' => 'house-fill',
						),
						'hr' => array(
							'ID' => 'hr',
						),
						'hurricane' => array(
							'ID' => 'hurricane',
						),
						'hypnotize' => array(
							'ID' => 'hypnotize',
						),
						'image' => array(
							'ID' => 'image',
						),
						'image-alt' => array(
							'ID' => 'image-alt',
						),
						'image-fill' => array(
							'ID' => 'image-fill',
						),
						'images' => array(
							'ID' => 'images',
						),
						'inbox' => array(
							'ID' => 'inbox',
						),
						'inbox-fill' => array(
							'ID' => 'inbox-fill',
						),
						'inboxes' => array(
							'ID' => 'inboxes',
						),
						'inboxes-fill' => array(
							'ID' => 'inboxes-fill',
						),
						'infinity' => array(
							'ID' => 'infinity',
						),
						'info' => array(
							'ID' => 'info',
						),
						'info-circle' => array(
							'ID' => 'info-circle',
						),
						'info-circle-fill' => array(
							'ID' => 'info-circle-fill',
						),
						'info-lg' => array(
							'ID' => 'info-lg',
						),
						'info-square' => array(
							'ID' => 'info-square',
						),
						'info-square-fill' => array(
							'ID' => 'info-square-fill',
						),
						'input-cursor' => array(
							'ID' => 'input-cursor',
						),
						'input-cursor-text' => array(
							'ID' => 'input-cursor-text',
						),
						'instagram' => array(
							'ID' => 'instagram',
						),
						'intersect' => array(
							'ID' => 'intersect',
						),
						'journal' => array(
							'ID' => 'journal',
						),
						'journal-album' => array(
							'ID' => 'journal-album',
						),
						'journal-arrow-down' => array(
							'ID' => 'journal-arrow-down',
						),
						'journal-arrow-up' => array(
							'ID' => 'journal-arrow-up',
						),
						'journal-bookmark' => array(
							'ID' => 'journal-bookmark',
						),
						'journal-bookmark-fill' => array(
							'ID' => 'journal-bookmark-fill',
						),
						'journal-check' => array(
							'ID' => 'journal-check',
						),
						'journal-code' => array(
							'ID' => 'journal-code',
						),
						'journal-medical' => array(
							'ID' => 'journal-medical',
						),
						'journal-minus' => array(
							'ID' => 'journal-minus',
						),
						'journal-plus' => array(
							'ID' => 'journal-plus',
						),
						'journal-richtext' => array(
							'ID' => 'journal-richtext',
						),
						'journal-text' => array(
							'ID' => 'journal-text',
						),
						'journal-x' => array(
							'ID' => 'journal-x',
						),
						'journals' => array(
							'ID' => 'journals',
						),
						'joystick' => array(
							'ID' => 'joystick',
						),
						'justify' => array(
							'ID' => 'justify',
						),
						'justify-left' => array(
							'ID' => 'justify-left',
						),
						'justify-right' => array(
							'ID' => 'justify-right',
						),
						'kanban' => array(
							'ID' => 'kanban',
						),
						'kanban-fill' => array(
							'ID' => 'kanban-fill',
						),
						'key' => array(
							'ID' => 'key',
						),
						'key-fill' => array(
							'ID' => 'key-fill',
						),
						'keyboard' => array(
							'ID' => 'keyboard',
						),
						'keyboard-fill' => array(
							'ID' => 'keyboard-fill',
						),
						'ladder' => array(
							'ID' => 'ladder',
						),
						'lamp' => array(
							'ID' => 'lamp',
						),
						'lamp-fill' => array(
							'ID' => 'lamp-fill',
						),
						'laptop' => array(
							'ID' => 'laptop',
						),
						'laptop-fill' => array(
							'ID' => 'laptop-fill',
						),
						'layer-backward' => array(
							'ID' => 'layer-backward',
						),
						'layer-forward' => array(
							'ID' => 'layer-forward',
						),
						'layers' => array(
							'ID' => 'layers',
						),
						'layers-fill' => array(
							'ID' => 'layers-fill',
						),
						'layers-half' => array(
							'ID' => 'layers-half',
						),
						'layout-sidebar' => array(
							'ID' => 'layout-sidebar',
						),
						'layout-sidebar-inset' => array(
							'ID' => 'layout-sidebar-inset',
						),
						'layout-sidebar-inset-reverse' => array(
							'ID' => 'layout-sidebar-inset-reverse',
						),
						'layout-sidebar-reverse' => array(
							'ID' => 'layout-sidebar-reverse',
						),
						'layout-split' => array(
							'ID' => 'layout-split',
						),
						'layout-text-sidebar' => array(
							'ID' => 'layout-text-sidebar',
						),
						'layout-text-sidebar-reverse' => array(
							'ID' => 'layout-text-sidebar-reverse',
						),
						'layout-text-window' => array(
							'ID' => 'layout-text-window',
						),
						'layout-text-window-reverse' => array(
							'ID' => 'layout-text-window-reverse',
						),
						'layout-three-columns' => array(
							'ID' => 'layout-three-columns',
						),
						'layout-wtf' => array(
							'ID' => 'layout-wtf',
						),
						'life-preserver' => array(
							'ID' => 'life-preserver',
						),
						'lightbulb' => array(
							'ID' => 'lightbulb',
						),
						'lightbulb-fill' => array(
							'ID' => 'lightbulb-fill',
						),
						'lightbulb-off' => array(
							'ID' => 'lightbulb-off',
						),
						'lightbulb-off-fill' => array(
							'ID' => 'lightbulb-off-fill',
						),
						'lightning' => array(
							'ID' => 'lightning',
						),
						'lightning-charge' => array(
							'ID' => 'lightning-charge',
						),
						'lightning-charge-fill' => array(
							'ID' => 'lightning-charge-fill',
						),
						'lightning-fill' => array(
							'ID' => 'lightning-fill',
						),
						'line' => array(
							'ID' => 'line',
						),
						'link' => array(
							'ID' => 'link',
						),
						'link-45deg' => array(
							'ID' => 'link-45deg',
						),
						'linkedin' => array(
							'ID' => 'linkedin',
						),
						'list' => array(
							'ID' => 'list',
						),
						'list-check' => array(
							'ID' => 'list-check',
						),
						'list-columns' => array(
							'ID' => 'list-columns',
						),
						'list-columns-reverse' => array(
							'ID' => 'list-columns-reverse',
						),
						'list-nested' => array(
							'ID' => 'list-nested',
						),
						'list-ol' => array(
							'ID' => 'list-ol',
						),
						'list-stars' => array(
							'ID' => 'list-stars',
						),
						'list-task' => array(
							'ID' => 'list-task',
						),
						'list-ul' => array(
							'ID' => 'list-ul',
						),
						'lock' => array(
							'ID' => 'lock',
						),
						'lock-fill' => array(
							'ID' => 'lock-fill',
						),
						'magic' => array(
							'ID' => 'magic',
						),
						'mailbox' => array(
							'ID' => 'mailbox',
						),
						'mailbox2' => array(
							'ID' => 'mailbox2',
						),
						'map' => array(
							'ID' => 'map',
						),
						'map-fill' => array(
							'ID' => 'map-fill',
						),
						'markdown' => array(
							'ID' => 'markdown',
						),
						'markdown-fill' => array(
							'ID' => 'markdown-fill',
						),
						'mask' => array(
							'ID' => 'mask',
						),
						'mastodon' => array(
							'ID' => 'mastodon',
						),
						'medium' => array(
							'ID' => 'medium',
						),
						'megaphone' => array(
							'ID' => 'megaphone',
						),
						'megaphone-fill' => array(
							'ID' => 'megaphone-fill',
						),
						'memory' => array(
							'ID' => 'memory',
						),
						'menu-app' => array(
							'ID' => 'menu-app',
						),
						'menu-app-fill' => array(
							'ID' => 'menu-app-fill',
						),
						'menu-button' => array(
							'ID' => 'menu-button',
						),
						'menu-button-fill' => array(
							'ID' => 'menu-button-fill',
						),
						'menu-button-wide' => array(
							'ID' => 'menu-button-wide',
						),
						'menu-button-wide-fill' => array(
							'ID' => 'menu-button-wide-fill',
						),
						'menu-down' => array(
							'ID' => 'menu-down',
						),
						'menu-up' => array(
							'ID' => 'menu-up',
						),
						'messenger' => array(
							'ID' => 'messenger',
						),
						'meta' => array(
							'ID' => 'meta',
						),
						'mic' => array(
							'ID' => 'mic',
						),
						'mic-fill' => array(
							'ID' => 'mic-fill',
						),
						'mic-mute' => array(
							'ID' => 'mic-mute',
						),
						'mic-mute-fill' => array(
							'ID' => 'mic-mute-fill',
						),
						'microsoft' => array(
							'ID' => 'microsoft',
						),
						'minecart' => array(
							'ID' => 'minecart',
						),
						'minecart-loaded' => array(
							'ID' => 'minecart-loaded',
						),
						'modem' => array(
							'ID' => 'modem',
						),
						'modem-fill' => array(
							'ID' => 'modem-fill',
						),
						'moisture' => array(
							'ID' => 'moisture',
						),
						'moon' => array(
							'ID' => 'moon',
						),
						'moon-fill' => array(
							'ID' => 'moon-fill',
						),
						'moon-stars' => array(
							'ID' => 'moon-stars',
						),
						'moon-stars-fill' => array(
							'ID' => 'moon-stars-fill',
						),
						'mortarboard' => array(
							'ID' => 'mortarboard',
						),
						'mortarboard-fill' => array(
							'ID' => 'mortarboard-fill',
						),
						'motherboard' => array(
							'ID' => 'motherboard',
						),
						'motherboard-fill' => array(
							'ID' => 'motherboard-fill',
						),
						'mouse' => array(
							'ID' => 'mouse',
						),
						'mouse-fill' => array(
							'ID' => 'mouse-fill',
						),
						'mouse2' => array(
							'ID' => 'mouse2',
						),
						'mouse2-fill' => array(
							'ID' => 'mouse2-fill',
						),
						'mouse3' => array(
							'ID' => 'mouse3',
						),
						'mouse3-fill' => array(
							'ID' => 'mouse3-fill',
						),
						'music-note' => array(
							'ID' => 'music-note',
						),
						'music-note-beamed' => array(
							'ID' => 'music-note-beamed',
						),
						'music-note-list' => array(
							'ID' => 'music-note-list',
						),
						'music-player' => array(
							'ID' => 'music-player',
						),
						'music-player-fill' => array(
							'ID' => 'music-player-fill',
						),
						'newspaper' => array(
							'ID' => 'newspaper',
						),
						'nintendo-switch' => array(
							'ID' => 'nintendo-switch',
						),
						'node-minus' => array(
							'ID' => 'node-minus',
						),
						'node-minus-fill' => array(
							'ID' => 'node-minus-fill',
						),
						'node-plus' => array(
							'ID' => 'node-plus',
						),
						'node-plus-fill' => array(
							'ID' => 'node-plus-fill',
						),
						'nut' => array(
							'ID' => 'nut',
						),
						'nut-fill' => array(
							'ID' => 'nut-fill',
						),
						'octagon' => array(
							'ID' => 'octagon',
						),
						'octagon-fill' => array(
							'ID' => 'octagon-fill',
						),
						'octagon-half' => array(
							'ID' => 'octagon-half',
						),
						'optical-audio' => array(
							'ID' => 'optical-audio',
						),
						'optical-audio-fill' => array(
							'ID' => 'optical-audio-fill',
						),
						'option' => array(
							'ID' => 'option',
						),
						'outlet' => array(
							'ID' => 'outlet',
						),
						'paint-bucket' => array(
							'ID' => 'paint-bucket',
						),
						'palette' => array(
							'ID' => 'palette',
						),
						'palette-fill' => array(
							'ID' => 'palette-fill',
						),
						'palette2' => array(
							'ID' => 'palette2',
						),
						'paperclip' => array(
							'ID' => 'paperclip',
						),
						'paragraph' => array(
							'ID' => 'paragraph',
						),
						'patch-check' => array(
							'ID' => 'patch-check',
						),
						'patch-check-fill' => array(
							'ID' => 'patch-check-fill',
						),
						'patch-exclamation' => array(
							'ID' => 'patch-exclamation',
						),
						'patch-exclamation-fill' => array(
							'ID' => 'patch-exclamation-fill',
						),
						'patch-minus' => array(
							'ID' => 'patch-minus',
						),
						'patch-minus-fill' => array(
							'ID' => 'patch-minus-fill',
						),
						'patch-plus' => array(
							'ID' => 'patch-plus',
						),
						'patch-plus-fill' => array(
							'ID' => 'patch-plus-fill',
						),
						'patch-question' => array(
							'ID' => 'patch-question',
						),
						'patch-question-fill' => array(
							'ID' => 'patch-question-fill',
						),
						'pause' => array(
							'ID' => 'pause',
						),
						'pause-btn' => array(
							'ID' => 'pause-btn',
						),
						'pause-btn-fill' => array(
							'ID' => 'pause-btn-fill',
						),
						'pause-circle' => array(
							'ID' => 'pause-circle',
						),
						'pause-circle-fill' => array(
							'ID' => 'pause-circle-fill',
						),
						'pause-fill' => array(
							'ID' => 'pause-fill',
						),
						'paypal' => array(
							'ID' => 'paypal',
						),
						'pc' => array(
							'ID' => 'pc',
						),
						'pc-display' => array(
							'ID' => 'pc-display',
						),
						'pc-display-horizontal' => array(
							'ID' => 'pc-display-horizontal',
						),
						'pc-horizontal' => array(
							'ID' => 'pc-horizontal',
						),
						'pci-card' => array(
							'ID' => 'pci-card',
						),
						'peace' => array(
							'ID' => 'peace',
						),
						'peace-fill' => array(
							'ID' => 'peace-fill',
						),
						'pen' => array(
							'ID' => 'pen',
						),
						'pen-fill' => array(
							'ID' => 'pen-fill',
						),
						'pencil' => array(
							'ID' => 'pencil',
						),
						'pencil-fill' => array(
							'ID' => 'pencil-fill',
						),
						'pencil-square' => array(
							'ID' => 'pencil-square',
						),
						'pentagon' => array(
							'ID' => 'pentagon',
						),
						'pentagon-fill' => array(
							'ID' => 'pentagon-fill',
						),
						'pentagon-half' => array(
							'ID' => 'pentagon-half',
						),
						'people' => array(
							'ID' => 'people',
						),
						'people-fill' => array(
							'ID' => 'people-fill',
						),
						'percent' => array(
							'ID' => 'percent',
						),
						'person' => array(
							'ID' => 'person',
						),
						'person-badge' => array(
							'ID' => 'person-badge',
						),
						'person-badge-fill' => array(
							'ID' => 'person-badge-fill',
						),
						'person-bounding-box' => array(
							'ID' => 'person-bounding-box',
						),
						'person-check' => array(
							'ID' => 'person-check',
						),
						'person-check-fill' => array(
							'ID' => 'person-check-fill',
						),
						'person-circle' => array(
							'ID' => 'person-circle',
						),
						'person-dash' => array(
							'ID' => 'person-dash',
						),
						'person-dash-fill' => array(
							'ID' => 'person-dash-fill',
						),
						'person-fill' => array(
							'ID' => 'person-fill',
						),
						'person-lines-fill' => array(
							'ID' => 'person-lines-fill',
						),
						'person-plus' => array(
							'ID' => 'person-plus',
						),
						'person-plus-fill' => array(
							'ID' => 'person-plus-fill',
						),
						'person-rolodex' => array(
							'ID' => 'person-rolodex',
						),
						'person-square' => array(
							'ID' => 'person-square',
						),
						'person-video' => array(
							'ID' => 'person-video',
						),
						'person-video2' => array(
							'ID' => 'person-video2',
						),
						'person-video3' => array(
							'ID' => 'person-video3',
						),
						'person-workspace' => array(
							'ID' => 'person-workspace',
						),
						'person-x' => array(
							'ID' => 'person-x',
						),
						'person-x-fill' => array(
							'ID' => 'person-x-fill',
						),
						'phone' => array(
							'ID' => 'phone',
						),
						'phone-fill' => array(
							'ID' => 'phone-fill',
						),
						'phone-landscape' => array(
							'ID' => 'phone-landscape',
						),
						'phone-landscape-fill' => array(
							'ID' => 'phone-landscape-fill',
						),
						'phone-vibrate' => array(
							'ID' => 'phone-vibrate',
						),
						'phone-vibrate-fill' => array(
							'ID' => 'phone-vibrate-fill',
						),
						'pie-chart' => array(
							'ID' => 'pie-chart',
						),
						'pie-chart-fill' => array(
							'ID' => 'pie-chart-fill',
						),
						'piggy-bank' => array(
							'ID' => 'piggy-bank',
						),
						'piggy-bank-fill' => array(
							'ID' => 'piggy-bank-fill',
						),
						'pin' => array(
							'ID' => 'pin',
						),
						'pin-angle' => array(
							'ID' => 'pin-angle',
						),
						'pin-angle-fill' => array(
							'ID' => 'pin-angle-fill',
						),
						'pin-fill' => array(
							'ID' => 'pin-fill',
						),
						'pin-map' => array(
							'ID' => 'pin-map',
						),
						'pin-map-fill' => array(
							'ID' => 'pin-map-fill',
						),
						'pinterest' => array(
							'ID' => 'pinterest',
						),
						'pip' => array(
							'ID' => 'pip',
						),
						'pip-fill' => array(
							'ID' => 'pip-fill',
						),
						'play' => array(
							'ID' => 'play',
						),
						'play-btn' => array(
							'ID' => 'play-btn',
						),
						'play-btn-fill' => array(
							'ID' => 'play-btn-fill',
						),
						'play-circle' => array(
							'ID' => 'play-circle',
						),
						'play-circle-fill' => array(
							'ID' => 'play-circle-fill',
						),
						'play-fill' => array(
							'ID' => 'play-fill',
						),
						'playstation' => array(
							'ID' => 'playstation',
						),
						'plug' => array(
							'ID' => 'plug',
						),
						'plug-fill' => array(
							'ID' => 'plug-fill',
						),
						'plus' => array(
							'ID' => 'plus',
						),
						'plus-circle' => array(
							'ID' => 'plus-circle',
						),
						'plus-circle-dotted' => array(
							'ID' => 'plus-circle-dotted',
						),
						'plus-circle-fill' => array(
							'ID' => 'plus-circle-fill',
						),
						'plus-lg' => array(
							'ID' => 'plus-lg',
						),
						'plus-slash-minus' => array(
							'ID' => 'plus-slash-minus',
						),
						'plus-square' => array(
							'ID' => 'plus-square',
						),
						'plus-square-dotted' => array(
							'ID' => 'plus-square-dotted',
						),
						'plus-square-fill' => array(
							'ID' => 'plus-square-fill',
						),
						'power' => array(
							'ID' => 'power',
						),
						'printer' => array(
							'ID' => 'printer',
						),
						'printer-fill' => array(
							'ID' => 'printer-fill',
						),
						'projector' => array(
							'ID' => 'projector',
						),
						'projector-fill' => array(
							'ID' => 'projector-fill',
						),
						'puzzle' => array(
							'ID' => 'puzzle',
						),
						'puzzle-fill' => array(
							'ID' => 'puzzle-fill',
						),
						'qr-code' => array(
							'ID' => 'qr-code',
						),
						'qr-code-scan' => array(
							'ID' => 'qr-code-scan',
						),
						'question' => array(
							'ID' => 'question',
						),
						'question-circle' => array(
							'ID' => 'question-circle',
						),
						'question-circle-fill' => array(
							'ID' => 'question-circle-fill',
						),
						'question-diamond' => array(
							'ID' => 'question-diamond',
						),
						'question-diamond-fill' => array(
							'ID' => 'question-diamond-fill',
						),
						'question-lg' => array(
							'ID' => 'question-lg',
						),
						'question-octagon' => array(
							'ID' => 'question-octagon',
						),
						'question-octagon-fill' => array(
							'ID' => 'question-octagon-fill',
						),
						'question-square' => array(
							'ID' => 'question-square',
						),
						'question-square-fill' => array(
							'ID' => 'question-square-fill',
						),
						'quora' => array(
							'ID' => 'quora',
						),
						'quote' => array(
							'ID' => 'quote',
						),
						'radioactive' => array(
							'ID' => 'radioactive',
						),
						'rainbow' => array(
							'ID' => 'rainbow',
						),
						'receipt' => array(
							'ID' => 'receipt',
						),
						'receipt-cutoff' => array(
							'ID' => 'receipt-cutoff',
						),
						'reception-0' => array(
							'ID' => 'reception-0',
						),
						'reception-1' => array(
							'ID' => 'reception-1',
						),
						'reception-2' => array(
							'ID' => 'reception-2',
						),
						'reception-3' => array(
							'ID' => 'reception-3',
						),
						'reception-4' => array(
							'ID' => 'reception-4',
						),
						'record' => array(
							'ID' => 'record',
						),
						'record-btn' => array(
							'ID' => 'record-btn',
						),
						'record-btn-fill' => array(
							'ID' => 'record-btn-fill',
						),
						'record-circle' => array(
							'ID' => 'record-circle',
						),
						'record-circle-fill' => array(
							'ID' => 'record-circle-fill',
						),
						'record-fill' => array(
							'ID' => 'record-fill',
						),
						'record2' => array(
							'ID' => 'record2',
						),
						'record2-fill' => array(
							'ID' => 'record2-fill',
						),
						'recycle' => array(
							'ID' => 'recycle',
						),
						'reddit' => array(
							'ID' => 'reddit',
						),
						'reply' => array(
							'ID' => 'reply',
						),
						'reply-all' => array(
							'ID' => 'reply-all',
						),
						'reply-all-fill' => array(
							'ID' => 'reply-all-fill',
						),
						'reply-fill' => array(
							'ID' => 'reply-fill',
						),
						'robot' => array(
							'ID' => 'robot',
						),
						'router' => array(
							'ID' => 'router',
						),
						'router-fill' => array(
							'ID' => 'router-fill',
						),
						'rss' => array(
							'ID' => 'rss',
						),
						'rss-fill' => array(
							'ID' => 'rss-fill',
						),
						'rulers' => array(
							'ID' => 'rulers',
						),
						'safe' => array(
							'ID' => 'safe',
						),
						'safe-fill' => array(
							'ID' => 'safe-fill',
						),
						'safe2' => array(
							'ID' => 'safe2',
						),
						'safe2-fill' => array(
							'ID' => 'safe2-fill',
						),
						'save' => array(
							'ID' => 'save',
						),
						'save-fill' => array(
							'ID' => 'save-fill',
						),
						'save2' => array(
							'ID' => 'save2',
						),
						'save2-fill' => array(
							'ID' => 'save2-fill',
						),
						'scissors' => array(
							'ID' => 'scissors',
						),
						'screwdriver' => array(
							'ID' => 'screwdriver',
						),
						'sd-card' => array(
							'ID' => 'sd-card',
						),
						'sd-card-fill' => array(
							'ID' => 'sd-card-fill',
						),
						'search' => array(
							'ID' => 'search',
						),
						'segmented-nav' => array(
							'ID' => 'segmented-nav',
						),
						'send' => array(
							'ID' => 'send',
						),
						'send-check' => array(
							'ID' => 'send-check',
						),
						'send-check-fill' => array(
							'ID' => 'send-check-fill',
						),
						'send-dash' => array(
							'ID' => 'send-dash',
						),
						'send-dash-fill' => array(
							'ID' => 'send-dash-fill',
						),
						'send-exclamation' => array(
							'ID' => 'send-exclamation',
						),
						'send-exclamation-fill' => array(
							'ID' => 'send-exclamation-fill',
						),
						'send-fill' => array(
							'ID' => 'send-fill',
						),
						'send-plus' => array(
							'ID' => 'send-plus',
						),
						'send-plus-fill' => array(
							'ID' => 'send-plus-fill',
						),
						'send-slash' => array(
							'ID' => 'send-slash',
						),
						'send-slash-fill' => array(
							'ID' => 'send-slash-fill',
						),
						'send-x' => array(
							'ID' => 'send-x',
						),
						'send-x-fill' => array(
							'ID' => 'send-x-fill',
						),
						'server' => array(
							'ID' => 'server',
						),
						'share' => array(
							'ID' => 'share',
						),
						'share-fill' => array(
							'ID' => 'share-fill',
						),
						'shield' => array(
							'ID' => 'shield',
						),
						'shield-check' => array(
							'ID' => 'shield-check',
						),
						'shield-exclamation' => array(
							'ID' => 'shield-exclamation',
						),
						'shield-fill' => array(
							'ID' => 'shield-fill',
						),
						'shield-fill-check' => array(
							'ID' => 'shield-fill-check',
						),
						'shield-fill-exclamation' => array(
							'ID' => 'shield-fill-exclamation',
						),
						'shield-fill-minus' => array(
							'ID' => 'shield-fill-minus',
						),
						'shield-fill-plus' => array(
							'ID' => 'shield-fill-plus',
						),
						'shield-fill-x' => array(
							'ID' => 'shield-fill-x',
						),
						'shield-lock' => array(
							'ID' => 'shield-lock',
						),
						'shield-lock-fill' => array(
							'ID' => 'shield-lock-fill',
						),
						'shield-minus' => array(
							'ID' => 'shield-minus',
						),
						'shield-plus' => array(
							'ID' => 'shield-plus',
						),
						'shield-shaded' => array(
							'ID' => 'shield-shaded',
						),
						'shield-slash' => array(
							'ID' => 'shield-slash',
						),
						'shield-slash-fill' => array(
							'ID' => 'shield-slash-fill',
						),
						'shield-x' => array(
							'ID' => 'shield-x',
						),
						'shift' => array(
							'ID' => 'shift',
						),
						'shift-fill' => array(
							'ID' => 'shift-fill',
						),
						'shop' => array(
							'ID' => 'shop',
						),
						'shop-window' => array(
							'ID' => 'shop-window',
						),
						'shuffle' => array(
							'ID' => 'shuffle',
						),
						'signal' => array(
							'ID' => 'signal',
						),
						'signpost' => array(
							'ID' => 'signpost',
						),
						'signpost-2' => array(
							'ID' => 'signpost-2',
						),
						'signpost-2-fill' => array(
							'ID' => 'signpost-2-fill',
						),
						'signpost-fill' => array(
							'ID' => 'signpost-fill',
						),
						'signpost-split' => array(
							'ID' => 'signpost-split',
						),
						'signpost-split-fill' => array(
							'ID' => 'signpost-split-fill',
						),
						'sim' => array(
							'ID' => 'sim',
						),
						'sim-fill' => array(
							'ID' => 'sim-fill',
						),
						'skip-backward' => array(
							'ID' => 'skip-backward',
						),
						'skip-backward-btn' => array(
							'ID' => 'skip-backward-btn',
						),
						'skip-backward-btn-fill' => array(
							'ID' => 'skip-backward-btn-fill',
						),
						'skip-backward-circle' => array(
							'ID' => 'skip-backward-circle',
						),
						'skip-backward-circle-fill' => array(
							'ID' => 'skip-backward-circle-fill',
						),
						'skip-backward-fill' => array(
							'ID' => 'skip-backward-fill',
						),
						'skip-end' => array(
							'ID' => 'skip-end',
						),
						'skip-end-btn' => array(
							'ID' => 'skip-end-btn',
						),
						'skip-end-btn-fill' => array(
							'ID' => 'skip-end-btn-fill',
						),
						'skip-end-circle' => array(
							'ID' => 'skip-end-circle',
						),
						'skip-end-circle-fill' => array(
							'ID' => 'skip-end-circle-fill',
						),
						'skip-end-fill' => array(
							'ID' => 'skip-end-fill',
						),
						'skip-forward' => array(
							'ID' => 'skip-forward',
						),
						'skip-forward-btn' => array(
							'ID' => 'skip-forward-btn',
						),
						'skip-forward-btn-fill' => array(
							'ID' => 'skip-forward-btn-fill',
						),
						'skip-forward-circle' => array(
							'ID' => 'skip-forward-circle',
						),
						'skip-forward-circle-fill' => array(
							'ID' => 'skip-forward-circle-fill',
						),
						'skip-forward-fill' => array(
							'ID' => 'skip-forward-fill',
						),
						'skip-start' => array(
							'ID' => 'skip-start',
						),
						'skip-start-btn' => array(
							'ID' => 'skip-start-btn',
						),
						'skip-start-btn-fill' => array(
							'ID' => 'skip-start-btn-fill',
						),
						'skip-start-circle' => array(
							'ID' => 'skip-start-circle',
						),
						'skip-start-circle-fill' => array(
							'ID' => 'skip-start-circle-fill',
						),
						'skip-start-fill' => array(
							'ID' => 'skip-start-fill',
						),
						'skype' => array(
							'ID' => 'skype',
						),
						'slack' => array(
							'ID' => 'slack',
						),
						'slash' => array(
							'ID' => 'slash',
						),
						'slash-circle' => array(
							'ID' => 'slash-circle',
						),
						'slash-circle-fill' => array(
							'ID' => 'slash-circle-fill',
						),
						'slash-lg' => array(
							'ID' => 'slash-lg',
						),
						'slash-square' => array(
							'ID' => 'slash-square',
						),
						'slash-square-fill' => array(
							'ID' => 'slash-square-fill',
						),
						'sliders' => array(
							'ID' => 'sliders',
						),
						'smartwatch' => array(
							'ID' => 'smartwatch',
						),
						'snapchat' => array(
							'ID' => 'snapchat',
						),
						'snow' => array(
							'ID' => 'snow',
						),
						'snow2' => array(
							'ID' => 'snow2',
						),
						'snow3' => array(
							'ID' => 'snow3',
						),
						'sort-alpha-down' => array(
							'ID' => 'sort-alpha-down',
						),
						'sort-alpha-down-alt' => array(
							'ID' => 'sort-alpha-down-alt',
						),
						'sort-alpha-up' => array(
							'ID' => 'sort-alpha-up',
						),
						'sort-alpha-up-alt' => array(
							'ID' => 'sort-alpha-up-alt',
						),
						'sort-down' => array(
							'ID' => 'sort-down',
						),
						'sort-down-alt' => array(
							'ID' => 'sort-down-alt',
						),
						'sort-numeric-down' => array(
							'ID' => 'sort-numeric-down',
						),
						'sort-numeric-down-alt' => array(
							'ID' => 'sort-numeric-down-alt',
						),
						'sort-numeric-up' => array(
							'ID' => 'sort-numeric-up',
						),
						'sort-numeric-up-alt' => array(
							'ID' => 'sort-numeric-up-alt',
						),
						'sort-up' => array(
							'ID' => 'sort-up',
						),
						'sort-up-alt' => array(
							'ID' => 'sort-up-alt',
						),
						'soundwave' => array(
							'ID' => 'soundwave',
						),
						'speaker' => array(
							'ID' => 'speaker',
						),
						'speaker-fill' => array(
							'ID' => 'speaker-fill',
						),
						'speedometer' => array(
							'ID' => 'speedometer',
						),
						'speedometer2' => array(
							'ID' => 'speedometer2',
						),
						'spellcheck' => array(
							'ID' => 'spellcheck',
						),
						'spotify' => array(
							'ID' => 'spotify',
						),
						'square' => array(
							'ID' => 'square',
						),
						'square-fill' => array(
							'ID' => 'square-fill',
						),
						'square-half' => array(
							'ID' => 'square-half',
						),
						'stack' => array(
							'ID' => 'stack',
						),
						'stack-overflow' => array(
							'ID' => 'stack-overflow',
						),
						'star' => array(
							'ID' => 'star',
						),
						'star-fill' => array(
							'ID' => 'star-fill',
						),
						'star-half' => array(
							'ID' => 'star-half',
						),
						'stars' => array(
							'ID' => 'stars',
						),
						'steam' => array(
							'ID' => 'steam',
						),
						'stickies' => array(
							'ID' => 'stickies',
						),
						'stickies-fill' => array(
							'ID' => 'stickies-fill',
						),
						'sticky' => array(
							'ID' => 'sticky',
						),
						'sticky-fill' => array(
							'ID' => 'sticky-fill',
						),
						'stop' => array(
							'ID' => 'stop',
						),
						'stop-btn' => array(
							'ID' => 'stop-btn',
						),
						'stop-btn-fill' => array(
							'ID' => 'stop-btn-fill',
						),
						'stop-circle' => array(
							'ID' => 'stop-circle',
						),
						'stop-circle-fill' => array(
							'ID' => 'stop-circle-fill',
						),
						'stop-fill' => array(
							'ID' => 'stop-fill',
						),
						'stoplights' => array(
							'ID' => 'stoplights',
						),
						'stoplights-fill' => array(
							'ID' => 'stoplights-fill',
						),
						'stopwatch' => array(
							'ID' => 'stopwatch',
						),
						'stopwatch-fill' => array(
							'ID' => 'stopwatch-fill',
						),
						'strava' => array(
							'ID' => 'strava',
						),
						'subtract' => array(
							'ID' => 'subtract',
						),
						'suit-club' => array(
							'ID' => 'suit-club',
						),
						'suit-club-fill' => array(
							'ID' => 'suit-club-fill',
						),
						'suit-diamond' => array(
							'ID' => 'suit-diamond',
						),
						'suit-diamond-fill' => array(
							'ID' => 'suit-diamond-fill',
						),
						'suit-heart' => array(
							'ID' => 'suit-heart',
						),
						'suit-heart-fill' => array(
							'ID' => 'suit-heart-fill',
						),
						'suit-spade' => array(
							'ID' => 'suit-spade',
						),
						'suit-spade-fill' => array(
							'ID' => 'suit-spade-fill',
						),
						'sun' => array(
							'ID' => 'sun',
						),
						'sun-fill' => array(
							'ID' => 'sun-fill',
						),
						'sunglasses' => array(
							'ID' => 'sunglasses',
						),
						'sunrise' => array(
							'ID' => 'sunrise',
						),
						'sunrise-fill' => array(
							'ID' => 'sunrise-fill',
						),
						'sunset' => array(
							'ID' => 'sunset',
						),
						'sunset-fill' => array(
							'ID' => 'sunset-fill',
						),
						'symmetry-horizontal' => array(
							'ID' => 'symmetry-horizontal',
						),
						'symmetry-vertical' => array(
							'ID' => 'symmetry-vertical',
						),
						'table' => array(
							'ID' => 'table',
						),
						'tablet' => array(
							'ID' => 'tablet',
						),
						'tablet-fill' => array(
							'ID' => 'tablet-fill',
						),
						'tablet-landscape' => array(
							'ID' => 'tablet-landscape',
						),
						'tablet-landscape-fill' => array(
							'ID' => 'tablet-landscape-fill',
						),
						'tag' => array(
							'ID' => 'tag',
						),
						'tag-fill' => array(
							'ID' => 'tag-fill',
						),
						'tags' => array(
							'ID' => 'tags',
						),
						'tags-fill' => array(
							'ID' => 'tags-fill',
						),
						'telegram' => array(
							'ID' => 'telegram',
						),
						'telephone' => array(
							'ID' => 'telephone',
						),
						'telephone-fill' => array(
							'ID' => 'telephone-fill',
						),
						'telephone-forward' => array(
							'ID' => 'telephone-forward',
						),
						'telephone-forward-fill' => array(
							'ID' => 'telephone-forward-fill',
						),
						'telephone-inbound' => array(
							'ID' => 'telephone-inbound',
						),
						'telephone-inbound-fill' => array(
							'ID' => 'telephone-inbound-fill',
						),
						'telephone-minus' => array(
							'ID' => 'telephone-minus',
						),
						'telephone-minus-fill' => array(
							'ID' => 'telephone-minus-fill',
						),
						'telephone-outbound' => array(
							'ID' => 'telephone-outbound',
						),
						'telephone-outbound-fill' => array(
							'ID' => 'telephone-outbound-fill',
						),
						'telephone-plus' => array(
							'ID' => 'telephone-plus',
						),
						'telephone-plus-fill' => array(
							'ID' => 'telephone-plus-fill',
						),
						'telephone-x' => array(
							'ID' => 'telephone-x',
						),
						'telephone-x-fill' => array(
							'ID' => 'telephone-x-fill',
						),
						'terminal' => array(
							'ID' => 'terminal',
						),
						'terminal-dash' => array(
							'ID' => 'terminal-dash',
						),
						'terminal-fill' => array(
							'ID' => 'terminal-fill',
						),
						'terminal-plus' => array(
							'ID' => 'terminal-plus',
						),
						'terminal-split' => array(
							'ID' => 'terminal-split',
						),
						'terminal-x' => array(
							'ID' => 'terminal-x',
						),
						'text-center' => array(
							'ID' => 'text-center',
						),
						'text-indent-left' => array(
							'ID' => 'text-indent-left',
						),
						'text-indent-right' => array(
							'ID' => 'text-indent-right',
						),
						'text-left' => array(
							'ID' => 'text-left',
						),
						'text-paragraph' => array(
							'ID' => 'text-paragraph',
						),
						'text-right' => array(
							'ID' => 'text-right',
						),
						'textarea' => array(
							'ID' => 'textarea',
						),
						'textarea-resize' => array(
							'ID' => 'textarea-resize',
						),
						'textarea-t' => array(
							'ID' => 'textarea-t',
						),
						'thermometer' => array(
							'ID' => 'thermometer',
						),
						'thermometer-half' => array(
							'ID' => 'thermometer-half',
						),
						'thermometer-high' => array(
							'ID' => 'thermometer-high',
						),
						'thermometer-low' => array(
							'ID' => 'thermometer-low',
						),
						'thermometer-snow' => array(
							'ID' => 'thermometer-snow',
						),
						'thermometer-sun' => array(
							'ID' => 'thermometer-sun',
						),
						'three-dots' => array(
							'ID' => 'three-dots',
						),
						'three-dots-vertical' => array(
							'ID' => 'three-dots-vertical',
						),
						'thunderbolt' => array(
							'ID' => 'thunderbolt',
						),
						'thunderbolt-fill' => array(
							'ID' => 'thunderbolt-fill',
						),
						'ticket' => array(
							'ID' => 'ticket',
						),
						'ticket-detailed' => array(
							'ID' => 'ticket-detailed',
						),
						'ticket-detailed-fill' => array(
							'ID' => 'ticket-detailed-fill',
						),
						'ticket-fill' => array(
							'ID' => 'ticket-fill',
						),
						'ticket-perferated' => array(
							'ID' => 'ticket-perferated',
						),
						'ticket-perferated-fill' => array(
							'ID' => 'ticket-perferated-fill',
						),
						'tiktok' => array(
							'ID' => 'tiktok',
						),
						'toggle-off' => array(
							'ID' => 'toggle-off',
						),
						'toggle-on' => array(
							'ID' => 'toggle-on',
						),
						'toggle2-off' => array(
							'ID' => 'toggle2-off',
						),
						'toggle2-on' => array(
							'ID' => 'toggle2-on',
						),
						'toggles' => array(
							'ID' => 'toggles',
						),
						'toggles2' => array(
							'ID' => 'toggles2',
						),
						'tools' => array(
							'ID' => 'tools',
						),
						'tornado' => array(
							'ID' => 'tornado',
						),
						'translate' => array(
							'ID' => 'translate',
						),
						'trash' => array(
							'ID' => 'trash',
						),
						'trash-fill' => array(
							'ID' => 'trash-fill',
						),
						'trash2' => array(
							'ID' => 'trash2',
						),
						'trash2-fill' => array(
							'ID' => 'trash2-fill',
						),
						'tree' => array(
							'ID' => 'tree',
						),
						'tree-fill' => array(
							'ID' => 'tree-fill',
						),
						'triangle' => array(
							'ID' => 'triangle',
						),
						'triangle-fill' => array(
							'ID' => 'triangle-fill',
						),
						'triangle-half' => array(
							'ID' => 'triangle-half',
						),
						'trophy' => array(
							'ID' => 'trophy',
						),
						'trophy-fill' => array(
							'ID' => 'trophy-fill',
						),
						'tropical-storm' => array(
							'ID' => 'tropical-storm',
						),
						'truck' => array(
							'ID' => 'truck',
						),
						'truck-flatbed' => array(
							'ID' => 'truck-flatbed',
						),
						'tsunami' => array(
							'ID' => 'tsunami',
						),
						'tv' => array(
							'ID' => 'tv',
						),
						'tv-fill' => array(
							'ID' => 'tv-fill',
						),
						'twitch' => array(
							'ID' => 'twitch',
						),
						'twitter' => array(
							'ID' => 'twitter',
						),
						'type' => array(
							'ID' => 'type',
						),
						'type-bold' => array(
							'ID' => 'type-bold',
						),
						'type-h1' => array(
							'ID' => 'type-h1',
						),
						'type-h2' => array(
							'ID' => 'type-h2',
						),
						'type-h3' => array(
							'ID' => 'type-h3',
						),
						'type-italic' => array(
							'ID' => 'type-italic',
						),
						'type-strikethrough' => array(
							'ID' => 'type-strikethrough',
						),
						'type-underline' => array(
							'ID' => 'type-underline',
						),
						'ui-checks' => array(
							'ID' => 'ui-checks',
						),
						'ui-checks-grid' => array(
							'ID' => 'ui-checks-grid',
						),
						'ui-radios' => array(
							'ID' => 'ui-radios',
						),
						'ui-radios-grid' => array(
							'ID' => 'ui-radios-grid',
						),
						'umbrella' => array(
							'ID' => 'umbrella',
						),
						'umbrella-fill' => array(
							'ID' => 'umbrella-fill',
						),
						'union' => array(
							'ID' => 'union',
						),
						'unlock' => array(
							'ID' => 'unlock',
						),
						'unlock-fill' => array(
							'ID' => 'unlock-fill',
						),
						'upc' => array(
							'ID' => 'upc',
						),
						'upc-scan' => array(
							'ID' => 'upc-scan',
						),
						'upload' => array(
							'ID' => 'upload',
						),
						'usb' => array(
							'ID' => 'usb',
						),
						'usb-c' => array(
							'ID' => 'usb-c',
						),
						'usb-c-fill' => array(
							'ID' => 'usb-c-fill',
						),
						'usb-drive' => array(
							'ID' => 'usb-drive',
						),
						'usb-drive-fill' => array(
							'ID' => 'usb-drive-fill',
						),
						'usb-fill' => array(
							'ID' => 'usb-fill',
						),
						'usb-micro' => array(
							'ID' => 'usb-micro',
						),
						'usb-micro-fill' => array(
							'ID' => 'usb-micro-fill',
						),
						'usb-mini' => array(
							'ID' => 'usb-mini',
						),
						'usb-mini-fill' => array(
							'ID' => 'usb-mini-fill',
						),
						'usb-plug' => array(
							'ID' => 'usb-plug',
						),
						'usb-plug-fill' => array(
							'ID' => 'usb-plug-fill',
						),
						'usb-symbol' => array(
							'ID' => 'usb-symbol',
						),
						'vector-pen' => array(
							'ID' => 'vector-pen',
						),
						'view-list' => array(
							'ID' => 'view-list',
						),
						'view-stacked' => array(
							'ID' => 'view-stacked',
						),
						'vimeo' => array(
							'ID' => 'vimeo',
						),
						'vinyl' => array(
							'ID' => 'vinyl',
						),
						'vinyl-fill' => array(
							'ID' => 'vinyl-fill',
						),
						'voicemail' => array(
							'ID' => 'voicemail',
						),
						'volume-down' => array(
							'ID' => 'volume-down',
						),
						'volume-down-fill' => array(
							'ID' => 'volume-down-fill',
						),
						'volume-mute' => array(
							'ID' => 'volume-mute',
						),
						'volume-mute-fill' => array(
							'ID' => 'volume-mute-fill',
						),
						'volume-off' => array(
							'ID' => 'volume-off',
						),
						'volume-off-fill' => array(
							'ID' => 'volume-off-fill',
						),
						'volume-up' => array(
							'ID' => 'volume-up',
						),
						'volume-up-fill' => array(
							'ID' => 'volume-up-fill',
						),
						'vr' => array(
							'ID' => 'vr',
						),
						'wallet' => array(
							'ID' => 'wallet',
						),
						'wallet-fill' => array(
							'ID' => 'wallet-fill',
						),
						'wallet2' => array(
							'ID' => 'wallet2',
						),
						'watch' => array(
							'ID' => 'watch',
						),
						'water' => array(
							'ID' => 'water',
						),
						'webcam' => array(
							'ID' => 'webcam',
						),
						'webcam-fill' => array(
							'ID' => 'webcam-fill',
						),
						'whatsapp' => array(
							'ID' => 'whatsapp',
						),
						'wifi' => array(
							'ID' => 'wifi',
						),
						'wifi-1' => array(
							'ID' => 'wifi-1',
						),
						'wifi-2' => array(
							'ID' => 'wifi-2',
						),
						'wifi-off' => array(
							'ID' => 'wifi-off',
						),
						'wind' => array(
							'ID' => 'wind',
						),
						'window' => array(
							'ID' => 'window',
						),
						'window-dash' => array(
							'ID' => 'window-dash',
						),
						'window-desktop' => array(
							'ID' => 'window-desktop',
						),
						'window-dock' => array(
							'ID' => 'window-dock',
						),
						'window-fullscreen' => array(
							'ID' => 'window-fullscreen',
						),
						'window-plus' => array(
							'ID' => 'window-plus',
						),
						'window-sidebar' => array(
							'ID' => 'window-sidebar',
						),
						'window-split' => array(
							'ID' => 'window-split',
						),
						'window-stack' => array(
							'ID' => 'window-stack',
						),
						'window-x' => array(
							'ID' => 'window-x',
						),
						'windows' => array(
							'ID' => 'windows',
						),
						'wordpress' => array(
							'ID' => 'wordpress',
						),
						'wrench' => array(
							'ID' => 'wrench',
						),
						'x' => array(
							'ID' => 'x',
						),
						'x-circle' => array(
							'ID' => 'x-circle',
						),
						'x-circle-fill' => array(
							'ID' => 'x-circle-fill',
						),
						'x-diamond' => array(
							'ID' => 'x-diamond',
						),
						'x-diamond-fill' => array(
							'ID' => 'x-diamond-fill',
						),
						'x-lg' => array(
							'ID' => 'x-lg',
						),
						'x-octagon' => array(
							'ID' => 'x-octagon',
						),
						'x-octagon-fill' => array(
							'ID' => 'x-octagon-fill',
						),
						'x-square' => array(
							'ID' => 'x-square',
						),
						'x-square-fill' => array(
							'ID' => 'x-square-fill',
						),
						'xbox' => array(
							'ID' => 'xbox',
						),
						'yin-yang' => array(
							'ID' => 'yin-yang',
						),
						'youtube' => array(
							'ID' => 'youtube',
						),
						'zoom-in' => array(
							'ID' => 'zoom-in',
						),
						'zoom-out' => array(
							'ID' => 'zoom-out',
						),
					),
					'ui' => 1,
					'ajax' => 0,
					'placeholder' => '',
					'return_format' => 'value',
					'file' => array(
						'path' => '/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/assets/bootstrap-icons.svg',
						'url' => '/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/assets/bootstrap-icons.svg',
					),
				),
			),
		),
		array(
			'key' => 'field_61a14f26396cc',
			'label' => 'Background',
			'name' => 'background',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_save_meta' => 0,
			'layout' => 'block',
			'acfe_seamless_style' => 1,
			'acfe_group_modal' => 0,
			'acfe_settings' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_61a14f63396cd',
					'label' => 'Type',
					'name' => 'type',
					'type' => 'button_group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'image' => 'Image',
						'color' => 'Color',
						'video' => 'Video',
					),
					'allow_null' => 1,
					'default_value' => '',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61a14fbb396ce',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'background',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'show_background_repeat' => 1,
					'background_repeat' => 'no-repeat',
					'show_background_clip' => 0,
					'background_clip' => 'inherit',
					'show_background_size' => 0,
					'background_size' => 'auto',
					'show_background_attachment' => 0,
					'background_attachment' => 'scroll',
					'show_background_position' => 0,
					'background_position' => 'left top',
					'show_background_origin' => 0,
					'background_origin' => 'inherit',
					'display_background_color' => 0,
					'background_color' => '',
					'show_background_image' => 1,
					'show_preview_media' => 1,
					'show_preview' => 1,
					'preview-height' => 200,
					'show_text_color' => 0,
					'text_color' => '#000',
					'acfe_settings' => '',
					'acfe_validate' => '',
					'ext_value' => array(
					),
					'background_repeat_values' => array(
						'no-repeat' => 'No Repeat',
						'repeat' => 'Repeat All',
						'repeat-x' => 'Repeat Horizontally',
						'repeat-y' => 'Repeat Vertically',
						'inherit' => 'Inherit',
					),
					'background_clip_values' => array(
						'border-box' => 'Border Box',
						'padding-box' => 'Padding Box',
						'content-box' => 'Content Box',
						'inherit' => 'Inherit',
					),
					'background_size_values' => array(
						'cover' => 'Cover',
						'contain' => 'Contain',
						'inherit' => 'Inherit',
						'auto' => 'auto',
					),
					'background_attachment_values' => array(
						'scroll' => 'Scroll',
						'fixed' => 'Fixed',
						'local' => 'Local',
						'inherit' => 'Inherit',
					),
					'background_position_values' => array(
						'left top' => 'Left Top',
						'left center' => 'Left center',
						'left bottom' => 'Left Bottom',
						'center top' => 'Center Top',
						'center center' => 'Center Center',
						'center bottom' => 'Center Bottom',
						'right top' => 'Right Top',
						'right center' => 'Right center',
						'right bottom' => 'Right Bottom',
						'inherit' => 'Inherit',
					),
					'background_origin_values' => array(
						'border-box' => 'Border Box',
						'padding-box' => 'Padding Box',
						'content-box' => 'Content Box',
						'inherit' => 'Inherit',
					),
				),
				array(
					'key' => 'field_61a14ff1396cf',
					'label' => 'Video',
					'name' => 'video',
					'type' => 'clone',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'clone' => array(
						0 => 'field_61a150c413a36',
					),
					'display' => 'seamless',
					'layout' => 'block',
					'prefix_label' => 0,
					'prefix_name' => 1,
					'acfe_settings' => '',
				),
				array(
					'key' => 'field_61a15003396d0',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'clone',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'clone' => array(
						0 => 'field_61772ca5bb3c1',
					),
					'display' => 'seamless',
					'layout' => 'block',
					'prefix_label' => 0,
					'prefix_name' => 1,
					'acfe_settings' => '',
				),
			),
		),
		array(
			'key' => 'field_61a150c413a36',
			'label' => 'Video',
			'name' => 'video',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_save_meta' => 0,
			'layout' => 'block',
			'acfe_seamless_style' => 1,
			'acfe_group_modal' => 0,
			'acfe_settings' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_61a156a61fad3',
					'label' => 'Host',
					'name' => 'host',
					'type' => 'button_group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'choices' => array(
						'internal' => 'File from Media Library',
						'external' => 'oEmbed Code',
					),
					'allow_null' => 0,
					'default_value' => 'external : oEmbed Code',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61a157211fad4',
					'label' => 'Internal',
					'name' => 'internal',
					'type' => 'file',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61a156a61fad3',
								'operator' => '==',
								'value' => 'internal',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'uploader' => '',
					'return_format' => 'array',
					'min_size' => '',
					'max_size' => '',
					'mime_types' => 'mp4,mov,wmv,avi,avchd,flv,f4v,swf,mkv,webm,html5',
					'acfe_settings' => '',
					'acfe_validate' => '',
					'library' => 'all',
				),
				array(
					'key' => 'field_61a157821fad5',
					'label' => 'External',
					'name' => 'external',
					'type' => 'oembed',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61a156a61fad3',
								'operator' => '==',
								'value' => 'external',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'width' => '',
					'height' => '',
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
			),
		),
		array(
			'key' => 'field_61a155444fe0e',
			'label' => 'Button',
			'name' => 'button',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_save_meta' => 0,
			'layout' => 'block',
			'acfe_seamless_style' => 1,
			'acfe_group_modal' => 0,
			'acfe_settings' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_61a155554fe0f',
					'label' => 'Text',
					'name' => 'text',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'col-md-auto',
						'id' => '',
					),
					'acfe_permissions' => '',
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
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61a155b04fe12',
					'label' => 'Style',
					'name' => 'bs_btn_style',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'col-md-auto',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'choices' => array(
						'btn-primary' => 'Primary',
						'btn-secondary' => 'Secondary',
						'btn-success' => 'Success',
						'btn-info' => 'Info',
						'btn-warning' => 'Warning',
						'btn-danger' => 'Danger',
						'btn-light' => 'Light',
						'btn-dark' => 'Dark',
						'btn-blue' => 'Blue',
						'btn-indigo' => 'Indigo',
						'btn-purple' => 'Purple',
						'btn-pink' => 'Pink',
						'btn-red' => 'Red',
						'btn-orange' => 'Orange',
						'btn-yellow' => 'Yellow',
						'btn-green' => 'Green',
						'btn-teal' => 'Teal',
						'btn-cyan' => 'Cyan',
						'btn-white' => 'White',
						'btn-black' => 'Black',
						'btn-gray' => 'Gray',
						'outline-primary' => 'Primary Outline',
						'outline-secondary' => 'Secondary Outline',
						'outline-success' => 'Success Outline',
						'outline-info' => 'Info Outline',
						'outline-warning' => 'Warning Outline',
						'outline-danger' => 'Danger Outline',
						'outline-light' => 'Light Outline',
						'outline-dark' => 'Dark Outline',
						'outline-blue' => 'Blue Outline',
						'outline-indigo' => 'Indigo Outline',
						'outline-purple' => 'Purple Outline',
						'outline-pink' => 'Pink Outline',
						'outline-red' => 'Red Outline',
						'outline-orange' => 'Orange Outline',
						'outline-yellow' => 'Yellow Outline',
						'outline-green' => 'Green Outline',
						'outline-teal' => 'Teal Outline',
						'outline-cyan' => 'Cyan Outline',
						'outline-white' => 'White Outline',
						'outline-black' => 'Black Outline',
						'outline-gray' => 'Gray Outline',
						'custom' => 'Custom',
					),
					'default_value' => false,
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'show_column' => 0,
					'show_column_sortable' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_61a156214fe16',
					'label' => 'Link',
					'name' => 'link',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'col-md-auto flex-fill',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'return_format' => 'array',
					'show_column' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'acfe_settings' => '',
					'acfe_validate' => '',
				),
				array(
					'key' => 'field_61a155634fe10',
					'label' => 'Icon',
					'name' => 'icon',
					'type' => 'clone',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_permissions' => '',
					'acfe_save_meta' => 0,
					'clone' => array(
						0 => 'field_61940d5ca41f6',
					),
					'display' => 'group',
					'layout' => 'block',
					'prefix_label' => 0,
					'prefix_name' => 0,
					'acfe_seamless_style' => 1,
					'acfe_clone_modal' => 0,
					'acfe_settings' => '',
				),
				array(
					'key' => 'field_61a1559d4fe11',
					'label' => 'Button Attributes',
					'name' => 'atts',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'label-none',
						'id' => '',
					),
					'layout' => 'block',
					'acfe_seamless_style' => 1,
					'acfe_group_modal' => 0,
					'acfe_settings' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_61a155e94fe14',
							'label' => 'CSS ID',
							'name' => 'id',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'col-md-4',
								'id' => '',
							),
							'acfe_permissions' => '',
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
							'acfe_settings' => '',
							'acfe_validate' => '',
						),
						array(
							'key' => 'field_61a155df4fe13',
							'label' => 'CSS Classes',
							'name' => 'class',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'col-md-8',
								'id' => '',
							),
							'acfe_permissions' => '',
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
							'acfe_settings' => '',
							'acfe_validate' => '',
						),
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => false,
	'description' => '',
	'show_in_rest' => 0,
	'acfe_display_title' => '',
	'acfe_autosync' => array(
		0 => 'php',
	),
	'acfe_permissions' => '',
	'acfe_form' => 1,
	'acfe_meta' => '',
	'acfe_note' => '',
	'acfe_categories' => array(
		'plugin' => 'Plugin',
	),
	'modified' => 1638734240,
));

endif;