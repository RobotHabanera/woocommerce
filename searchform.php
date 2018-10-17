<?php
/**
 * Search form
 *
 * @package woondershop-pt
 */

// Get the Smart Search plugin default search widget placeholder text, if the plugin is active.
$search_widget_placeholder = function_exists( 'ysm_get_option' ) ? ysm_get_option( 'default', 'placeholder' ) : esc_html__( 'Search', 'woondershop-pt' );

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'woondershop-pt' ); ?></span>
		<input type="search" class="form-control  search-field" placeholder="<?php echo esc_html( $search_widget_placeholder ); ?>" value="" name="s">
	</label>
	<button type="submit" class="search-submit"><i class="search-submit__icon  fas  fa-search"></i></button>
</form>
