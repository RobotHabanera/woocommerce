<?php
/**
 * Featured Product Widget
 *
 * @package woondershop-pt
 */

if ( ! class_exists( 'PW_Featured_Product' ) ) {
	class PW_Featured_Product extends WP_Widget {

		// Basic widget settings.
		function widget_id_base() { return 'featured_product'; }
		function widget_name() { return esc_html__( 'Featured Product', 'woondershop-pt' ); }
		function widget_description() { return esc_html__( 'Select a WooCommerce product and display it with some details.', 'woondershop-pt' ); }
		function widget_class() { return 'widget-featured-product'; }

		public function __construct() {
			parent::__construct(
				'pw_' . $this->widget_id_base(),
				sprintf( 'ProteusThemes: %s', $this->widget_name() ),
				array(
					'description' => $this->widget_description(),
					'classname'   => $this->widget_class(),
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$product_id  = empty( $instance['product_id'] ) ? 'none' : $instance['product_id'];
			$product_obj = wc_get_product( $product_id );

			if ( ! empty( $product_id ) && 'none' !== $product_id && is_object( $product_obj ) ) :
				echo $args['before_widget'];
				?>
					<div class="featured-product">
						<a href="<?php echo esc_url( $product_obj->get_permalink() ); ?>" class="featured-product__image">
							<?php echo wp_kses_post( $product_obj->get_image( 'shop_catalog', array( 'class' => 'img-fluid', 'alt' => esc_attr( $product_obj->get_title() ) ) ) ); ?>
						</a>
						<div class="featured-product__content">
							<div class="featured-product__price">
								<?php echo wp_kses_post( $product_obj->get_price_html() ); ?>
							</div>
							<h4 class="featured-product__title">
								<a href="<?php echo esc_url( $product_obj->get_permalink() ); ?>"><?php echo esc_html( $product_obj->get_title() ); ?></a>
							</h4>
							<div class="featured-product__categories">
								<?php echo wp_kses_post( wc_get_product_category_list( $product_obj->get_id() ) ); ?>
							</div>
						</div>
					</div>
				<?php
				echo $args['after_widget'];
			else :
				esc_html_e( 'ProteusThemes - Featured Product widget: No product selected! Please select a WooCommerce product in the widget settings.', 'woondershop-pt' );
			endif;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance The new options.
		 * @param array $old_instance The previous options.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['product_id'] = sanitize_key( $new_instance['product_id'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance The widget options.
		 */
		public function form( $instance ) {
			$product_id = empty( $instance['product_id'] ) ? 'none' : $instance['product_id'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'product_id' ) ); ?>"><?php esc_html_e( 'Product:', 'woondershop-pt' ); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'product_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'product_id' ) ); ?>">
						<option value="none" <?php selected( $product_id, 'none' ); ?>><?php esc_html_e( '-Select product-', 'woondershop-pt' ); ?></option>
					<?php
						$args = array(
							'post_type'   => 'product',
							'post_status' => 'publish',
							'orderby'     => 'title',
							'order'       => 'ASC',
							'nopaging'    => true, // Display all products.
						);
						$loop = new WP_Query( $args );
						while ( $loop->have_posts() ) :
							$loop->the_post();
							$id = get_the_ID();
					?>
							<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $product_id, $id ); ?>><?php the_title(); ?></option>
					<?php
						endwhile;

						// Restore original Post Data.
						wp_reset_postdata();
					?>
				</select>
			</p>

			<?php
		}
	}

	// Only register this widget, if WooCommerce is active.
	if ( WoonderShopHelpers::is_woocommerce_active() ) {
		register_widget( 'PW_Featured_Product' );
	}
}
