<?php
/**
 * Breadcrumbs template used in the theme
 *
 * @package woondershop-pt
 */

$woondershop_page_id = WoonderShopHelpers::get_acf_page_id();
$show_breadcrumbs    = WoonderShopHelpers::show_breadcrumbs( $woondershop_page_id );

if ( function_exists( 'bcn_display' ) && ! empty( $show_breadcrumbs ) ) : ?>
	<div class="breadcrumbs">
		<?php bcn_display(); ?>
	</div>
<?php endif; ?>
