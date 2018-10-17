<?php
/**
 * Template part for displaying blog sidebar
 *
 * @package woondershop-pt
 */

if ( is_single() ) {
	$woondershop_sidebar = get_theme_mod( 'single_post_sidebar', 'none' );
} else {
	$woondershop_sidebar = get_theme_mod( 'blog_sidebar', 'none' );
}

if ( 'none' !== $woondershop_sidebar && is_active_sidebar( 'blog-sidebar' ) ) : ?>
	<div class="col-12  col-lg-3<?php echo 'left' === $woondershop_sidebar ? '  order-lg-1' : ''; ?><?php echo 'right' === $woondershop_sidebar ? '  order-lg-2' : ''; ?>">
		<div class="sidebar<?php echo 'right' === $woondershop_sidebar ? '  sidebar--right' : ''; ?><?php echo 'left' === $woondershop_sidebar ? '  sidebar--left' : ''; ?>" role="complementary">
			<?php dynamic_sidebar( apply_filters( 'woondershop_blog_sidebar', 'blog-sidebar', get_the_ID() ) ); ?>
		</div>
	</div>
<?php endif; ?>
