<?php
/**
 * Template Name: Empty Template (no header and footer)
 *
 * @package woondershop-pt
 */

get_header( WoonderShopHelpers::get_skin() );

$woondershop_sidebar = get_field( 'sidebar' );

if ( ! $woondershop_sidebar ) {
	$woondershop_sidebar = 'none';
}

?>

	<div id="primary" class="content-area  container">
		<div class="row">
			<main id="main" class="site-main  col-12<?php echo 'left' === $woondershop_sidebar ? '  site-main--left  col-lg-9  order-lg-2' : ''; ?><?php echo 'right' === $woondershop_sidebar ? '  site-main--right  col-lg-9  order-lg-1' : ''; ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>

				<?php endwhile; // End of the loop. ?>
			</main>

			<?php get_template_part( 'template-parts/sidebar', 'regular-page' ); ?>

		</div>
	</div>

<?php get_footer( WoonderShopHelpers::get_skin() ); ?>
