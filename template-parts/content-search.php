<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package woondershop-pt
 */

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
			<!-- Read More Link -->
			<span class="article__more-link  more-link"><?php printf( esc_html__( 'Read more %s', 'woondershop-pt' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ); ?></span>
		</div><!-- .article__content -->
	</a>
</article><!-- .asrticle -->
