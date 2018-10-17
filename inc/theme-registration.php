<?php
/**
 * Theme registration for this theme.
 *
 * @package woondershop-pt
 */

use ProteusThemes\ThemeRegistration\ThemeRegistration;

class WoonderShopThemeRegistration {
	function __construct() {
		$this->enable_theme_registration();
	}

	/**
	 * Load theme registration and automatic updates.
	 */
	private function enable_theme_registration() {
		$config = array(
			'item_name'        => 'WoonderShop',
			'theme_slug'       => 'woondershop-pt',
			'item_id'          => 40615,
			'tf_item_id'       => 0,
			'customizer_panel' => 'panel_woondershop',
			'build'            => 'pt',
		);
		$pt_theme_registration = ThemeRegistration::get_instance( $config );
	}
}

if ( ! PT_DEVELOPMENT ) {
	$woondershop_theme_registration = new WoonderShopThemeRegistration();
}
