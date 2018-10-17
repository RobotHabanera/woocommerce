<?php
/**
 * Template part for displaying posts.
 *
 * @package woondershop-pt
 */

$article_more_link = get_theme_mod( 'article_more_link', 'show' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="article__container">
		<!-- Featured Image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-fluid  article__featured-image  u-photo' ) ); ?>
		<?php endif; ?>
		<!-- Content Box -->
		<div class="article__content">
			<div class="article__header">
				<!-- Date -->
				<time class="article__date  dt-published" datetime="<?php the_time( 'c' ); ?>"><?php echo get_the_date(); ?></time>
				<!-- Title -->
				<?php the_title( sprintf( '<h2 class="article__title  p-name">', esc_url( get_permalink() ) ), '</h2>' ); ?>
			</div>
			<?php if ( 'show' === $article_more_link ) : ?>
			<!-- Read More Link -->
			<span class="article__more-link  more-link"><?php printf( esc_html__( 'Read more %s', 'woondershop-pt' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ); ?></span>
			<?php endif; ?>
		</div><!-- .article__content -->
	</a>
</article><!-- .article -->
