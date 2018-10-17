<?php
/**
 * WooCommerce custom cart widget
 *
 * @package woondershop-pt
 */

if ( ! class_exists( 'PW_Woo_Cart' ) ) {
	class PW_Woo_Cart extends WP_Widget {
		private $widget_id_base, $widget_name, $widget_description, $widget_class;

		public function __construct() {
			$this->widget_id_base     = 'woo_cart';
			$this->widget_class       = 'pt-widget-woo-cart';
			$this->widget_name        = esc_html__( 'Cart', 'woondershop-pt' );
			$this->widget_description = esc_html__( 'WooCommerce cart with items dropdown', 'woondershop-pt' );

			parent::__construct(
				'pw_' . $this->widget_id_base,
				sprintf( 'ProteusThemes: %s', $this->widget_name ),
				array(
					'description' => $this->widget_description,
					'classname'   => $this->widget_class,
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args widget arguments.
		 * @param array $instance widget data.
		 */
		public function widget( $args, $instance ) {
			if ( ! WoonderShopHelpers::is_woocommerce_active() ) {
				return;
			}

			$is_cart_empty            = 0 === WC()->cart->get_cart_contents_count();
			$is_cart_or_checkout_page = is_cart() || is_checkout();

			echo $args['before_widget'];
			?>
				<div class="shopping-cart<?php echo $is_cart_empty ? '  shopping-cart--empty' : '' ?><?php echo $is_cart_or_checkout_page ? '  shopping-cart--disabled' : '  shopping-cart--enabled' ?>">
					<?php if ( $is_cart_or_checkout_page ) : ?>
						<div class="shopping-cart__link">
					<?php else : ?>
						<a href="<?php echo wc_get_cart_url(); ?>" class="shopping-cart__link">
					<?php endif; ?>
							<div class="shopping-cart__icon-container">
								<?php if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) : ?>
									<img src="<?php echo esc_attr( get_template_directory_uri() ) . '/assets/images/cart_icon.svg'; ?>">
									<?php WoonderShopHelpers::woocommerce_cart_number_of_products_fragments(); ?>
								<?php else : ?>
									<i class="shopping-cart__icon  fas  fa-shopping-bag">
										<?php WoonderShopHelpers::woocommerce_cart_number_of_products_fragments(); ?>
									</i>
								<?php endif; ?>
							</div>
							<div class="shopping-cart__text">
								<?php if ( ! empty( $instance['title'] ) ) : ?>
								<div class="shopping-cart__title">
									<?php echo wp_kses_post( $instance['title'] ); ?>
								</div>
								<?php endif; ?>
								<?php if ( WoonderShopHelpers::is_skin_active( apply_filters( 'woondershop_cart_widget_show_price_for_skins', array( 'default' ) ) ) ) : ?>
									<?php WoonderShopHelpers::woocommerce_cart_subtotal_fragment(); ?>
									<?php WoonderShopHelpers::woocommerce_cart_empty_fragment(); ?>
								<?php endif; ?>
							</div>
					<?php if ( $is_cart_or_checkout_page ) : ?>
						</div>
					<?php else : ?>
						</a>
					<?php endif; ?>
					<div class="shopping-cart__content">
						<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
					</div>
				</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance The new options.
		 * @param array $old_instance The previous options.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['title'] = sanitize_text_field( $new_instance['title'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance The widget options.
		 */
		public function form( $instance ) {
			if ( ! WoonderShopHelpers::is_woocommerce_active() ) {
				WoonderShopHelpers::woocommerce_not_active_notice();

				return;
			}

			$title = empty( $instance['title'] ) ? '' : $instance['title'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'woondershop-pt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<?php
		}
	}

	register_widget( 'PW_Woo_Cart' );
}
