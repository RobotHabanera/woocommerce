<?php
/**
 * Search results page
 *
 * @package woondershop-pt
 */

get_header( WoonderShopHelpers::get_skin() );

$woondershop_sidebar = get_theme_mod( 'blog_sidebar', 'none' );

?>

	<div id="primary" class="content-area  container">

		<?php get_template_part( 'template-parts/blog-navigation', WoonderShopHelpers::get_skin() ); ?>

		<div class="row">
			<main id="main" class="site-main  article-grid  col-12<?php echo 'left' === $woondershop_sidebar ? '  site-main--left  col-lg-9  order-lg-2' : ''; ?><?php echo 'right' === $woondershop_sidebar ? '  site-main--right  col-lg-9  order-lg-1' : ''; ?>">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'template-parts/content', 'search' ); ?>

					<?php endwhile; ?>

					<?php
						the_posts_pagination( array(
							'prev_text' => '<i class="fas  fa-chevron-left"></i>',
							'next_text' => '<i class="fas  fa-chevron-right"></i>',
						) );
					?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>
			</main>

			<?php get_template_part( 'template-parts/sidebar', 'blog' ); ?>

		</div>
	</div>

<?php get_footer( WoonderShopHelpers::get_skin() ); ?>
