<?php
/**
 * Mobile header
 *
 * @package woondershop-pt
 */

$is_mobile_cart_shown = get_theme_mod( 'show_mobile_cart_in_header', true ) && WoonderShopHelpers::is_woocommerce_active() && ! is_cart() && ! is_checkout();
$is_mobile_search_shown = get_theme_mod( 'show_mobile_search_in_header', true );

?>

<div class="header-mobile__container  d-lg-none">
	<?php if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) : ?>
	<div class="container">
	<?php endif; ?>
		<div class="header-mobile">
			<?php if ( has_nav_menu( 'main-menu' ) ) : ?>
				<!-- Toggle button for Main Navigation on mobile -->
				<button class="header-mobile__navbar-toggler  js-header-navbar-toggler  js-sticky-mobile-option" type="button" aria-controls="woondershop-main-navigation" aria-expanded="false" aria-label="Toggle navigation"><i class="fas  fa-bars  hamburger"></i></button>
			<?php endif;?>
			<?php get_template_part( 'template-parts/header/logo', 'mobile' ); ?>
			<?php if ( true === $is_mobile_search_shown ) : ?>
				<!-- Search on mobile -->
				<button class="header-mobile__search-toggler  js-header-search-toggler" type="button" aria-controls="woondershop-mobile-search" aria-expanded="false" aria-label="Toggle search"><i class="fa  fa-search" aria-hidden="true"></i></button>
			<?php endif; ?>
			<?php if ( true === $is_mobile_cart_shown ) : ?>
				<!-- Cart on mobile -->
				<button class="header-mobile__cart-toggler  js-header-cart-toggler" type="button" aria-controls="woondershop-mobile-cart" aria-expanded="false" aria-label="Toggle cart">
					<?php if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) : ?>
						<img src="<?php echo esc_attr( get_template_directory_uri() ) . '/assets/images/cart_icon.svg'; ?>">
						<?php WoonderShopHelpers::woocommerce_cart_number_of_products_fragments(); ?>
					<?php else : ?>
						<i class="fa  fa-shopping-bag" aria-hidden="true">
							<?php WoonderShopHelpers::woocommerce_cart_number_of_products_fragments(); ?>
						</i>
					<?php endif; ?>
				</button>
			<?php endif; ?>
		</div>
	<?php if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) : ?>
	</div>
	<?php endif; ?>
</div>

<div class="header-mobile__overlay-elements">
<?php
	// these elements must be outside the header-mobile because of the z-index and black overlay
	if ( true === $is_mobile_search_shown ) :
?>
	<div class="header-mobile__search  mobile-search">
		<div class="mobile-search__header">
			<div class="mobile-search__title">
				<?php esc_html_e( 'Search' , 'woondershop-pt' ); ?>
			</div>
			<button class="mobile-search__close  js-mobile-search-close" type="button" aria-controls="woondershop-mobile-search" aria-expanded="false" aria-label="Close search"><i class="fa fa-times" aria-hidden="true"></i></button>
		</div>
		<div class="mobile-search__form" id="woondershop-mobile-search">
			<?php
			// Using the widget instead of get_search_form function, because the auto-suggest feature works only on search widgets.
			the_widget( 'WP_Widget_Search', 'title=' );
			?>
		</div>
	</div>
<?php
	endif;
	if ( true === $is_mobile_cart_shown ) :
?>
	<div class="header-mobile__cart  mobile-cart" id="woondershop-mobile-cart">
		<div class="mobile-cart__header">
			<div class="mobile-cart__title">
				<?php esc_html_e( 'Shopping cart' , 'woondershop-pt' ); ?>
			</div>
			<div class="mobile-cart__subtotal">
				<?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?>
			</div>
		</div>
		<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
	</div>
	<button class="mobile-cart__close  js-mobile-cart-close" type="button" aria-controls="woondershop-mobile-cart" aria-expanded="false" aria-label="Close cart"><i class="fa  fa-times" aria-hidden="true"></i></button>
<?php
	endif;
?>
</div>
