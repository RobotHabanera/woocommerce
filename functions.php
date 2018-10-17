<?php
/**
 * WoonderShop functions and definitions
 *
 * @author ProteusThemes <info@proteusthemes.com>
 * @package woondershop-pt
 */

// Display informative message if PHP version is less than 5.4.
if ( version_compare( phpversion(), '5.4', '<' ) ) {
	printf( esc_html_x( 'This theme requires %2$sPHP 5.4+%3$s to run. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.4.%4$s Your current version of PHP: %2$s%1$s%3$s', '%1$s - version ie. 5.4.0. %2$s, %3$s and %4$s  - html tags, must be included around the same words as original', 'woondershop-pt' ), esc_html( phpversion() ), '<strong>', '</strong>', '<br>' );
}


// Composer autoloader.
require_once trailingslashit( get_template_directory() ) . 'vendor/autoload.php';


/**
 * Define the version variable to assign it to all the assets (css and js)
 */
define( 'WOONDERSHOP_WP_VERSION', wp_get_theme()->get( 'Version' ) );


/**
 * Define the development constant
 */
if ( ! defined( 'PT_DEVELOPMENT' ) ) {
	define( 'PT_DEVELOPMENT', false );
}


/**
 * Helper functions used in the theme
 */
require_once get_template_directory() . '/inc/helpers.php';


/**
 * Advanced Custom Fields calls to require the plugin within the theme
 */
WoonderShopHelpers::load_file( '/inc/acf.php' );

/**
 * Theme support and thumbnail sizes
 */
