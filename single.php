<?php
/**
 * The template for displaying all single posts.
 *
 * @package woondershop-pt
 */

get_header( WoonderShopHelpers::get_skin() );

$woondershop_sidebar = get_theme_mod( 'single_post_sidebar', 'none' );

if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) {
	get_template_part( 'template-parts/page-header', WoonderShopHelpers::get_skin() );
}

?>

	<div id="primary" class="content-area  container">
		<div class="row">
			<main id="main" class="site-main  col-12  col-lg-9<?php echo 'left' === $woondershop_sidebar ? '  site-main--left  order-lg-2' : ''; echo 'right' === $woondershop_sidebar ? '  site-main--right  order-lg-1' : ''; echo 'none' === $woondershop_sidebar ? '  site-main--center  offset-lg-2' : ''; ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>

					<!-- Post Navigation -->
					<?php
					$prev_post = get_adjacent_post( false, '', false );
					$next_post = get_adjacent_post( false, '', true );
					?>

					<div class="post-navigation__container">
						<a class="post-navigation  post-navigation--previous" href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>">
							<div class="post-navigation__text  post-navigation__text--previous">
								<?php esc_html_e( 'Previous reading' , 'woondershop-pt' ); ?>
							</div>
							<div class="post-navigation__title  post-navigation__title--previous">
								<?php echo get_the_title( $prev_post ); ?>
							</div>
						</a>
						<a class="post-navigation  post-navigation--next" href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
							<div class="post-navigation__text  post-navigation__text--next">
								<?php esc_html_e( 'Next reading' , 'woondershop-pt' ); ?>
							</div>
							<div class="post-navigation__title  post-navigation__title--next">
								<?php echo get_the_title( $next_post ); ?>
							</div>
						</a>
					</div>

				<?php endwhile; // End of the loop. ?>
			</main>

			<?php get_template_part( 'template-parts/sidebar', 'blog' ); ?>

		</div>
	</div><!-- #primary -->

<?php get_footer( WoonderShopHelpers::get_skin() ); ?>
