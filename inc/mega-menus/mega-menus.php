<?php
/**
 * Main mega menu class.
 *
 * Code based from the Storefront Mega Menu plugin (license: GPL v3):
 * https://woocommerce.com/products/storefront-mega-menus/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Returns the main instance of WoonderShop_Mega_Menus to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object WoonderShop_Mega_Menus
 */
function WoonderShop_Mega_Menus() {
	return WoonderShop_Mega_Menus::instance();
} // End WoonderShop_Mega_Menus()

WoonderShop_Mega_Menus();

/**
 * Main WoonderShop_Mega_Menus Class
 *
 * @class WoonderShop_Mega_Menus
 * @version	1.0.0
 * @since 1.0.0
 * @package	WoonderShop_Mega_Menus
 */
final class WoonderShop_Mega_Menus {
	/**
	 * WoonderShop_Mega_Menus The single instance of WoonderShop_Mega_Menus.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		$this->token		= 'woondershop-mega-menus';
		$this->plugin_url	= get_template_directory_uri() . '/inc/mega-menus/';
		$this->plugin_path	= get_template_directory() . '/inc/mega-menus/';
		$this->version		= '1.6.0';

		// Include all the necessary files.
		$this->setup();
	}

	/**
	 * Main WoonderShop_Mega_Menus Instance
	 *
	 * Ensures only one instance of WoonderShop_Mega_Menus is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WoonderShop_Mega_Menus()
	 * @return Main WoonderShop_Mega_Menus instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woondershop-pt' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woondershop-pt' ), '1.0.0' );
	}

	/**
	 * Include all the necessary files.
	 */
	public function setup() {
		require_once 'includes/class-smm-admin.php';
		require_once 'includes/class-smm-customizer.php';
		require_once 'includes/class-smm-frontend.php';
	}
} // End Class
