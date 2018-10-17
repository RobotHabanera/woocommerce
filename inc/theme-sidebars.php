<?php
/**
 * Register sidebars for WoonderShop
 *
 * @package woondershop-pt
 */

function woondershop_sidebars() {
	// Blog Sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'woondershop-pt' ),
			'id'            => 'blog-sidebar',
			'description'   => esc_html__( 'Sidebar on the blog layout.', 'woondershop-pt' ),
			'class'         => 'blog  sidebar',
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sidebar__headings">',
			'after_title'   => '</h4>',
		)
	);

	// Regular Page Sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Regular Page Sidebar', 'woondershop-pt' ),
			'id'            => 'regular-page-sidebar',
			'description'   => esc_html__( 'Sidebar on the regular page.', 'woondershop-pt' ),
			'class'         => 'sidebar',
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sidebar__headings">',
			'after_title'   => '</h4>',
		)
	);

	// Top Left Widgets
	register_sidebar(
		array(
			'name'          => esc_html__( 'Top Left', 'woondershop-pt' ),
			'id'            => 'top-left-widgets',
			'description'   => esc_html__( 'Top left widget area for Icon Box, Social Icons, Custom Menu or Text widget.', 'woondershop-pt' ),
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
		)
	);

	// Top Right Widgets
	register_sidebar(
		array(
			'name'          => esc_html__( 'Top Right', 'woondershop-pt' ),
			'id'            => 'top-right-widgets',
			'description'   => esc_html__( 'Top right widget area for Icon Box, Social Icons, Custom Menu or Text widget.', 'woondershop-pt' ),
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
		)
	);

	// Header widgets.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header', 'woondershop-pt' ),
			'id'            => 'header-widgets',
			'description'   => esc_html__( 'Header widget area for Cart, Icon Box, Buttons (Textwidget), Social Icons, Search, or Skype Button.', 'woondershop-pt' ),
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
		)
	);

	// Benefit bar widgets.
	if ( WoonderShopHelpers::is_skin_active( array( 'default' ) ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Benefit Bar', 'woondershop-pt' ),
				'id'            => 'benefit-bar-widgets',
				'description'   => esc_html__( 'Benefit bar widget area under main navigation for Icon Box.', 'woondershop-pt' ),
				'before_widget' => '<div class="widget  %2$s">',
				'after_widget'  => '</div>',
			)
		);
	}

	// WooCommerce shop sidebar.
	if ( WoonderShopHelpers::is_woocommerce_active() ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'woondershop-pt' ),
				'id'            => 'shop-sidebar',
				'description'   => esc_html__( 'Sidebar for the shop page', 'woondershop-pt' ),
				'class'         => 'sidebar',
				'before_widget' => '<div class="widget  %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="sidebar__headings">',
				'after_title'   => '</h4>',
			)
		);
	}

	// Footer.
	$footer_widgets_num = count( WoonderShopHelpers::footer_widgets_layout_array() );

	// Only register if not 0.
	if ( $footer_widgets_num > 0 ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer', 'woondershop-pt' ),
				'id'            => 'footer-widgets',
				'description'   => sprintf( esc_html__( 'Footer area works best with %d widgets. This number can be changed in the Appearance &rarr; Customize &rarr; Theme Options &rarr; Footer.', 'woondershop-pt' ), $footer_widgets_num ),
				'before_widget' => '<div class="col-xs-12  col-lg-__col-num__"><div class="widget  %2$s">', // __col-num__ is replaced dynamically in filter 'dynamic_sidebar_params'
				'after_widget'  => '</div></div>',
				'before_title'  => '<h4 class="footer-top__heading">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'woondershop_sidebars' );
