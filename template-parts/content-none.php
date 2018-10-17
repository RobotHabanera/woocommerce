<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package woondershop-pt
 */

?>

<section class="no-results  not-found">
	<header>
		<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'woondershop-pt' ); ?></h2>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php echo wp_kses( sprintf( esc_html__( 'Ready to publish your first post? %1$sGet started here%2$s.', 'woondershop-pt' ), '<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">', '</a>' ), array( 'a' => array( 'href' => array() ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'woondershop-pt' ); ?>
			</p>
			<div class="widget_search">
				<?php get_search_form(); ?>
			</div>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'woondershop-pt' ); ?></p>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
