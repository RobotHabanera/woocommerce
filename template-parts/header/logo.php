<?php
/**
 * Show (or not) logo in header
 *
 * @package woondershop-pt
 */

$woondershop_logo = get_theme_mod( 'logo_img', false );
$woondershop_logo2x = get_theme_mod( 'logo2x_img', false );

?>
<!-- Logo -->
<a class="header__logo<?php echo empty( $woondershop_logo ) ? '  header__logo--text' : '  header__logo--image'; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
<?php if ( ! empty( $woondershop_logo ) ) : ?>
	<img src="<?php echo esc_url( $woondershop_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" srcset="<?php echo esc_attr( $woondershop_logo ); ?><?php echo empty( $woondershop_logo2x ) ? '' : ', ' . esc_url( $woondershop_logo2x ) . ' 2x'; ?>" class="img-fluid  header__logo-image" <?php echo WoonderShopHelpers::get_logo_dimensions(); ?> />
<?php else : ?>
	<h1 class="h1  header__logo-text"><?php bloginfo( 'name' ); ?></h1>
<?php endif; ?>
</a>
