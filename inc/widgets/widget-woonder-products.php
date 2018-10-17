<?php
/**
 * Feature rich WooCommerce products widget.
 *
 * @package woondershop-pt
 */

if ( ! class_exists( 'PW_Woonder_Products' ) ) {
	class PW_Woonder_Products extends WP_Widget {
		private $widget_id_base, $widget_name, $widget_description, $widget_class;

		public function __construct() {
			$this->widget_id_base     = 'woonder_products';
			$this->widget_class       = 'pt-widget-woonder-products';
			$this->widget_name        = esc_html__( 'Woonder Products', 'woondershop-pt' );
			$this->widget_description = esc_html__( 'Feature rich WooCommerce products widget.', 'woondershop-pt' );

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
			global $post;

			if ( ! WoonderShopHelpers::is_woocommerce_active() ) {
				return;
			}

			$widget_id = 'woonder-products-' . esc_attr( uniqid( $args['widget_id'] . '-' ) );

			$product_args = [
				'status' => ['publish'],
				'limit'  => intval( $instance['number_of_products'] ),
			];

			if ( ! empty( $instance['product_category'] ) && ! array_key_exists( 'all', $instance['product_category'] ) ) {
				$product_args['category'] = array_keys( $instance['product_category'] );
			}

			switch ( $instance['product_type'] ) {
				// "recent" use case is covered by default.
				case 'best-selling':
					$product_args['meta_key'] = 'total_sales';
					$product_args['orderby']  = 'meta_value_num';
					break;

				case 'top-rated':
					$product_args['meta_key'] = '_wc_average_rating';
					$product_args['orderby']  = 'meta_value_num';
					break;

				case 'featured':
					$product_args['tax_query'][] = array(
						'taxonomy'         => 'product_visibility',
						'terms'            => 'featured',
						'field'            => 'name',
						'operator'         => 'IN',
						'include_children' => false,
					);
					break;

				case 'on-sale':
					$product_args['include'] = wc_get_product_ids_on_sale();
					break;
			}

			$products = wc_get_products( $product_args );

			$slick_data = [];

			if ( ! empty( $instance['use_as_slider'] ) ) {
				$slick_data = array(
					'prevArrow'      => '<button type="button" class="woonder-products__arrow  woonder-products__arrow--prev  slick-prev  slick-arrow"><span class="screen-reader-text">' . esc_html__( 'Previous', 'woondershop-pt' ) . '</span><i class="fas fa-chevron-left" aria-hidden="true"></i></button>',
					'nextArrow'      => '<button type="button" class="woonder-products__arrow  woonder-products__arrow--next  slick-next  slick-arrow"><span class="screen-reader-text">' . esc_html__( 'Next', 'woondershop-pt' ) . '</span><i class="fas fa-chevron-right" aria-hidden="true"></i></button>',
					'appendArrows'   => '#' . $widget_id . ' .js-woonder-products-carousel-navigation',
					'slidesToShow'   => $instance['number_of_products_per_slide'],
					'responsive' => array(
						array(
							'breakpoint' => 992,
							'settings' => array(
								'slidesToShow' => 2,
							),
						),
					),
				);

				// New settings for Jungle skin mobile slider.
				if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) {
					$slick_data['responsive'] = array(
						array(
							'breakpoint' => 992,
							'settings'   => array(
								'slidesToShow'  => 2,
								'dots'          => true,
								'centerMode'    => true,
								'centerPadding' => '15% 0 0',
								'swipeToSlide'  => true,
							),
						),
					);
				}

				$slick_data = apply_filters( 'pt-woondershop/slick_carousel_woonder_products_data', $slick_data );
			}

			echo $args['before_widget'];
			?>
			<div class="woonder-products__container" id="<?php echo esc_attr( $widget_id ); ?>">
				<div class="woonder-products<?php echo ! empty( $slick_data ) ? '  js-woonder-products-slick-carousel' : '' ?>" <?php echo ! empty( $slick_data ) ? "data-slick='" . wp_json_encode( $slick_data ) . "'" : ''; ?>>
					<?php foreach( $products as $product ) : ?>
						<?php
						// Setup the WC product as global, so we can use loop functions.
						$product = wc_setup_product_data( $product->get_id() );
						?>
						<div class="woonder-products__item">
							<a href="<?php echo esc_url( $product->get_permalink() ) ?>" class="woonder-product">
								<?php echo $product->get_image(); ?>
								<?php if ( $product->is_on_sale() ) : ?>
									<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="woonder-product__onsale  onsale">' . esc_html__( 'Sale!', 'woondershop-pt' ) . '</span>', $product, $product ); ?>
								<?php endif; ?>
								<div class="woonder-product__title"><?php echo wp_kses_post( $product->get_title() ); ?></div>
								<div class="woonder-product__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
							</a>
							<?php
							if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) {
								woocommerce_template_loop_add_to_cart( array(
									'class' => implode( ' ', array_filter( array(
										'woonder-product__button',
										'button',
										'product_type_' . $product->get_type(),
										$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
										$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
									) ) ),
								) );
							}
							?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if ( ! empty( $slick_data ) ) : ?>
					<div class="woonder-products__navigation  js-woonder-products-carousel-navigation"></div>
				<?php endif; ?>
			</div>
			<?php
			echo $args['after_widget'];

			// Restore Product global in case this is shown inside a product post.
			wc_setup_product_data( $post );
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance The new options.
		 * @param array $old_instance The previous options.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['product_type']                 = sanitize_key( $new_instance['product_type'] );
			$instance['product_category']             = $new_instance['product_category'];
			$instance['number_of_products']           = absint( WoondershopHelpers::bound( $new_instance['number_of_products'], 0, 20 ) );
			$instance['use_as_slider']                = ! empty( $new_instance['use_as_slider'] ) ? sanitize_key( $new_instance['use_as_slider'] ) : '';
			$instance['number_of_products_per_slide'] = absint( WoondershopHelpers::bound( $new_instance['number_of_products_per_slide'], 0, 10 ) );

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

			$product_type                 = empty( $instance['product_type'] ) ? 'recent' : $instance['product_type'];
			$checked_product_categories   = empty( $instance['product_category'] ) ? ['all' => 'on'] : $instance['product_category'];
			$number_of_products           = empty( $instance['number_of_products'] ) ? 4 : $instance['number_of_products'];
			$use_as_slider                = empty( $instance['use_as_slider'] ) ? '' : $instance['use_as_slider'];
			$number_of_products_per_slide = empty( $instance['number_of_products_per_slide'] ) ? 4 : $instance['number_of_products_per_slide'];

			$product_categories = get_terms( [ 'taxonomy' => 'product_cat' ] );

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'product_type' ) ); ?>"><?php esc_html_e( 'Product type:', 'woondershop-pt' ); ?></label> <br>
				<select id="<?php echo esc_attr( $this->get_field_id( 'product_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'product_type' ) ); ?>">
					<option value="recent" <?php selected( $product_type, 'recent' ); ?>><?php esc_html_e( 'Recently added', 'woondershop-pt' ); ?></option>
					<option value="best-selling" <?php selected( $product_type, 'best-selling' ); ?>><?php esc_html_e( 'Best selling', 'woondershop-pt' ); ?></option>
					<option value="top-rated" <?php selected( $product_type, 'top-rated' ); ?>><?php esc_html_e( 'Top rated', 'woondershop-pt' ); ?></option>
					<option value="featured" <?php selected( $product_type, 'featured' ); ?>><?php esc_html_e( 'Featured', 'woondershop-pt' ); ?></option>
					<option value="on-sale" <?php selected( $product_type, 'on-sale' ); ?>><?php esc_html_e( 'On sale', 'woondershop-pt' ); ?></option>
				</select>
			</p>

			<p>
				<label><?php esc_html_e( 'In category:', 'woondershop-pt' ); ?></label>
				<br>
				<span class="single-product-category">
					<input class="checkbox" type="checkbox" <?php checked( $checked_product_categories['all'], 'on' ) ?> id="<?php echo $this->get_field_id( 'product_category' ) . '-all'; ?>" name="<?php echo $this->get_field_name( 'product_category' ) . '[all]'; ?>" value="on" />
					<label for="<?php echo $this->get_field_id( 'product_category' ) . '-all'; ?>"><?php esc_html_e( 'All', 'woondershop-pt' ); ?></label>
				</span>
				<?php foreach ( $product_categories as $category ) : ?>
					<span class="single-product-category">
						<input class="checkbox" type="checkbox" <?php
							if ( array_key_exists( $category->slug, $checked_product_categories ) ) {
								checked( $checked_product_categories[ $category->slug ], 'on' );
							}
						?> id="<?php echo $this->get_field_id( 'product_category' ) . '-' . $category->slug; ?>" name="<?php echo $this->get_field_name( 'product_category' ) . '[' . $category->slug . ']'; ?>" value="on" />
						<label for="<?php echo $this->get_field_id( 'product_category' ) . '-' . $category->slug; ?>"><?php echo esc_html( $category->name ); ?></label>
					</span>
				<?php endforeach; ?>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_products' ) ); ?>"><?php esc_html_e( 'Number of products to display:', 'woondershop-pt' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'number_of_products' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_products' ) ); ?>" type="number" min="1" max="30" value="<?php echo esc_attr( $number_of_products ); ?>" />
			</p>

			<p>
				<input class="checkbox  js-use-as-slider" type="checkbox" <?php checked( $use_as_slider, 'on' ) ?> id="<?php echo $this->get_field_id( 'use_as_slider' ); ?>" name="<?php echo $this->get_field_name( 'use_as_slider' ); ?>" value="on" />
				<label for="<?php echo $this->get_field_id( 'use_as_slider' ); ?>"><?php esc_html_e( 'Display products in a slider!', 'woondershop-pt' ); ?></label>
			</p>

			<p class="js-number-of-products-per-slide-control">
				<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_products_per_slide' ) ); ?>"><?php esc_html_e( 'Number of products per slide:', 'woondershop-pt' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'number_of_products_per_slide' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_products_per_slide' ) ); ?>" type="number" min="1" max="10" value="<?php echo esc_attr( $number_of_products_per_slide ); ?>" />
			</p>

			<script type="text/javascript">
				(function( $ ) {
					// Show/hide number per slide control on load (this change event will be caught in the admin.js).
					$( '.js-use-as-slider' ).change();
				})( jQuery );
			</script>

			<?php
		}
	}

	register_widget( 'PW_Woonder_Products' );
}
