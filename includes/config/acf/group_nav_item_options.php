<?php 

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key'                   => 'group_nav_item_options',
		'title'                 => 'Nav Item Options',
		'fields'                => array(
			array(
				'key'                     => 'field_6116eb93dfc3d',
				'label'                   => 'Nav Item Options',
				'name'                    => 'nav_item_options',
				'type'                    => 'group',
				'instructions'            => '',
				'required'                => 0,
				'conditional_logic'       => 0,
				'wrapper'                 => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'acfe_save_meta'          => 0,
				'layout'                  => 'block',
				'acfe_group_modal'        => 1,
				'acfe_group_modal_close'  => 1,
				'acfe_group_modal_button' => '',
				'acfe_group_modal_size'   => 'large',
				'sub_fields'              => array(
					array(
						'key'               => 'field_61772eff59f8d',
						'label'             => 'Background Color',
						'name'              => 'bg_color',
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
						'prefix_name'       => 0,
					),
					array(
						'key'               => 'field_6116eb93ea6ad',
						'label'             => 'Child Menu Type',
						'name'              => 'child_type',
						'type'              => 'select',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							'none'     => 'Flat style (no submenus)',
							'collapse' => 'Accordion Style',
							'dropdown' => 'Dropdown Style',
							'tab'      => 'Tab Style',
						),
						'default_value'     => false,
						'allow_null'        => 0,
						'multiple'          => 0,
						'ui'                => 0,
						'return_format'     => 'value',
						'ajax'              => 0,
						'placeholder'       => '',
					),
					array(
						'key'               => 'field_6176f5f1548d9',
						'label'             => 'Icon',
						'name'              => 'icon',
						'type'              => 'fonticonpicker',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
					),
					array(
						'key'               => 'field_6177215021e10',
						'label'             => 'Icon Position',
						'name'              => 'icon_position',
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
							'before' => 'Before Text',
							'after'  => 'After Text',
						),
						'allow_null'        => 0,
						'default_value'     => '',
						'layout'            => 'horizontal',
						'return_format'     => 'value',
					),
					array(
						'key'                 => 'field_6177217b21e11',
						'label'               => 'Toggle Icon',
						'name'                => 'toggle_icon',
						'type'                => 'group',
						'instructions'        => '',
						'required'            => 0,
						'conditional_logic'   => 0,
						'wrapper'             => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'layout'              => 'block',
						'acfe_seamless_style' => 0,
						'acfe_group_modal'    => 0,
						'sub_fields'          => array(
							array(
								'key'               => 'field_6177218921e12',
								'label'             => 'Icon to show when subnav is closed',
								'name'              => 'icon_closed',
								'type'              => 'fonticonpicker',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '50',
									'class' => '',
									'id'    => '',
								),
							),
							array(
								'key'               => 'field_6177219721e13',
								'label'             => 'Icon to show when subnav is open',
								'name'              => 'icon_opened',
								'type'              => 'text',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '50',
									'class' => '',
									'id'    => '',
								),
								'acfe_save_meta'    => 0,
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
						),
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'nav_menu_item',
					'operator' => '==',
					'value'    => 'all',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'acfe_display_title'    => '',
		'acfe_autosync'         => array(
			0 => 'php',
		),
		'acfe_form'             => 0,
		'acfe_meta'             => '',
		'acfe_note'             => '',
		'acfe_categories'       => array(
			'plugin' => 'Plugin',
		),
		'modified'              => 1635202095,
	) );

endif;
