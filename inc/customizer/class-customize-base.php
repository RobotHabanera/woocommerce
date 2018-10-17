<?php
/**
 * Customizer
 *
 * @package woondershop-pt
 */

/*
 Customizer arrangement

 TABLE OF CONTENTS
	01. General panel
		01.01. Global Colors
		01.02. Layout
		01.03. Homepage Settings (native WordPress settings)
		01.04. Site Identity (native WordPress settings)
	02. Header panel
		02.01. Logo
		02.02. Top Bar
		02.03. Header Widgets
		02.04. Navigation
		02.05. Page Title
		02.06. Benefit Bar
		02.07. Sticky Header
		02.08. Mobile Header
	03. Shop (WooCommerce)
		03.01. Product Catalog
		03.02. Product Page
		03.03. Product Images
		03.04. Checkout Page
		03.05. Store Notice (Native WooCommerce settings)
	04. Footer
		04.01. Layout
		04.02. Bottom Bar Content
		04.03. Colors
		04.04. Back to Top
		04.05. Footer Benefit Bar
	05. Blog
		05.01. Layout
		05.02. Single Post
	06. Widgets
	07. Menus
	08. Additional Javascript
	09. Additional CSS
	10. Other
*/

use ProteusThemes\CustomizerUtils\Setting;
use ProteusThemes\CustomizerUtils\Control;
use ProteusThemes\CustomizerUtils\CacheManager;
use ProteusThemes\CustomizerUtils\Helpers as WpUtilsHelpers;

