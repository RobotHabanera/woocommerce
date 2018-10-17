<?php
/**
 * Benefit bar widgets in header
 *
 * @package woondershop-pt
 */

$benefit_bar_visibility = get_theme_mod( 'benefit_bar_visibility', 'yes' );
$benefit_bar_only_on_homepage = get_theme_mod( 'benefit_bar_only_on_homepage', true );

?>
<?php if ( 'no' !== $benefit_bar_visibility && ( $benefit_bar_only_on_homepage ? is_front_page() : true ) ) : ?>
	<div class="benefit-bar__container">
		<div class="container">
			<div class="benefit-bar<?php echo 'hide_mobile' === $benefit_bar_visibility ? '  d-none  d-lg-flex' : ''; ?>">
				<?php dynamic_sidebar( apply_filters( 'woondershop_benefit_bar_widgets', 'benefit-bar-widgets', get_the_ID() ) ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
