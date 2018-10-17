<?php
/**
 * Template Name: Front page with slider
 *
 * @package woondershop-pt
 */

get_header( WoonderShopHelpers::get_skin() );

// Only include the slick carousel if we defined some slides.
if ( have_rows( 'slides' ) ) {
	get_template_part( 'template-parts/slick-carousel', WoonderShopHelpers::get_skin() );
}

?>

<div id="primary" class="content-area  container" role="main">
	<div class="article__content">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				the_content();
			}
		}
		?>
	</div>
</div>

<?php get_footer( WoonderShopHelpers::get_skin() ); ?>
