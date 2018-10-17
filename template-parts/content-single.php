<?php
/**
 * Template part for displaying single posts.
 *
 * @package woondershop-pt
 */

$reading_time_setting = get_theme_mod( 'reading_time', 'show' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="article__content  clearfix  e-content">
		<!-- Content -->
		<?php the_title( sprintf( '<h1 class="article__title  p-name">', esc_url( get_permalink() ) ), '</h1>' ); ?>

		<div class="article__meta  meta">
			<!-- Author -->
			<span class="meta__item  meta__item--author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
				<span class="author-text"><?php esc_html_e( 'Author:' , 'woondershop-pt' ); ?></span>
				<span class="p-author"><?php the_author(); ?></span>
			</span>
			<!-- Date -->
			<a class="meta__item  meta__item--date" href="<?php the_permalink(); ?>"><time class="dt-published" datetime="<?php the_time( 'c' ); ?>"><?php echo get_the_date(); ?></time></a>
			<?php if ( 'show' === $reading_time_setting ) : ?>
			<!-- Read Time -->
			<span class="meta__item  meta__item--read-time"><?php printf( esc_html__( '%d min read', 'woondershop-pt' ), WoonderShopHelpers::get_read_time( get_the_content() ) ); ?></span>
			<?php endif; ?>
		</div>
		<!-- Featured Image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-fluid  article__featured-image  u-photo' ) ); ?>
		<?php endif; ?>

		<?php the_content(); ?>

		<!-- Multi Page in One Post -->
		<?php
			$woondershop_args = array(
				'before'      => '<div class="multi-page  clearfix">' . /* translators: after that comes pagination like 1, 2, 3 ... 10 */ esc_html__( 'Pages:', 'woondershop-pt' ) . ' &nbsp; ',
				'after'       => '</div>',
				'link_before' => '<span class="btn  btn-primary">',
				'link_after'  => '</span>',
				'echo'        => 1,
			);
			wp_link_pages( $woondershop_args );
		?>
	</div><!-- .article__content -->
	<div class="article__taxonomies">
		<!-- Categories -->
		<?php if ( has_category() ) : ?>
			<div class="article__taxonomies-categories"><?php the_category( ' ' ); ?></div>
		<?php endif; ?>
		<!-- Tags -->
		<?php if ( has_tag() ) : ?>
			<div class="article__taxonomies-tags"><?php the_tags( '', '' ); ?></div>
		<?php endif; ?>
	</div>
</article><!-- .article -->
