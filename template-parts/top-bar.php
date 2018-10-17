<?php
/**
 * Top bar used in the theme
 *
 * @package woondershop-pt
 */

$top_left_bar_visibility        = get_theme_mod( 'top_left_bar_visibility', 'hide_mobile' );
$top_left_bar_only_on_homepage  = get_theme_mod( 'top_left_bar_only_on_homepage', false );
$top_right_bar_visibility       = get_theme_mod( 'top_right_bar_visibility', 'hide_mobile' );
$top_right_bar_only_on_homepage = get_theme_mod( 'top_right_bar_only_on_homepage', false );

if ( 'no' !== $top_left_bar_visibility || 'no' !== $top_right_bar_visibility ) : ?>
	<div class="top__container">
		<div class="container">
			<div class="top">
				<?php if ( 'no' !== $top_left_bar_visibility && ( $top_left_bar_only_on_homepage ? is_front_page() : true ) ) : ?>
					<div class="top__left<?php echo 'hide_mobile' === $top_left_bar_visibility ? '  d-none  d-lg-block' : ''; ?>">
						<?php
						if ( is_active_sidebar( 'top-left-widgets' ) ) {
							dynamic_sidebar( apply_filters( 'woondershop_top_left_widgets', 'top-left-widgets', get_the_ID() ) );
						}
						?>
					</div>
				<?php endif; ?>
				<?php if ( 'no' !== $top_right_bar_visibility && ( $top_right_bar_only_on_homepage ? is_front_page() : true ) ) : ?>
					<div class="top__right<?php echo 'hide_mobile' === $top_right_bar_visibility ? '  d-none  d-lg-block' : ''; ?>">
						<?php
						if ( is_active_sidebar( 'top-right-widgets' ) ) {
							dynamic_sidebar( apply_filters( 'woondershop_top_right_widgets', 'top-right-widgets', get_the_ID() ) );
						}
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
