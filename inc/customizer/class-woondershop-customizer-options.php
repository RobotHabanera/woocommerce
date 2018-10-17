<?php
/*
 * A Customizer options wrapper class.
 *
 * Uses the Kirki customizer framework: https://wordpress.org/plugins/kirki/.
 */

class WoonderShopCustomizerOptions {
	/**
	 * Register the options (panels, sections and fields).
	 *
	 * Kirki wants to register them directly in code or on WP init hook, but not in the "customize_register" hook.
	 */
	public static function register_options() {
		// 04. Footer -> 04.05. Footer benefit bar -> Repeating fields settings.
		self::add_field(
			'footer_benefit_bar_settings',
			array(
				'type'        => 'repeater',
				'label'       => esc_attr__( 'Footer benefit settings', 'woondershop-pt' ),
				'section'     => 'woondershop_section_footer_benefit_bar',
				'priority'    => 20,
				'settings'    => 'footer_benefit_bar_settings',
				'active_callback' =>  function() {
					return WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) && 'hide' !== get_theme_mod( 'footer_benefit_bar', 'show' );
				},
				'row_label'   => array(
					'type'  => 'text',
					'value' => esc_attr__( 'Benefit item', 'woondershop-pt' ),
				),
				'default' => array(
					array(
						'icon'  => 'ws ws-delivery-truck',
						'title' => 'Free Delivery',
						'text'  => 'On all orders over $30',
						'url'   => '',
					),
					array(
						'icon'  => 'ws ws-return',
						'title' => 'Free Returns',
						'text'  => 'No questions asked return policy',
						'url'   => '',
					),
					array(
						'icon'  => 'ws ws-chat',
						'title' => 'Need Help? +555 123 4567',
						'text'  => 'Call us on a toll-free phone number',
						'url'   => '',
					),
					array(
						'icon'  => 'ws ws-medal',
						'title' => 'Money Back Guarantee',
						'text'  => 'No questions asked',
						'url'   => '',
					),
				),
				'fields' => array(
					'icon' => array(
						'type'        => 'text',
						'label'       => esc_attr__( 'Icon classes', 'woondershop-pt' ),
						'description' => sprintf( esc_attr__( 'You can select the icons from the free %1$sFontAwesome icon collection%2$s or from the %3$sWoonderShop custom icons%2$s. Input a FontAwesome or WoonderShop custom icon classes, for example: %4$sfar fa-address-book%5$s or %4$sws ws-medal%5$s', 'woondershop-pt' ) , '<a href="https://fontawesome.com/icons/" target="_blank">', '</a>', '<a href="https://www.proteusthemes.com/help/woondershop-custom-icons/" target="_blank">', '<strong>', '</strong>' ),
						'default'     => 'ws ws-medal',
					),
					'title' => array(
						'type'        => 'text',
						'label'       => esc_attr__( 'Title', 'woondershop-pt' ),
						'default'     => '',
					),
					'text' => array(
						'type'        => 'text',
						'label'       => esc_attr__( 'Text', 'woondershop-pt' ),
						'default'     => '',
					),
					'url' => array(
						'type'        => 'text',
						'label'       => esc_attr__( 'URL', 'woondershop-pt' ),
						'description' => esc_attr__( 'Do you want to link your benefit item? Input a URL! If left empty the block is not linkable.', 'woondershop-pt' ),
						'default'     => '',
					),
				),
			)
		);
	}


	/**
	 * Create a new panel.
	 *
	 * @param string $id   The ID for the panel.
	 * @param array  $args The panel arguments.
	 */
	public static function add_panel( $id = '', $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_panel( $id, $args );
		}
	}


	/**
	 * Create a new section.
	 *
	 * @param string $id   The ID for the section.
	 * @param array  $args The section arguments.
	 */
	public static function add_section( $id, $args ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_section( $id, $args );
		}
	}


	/**
	 * Create a new field.
	 *
	 * @param string $id   The ID for the field.
	 * @param array  $args The field's arguments.
	 */
	public static function add_field( $id, $args ) {
		$id = empty( $id ) ? $args['settings'] : $id;

		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_field( $id, $args );
		}
	}


	/**
	 * Sets the configuration options.
	 *
	 * @param string $config_id The configuration ID.
	 * @param array  $args      The configuration arguments.
	 */
	public static function add_config( $config_id, $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_config( $config_id, $args );
		}
	}
}
