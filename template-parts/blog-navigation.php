<?php
/**
 * Blog navigation with the search and categories.
 *
 * @package woondershop-pt
 */

$blog_search_box   = get_theme_mod( 'blog_search_box', 'show' );
$blog_category_box = get_theme_mod( 'blog_category_box', 'show' );

?>

<?php if ( 'show' === $blog_search_box || 'show' === $blog_category_box ) : ?>
<div class="blog-navigation">
	<?php if ( 'show' === $blog_search_box ) : ?>
	<!-- Search -->
	<form class="blog-navigation__search  search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label>
			<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'woondershop-pt' ); ?></span>
			<input type="search" class="form-control  search-form__field" placeholder="<?php esc_html_e( 'Search posts, authors...', 'woondershop-pt' ); ?>" value="<?php the_search_query(); ?>" name="s">
		</label>
		<button type="submit" class="search-form__submit"><i class="fas fa-search" aria-hidden="true"></i></button>
	</form>
	<?php endif; ?>
	<?php if ( 'show' === $blog_category_box ) : ?>
	<!-- Categories -->
	<div class="blog-navigation__categories  blog-categories">
		<p class="blog-categories__title"><?php esc_html_e( 'Category', 'woondershop-pt' ); ?></p>
		<div class="blog-categories__button">
			<div class="blog-categories__current-category">
				<?php

				$current_category = single_cat_title( '', false );

				if ( ! empty( $current_category ) ) {
					echo esc_html( $current_category );
				}
				else {
					esc_html_e( 'All posts', 'woondershop-pt' );
				}

				$blog_url = home_url();

				if ( 'page' == get_option( 'show_on_front' ) ) {
					$blog_page_id = get_option('page_for_posts' );
					if ( ! empty( $blog_page_id ) ) {
						$blog_url = get_permalink( $blog_page_id );
					}
				}

				?>
			</div>
			<button class="blog-categories__toggle  blog-categories__toggle--active">
			</button>
			<div class="blog-categories__dropdown">
				<a href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'All posts', 'woondershop-pt' ); ?></a>
				<?php
					wp_list_categories( array(
						'orderby'    => 'name',
						'style'      => '',
						'separator'  => ''
					) );
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>
