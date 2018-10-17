<?php
/**
 * This file holds the WoonderShop customizer settings array.
 */

use ProteusThemes\CustomizerUtils\Setting;

class WoonderShop_Customizer_Settings_Data {
	/**
	 * The instance *Singleton* of this class
	 *
	 * @var WoonderShop_Customizer_Settings_Data
	 */
	private static $instance;

	/**
	 * The data array of the Customizer settings.
	 *
	 * @var array
	 */
	private $data;

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return WoonderShop_Customizer_Settings_Data the *Singleton* instance.
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Class construct function.
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		$this->data = $this->generate_settings_data();
	}

	/**
	 * Getter function for the Customizer settings data.
	 *
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Generate the Customizer settings array.
	 *
	 * @return array
	 */
	private function generate_settings_data() {
		$darken6            = new Setting\DynamicCSS\ModDarken( 6 );
		$darken8            = new Setting\DynamicCSS\ModDarken( 8 );
		$darken12           = new Setting\DynamicCSS\ModDarken( 12 );
		$darken18           = new Setting\DynamicCSS\ModDarken( 18 );
		$darken28           = new Setting\DynamicCSS\ModDarken( 28 );
		$lighten6           = new Setting\DynamicCSS\ModLighten( 6 );
		$lighten15          = new Setting\DynamicCSS\ModLighten( 15 );
		$lighten18          = new Setting\DynamicCSS\ModLighten( 18 );
		$lighten24          = new Setting\DynamicCSS\ModLighten( 24 );
		$background_img_url = new Setting\DynamicCSS\ModPrependAppend( 'url(', ')' );
		$lg_darken18        = new Setting\DynamicCSS\ModLinearGradient( $darken18 );
		$lg_darken_both_10  = new Setting\DynamicCSS\ModLinearGradient( $darken28, 'to bottom', $darken8 );
		$lg_darken18_180deg = new Setting\DynamicCSS\ModLinearGradient( $darken18, '180deg' );
		$boxshadow_0_0_0_2px = new Setting\DynamicCSS\ModPrependAppend( '0 0 0 2px ', '' );

		return array(
			'featured_dropdown_background_color' => array(
				'default'   => array(
					'default' => '#5c5c5c',
					'jungle'  => '#000000',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'background',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .featured-dropdown',
								),
							),
							'modifier'  => $lg_darken18_180deg,
						),
					),
					'jungle' => array(), // not used in that skin
				)
			),

			'main_navigation_background_color' => array(
				'default'   => '#3b3b3b',
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'background',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.navigation-bar',
								),
							),
							'modifier'  => $lg_darken18_180deg,
						),
					),
					'jungle' => array(),
				)
			),

			'main_navigation_mobile_background' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#141a22',
				),
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.navigation-bar',
							),
						),
					),
				),
			),

			'main_navigation_mobile_color' => array(
				'default'   => '#ffffff',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.main-navigation a',
							),
						),
					),
				),
			),

			'main_navigation_mobile_color_hover' => array(
				'default'   => array(
					'default' => '#1f1f1f',
					'jungle'  => '#242f3d',
				),
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.main-navigation .menu-item.is-hover>a',
								'.main-navigation .menu-item:focus>a',
								'.main-navigation .menu-item:hover>a',
								'.main-navigation .dropdown-toggle',
							),
						),
					),
					array(
						'name'      => 'color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.main-navigation .dropdown-toggle',
							),
						),
						'modifier'  => $lighten24,
					),
				),
			),

			'main_navigation_mobile_sub_bgcolor' => array(
				'default'   => array(
					'default' => '#1f1f1f',
					'jungle'  => '#242f3d',
				),
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.main-navigation .sub-menu a',
								'.main-navigation .sub-menu',
							),
						),
					),
					array(
						'name'      => 'border-color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.main-navigation .sub-menu a',
							),
						),
						'modifier'  => $lighten18,
					),
				),
			),

			'main_navigation_mobile_sub_color' => array(
				'default'   => '#ffffff',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.main-navigation .sub-menu a',
							),
						),
					),
				),
			),

			'main_navigation_mobile_sub_color_hover' => array(
				'default'   => array(
					'default' => '#2e2e2e',
					'jungle'  => '#3a4857',
				),
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'@media (max-width: 991px)' => array(
								'.main-navigation .sub-menu .menu-item:focus>a',
								'.main-navigation .sub-menu .menu-item:hover>a',
							),
						),
					),
				),
			),

			'main_navigation_color' => array(
				'default'   => array(
					'default' => '#bbbbbb',
					'jungle'  => '#c7cace',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation a',
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation a::before',
								),
							),
						),
					),
					'jungle' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation a',
								),
							),
						),
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation a::after',
								),
							),
							'modifier' => $lighten24,
						),
					),
				),
			),

			'main_navigation_color_hover' => array(
				'default'   => '#ffffff',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'@media (min-width: 992px)' => array(
								'.main-navigation .menu-item.is-hover>a',
								'.main-navigation .menu-item:focus>a',
								'.main-navigation .menu-item:hover>a',
							),
						),
					),
				),
			),

			'main_navigation_color_current' => array(
				'default'   => '#ffffff',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'@media (min-width: 992px)' => array(
								'.main-navigation>.current-menu-item:focus>a',
								'.main-navigation>.current-menu-item:hover>a',
								'.main-navigation>.current-menu-item>a'
							),
						),
					),
				),
			),

			'main_navigation_sub_bg' => array(
				'default'   => array(
					'default' => '#f4f4f4',
					'jungle'  => '#ffffff',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu a',
									'.main-navigation .sub-menu',
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu .menu-item > a:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu a',
								),
							),
							'modifier'  => $darken6,
						),
					),
					'jungle' => array(
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu a',
									'.main-navigation .sub-menu',
									'.main-navigation .sub-menu .menu-item:focus > a',
									'.main-navigation .sub-menu .menu-item:hover > a',
									'.main-navigation .sub-menu .menu-item[aria-expanded="true"] > a',
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu .menu-item > a:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu a',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'border-bottom-color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .featured-dropdown > .sub-menu::before',
								),
							),
						),
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu > .menu-item-has-children > a::after',
								),
							),
							'modifier' => $darken18,
						),
					),
				),
			),

			'main_navigation_sub_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#666666',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu a',
									'.main-navigation .sub-menu .menu-item > a',
									'.main-navigation .sub-menu .menu-item > a:hover',
									'.main-navigation .sub-menu .menu-item-has-children > a::before',
								),
							),
						),
					),
					'jungle' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu a',
									'.main-navigation .sub-menu .menu-item > a',
								),
							),
						),
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu .menu-item-icon',
								),
							),
							'modifier' => $lighten18,
						),
					),
				),
			),

			'main_navigation_sub_color_hover' => array(
				'default'   => '#000000',
				'css_props' => array(
					'default' => array(),
					'jungle' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'@media (min-width: 992px)' => array(
									'.main-navigation .sub-menu .menu-item:focus > a',
									'.main-navigation .sub-menu .menu-item:hover > a',
									'.main-navigation .sub-menu .menu-item[aria-expanded=true] > a',
									'.main-navigation .sub-menu .menu-item:focus > a .menu-item-icon',
									'.main-navigation .sub-menu .menu-item:hover > a .menu-item-icon',
									'.main-navigation .sub-menu .menu-item[aria-expanded="true"] > a .menu-item-icon',
								),
							),
						),
					),
				),
			),

			'header_bg_color' => array(
				'default'   => array(
					'default' => '#ffffff',
					'jungle'  => '#232f3f',
				),
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.header__container',
								'.navigation-bar__container',
								'.navigation-bar__container',
								'.benefit-bar__container',
								'.header-mobile__container',
							),
						),
					),
				),
			),

			'page_header_color' => array(
				'default'   => '#000000',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.page-header__title',
							),
						),
					),
				),
			),

			'breadcrumbs_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#999999',
				),
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.breadcrumbs a',
								'.breadcrumbs span > span',
							),
						),
					),
				),
			),

			'text_color_content_area' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#666666',
				),
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.content-area',
								'.accordion__content .panel-body',
								'.woocommerce-tabs .woocommerce-Tabs-panel',
							),
						),
					),
				),
			),

			'headings_color' => array(
				'default'   => '#000000',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'h1',
								'h2',
								'h3',
								'h4',
								'h5',
								'h6',
								'.post-navigation__title',
								'.accordion__panel .panel-title a.collapsed',
								'.accordion__panel .panel-title a',
								'.accordion .more-link',
								'.latest-news--more-news',
								'.product .price .amount',
								'.wpf_item_name',
								'.woonder-product__title',
								'.woocommerce-tabs .woocommerce-Reviews .woocommerce-Reviews-title',
								'.woocommerce-tabs .woocommerce-Reviews .comment-reply-title',
							),
						),
					),
				),
			),

			'primary_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#f39f39',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.header__widgets .shopping-cart__link',
									'a.icon-box:focus .icon-box__icon',
									'a.icon-box:hover .icon-box__icon',
									'.benefit-bar a.icon-box:focus .icon-box__icon',
									'.benefit-bar a.icon-box:hover .icon-box__icon',
									'.blog-navigation .search-form__submit',
									'.blog-navigation__categories',
									'.blog-categories__dropdown a',
									'.blog-categories__dropdown a:hover',
									'.blog-categories__dropdown a:focus',
									'.widget_search .search-submit',
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.btn-primary',
									'.widget_calendar caption',
									'.wpf_slider.ui-slider .ui-slider-handle',
									'.wpf_slider.ui-slider .ui-widget-header',
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.btn-primary:focus',
									'.btn-primary:hover',
									'.widget_tag_cloud a:active:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.btn-primary:active:hover',
								),
							),
							'modifier'  => $darken12,
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'.btn-primary',
									'.widget_tag_cloud a',
									'.widget_tag_cloud a:focus',
									'.widget_tag_cloud a:hover',
								),
							),
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'.btn-primary:focus',
									'.btn-primary:hover',
									'.widget_tag_cloud a:active:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'.btn-primary:active:hover',
								),
							),
							'modifier'  => $darken12,
						),
					),
					'jungle' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.header__logo-text',
									'.widget_product_search .search-field',
									'.header__widgets .shopping-cart__link',
									'a.icon-box:focus .icon-box__icon',
									'a.icon-box:hover .icon-box__icon',
									'.benefit-bar a.icon-box:focus .icon-box__icon',
									'.benefit-bar a.icon-box:hover .icon-box__icon',
									'.widget_search .search-submit',
								),
							),
						),
						array(
							'name'      => 'color',
							'modifier' => $lighten15,
							'selectors' => array(
								'noop' => array(
									'.shopping-cart .woondershop-cart-quantity',
									'.header-mobile__cart-toggler .woondershop-cart-quantity',
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.main-navigation a::before',
									'.wpf_slider.ui-slider .ui-slider-handle',
									'.wpf_slider.ui-slider .ui-widget-header',
									'.widget_calendar caption',
									'.pw-instagram__item--cta',
									'.wpf_item input[type=checkbox]::before',
									'.widget_tag_cloud a:focus',
									'.widget_tag_cloud a:hover',
									'.main-navigation__label',
								),
							),
						),
						array(
							'name' => 'background-color',
							'modifier' => $lighten15,
							'selectors' => array(
								'noop' => array(
									'.widget_search .search-submit',
								),
							),
						),
						array(
							'name' => 'background-color',
							'modifier' => $lighten24,
							'selectors' => array(
								'noop' => array(
									'.pagination .current',
									'.pagination .current:hover',
									'.pagination .current:focus',
									'.woocommerce-pagination ul .current',
									'.woocommerce-pagination ul .current:focus',
									'.woocommerce-pagination ul .current:hover',
									'.woocommerce .quantity .ui-spinner-button:hover'
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.pw-instagram__item--cta:hover',
									'.widget_tag_cloud a:active:hover',
									'.widget_search .search-submit:focus',
									'.widget_search .search-submit:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'select:focus',
									'.wpf_item input[type=checkbox]:checked',
									'.woocommerce-pagination ul .current',
									'.woocommerce-pagination ul .current:focus',
									'.woocommerce-pagination ul .current:hover',
									'.product .cart .variations .variation-img--selected',
									'.product .cart .variations .variation-img:hover',
									'.product .woocommerce-product-gallery .flex-control-thumbs .flex-active',
									'.product .woocommerce-product-gallery .flex-control-thumbs .flex-active:hover',
									'.widget_tag_cloud a',
									'.widget_tag_cloud a:focus',
									'.widget_tag_cloud a:hover',
									'.pagination .current',
									'.pagination .current:hover',
									'.woocommerce .quantity .ui-spinner-button:hover',
								),
							),
						),
						array(
							'name'      => 'border-left-color',
							'selectors' => array(
								'noop' => array(
									'.content-area .widget_nav_menu .current-menu-item a',
									'.woocommerce-MyAccount-navigation-link.is-active a',
								),
							),
						),
						array(
							'name'      => 'border-top-color',
							'selectors' => array(
								'noop' => array(
									'.product .cart .variations .variation-img--selected::after',
									'.product .woocommerce-product-gallery .flex-control-thumbs .flex-active-container::before',
									'.woocommerce-tabs .tabs .active a',
									'.woocommerce-tabs .tabs .active a:hover',
								),
							),
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'.widget_tag_cloud a:active:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'box-shadow',
							'selectors' => array(
								'noop' => array(
									'.wpf_item .wpf_color_icons.wpf_hide_text input:checked + label',
								),
							),
							'modifier'  => $boxshadow_0_0_0_2px,
						),
					),
				),
			),

			'link_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#3a7bb8',
				),
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'a',
								'.latest-news__more-news',
								'.article-grid .article__more-link',
								'.article-grid .article__container:focus .article__more-link',
								'.article-grid .article__container:hover .article__more-link',
							),
						),
					),
				),
			),

			'link_color_hover' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#e48c34',
				),
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'a:hover',
								'.latest-news__more-news:hover',
								'.article-grid .article__more-link:hover',
								'.article-grid .article__container:focus .article__more-link:hover',
								'.article-grid .article__container:hover .article__more-link:hover',
							),
						),
					),
				),
			),

			'primary_button_background_color' => array(
				'default'   => '#ffc768',
				'css_props' => array(
					'default' => array(),
					'jungle' => array(
						array(
							'name' => 'background',
							'modifier' => $lg_darken18,
							'selectors' => array(
								'noop' => array(
									'.btn-primary',
									'.woocommerce .button',
									'.woonder-product__button',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout',
									'.image-banner__cta',
									'.woocommerce-tabs .woocommerce-Reviews .submit',
									'.woonder-product__button',
								),
							),
						),
						array(
							'name' => 'background',
							'modifier'  => $lg_darken_both_10,
							'selectors' => array(
								'noop' => array(
									'.btn-primary:focus',
									'.btn-primary:hover',
									'.btn-primary:active:hover',
									'.woocommerce .button:focus',
									'.woocommerce .button:hover',
									'.woocommerce .button:active:hover',
									'.woonder-product__button:focus',
									'.woonder-product__button:hover',
									'.woonder-product__button:active:hover',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout:focus',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout:hover',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout:active:hover',
									'.image-banner__cta:focus',
									'.image-banner__cta:hover',
									'.image-banner__cta:active:hover',
									'.woocommerce-tabs .woocommerce-Reviews .submit:focus',
									'.woocommerce-tabs .woocommerce-Reviews .submit:hover',
									'.woocommerce-tabs .woocommerce-Reviews .submit:active:hover',
									'.woonder-product__button:focus',
									'.woonder-product__button:hover',
									'.woonder-product__button:active:hover',
								),
							),
						),
						array(
							'name' => 'border-color',
							'modifier'  => $darken18,
							'selectors' => array(
								'noop' => array(
									'.btn-primary',
									'.woocommerce .button',
									'.woonder-product__button',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout',
									'.image-banner__cta',
									'.woocommerce-tabs .woocommerce-Reviews .submit',
									'.woonder-product__button',
									'.product .cart .single_add_to_cart_button',
								),
							),
						),
						array(
							'name' => 'border-color',
							'modifier'  => $darken28,
							'selectors' => array(
								'noop' => array(
									'.btn-primary:focus',
									'.btn-primary:hover',
									'.btn-primary:active:hover',
									'.woocommerce .button:focus',
									'.woocommerce .button:hover',
									'.woocommerce .button:active:hover',
									'.woonder-product__button:focus',
									'.woonder-product__button:hover',
									'.woonder-product__button:active:hover',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout:focus',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout:hover',
									'.widget_shopping_cart .woocommerce-mini-cart__buttons .checkout:active:hover',
									'.image-banner__cta:focus',
									'.image-banner__cta:hover',
									'.image-banner__cta:active:hover',
									'.woocommerce-tabs .woocommerce-Reviews .submit:focus',
									'.woocommerce-tabs .woocommerce-Reviews .submit:hover',
									'.woocommerce-tabs .woocommerce-Reviews .submit:active:hover',
									'.woonder-product__button:focus',
									'.woonder-product__button:hover',
									'.woonder-product__button:active:hover',
								),
							),
						),
					)
				),
			),

			'secondary_button_background_color' => array(
				'default'   => '#999999',
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.btn-secondary',
								),
							),
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.btn-secondary:focus',
									'.btn-secondary:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.btn-secondary:active:hover',
								),
							),
							'modifier'  => $darken12,
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'.btn-secondary',
								),
							),
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'.btn-secondary:focus',
									'.btn-secondary:hover',
								),
							),
							'modifier'  => $darken6,
						),
						array(
							'name'      => 'border-color',
							'selectors' => array(
								'noop' => array(
									'.btn-secondary:active:hover',
								),
							),
							'modifier'  => $darken12,
						),
					),
					'jungle' => array(),
				),
			),

			'light_button_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#333333',
				),
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.btn-light',
								'.btn-light:focus',
								'.btn-light:hover',
								'.btn-light:active:hover',
							),
						),
					),
				),
			),

			'light_button_background_color' => array(
				'default'   => array(
					'default' => '#f4f4f4',
					'jungle'  => '#ffffff',
				),
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.btn-light',
							),
						),
					),
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.btn-light:focus',
								'.btn-light:hover',
							),
						),
						'modifier'  => $darken6,
					),
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.btn-light:active:hover',
							),
						),
						'modifier'  => $darken12,
					),
					array(
						'name'      => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-light',
							),
						),
					),
					array(
						'name'      => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-light:focus',
								'.btn-light:hover',
							),
						),
						'modifier'  => $darken6,
					),
					array(
						'name'      => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-light:active:hover',
							),
						),
						'modifier'  => $darken12,
					),
				),
			),

			'dark_button_background_color' => array(
				'default'   => array(
					'default' => '#333333',
					'jungle'  => '#485769',
				),
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.btn-dark',
							),
						),
					),
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.btn-dark:focus',
								'.btn-dark:hover',
							),
						),
						'modifier'  => $darken6,
					),
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.btn-dark:active:hover',
							),
						),
						'modifier'  => $darken12,
					),
					array(
						'name'      => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-dark',
							),
						),
					),
					array(
						'name'      => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-dark:focus',
								'.btn-dark:hover',
							),
						),
						'modifier'  => $darken6,
					),
					array(
						'name'      => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-dark:active:hover',
							),
						),
						'modifier'  => $darken12,
					),
				),
			),

			'primary_custom_icon_color' => array(
				'default'   => '#f39f39',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.ws-yen .path1:before',
								'.ws-tag .path1:before',
								'.ws-return .path2:before',
								'.ws-coins-1 .path1:before',
								'.ws-sign .path1:before',
								'.ws-heart .path1:before',
								'.ws-wallet .path1:before',
								'.ws-shopping-bag-2 .path1:before',
								'.ws-delivery-truck-1 .path1:before',
								'.ws-delivery-truck .path1:before',
								'.ws-ticket .path1:before',
								'.ws-task .path1:before',
								'.ws-chat .path1:before',
								'.ws-chat .path2:before',
								'.ws-shopping-basket .path1:before',
								'.ws-shopping-bag-1 .path1:before',
								'.ws-loupe .path1:before',
								'.ws-percentage .path2:before',
								'.ws-review .path1:before',
								'.ws-receipt .path1:before',
								'.ws-smartphone-1 .path2:before',
								'.ws-smartphone .path2:before',
								'.ws-atm .path1:before',
								'.ws-email .path3:before',
								'.ws-pin .path2:before',
								'.ws-list .path2:before',
								'.ws-hanger-1 .path1:before',
								'.ws-hanger .path1:before',
								'.ws-gift .path1:before',
								'.ws-gift-bag .path1:before',
								'.ws-package-2 .path1:before',
								'.ws-dollar .path1:before',
								'.ws-euro .path1:before',
								'.ws-coins .path1:before',
								'.ws-cursor .path2:before',
								'.ws-online-banking .path1:before',
								'.ws-cash-1 .path1:before',
								'.ws-cash .path1:before',
								'.ws-trolley .path1:before',
								'.ws-shopping-cart-2 .path1:before',
								'.ws-shopping-cart-1 .path1:before',
								'.ws-shopping-cart .path1:before',
								'.ws-credit-card-1 .path1:before',
								'.ws-credit-card .path1:before',
								'.ws-calculator .path1:before',
								'.ws-package-1 .path1:before',
								'.ws-package .path1:before',
								'.ws-medal .path1:before',
								'.ws-barcode .path1:before',
								'.ws-barcode .path2:before',
								'.ws-barcode .path3:before',
								'.ws-barcode .path4:before',
								'.ws-barcode .path5:before',
								'.ws-barcode .path6:before',
								'.ws-shopping-bag .path1:before',
								'.ws-worldwide .path1:before',
							),
						),
					),
				),
			),

			'secondary_custom_icon_color' => array(
				'default'   => '#000000',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.ws-yen .path2::before',
								'.ws-tag .path2::before',
								'.ws-tag .path3::before',
								'.ws-return .path1::before',
								'.ws-coins-1 .path2::before',
								'.ws-coins-1 .path3::before',
								'.ws-coins-1 .path4::before',
								'.ws-coins-1 .path5::before',
								'.ws-sign .path2::before',
								'.ws-sign .path3::before',
								'.ws-heart .path2::before',
								'.ws-heart .path3::before',
								'.ws-heart .path4::before',
								'.ws-wallet .path2::before',
								'.ws-wallet .path3::before',
								'.ws-shopping-bag-2 .path2::before',
								'.ws-shopping-bag-2 .path3::before',
								'.ws-shopping-bag-2 .path4::before',
								'.ws-delivery-truck-1 .path2::before',
								'.ws-delivery-truck-1 .path3::before',
								'.ws-delivery-truck-1 .path4::before',
								'.ws-delivery-truck .path2::before',
								'.ws-ticket .path2::before',
								'.ws-ticket .path3::before',
								'.ws-task .path2::before',
								'.ws-task .path3::before',
								'.ws-task .path4::before',
								'.ws-task .path5::before',
								'.ws-task .path6::before',
								'.ws-task .path7::before',
								'.ws-task .path8::before',
								'.ws-task .path9::before',
								'.ws-task .path10::before',
								'.ws-chat .path3::before',
								'.ws-chat .path4::before',
								'.ws-shopping-basket .path2::before',
								'.ws-shopping-basket .path3::before',
								'.ws-shopping-basket .path4::before',
								'.ws-shopping-basket .path5::before',
								'.ws-shopping-bag-1 .path2::before',
								'.ws-shopping-bag-1 .path3::before',
								'.ws-loupe .path2::before',
								'.ws-loupe .path3::before',
								'.ws-percentage .path1::before',
								'.ws-percentage .path3::before',
								'.ws-percentage .path4::before',
								'.ws-percentage .path5::before',
								'.ws-review .path2::before',
								'.ws-review .path3::before',
								'.ws-review .path4::before',
								'.ws-receipt .path2::before',
								'.ws-receipt .path3::before',
								'.ws-receipt .path4::before',
								'.ws-receipt .path5::before',
								'.ws-receipt .path6::before',
								'.ws-smartphone-1 .path1::before',
								'.ws-smartphone-1 .path3::before',
								'.ws-smartphone .path1::before',
								'.ws-smartphone .path3::before',
								'.ws-smartphone .path4::before',
								'.ws-smartphone .path5::before',
								'.ws-atm .path2::before',
								'.ws-atm .path3::before',
								'.ws-email .path1::before',
								'.ws-email .path2::before',
								'.ws-email .path4::before',
								'.ws-email .path5::before',
								'.ws-pin .path1::before',
								'.ws-pin .path3::before',
								'.ws-list .path1::before',
								'.ws-list .path3::before',
								'.ws-list .path4::before',
								'.ws-list .path5::before',
								'.ws-list .path6::before',
								'.ws-hanger-1 .path2::before',
								'.ws-hanger-1 .path3::before',
								'.ws-hanger .path2::before',
								'.ws-gift .path2::before',
								'.ws-gift-bag .path2::before',
								'.ws-package-2 .path2::before',
								'.ws-package-2 .path3::before',
								'.ws-package-2 .path4::before',
								'.ws-package-2 .path5::before',
								'.ws-dollar .path2::before',
								'.ws-euro .path2::before',
								'.ws-coins .path2::before',
								'.ws-coins .path3::before',
								'.ws-cursor .path1::before',
								'.ws-cursor .path3::before',
								'.ws-cursor .path4::before',
								'.ws-cursor .path5::before',
								'.ws-online-banking .path2::before',
								'.ws-online-banking .path3::before',
								'.ws-cash-1 .path2::before',
								'.ws-cash-1 .path3::before',
								'.ws-cash-1 .path4::before',
								'.ws-cash .path2::before',
								'.ws-cash .path3::before',
								'.ws-cash .path4::before',
								'.ws-trolley .path2::before',
								'.ws-trolley .path3::before',
								'.ws-shopping-cart-2 .path2::before',
								'.ws-shopping-cart-2 .path3::before',
								'.ws-shopping-cart-2 .path4::before',
								'.ws-shopping-cart-2 .path5::before',
								'.ws-shopping-cart-1 .path2::before',
								'.ws-shopping-cart .path2::before',
								'.ws-credit-card-1 .path2::before',
								'.ws-credit-card-1 .path3::before',
								'.ws-credit-card-1 .path4::before',
								'.ws-credit-card-1 .path5::before',
								'.ws-credit-card .path2::before',
								'.ws-credit-card .path3::before',
								'.ws-calculator .path2::before',
								'.ws-calculator .path3::before',
								'.ws-calculator .path4::before',
								'.ws-calculator .path5::before',
								'.ws-calculator .path6::before',
								'.ws-calculator .path7::before',
								'.ws-calculator .path8::before',
								'.ws-calculator .path9::before',
								'.ws-calculator .path10::before',
								'.ws-calculator .path11::before',
								'.ws-calculator .path12::before',
								'.ws-calculator .path13::before',
								'.ws-package-1 .path2::before',
								'.ws-package .path2::before',
								'.ws-medal .path2::before',
								'.ws-medal .path3::before',
								'.ws-barcode .path7::before',
								'.ws-barcode .path8::before',
								'.ws-barcode .path9::before',
								'.ws-barcode .path10::before',
								'.ws-barcode .path11::before',
								'.ws-barcode .path12::before',
								'.ws-shopping-bag .path2::before',
								'.ws-shopping-bag .path3::before',
								'.ws-shopping-bag .path4::before',
								'.ws-worldwide .path2::before',
							),
						),
					),
				),
			),

			'slider_title_color' => array(
				'default'   => '#000000',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.pt-slick-carousel__content-title',
							),
						),
					),
				),
			),

			'slider_text_color' => array(
				'default'   => '#999999',
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.pt-slick-carousel__content-description',
							),
						),
					),
				),
			),

			'body_bg_img' => array(
				'sanitize_callback' => 'esc_url',
				'css_props'         => array(
					array(
						'name'      => 'background-image',
						'modifier'  => $background_img_url,
						'selectors' => array(
							'noop' => array(
								'body .boxed-container',
							),
						),
					),
				),
			),

			'body_bg_img_repeat' => array(
				'default'           => 'repeat',
				'sanitize_callback' => 'sanitize_key',
				'css_props'         => array(
					array(
						'name'      => 'background-repeat',
						'selectors' => array(
							'noop' => array(
								'body .boxed-container',
							),
						),
					),
				),
			),

			'body_bg_img_position_x' => array(
				'default'           => 'center',
				'sanitize_callback' => 'sanitize_key',
				'css_props'         => array(
					array(
						'name'      => 'background-position-x',
						'selectors' => array(
							'noop' => array(
								'body .boxed-container',
							),
						),
					),
				),
			),

			'body_bg_img_position_y' => array(
				'default'           => 'center',
				'sanitize_callback' => 'sanitize_key',
				'css_props'         => array(
					array(
						'name'      => 'background-position-y',
						'selectors' => array(
							'noop' => array(
								'body .boxed-container',
							),
						),
					),
				),
			),

			'body_bg_img_attachment' => array(
				'default'           => 'scroll',
				'sanitize_callback' => 'sanitize_key',
				'css_props'         => array(
					array(
						'name'      => 'background-attachment',
						'selectors' => array(
							'noop' => array(
								'body .boxed-container',
							),
						),
					),
				),
			),

			'body_bg' => array(
				'default'   => '#ffffff',
				'css_props' => array(
					array(
						'name'      => 'background-color',
						'selectors' => array(
							'noop' => array(
								'body .boxed-container',
							),
						),
					),
				),
			),

			'footer_bg_color' => array(
				'default'   => array(
					'default' => '#eeeeee',
					'jungle'  => '#242f3d',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.footer-top',
								),
							),
						),
					),
					'jungle' => array(
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.footer-top',
									'.footer-bottom__container',
								),
							),
						),
					),
				),
			),

			'footer_title_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#ffffff',
				),
				'css_props' => array(
					array(
						'name'      => 'color',
						'selectors' => array(
							'noop' => array(
								'.footer-top__heading',
							),
						),
					),
				),
			),

			'footer_text_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#c7cace',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.footer-top',
								),
							),
						),
					),
					'jungle' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.footer-top',
									'.footer-bottom',
								),
							),
						),
					),
				),
			),

			'footer_link_color' => array(
				'default'   => array(
					'default' => '#000000',
					'jungle'  => '#c7cace',
				),
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.footer-top a',
									'.footer-top .widget_nav_menu .menu a',
								),
							),
						),
					),
					'jungle' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.footer-top a',
									'.footer-top .widget_nav_menu .menu a',
									'.footer-bottom a',
									'.footer .footer-bottom .back-to-top',
								),
							),
						),
					),
				),
			),

			'footer_bottom_background_color' => array(
				'default'   => '#dddddd',
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.footer-bottom__container',
								),
							),
						),
					),
					'jungle' => array(),
				),
			),

			'footer_bottom_text_color' => array(
				'default'   => '#000000',
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.footer-bottom',
									'.footer .back-to-top',
								),
							),
						),
					),
					'jungle' => array(),
				),
			),

			'footer_bottom_link_color' => array(
				'default'   => '#000000',
				'css_props' => array(
					'default' => array(
						array(
							'name'      => 'color',
							'selectors' => array(
								'noop' => array(
									'.footer-bottom a',
									'.footer .footer-bottom .back-to-top',
								),
							),
						),
					),
					'jungle' => array(),
				),
			),

			'footer_credits_bg_color' => array(
				'default'   => '#141a22',
				'css_props' => array(
					'default' => array(),
					'jungle' => array(
						array(
							'name' => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.footer-credits__container',
								),
							),
						),
					),
				),
			),

			'footer_credits_text_color' => array(
				'default'   => '#d8d8d8',
				'css_props' => array(
					'default' => array(),
					'jungle' => array(
						array(
							'name' => 'color',
							'selectors' => array(
								'noop' => array(
									'.footer-credits',
								),
							),
						),
					),
				),
			),

			'back_to_top_bg_color' => array(
				'default'   => '#3a4757',
				'css_props' => array(
					'default' => array(),
					'jungle' => array(
						array(
							'name' => 'background-color',
							'selectors' => array(
								'noop' => array(
									'.footer-back-to-top',
								),
							),
						),
						array(
							'name' => 'background-color',
							'modifier' => $lighten6,
							'selectors' => array(
								'noop' => array(
									'.footer-back-to-top:focus',
									'.footer-back-to-top:hover',
								),
							),
						),
					),
				),
			),
		);
	}

	/**
	 * Private clone method to prevent cloning of the instance of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}


	/**
	 * Private unserialize method to prevent unserializing of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __wakeup() {}
}
