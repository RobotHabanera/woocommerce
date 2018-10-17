<?php
/**
 * The Header for WoonderShop Theme
 *
 * @package woondershop-pt
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php endif; ?>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>
	<div class="boxed-container<?php echo ( is_single() && 'post' === get_post_type() ) ? '  h-entry' : ''; ?>">

	<?php if ( ! is_page_template( 'template-empty.php' ) ) : ?>

	<?php get_template_part( 'template-parts/top-bar', WoonderShopHelpers::get_skin() ); ?>

	<?php get_template_part( 'template-parts/header/mobile', WoonderShopHelpers::get_skin() ); ?>

	<!-- Header with logo and header widgets. -->
	<header class="header__container">
		<div class="container">
			<div class="header  header--default">
				<?php get_template_part( 'template-parts/header/logo', 'desktop' ); ?>
				<?php get_template_part( 'template-parts/header/widgets', WoonderShopHelpers::get_skin() ); ?>
			</div>
		</div>
	</header>

	<?php get_template_part( 'template-parts/header/navigation-bar', WoonderShopHelpers::get_skin() ); ?>

	<?php
	if ( WoonderShopHelpers::is_skin_active( array( 'jungle' ) ) ) {
		get_template_part( 'template-parts/breadcrumbs', WoonderShopHelpers::get_skin() );
	}
	?>


	<?php endif; ?>
