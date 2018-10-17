<?php
/**
 * Compatibility hooks
 *
 * For 3rd party plugins/features.
 *
 * @package woondershop-pt
 */

/**
 * WoonderShopCompat class with compatibility hooks
 */
class WoonderShopCompat {

	/**
	 * Runs on class initialization. Adds actions and filters.
	 */
	function __construct() {
		add_action( 'activate_breadcrumb-navxt/breadcrumb-navxt.php', array( $this, 'custom_hseparator' ) );
	}

	/**
	 * Set custom separator for NavXT breadcrumbs plugin.
	 */
	function custom_hseparator() {
		add_option( 'bcn_options', array( 'hseparator' => '' ) );
	}
}

// Single instance.
$woondershop_compat = new WoonderShopCompat();
