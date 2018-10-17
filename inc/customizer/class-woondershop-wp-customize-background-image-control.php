<?php
/*
 * Custom customizer control: Background image.
 *
 * Taken from the WP core customizer control: WP_Customize_Background_Image_Control
 * The priority and the section parameters were changed, everything else is the same.
 */
class WoonderShop_WP_Customize_Background_Image_Control extends WP_Customize_Image_Control {
	public $type = 'background';

	/**
	 * Constructor.
	 *
	 * @uses WP_Customize_Image_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 */
	public function __construct( $manager ) {
		parent::__construct(
			$manager, 'background_image', array(
				'priority' => 170,
				'label'    => __( 'Background Image', 'woondershop-pt' ),
				'description' => esc_html__( 'This background image is only visible with boxed (General -> Layout) setting.', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		);
	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {
		parent::enqueue();
		$custom_background = get_theme_support( 'custom-background' );
		wp_localize_script(
			'customize-controls', '_wpCustomizeBackground', array(
				'defaults' => ! empty( $custom_background[0] ) ? $custom_background[0] : array(),
				'nonces'   => array(
					'add' => wp_create_nonce( 'background-add' ),
				),
			)
		);
	}
}
