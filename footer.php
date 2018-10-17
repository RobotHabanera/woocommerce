<?php
/**
 * Footer
 *
 * @package woondershop-pt
 */

$woondershop_footer_widgets_layout = WoonderShopHelpers::footer_widgets_layout_array();

$woondershop_footer_bottom_left_txt  = get_theme_mod( 'footer_bottom_left_txt', 'Copyright &copy;' . date( 'Y' ) . ' <strong><a href="https://www.proteusthemes.com/wordpress-themes/woondershop/">ProteusThemes</a></strong>. All Rights Reserved.' );
$woondershop_footer_bottom_right_txt = get_theme_mod( 'footer_bottom_right_txt', '<a class="back-to-top  js-back-to-top" href="#">[fa icon="fas fa-chevron-up"] Back to top</a>' );
$woondershop_footer_credits_txt      = get_theme_mod( 'footer_credits_txt', 'Copyright &copy;' . date( 'Y' ) . ' <strong><a href="https://www.proteusthemes.com/wordpress-themes/woondershop/">ProteusThemes</a></strong>. All Rights Reserved.' );

$back_to_top                 = get_theme_mod( 'back_to_top', 'show' );
$footer_benefit_bar          = get_theme_mod( 'footer_benefit_bar', 'show' );
$footer_benefit_bar_settings = get_theme_mod( 'footer_benefit_bar_settings', array(
	array(
		'icon'  => 'ws ws-delivery-truck',
		'title' => 'Free Delivery',
		'text'  => 'On all orders over $30',
		'url'   => '',
	),
	array(
		'icon'  => 'ws ws-return',
		'title' => 'Free Returns',
		'text'  => 'No questions asked return policy',
		'url'   => '',
	),
	array(
		'icon'  => 'ws ws-chat',
		'title' => 'Need Help? +555 123 4567',
		'text'  => 'Call us on a toll-free phone number',
		'url'   => '',
	),
	array(
		'icon'  => 'ws ws-medal',
		'title' => 'Money Back Guarantee',
		'text'  => 'No questions asked',
		'url'   => '',
	),
) );

?>
	<?php if ( ! is_page_template( 'template-empty.php' ) ) : ?>
	<footer class="footer">
		<?php if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) && 'show' === $footer_benefit_bar && ! empty( $footer_benefit_bar_settings ) ) : ?>
			<div class="footer-benefit-bar__container">
				<div class="container">
					<div class="footer-benefit-bar">
						<?php foreach ( $footer_benefit_bar_settings as $item ) : ?>
							<?php if ( ! empty( $item['url'] ) ) : ?>
								<a href="<?php echo esc_url( $item['url'] ); ?>" class="footer-benefit-bar__item">
							<?php else : ?>
								<div class="footer-benefit-bar__item">
							<?php endif; ?>
								<i class="<?php echo esc_attr( $item['icon'] ); ?> footer-benefit-bar__icon  fa-fw"></i>
								<div class="footer-benefit-bar__text">
									<div class="footer-benefit-bar__title">
										<?php echo wp_kses_post( $item['title'] ); ?>
									</div>
									<div class="footer-benefit-bar__subtitle">
										<?php echo wp_kses_post( $item['text'] ); ?>
									</div>
								</div>
							<?php if ( ! empty( $item['url'] ) ) : ?>
								</a>
							<?php else : ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</a>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) && 'show' === $back_to_top ) : ?>
			<a href="#" class="footer-back-to-top  js-back-to-top">
				<?php esc_html_e( 'Back to top' , 'woondershop-pt' ); ?> <i class="fas fa-arrow-up"></i>
			</a>
		<?php endif; ?>
		<?php if ( ! empty( $woondershop_footer_widgets_layout ) && is_active_sidebar( 'footer-widgets' ) ) : ?>
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<?php dynamic_sidebar( 'footer-widgets' ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="footer-bottom__container">
			<div class="container">
				<div class="footer-bottom">
					<?php if ( ! empty( $woondershop_footer_bottom_left_txt ) ) : ?>
						<div class="footer-bottom__left">
							<?php echo wp_kses_post( do_shortcode( $woondershop_footer_bottom_left_txt ) ); ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $woondershop_footer_bottom_right_txt ) ) : ?>
						<div class="footer-bottom__right">
							<?php echo wp_kses_post( do_shortcode( $woondershop_footer_bottom_right_txt ) ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) : ?>
			<div class="footer-credits__container">
				<div class="container">
					<div class="footer-credits">
						<?php echo wp_kses_post( do_shortcode( $woondershop_footer_credits_txt ) ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</footer>
	<?php endif; ?>
	</div><!-- end of .boxed-container -->

	<?php wp_footer(); ?>
	<div class="woondershop-overlay"></div>
	</body>
</html>
