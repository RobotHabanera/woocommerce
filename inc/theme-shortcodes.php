<?php
/**
 * Load all the individual shortcodes
 *
 * @package woondershop-pt
 */

add_action( 'init', function () {
	$woondershop_custom_shortcodes = array(
		'shortcode-urgency-countdown',
		'shortcode-time-left',
		'shortcode-woonder-product',
	);

	foreach ( $woondershop_custom_shortcodes as $filename ) {
		WoonderShopHelpers::load_file( sprintf( '/inc/shortcodes/%s.php', $filename ) );
	}
} );
