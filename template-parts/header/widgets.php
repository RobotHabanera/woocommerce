<?php
/**
 * Widgets in header
 *
 * @package woondershop-pt
 */

$header_widget_area_visibility = get_theme_mod( 'header_widget_area_visibility', 'hide_mobile' );
$header_widget_area_only_on_homepage = get_theme_mod( 'header_widget_area_only_on_homepage', false );

?>
<?php if ( 'no' !== $header_widget_area_visibility && ( $header_widget_area_only_on_homepage ? is_front_page() : true ) ) : ?>
	<!-- Header widget area -->
	<div class="header__widgets<?php echo 'hide_mobile' === $header_widget_area_visibility ? '  d-none  d-lg-flex' : ''; ?>">
		<?php dynamic_sidebar( apply_filters( 'woondershop_header_widgets', 'header-widgets', get_the_ID() ) ); ?>
	</div>
<?php endif; ?>
