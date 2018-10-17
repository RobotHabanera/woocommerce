<?php
/**
 * 404 page
 *
 * @package woondershop-pt
 */

get_header( WoonderShopHelpers::get_skin() );

?>

<div class="content-area  error-404">
	<div class="container">
		<p class="h1  error-404__title">404</p>
		<p class="h2  error-404__subtitle"><?php esc_html_e( 'You landed on the wrong side of the website' , 'woondershop-pt' ); ?></p>
		<p class="error-404__text">
		<?php
			printf(
				/* translators: the first %s for line break, the second and third %s for link to home page wrap */
				esc_html__( 'Page you are looking for is not here. %1$s Go %2$sHome%3$s or try to search:' , 'woondershop-pt' ),
				'<br>',
				'<b><a href="' . esc_url( home_url( '/' ) ) . '">',
				'</a></b>'
			);
		?>
		</p>
		<div class="widget_search">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<?php get_footer( WoonderShopHelpers::get_skin() ); ?>
