<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5adf0f796438c',
	'title' => 'Additional product category fields',
	'fields' => array(
		array(
			'key' => 'field_5adf0f8ab34d1',
			'label' => 'Description above',
			'name' => 'description_above',
			'type' => 'wysiwyg',
			'instructions' => 'This text will be displayed on the category page, above the category product catalog. It can be used for useful information, SEO purposes, ...',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_5adf10d4a20d8',
			'label' => 'Description below',
			'name' => 'description_below',
			'type' => 'wysiwyg',
			'instructions' => 'This text will be displayed on the category page, below the category product catalog. It can be used for useful information, SEO purposes, ...',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'product_cat',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5a8ac8c52f61d',
	'title' => 'Front page slider',
	'fields' => array(
		array(
			'key' => 'field_5729d1abfb679',
			'label' => 'Slides',
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
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5548717a1b3e4',
			'label' => 'Slider content',
			'name' => 'slider_content',
			'type' => 'radio',
			'instructions' => 'Choose \'Slider with captions\' to add title and text over the slides or choose \'Slider with links\' to apply links to slides.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'caption' => 'Slider with captions',
				'link' => 'Slider with links',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'caption',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5a9ea1123fb4c',
			'label' => 'Slides',
			'name' => 'slides',
			'type' => 'repeater',
			'instructions' => 'You can add multiple slides. Start adding them by clicking "Add Another Slider" on the right.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5a9ea76a3fb52',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => 'Add Another Slide',
			'sub_fields' => array(
				array(
					'key' => 'field_5a9ea57d3fb4e',
					'label' => 'Image or Video',
					'name' => 'image_or_video',
					'type' => 'radio',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'image' => 'Image',
						'video' => 'Video',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => 'image',
					'layout' => 'horizontal',
					'return_format' => 'value',
				),
				array(
					'key' => 'field_5aa1359ff94fe',
					'label' => 'Instructions for video slide',
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5a9ea57d3fb4e',
								'operator' => '==',
								'value' => 'video',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => 'Video slide still needs an image which will automatically get a play button overlay.

Upon clicking on the play button, the video will be opened in the popup and started to play automatically. This is the best UX practice. If you require a different behavior, we recommend using dedicated slider plugin for that job.',
					'new_lines' => 'wpautop',
					'esc_html' => 0,
				),
				array(
					'key' => 'field_5a9ea5d33fb4f',
					'label' => 'Slide image',
					'name' => 'slide_image',
					'type' => 'image',
					'instructions' => 'The best image size for the slider is <strong>1920 pixels</strong> wide and <strong>600 pixels</strong> high (the same image dimensions are used in the theme demo). You can also upload images of different size or with to height ratio but this might break the theme layout. <a href="https://www.proteusthemes.com/blog/7-design-tips-improve-slider-images/" target="_blank">Learn more about how to prepare good images for the slider</a>.',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'preview_size' => 'woondershop-jumbotron-slider-m',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5a9ea7163fb51',
					'label' => 'Video URL',
					'name' => 'video_url',
					'type' => 'url',
					'instructions' => 'Add YouTube or Vimeo video URL.',
					'required' => 1,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5a9ea57d3fb4e',
								'operator' => '==',
								'value' => 'video',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
				),
				array(
					'key' => 'field_5a9ea76a3fb52',
					'label' => 'Slide title',
					'name' => 'slide_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5548717a1b3e4',
								'operator' => '==',
								'value' => 'caption',
							),
							array(
								'field' => 'field_5b16488fd321c',
								'operator' => '==',
								'value' => 'fullwidth',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5a9ea7a93fb53',
					'label' => 'Slide text',
					'name' => 'slide_text',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5548717a1b3e4',
								'operator' => '==',
								'value' => 'caption',
							),
							array(
								'field' => 'field_5a9ea57d3fb4e',
								'operator' => '==',
								'value' => 'image',
							),
							array(
								'field' => 'field_5b16488fd321c',
								'operator' => '==',
								'value' => 'fullwidth',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 0,
					'delay' => 0,
				),
				array(
					'key' => 'field_5a9ea8043fb56',
					'label' => 'Slide link',
					'name' => 'slide_link',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5548717a1b3e4',
								'operator' => '==',
								'value' => 'link',
							),
							array(
								'field' => 'field_5a9ea57d3fb4e',
								'operator' => '==',
								'value' => 'image',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'https://www.amazon.com/',
				),
				array(
					'key' => 'field_5a9ea84d3fb58',
					'label' => 'Slide open link in new window/tab',
					'name' => 'slide_open_link_in_new_windowtab',
					'type' => 'true_false',
					'instructions' => 'Open link in a new window/tab',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5548717a1b3e4',
								'operator' => '==',
								'value' => 'link',
							),
							array(
								'field' => 'field_5a9ea57d3fb4e',
								'operator' => '==',
								'value' => 'image',
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
					'ui_on_text' => 'Yes',
					'ui_off_text' => 'No',
				),
			),
		),
		array(
			'key' => 'field_5729d184fb678',
			'label' => 'Slider settings',
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
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5b16488fd321c',
			'label' => 'Slider width',
			'name' => 'slider_width',
			'type' => 'button_group',
			'instructions' => 'If you select \'Boxed\' there will be no option for slide title/text beucase there is much less space available.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'fullwidth' => 'Full Width',
				'boxed' => 'Boxed',
			),
			'allow_null' => 0,
			'default_value' => 'fullwidth',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5b167802aa905',
			'label' => 'Background color',
			'name' => 'slider_background_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b16488fd321c',
						'operator' => '==',
						'value' => 'boxed',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#f5f7fa',
		),
		array(
			'key' => 'field_5729dba1e3f47',
			'label' => 'Slide effects',
			'name' => 'slide_effects',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'slide' => 'Slide',
				'fade' => 'Fade',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'slide',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_55487307bdff8',
			'label' => 'Auto cycle',
			'name' => 'auto_cycle',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Automatically cycle the slides',
			'default_value' => 1,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_55487335bdff9',
			'label' => 'Cycle interval',
			'name' => 'cycle_interval',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_55487307bdff8',
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
			'default_value' => 5000,
			'placeholder' => '',
			'prepend' => '',
			'append' => 'ms',
			'min' => 0,
			'max' => '',
			'step' => 1000,
		),
		array(
			'key' => 'field_5729df9d024d8',
			'label' => 'Transition speed',
			'name' => 'transition_speed',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 600,
			'placeholder' => '',
			'prepend' => '',
			'append' => 'ms',
			'min' => 0,
			'max' => '',
			'step' => 10,
		),
		array(
			'key' => 'field_5729de0638113',
			'label' => 'Navigation arrows',
			'name' => 'navigation_arrows',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Show navigation arrows',
			'default_value' => 1,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5729d98501bf1',
			'label' => 'Navigation dots',
			'name' => 'navigation_dots',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Show slider navigation dots',
			'default_value' => 1,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_575e5604487a0',
			'label' => 'Adaptive Height',
			'name' => 'adaptive_height',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Adapt slider height to the current slide',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template-front-page-slider.php',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5a8ac8d01fa2e',
	'title' => 'Menu item fields',
	'fields' => array(
		array(
			'key' => 'field_5a8ac8d29dfab',
			'label' => 'Icon',
			'name' => 'menu_item_icon',
			'type' => 'text',
			'instructions' => 'Enter the name of the <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a> icon. Example: <i>fas fa-home</i>',
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
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a8d7169d5679',
			'label' => 'Label',
			'name' => 'menu_item_label',
			'type' => 'text',
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
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'nav_menu_item',
				'operator' => '==',
				'value' => 'location/main-menu',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5b0d30a67db91',
	'title' => 'Page subtitle',
	'fields' => array(
		array(
			'key' => 'field_5b0d30a6ab2f7',
			'label' => 'Subtitle',
			'name' => 'subtitle',
			'type' => 'text',
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
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
			array(
				'param' => 'ws_skin',
				'operator' => '==',
				'value' => 'jungle',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5a8ac8c55443d',
	'title' => 'Page title area',
	'fields' => array(
		array(
			'key' => 'field_58aedc9a4a907',
			'label' => 'Show page title area',
			'name' => 'show_page_title_area',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'yes',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5ab4e45ee0241',
			'label' => 'Show Title',
			'name' => 'show_title',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'yes',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_570b5d7dd3bfc',
			'label' => 'Show breadcrumbs',
			'name' => 'show_breadcrumbs',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'yes',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
			array(
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template-front-page-slider.php',
			),
			array(
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template-empty.php',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5b0d3e2716adf',
	'title' => 'Page title area background',
	'fields' => array(
		array(
			'key' => 'field_5b0d3e271b428',
			'label' => 'Background image',
			'name' => 'background_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'return_format' => 'url',
			'min_width' => 0,
			'min_height' => 0,
			'min_size' => 0,
			'max_width' => 0,
			'max_height' => 0,
			'max_size' => 0,
			'mime_types' => '',
		),
		array(
			'key' => 'field_5b0d3e271b4d1',
			'label' => 'Background image horizontal position',
			'name' => 'background_image_horizontal_position',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'left' => 'Left',
				'center' => 'Center',
				'right' => 'Right',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'center',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5b0d3e271b55b',
			'label' => 'Background image vertical position',
			'name' => 'background_image_vertical_position',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'top' => 'Top',
				'center' => 'Center',
				'bottom' => 'Bottom',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'center',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5b0d3e271b5ec',
			'label' => 'Background image repeat',
			'name' => 'background_image_repeat',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'no-repeat' => 'No Repeat',
				'repeat' => 'Tile',
				'repeat-x' => 'Tile Horizontally',
				'repeat-y' => 'Tile Vertically',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'repeat',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5b0d3e271b6a7',
			'label' => 'Background image attachment',
			'name' => 'background_image_attachment',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'scroll' => 'Scroll',
				'fixed' => 'Fixed',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'scroll',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5b0d3e271b751',
			'label' => 'Background color',
			'name' => 'background_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
			array(
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template-front-page-slider.php',
			),
			array(
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template-empty.php',
			),
			array(
				'param' => 'ws_skin',
				'operator' => '==',
				'value' => 'default',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5a8ac8c5747f6',
	'title' => 'Position of the Sidebar',
	'fields' => array(
		array(
			'key' => 'field_5534bcc459d58',
			'label' => '',
			'name' => 'sidebar',
			'type' => 'radio',
			'instructions' => 'Position the sidebar for this particular page: left, right or do not display it at all.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'right' => 'Right',
				'left' => 'Left',
				'none' => 'No Sidebar',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'none',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
			array(
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template-front-page-slider.php',
			),
			array(
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template-front-page-slider-alt.php',
			),
			array(
				'param' => 'page_type',
				'operator' => '!=',
				'value' => 'posts_page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
	),
	'active' => 1,
	'description' => '',
));

endif;
