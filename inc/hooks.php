<?php
/**
 * WordPress hooks (filters and actions) for WoonderShop WP theme
 *
 * @package woondershop-pt
 */

/**
 * WoonderShopHooks class with WP hooks.
 */
class WoonderShopHooks {

	/**
	 * Runs on class initialization. Adds filters and actions.
	 */
	function __construct() {

		// ProteusWidgets.
		add_filter( 'pw/widget_views_path', array( $this, 'set_widgets_view_path' ) );
		add_filter( 'pw/featured_page_widget_page_box_image_size', array( $this, 'set_page_box_image_size' ) );
		add_filter( 'pw/featured_page_widget_inline_image_size', array( $this, 'set_inline_image_size' ) );
		add_filter( 'pw/latest_news_widget_image_size', array( $this, 'set_latest_news_image_size' ) );
		add_filter( 'pw/featured_page_excerpt_lengths', array( $this, 'set_featured_page_excerpt_lengths' ) );
		add_filter( 'pw/social_icons_fa_icons_list', array( $this, 'social_icons_fa_icons_list' ) );
		add_filter( 'pw/featured_page_fields', array( $this, 'set_featured_page_fields' ) );
		add_filter( 'pw/latest_news_texts', array( $this, 'set_latest_news_texts' ) );
		add_filter( 'pw/latest_news_fields', array( $this, 'set_latest_news_fields' ) );
		add_filter( 'pw/number_counter_widget', array( $this, 'set_number_counter_widget_settings' ) );
		add_filter( 'pw/testimonial_widget', array( $this, 'set_testimonial_widget_settings' ) );

		// Custom tag font size.
		add_filter( 'widget_tag_cloud_args', array( $this, 'set_tag_cloud_sizes' ) );

		// Custom text after excerpt.
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

		// Footer widgets with dynamic layouts.
		add_filter( 'dynamic_sidebar_params', array( $this, 'footer_widgets_params' ), 9, 1 );

		// Google fonts.
		add_filter( 'woondershop_pre_google_web_fonts', array( $this, 'additional_fonts' ) );
		add_filter( 'woondershop_subsets_google_web_fonts', array( $this, 'subsets_google_web_fonts' ) );

		// Page builder.
		add_filter( 'siteorigin_panels_settings_defaults', array( $this, 'siteorigin_panels_settings_defaults' ) );
		add_filter( 'siteorigin_panels_widgets', array( $this, 'add_icons_to_page_builder_for_pw_widgets' ), 15 );
		add_filter( 'siteorigin_panels_widget_dialog_tabs', array( $this, 'siteorigin_panels_add_widgets_dialog_tabs' ), 15 );

		// Embeds.
		add_filter( 'embed_oembed_html', array( $this, 'embed_oembed_html' ), 10, 1 );
		add_filter( 'oembed_result', array( $this, 'oembed_result' ), 10, 3 );
		add_filter( 'oembed_fetch_url', array( $this, 'oembed_fetch_url' ), 10, 3 );

		// Protocols.
		add_filter( 'kses_allowed_protocols', array( $this, 'kses_allowed_protocols' ) );

		// <body> and post class
		add_filter( 'body_class', array( $this, 'body_class' ), 10, 1 );
		add_filter( 'post_class', array( $this, 'post_class' ), 10, 1 );

		// One Click Demo Import plugin.
		add_filter( 'pt-ocdi/import_files', array( $this, 'ocdi_import_files' ) );
		add_action( 'pt-ocdi/after_import', array( $this, 'ocdi_after_import_setup' ) );
		add_filter( 'pt-ocdi/message_after_file_fetching_error', array( $this, 'ocdi_message_after_file_fetching_error' ) );

		// Shortcodes plugin.
		add_filter( 'pt/convert_widget_text', '__return_true' );
		add_filter( 'pt-shortcodes/shortcode_settings', array( $this, 'shortcode_settings' ) );

		// Remove references to SiteOrigin Premium.
		add_filter( 'siteorigin_premium_upgrade_teaser', '__return_false' );

		// Special dropdown menu.
		add_filter( 'wp_nav_menu_objects', array( $this, 'add_images_to_special_submenu' ) );

		// PT Mailchimp widget.
		add_filter( 'pt-mcw/disable_frontend_styles', '__return_true' );

		// WooCommerce.
		if ( WoonderShopHelpers::is_woocommerce_active() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
			add_action( 'woocommerce_before_main_content', array( $this, 'theme_wrapper_start' ), 10 );
			add_action( 'woocommerce_after_main_content', array( $this, 'theme_wrapper_end' ), 10 );
			add_filter( 'loop_shop_per_page', array( $this, 'custom_number_of_products_per_page' ), 20 );
			add_filter( 'woocommerce_show_page_title', '__return_false' );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woocommerce_cart_widget_fragments' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'output_related_products_args' ), 10, 1 );
			add_filter( 'loop_shop_columns', array( $this, 'shop_loop_columns' ) );
			add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );
			add_action( 'woocommerce_after_main_content', array( $this, 'add_category_below_description' ), 7 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_checkout_floating_labels' ), 100 );
			add_filter( 'woocommerce_default_address_fields', array( $this, 'set_placeholders_for_floating_labels_on_checkout' ) );
			add_action( 'wp', array( $this, 'maybe_change_woocommerce_product_loop_image_template' ) );

			if ( class_exists( 'WPF_Utils' ) && ! WPF_Utils::is_ajax() ) {
				add_action( 'woocommerce_archive_description', array( $this, 'add_category_above_description' ), 15 );
			}

			// Remove single product meta data, if the setting is set in customizer.
			if ( ! get_theme_mod( 'single_product_show_meta', true ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}

			// Show/hide the 'add to cart' button on shop index pages.
			if (
				( WoonderShopHelpers::is_skin_active( array( 'default' ) ) && ! get_theme_mod( 'show_add_to_cart_button', false ) ) ||
				( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) && 'hide' === get_theme_mod( 'show_add_to_cart_button_dropdown', 'hover' ) )
			) {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			}

			if ( WoonderShopHelpers::is_skin_active( 'jungle' ) ) {
				add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_template_single_brand_text' ), 3 );

				// wrapper around reviews + stock indicator + share icons
				add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_template_before_single_rating' ), 9 );
				add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_template_after_single_rating' ), 11 );

				// remove price and show it lower for all but variable products
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
				add_action( 'woocommerce_before_single_product_summary', function () {
					global $product;

					if ( ! $product->is_type( 'variable' ) ) {
						add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 29 );
					}
				} );

				// wrapper around attributes, price, qty, add to cart. Also displays extra info
				add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_template_box_wrapper_start' ), 28 );
				add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_template_box_wrapper_end' ), 32 );

				// display custom fields in the WC product settings - for brand and extra info
				add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_custom_general_fields' ) );
				add_action( 'woocommerce_process_product_meta', array( $this, 'add_custom_general_fields_save' ) );

				add_action( 'woocommerce_variable_product_before_variations', array( $this, 'add_custom_select_for_image_variation_selector' ) );
				add_filter( 'woocommerce_available_variation', array( $this, 'add_custom_variable_to_woocommerce_available_variation' ), 10, 1 );

				// Force the price display for variable products with same price.
				add_filter( 'woocommerce_show_variation_price', array( $this, 'force_price_display_for_variable_products' ), 10, 3 );

				// Display 4 related products on the single product page.
				add_filter( 'woocommerce_output_related_products_args', array( $this, 'change_woocommerce_related_products_args' ) );

				// Change the layout of the WooCommerce single product review form.
				add_filter( 'woocommerce_product_review_comment_form_args', array( $this, 'change_woocommerce_product_review_comment_form_args' ) );

				// Change the location of the page header on the WooCommerce account page.
				add_action( 'wp', array( $this, 'change_location_of_the_page_header_on_woocommerce_account_page' ) );
			} else { // default
				// change order of the rating
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 3 );
			}
		}

		// Customize the menu output.
		add_filter( 'wp_nav_menu_objects', array( $this, 'modify_wp_nav_menu_objects' ), 10, 2 );

		// Smart WooCommerce Search plugin.
		remove_filter( 'admin_footer_text', 'ysm_change_admin_footer_text', 1 );
		add_filter( 'smart_search_suggestions_image_attributes', array( $this, 'smart_search_suggestions_image_attributes' ) );

		// Instagram widget - AJAX actions.
		add_action( 'wp_ajax_pt_woondershop_get_instagram_data', array( $this, 'pt_woondershop_get_instagram_data' ) );
		add_action( 'wp_ajax_nopriv_pt_woondershop_get_instagram_data', array( $this, 'pt_woondershop_get_instagram_data' ) );

		// MerlinWP.
		add_filter( 'merlin_generate_child_functions_php', array( $this, 'merlin_generate_child_functions_php' ), 10, 2 );
		add_filter( 'merlin_import_files', array( $this, 'ocdi_import_files' ) );
		add_action( 'merlin_after_all_import', array( $this, 'ocdi_after_import_setup' ) );

		// WooCommerce product filter plugin.
		add_action( 'activate_themify-wc-product-filter/themify-wc-product-filter.php', array( $this, 'disable_wc_product_filter_redirect_after_activation' ), 15 );
		remove_action( 'admin_notices', 'wpf_admin_notice' ); // Fixes the MerlinWP plugin install/activation.

		// ACF PRO.
		add_filter( 'acf/location/rule_types', array( $this, 'add_acf_location_rules_types' ) );
		add_filter( 'acf/location/rule_values/ws_skin', array( $this, 'add_acf_location_rules_values_theme_skin' ) );
		add_filter( 'acf/location/rule_match/ws_skin', array( $this, 'add_acf_location_rules_match_theme_skin' ), 10, 3 );

		if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) {
			// Reposition the admin WC notices, to the top of the shop page (above title).
			remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
			add_action( 'woocommerce_before_main_content', 'wc_print_notices', 20 );

			// Enable the default WooCommerce title.
			add_filter( 'woocommerce_show_page_title', '__return_true' );

			// Reposition the ACF above description output.
			if ( class_exists( 'WPF_Utils' ) && ! WPF_Utils::is_ajax() ) {
				remove_action( 'woocommerce_archive_description', array( $this, 'add_category_above_description' ), 15 );
				add_action( 'woocommerce_before_shop_loop', array( $this, 'add_category_above_description' ), 50 );
			}

			// Add custom div elements around the WooCommerce header
			add_action( 'woocommerce_before_main_content', array( $this, 'open_woocommerce_archive_page_title_div' ), 300 );
			add_action( 'woocommerce_before_shop_loop', array( $this, 'close_woocommerce_acrhive_page_div' ), 40 );
			add_action( 'woocommerce_before_main_content', array( $this, 'open_woocommerce_archive_page_title_and_count_div' ), 400 );
			add_action( 'woocommerce_before_shop_loop', array( $this, 'close_woocommerce_acrhive_page_div' ), 25 );

			// Reposition the WooCommerce archive descriptions.
			if ( class_exists( 'WPF_Utils' ) && ! WPF_Utils::is_ajax() ) {
				remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
				remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
				add_action( 'woocommerce_before_shop_loop', 'woocommerce_taxonomy_archive_description', 50 );
				add_action( 'woocommerce_before_shop_loop', 'woocommerce_product_archive_description', 50 );
			}
		}

		// Theme registration.
		add_action( 'pt-tr/disable_customizer_theme_options', array( $this, 'disable_customizer_theme_options' ) );
		add_filter( 'pt-tr/pt_customizer_support_section_priority', array( $this, 'pt_customizer_support_section_priority' ) );
	}


	/**
	 * Custom tag font size.
	 *
	 * @param array $args default arguments.
	 * @return array
	 */
	function set_tag_cloud_sizes( $args ) {
		$args['smallest'] = 12;
		$args['largest']  = 12;
		$args['unit'] = 'px';
		return $args;
	}


	/**
	 * Custom text after excerpt.
	 *
	 * @param array $more default more value.
	 * @return array
	 */
	function excerpt_more( $more ) {
		return ' &hellip;';
	}


	/**
	 * Filter the dynamic sidebars and alter the BS col classes for the footer widgets.
	 *
	 * @param  array $params parameters of the sidebar.
	 * @return array
	 */
	function footer_widgets_params( $params ) {
		static $counter              = 0;
		static $first_row            = true;
		$footer_widgets_layout_array = WoonderShopHelpers::footer_widgets_layout_array();

		if ( 'footer-widgets' === $params[0]['id'] ) {
			// 'before_widget' contains __col-num__, see inc/theme-sidebars.php.
			$params[0]['before_widget'] = str_replace( '__col-num__', $footer_widgets_layout_array[ $counter ], $params[0]['before_widget'] );

			// First widget in the any non-first row.
			if ( false === $first_row && 0 === $counter ) {
				$params[0]['before_widget'] = '</div><div class="row">' . $params[0]['before_widget'];
			}

			$counter++;
		}

		end( $footer_widgets_layout_array );
		if ( $counter > key( $footer_widgets_layout_array ) ) {
			$counter   = 0;
			$first_row = false;
		}

		return $params;
	}


	/**
	 * Filter setting ProteusWidgets mustache widget views path for WoonderShop.
	 */
	function set_widgets_view_path() {
		return get_template_directory() . '/inc/widgets-views';
	}


	/**
	 * Filter the Featured page widget pw-page-box image size for WoonderShop (ProteusWidgets).
	 *
	 * @param array $image default image parameters.
	 * @return array
	 */
	function set_page_box_image_size( $image ) {
		$image['width']  = 350;
		$image['height'] = 175;
		return $image;
	}


	/**
	 * Filter the pw-latest-news image size for WoonderShop (ProteusWidgets).
	 *
	 * @param array $image default image parameters.
	 * @return array
	 */
	function set_latest_news_image_size( $image ) {
		$image['width']  = 350;
		$image['height'] = 175;
		return $image;
	}


	/**
	 * Filter the Featured page widget pw-inline image size for WoonderShop (ProteusWidgets).
	 *
	 * @param array $image default image parameters.
	 * @return array
	 */
	function set_inline_image_size( $image ) {
		$image['width']  = 100;
		$image['height'] = 70;
		return $image;
	}

	/**
	 * Filter the Featured page widget excerpt lengths for WoonderShop (ProteusWidgets).
	 *
	 * @param array $excerpt_lengths default excerpt lengths.
	 * @return array
	 */
	function set_featured_page_excerpt_lengths( $excerpt_lengths ) {
		$excerpt_lengths['inline_excerpt'] = 55;
		$excerpt_lengths['block_excerpt']  = 140;
		return $excerpt_lengths;
	}

	/**
	 * Set Latest News widget texts for WoonderShop (ProteusWidgets).
	 *
	 * @param array $defaults default Latest news widget texts.
	 * @return array
	 */
	function set_latest_news_texts( $defaults ) {
		$defaults['read_more'] = 'Read more';
		return $defaults;
	}


	/**
	 * Filter for the list of Font-Awesome icons in social icons widget in WoonderShop (ProteusWidgets).
	 */
	function social_icons_fa_icons_list() {
		return array(
			'fab fa-facebook',
			'fab fa-twitter',
			'fab fa-youtube',
			'fab fa-google-plus',
			'fab fa-pinterest',
			'fab fa-tumblr',
			'fab fa-xing',
			'fab fa-vimeo',
			'fab fa-linkedin',
			'fab fa-facebook-square',
			'fab fa-twitter-square',
			'fab fa-youtube-square',
			'fab fa-google-plus-square',
			'fab fa-pinterest-square',
			'fab fa-tumblr-square',
			'fab fa-xing-square',
			'fab fa-vimeo-square',
			'fab fa-linkedin-square',
		);
	}

	/**
	 * Return Google fonts and sizes.
	 *
	 * @see https://github.com/grappler/wp-standard-handles/blob/master/functions.php
	 * @param array $fonts google fonts used in the theme.
	 * @return array Google fonts and sizes.
	 */
	function additional_fonts( $fonts ) {
		$fonts = array();
		$skin = WoonderShopHelpers::get_skin();

		switch ( $skin ) {
			case 'jungle':
				$fonts['Lato'] = array(
					'400' => '400',
					'700' => '700',
				);
				break;

			default:
				$fonts['Roboto'] = array(
					'400' => '400',
					'700' => '700',
				);
				$fonts['Poppins'] = array(
					'700' => '700',
				);
				break;
		}

		return $fonts;
	}


	/**
	 * Add subsets from customizer, if needed.
	 *
	 * @param array $subsets google font subsets used in the theme.
	 * @return array
	 */
	function subsets_google_web_fonts( $subsets ) {
		$additional_subset = get_theme_mod( 'charset_setting', 'latin' );

		array_push( $subsets, $additional_subset );

		return $subsets;
	}


	/**
	 * Embedded videos and video container around them.
	 *
	 * @param string $html html to be enclosed with responsive HTML.
	 * @return string
	 */
	function embed_oembed_html( $html ) {
		if (
			false !== strstr( $html, 'youtube.com' ) ||
			false !== strstr( $html, 'wordpress.tv' ) ||
			false !== strstr( $html, 'wordpress.com' ) ||
			false !== strstr( $html, 'vimeo.com' )
		) {

			// Remove the frameborder="0" attribute.
			$html = str_replace( ' frameborder="0"', '', $html );

			$out = '<div class="embed-responsive  embed-responsive-16by9">' . $html . '</div>';
		} else {
			$out = $html;
		}
		return $out;
	}


	/**
	 * Add more allowed protocols.
	 *
	 * @param array $protocols default protocols.
	 * @return array
	 * @link https://developer.wordpress.org/reference/functions/wp_allowed_protocols/
	 */
	static function kses_allowed_protocols( $protocols ) {
		return array_merge( $protocols, array( 'skype' ) );
	}


	/**
	 * Append the right body classes to the <body>.
	 *
	 * @param  array $classes The default array of classes.
	 * @return array
	 */
	public static function body_class( $classes ) {
		$classes[] = sprintf( 'woondershop-%s', sanitize_html_class( WoonderShopHelpers::get_skin() ) );
		$classes[] = 'woondershop-loading-site';

		if ( 'boxed' === get_theme_mod( 'layout_mode', 'wide' ) ) {
			$classes[] = 'boxed';
		}

		if ( WoonderShopHelpers::is_woocommerce_active() ) {
			$classes[] = 'woocommerce-active';

			// Removes the confusing body.woocommerce so it is easier and more reliable to target the elements within WooCommerce implementation.
			if ( is_shop() ) {
				$classes[] = 'woocommerce-shop-page';
			}

			if ( is_checkout() && get_theme_mod( 'checkout_floating_labels', true ) ) {
				$classes[] = 'js-ws-floating-labels';
				$classes[] = 'woondershop-has-floating-labels';
			}
		}

		if ( 'yes' === get_theme_mod( 'header_widget_area_visibility', 'hide_mobile' ) && ( get_theme_mod( 'header_widget_area_only_on_homepage', false ) ? is_front_page() : true ) ) {
			$classes[] = 'woondershop-has-header-widgets-on-mobile';
		}

		$classes[] = sprintf( 'woondershop-%s-mobile-sticky-header', ( true === get_theme_mod( 'sticky_mobile_header', true ) ) ? 'has' : 'has-no' );
		$classes[] = sprintf( 'woondershop-%s-mobile-header-elements', ( true === WoonderShopHelpers::has_page_any_additional_header_elements_shown_on_mobile() ) ? 'has' : 'has-no' );
		$classes[] = sprintf( 'woondershop-%s-desktop-sticky-header', ( true === get_theme_mod( 'sticky_desktop_header', true ) ) ? 'has' : 'has-no' );

		return $classes;
	}


	/**
	 * Append the right post classes.
	 *
	 * @param  array $classes The default array of classes.
	 * @return array
	 */
	public static function post_class( $classes ) {
		$classes[] = 'clearfix';
		$classes[] = 'article';

		// Remove the hentry class.
		$classes = array_diff( $classes , array( 'hentry' ) );

		// Add the columns class for blog and search pages.
		if ( is_home() || is_search() || is_archive() ) {
			$classes[] = sprintf( 'article--%s-columns', get_theme_mod( 'blog_columns', '3' ) );
			$classes[] = 'h-entry';
		}

		// Add the class 'product--with-button-on-hover' on product li elements on WooCommerce archive
		// pages, when jungle skin is used and the customizer control is set to hover.
		if (
			WoonderShopHelpers::is_woocommerce_active() &&
			! is_product() &&
			WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) &&
			'hover' === get_theme_mod( 'show_add_to_cart_button_dropdown', 'hover' )
		) {
			$classes[] = 'product--with-button-on-hover';
		}

		return $classes;
	}


	/**
	 * Change the default settings for SO.
	 *
	 * @param  array $settings default Page Builder settings.
	 * @return array
	 */
	function siteorigin_panels_settings_defaults( $settings ) {
		$settings['title-html']           = '<h3 class="widget-title"><span class="widget-title__inline">{{title}}</span></h3>';
		$settings['full-width-container'] = '.boxed-container';
		$settings['mobile-width']         = '991';

		return $settings;
	}


	/**
	 * Set Featured Page widget fields (ProteusWidgets)
	 *
	 * @param array $fields default settings for Featured page widget.
	 * @return array
	 */
	function set_featured_page_fields( $fields ) {
		$fields['show_read_more_link'] = true;
		return $fields;
	}


	/**
	 * Define demo import files for One Click Demo Import plugin.
	 */
	function ocdi_import_files() {
		return array(
			array(
				'import_file_name'         => 'WoonderShop - default',
				'import_file_url'          => 'http://artifacts.proteusthemes.com/xml-exports/woondershop-latest.xml',
				'import_widget_file_url'   => 'http://artifacts.proteusthemes.com/json-widgets/woondershop.json',
				'import_preview_image_url' => 'http://artifacts.proteusthemes.com/import-preview-images/woondershop-default.png',
				'preview_url'              => 'https://demo.proteusthemes.com/woondershop/',
			),
			array(
				'import_file_name'           => 'WoonderShop - Jungle skin',
				'import_file_url'            => 'http://artifacts.proteusthemes.com/xml-exports/woondershop-jungle-latest.xml',
				'import_widget_file_url'     => 'http://artifacts.proteusthemes.com/json-widgets/woondershop-jungle.json',
				'import_customizer_file_url' => 'http://artifacts.proteusthemes.com/customizer-exports/woondershop-jungle.dat',
				'import_preview_image_url'   => 'http://artifacts.proteusthemes.com/import-preview-images/woondershop-jungle.png',
				'preview_url'                => 'https://demo.proteusthemes.com/woondershop-jungle/',
			),
		);
	}


	/**
	 * After import theme setup for One Click Demo Import plugin.
	 */
	function ocdi_after_import_setup( $selected_import ) {
		// Menus to Import and assign.
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

		set_theme_mod( 'nav_menu_locations', array(
			'main-menu'   => $main_menu->term_id,
		) );

		// Set options for front page and blog page.
		$front_page_id = get_page_by_title( 'Home' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );

		// Set options for Breadcrumbs NavXT.
		$breadcrumbs_settings                         = get_option( 'bcn_options', array() );
		$breadcrumbs_settings['hseparator']           = '';
		$breadcrumbs_settings['bcurrent_item_linked'] = true;
		$breadcrumbs_settings['bmainsite_display']    = false;
		update_option( 'bcn_options', $breadcrumbs_settings );

		// Set WooCommerce pages.
		$shop_page = get_page_by_title( 'Shop' );
		if ( $shop_page ) {
			update_option( 'woocommerce_shop_page_id', $shop_page->ID );
		}

		$cart_page = get_page_by_title( 'Cart' );
		if ( $cart_page ) {
			update_option( 'woocommerce_cart_page_id', $cart_page->ID );
		}

		$checkout_page = get_page_by_title( 'Checkout' );
		if ( $checkout_page ) {
			update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
		}

		$account_page = get_page_by_title( 'My account' );
		if ( $account_page ) {
			update_option( 'woocommerce_myaccount_page_id', $account_page->ID );
		}

		if (
			( ! empty( $selected_import['import_file_name'] ) && 'WoonderShop - default' === $selected_import['import_file_name'] ) ||
			( is_numeric( $selected_import ) && 0 === intval( $selected_import ) )
			) {
			// Set logo in customizer.
			set_theme_mod( 'logo_img', get_template_directory_uri() . '/assets/images/logo.png' );

			// Import the WooCommerce product filters shortcode.
			WoonderShopHelpers::import_wpf_settings( 'http://artifacts.proteusthemes.com/other-import-files/woondershop-wpf-filter-shop.json' );
		}
		else if (
			( ! empty( $selected_import['import_file_name'] ) && 'WoonderShop - Jungle skin' === $selected_import['import_file_name'] ) ||
			( is_numeric( $selected_import ) && 1 === intval( $selected_import ) )
		) {
			// Set logo in customizer.
			set_theme_mod( 'logo_img', get_template_directory_uri() . '/assets/images/logo-jungle.png' );

			// Import the WooCommerce product filters shortcode.
			WoonderShopHelpers::import_wpf_settings( 'http://artifacts.proteusthemes.com/other-import-files/woondershop-jungle-wpf-filter-shop.json' );
		}
	}


	/**
	 * Message for manual demo import for One Click Demo Import plugin.
	 */
	function ocdi_message_after_file_fetching_error() {
		return sprintf( esc_html__( 'Please try to manually import the demo data. Here are instructions on how to do that: %1$sDocumentation: Import XML File%2$s', 'woondershop-pt' ), '<a href="https://www.proteusthemes.com/docs/woondershop/#import-xml-file" target="_blank">', '</a>' );
	}


	/**
	 * Add arguments to oembed iframes.
	 *
	 * @param string $html the output.
	 * @param string $url the url used for the embed.
	 * @param array  $args arguments.
	 */
	function oembed_result( $html, $url, $args ) {

		// Modify youtube parameters.
		if ( strstr( $html, 'youtube.com/' ) ) {
			if ( isset( $args['player_id'] ) ) {
				$html = str_replace( '<iframe ', '<iframe id="' . $args['player_id'] . '"', $html );
			}
			if ( isset( $args['api'] ) ) {
				$html = str_replace( '?feature=oembed', '?feature=oembed&enablejsapi=1', $html );
			}
		}

		// Modify vimeo parameters.
		if ( strstr( $html, 'vimeo.com/' ) ) {
			if ( isset( $args['player_id'] ) ) {
				$html = str_replace( '<iframe ', '<iframe id="' . $args['player_id'] . '" ', $html );
			}
		}

		return $html;
	}


	/**
	 * Modify the oembed urls.
	 * Check the full list of args here: https://developer.vimeo.com/apis/oembed.
	 * You can find the list of defaults providers in WP_oEmbed::__construct().
	 *
	 * @param  string $provider URL of the oEmbed provider.
	 * @param  string $url      URL of the content to be embedded.
	 * @param  array  $args     Arguments, usually passed from a shortcode.
	 * @return string           Modified $provider.
	 */
	function oembed_fetch_url( $provider, $url, $args ) {
		if ( false !== strpos( $provider, 'vimeo.com' ) ) {
			if ( isset( $args['api'] ) ) {
				$provider = add_query_arg( 'api', absint( $args['api'] ), $provider );
			}
			if ( isset( $args['player_id'] ) ) {
				$provider = add_query_arg( 'player_id', esc_attr( $args['player_id'] ), $provider );
			}
		}

		return $provider;
	}


	/**
	 * Add PW widgets to Page Builder group and add icon class.
	 *
	 * @param array $widgets All widgets in page builder list of widgets.
	 *
	 * @return array
	 */
	function add_icons_to_page_builder_for_pw_widgets( $widgets ) {
		foreach ( $widgets as $class => $widget ) {
			if ( strstr( $widget['title'], 'ProteusThemes:' ) ) {
				$widgets[ $class ]['icon']   = 'pw-pb-widget-icon';
				$widgets[ $class ]['groups'] = array( 'pw-widgets' );
			}
		}

		return $widgets;
	}


	/**
	 * Add another tab section in the Page Builder "add new widget" dialog.
	 *
	 * @param array $tabs Existing tabs.
	 *
	 * @return array
	 */
	function siteorigin_panels_add_widgets_dialog_tabs( $tabs ) {
		$tabs['pw_widgets'] = array(
			'title' => esc_html__( 'ProteusThemes Widgets', 'woondershop-pt' ),
			'filter' => array(
				'groups' => array( 'pw-widgets' ),
			),
		);

		return $tabs;
	}

	/**
	 * Set the Latest news widget settings.
	 *
	 * @param array $defaults Array of the default widget settings.
	 * @return array          Modified settings.
	 */
	public function set_latest_news_fields( $defaults ) {
		$defaults['by_author']   = true;
		$defaults['by_category'] = true;

		return $defaults;
	}


	/**
	 * Add the images to the special submenu -> the submenu items with the parent with 'pt-special-dropdown' class.
	 *
	 * @param array $items List of menu objects (WP_Post).
	 * @param array $args  Array of menu settings.
	 * @return array
	 */
	public function add_images_to_special_submenu( $items ) {
		$special_menu_parent_ids = array();

		foreach ( $items as $item ) {
			if ( in_array( 'pt-special-dropdown', $item->classes, true ) && isset( $item->ID ) ) {
				$special_menu_parent_ids[] = $item->ID;
			}

			if ( in_array( $item->menu_item_parent, $special_menu_parent_ids ) && has_post_thumbnail( $item->object_id ) ) {
				$item->title = sprintf(
					'%1$s %2$s',
					get_the_post_thumbnail( $item->object_id, 'thumbnail', array( 'alt' => esc_attr( $item->title ) ) ),
					$item->title
				);
			}
		}

		return $items;
	}

	/**
	 * Set Number Counter widget settings (ProteusWidgets)
	 *
	 * @param array $defaults default Number Counter settings.
	 * @return array
	 */
	function set_number_counter_widget_settings( $defaults ) {
		$defaults['progress_bar'] = true;

		return $defaults;
	}


	/**
	 * Ensure WooCommerce cart contents update when products are added/removed to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX.
	 */
	public function woocommerce_cart_widget_fragments( $fragments ) {
		ob_start();
		WoonderShopHelpers::woocommerce_cart_subtotal_fragment();
		$fragments['div.shopping-cart__price'] = ob_get_clean();

		ob_start();
		WoonderShopHelpers::woocommerce_cart_empty_fragment();
		$fragments['div.shopping-cart__subtitle'] = ob_get_clean();

		ob_start();
		WoonderShopHelpers::woocommerce_cart_number_of_products_fragments();
		$fragments['span.woondershop-cart-quantity'] = ob_get_clean();

		ob_start();
		?>
			<div class="mobile-cart__subtotal">
				<?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?>
			</div>
		<?php
		$fragments['div.mobile-cart__subtotal'] = ob_get_clean();

		return $fragments;
	}


	/**
	 * Set the PT shortcodes plugin settings.
	 *
	 * @param array $settings The array of settings.
	 *
	 * @return array
	 */
	public function shortcode_settings( $settings ) {
		$settings['fa_version'] = 5;

		return $settings;
	}


	/**
	 * Modify the WP nav menu object, to include custom ACF fields for the menu in the "main-menu" location.
	 *
	 * @param array  $items Array of menu items (WP_Post).
	 * @param object $args  The object of menu settings.
	 *
	 * @return array
	 */
	public function modify_wp_nav_menu_objects( $items, $args ) {
		if ( 'main-menu' !== $args->theme_location ) {
			return $items;
		}

		foreach( $items as &$item ) {
			$icon  = get_field( 'menu_item_icon', $item );
			$label = get_field( 'menu_item_label', $item );

			if( ! empty( $icon ) ) {
				$old_title = $item->title;
				$item->title = '<i class="menu-item-icon ' . esc_attr( $icon ) . '"></i> ' . $old_title;
			}

			if( ! empty( $label ) ) {
				$item->title .= ' <span class="main-navigation__label">' . esc_html( $label ) . '</span>';
			}
		}

		return $items;
	}


	/**
	 * AJAX callback:
	 * Instagram widget. Get instagram data, from their API or from cache (WP transient).
	 */
	public function pt_woondershop_get_instagram_data() {
		// Check AJAX referer for a logged in user - cache issue fix for non logged in users.
		if ( is_user_logged_in() ) {
			check_ajax_referer( 'pt-woondershop-ajax-verification', 'security' );
		}

		$ajax_response = '';
		$access_token  = $_GET['access_token'];

		// Get instagram data from the instagram API, or from DB, if there is any cached data.
		$data = get_transient( 'pt_ws_inst_data-' . sanitize_key( substr( $access_token, -5 ) ) );
		if ( false === $data || '-1' === $data ) {
			// Get data from instagram API.
			$instagram_url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $access_token;
			$response      = wp_remote_get( $instagram_url );

			// Return with an error if something went wrong.
			if ( is_wp_error( $response ) ) {
				wp_send_json(
					array(
						'meta' => array(
							'code'          => $response->get_error_code(),
							'error_message' => $response->get_error_message(),
						),
					)
				);
			}

			$ajax_response = wp_remote_retrieve_body( $response );

			// Save the data to cache (WP transient).
			set_transient( 'pt_ws_inst_data-' . sanitize_key( substr( $access_token, -5 ) ), $ajax_response, 0.5 * HOUR_IN_SECONDS );
		}
		else {
			$ajax_response = $data;
		}

		// Send JSON back to the AJAX call in JS (instagram-widget.js).
		wp_send_json( $ajax_response );
	}


	/**
	 * MerlinWP: Custom content for the generated child theme's functions.php file.
	 *
	 * @param string $output Generated content.
	 * @param string $slug Parent theme slug.
	 */
	function merlin_generate_child_functions_php( $output, $slug ) {
		$output = "
		<?php
		/**
		 * Enqueue theme styles.
		 */
		function woondershop_child_enqueue_styles() {
		    wp_enqueue_style( 'woondershop-child-style',
		        get_stylesheet_directory_uri() . '/style.css',
		        array( 'woondershop-theme' ),
		        wp_get_theme()->get('Version')
		    );
		}
		add_action( 'wp_enqueue_scripts', 'woondershop_child_enqueue_styles', 17 );

	";

		// Let's remove the tabs so that it displays nicely.
		$output = trim( preg_replace( '/\t+/', '', $output ) );

		// Filterable return.
		return $output;
	}

	/**
	 * Disable the WC Product filter plugin redirect after activation.
	 */
	public function disable_wc_product_filter_redirect_after_activation() {
		delete_option( 'themify_WPF_activation_redirect' );
	}


	/**
	 * Change the smart search plugin suggestions image attributes.
	 * Note: the image size by default is 50px, but it can be changed
	 * in the plugin settings. So the default thumbnail size of 150px
	 * should be a good solution.
	 *
	 * @param array $attr The default attributes.
	 */
	public function smart_search_suggestions_image_attributes( $attr ) {
		$attr['sizes'] = '150px';

		return $attr;
	}


	/**
	 * Add the start html WooCommerce page wrapper. The default was removed via:
	 * remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	 */
	public function theme_wrapper_start() {
		$woondershop_sidebar = WoonderShopHelpers::get_shop_sidebar_position();
		?>

		<?php
		if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) {
			get_template_part( 'template-parts/page-header', WoonderShopHelpers::get_skin() );
		}
		?>

		<!-- Mobile sort and filter. Show only in shop, product categories and in product tags. -->
		<?php if ( is_shop() || is_product_category() || is_product_tag() ) : ?>
			<div class="mobile-sort-and-filter  d-lg-none">
				<button class="mobile-sort-and-filter__toggler  mobile-sort-and-filter__toggler--sort  js-mobile-sort-toggler">
					<i class="fas fa-sort-amount-down"></i> <?php esc_html_e( 'Sort' , 'woondershop-pt' ); ?>
				</button>
				<button class="mobile-sort__close  js-mobile-sort-close" type="button" aria-controls="woondershop-mobile-sort" aria-expanded="false" aria-label="<?php esc_html_e( 'Close sort' , 'woondershop-pt' ); ?>"><i class="fa  fa-times" aria-hidden="true"></i></button>
				<div class="mobile-sort">
					<div class="mobile-sort__header">
						<div class="mobile-sort__header-title">
							<?php esc_html_e( 'Sort by:' , 'woondershop-pt' ); ?>
						</div>
						<i class="fas fa-sort-amount-down"></i>
					</div>
					<?php WoonderShopHelpers::output_woocommerce_ordering_links(); ?>
				</div>
				<button class="mobile-sort-and-filter__toggler  mobile-sort-and-filter__toggler--filter  js-mobile-filter-toggler">
					<i class="fas fa-filter"></i> <?php esc_html_e( 'Filter' , 'woondershop-pt' ); ?>
				</button>
				<button class="mobile-filter__close  js-mobile-filter-close" type="button" aria-controls="woondershop-mobile-filter" aria-expanded="false" aria-label="<?php esc_html_e( 'Close filter' , 'woondershop-pt' ); ?>"><i class="fas  fa-check" aria-hidden="true"></i></button>
			</div>
		<?php endif ?>

		<div class="content-area  container">
			<div class="row">
				<main id="main" class="site-main  col-12<?php echo 'left' === $woondershop_sidebar ? '  site-main--left  col-lg-9  order-lg-2' : ''; ?><?php echo 'right' === $woondershop_sidebar ? '  site-main--right  col-lg-9  order-lg-1' : ''; ?>">
		<?php
	}


	/**
	 * Add the end html WooCommerce page wrapper. The default was removed via:
	 * remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	 */
	public function theme_wrapper_end() {
		$woondershop_sidebar = WoonderShopHelpers::get_shop_sidebar_position();
		?>
		</main>
		<?php if ( 'none' !== $woondershop_sidebar ) : ?>
			<div class="col-12  col-lg-3<?php echo 'left' === $woondershop_sidebar ? '  order-lg-1' : ''; ?><?php echo 'right' === $woondershop_sidebar ? '  order-lg-2' : ''; ?>">
				<div class="sidebar  sidebar--shop<?php echo 'right' === $woondershop_sidebar ? '  sidebar--right' : ''; ?><?php echo 'left' === $woondershop_sidebar ? '  sidebar--left' : ''; ?>" role="complementary">
					<?php
					if ( is_active_sidebar( 'shop-sidebar' ) ) {
						dynamic_sidebar( 'shop-sidebar' );
					}
					?>
				</div>
			</div>
		<?php endif ?>
			</div>
		</div>
		<?php
	}


	/**
	 * Display custom number of products per page in the WooCommerce shop.
	 */
	public function custom_number_of_products_per_page() {
		return absint( get_theme_mod( 'products_per_page', 9 ) );
	}


	/**
	 * Change number of related columns/products for single product page.
	 *
	 * @param  array $args
	 * @return array
	 */
	public function output_related_products_args( $args ) {
		$args['posts_per_page'] = 3;
		$args['columns']        = 3;

		return $args;
	}


	/**
	 * Change number or products per row in the WooCommerce shop page.
	 */
	public function shop_loop_columns() {
		return get_theme_mod( 'products_per_row', 3 );
	}


	/**
	 * Add the "description above" ACF field to the WooCommerce category pages.
	 */
	public function add_category_above_description() {
		WoonderShopHelpers::add_acf_category_description( 'above' );
	}


	/**
	 * Add the "description below" ACF field to the WooCommerce category pages.
	 */
	public function add_category_below_description() {
		WoonderShopHelpers::add_acf_category_description( 'below' );
	}


	/**
	 * Enqueue floating labels library for WooCommerce checkout page.
	 */
	public function enqueue_checkout_floating_labels() {
		if ( is_checkout() && get_theme_mod( 'checkout_floating_labels', true ) ) {
			wp_enqueue_script( 'woondershop-floating-labels', get_template_directory_uri() . '/node_modules/float-labels.js/dist/float-labels.min.js', array(), '3.3.3', true );
			wp_dequeue_style( 'selectWoo' );
			wp_dequeue_script( 'selectWoo' );
		}
	}

	/**
	 * Set missing placeholders and labels for floating labels on checkout.
	 */
	public function set_placeholders_for_floating_labels_on_checkout( $fields ) {
		if ( get_theme_mod( 'checkout_floating_labels', true ) ) {
			$fields['address_1']['placeholder'] = __( 'Street address', 'woondershop-pt' );
			$fields['address_2']['label']       = esc_attr__( 'Apartment, suite, unit etc. (optional)', 'woondershop-pt' );

			// Set missing placeholders.
			foreach ( $fields as $key => $value ) {
				if ( isset( $fields[ $key ]['label'] ) && ! isset( $fields[ $key ]['placeholder'] ) ) {
					$fields[ $key ]['placeholder'] = $fields[ $key ]['label'];
				}
			}
		}

		return $fields;
	}


	/**
	 * Add custom ACF PRO location rules types.
	 *
	 * @see https://www.advancedcustomfields.com/resources/custom-location-rules/
	 *
	 * @param array $choices The existing ACF choices for location rules types.
	 *
	 * @return array
	 */
	public function add_acf_location_rules_types( $choices ) {
		$choices['Options']['ws_skin'] = 'Theme Skin';

		return $choices;
	}


	/**
	 * Add custom ACF PRO location rules values for the theme option type.
	 *
	 * @see https://www.advancedcustomfields.com/resources/custom-location-rules/
	 *
	 * @param array $choices The existing ACF choices for theme option type.
	 *
	 * @return array
	 */
	public function add_acf_location_rules_values_theme_skin( $choices ) {
		$values = array(
			'default' => 'Default',
			'jungle'  => 'Jungle',
		);

		return array_merge( $values, $choices );
	}


	/**
	 * Return a boolean, whether the ACF field should be displayed on the edit screen or not.
	 *
	 * @see https://www.advancedcustomfields.com/resources/custom-location-rules/
	 *
	 * @param bool  $match   Default boolean value.
	 * @param array $rule    The data from the ACF location settings ( 'param', 'operator', 'value' )
	 * @param array $options The data from the current edit screen.
	 *
	 * @return bool
	 */
	public function add_acf_location_rules_match_theme_skin( $match, $rule, $options ) {
		$is_skin_active = WoonderShopHelpers::is_skin_active( $rule['value'] );

		if( '==' === $rule['operator'] ) {
			return $is_skin_active;
		}
		elseif( '!=' === $rule['operator'] ) {
			return ! $is_skin_active;
		}

		return $match;
	}


	/**
	 * Open the WC page title area container div on WooCommerce archive pages.
	 */
	public function open_woocommerce_archive_page_title_div() {
		if ( WoonderShopHelpers::is_woocommerce_active() && is_product() ) {
			return;
		}
		?>
		<div class="woocommerce-page-title-area">
		<?php
	}


	/**
	 * Enhance the theme registration process.
	 *
	 * @param object $wp_customize The WP_Customize instance.
	 */
	public function disable_customizer_theme_options( $wp_customize ) {
		$remove_panels = array(
			'woondershop_panel_general',
			'woondershop_panel_header',
			'woocommerce',
			'woondershop_panel_footer',
			'woondershop_panel_blog',
		);

		$remove_sections = array(
			'woondershop_section_additional_javascript',
			'section_other',
		);

		array_map( function( $panel_name ) use ( $wp_customize ) {
			$wp_customize->remove_panel( $panel_name );
		}, $remove_panels );

		array_map( function( $section_name ) use ( $wp_customize ) {
			$wp_customize->remove_section( $section_name );
		}, $remove_sections );
	}


	/**
	 * Output a closing div on WooCommerce archive pages.
	 */
	public function close_woocommerce_acrhive_page_div() {
		if ( WoonderShopHelpers::is_woocommerce_active() && is_product() ) {
			return;
		}
		?>
		</div>
		<?php
	}


	/**
	 * Change the priority of the PT Support section in customizer.
	 *
	 * @return int The value of the desired customizer priority.
	 */
	public function pt_customizer_support_section_priority() {
		return 500;
	}


	/**
	 * Open the WC page title and result count container div on WooCommerce archive pages.
	 */
	public function open_woocommerce_archive_page_title_and_count_div() {
		if ( WoonderShopHelpers::is_woocommerce_active() && is_product() ) {
			return;
		}
		?>
		<div class="woocommerce-page-title-and-count">
		<?php
	}


	/**
	 * Add custom text above the title
	 *
	 * @todo the text added should be dynamic
	 */
	public static function woocommerce_template_single_brand_text() {
		$brand = get_post_meta( get_the_ID(), '_woonder_brand_text', true );

		if ( ! empty( $brand ) ) :
		?>
		<div class="woocommerce-product-details__brand"><?php echo wp_kses_post( $brand ); ?></div>
		<?php
		endif;
	}


	/**
	 * Maybe change the output for product images in a loop on single product pages (example: "related products").
	 */
	public function maybe_change_woocommerce_product_loop_image_template(){
		if ( is_product() ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'change_woocommerce_template_loop_product_thumbnail' ), 10 );
		}
	}


	/**
	 * Wrapper around ratings + share buttons
	 *
	 * @todo buttons should share the specific product
	 */
	public static function woocommerce_template_before_single_rating() {
		?>
		<div class="woocommerce-product-details__status-row">
			<div class="woocommerce-product-details__share">
				<?php esc_html_e( 'Share', 'woondershop-pt' ); ?>:
				<a target="_blank" href="<?php echo esc_url( sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%s', rawurlencode( get_permalink() ) ) ); ?>" class="woocommerce-product-details__share-icon"><i class="fab fa-facebook-f"></i></a>
				<a target="_blank" href="<?php echo esc_url( sprintf( 'https://twitter.com/home?status=%s', rawurlencode( get_permalink() ) ) ); ?>" class="woocommerce-product-details__share-icon"><i class="fab fa-twitter"></i></a>
			</div>
		<?php
	}


	/**
	 * Wrapper around ratings + custom stock badge
	 */
	public static function woocommerce_template_after_single_rating() {
		global $product;

		$availability = $product->get_availability();

		?>
			<div class="woocommerce-product-details__stock">
				<span class="stock <?php echo esc_attr( $availability['class'] ); ?>"><?php echo 'in-stock' === $availability['class'] ? esc_html_e( 'In stock', 'woondershop-pt' ) : esc_html_e( 'Out of stock', 'woondershop-pt' ); ?></span>
			</div>
		</div>
		<?php
	}


	/**
	 * Start wrapper for box around add to cart
	 */
	public static function woocommerce_template_box_wrapper_start() {
		?>
		<div class="woocommerce-product-details__box">
		<?php
	}


	/**
	 * End wrapper for box around add to cart
	 */
	public static function woocommerce_template_box_wrapper_end() {
		$add_info = get_post_meta( get_the_ID(), '_woonder_additional_info_text', true );

		?>
		</div>
		<?php
		if ( ! empty( $add_info ) ) :
		?>
		<div class="woocommerce-product-details__extra-info"><?php echo wp_kses_post( $add_info ); ?></div>
		<?php
		endif;
	}


	/**
	 * Add custom fields to WC product settings
	 *
	 * @see http://www.remicorson.com/mastering-woocommerce-products-custom-fields/
	 */
	public static function add_custom_general_fields() {
		echo '<div class="options_group">';

		woocommerce_wp_text_input(
			array(
				'id' => '_woonder_brand_text',
				'label' => __( 'Brand text', 'woondershop-pt' ),
				'desc_tip' => true,
				'description' => __( 'Above the title. Accepts basic HTML.', 'woondershop-pt' )
			)
		);

		woocommerce_wp_text_input(
			array(
				'id' => '_woonder_additional_info_text',
				'label' => __( 'Additional info', 'woondershop-pt' ),
				'placeholder' => 'Free delivery. <a href="#">More</a>',
				'desc_tip' => true,
				'description' => __( 'Below the &quot;Add to cart&quot;. Accepts basic HTML.', 'woondershop-pt' )
			)
		);

		echo '</div>';
	}


	/**
	 * Handles saving custom WC product settings
	 *
	 * @see http://www.remicorson.com/mastering-woocommerce-products-custom-fields/
	 */
	public static function add_custom_general_fields_save( $post_id ) {
		update_post_meta( $post_id, '_woonder_brand_text', $_POST['_woonder_brand_text'] );
		update_post_meta( $post_id, '_woonder_additional_info_text', $_POST['_woonder_additional_info_text'] );
		update_post_meta( $post_id, '_woonder_img_variation_attribute', $_POST['_woonder_img_variation_attribute'] );
	}


	/**
	 * Add custom <select> to WC variation settings
	 */
	public static function add_custom_select_for_image_variation_selector() {
		global $post, $wpdb, $product_object;
		$variation_attributes = $product_object->get_attributes();
		?>
		<div class="toolbar">
			<strong><?php esc_html_e( 'Attribute used for image selector', 'woondershop-pt' ); ?>: <?php echo wc_help_tip( __( 'Choose different product images in the individual variations. Chosen images will be displayed and used as an image variation selector on frontend.', 'woondershop-pt' ) ); ?></strong>
			<select name="_woonder_img_variation_attribute">
				<option value=""><?php esc_html_e( 'None', 'woondershop-pt' ); ?></option>
				<?php
					foreach ( $variation_attributes as $key => $attribute ) {
						printf( '<option value="%s" %s>%s</option>', esc_attr( $key ), selected( get_post_meta( get_the_ID(), '_woonder_img_variation_attribute', true ), $key ), esc_html( $attribute->get_name() ) );
					}
				?>
			</select>
		</div>
		<?php
	}


	/**
	 * Custom variable to determine which attribute is for the image selector
	 */
	public static function add_custom_variable_to_woocommerce_available_variation( $parameters_array ) {
		$parameters_array['img_variation_attribute'] = get_post_meta( get_the_ID(), '_woonder_img_variation_attribute', true );

		return $parameters_array;
	}


	/**
	 * Change the default Testimonial widget settings.
	 *
	 * @param array $defaults The default testimonial widget settings.
	 */
	public function set_testimonial_widget_settings( $defaults ) {
		$defaults['author_avatar'] = true;

		return $defaults;
	}


	/**
	 * Change the WooCommerce related products arguments on single product page.
	 * Change from 3 products to 4.
	 *
	 * @param array $args The default arguments.
	 *
	 * @return array
	 */
	public function change_woocommerce_related_products_args( $args ) {
		$args['posts_per_page'] = 4;
		$args['columns']        = 4;

		return $args;
	}


	/**
	 * Change the WooCommerce product review comment form args.
	 * Default form can be found in WooCommerce:
	 * templates/single-product-reviews.php
	 *
	 * @param array $args The default review form args.
	 *
	 * @return array
	 */
	public function change_woocommerce_product_review_comment_form_args( $args ) {
		// Remove the rating HTML code from the comment_field.
		$args['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woondershop-pt' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

		// Add rating to the first position of the fields.
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$fields         = $args['fields'];
			$args['fields'] = array();

			$args['fields']['rating'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woondershop-pt' ) . ' <span class="required">*</span></label><select name="rating" id="rating" aria-required="true" required>
				<option value="">' . esc_html__( 'Rate&hellip;', 'woondershop-pt' ) . '</option>
				<option value="5">' . esc_html__( 'Perfect', 'woondershop-pt' ) . '</option>
				<option value="4">' . esc_html__( 'Good', 'woondershop-pt' ) . '</option>
				<option value="3">' . esc_html__( 'Average', 'woondershop-pt' ) . '</option>
				<option value="2">' . esc_html__( 'Not that bad', 'woondershop-pt' ) . '</option>
				<option value="1">' . esc_html__( 'Very poor', 'woondershop-pt' ) . '</option>
			</select></div>';

			if ( ! is_user_logged_in() ) {
				$args['fields'] = array_merge( $args['fields'], $fields );
			}
		}

		// Add all fields to the top of comment_field with wrapper divs.
		$args['comment_field'] = array_reduce( $args['fields'], function( $string, $item ) {
			return $string . $item;
		}, '<div class="ratings-fields">' ) . '</div><div class="ratings-comment-and-submit">' . $args['comment_field'];

		// Clear all fields, since they were added to comment_field above and are no longer needed.
		$args['fields'] = array();

		// Overwrite the default submit button wrapper code with a closing div tag.
		$args['submit_field'] = '<p class="form-submit">%1$s %2$s</p>' . '</div>';

		return $args;
	}


	/**
	 * Change the location of the page header "title area" on WooCommerce account page.
	 * Hooked into the 'wp' action, so that we can use the WooCommerce conditional: is_account_page.
	 */
	public function change_location_of_the_page_header_on_woocommerce_account_page() {
		if ( ! is_account_page() ) {
			return;
		}

		add_action( 'woocommerce_account_content', function() {
			get_template_part( 'template-parts/page-header', WoonderShopHelpers::get_skin() );
		}, 8 );
	}


	/**
	 * Output the HTML for the WooCommerce product image on single product page in a loop (example: "related products").
	 * Code mostly from WooCommerce: abstract-wc-product.php -> get_image method.
	 *
	 * This was done, to add a correct "sizes" attribute to those images.
	 */
	public function change_woocommerce_template_loop_product_thumbnail() {
		global $product;

		$size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
		$attr = array(
			'sizes' => '(min-width: 1200px) 350px, (min-width: 992px) 290px, (min-width: 768px) 332px, (min-width: 576px) 242px, calc(50vw - 30px)',
		);

		if ( has_post_thumbnail( $product->get_id() ) ) {
			$image = get_the_post_thumbnail( $product->get_id(), $size, $attr );
		} elseif ( ( $parent_id = wp_get_post_parent_id( $product->get_id() ) ) && has_post_thumbnail( $parent_id ) ) {
			$image = get_the_post_thumbnail( $parent_id, $size, $attr );
		} else {
			$image = wc_placeholder_img( $size );
		}

		echo apply_filters( 'woocommerce_product_get_image', wc_get_relative_url( $image ), $this, $size, $attr, true, $image );
	}


	/**
	 * Force the price display for variable products with same price.
	 * This is hooked to the WooCommerce filter in "get_available_variation" method of the WC_Product_Variable class.
	 *
	 * @param boolean $default     The default do/don't display of the purchase price.
	 * @param object  $var_product The WC_Product_Variable object.
	 * @param object  $variation   The WC product instance.
	 *
	 * @return boolean
	 */
	public function force_price_display_for_variable_products( $default, $var_product, $variation ) {
		if ( "" === $variation->get_price() ) {
			return $default;
		}

		return true;
	}
}

// Single instance.
$woondershop_hooks = new WoonderShopHooks();
