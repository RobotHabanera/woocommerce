<?php
/**
 * The page title part of the header
 *
 * @package woondershop-pt
 */

// Regular page id.
$woondershop_bg_id   = WoonderShopHelpers::get_acf_page_id();
$woondershop_blog_id = absint( get_option( 'page_for_posts' ) );

$show_page_title_area = get_field( 'show_page_title_area', $woondershop_bg_id );
if ( ! $show_page_title_area ) {
	$show_page_title_area = 'yes';
}

$show_title = get_field( 'show_title', $woondershop_bg_id );
if ( ! $show_title ) {
	$show_title = 'yes';
}

// Overwrite the settings with single product settings.
if ( WoonderShopHelpers::is_woocommerce_active() && is_woocommerce() && is_product() ) {
	$show_page_title_area  = get_theme_mod( 'single_product_show_header_area', true ) ? 'yes' : 'no';
	$show_title            = get_theme_mod( 'single_product_show_title', false ) ? 'yes' : 'no';
}

$woondershop_style_attr = WoonderShopHelpers::page_header_background_style( $woondershop_bg_id );

if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) {
	$woondershop_style_attr = '';
}

// Show/hide page title area (ACF control - single page && customizer control - all pages).
if ( 'yes' === $show_page_title_area && (bool) get_theme_mod( 'show_page_title_area', true ) ) : ?>

	<div class="page-header" style="<?php echo esc_attr( $woondershop_style_attr ); ?>">
		<?php if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) : ?>
		<div class="container">
		<?php endif; ?>
			<?php
			$woondershop_main_tag = 'h1';

			if ( is_home() || ( is_single() && 'post' === get_post_type() ) ) {
				$woondershop_title    = 0 === $woondershop_blog_id ? esc_html__( 'Blog', 'woondershop-pt' ) : get_the_title( $woondershop_blog_id );

				if ( is_single() ) {
					$woondershop_main_tag = 'h2';
				}
			}
			elseif ( WoonderShopHelpers::is_woocommerce_active() && is_woocommerce() ) {
				ob_start();
				woocommerce_page_title();
				$woondershop_title    = ob_get_clean();

				if ( is_product() ) {
					$woondershop_main_tag = 'h2';
				}
			}
			elseif ( is_category() || is_tag() || is_author() || is_post_type_archive() || is_tax() || is_day() || is_month() || is_year() ) {
				$woondershop_title = get_the_archive_title();
			}
			elseif ( is_search() ) {
				$woondershop_title = esc_html__( 'Search Results For' , 'woondershop-pt' ) . ' &quot;' . get_search_query() . '&quot;';
			}
			elseif ( is_404() ) {
				$woondershop_title = esc_html__( 'Error 404' , 'woondershop-pt' );
			}
			else {
				$woondershop_title    = get_the_title();
			}

			?>

			<?php
			if ( 'yes' === $show_title ) {
				printf( '<%1$s class="page-header__title">%2$s</%1$s>', tag_escape( $woondershop_main_tag ), wp_kses_post( $woondershop_title ) );

				$subtitle = get_field( 'subtitle', $woondershop_bg_id );

				if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) && ! empty( $subtitle ) ) {
					printf( '<p class="page-header__subtitle">%1$s</p>', wp_kses_post( $subtitle ) );
				}
			}
			?>

			<?php
			if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) {
				get_template_part( 'template-parts/breadcrumbs', WoonderShopHelpers::get_skin() );
			}
			?>
		<?php if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) : ?>
		</div>
		<?php endif; ?>
	</div>

<?php endif; ?>
