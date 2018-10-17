<?php
/**
 * Main navigation in header
 *
 * @package woondershop-pt
 */

?>
<!-- Main navigation. -->
<div class="navigation-bar__container">
	<div class="container">
		<nav class="navigation-bar  js-sticky-desktop-option  navbar-side" id="woondershop-main-navigation" aria-label="<?php esc_html_e( 'Main Menu', 'woondershop-pt' ); ?>">
			<?php
			if ( has_nav_menu( 'main-menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'main-menu',
					'container'      => false,
					'menu_class'     => 'main-navigation  js-main-nav  js-dropdown',
					'walker'         => new Aria_Walker_Nav_Menu(),
					'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
				) );
			}
			?>
		</nav>
		<button class="main-navigation__close  d-lg-none  js-main-navigation-close" type="button" aria-controls="woondershop-main-navigation" aria-expanded="false" aria-label="Close navigation"><i class="fa fa-times" aria-hidden="true"></i></button>
	</div>
</div>
