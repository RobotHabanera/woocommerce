<?php
/**
 * Merlin WP configuration file.
 */

if ( defined( 'PT_DEVELOPMENT' ) && PT_DEVELOPMENT ) {
	return;
}

define( 'MERLIN_VERSION', '1.0.0' );

WoonderShopHelpers::load_file( '/vendor/richtabor/merlin-wp/merlin.php' );

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and other settings for Merlin WP.
 */
$wizard = new Merlin(
	// Configure Merlin with custom settings.
	$config = array(
		'directory'                => 'vendor/richtabor/merlin-wp',
		'merlin_url'               => 'merlin',
		'child_action_btn_url'     => 'https://www.proteusthemes.com/blog/the-ultimate-guide-to-wordpress-child-themes/',
		'theme_license_step'       => true,
		'theme_license_btn_url'    => 'https://www.proteusthemes.com/help/can-find-theme-license-key/',
		'edd_item_name'            => 'WoonderShop',
		'edd_theme_slug'           => 'woondershop',
		'edd_remote_api_url'       => '',
		'help_mode'                => false,
		'dev_mode'                 => false,
		'branding'                 => false,
	),
	// Text strings.
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup' , 'woondershop-pt' ),
		'title%s%s%s%s' 		       => esc_html__( '%s%s Themes &lsaquo; Theme Setup: %s%s' , 'woondershop-pt' ),

		'return-to-dashboard'      => esc_html__( 'Return to the dashboard' , 'woondershop-pt' ),

		'btn-skip'                  => esc_html__( 'Skip', 'woondershop-pt' ),
		'btn-next'                  => esc_html__( 'Next', 'woondershop-pt' ),
		'btn-start'                 => esc_html__( 'Start', 'woondershop-pt' ),
		'btn-no'                    => esc_html__( 'Cancel', 'woondershop-pt' ),
		'btn-plugins-install'       => esc_html__( 'Install', 'woondershop-pt' ),
		'btn-theme-license-install' => esc_html__( 'Activate', 'woondershop-pt' ),
		'btn-child-install'         => esc_html__( 'Install', 'woondershop-pt' ),
		'btn-content-install'       => esc_html__( 'Install', 'woondershop-pt' ),
		'btn-import'                => esc_html__( 'Import' , 'woondershop-pt' ),

		'welcome-header%s'         => esc_html__( 'Welcome to %s' , 'woondershop-pt' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back' , 'woondershop-pt' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.' , 'woondershop-pt' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.' , 'woondershop-pt' ),

		'theme-license-header'         => esc_html__( 'Register theme' , 'woondershop-pt' ),
		'theme-license-header-success' => esc_html__( 'You\'re good to go!' , 'woondershop-pt' ),
		'theme-license'                => esc_html__( 'Input the theme license key and activate it, to unlock the theme\'s full potential.' , 'woondershop-pt' ),
		'theme-license-label'          => esc_html__( 'License key:' , 'woondershop-pt' ),
		'theme-license-success%s'      => esc_html__( 'The theme is already registered, so you can go to the next step!' , 'woondershop-pt' ),
		'theme-license-action-link'    => esc_html__( 'Where can I find the license key?' , 'woondershop-pt' ),

		'child-header'             => esc_html__( 'Install Child Theme' , 'woondershop-pt' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!' , 'woondershop-pt' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.' , 'woondershop-pt' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.' , 'woondershop-pt' ),
		'child-action-link'        => esc_html__( 'Learn about child themes' , 'woondershop-pt' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.' , 'woondershop-pt' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.' , 'woondershop-pt' ),

		'plugins-header'           => esc_html__( 'Install Plugins' , 'woondershop-pt' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!' , 'woondershop-pt' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.' , 'woondershop-pt' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.' , 'woondershop-pt' ),
		'plugins-action-link'      => esc_html__( 'Advanced' , 'woondershop-pt' ),

		'import-header'            => esc_html__( 'Import Content' , 'woondershop-pt' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme. This might take a few minutes!' , 'woondershop-pt' ),
		'import-action-link'       => esc_html__( 'Advanced' , 'woondershop-pt' ),

		'ready-header'             => esc_html__( 'All done. Have fun!' , 'woondershop-pt' ),
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.' , 'woondershop-pt' ),
		'ready-action-link'        => esc_html__( 'Extras' , 'woondershop-pt' ),
		'ready-big-button'         => esc_html__( 'View your website' , 'woondershop-pt' ),

		'ready-link-1'             => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__( 'Explore WordPress', 'woondershop-pt' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
		'ready-link-2'             => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themebeans.com/contact/', esc_html__( 'Get Theme Support', 'woondershop-pt' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
		'ready-link-3'             => wp_kses( sprintf( '<a href="'.admin_url( 'customize.php' ).'" target="_blank">%s</a>', esc_html__( 'Start Customizing', 'woondershop-pt' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
	)
);
