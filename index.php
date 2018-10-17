<?php
/**
 * The main template file.
 *
 * Main blog page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package woondershop-pt
 */

get_header( WoonderShopHelpers::get_skin() );

$woondershop_sidebar = get_theme_mod( 'blog_sidebar', 'none' );

if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) {
	get_template_part( 'template-parts/page-header', WoonderShopHelpers::get_skin() );
}

?>

	<div id="primary" class="content-area  container">
		<?php get_template_part( 'template-parts/blog-navigation', WoonderShopHelpers::get_skin() ); ?>
		<div class="row">
			<main id="main" class="site-main  article-grid  col-12<?php echo 'left' === $woondershop_sidebar ? '  site-main--left  col-lg-9  order-lg-2' : ''; ?><?php echo 'right' === $woondershop_sidebar ? '  site-main--right  col-lg-9  order-lg-1' : ''; ?>">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						?>
					<?php endwhile; ?>

					<?php
						the_posts_pagination( array(
							'prev_text' => '<i class="prev-icon  fas fa-chevron-left"></i>',
							'next_text' => '<i class="next-icon  fas fa-chevron-right"></i>',
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
