<?php 			if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_rwp_plugin_options',
	'title' => 'Plugin Settings',
	'fields' => array(
		array(
			'key' => 'field_60c3b7f0cdab6',
			'label' => 'Modules',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_60c3b80ecdab7',
			'label' => 'Modules',
			'name' => 'modules',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_save_meta' => 0,
			'layout' => 'row',
			'acfe_seamless_style' => 0,
			'acfe_group_modal' => 0,
			'sub_fields' => array(
				array(
					'key' => 'field_60c3b825cdab8',
					'label' => 'Enable Relative Urls',
					'name' => 'relative_urls',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'message' => '',
					'default_value' => 1,
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
					'key' => 'field_60c3b853cdab9',
					'label' => 'Enable Nice Search',
					'name' => 'nice_search',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'border-top',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'message' => '',
					'default_value' => 1,
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
					'key' => 'field_60c3b896cdaba',
					'label' => 'Enable Wistia',
					'name' => 'wistia',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'message' => '',
					'default_value' => 1,
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
					'key' => 'field_60c3b8a7cdabb',
					'label' => 'Enable Head Cleanup',
					'name' => 'head_cleanup',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'message' => '',
					'default_value' => 1,
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
					'key' => 'field_60c3b8bccdabc',
					'label' => 'Enable Bootstrap Markup',
					'name' => 'bootstrap',
					'type' => 'group',
					'instructions' => 'Enable bootstrap markup for various elements',
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
							'key' => 'field_6115a1a88b87b',
							'label' => 'Styles',
							'name' => 'styles',
							'type' => 'true_false',
							'instructions' => 'Enable bootstrap styles',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
								'id' => '',
							),
							'acfe_save_meta' => 0,
							'message' => '',
							'default_value' => 1,
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
							'key' => 'field_6115a1c68b87c',
							'label' => 'Scripts',
							'name' => 'scripts',
							'type' => 'true_false',
							'instructions' => 'Enable bootstrap scripts',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
								'id' => '',
							),
							'acfe_save_meta' => 0,
							'message' => '',
							'default_value' => 1,
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
							'key' => 'field_60dcebae68bd9',
							'label' => 'Search Form',
							'name' => 'search',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dcebf868bda',
							'label' => 'Gutenberg Blocks',
							'name' => 'gutenberg',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dcec3b68bdd',
							'label' => 'Comments',
							'name' => 'comments',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dcec3a68bdc',
							'label' => 'Login Forms',
							'name' => 'login',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dcec9668bdf',
							'label' => 'Gravity Forms',
							'name' => 'gravityforms',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dcecd768be3',
							'label' => 'Navigation Menus',
							'name' => 'nav_menus',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_614a574fc6589',
							'label' => 'Elementor',
							'name' => 'elementor',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
					),
				),
				array(
					'key' => 'field_60c3b903cdabd',
					'label' => 'Enable JS Plugins',
					'name' => 'js_plugins',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'choices' => array(
						'Select2' => 'Select2',
						'Fancybox' => 'Fancybox',
						'Tiny Slider' => 'Tiny Slider',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 1,
					'return_format' => 'value',
					'show_column' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'save_custom' => 0,
				),
				array(
					'key' => 'field_60c3b935cdabe',
					'label' => 'Enable Icon Fonts',
					'name' => 'icon_fonts',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'choices' => array(
						'Font Awesome' => 'Font Awesome',
						'Bootstrap Icons' => 'Bootstrap Icons',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'show_column' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'save_custom' => 0,
				),
				array(
					'key' => 'field_60dce6d075dbb',
					'label' => 'Lazyloading options',
					'name' => 'lazysizes',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'layout' => 'block',
					'acfe_seamless_style' => 0,
					'acfe_group_modal' => 0,
					'sub_fields' => array(
						array(
							'key' => 'field_60dce70a75dbc',
							'label' => 'Use plugin lazyloading',
							'name' => 'lazyload',
							'type' => 'true_false',
							'instructions' => 'Add additional features for lazyloading that do more than WordPress\' built in functionality',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dce76075dbe',
							'label' => 'Blur-up effect',
							'name' => 'blurup',
							'type' => 'true_false',
							'instructions' => 'Add a blur effect to images (go from low quality image with gaussien blur to higher-quality image when the image comes into view)',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dce7f475dbf',
							'label' => 'Fade-in effect',
							'name' => 'fadein',
							'type' => 'true_false',
							'instructions' => 'Add a fade-in effect to images when the image comes into view',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dce81b75dc0',
							'label' => 'Custom Media',
							'name' => 'custommedia',
							'type' => 'true_false',
							'instructions' => 'Automatically sync and manage your breakpoints between your CSS and the media attributes of your "picture > source" elements',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
							'key' => 'field_60dce94c75dc1',
							'label' => 'Custom Art',
							'name' => 'artdirect',
							'type' => 'true_false',
							'instructions' => 'Add the ability to fully control art direction through your CSS. (See https://github.com/aFarkas/lazysizes/tree/gh-pages/plugins/artdirect)',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
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
					),
				),
				array(
					'key' => 'field_6179a8fb3a449',
					'label' => 'Yoast Options',
					'name' => 'yoast',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'layout' => 'block',
					'acfe_seamless_style' => 0,
					'acfe_group_modal' => 0,
					'sub_fields' => array(
						array(
							'key' => 'field_6179a91b3a44a',
							'label' => 'Use Bootstrap Markup for Breadcrumbs',
							'name' => 'bootstrap_breadcrumbs',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
								'id' => '',
							),
							'acfe_save_meta' => 0,
							'message' => '',
							'default_value' => 1,
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
							'key' => 'field_6179a9463a44b',
							'label' => 'Update Page Type Based on the URL',
							'name' => 'update_url',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
								'id' => '',
							),
							'acfe_save_meta' => 0,
							'message' => '',
							'default_value' => 1,
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
							'key' => 'field_6179a9833a44d',
							'label' => 'Use Bootstrap Accordion Markup for FAQs',
							'name' => 'bootstrap_faqs',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
								'id' => '',
							),
							'acfe_save_meta' => 0,
							'message' => '',
							'default_value' => 1,
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
							'key' => 'field_6179a9a33a44e',
							'label' => 'Update page paths',
							'name' => 'update_paths',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'label-inline w-100',
								'id' => '',
							),
							'acfe_save_meta' => 0,
							'message' => '',
							'default_value' => 1,
							'ui' => 1,
							'ui_on_text' => '',
							'ui_off_text' => '',
							'show_column' => 0,
							'show_column_sortable' => 0,
							'show_column_weight' => 1000,
							'allow_quickedit' => 0,
							'allow_bulkedit' => 0,
						),
					),
				),

				array(
					'key' => 'field_623511a69d0ef',
					'label' => 'BugHerd',
					'name' => 'bugherd',
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
							'key' => 'field_623511bc9d0f0',
							'label' => 'Enable BugHerd',
							'name' => 'enable',
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
							'key' => 'field_623511f39d0f1',
							'label' => 'Project Key',
							'name' => 'project_key',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_623511bc9d0f0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
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
							'key' => 'field_623512149d0f2',
							'label' => 'Enable Frontend',
							'name' => 'frontend',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_623511bc9d0f0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 1,
							'ui' => 1,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_623512329d0f3',
							'label' => 'Enable Backend',
							'name' => 'backend',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_623511bc9d0f0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
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
			),
		),
		array(
			'key' => 'field_614cf2b1392d1',
			'label' => 'CPTs',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_614cf1d7be4c9',
			'label' => 'Custom Post Type Options',
			'name' => 'cpt_options',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'label-none',
				'id' => '',
			),
			'acfe_save_meta' => 0,
			'layout' => 'row',
			'acfe_seamless_style' => 0,
			'acfe_group_modal' => 0,
			'sub_fields' => array(
				array(
					'key' => 'field_614cf1f1be4ca',
					'label' => 'Enable custom pages for post types?',
					'name' => 'page_for_cpt',
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
					'key' => 'field_614cf34c2b4e2',
					'label' => 'Enable Custom Post Types',
					'name' => 'cpts',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'acfe_save_meta' => 0,
					'choices' => array(
						'landing_page' => 'Landing Pages',
						'team_member' => 'Team Members',
						'page_header' => 'Custom Page Headers',
						'global_block' => 'Global Blocks',
						'testimonial' => 'Testimonials',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'array',
					'show_column' => 0,
					'show_column_weight' => 1000,
					'allow_quickedit' => 0,
					'allow_bulkedit' => 0,
					'save_custom' => 0,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'rwp-options',
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
	'show_in_rest' => 0,
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
));

endif;
