<?php
/**
 * Class which handles the output of the WP customizer on the frontend.
 * Meaning that this stuff loads always, no matter if the global $wp_cutomize
 * variable is present or not.
 *
 * @package woondershop-pt
 */

/**
 * Customizer frontend related code
 */
class WoonderShop_Customize_Frontent {

	/**
	 * Add actions to load the right staff at the right places (header, footer).
	 */
	function __construct() {
		if ( ! is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts' , array( $this, 'output_customizer_css' ), 20 );
		}
		add_action( 'wp_head' , array( $this, 'head_output' ) );
		add_action( 'wp_footer' , array( $this, 'footer_output' ) );
	}

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @see add_action( 'wp_head' , array( $this, 'head_output' ) );
	 */
	public static function output_customizer_css() {
		$css_string = self::get_customizer_css();

		if ( WoonderShopHelpers::is_skin_active( 'default' ) ) {
			$css_string .= self::get_top_header_css();
		}

		$css_string .= self::get_logo_padding_css();

		if ( $css_string ) {
			wp_add_inline_style( 'woondershop-theme', $css_string );
		}
	}

	/**
	 * This will get custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @see add_action( 'wp_head' , array( $this, 'head_output' ) );
	 */
	public static function get_customizer_css() {
		$css = array();

		$css[] = self::get_customizer_colors_css();

		return join( PHP_EOL, $css );
	}


	/**
	 * Branding CSS, generated dynamically and cached stringifyed in db
	 *
	 * @return string CSS
	 */
	public static function get_customizer_colors_css() {
		$out = '';

		$cached_css = get_theme_mod( 'cached_css', '' );

		$out .= '/* WP Customizer start */' . PHP_EOL;
		$out .= strip_tags( apply_filters( 'woondershop_cached_css', $cached_css ) );
		$out .= PHP_EOL . '/* WP Customizer end */';

		return $out;
	}


	/**
	 * Compute the top header background color (hex) and opacity into a rgba color.
	 *
	 * @return string CSS
	 */
	public static function get_top_header_css() {
		$out = '';

		$page_title_area_bg_color         = get_theme_mod( 'page_title_area_bg_color', '#f4f4f4' );
		$page_title_area_bg_color_opacity = get_theme_mod( 'page_title_area_bg_color_opacity', 100 );

		if ( empty( $page_title_area_bg_color ) ) {
			return '';
		}

		$page_title_area_bg_color_data = WoonderShopHelpers::hex2rgb( $page_title_area_bg_color );

		$page_title_area_bg_color_opacity = WoonderShopHelpers::bound( $page_title_area_bg_color_opacity, 0, 100 );

		if ( 0 !== $page_title_area_bg_color_opacity ) {
			$page_title_area_bg_color_opacity = $page_title_area_bg_color_opacity / 100;
		}

		$out .= PHP_EOL;
		$out .= sprintf( '.page-header { background-color: rgba( %1$s, %2$s ); }', implode( ', ', $page_title_area_bg_color_data ) , $page_title_area_bg_color_opacity );
		$out .= PHP_EOL;

		return $out;
	}


	/**
	 * Output the logo padding CSS.
	 *
	 * @return string CSS
	 */
	public static function get_logo_padding_css() {
		$out = '';

		$logo_padding_top    = (int) get_theme_mod( 'logo_padding_top', 0 );
		$logo_padding_right  = (int) get_theme_mod( 'logo_padding_right', 0 );
		$logo_padding_bottom = (int) get_theme_mod( 'logo_padding_bottom', 0 );
		$logo_padding_left   = (int) get_theme_mod( 'logo_padding_left', 0 );

		$out .= PHP_EOL;
		$out .= sprintf( '.header__logo--image { padding: %1$dpx %2$dpx %3$dpx %4$dpx; }', $logo_padding_top, $logo_padding_right, $logo_padding_bottom, $logo_padding_left );
		$out .= PHP_EOL;

		return $out;
	}


	/**
	 * Outputs the code in head of the every page
	 *
	 * Used by hook: add_action( 'wp_head' , array( $this, 'head_output' ) );
	 */
	public static function head_output() {
		// Custom JS from the customizer.
		$script = get_theme_mod( 'custom_js_head', '' );

		if ( ! empty( $script ) ) {
			echo PHP_EOL . $script . PHP_EOL;
		}
	}


	/**
	 * Outputs the code in footer of the every page, right before closing </body>
	 *
	 * Used by hook: add_action( 'wp_footer' , array( $this, 'footer_output' ) );
	 */
	public static function footer_output() {
		$script = get_theme_mod( 'custom_js_footer', '' );

		if ( ! empty( $script ) ) {
			echo PHP_EOL . $script . PHP_EOL;
		}
	}
}
