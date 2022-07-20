<?php 

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key'                   => 'group_reusable_fields',
		'title'                 => 'Reusable Fields',
		'fields'                => array(
			array(
				'key'                 => 'field_61772ca5bb3c1',
				'label'               => 'Background Color',
				'name'                => 'background_color',
				'type'                => 'group',
				'instructions'        => '',
				'required'            => 0,
				'conditional_logic'   => 0,
				'wrapper'             => array(
					'width' => '',
					'class' => 'label-none',
					'id'    => '',
				),
				'acfe_permissions'    => '',
				'acfe_save_meta'      => 0,
				'layout'              => 'block',
				'acfe_seamless_style' => 1,
				'acfe_group_modal'    => 0,
				'acfe_settings'       => '',
				'sub_fields'          => array(
					array(
						'key'                  => 'field_61772cbfbb3c2',
						'label'                => 'Background Color',
						'name'                 => 'bs_class',
						'type'                 => 'select',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => 0,
						'wrapper'              => array(
							'width' => '',
							'class' => 'label-none',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'choices'              => array(
							'bg-primary'   => 'Primary',
							'bg-secondary' => 'Secondary',
							'bg-success'   => 'Success',
							'bg-info'      => 'Info',
							'bg-warning'   => 'Warning',
							'bg-danger'    => 'Danger',
							'bg-light'     => 'Light',
							'bg-dark'      => 'Dark',
							'bg-blue'      => 'Blue',
							'bg-indigo'    => 'Indigo',
							'bg-purple'    => 'Purple',
							'bg-pink'      => 'Pink',
							'bg-red'       => 'Red',
							'bg-orange'    => 'Orange',
							'bg-yellow'    => 'Yellow',
							'bg-green'     => 'Green',
							'bg-teal'      => 'Teal',
							'bg-cyan'      => 'Cyan',
							'bg-white'     => 'White',
							'bg-black'     => 'Black',
							'bg-gray'      => 'Gray',
							'custom'       => 'Custom',
						),
						'default_value'        => false,
						'allow_null'           => 1,
						'multiple'             => 0,
						'ui'                   => 1,
						'ajax'                 => 0,
						'return_format'        => 'value',
						'allow_custom'         => 0,
						'placeholder'          => '',
						'search_placeholder'   => '',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
					array(
						'key'                  => 'field_61772cf0bb3c3',
						'label'                => 'Custom Background Color',
						'name'                 => 'custom',
						'type'                 => 'color_picker',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => array(
							array(
								array(
									'field'    => 'field_61772cbfbb3c2',
									'operator' => '==',
									'value'    => 'custom',
								),
							),
						),
						'wrapper'              => array(
							'width' => '',
							'class' => 'label-none',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'default_value'        => '',
						'enable_opacity'       => 1,
						'return_format'        => 'string',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
				),
			),
			array(
				'key'                 => 'field_61acfe12f7a57',
				'label'               => 'Border Color',
				'name'                => 'border_color',
				'type'                => 'group',
				'instructions'        => '',
				'required'            => 0,
				'conditional_logic'   => 0,
				'wrapper'             => array(
					'width' => '',
					'class' => 'label-none',
					'id'    => '',
				),
				'acfe_permissions'    => '',
				'acfe_save_meta'      => 0,
				'layout'              => 'block',
				'acfe_seamless_style' => 1,
				'acfe_group_modal'    => 0,
				'acfe_settings'       => '',
				'sub_fields'          => array(
					array(
						'key'                  => 'field_61acfe12f7a58',
						'label'                => 'Border Color',
						'name'                 => 'bs_class',
						'type'                 => 'select',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => 0,
						'wrapper'              => array(
							'width' => '',
							'class' => 'label-none',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'choices'              => array(
							'border-primary'   => 'Primary',
							'border-secondary' => 'Secondary',
							'border-success'   => 'Success',
							'border-info'      => 'Info',
							'border-warning'   => 'Warning',
							'border-danger'    => 'Danger',
							'border-light'     => 'Light',
							'border-dark'      => 'Dark',
							'border-blue'      => 'Blue',
							'border-indigo'    => 'Indigo',
							'border-purple'    => 'Purple',
							'border-pink'      => 'Pink',
							'border-red'       => 'Red',
							'border-orange'    => 'Orange',
							'border-yellow'    => 'Yellow',
							'border-green'     => 'Green',
							'border-teal'      => 'Teal',
							'border-cyan'      => 'Cyan',
							'border-white'     => 'White',
							'border-black'     => 'Black',
							'border-gray'      => 'Gray',
							'custom'           => 'Custom',
						),
						'default_value'        => false,
						'allow_null'           => 1,
						'multiple'             => 0,
						'ui'                   => 1,
						'ajax'                 => 0,
						'return_format'        => 'value',
						'allow_custom'         => 0,
						'placeholder'          => '',
						'search_placeholder'   => '',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
					array(
						'key'                  => 'field_61acfe12f7a59',
						'label'                => 'Custom Border Color',
						'name'                 => 'custom',
						'type'                 => 'color_picker',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => array(
							array(
								array(
									'field'    => 'field_61acfe12f7a58',
									'operator' => '==',
									'value'    => 'custom',
								),
							),
						),
						'wrapper'              => array(
							'width' => '',
							'class' => 'label-none',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'default_value'        => '',
						'enable_opacity'       => 1,
						'return_format'        => 'string',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
				),
			),
			array(
				'key'                 => 'field_61acfdb9f7a54',
				'label'               => 'Text Color',
				'name'                => 'text_color',
				'type'                => 'group',
				'instructions'        => '',
				'required'            => 0,
				'conditional_logic'   => 0,
				'wrapper'             => array(
					'width' => '',
					'class' => 'label-none',
					'id'    => '',
				),
				'acfe_permissions'    => '',
				'acfe_save_meta'      => 0,
				'layout'              => 'block',
				'acfe_seamless_style' => 1,
				'acfe_group_modal'    => 0,
				'acfe_settings'       => '',
				'sub_fields'          => array(
					array(
						'key'                  => 'field_61acfdb9f7a55',
						'label'                => 'Text Color',
						'name'                 => 'bs_class',
						'type'                 => 'select',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => 0,
						'wrapper'              => array(
							'width' => '',
							'class' => 'label-none',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'choices'              => array(
							'text-primary'   => 'Primary',
							'text-secondary' => 'Secondary',
							'text-success'   => 'Success',
							'text-info'      => 'Info',
							'text-warning'   => 'Warning',
							'text-danger'    => 'Danger',
							'text-light'     => 'Light',
							'text-dark'      => 'Dark',
							'text-blue'      => 'Blue',
							'text-indigo'    => 'Indigo',
							'text-purple'    => 'Purple',
							'text-pink'      => 'Pink',
							'text-red'       => 'Red',
							'text-orange'    => 'Orange',
							'text-yellow'    => 'Yellow',
							'text-green'     => 'Green',
							'text-teal'      => 'Teal',
							'text-cyan'      => 'Cyan',
							'text-white'     => 'White',
							'text-black'     => 'Black',
							'text-gray'      => 'Gray',
							'custom'         => 'Custom',
						),
						'default_value'        => false,
						'allow_null'           => 1,
						'multiple'             => 0,
						'ui'                   => 1,
						'ajax'                 => 0,
						'return_format'        => 'value',
						'allow_custom'         => 0,
						'placeholder'          => '',
						'search_placeholder'   => '',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
					array(
						'key'                  => 'field_61acfdb9f7a56',
						'label'                => 'Custom Text Color',
						'name'                 => 'custom',
						'type'                 => 'color_picker',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => array(
							array(
								array(
									'field'    => 'field_61acfdb9f7a55',
									'operator' => '==',
									'value'    => 'custom',
								),
							),
						),
						'wrapper'              => array(
							'width' => '',
							'class' => 'label-none',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'default_value'        => '',
						'enable_opacity'       => 1,
						'return_format'        => 'string',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
				),
			),
			array(
				'key'                 => 'field_61940d5ca41f6',
				'label'               => 'Icon',
				'name'                => 'icon',
				'type'                => 'group',
				'instructions'        => '',
				'required'            => 0,
				'conditional_logic'   => 0,
				'wrapper'             => array(
					'width' => '',
					'class' => 'label-none',
					'id'    => '',
				),
				'acfe_permissions'    => '',
				'acfe_save_meta'      => 0,
				'layout'              => 'block',
				'acfe_seamless_style' => 1,
				'acfe_group_modal'    => 0,
				'acfe_settings'       => '',
				'sub_fields'          => array(
					array(
						'key'                  => 'field_61940d6ea41f7',
						'label'                => 'Type',
						'name'                 => 'type',
						'type'                 => 'button_group',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => 0,
						'wrapper'              => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'choices'              => array(
							'icon'  => 'Icon Font',
							'image' => 'Image',
							'svg'   => 'SVG',
							'class' => 'Icon Class',
							'html'  => 'Custom HTML',
						),
						'allow_null'           => 1,
						'default_value'        => 'icon : Icon Font',
						'layout'               => 'horizontal',
						'return_format'        => 'value',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
					array(
						'key'                => 'field_61940dbda41f8',
						'label'              => 'Image',
						'name'               => 'src',
						'type'               => 'image',
						'instructions'       => '',
						'required'           => 0,
						'conditional_logic'  => array(
							array(
								array(
									'field'    => 'field_61940d6ea41f7',
									'operator' => '==',
									'value'    => 'image',
								),
							),
							array(
								array(
									'field'    => 'field_61940d6ea41f7',
									'operator' => '==',
									'value'    => 'svg',
								),
							),
						),
						'wrapper'            => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'   => '',
						'acfe_save_meta'     => 0,
						'uploader'           => '',
						'acfe_thumbnail'     => 0,
						'return_format'      => 'url',
						'preview_size'       => 'thumbnail',
						'min_width'          => '',
						'min_height'         => '',
						'min_size'           => '',
						'max_width'          => '',
						'max_height'         => '',
						'max_size'           => '',
						'mime_types'         => '',
						'show_column'        => 0,
						'show_column_weight' => 1000,
						'allow_quickedit'    => 0,
						'allow_bulkedit'     => 0,
						'acfe_settings'      => '',
						'acfe_validate'      => '',
						'library'            => 'all',
					),
					array(
						'key'                  => 'field_6194424409883',
						'label'                => 'Class',
						'name'                 => 'class',
						'type'                 => 'text',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => array(
							array(
								array(
									'field'    => 'field_61940d6ea41f7',
									'operator' => '==',
									'value'    => 'class',
								),
							),
						),
						'wrapper'              => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'default_value'        => '',
						'placeholder'          => '',
						'prepend'              => '',
						'append'               => '',
						'maxlength'            => '',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
					array(
						'key'               => 'field_6194426009884',
						'label'             => 'Custom Html',
						'name'              => 'content',
						'type'              => 'acfe_code_editor',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_61940d6ea41f7',
									'operator' => '==',
									'value'    => 'html',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'  => '',
						'default_value'     => '',
						'placeholder'       => '',
						'mode'              => 'text/html',
						'lines'             => 1,
						'indent_unit'       => 4,
						'maxlength'         => '',
						'rows'              => 8,
						'max_rows'          => '',
						'return_entities'   => 0,
						'acfe_settings'     => '',
						'acfe_validate'     => '',
					),
					array(
						'key'               => 'field_61a157d11fad6',
						'label'             => 'Icon',
						'name'              => 'icon',
						'type'              => 'svg_icon',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_61940d6ea41f7',
									'operator' => '==',
									'value'    => 'icon',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'  => '',
						'default_value'     => array(),
						'allow_null'        => 0,
						'multiple'          => 0,
						'acfe_settings'     => '',
						'acfe_validate'     => '',
						'choices'           => array(),
						'ui'                => 1,
						'ajax'              => 0,
						'placeholder'       => '',
						'return_format'     => 'value',
						'file'              => array(
							'path' => '',
							'url'  => '',
						),
					),
				),
			),
			array(
				'key'                 => 'field_61a14f26396cc',
				'label'               => 'Background',
				'name'                => 'background',
				'type'                => 'group',
				'instructions'        => '',
				'required'            => 0,
				'conditional_logic'   => 0,
				'wrapper'             => array(
					'width' => '',
					'class' => 'label-none',
					'id'    => '',
				),
				'acfe_permissions'    => '',
				'acfe_save_meta'      => 0,
				'layout'              => 'block',
				'acfe_seamless_style' => 1,
				'acfe_group_modal'    => 0,
				'acfe_settings'       => '',
				'sub_fields'          => array(
					array(
						'key'               => 'field_61a14f63396cd',
						'label'             => 'Type',
						'name'              => 'type',
						'type'              => 'button_group',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							'image' => 'Image',
							'color' => 'Color',
							'video' => 'Video',
						),
						'allow_null'        => 1,
						'default_value'     => '',
						'layout'            => 'horizontal',
						'return_format'     => 'value',
						'acfe_settings'     => '',
						'acfe_validate'     => '',
					),
					array(
						'key'                          => 'field_61a14fbb396ce',
						'label'                        => 'Image',
						'name'                         => 'image',
						'type'                         => 'background',
						'instructions'                 => '',
						'required'                     => 0,
						'conditional_logic'            => 0,
						'wrapper'                      => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'             => '',
						'show_background_repeat'       => 1,
						'background_repeat'            => 'no-repeat',
						'show_background_clip'         => 0,
						'background_clip'              => 'inherit',
						'show_background_size'         => 0,
						'background_size'              => 'auto',
						'show_background_attachment'   => 0,
						'background_attachment'        => 'scroll',
						'show_background_position'     => 0,
						'background_position'          => 'left top',
						'show_background_origin'       => 0,
						'background_origin'            => 'inherit',
						'display_background_color'     => 0,
						'background_color'             => '',
						'show_background_image'        => 1,
						'show_preview_media'           => 1,
						'show_preview'                 => 1,
						'preview-height'               => 200,
						'show_text_color'              => 0,
						'text_color'                   => '#000',
						'acfe_settings'                => '',
						'acfe_validate'                => '',
						'ext_value'                    => array(),
						'background_repeat_values'     => array(
							'no-repeat' => 'No Repeat',
							'repeat'    => 'Repeat All',
							'repeat-x'  => 'Repeat Horizontally',
							'repeat-y'  => 'Repeat Vertically',
							'inherit'   => 'Inherit',
						),
						'background_clip_values'       => array(
							'border-box'  => 'Border Box',
							'padding-box' => 'Padding Box',
							'content-box' => 'Content Box',
							'inherit'     => 'Inherit',
						),
						'background_size_values'       => array(
							'cover'   => 'Cover',
							'contain' => 'Contain',
							'inherit' => 'Inherit',
							'auto'    => 'auto',
						),
						'background_attachment_values' => array(
							'scroll'  => 'Scroll',
							'fixed'   => 'Fixed',
							'local'   => 'Local',
							'inherit' => 'Inherit',
						),
						'background_position_values'   => array(
							'left top'      => 'Left Top',
							'left center'   => 'Left center',
							'left bottom'   => 'Left Bottom',
							'center top'    => 'Center Top',
							'center center' => 'Center Center',
							'center bottom' => 'Center Bottom',
							'right top'     => 'Right Top',
							'right center'  => 'Right center',
							'right bottom'  => 'Right Bottom',
							'inherit'       => 'Inherit',
						),
						'background_origin_values'     => array(
							'border-box'  => 'Border Box',
							'padding-box' => 'Padding Box',
							'content-box' => 'Content Box',
							'inherit'     => 'Inherit',
						),
					),
					array(
						'key'               => 'field_61a14ff1396cf',
						'label'             => 'Video',
						'name'              => 'video',
						'type'              => 'clone',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'  => '',
						'clone'             => array(
							0 => 'field_61a150c413a36',
						),
						'display'           => 'seamless',
						'layout'            => 'block',
						'prefix_label'      => 0,
						'prefix_name'       => 1,
						'acfe_settings'     => '',
					),
					array(
						'key'               => 'field_61a15003396d0',
						'label'             => 'Color',
						'name'              => 'color',
						'type'              => 'clone',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'clone'             => array(
							0 => 'field_61772ca5bb3c1',
						),
						'display'           => 'seamless',
						'layout'            => 'block',
						'prefix_label'      => 0,
						'prefix_name'       => 1,
						'acfe_settings'     => '',
					),
				),
			),
			array(
				'key'                 => 'field_61a150c413a36',
				'label'               => 'Video',
				'name'                => 'video',
				'type'                => 'group',
				'instructions'        => '',
				'required'            => 0,
				'conditional_logic'   => 0,
				'wrapper'             => array(
					'width' => '',
					'class' => 'label-none',
					'id'    => '',
				),
				'acfe_permissions'    => '',
				'acfe_save_meta'      => 0,
				'layout'              => 'block',
				'acfe_seamless_style' => 1,
				'acfe_group_modal'    => 0,
				'acfe_settings'       => '',
				'sub_fields'          => array(
					array(
						'key'               => 'field_61a156a61fad3',
						'label'             => 'Host',
						'name'              => 'host',
						'type'              => 'button_group',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'  => '',
						'choices'           => array(
							'internal' => 'File from Media Library',
							'external' => 'oEmbed Code',
						),
						'allow_null'        => 0,
						'default_value'     => 'external : oEmbed Code',
						'layout'            => 'horizontal',
						'return_format'     => 'value',
						'acfe_settings'     => '',
						'acfe_validate'     => '',
					),
					array(
						'key'               => 'field_61a157211fad4',
						'label'             => 'Internal',
						'name'              => 'internal',
						'type'              => 'file',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_61a156a61fad3',
									'operator' => '==',
									'value'    => 'internal',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'  => '',
						'uploader'          => '',
						'return_format'     => 'array',
						'min_size'          => '',
						'max_size'          => '',
						'mime_types'        => 'mp4,mov,wmv,avi,avchd,flv,f4v,swf,mkv,webm,html5',
						'acfe_settings'     => '',
						'acfe_validate'     => '',
						'library'           => 'all',
					),
					array(
						'key'               => 'field_61a157821fad5',
						'label'             => 'External',
						'name'              => 'external',
						'type'              => 'oembed',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_61a156a61fad3',
									'operator' => '==',
									'value'    => 'external',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'  => '',
						'width'             => '',
						'height'            => '',
						'acfe_settings'     => '',
						'acfe_validate'     => '',
					),
				),
			),
			array(
				'key'                 => 'field_61a155444fe0e',
				'label'               => 'Button',
				'name'                => 'button',
				'type'                => 'group',
				'instructions'        => '',
				'required'            => 0,
				'conditional_logic'   => 0,
				'wrapper'             => array(
					'width' => '',
					'class' => 'label-none',
					'id'    => '',
				),
				'acfe_permissions'    => '',
				'acfe_save_meta'      => 0,
				'layout'              => 'block',
				'acfe_seamless_style' => 1,
				'acfe_group_modal'    => 0,
				'acfe_settings'       => '',
				'sub_fields'          => array(
					array(
						'key'                  => 'field_61a155554fe0f',
						'label'                => 'Text',
						'name'                 => 'text',
						'type'                 => 'text',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => 0,
						'wrapper'              => array(
							'width' => '',
							'class' => 'col-md-auto',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'default_value'        => '',
						'placeholder'          => '',
						'prepend'              => '',
						'append'               => '',
						'maxlength'            => '',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
					),
					array(
						'key'                  => 'field_61a155b04fe12',
						'label'                => 'Style',
						'name'                 => 'bs_btn_style',
						'type'                 => 'select',
						'instructions'         => '',
						'required'             => 0,
						'conditional_logic'    => 0,
						'wrapper'              => array(
							'width' => '',
							'class' => 'col-md-auto',
							'id'    => '',
						),
						'acfe_permissions'     => '',
						'acfe_save_meta'       => 0,
						'choices'              => array(
							'btn-primary'       => 'Primary',
							'btn-secondary'     => 'Secondary',
							'btn-success'       => 'Success',
							'btn-info'          => 'Info',
							'btn-warning'       => 'Warning',
							'btn-danger'        => 'Danger',
							'btn-light'         => 'Light',
							'btn-dark'          => 'Dark',
							'btn-blue'          => 'Blue',
							'btn-indigo'        => 'Indigo',
							'btn-purple'        => 'Purple',
							'btn-pink'          => 'Pink',
							'btn-red'           => 'Red',
							'btn-orange'        => 'Orange',
							'btn-yellow'        => 'Yellow',
							'btn-green'         => 'Green',
							'btn-teal'          => 'Teal',
							'btn-cyan'          => 'Cyan',
							'btn-white'         => 'White',
							'btn-black'         => 'Black',
							'btn-gray'          => 'Gray',
							'outline-primary'   => 'Primary Outline',
							'outline-secondary' => 'Secondary Outline',
							'outline-success'   => 'Success Outline',
							'outline-info'      => 'Info Outline',
							'outline-warning'   => 'Warning Outline',
							'outline-danger'    => 'Danger Outline',
							'outline-light'     => 'Light Outline',
							'outline-dark'      => 'Dark Outline',
							'outline-blue'      => 'Blue Outline',
							'outline-indigo'    => 'Indigo Outline',
							'outline-purple'    => 'Purple Outline',
							'outline-pink'      => 'Pink Outline',
							'outline-red'       => 'Red Outline',
							'outline-orange'    => 'Orange Outline',
							'outline-yellow'    => 'Yellow Outline',
							'outline-green'     => 'Green Outline',
							'outline-teal'      => 'Teal Outline',
							'outline-cyan'      => 'Cyan Outline',
							'outline-white'     => 'White Outline',
							'outline-black'     => 'Black Outline',
							'outline-gray'      => 'Gray Outline',
							'custom'            => 'Custom',
						),
						'default_value'        => false,
						'allow_null'           => 0,
						'multiple'             => 0,
						'ui'                   => 0,
						'return_format'        => 'value',
						'show_column'          => 0,
						'show_column_sortable' => 0,
						'show_column_weight'   => 1000,
						'allow_quickedit'      => 0,
						'allow_bulkedit'       => 0,
						'acfe_settings'        => '',
						'acfe_validate'        => '',
						'ajax'                 => 0,
						'placeholder'          => '',
					),
					array(
						'key'                => 'field_61a156214fe16',
						'label'              => 'Link',
						'name'               => 'link',
						'type'               => 'link',
						'instructions'       => '',
						'required'           => 0,
						'conditional_logic'  => 0,
						'wrapper'            => array(
							'width' => '',
							'class' => 'col-md-auto flex-fill',
							'id'    => '',
						),
						'acfe_permissions'   => '',
						'acfe_save_meta'     => 0,
						'return_format'      => 'array',
						'show_column'        => 0,
						'show_column_weight' => 1000,
						'allow_quickedit'    => 0,
						'allow_bulkedit'     => 0,
						'acfe_settings'      => '',
						'acfe_validate'      => '',
					),
					array(
						'key'                 => 'field_61a155634fe10',
						'label'               => 'Icon',
						'name'                => 'icon',
						'type'                => 'clone',
						'instructions'        => '',
						'required'            => 0,
						'conditional_logic'   => 0,
						'wrapper'             => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'acfe_permissions'    => '',
						'acfe_save_meta'      => 0,
						'clone'               => array(
							0 => 'field_61940d5ca41f6',
						),
						'display'             => 'group',
						'layout'              => 'block',
						'prefix_label'        => 0,
						'prefix_name'         => 0,
						'acfe_seamless_style' => 1,
						'acfe_clone_modal'    => 0,
						'acfe_settings'       => '',
					),
					array(
						'key'                 => 'field_61a1559d4fe11',
						'label'               => 'Button Attributes',
						'name'                => 'atts',
						'type'                => 'group',
						'instructions'        => '',
						'required'            => 0,
						'conditional_logic'   => 0,
						'wrapper'             => array(
							'width' => '',
							'class' => 'label-none',
							'id'    => '',
						),
						'layout'              => 'block',
						'acfe_seamless_style' => 1,
						'acfe_group_modal'    => 0,
						'acfe_settings'       => '',
						'sub_fields'          => array(
							array(
								'key'                  => 'field_61a155e94fe14',
								'label'                => 'CSS ID',
								'name'                 => 'id',
								'type'                 => 'text',
								'instructions'         => '',
								'required'             => 0,
								'conditional_logic'    => 0,
								'wrapper'              => array(
									'width' => '',
									'class' => 'col-md-4',
									'id'    => '',
								),
								'acfe_permissions'     => '',
								'acfe_save_meta'       => 0,
								'default_value'        => '',
								'placeholder'          => '',
								'prepend'              => '',
								'append'               => '',
								'maxlength'            => '',
								'show_column'          => 0,
								'show_column_sortable' => 0,
								'show_column_weight'   => 1000,
								'allow_quickedit'      => 0,
								'allow_bulkedit'       => 0,
								'acfe_settings'        => '',
								'acfe_validate'        => '',
							),
							array(
								'key'                  => 'field_61a155df4fe13',
								'label'                => 'CSS Classes',
								'name'                 => 'class',
								'type'                 => 'text',
								'instructions'         => '',
								'required'             => 0,
								'conditional_logic'    => 0,
								'wrapper'              => array(
									'width' => '',
									'class' => 'col-md-8',
									'id'    => '',
								),
								'acfe_permissions'     => '',
								'acfe_save_meta'       => 0,
								'default_value'        => '',
								'placeholder'          => '',
								'prepend'              => '',
								'append'               => '',
								'maxlength'            => '',
								'show_column'          => 0,
								'show_column_sortable' => 0,
								'show_column_weight'   => 1000,
								'allow_quickedit'      => 0,
								'allow_bulkedit'       => 0,
								'acfe_settings'        => '',
								'acfe_validate'        => '',
							),
						),
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => false,
		'description'           => '',
		'show_in_rest'          => 0,
		'acfe_display_title'    => '',
		'acfe_autosync'         => array(
			0 => 'php',
		),
		'acfe_permissions'      => '',
		'acfe_form'             => 1,
		'acfe_meta'             => '',
		'acfe_note'             => '',
		'acfe_categories'       => array(
			'plugin' => 'Plugin',
		),
		'modified'              => 1648660967,
	) );

endif;
