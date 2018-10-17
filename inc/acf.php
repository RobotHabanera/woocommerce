<?php
/**
 * Filters and include calls for the ACF plugin, so it is available within the theme
 *
 * @see http://www.advancedcustomfields.com/resources/including-acf-in-a-plugin-theme/
 *
 * @package woondershop-pt
 */

if ( 'yes' !== get_theme_mod( 'show_acf', 'no' ) && ! defined( 'ACF_LITE' ) ) {
	// Hide ACF field group menu depending on the setting in customizer.
	define( 'ACF_LITE', true );
}

// Load acf field groups from PHP file.
if ( ! PT_DEVELOPMENT ) {
	WoonderShopHelpers::load_file( '/inc/acf-field-groups.php' );
}


/**
 * Fix if the ACF is not activated yet
 */
add_action( 'get_header', function () {
	if ( ! function_exists( 'get_field' ) ) {
		function get_field( $setting, $id = 0 ) {
			return false;
		}

		function have_rows( $value = false ) {
			return false;
		}
	}
} );


/**
 * Remove the ACF PRO update notices, because the theme will bundle this plugin
 * and user will be able to update it in Appearance -> Install plugins.
 *
 * @param boolean $value If the ACF PRO update notices should be displayed.
 *
 * @return bool
 */
function woondershop_remove_acf_updates_notice( $value ) {
	if ( function_exists( 'acf_pro_get_license_key' ) && acf_pro_get_license_key() ) {
		return $value;
	}

	return false;
}
add_filter( 'acf/settings/show_updates', 'woondershop_remove_acf_updates_notice' );
