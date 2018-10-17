<?php
/**
 * Template part for displaying page sidebar
 *
 * @package woondershop-pt
 */

$woondershop_sidebar = get_field( 'sidebar' );

if ( ! $woondershop_sidebar ) {
	$woondershop_sidebar = 'left';
}

if ( 'none' !== $woondershop_sidebar && is_active_sidebar( 'regular-page-sidebar' ) ) : ?>
	<div class="col-12  col-lg-3<?php echo 'left' === $woondershop_sidebar ? '  order-lg-1' : ''; ?><?php echo 'right' === $woondershop_sidebar ? '  order-lg-2' : ''; ?>">
		<div class="sidebar<?php echo 'right' === $woondershop_sidebar ? '  sidebar--right' : ''; ?><?php echo 'left' === $woondershop_sidebar ? '  sidebar--left' : ''; ?>" role="complementary">
			<?php dynamic_sidebar( apply_filters( 'woondershop_regular_page_sidebar', 'regular-page-sidebar', get_the_ID() ) ); ?>
		</div>
	</div>
<?php endif; ?>
