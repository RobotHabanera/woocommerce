<?php
/**
 * Single product shortcode.
 *
 * Only available if WooCommerce is active.
 *
 * @package woondershop-pt
 */

class WS_Woonder_Product {

	function __construct() {
		if ( WoonderShopHelpers::is_woocommerce_active() ) {
			add_shortcode( 'woonder_product', array( $this, 'woonder_product' ) );
		}
	}

	/**
	 * WoonderProduct shortcode callback.
	 *
	 * @param array $atts Shortcode attributes.
	 */
	public function woonder_product( $atts ) {
		global $post;

		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts
		);

		if ( empty( $atts['id'] ) ) {
			return false;
		}

		// Get the product data object, set the product global and capture it in $product variable.
		$product_data = get_post( $atts['id'] );
		$product      = is_object( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ), true ) ? wc_setup_product_data( $product_data ) : false;

		if ( empty( $product ) ) {
			return false;
		}

		ob_start();
		?>
			<div class="woonder-product">
				<a class="woonder-product__content" href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo $product->get_image(); ?>
					<span class="woonder-product__title">
						<?php echo $product->get_title(); ?>
					</span>
					<?php echo $product->get_price_html(); ?>
				</a>
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
		<?php

		// Restore Product global in case this is shown inside a product post.
		wc_setup_product_data( $post );

		return ob_get_clean();
	}
}

$ws_woonder_product = new WS_Woonder_Product();
