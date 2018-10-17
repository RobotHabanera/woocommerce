<?php
/**
 * Load the Customizer with some custom extended addons
 *
 * @package woondershop-pt
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

/**
 * Require the customizer settings data class.
 */
require_once 'customizer/class-customizer-settings-data.php';

/**
 * Load the WoonderShop Customizer Options wrapper class and register the options.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/customizer/class-woondershop-customizer-options.php';

WoonderShopCustomizerOptions::register_options();

/**
 * This funtion is only called when the user is actually on the customizer page
 *
 * @param  WP_Customize_Manager $wp_customize
 */
if ( ! function_exists( 'woondershop_customizer' ) ) {
	function woondershop_customizer( $wp_customize ) {
		// Add required files.
		WoonderShopHelpers::load_file( '/inc/customizer/class-customize-base.php' );

		new WoonderShop_Customizer_Base( $wp_customize );
	}
	add_action( 'customize_register', 'woondershop_customizer' );
}


/**
 * Takes care for the frontend output from the customizer and nothing else
 */
if ( ! function_exists( 'woondershop_customizer_frontend' ) && ! class_exists( 'WoonderShop_Customize_Frontent' ) ) {
	function woondershop_customizer_frontend() {
		WoonderShopHelpers::load_file( '/inc/customizer/class-customize-frontend.php' );
		$woondershop_customize_frontent = new WoonderShop_Customize_Frontent();
	}
	add_action( 'init', 'woondershop_customizer_frontend' );
}


/**
 * Enqueue script for custom customizer JS code.
 */
if ( ! function_exists( 'woondershop_custom_customizer_code_enqueue' ) ) {
	function woondershop_custom_customizer_code_enqueue() {
		$ver = true === PT_DEVELOPMENT ? null : WOONDERSHOP_WP_VERSION;

		wp_enqueue_script( 'woondershop-customizer-controls-js', get_template_directory_uri() . '/assets/admin/js/customizer.js', array( 'jquery', 'underscore', 'customize-controls' ), $ver, true );

		$ws_customizer_settings_data = WoonderShop_Customizer_Settings_Data::get_instance();

		wp_localize_script( 'woondershop-customizer-controls-js', 'WoonderShopCustomizerVars', array(
			'registered_settings' => $ws_customizer_settings_data->get_data(),
			'texts'               => array(
				'skin_color_change'      => esc_html__( 'Do you want that all color controls are re-set to the default colors of the selected theme skin?', 'woondershop-pt' ),
				'skin_color_change_note' => esc_html__( 'Note: This will make your new skin selection easier to customize, however, you will lose your current skin colors in the process.', 'woondershop-pt' ),
			),
		) );
	}
	add_action( 'customize_controls_enqueue_scripts', 'woondershop_custom_customizer_code_enqueue' );
}
