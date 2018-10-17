<?php
/**
 * Loading the remote and local plugins when the theme is activated
 *
 * For reference see file vendor/tgm/plugin-activation/example.php
 *
 * @package TGM-Plugin-Activation
 */

/**
 * Register the required plugins for this theme.
 */
function woondershop_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'               => 'Advanced Custom Fields PRO',
			'slug'               => 'advanced-custom-fields-pro',
			'source'             => get_template_directory() . '/bundled-plugins/advanced-custom-fields-pro.zip',
			'required'           => true,
			'force_activation'   => true,
			'version'            => '5.6.10',
			'external_url'       => 'https://www.advancedcustomfields.com/pro',
		),
		array(
			'name'               => 'ProteusThemes Shortcodes',
			'slug'               => 'pt-shortcodes',
			'source'             => 'https://github.com/proteusthemes/pt-shortcodes/archive/master.zip',
			'required'           => true,
			'version'            => '1.7.3',
			'external_url'       => 'https://github.com/proteusthemes/pt-shortcodes',
		),
		array(
			'name'               => 'Page Builder by SiteOrigin',
			'slug'               => 'siteorigin-panels',
			'required'           => true,
			'version'            => '2.0',
		),
		array(
			'name'               => 'SiteOrigin Widgets Bundle',
			'slug'               => 'so-widgets-bundle',
			'required'           => true,
		),
		array(
			'name'               => 'WooCommerce - excelling eCommerce',
			'slug'               => 'woocommerce',
			'required'           => true,
		),
		array(
			'name'               => 'Contact Form 7',
			'slug'               => 'contact-form-7',
			'required'           => false,
		),
		array(
			'name'               => 'WP Featherlight - A Simple jQuery Lightbox',
			'slug'               => 'wp-featherlight',
			'required'           => false,
		),
		array(
			'name'               => 'Smart WooCommerce Search',
			'slug'               => 'smart-woocommerce-search',
			'required'           => false,
		),
		array(
			'name'               => 'Themify - WooCommerce Product Filter',
			'slug'               => 'themify-wc-product-filter',
			'required'           => false,
		),
		array(
			'name'               => 'Breadcrumb NavXT',
			'slug'               => 'breadcrumb-navxt',
			'required'           => false,
		),
		array(
			'name'               => 'MailChimp widget by ProteusThemes',
			'slug'               => 'proteusthemes-mailchimp-widget',
			'required'           => false,
		),
	);

	// Array of configuration settings. See the source example.php file to add it if needed.
	// Let the magic happen!
	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'woondershop_register_required_plugins' );