require_once 'class-woondershop-wp-customize-background-image-control.php';
require_once 'class-woondershop-separator-custom-control.php';

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class WoonderShop_Customizer_Base {
	/**
	 * The singleton manager instance
	 *
	 * @see wp-includes/class-wp-customize-manager.php
	 * @var WP_Customize_Manager
	 */
	protected $wp_customize;

	/**
	 * Instance of the DynamicCSS cache manager
	 *
	 * @var ProteusThemes\CustomizerUtils\CacheManager
	 */
	private $dynamic_css_cache_manager;

	/**
	 * Holds the array for the DynamicCSS.
	 *
	 * @var array
	 */
	private $dynamic_css = array();

	/**
	 * HTML ID of the <style> tag which contains render of DynamicCSS
	 */
	const DYNAMIC_CSS_STYLE_TAG_ID = 'wp-utils-dynamic-css-style-tag';

	/**
	 * Constructor method for this class.
	 *
	 * @param WP_Customize_Manager $wp_customize The WP customizer manager instance.
	 */
	public function __construct( WP_Customize_Manager $wp_customize ) {
		// Set the private propery to instance of wp_customize.
		$this->wp_customize = $wp_customize;

		// Set the private propery to instance of DynamicCSS CacheManager.
		$this->dynamic_css_cache_manager = new CacheManager( $this->wp_customize );

		// Init the dynamic_css property.
		$this->dynamic_css = $this->dynamic_css_init();

		// Register the settings/panels/sections/controls.
		$this->register_settings();
		$this->register_panels();
		$this->register_sections();
		$this->register_partials();
		$this->register_controls();

		/**
		 * Action and filters
		 */

		// Render the CSS and cache it to the theme_mod when the setting is saved.
		add_action( 'wp_head', array( $this, 'add_dynamic_css_style_tag' ), 50, 0 );
		add_action( 'customize_save_after', function() {
			$woondershop_woocommerce_selectors_filter_callable = false;

			if ( ! WoonderShopHelpers::is_woocommerce_active() ) {
				$woondershop_woocommerce_selectors_filter_callable = function ( $css_selector ) {
					return false === strpos( $css_selector, '.woocommerce' ) && false === strpos( $css_selector, '.wc-appointments' );
				};
			}

			$this->dynamic_css_cache_manager->cache_rendered_css( $woondershop_woocommerce_selectors_filter_callable );
		}, 10, 0 );

		// Save logo width/height dimensions.
		add_action( 'customize_save_logo_img', array( 'ProteusThemes\CustomizerUtils\Helpers', 'save_logo_dimensions' ), 10, 1 );
	}


	/**
	 * Initialization of the dynamic CSS settings with config arrays
	 *
	 * @return array
	 */
	private function dynamic_css_init() {
		$ws_customizer_settings_data = WoonderShop_Customizer_Settings_Data::get_instance();

		return $ws_customizer_settings_data->get_data();
	}


	/**
	 * Add <style> tag when in customizer
	 *
	 * @return void
	 */
	public function add_dynamic_css_style_tag() {
		printf(
			'<style id="%s" type="text/css">%s</style>',
			esc_attr( self::DYNAMIC_CSS_STYLE_TAG_ID ),
			$this->dynamic_css_cache_manager->render_css()
		);
	}

	/**
	 * Register customizer settings
	 *
	 * @return void
	 */
	public function register_settings() {
		// Skins
		$this->wp_customize->add_setting( 'ws_skin', array( 'default' => 'default', 'sanitize_callback' => 'sanitize_key' ) );

		// Branding.
		$this->wp_customize->add_setting( 'logo_img', array( 'sanitize_callback' => 'esc_url' ) );
		$this->wp_customize->add_setting( 'logo2x_img', array( 'sanitize_callback' => 'esc_url' ) );
		$this->wp_customize->add_setting( 'logo_padding_top', array( 'sanitize_callback' => 'esc_html' ) );
		$this->wp_customize->add_setting( 'logo_padding_right', array( 'sanitize_callback' => 'esc_html' ) );
		$this->wp_customize->add_setting( 'logo_padding_bottom', array( 'sanitize_callback' => 'esc_html' ) );
		$this->wp_customize->add_setting( 'logo_padding_left', array( 'sanitize_callback' => 'esc_html' ) );

		// Header.
		$this->wp_customize->add_setting( 'show_page_title_area', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'page_title_area_bg_color', array( 'default' => '#f4f4f4' ) );
		$this->wp_customize->add_setting( 'page_title_area_bg_color_opacity', array( 'default' => 100 ) );
		$this->wp_customize->add_setting( 'show_mobile_search_in_header', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'show_mobile_cart_in_header', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'top_left_bar_visibility', array( 'default' => 'hide_mobile', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'top_left_bar_only_on_homepage', array( 'default' => false, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'top_right_bar_visibility', array( 'default' => 'hide_mobile', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'top_right_bar_only_on_homepage', array( 'default' => false, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'sticky_mobile_header', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'sticky_desktop_header', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'header_widget_area_visibility', array( 'default' => 'hide_mobile', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'header_widget_area_only_on_homepage', array( 'default' => false, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		$this->wp_customize->add_setting( 'benefit_bar_visibility', array( 'default' => 'yes', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'benefit_bar_only_on_homepage', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );

		// Typography.
		$this->wp_customize->add_setting( 'charset_setting', array( 'default' => 'latin', 'sanitize_callback' => 'sanitize_key' ) );

		// Theme layout & color.
		$this->wp_customize->add_setting( 'layout_mode', array( 'default' => 'wide', 'sanitize_callback' => 'sanitize_key' ) );

		// Blog.
		$this->wp_customize->add_setting( 'blog_columns', array( 'default' => '3', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'blog_sidebar', array( 'default' => 'none', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'single_post_sidebar', array( 'default' => 'none', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'article_more_link', array( 'default' => 'hide', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'blog_search_box', array( 'default' => 'show', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'blog_category_box', array( 'default' => 'show', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'reading_time', array( 'default' => 'show', 'sanitize_callback' => 'sanitize_key' ) );

		// Shop.
		if ( WoonderShopHelpers::is_woocommerce_active() ) {
			$this->wp_customize->add_setting( 'products_per_page', array( 'default' => 9, 'sanitize_callback' => 'absint' ) );
			$this->wp_customize->add_setting( 'products_per_row', array( 'default' => 3, 'sanitize_callback' => 'absint' ) );
			$this->wp_customize->add_setting( 'show_add_to_cart_button', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
			$this->wp_customize->add_setting( 'show_add_to_cart_button_dropdown', array( 'default' => 'hover', 'sanitize_callback' => 'sanitize_key' ) );
			$this->wp_customize->add_setting( 'single_product_sidebar', array( 'default' => 'none', 'sanitize_callback' => 'sanitize_key' ) );
			$this->wp_customize->add_setting( 'single_product_show_header_area', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
			$this->wp_customize->add_setting( 'single_product_show_title', array( 'default' => false, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
			$this->wp_customize->add_setting( 'single_product_show_breadcrumbs', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
			$this->wp_customize->add_setting( 'single_product_show_meta', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
			$this->wp_customize->add_setting( 'checkout_floating_labels', array( 'default' => true, 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'sanitize_boolean' ) ) );
		}

		// Footer.
		$this->wp_customize->add_setting( 'footer_widgets_layout', array( 'default' => '[4,6,8]', 'sanitize_callback' => 'wp_kses_post' ) );

		$this->wp_customize->add_setting( 'footer_bottom_left_txt', array( 'default' => 'Copyright &copy;' . date( 'Y' ) . ' <strong><a href="https://www.proteusthemes.com/wordpress-themes/woondershop/">ProteusThemes</a></strong>. All Rights Reserved.', 'sanitize_callback' => 'wp_kses_post' ) );
		$this->wp_customize->add_setting( 'footer_bottom_right_txt', array( 'default' => '<a class="back-to-top  js-back-to-top" href="#">[fa icon="fas fa-chevron-up"] Back to top</a>', 'sanitize_callback' => 'wp_kses_post' ) );
		$this->wp_customize->add_setting( 'footer_credits_txt', array( 'default' => 'Copyright &copy;' . date( 'Y' ) . ' <strong><a href="https://www.proteusthemes.com/wordpress-themes/woondershop/">ProteusThemes</a></strong>. All Rights Reserved.', 'sanitize_callback' => 'wp_kses_post' ) );

		$this->wp_customize->add_setting( 'back_to_top', array( 'default' => 'show', 'sanitize_callback' => 'sanitize_key' ) );

		$this->wp_customize->add_setting( 'footer_benefit_bar', array( 'default' => 'show', 'sanitize_callback' => 'sanitize_key' ) );

		// Custom code (css/js).
		$this->wp_customize->add_setting( 'custom_js_head', array( 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'wp_kses_script' ) ) );
		$this->wp_customize->add_setting( 'custom_js_footer', array( 'sanitize_callback' => array( 'ProteusThemes\CustomizerUtils\Helpers', 'wp_kses_script' ) ) );

		// ACF.
		$this->wp_customize->add_setting( 'show_acf', array( 'default' => 'no', 'sanitize_callback' => 'sanitize_key' ) );
		$this->wp_customize->add_setting( 'use_minified_css', array( 'default' => 'yes', 'sanitize_callback' => 'sanitize_key' ) );

		// All the DynamicCSS settings.
		$chosen_skin = $this->get_chosen_skin();
		foreach ( $this->dynamic_css as $setting_id => $args ) {
			$args = WpUtilsHelpers::process_multiskin_args( $args, $chosen_skin );

			$this->wp_customize->add_setting(
				new Setting\DynamicCSS( $this->wp_customize, $setting_id, $args )
			);
		}
	}


	/**
	 * Returns chosen skin. Checks also in the current customizer changeset.
	 *
	 * @return string WoonderShop skin
	 */
	public function get_chosen_skin() {
		$skin = $this->wp_customize->post_value( $this->wp_customize->get_setting( 'ws_skin' ) );

		if ( ! $skin ) {
			$skin = WoonderShopHelpers::get_skin();
		}

		return $skin;
	}


	/**
	 * Panels
	 *
	 * @return void
	 */
	public function register_panels() {
		// 01. General panel
		$this->wp_customize->add_panel( 'woondershop_panel_general', array(
			'title'       => esc_html__( 'General', 'woondershop-pt' ),
			'description' => esc_html__( 'Site wide settings.', 'woondershop-pt' ),
			'priority'    => 10,
		) );

		// 02. Header panel
		$this->wp_customize->add_panel( 'woondershop_panel_header', array(
			'title'       => esc_html__( 'Header', 'woondershop-pt' ),
			'description' => esc_html__( 'Header settings.', 'woondershop-pt' ),
			'priority'    => 20,
		) );

		// 03. Shop (WooCommerce) panel
		$this->wp_customize->add_panel( 'woocommerce', array(
			'title'       => esc_html__( 'Shop (WooCommerce)', 'woondershop-pt' ),
			'description' => esc_html__( 'Shop (WooCommerce) settings.', 'woondershop-pt' ),
			'priority'    => 30,
		) );

		// 04. Footer
		$this->wp_customize->add_panel( 'woondershop_panel_footer', array(
			'title'       => esc_html__( 'Footer', 'woondershop-pt' ),
			'description' => esc_html__( 'All layout and appearance settings for the footer.', 'woondershop-pt' ),
			'priority'    => 40,
		) );

		// 05. Blog
		$this->wp_customize->add_panel( 'woondershop_panel_blog', array(
			'title'       => esc_html__( 'Blog', 'woondershop-pt' ),
			'description' => esc_html__( 'All blog layout and appearance settings.', 'woondershop-pt' ),
			'priority'    => 50,
		) );

		// 06. Menus, priority => 100
		// 07. Widgets, priority => 110

		// 08. Additional JavaScript - This is actually section
		$this->wp_customize->add_section( 'woondershop_section_additional_javascript', array(
			'title'       => esc_html__( 'Additional JavaScript', 'woondershop-pt' ),
			'priority'    => 190,
			'panel'       => '',
		) );

		// 09. Additional CSS, priority => 200

		// 10. Other - This is actually section
		$this->wp_customize->add_section( 'section_other', array(
			'title'       => esc_html__( 'Other' , 'woondershop-pt' ),
			'priority'    => 210,
			'panel'       => '',
		) );
	}


	/**
	 * Sections
	 *
	 * @return void
	 */
	public function register_sections() {
		// 01. General panel -> 01.01. Global Colors
		$this->wp_customize->add_section( 'woondershop_section_theme_colors', array(
			'title'       => esc_html__( 'Global Colors', 'woondershop-pt' ),
			'priority'    => 10,
			'panel'       => 'woondershop_panel_general',
		) );
		// 01. General panel -> 01.02. Layout
		$this->wp_customize->add_section( 'woondershop_section_layout', array(
			'title'       => esc_html__( 'Layout', 'woondershop-pt' ),
			'priority'    => 20,
			'panel'       => 'woondershop_panel_general',
		) );
		// 01. General panel -> 01.03. Site Identity
		$this->wp_customize->add_section( 'static_front_page', array(
			'title'       => esc_html__( 'Homepage Settings', 'woondershop-pt' ),
			'priority'    => 30,
			'panel'       => 'woondershop_panel_general',
		) );
		// 01. General panel -> 01.04. Site Identity
		$this->wp_customize->add_section( 'title_tagline', array(
			'title'       => esc_html__( 'Site Identity', 'woondershop-pt' ),
			'priority'    => 40,
			'panel'       => 'woondershop_panel_general',
		) );
		// 01. General panel -> 01.05. Skins
		$this->wp_customize->add_section( 'woondershop_section_ws_skins', array(
			'title'       => esc_html__( 'WoonderShop Skins', 'woondershop-pt' ),
			'description' => sprintf( esc_html__( 'WoonderShop skins allow you to dramatically change the look&amp;feel of your eCommerce store.', 'woondershop-pt' ) , '<i>', '</i>' ),
			'priority'    => 50,
			'panel'       => 'woondershop_panel_general',
		) );

		// 02. Header panel -> 02.01. Logo
		$this->wp_customize->add_section( 'woondershop_section_logos', array(
			'title'       => esc_html__( 'Logo', 'woondershop-pt' ),
			'description' => sprintf( esc_html__( 'Logo for the WoonderShop theme.', 'woondershop-pt' ) , '<i>', '</i>' ),
			'priority'    => 10,
			'panel'       => 'woondershop_panel_header',
		) );
		// 02. Header panel -> 02.02. Top Bar
		$this->wp_customize->add_section( 'woondershop_section_top_bar', array(
			'title'       => esc_html__( 'Top Bar Area', 'woondershop-pt' ),
			'description' => sprintf( esc_html__( 'Settings for top bar area.', 'woondershop-pt' ) , '<i>', '</i>' ),
			'priority'    => 20,
			'panel'       => 'woondershop_panel_header',
		) );
		// 02. Header panel -> 02.03. Header Widgets
		$this->wp_customize->add_section( 'woondershop_section_header_widgets', array(
			'title'       => esc_html__( 'Header Widgets Area', 'woondershop-pt' ),
			'description' => sprintf( esc_html__( 'Settings for header widgets area.', 'woondershop-pt' ) , '<i>', '</i>' ),
			'priority'    => 30,
			'panel'       => 'woondershop_panel_header',
		) );
		// 02. Header panel -> 02.04. Navigation
		$this->wp_customize->add_section( 'woondershop_section_navigation', array(
			'title'       => esc_html__( 'Navigation', 'woondershop-pt' ),
			'description' => esc_html__( 'Navigation for the WoonderShop theme.', 'woondershop-pt' ),
			'priority'    => 40,
			'panel'       => 'woondershop_panel_header',
		) );
		// 02. Header panel -> 02.05. Page Title
		$this->wp_customize->add_section( 'woondershop_section_page_title', array(
			'title'       => esc_html__( 'Page Title Area and Breadcrumbs', 'woondershop-pt' ),
			'description' => esc_html__( 'Settings for page title area.', 'woondershop-pt' ),
			'priority'    => 50,
			'panel'       => 'woondershop_panel_header',
		) );
		// 02. Header panel -> 02.06. Benefit bar
		$this->wp_customize->add_section( 'woondershop_section_benefit_bar', array(
			'title'           => esc_html__( 'Benefit Bar Area', 'woondershop-pt' ),
			'description'     => esc_html__( 'Settings for benefit bar area.', 'woondershop-pt' ),
			'priority'        => 60,
			'panel'           => 'woondershop_panel_header',
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
			},
		) );
		// 02. Header panel -> 02.07. Sticky header
		$this->wp_customize->add_section( 'woondershop_section_sticky_header', array(
			'title'       => esc_html__( 'Sticky Header', 'woondershop-pt' ),
			'description' => esc_html__( 'Settings for sticky header on mobile and desktop.', 'woondershop-pt' ),
			'priority'    => 70,
			'panel'       => 'woondershop_panel_header',
		) );
		// 02. Header panel -> 02.08. Mobile header
		$this->wp_customize->add_section( 'woondershop_section_mobile_header', array(
			'title'       => esc_html__( 'Mobile Header', 'woondershop-pt' ),
			'description' => esc_html__( 'Settings for mobile header.', 'woondershop-pt' ),
			'priority'    => 80,
			'panel'       => 'woondershop_panel_header',
		) );
		// 02. Header panel -> 02.09. Background color
		$this->wp_customize->add_section( 'woondershop_section_header_background_color', array(
			'title'       => esc_html__( 'Background Color', 'woondershop-pt' ),
			'description' => esc_html__( 'Change heeader background color.', 'woondershop-pt' ),
			'priority'    => 90,
			'panel'       => 'woondershop_panel_header',
		) );

		// Show only if WooCommerce is active
		if ( WoonderShopHelpers::is_woocommerce_active() ) {
			// 03. Shop -> 03.01. Product Catalog
			$this->wp_customize->add_section( 'woocommerce_product_catalog', array(
				'title'       => esc_html__( 'Product Catalog', 'woondershop-pt' ),
				'priority'    => 10,
				'panel'       => 'woocommerce',
			) );
			// 03. Shop -> 03.02. Product Page
			$this->wp_customize->add_section( 'woocommerce_product_page', array(
				'title'       => esc_html__( 'Product Page', 'woondershop-pt' ),
				'priority'    => 20,
				'panel'       => 'woocommerce',
			) );
			// 03. Shop -> 03.03. Product Images
			$this->wp_customize->add_section( 'woocommerce_product_images', array(
				'title'       => esc_html__( 'Product Images', 'woondershop-pt' ),
				'priority'    => 30,
				'panel'       => 'woocommerce',
			) );
			// 03. Shop -> 03.04. Checkout Page
			$this->wp_customize->add_section( 'woocommerce_checkout_page', array(
				'title'       => esc_html__( 'Checkout Page', 'woondershop-pt' ),
				'priority'    => 40,
				'panel'       => 'woocommerce',
			) );
			// 03. Shop -> 03.05. Store Notice
			$this->wp_customize->add_section( 'woocommerce_store_notice', array(
				'title'       => esc_html__( 'Store Notice', 'woondershop-pt' ),
				'priority'    => 50,
				'panel'       => 'woocommerce',
			) );
		}

		// 04. Footer -> 04.01. Footer Benefit Bar
		$this->wp_customize->add_section( 'woondershop_section_footer_benefit_bar', array(
			'title'       => esc_html__( 'Footer Benefit Bar', 'woondershop-pt' ),
			'priority'    => 10,
			'panel'       => 'woondershop_panel_footer',
		) );
		// 04. Footer -> 04.02. Footer Back to Top
		$this->wp_customize->add_section( 'woondershop_section_footer_back_to_top', array(
			'title'       => esc_html__( 'Back to Top', 'woondershop-pt' ),
			'priority'    => 20,
			'panel'       => 'woondershop_panel_footer',
		) );
		// 04. Footer -> 04.03. Footer Layout
		$this->wp_customize->add_section( 'woondershop_section_footer_layout', array(
			'title'       => esc_html__( 'Layout', 'woondershop-pt' ),
			'priority'    => 30,
			'panel'       => 'woondershop_panel_footer',
		) );
		// 04. Footer -> 04.04. Footer Bottom Bar Content
		$this->wp_customize->add_section( 'woondershop_section_footer_content', array(
			'title'       => esc_html__( 'Bottom Bar Content', 'woondershop-pt' ),
			'priority'    => 40,
			'panel'       => 'woondershop_panel_footer',
		) );
		// 04. Footer -> 04.05. Footer Colors
		$this->wp_customize->add_section( 'woondershop_section_footer_colors', array(
			'title'       => esc_html__( 'Colors', 'woondershop-pt' ),
			'priority'    => 50,
			'panel'       => 'woondershop_panel_footer',
		) );

		// 05. Blog -> 05.01. Layout
		$this->wp_customize->add_section( 'woondershop_section_blog_layout', array(
			'title'       => esc_html__( 'Layout', 'woondershop-pt' ),
			'priority'    => 10,
			'panel'       => 'woondershop_panel_blog',
		) );
		// 05. Blog -> 05.02. Single Post
		$this->wp_customize->add_section( 'woondershop_section_single_post', array(
			'title'       => esc_html__( 'Single Post', 'woondershop-pt' ),
			'priority'    => 20,
			'panel'       => 'woondershop_panel_blog',
		) );
	}


	/**
	 * Partials for selective refresh
	 *
	 * @return void
	 */
	public function register_partials() {
		$this->wp_customize->selective_refresh->add_partial( 'dynamic_css', array(
			'selector' => 'head > #' . self::DYNAMIC_CSS_STYLE_TAG_ID,
			'settings' => array_keys( $this->dynamic_css ),
			'render_callback' => function() {
				return $this->dynamic_css_cache_manager->render_css();
			},
		) );
	}


	/**
	 * Controls
	 *
	 * @return void
	 */
	public function register_controls() {
		// 01. General panel -> 01.01. Global Colors -> Text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'text_color_content_area',
			array(
				'priority' => 10,
				'label'    => esc_html__( 'Text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Headings color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'headings_color',
			array(
				'priority' => 20,
				'label'    => esc_html__( 'Headings color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Primary color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'primary_color',
			array(
				'priority' => 30,
				'label'    => esc_html__( 'Primary color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Link color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'link_color',
			array(
				'priority' => 40,
				'label'    => esc_html__( 'Link color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Link hover color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'link_color_hover',
			array(
				'priority' => 41,
				'label'    => esc_html__( 'Link hover color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Separator_1
		$this->wp_customize->add_control( new WoonderShop_Separator_Custom_Control(
			$this->wp_customize,
			'separator_1',
			array(
				'priority' => 45,
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Primary button background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'primary_button_background_color',
			array(
				'priority' => 48,
				'label'    => esc_html__( 'Primary button background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'jungle' );
				},
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Secondary button background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'secondary_button_background_color',
			array(
				'priority' => 50,
				'label'    => esc_html__( 'Secondary button background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'default' );
				},
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Light button text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'light_button_color',
			array(
				'priority' => 60,
				'label'    => esc_html__( 'Light button color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Light button background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'light_button_background_color',
			array(
				'priority' => 70,
				'label'    => esc_html__( 'Light button background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Dark button background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'dark_button_background_color',
			array(
				'priority' => 80,
				'label'    => esc_html__( 'Dark button background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Separator_2
		$this->wp_customize->add_control( new WoonderShop_Separator_Custom_Control(
			$this->wp_customize,
			'separator_2',
			array(
				'priority' => 85,
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Primary custom icon color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'primary_custom_icon_color',
			array(
				'priority'    => 87,
				'label'       => esc_html__( 'Primary custom icon color', 'woondershop-pt' ),
				'description' => sprintf( esc_html__( 'The primary color for the %1$sWoonderShop custom icons%2$s.', 'woondershop-pt' ), '<a href="https://www.proteusthemes.com/help/woondershop-custom-icons/" target="_blank">', '</a>' ),
				'section'     => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Secondary custom icon color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'secondary_custom_icon_color',
			array(
				'priority'    => 88,
				'label'       => esc_html__( 'Secondary custom icon color', 'woondershop-pt' ),
				'description' => sprintf( esc_html__( 'The secondary color for the %1$sWoonderShop custom icons%2$s.', 'woondershop-pt' ), '<a href="https://www.proteusthemes.com/help/woondershop-custom-icons/" target="_blank">', '</a>' ),
				'section'     => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Separator_3
		$this->wp_customize->add_control( new WoonderShop_Separator_Custom_Control(
			$this->wp_customize,
			'separator_3',
			array(
				'priority' => 89,
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Slider title color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'slider_title_color',
			array(
				'priority' => 90,
				'label'    => esc_html__( 'Slider title color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Slider text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'slider_text_color',
			array(
				'priority' => 100,
				'label'    => esc_html__( 'Slider text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Separator_4
		$this->wp_customize->add_control( new WoonderShop_Separator_Custom_Control(
			$this->wp_customize,
			'separator_4',
			array(
				'priority' => 105,
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global colors -> Body background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'body_bg',
			array(
				'priority' => 110,
				'label'    => esc_html__( 'Body background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Body background image
		$this->wp_customize->add_control( new WP_Customize_Image_Control(
			$this->wp_customize,
			'body_bg_img',
			array(
				'priority' => 120,
				'label'    => esc_html__( 'Body background image', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
			)
		) );
		$this->wp_customize->add_control( 'body_bg_img_repeat', array(
			'priority'        => 130,
			'label'           => esc_html__( 'Body background repeat', 'woondershop-pt' ),
			'section'         => 'woondershop_section_theme_colors',
			'type'            => 'select',
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_not_empty( 'body_bg_img' );
			},
			'choices'         => array(
				'no-repeat' => esc_html__( 'No Repeat', 'woondershop-pt' ),
				'repeat'    => esc_html__( 'Tile', 'woondershop-pt' ),
				'repeat-x'  => esc_html__( 'Tile Horizontally', 'woondershop-pt' ),
				'repeat-y'  => esc_html__( 'Tile Vertically', 'woondershop-pt' ),
			),
		) );
		$this->wp_customize->add_control( new WP_Customize_Background_Position_Control( $this->wp_customize, 'body_bg_img_position', array(
			'priority' => 140,
			'label'    => esc_html__( 'Body background image position', 'woondershop-pt' ),
			'section'  => 'woondershop_section_theme_colors',
			'settings' => array(
				'x' => 'body_bg_img_position_x',
				'y' => 'body_bg_img_position_y',
			),
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_not_empty( 'body_bg_img' );
			},
		) ) );
		$this->wp_customize->add_control( 'body_bg_img_attachment', array(
			'priority'        => 150,
			'label'           => esc_html__( 'Body background attachment', 'woondershop-pt' ),
			'section'         => 'woondershop_section_theme_colors',
			'type'            => 'select',
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_not_empty( 'body_bg_img' );
			},
			'choices'         => array(
				'scroll' => esc_html__( 'Scroll', 'woondershop-pt' ),
				'fixed'  => esc_html__( 'Fixed (parallax effect)', 'woondershop-pt' ),
			),
		) );
		// 01. General panel -> 01.01. Global Colors -> Background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'background_color',
			array(
				'priority'    => 160,
				'label'       => esc_html__( 'Background color', 'woondershop-pt' ),
				'description' => esc_html__( 'This background color is only visible with boxed (General -> Layout) setting.', 'woondershop-pt' ),
				'section'     => 'woondershop_section_theme_colors',
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Background image, priority => 170
		$this->wp_customize->add_control( new WoonderShop_WP_Customize_Background_Image_Control( $this->wp_customize ) );
		// 01. General panel -> 01.01. Global Colors -> Background preset
		$this->wp_customize->add_control( 'background_preset', array(
			'type'     => 'select',
			'priority' => 180,
			'label'    => esc_html__( 'Preset', 'woondershop-pt' ),
			'section'  => 'woondershop_section_theme_colors',
			'choices' => array(
				'default' => esc_html__( 'Default', 'woondershop-pt' ),
				'fill'    => esc_html__( 'Fill Screen', 'woondershop-pt' ),
				'fit'     => esc_html__( 'Fit to Screen', 'woondershop-pt' ),
				'repeat'  => esc_html__( 'Repeat', 'woondershop-pt' ),
				'custom'  => esc_html__( 'Custom', 'woondershop-pt' ),
			),
		) );
		// 01. General panel -> 01.01. Global Colors -> Background position
		$this->wp_customize->add_control( new WP_Customize_Background_Position_Control(
			$this->wp_customize,
			'background_position',
			array(
				'priority' => 190,
				'label'    => esc_html__( 'Image Position', 'woondershop-pt' ),
				'section'  => 'woondershop_section_theme_colors',
				'settings' => array(
					'x' => 'background_position_x',
					'y' => 'background_position_y',
				),
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Background size
		$this->wp_customize->add_control( 'background_size', array(
			'type'     => 'select',
			'priority' => 200,
			'label'    => esc_html__( 'Image Size', 'woondershop-pt' ),
			'section'  => 'woondershop_section_theme_colors',
			'choices' => array(
				'auto'    => esc_html__( 'Original', 'woondershop-pt' ),
				'contain' => esc_html__( 'Fit to Screen', 'woondershop-pt' ),
				'cover'   => esc_html__( 'Fill Screen', 'woondershop-pt' ),
			),
		) );
		// 01. General panel -> 01.01. Global Colors -> Background repeat
		$this->wp_customize->add_control( 'background_repeat', array(
			'type'     => 'checkbox',
			'priority' => 210,
			'label'    => esc_html__( 'Repeat Background Image', 'woondershop-pt' ),
			'section'  => 'woondershop_section_theme_colors',
		) );
		// 01. General panel -> 01.01. Global Colors -> Background scroll with page
		$this->wp_customize->add_control( 'background_attachment', array(
			'type'     => 'checkbox',
			'priority' => 220,
			'label'    => esc_html__( 'Scroll with Page', 'woondershop-pt' ),
			'section'  => 'woondershop_section_theme_colors',
		) );

		// 01. General panel -> 01.02. Layout -> Choose layout
		$this->wp_customize->add_control( 'layout_mode', array(
			'type'     => 'select',
			'priority' => 10,
			'label'    => esc_html__( 'Choose layout', 'woondershop-pt' ),
			'section'  => 'woondershop_section_layout',
			'choices'  => array(
				'wide'  => esc_html__( 'Wide', 'woondershop-pt' ),
				'boxed' => esc_html__( 'Boxed', 'woondershop-pt' ),
			),
		) );

		// 01. General panel -> 01.05. Skins -> Choose skin
		$this->wp_customize->add_control(
			'ws_skin',
			array(
				'label' => esc_html__( 'Select skin', 'woondershop-pt' ),
				'section' => 'woondershop_section_ws_skins',
				'type' => 'select',
				'choices' => array(
					'default' => esc_html__( 'Default', 'woondershop-pt' ),
					'jungle' => esc_html__( 'Jungle (inspired by Amazon.com)', 'woondershop-pt' ),
				),
			)
		);

		// 02. Header panel -> 02.01. Logo -> Logo image
		$this->wp_customize->add_control( new WP_Customize_Image_Control(
			$this->wp_customize,
			'logo_img',
			array(
				'label'       => esc_html__( 'Logo Image', 'woondershop-pt' ),
				'description' => esc_html__( 'Max recommended height for the logo image is 95px.', 'woondershop-pt' ),
				'section'     => 'woondershop_section_logos',
			)
		) );
		// 02. Header panel -> 02.01. Logo -> Logo retina image
		$this->wp_customize->add_control( new WP_Customize_Image_Control(
			$this->wp_customize,
			'logo2x_img',
			array(
				'label'       => esc_html__( 'Retina Logo Image', 'woondershop-pt' ),
				'description' => esc_html__( '2x logo size, for screens with high DPI.', 'woondershop-pt' ),
				'section'     => 'woondershop_section_logos',
			)
		) );
		// 02. Header panel -> 02.01. Logo -> Logo padding top
		$this->wp_customize->add_control(
			'logo_padding_top',
			array(
				'type'    => 'number',
				'label'   => esc_html__( 'Logo Padding Top', 'woondershop-pt' ),
				'section' => 'woondershop_section_logos',
			)
		);
		// 02. Header panel -> 02.01. Logo -> Logo padding right
		$this->wp_customize->add_control(
			'logo_padding_right',
			array(
				'type'    => 'number',
				'label'   => esc_html__( 'Logo Padding Right', 'woondershop-pt' ),
				'section' => 'woondershop_section_logos',
			)
		);
		// 02. Header panel -> 02.01. Logo -> Logo padding bottom
		$this->wp_customize->add_control(
			'logo_padding_bottom',
			array(
				'type'    => 'number',
				'label'   => esc_html__( 'Logo Padding Bottom', 'woondershop-pt' ),
				'section' => 'woondershop_section_logos',
			)
		);
		// 02. Header panel -> 02.01. Logo -> Logo padding left
		$this->wp_customize->add_control(
			'logo_padding_left',
			array(
				'type'    => 'number',
				'label'   => esc_html__( 'Logo Padding Left', 'woondershop-pt' ),
				'section' => 'woondershop_section_logos',
			)
		);

		$sideabar_choices = array(
			'yes'         => esc_html__( 'Show', 'woondershop-pt' ),
			'no'          => esc_html__( 'Hide', 'woondershop-pt' ),
			'hide_mobile' => esc_html__( 'Hide on Mobile', 'woondershop-pt' ),
		);

		// 02. Header panel -> 02.02. Top Bar -> Left top bar visibility
		$this->wp_customize->add_control( 'top_left_bar_visibility', array(
			'type'        => 'select',
			'priority'    => 10,
			'label'       => esc_html__( 'Top Left bar visibility', 'woondershop-pt' ),
			'description' => esc_html__( 'Show or hide Top Left widgets area?', 'woondershop-pt' ),
			'section'     => 'woondershop_section_top_bar',
			'choices'     => $sideabar_choices,
		) );
		// 02. Header panel -> 02.02. Top Bar -> Left top bar only on home page
		$this->wp_customize->add_control( 'top_left_bar_only_on_homepage', array(
			'type'        => 'checkbox',
			'priority'    => 20,
			'label'       => esc_html__( 'Show Top Left bar only on home page', 'woondershop-pt' ),
			'section'     => 'woondershop_section_top_bar',
		) );
		// 02. Header panel -> 02.02. Top Bar -> Right top bar visibility
		$this->wp_customize->add_control( 'top_right_bar_visibility', array(
			'type'        => 'select',
			'priority'    => 30,
			'label'       => esc_html__( 'Top Right bar visibility', 'woondershop-pt' ),
			'description' => esc_html__( 'Show or hide Top Right widgets area?', 'woondershop-pt' ),
			'section'     => 'woondershop_section_top_bar',
			'choices'     => $sideabar_choices,
		) );
		// 02. Header panel -> 02.02. Top Bar -> Right top bar only on home page
		$this->wp_customize->add_control( 'top_right_bar_only_on_homepage', array(
			'type'        => 'checkbox',
			'priority'    => 40,
			'label'       => esc_html__( 'Show Top Right bar only on home page', 'woondershop-pt' ),
			'section'     => 'woondershop_section_top_bar',
		) );

		// 02. Header panel -> 02.03. Header Widgets -> Header widgets bar visibility
		$this->wp_customize->add_control( 'header_widget_area_visibility', array(
			'type'        => 'select',
			'priority'    => 10,
			'label'       => esc_html__( 'Header widget area visibility', 'woondershop-pt' ),
			'description' => esc_html__( 'Show or hide Header widget area?', 'woondershop-pt' ),
			'section'     => 'woondershop_section_header_widgets',
			'choices'     => $sideabar_choices,
		) );
		// 02. Header panel -> 02.03. Header Widgets -> Header widgets only on home page
		$this->wp_customize->add_control( 'header_widget_area_only_on_homepage', array(
			'type'        => 'checkbox',
			'priority'    => 20,
			'label'       => esc_html__( 'Show Header widget area only on home page', 'woondershop-pt' ),
			'section'     => 'woondershop_section_header_widgets',
		) );

		// 02. Header panel -> 02.04. Navigation -> Navigation featured dropdown background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'featured_dropdown_background_color',
			array(
				'priority' => 10,
				'label'    => esc_html__( 'Featured dropdown background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'default' );
				},
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_background_color',
			array(
				'priority' => 20,
				'label'    => esc_html__( 'Main navigation background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'default' );
				},
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_color',
			array(
				'priority' => 30,
				'label'    => esc_html__( 'Main navigation text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation text hover color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_color_hover',
			array(
				'priority' => 40,
				'label'    => esc_html__( 'Main navigation text hover color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation text current color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_color_current',
			array(
				'priority' => 50,
				'label'    => esc_html__( 'Main navigation current text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation submenu background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_bg',
			array(
				'priority' => 60,
				'label'    => esc_html__( 'Main navigation submenu background', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation submenu text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_color',
			array(
				'priority' => 70,
				'label'    => esc_html__( 'Main navigation submenu text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_color_hover',
			array(
				'priority' => 71,
				'label'    => esc_html__( 'Main navigation submenu text hover color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'jungle' );
				},
			)
		) );
		// 01. General panel -> 01.01. Global Colors -> Separator_5
		$this->wp_customize->add_control( new WoonderShop_Separator_Custom_Control(
			$this->wp_customize,
			'separator_5',
			array(
				'priority' => 75,
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation mobile background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_mobile_background',
			array(
				'priority' => 80,
				'label'    => esc_html__( 'Main navigation background color (mobile)', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation mobile text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_mobile_color',
			array(
				'priority' => 90,
				'label'    => esc_html__( 'Main navigation text color (mobile)', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation mobile text hover color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_mobile_color_hover',
			array(
				'priority' => 100,
				'label'    => esc_html__( 'Main navigation item hover background color (mobile)', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation mobile submenu background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_mobile_sub_bgcolor',
			array(
				'priority' => 110,
				'label'    => esc_html__( 'Main navigation submenu background color (mobile)', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation mobile submenu text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_mobile_sub_color',
			array(
				'priority' => 120,
				'label'    => esc_html__( 'Main navigation submenu text color (mobile)', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );
		// 02. Header panel -> 02.04. Navigation -> Navigation mobile submenu text hover color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_mobile_sub_color_hover',
			array(
				'priority' => 130,
				'label'    => esc_html__( 'Main navigation submenu item hover color (mobile)', 'woondershop-pt' ),
				'section'  => 'woondershop_section_navigation',
			)
		) );

		// 02. Header panel -> 02.05. Page Title -> Page title show or hide
		$is_header_visible = function () {
			return WpUtilsHelpers::is_theme_mod_specific_value( 'show_page_title_area', true );
		};
		$this->wp_customize->add_control( 'show_page_title_area', array(
			'type'        => 'checkbox',
			'priority'    => 10,
			'label'       => esc_html__( 'Show page title area', 'woondershop-pt' ),
			'description' => esc_html__( 'This will hide the page title area on all pages. You can also hide individual page headers in page settings. To remove breadcrumbs from all pages, please deactivate the Breadcrumb NavXT plugin.', 'woondershop-pt' ),
			'section'     => 'woondershop_section_page_title',
		) );
		// 02. Header panel -> 02.05. Page Title -> Page title background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'page_title_area_bg_color',
			array(
				'priority'        => 20,
				'label'           => esc_html__( 'Page title area background color', 'woondershop-pt' ),
				'section'         => 'woondershop_section_page_title',
				'active_callback' => function() {
					return WpUtilsHelpers::is_theme_mod_specific_value( 'show_page_title_area', true ) && WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
				},
			)
		) );
		// 02. Header panel -> 02.05. Page Title -> Page title background color opacity
		$this->wp_customize->add_control(
			'page_title_area_bg_color_opacity',
			array(
				'type'            => 'number',
				'priority'        => 30,
				'label'           => esc_html__( 'Page title area background color opacity', 'woondershop-pt' ),
				'description'     => esc_html__( 'Input the opacity percentage (0 - 100)', 'woondershop-pt' ),
				'section'         => 'woondershop_section_page_title',
				'input_attrs'     => array(
					'min' => 0,
					'max' => 100,
				),
				'active_callback' => function() {
					return WpUtilsHelpers::is_theme_mod_specific_value( 'show_page_title_area', true ) && WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
				},
			)
		);
		// 02. Header panel -> 02.05. Page Title -> Page title text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'page_header_color',
			array(
				'priority'        => 40,
				'label'           => esc_html__( 'Page title color', 'woondershop-pt' ),
				'section'         => 'woondershop_section_page_title',
				'active_callback' => $is_header_visible,
			)
		) );
		// 02. Header panel -> 02.05. Page Title -> Breadcrumbs text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'breadcrumbs_color',
			array(
				'priority'        => 50,
				'label'           => esc_html__( 'Breadcrumbs text color', 'woondershop-pt' ),
				'section'         => 'woondershop_section_page_title',
				'active_callback' => $is_header_visible,
			)
		) );

		// 02. Header panel -> 02.06. Benefit Bar -> Benefit bar visibility
		$this->wp_customize->add_control( 'benefit_bar_visibility', array(
			'type'        => 'select',
			'priority'    => 10,
			'label'       => esc_html__( 'Benefit bar visibility', 'woondershop-pt' ),
			'description' => esc_html__( 'Show or hide Benefit bar underneath the main menu?', 'woondershop-pt' ),
			'section'     => 'woondershop_section_benefit_bar',
			'choices'     => $sideabar_choices,
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
			},
		) );
		// 02. Header panel -> 02.06. Benefit Bar -> Benefit bar only on homepage
		$this->wp_customize->add_control( 'benefit_bar_only_on_homepage', array(
			'type'        => 'checkbox',
			'priority'    => 20,
			'label'       => esc_html__( 'Show Benefit bar only on home page', 'woondershop-pt' ),
			'section'     => 'woondershop_section_benefit_bar',
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
			},
		) );

		// 02. Header panel -> 02.07. Sticky Header -> Sticky header on desktop
		$this->wp_customize->add_control( 'sticky_desktop_header', array(
			'type'        => 'checkbox',
			'priority'    => 10,
			'label'       => esc_html__( 'Sticky header on desktop', 'woondershop-pt' ),
			'description' => esc_html__( 'Desktop header contains logo and header widget area.', 'woondershop-pt' ),
			'section'     => 'woondershop_section_sticky_header',
		) );
		// 02. Header panel -> 02.07. Sticky Header -> Sticky header on mobile
		$this->wp_customize->add_control( 'sticky_mobile_header', array(
			'type'        => 'checkbox',
			'priority'    => 20,
			'label'       => esc_html__( 'Sticky header on mobile', 'woondershop-pt' ),
			'description' => esc_html__( 'Mobile header contains essential eCommerce features (navigation, logo, search, cart) and it\'s highly recommended to turn this feature on for the best shopping experience.', 'woondershop-pt' ),
			'section'     => 'woondershop_section_sticky_header',
		) );

		// 02. Header panel -> 02.08. Mobile Header -> Show or hide mobile search in header
		$this->wp_customize->add_control( 'show_mobile_search_in_header', array(
			'type'        => 'checkbox',
			'priority'    => 10,
			'label'       => esc_html__( 'Show mobile search', 'woondershop-pt' ),
			'description' => esc_html__( 'Show or hide the mobile search in the header.', 'woondershop-pt' ),
			'section'     => 'woondershop_section_mobile_header',
		) );
		// 02. Header panel -> 02.08. Mobile Header -> Show or hide mobile cart in header
		$this->wp_customize->add_control( 'show_mobile_cart_in_header', array(
			'type'        => 'checkbox',
			'priority'    => 20,
			'label'       => esc_html__( 'Show mobile cart', 'woondershop-pt' ),
			'description' => esc_html__( 'Show or hide the mobile cart in the header.', 'woondershop-pt' ),
			'section'     => 'woondershop_section_mobile_header',
		) );

		// 02. Header panel -> 02.09. Background color -> Header background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'header_bg_color',
			array(
				'priority' => 10,
				'label'    => esc_html__( 'Background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_header_background_color',
			)
		) );

		// Show only if WooCommerce is active
		if ( WoonderShopHelpers::is_woocommerce_active() ) {
			// 03. Shop panel -> 03.01. Product Catalog -> Number of products per page
			$this->wp_customize->add_control( 'products_per_page', array(
					'priority' => 10,
					'label'    => esc_html__( 'Number of products per page', 'woondershop-pt' ),
					'section'  => 'woocommerce_product_catalog',
				)
			);
			// 03. Shop panel -> 03.01. Product Catalog -> Number of products per row
			$this->wp_customize->add_control( 'products_per_row', array(
					'label'    => esc_html__( 'Number of products per row', 'woondershop-pt' ),
					'section'  => 'woocommerce_product_catalog',
					'type'     => 'select',
					'choices'  => array(
						1 => '1',
						2 => '2',
						3 => '3',
						4 => '4',
						5 => '5',
						6 => '6',
					),
				)
			);
			// 03. Shop panel -> 03.01. Product Catalog -> Show or hide add to cart button
			$this->wp_customize->add_control( 'show_add_to_cart_button', array(
				'type'            => 'checkbox',
				'label'           => esc_html__( 'Show add to cart button?', 'woondershop-pt' ),
				'description'     => esc_html__( 'Show or hide the add to cart button on the shop pages (shop, categories, tags, ...).', 'woondershop-pt' ),
				'section'         => 'woocommerce_product_catalog',
				'active_callback' => function() {
					return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
				},
			) );
			// 03. Shop panel -> 03.01. Product Catalog -> Show, hide or on hover display the add to cart button
			$this->wp_customize->add_control( 'show_add_to_cart_button_dropdown', array(
				'type'        => 'select',
				'label'       => esc_html__( 'Add to cart button display options', 'woondershop-pt' ),
				'description' => esc_html__( 'Show, hide or show on hover the add to cart button on the shop pages (shop, categories, tags, ...).', 'woondershop-pt' ),
				'section'     => 'woocommerce_product_catalog',
				'choices'     => array(
					'show'  => esc_html__( 'Show', 'woondershop-pt' ),
					'hover' => esc_html__( 'Show on product hover', 'woondershop-pt' ),
					'hide'  => esc_html__( 'Hide', 'woondershop-pt' ),
				),
				'active_callback' => function() {
					return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'jungle' ) );
				},
			) );

			// 03. Shop panel -> 03.02. Product Page -> Product page sidebars
			$this->wp_customize->add_control( 'single_product_sidebar', array(
					'label'   => esc_html__( 'Sidebar on single product page', 'woondershop-pt' ),
					'section' => 'woocommerce_product_page',
					'type'    => 'select',
					'choices' => array(
						'none'  => esc_html__( 'No sidebar', 'woondershop-pt' ),
						'left'  => esc_html__( 'Left', 'woondershop-pt' ),
						'right' => esc_html__( 'Right', 'woondershop-pt' ),
					),
				)
			);
			// 03. Shop panel -> 03.02. Product Page -> Product page header area
			$this->wp_customize->add_control( 'single_product_show_header_area', array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Show single product header area?', 'woondershop-pt' ),
				'description' => esc_html__( 'Show or hide the single product header area (with shop title and breadcrumbs).', 'woondershop-pt' ),
				'section'     => 'woocommerce_product_page',
				'active_callback' => function() {
					return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
				},
			) );
			// 03. Shop panel -> 03.02. Product Page -> Product page title area
			$this->wp_customize->add_control( 'single_product_show_title', array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Show title in single product header area?', 'woondershop-pt' ),
				'description' => esc_html__( 'Show or hide the title in single product header area.', 'woondershop-pt' ),
				'section'     => 'woocommerce_product_page',
				'active_callback' => function() {
					return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'default' ) );
				},
			) );
			// 03. Shop panel -> 03.02. Product Page -> Product page breadcrumbs
			$this->wp_customize->add_control( 'single_product_show_breadcrumbs', array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Show breadcrumbs in single product header area?', 'woondershop-pt' ),
				'description' => esc_html__( 'Show or hide the breadcrumbs in single product header area.', 'woondershop-pt' ),
				'section'     => 'woocommerce_product_page',
			) );
			// 03. Shop panel -> 03.02. Product Page -> Product page meta
			$this->wp_customize->add_control( 'single_product_show_meta', array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Show product meta data on single product page?', 'woondershop-pt' ),
				'description' => esc_html__( 'Show or hide the product meta data (SKU, categories, tags,...) on single product page.', 'woondershop-pt' ),
				'section'     => 'woocommerce_product_page',
			) );

			// 03. Shop panel -> 03.04. Checkout Page -> Show or hide floating labels
			$this->wp_customize->add_control( 'checkout_floating_labels', array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Use floating labels on checkout?', 'woondershop-pt' ),
				'description' => esc_html__( 'Use floating labels for inputs on the checkout page. Using floating labels makes the checkout less cluttered and cleaner.', 'woondershop-pt' ),
				'section'     => 'woocommerce_checkout_page',
			) );
		}

		// 04. Footer -> 04.01. Footer benefit bar -> Show or hide benefit bar
		$this->wp_customize->add_control( 'footer_benefit_bar', array(
			'label'    => esc_html__( 'Benefit bar above footer', 'woondershop-pt' ),
			'priority' => 10,
			'section'  => 'woondershop_section_footer_benefit_bar',
			'type'     => 'select',
			'choices'  => array(
				'hide'  => esc_html__( 'Hide', 'woondershop-pt' ),
				'show'  => esc_html__( 'Show', 'woondershop-pt' ),
			),
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'jungle' ) );
			},
		) );

		// 04. Footer -> 04.02. Footer back to top -> Show or hide back to top
		$this->wp_customize->add_control( 'back_to_top', array(
			'label'    => esc_html__( 'Back to top button above footer', 'woondershop-pt' ),
			'priority' => 10,
			'section'  => 'woondershop_section_footer_back_to_top',
			'type'     => 'select',
			'choices'  => array(
				'hide'  => esc_html__( 'Hide', 'woondershop-pt' ),
				'show'  => esc_html__( 'Show', 'woondershop-pt' ),
			),
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'jungle' ) );
			},
		) );

		// 04. Footer -> 04.03. Footer Layout -> Widgets layout
		$this->wp_customize->add_control( new Control\LayoutBuilder(
			$this->wp_customize,
			'footer_widgets_layout',
			array(
				'priority'    => 10,
				'label'       => esc_html__( 'Footer widgets layout', 'woondershop-pt' ),
				'description' => esc_html__( 'Select number of widget you want in the footer and then with the slider rearrange the layout', 'woondershop-pt' ),
				'section'     => 'woondershop_section_footer_layout',
				'input_attrs' => array(
					'min'     => 0,
					'max'     => 12,
					'step'    => 1,
					'maxCols' => 6,
				),
			)
		) );

		// 04. Footer -> 04.04. Footer Bottom Bar Content -> Left bottom text
		$this->wp_customize->add_control( 'footer_bottom_left_txt', array(
			'type'        => 'text',
			'priority'    => 10,
			'label'       => esc_html__( 'Footer bottom left text', 'woondershop-pt' ),
			'section'     => 'woondershop_section_footer_content',
		) );
		// 04. Footer -> 04.04. Footer Bottom Bar Content -> Right bottom text
		$this->wp_customize->add_control( 'footer_bottom_right_txt', array(
			'type'        => 'text',
			'priority'    => 20,
			'label'       => esc_html__( 'Footer bottom right text', 'woondershop-pt' ),
			'section'     => 'woondershop_section_footer_content',
		) );
		// 04. Footer -> 04.04. Footer Bottom Bar Content -> Credits text
		$this->wp_customize->add_control( 'footer_credits_txt', array(
			'type'        => 'text',
			'priority'    => 30,
			'label'       => esc_html__( 'Footer credits text', 'woondershop-pt' ),
			'section'     => 'woondershop_section_footer_content',
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_in_array( 'ws_skin', array( 'jungle' ) );
			},
		) );

		// 04. Footer -> 04.05. Footer Colors -> Back to top button background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'back_to_top_bg_color',
			array(
				'label'    => esc_html__( 'Back to top button background color', 'woondershop-pt' ),
				'priority' => 5,
				'section'  => 'woondershop_section_footer_colors',
				'active_callback' => function() {
					return WpUtilsHelpers::is_theme_mod_specific_value( 'back_to_top', 'show' ) && WoonderShopHelpers::is_skin_active( 'jungle' );
				},
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bg_color',
			array(
				'priority' => 10,
				'label'    => esc_html__( 'Footer background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Title color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_title_color',
			array(
				'priority' => 20,
				'label'    => esc_html__( 'Footer widget title color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_text_color',
			array(
				'priority' => 30,
				'label'    => esc_html__( 'Footer text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Link color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_link_color',
			array(
				'priority' => 40,
				'label'    => esc_html__( 'Footer link color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Bottom background color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bottom_background_color',
			array(
				'priority' => 50,
				'label'    => esc_html__( 'Footer bottom background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'default' );
				},
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Bottom text color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bottom_text_color',
			array(
				'priority' => 60,
				'label'    => esc_html__( 'Footer bottom text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'default' );
				},
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Bottom link color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bottom_link_color',
			array(
				'priority' => 70,
				'label'    => esc_html__( 'Footer bottom link color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'default' );
				},
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Credits bg color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_credits_bg_color',
			array(
				'priority' => 80,
				'label'    => esc_html__( 'Footer credits background color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'jungle' );
				},
			)
		) );
		// 04. Footer -> 04.05. Footer Colors -> Credits text/link color
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_credits_text_color',
			array(
				'priority' => 90,
				'label'    => esc_html__( 'Footer credits text color', 'woondershop-pt' ),
				'section'  => 'woondershop_section_footer_colors',
				'active_callback' => function() {
					return WoonderShopHelpers::is_skin_active( 'jungle' );
				},
			)
		) );

		// 05. Blog -> 05.01. Layout -> Number of blog columns
		$this->wp_customize->add_control( 'blog_columns', array(
			'label'    => esc_html__( 'Number of blog columns', 'woondershop-pt' ),
			'priority' => 10,
			'section'  => 'woondershop_section_blog_layout',
			'type'     => 'select',
			'choices'  => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		) );
		// 05. Blog -> 05.01. Layout -> Blog sidebar settings
		$this->wp_customize->add_control( 'blog_sidebar', array(
			'label'    => esc_html__( 'Sidebar on the blog', 'woondershop-pt' ),
			'priority' => 20,
			'section'  => 'woondershop_section_blog_layout',
			'type'     => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'No sidebar', 'woondershop-pt' ),
				'left'  => esc_html__( 'Left', 'woondershop-pt' ),
				'right' => esc_html__( 'Right', 'woondershop-pt' ),
			),
		) );
		// 05. Blog -> 05.01. Layout -> Read more link for each article
		$this->wp_customize->add_control( 'article_more_link', array(
			'label'    => esc_html__( 'Read more link for each article.', 'woondershop-pt' ),
			'priority' => 30,
			'section'  => 'woondershop_section_blog_layout',
			'type'     => 'select',
			'choices'  => array(
				'hide'  => esc_html__( 'Hide', 'woondershop-pt' ),
				'show'  => esc_html__( 'Show', 'woondershop-pt' ),
			),
		) );
		// 05. Blog -> 05.01. Layout -> Show or hide search box
		$this->wp_customize->add_control( 'blog_search_box', array(
			'label'    => esc_html__( 'Search Box at the top of the blog', 'woondershop-pt' ),
			'priority' => 40,
			'section'  => 'woondershop_section_blog_layout',
			'type'     => 'select',
			'choices'  => array(
				'hide'  => esc_html__( 'Hide', 'woondershop-pt' ),
				'show'  => esc_html__( 'Show', 'woondershop-pt' ),
			),
		) );
		// 05. Blog -> 05.01. Layout -> Show or hide category box
		$this->wp_customize->add_control( 'blog_category_box', array(
			'label'    => esc_html__( 'Category box at the top of the blog', 'woondershop-pt' ),
			'priority' => 50,
			'section'  => 'woondershop_section_blog_layout',
			'type'     => 'select',
			'choices'  => array(
				'hide'  => esc_html__( 'Hide', 'woondershop-pt' ),
				'show'  => esc_html__( 'Show', 'woondershop-pt' ),
			),
		) );
		// 05. Blog -> 05.02. Single Post -> Single post sidebar settings
		$this->wp_customize->add_control( 'single_post_sidebar', array(
			'label'    => esc_html__( 'Sidebar on the single post page', 'woondershop-pt' ),
			'priority' => 10,
			'section'  => 'woondershop_section_single_post',
			'type'     => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'No sidebar', 'woondershop-pt' ),
				'left'  => esc_html__( 'Left', 'woondershop-pt' ),
				'right' => esc_html__( 'Right', 'woondershop-pt' ),
			),
		) );
		// 05. Blog -> 05.02. Single Post -> Single post reading time
		$this->wp_customize->add_control( 'reading_time', array(
			'label'    => esc_html__( 'Single post reading time', 'woondershop-pt' ),
			'priority' => 20,
			'section'  => 'woondershop_section_single_post',
			'type'     => 'select',
			'choices'  => array(
				'hide'  => esc_html__( 'Hide', 'woondershop-pt' ),
				'show'  => esc_html__( 'Show', 'woondershop-pt' ),
			),
		) );

		// 08. Additional JavaScript -> Custom header javascript
		$this->wp_customize->add_control( 'custom_js_head', array(
			'type'        => 'textarea',
			'label'       => esc_html__( 'Custom JavaScript (head)', 'woondershop-pt' ),
			'description' => esc_html__( 'You have to include the &lt;script&gt;&lt;/script&gt; tags as well. Paste your Google Analytics tracking code here.', 'woondershop-pt' ),
			'section'       => 'woondershop_section_additional_javascript',
		) );
		// 08. Additional JavaScript -> Custom footer javascript
		$this->wp_customize->add_control( 'custom_js_footer', array(
			'type'        => 'textarea',
			'label'       => esc_html__( 'Custom JavaScript (footer)', 'woondershop-pt' ),
			'description' => esc_html__( 'You have to include the &lt;script&gt;&lt;/script&gt; tags as well.', 'woondershop-pt' ),
			'section'     => 'woondershop_section_additional_javascript',
		) );

		// 10. Other -> Show ACF admin panel
		$this->wp_customize->add_control( 'show_acf', array(
			'type'        => 'select',
			'label'       => esc_html__( 'Show ACF admin panel?', 'woondershop-pt' ),
			'description' => sprintf( esc_html__( 'If you want to use ACF and need the ACF admin panel set this to %1$sYes%2$s. Do not change if you do not know what you are doing.', 'woondershop-pt' ), '<strong>', '</strong>' ),
			'section'     => 'section_other',
			'choices'     => array(
				'no'  => esc_html__( 'No', 'woondershop-pt' ),
				'yes' => esc_html__( 'Yes', 'woondershop-pt' ),
			),
		) );
		// 10. Other -> Use minified CSS
		$this->wp_customize->add_control( 'use_minified_css', array(
			'type'    => 'select',
			'label'   => esc_html__( 'Use minified theme CSS (recommended)', 'woondershop-pt' ),
			'section' => 'section_other',
			'choices' => array(
				'no'  => esc_html__( 'No', 'woondershop-pt' ),
				'yes' => esc_html__( 'Yes', 'woondershop-pt' ),
			),
		) );
		// 10. Other -> Google fonts character set
		$this->wp_customize->add_control( 'charset_setting', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Character set for Google Fonts', 'woondershop-pt' ),
			'section'  => 'section_other',
			'choices'  => array(
				'latin'        => 'Latin',
				'latin-ext'    => 'Latin Extended',
				'cyrillic'     => 'Cyrillic',
				'cyrillic-ext' => 'Cyrillic Extended',
				'vietnamese'   => 'Vietnamese',
				'greek'        => 'Greek',
				'greek-ext'    => 'Greek Extended',
			),
		) );
	}
}
