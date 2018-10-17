<?php
/**
 * Load here all the individual widgets
 *
 * @package woondershop-pt
 */

// ProteusWidgets init.
new ProteusWidgets();

// Require the individual widgets.
add_action( 'widgets_init', function () {
	// Custom widgets in the theme.
	$woondershop_custom_widgets = array(
		'widget-call-to-action',
		'widget-opening-time',
		'widget-image-banner',
		'widget-woo-cart',
		'widget-featured-product',
		'widget-instagram',
		'widget-countdown',
		'widget-woonder-products',
		'widget-title-with-button',
	);

	// Load skin specific widgets.
	if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) {
		$woondershop_custom_widgets[] = 'widget-title-with-button';
	}

	foreach ( $woondershop_custom_widgets as $file ) {
		WoonderShopHelpers::load_file( sprintf( '/inc/widgets/%s.php', $file ) );
	}

	// Relying on composer's autoloader, just provide classes from ProteusWidgets.
	register_widget( 'PW_Brochure_Box' );
	register_widget( 'PW_Facebook' );
	register_widget( 'PW_Icon_Box' );
	register_widget( 'PW_Skype' );
	register_widget( 'PW_Social_Icons' );
	register_widget( 'PW_Accordion' );
	register_widget( 'PW_Latest_News' );


	// Load skin specific widgets.
	if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) {
		register_widget( 'PW_Testimonials' );
	}
} );