if ( ! function_exists( 'woondershop_theme_setup' ) ) {
	function woondershop_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on WoonderShop, use a find and replace
		 * to change 'woondershop-pt' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'woondershop-pt', get_template_directory() . '/languages' );

		/**
		 * Loads separate textdomain for the proteuswidgets which are included with composer.
		 */
		load_theme_textdomain( 'proteuswidgets', get_template_directory() . '/languages/proteuswidgets' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// WooCommerce basic support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'woondershop-jumbotron-slider-l', 1920, 600, true );
		add_image_size( 'woondershop-jumbotron-slider-m', 960, 300, true );
		add_image_size( 'woondershop-jumbotron-slider-s', 480, 150, true );

		// Menus.
		register_nav_menu( 'main-menu', esc_html__( 'Main Menu', 'woondershop-pt' ) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add excerpt support for pages.
		add_post_type_support( 'page', 'excerpt' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'woondershop_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
	add_action( 'after_setup_theme', 'woondershop_theme_setup' );
}


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @see https://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}


/**
 * Enqueue CSS stylesheets
 */
if ( ! function_exists( 'woondershop_enqueue_styles' ) ) {
	function woondershop_enqueue_styles() {
		$min = 'yes' === get_theme_mod( 'use_minified_css', 'yes' ) ? '.min' : '';
		$ver = true === PT_DEVELOPMENT ? null : WOONDERSHOP_WP_VERSION;
		$skin = WoonderShopHelpers::get_skin();

		wp_enqueue_style( 'woondershop-theme', get_theme_file_uri( "assets/dist/css/woondershop-{$skin}{$min}.css" ), array(), $ver );
	}
	add_action( 'wp_enqueue_scripts', 'woondershop_enqueue_styles', 16 );
}


/**
 * Enqueue Google Web Fonts.
 */
if ( ! function_exists( 'woondershop_enqueue_google_web_fonts' ) ) {
	function woondershop_enqueue_google_web_fonts() {
		wp_enqueue_style( 'woondershop-google-fonts', WoonderShopHelpers::google_web_fonts_url(), array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'woondershop_enqueue_google_web_fonts' );
}


/**
 * Enqueue JS scripts
 */
if ( ! function_exists( 'woondershop_enqueue_scripts' ) ) {
	function woondershop_enqueue_scripts() {
		$ver = true === PT_DEVELOPMENT ? null : WOONDERSHOP_WP_VERSION;

		// Modernizr for the frontend feature detection.
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/src/js/modernizr.custom.20170701.js', array(), null );

		// FlipClock.
		if ( is_active_widget( false, false, 'pw_countdown' ) || class_exists( 'WPML_Config' ) ) {
			wp_enqueue_script( 'flipclock-js', get_template_directory_uri() . '/node_modules/flipclock/compiled/flipclock.min.js', array( 'jquery' ), '0.7.8', true );

			wp_enqueue_style( 'flipclock-css', get_template_directory_uri() . '/node_modules/flipclock/compiled/flipclock.css', array(), '0.7.8' );
		}

		// Array for main.js dependencies.
		$main_deps = array( 'jquery', 'underscore' );

		if ( WoonderShopHelpers::is_woocommerce_active() && ( is_product() || is_cart() ) ) {
			wp_enqueue_script( 'jquery-ui-spinner' );
			$main_deps[] = 'jquery-ui-spinner';
		}

		// Main JS file
		wp_enqueue_script( 'woondershop-main', get_template_directory_uri() . '/assets/dist/js/build.js', $main_deps, $ver, true );

		wp_localize_script( 'woondershop-main', 'WoonderShopVars', array(
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'pt-woondershop-ajax-verification' ),
			'texts'      => array(
				'day'           => esc_html__( 'day', 'woondershop-pt' ),
				'days'          => esc_html__( 'days', 'woondershop-pt' ),
				'hour'          => esc_html__( 'hour', 'woondershop-pt' ),
				'hours'         => esc_html__( 'hours', 'woondershop-pt' ),
				'short_hours'   => esc_html_x( 'h', 'short version of: hours', 'woondershop-pt' ),
				'minute'        => esc_html__( 'minute', 'woondershop-pt' ),
				'minutes'       => esc_html__( 'minutes', 'woondershop-pt' ),
				'short_minutes' => esc_html_x( 'min', 'short version of: minutes', 'woondershop-pt' ),
				'second'        => esc_html__( 'second', 'woondershop-pt' ),
				'seconds'       => esc_html__( 'seconds', 'woondershop-pt' ),
				'short_seconds' => esc_html_x( 's', 'short version of: seconds', 'woondershop-pt' ),
				'new_to_cart'   => esc_html__( 'New item has been added.', 'woondershop-pt' ),
			),
			'skin' => WoonderShopHelpers::get_skin(),
		) );

		// For nested comments.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'woondershop_enqueue_scripts' );
}


/**
 * Register admin JS scripts
 */
if ( ! function_exists( 'woondershop_admin_enqueue_scripts' ) ) {
	function woondershop_admin_enqueue_scripts() {
		// Mustache for ProteusWidgets.
		wp_register_script( 'mustache.js', get_template_directory_uri() . '/node_modules/mustache/mustache.min.js' );

		// Add the color picker css file.
		wp_enqueue_style( 'wp-color-picker' );

		// Enqueue admin utils js.
		wp_enqueue_script( 'woondershop-admin-utils', get_template_directory_uri() . '/assets/admin/js/admin.js', array( 'jquery', 'underscore', 'backbone', 'mustache.js', 'wp-color-picker' ), WOONDERSHOP_WP_VERSION );

		// Register FA CSS files.
		wp_register_style( 'font-awesome-brands', get_template_directory_uri() . '/node_modules/@fortawesome/fontawesome-free-webfonts/css/fa-brands.css', array(), '5.0.6' );
		wp_register_style( 'font-awesome-regular', get_template_directory_uri() . '/node_modules/@fortawesome/fontawesome-free-webfonts/css/fa-regular.css', array(), '5.0.6' );
		wp_register_style( 'font-awesome-solid', get_template_directory_uri() . '/node_modules/@fortawesome/fontawesome-free-webfonts/css/fa-solid.css', array(), '5.0.6' );
		wp_register_style( 'font-awesome', get_template_directory_uri() . '/node_modules/@fortawesome/fontawesome-free-webfonts/css/fontawesome.css', array(), '5.0.6' );

		// Enqueue CSS for admin area.
		wp_enqueue_style( 'medicpress-admin-css', get_template_directory_uri() . '/assets/admin/css/admin.css' );
	}
	add_action( 'admin_enqueue_scripts', 'woondershop_admin_enqueue_scripts' );
}


/**
 * Require the files in the inc folder.
 */
WoonderShopHelpers::load_file( '/inc/theme-widgets.php' );
WoonderShopHelpers::load_file( '/inc/theme-shortcodes.php' );
WoonderShopHelpers::load_file( '/inc/theme-sidebars.php' );
WoonderShopHelpers::load_file( '/inc/hooks.php' );
WoonderShopHelpers::load_file( '/inc/compat.php' );
WoonderShopHelpers::load_file( '/inc/theme-customizer.php' );
WoonderShopHelpers::load_file( '/inc/theme-registration.php' );
WoonderShopHelpers::load_file( '/inc/mega-menus/mega-menus.php' );
WoonderShopHelpers::load_file( '/inc/merlin-config.php' );

/**
 * WIA-ARIA nav walker and accompanying JS file.
 */
if ( ! function_exists( 'woondershop_wai_aria_js' ) ) {
	function woondershop_wai_aria_js() {
		wp_enqueue_script( 'woondershop-wp-wai-aria', get_template_directory_uri() . '/vendor/proteusthemes/wai-aria-walker-nav-menu/wai-aria.js', array( 'jquery' ), null, true );
	}
	add_action( 'wp_enqueue_scripts', 'woondershop_wai_aria_js' );
}


/**
 * Require some files only when in admin.
 */
if ( is_admin() ) {
	WoonderShopHelpers::load_file( '/inc/tgm-plugin-activation.php' );
	WoonderShopHelpers::load_file( '/inc/documentation-link.php' );
}
