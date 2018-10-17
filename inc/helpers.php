<?php
/**
 * Helper functions
 *
 * @package woondershop-pt
 */

/**
 * WoonderShopHelpers class with static methods
 */
class WoonderShopHelpers {
	/**
	 * Get logo dimensions from the db
	 *
	 * @param  string $theme_mod theme mod where the array with width and height is saved.
	 * @return mixed             string or FALSE
	 */
	static function get_logo_dimensions( $theme_mod = 'logo_dimensions_array' ) {
		$width_height_array = get_theme_mod( $theme_mod );

		if ( is_array( $width_height_array ) && 2 === count( $width_height_array ) ) {
			return sprintf( ' width="%d" height="%d" ', absint( $width_height_array['width'] ), absint( $width_height_array['height'] ) );
		}

		return '';
	}


	/**
	 * The comments_number() does not use _n function, here we are to fix that
	 */
	static function pretty_comments_number() {
		global $post;
		printf(
			/* translators: %s represents a number */
			_n( '%s Comment', '%s Comments', get_comments_number(), 'woondershop-pt' ), number_format_i18n( get_comments_number() )
		);
	}


	/**
	 * Check if WooCommerce is active
	 *
	 * @return boolean
	 */
	public static function is_woocommerce_active() {
		return apply_filters( 'woondershop_is_woocommerce_active', class_exists( 'Woocommerce' ) );
	}


	/**
	 * The general "WooCommerce is not active" notice.
	 */
	public static function woocommerce_not_active_notice() {
		?>
			<p><?php esc_html_e( 'The WooCommerce plugin has to be active in order to use this feature! Please activate the WooCommerce plugin.', 'woondershop-pt' ); ?></p>
		<?php
	}


	/**
	 * Output a link to the WooCommerce cart including the number of items present and the cart total
	 */
	public static function woocommerce_cart_subtotal_fragment() {
		$is_cart_empty = 0 === WC()->cart->get_cart_contents_count();
		?>
				<div class="shopping-cart__price">
					<?php if ( ! $is_cart_empty ) : ?>
						<?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?>
					<?php endif; ?>
				</div>
		<?php
	}

	/**
	 * Output a link to the WooCommerce cart including the number of items present and the cart total
	 */
	public static function woocommerce_cart_empty_fragment() {
		$is_cart_empty = 0 === WC()->cart->get_cart_contents_count();
		?>
				<div class="shopping-cart__subtitle">
					<?php if ( $is_cart_empty ) : ?>
						<?php esc_html_e( 'is empty', 'woondershop-pt' ); ?>
					<?php endif; ?>
				</div>
		<?php
	}


	/**
	 * Output the number of products in the WooCommerce cart.
	 */
	public static function woocommerce_cart_number_of_products_fragments() {
		$count = WC()->cart->get_cart_contents_count();
		$class = 'woondershop-cart-quantity--one-number';

		if ( 9 < $count && 99 >= $count ) {
			$class = 'woondershop-cart-quantity--two-numbers';
		}
		else if ( 99 < $count ) {
			$class = 'woondershop-cart-quantity--two-numbers-plus';
		}

		?>
			<span class="woondershop-cart-quantity  <?php echo esc_attr( $class ); ?>">
				<?php echo esc_html( $count ); ?>
			</span>
		<?php
	}


	/**
	 * Return array of the number which represent the layout of the footer.
	 *
	 * @return array
	 */
	static function footer_widgets_layout_array() {
		$layout = get_theme_mod( 'footer_widgets_layout', '[4,6,8]' );
		$layout = json_decode( $layout );

		if ( is_array( $layout ) && ! empty( $layout ) ) {
			$spans = array( (int) $layout[0] );

			for ( $i = 0; $i < ( count( $layout ) - 1 ); $i++ ) {
				$spans[] = $layout[ $i + 1 ] - $layout[ $i ];
			}

			$spans[] = 12 - $layout[ $i ];

			return $spans;
		}
		elseif ( 1 === $layout ) { // Single column.
			return array( '12' );
		}

		// Default: disable footer.
		return array();
	}

	/**
	 * Return url with Google Fonts.
	 *
	 * @see https://github.com/grappler/wp-standard-handles/blob/master/functions.php
	 * @return string Google fonts URL for the theme.
	 */
	static function google_web_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = array( 'latin' );

		$fonts = apply_filters( 'woondershop_pre_google_web_fonts', $fonts );

		foreach ( $fonts as $key => $value ) {
			$fonts[ $key ] = $key . ':' . implode( ',', $value );
		}

		/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
		$subset = esc_html_x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'woondershop-pt' );
		if ( 'cyrillic' == $subset ) {
			array_push( $subsets, 'cyrillic', 'cyrillic-ext' );
		} elseif ( 'greek' == $subset ) {
			array_push( $subsets, 'greek', 'greek-ext' );
		} elseif ( 'devanagari' == $subset ) {
			array_push( $subsets, 'devanagari' );
		} elseif ( 'vietnamese' == $subset ) {
			array_push( $subsets, 'vietnamese' );
		}

		$subsets = apply_filters( 'woondershop_subsets_google_web_fonts', $subsets );

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( implode( ',', array_unique( $subsets ) ) ),
				),
				'//fonts.googleapis.com/css'
			);
		}

		return apply_filters( 'woondershop_google_web_fonts_url', $fonts_url );
	}


	/**
	 * Prepare the srcset attribute value.
	 *
	 * @param int   $img_id ID of the image.
	 * @param array $sizes array of the image sizes. Example: $sizes = array( 'jumbotron-slider-s', 'jumbotron-slider-l' );.
	 * @uses http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src
	 * @return string
	 */
	static function get_image_srcset( $img_id, $sizes ) {
		$srcset = array();

		foreach ( $sizes as $size ) {
			$img = wp_get_attachment_image_src( absint( $img_id ), $size );
			$srcset[] = sprintf( '%s %sw', $img[0], $img[1] );
		}

		return implode( ', ' , $srcset );
	}


	/**
	 * Create a style for the HTML attribute from the array of the CSS properties
	 *
	 * @param array $attrs array with CSS settings.
	 * @return string of the background style (CSS)
	 */
	static function create_background_style_attr( $attrs ) {
		$bg_style = array();

		if ( ! empty( $attrs ) ) {
			foreach ( $attrs as $key => $value ) {
				$trimmed_val = trim( $value );
				if ( ! empty( $trimmed_val ) ) {
					if ( 'background-image' === $key ) {
						$bg_style[] = $key . ': url(' . esc_url( $trimmed_val ) . ')';
					}
					elseif ( 'background-color' === $key && ! array_key_exists( 'background-image', $attrs ) ) {
						// To overwrite the pattern set in customizer.
						$bg_style[] = 'background: ' . $trimmed_val;
					}
					else {
						$bg_style[] = $key . ': ' . $trimmed_val;
					}
				}
			}
		}

		if ( empty( $bg_style ) ) {
			return '';
		}
		else {
			return join( '; ', $bg_style );
		}

	}


	/**
	 * Custom wp_list_comments callback (template)
	 *
	 * @param obj   $comment WP comment object.
	 * @param array $args comment arguments.
	 * @param int   $depth WP comment depth.
	 */
	static function custom_comment( $comment, $args, $depth ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>

		<<?php echo tag_escape( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( array( 'clearfix', empty( $args['has_children'] ) ? '' : 'parent' ) ); ?>>
			<div class="comment__content">
				<div class="comment__inner">
					<div class="comment__avatar">
						<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
					</div>
					<div class="comment__metadata">
						<?php comment_reply_link( array_merge( $args, array(
							'depth' => $depth,
							'before' => '',
						) ) ); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'woondershop-pt' ), '' ); ?>
					</div>
					<cite class="comment__author  vcard">
						<?php echo get_comment_author_link(); ?>
					</cite><span>,</span>
					<time class="comment__date" datetime="<?php comment_time( 'c' ); ?>">
						<?php comment_date( 'F j, Y' ); ?>
					</time>
					<div class="comment__text">
						<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment__awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.' , 'woondershop-pt' ); ?></p>
						<?php endif; ?>

						<?php comment_text(); ?>
					</div>
				</div>

		<?php
	}


	/**
	 * Helper function to get terms (categories) for custom post types
	 *
	 * @param  int    $post_id ID of the post.
	 * @param  string $taxonomy taxonomy name.
	 * @return array
	 */
	public static function get_custom_categories( $post_id, $taxonomy ) {
		$out   = array();
		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! is_array( $terms ) ) {
			return array();
		}

		foreach ( $terms as $term ) {
			$out[ $term->slug ] = $term->name;
		}

		return $out;
	}


	/**
	 * Get the post excerpt. If post_excerpt data is defined use that, otherwise
	 * trim down the content to the proper size.
	 *
	 * @param string $post_excerpt post excerpt text.
	 * @param string $post_content post content text.
	 * @param int    $excerpt_length length of the excerpt.
	 * @return string
	 */
	public static function get_post_excerpt( $post_excerpt, $post_content, $excerpt_length = 55 ) {
		$excerpt      = empty( $post_excerpt ) ? $post_content : $post_excerpt;
		$excerpt      = strip_shortcodes( $excerpt );
		$excerpt      = wp_strip_all_tags( $excerpt );
		$excerpt      = str_replace( ']]>', ']]&gt;', $excerpt );
		$excerpt_more = apply_filters( 'excerpt_more', '[&hellip;]' );
		$excerpt      = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );

		return $excerpt;
	}


	/**
	 * Return correct path to the file (check child theme first)
	 *
	 * @param string $relative_file_path relative path to the file.
	 * @return string, absolute path of the correct file.
	 */
	public static function get_correct_file_path( $relative_file_path ) {
		if ( file_exists( get_stylesheet_directory() . $relative_file_path ) ) {
			return get_stylesheet_directory() . $relative_file_path;
		}
		elseif ( file_exists( get_template_directory() . $relative_file_path ) ) {
			return get_template_directory() . $relative_file_path;
		}
		else {
			return false;
		}
	}


	/**
	 * Require the correct file with require_once (checks child theme first)
	 *
	 * @param string $relative_file_path relative path to the file.
	 */
	public static function load_file( $relative_file_path ) {
		require_once self::get_correct_file_path( $relative_file_path );
	}


	/**
	 * Bound an integer between two numbers
	 *
	 * @param int $input number to evaluate.
	 * @param int $min minimal allowed number.
	 * @param int $max maximal allowed number.
	 */
	public static function bound( $input, $min, $max ) {
		return min( max( $input, $min ), $max );
	}


	/**
	 * Create appropriate page header background style.
	 *
	 * @param string $bg_id page ID for which the header style should be build for.
	 */
	public static function page_header_background_style( $bg_id ) {

		$style_array = array();

		if ( get_field( 'background_image', $bg_id ) ) {
			$style_array = array(
				'background-image'      => get_field( 'background_image', $bg_id ),
				'background-position'   => get_field( 'background_image_horizontal_position', $bg_id ) . ' ' . get_field( 'background_image_vertical_position', $bg_id ),
				'background-repeat'     => get_field( 'background_image_repeat', $bg_id ),
				'background-attachment' => get_field( 'background_image_attachment', $bg_id ),
			);
		}

		$style_array['background-color'] = get_field( 'background_color', $bg_id );

		// Create the style tag to use in the .page-header element.
		return self::create_background_style_attr( $style_array );
	}


	/**
	 * Return the correct page ID.
	 * WPML support.
	 *
	 * @param mixed [string|int] $original_id Original ID.
	 */
	public static function get_page_id( $original_id ) {
		if ( function_exists( 'icl_object_id' ) ) {
			return icl_object_id( $original_id, 'page', true );
		}

		return $original_id;
	}


	/**
	 * Get the author posts link with author display name (also works outside the WP loop).
	 *
	 * @param string $class String of classes that will be added to the link.
	 */
	public static function get_author_posts_link( $class = '' ) {
		global $post;

		$author_id   = $post->post_author;
		$author_url  = get_author_posts_url( $author_id );
		$author_name = get_the_author_meta( 'display_name', $author_id );

		ob_start();
		?>
			<a class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $author_url ); ?>" title="<?php echo esc_html__( 'Posted by', 'woondershop-pt' ) . ' ' . esc_html( $author_name ); ?>" rel="author"><?php echo esc_html( $author_name ); ?></a>
		<?php
		$output = ob_get_clean();

		return $output;
	}


	/**
	 * Return the reading time in minutes of the supplied content.
	 *
	 * @param string $content The content to calculate the reading time for.
	 *
	 * @return int
	 */
	public static function get_read_time( $content ) {
		$avg_read_time = apply_filters( 'woondershop_average_reading_time', 200 );

		$number_of_words = str_word_count( wp_strip_all_tags( $content ) );

		return (int) ceil( $number_of_words / $avg_read_time );
	}


	/**
	 * Convert a hex color to rgb (array).
	 *
	 * @param string $hex The hex code of a color.
	 *
	 * @return array
	 */
	public static function hex2rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		}
		else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		return array( $r, $g, $b );
	}


	/**
	 * Get the correct Font Awesome 5 class string.
	 *
	 * @param string $class_string The string to filter through.
	 *
	 * @return string
	 */
	public static function get_full_fa_class( $class_string ) {
		$allowed_prefix = [ 'fas', 'far', 'fab' ];
		$class_words    = explode( ' ', $class_string );

		// Remove 'fa' class from the string ('fa' is no longer used in FAv5).
		if ( in_array( 'fa', $class_words, true ) ) {
			$class_words  = array_diff( $class_words, [ 'fa' ] );
			$class_string = implode( ' ', $class_words );
		}

		if ( 0 < count( array_intersect( $allowed_prefix, $class_words ) ) ) {
			return $class_string;
		}

		return 'fas ' . $class_string;
	}


	/**
	 * Import the WooCommerce product filter settings (shortcodes).
	 *
	 * @param string $file_url The URL of the import JSON file.
	 *
	 * @return boolean
	 */
	public static function import_wpf_settings( $file_url ) {
		$result = array();

		// Retrieve the settings from the URL (JSON).
		$data = file_get_contents( $file_url );

		if ( empty( $data ) ) {
			return false;
		}

		// Replace the old term IDs with the new ones.
		$importer_data = get_transient( 'pt_importer_data' );

		if ( false !== $importer_data && ! empty( $importer_data['mapping']['term_id'] ) ) {
			$term_ids = $importer_data['mapping']['term_id'];

			// Get all old term IDs.
			preg_match_all( '/(color_bg|color_text|text)_(\d+)/' , $data, $output_array );

			$old_term_ids = empty( $output_array[2] ) ? array() : array_unique( $output_array[2] );

			foreach ( $old_term_ids as $old_term_id ) {
				$new_term_id = empty( $term_ids[ $old_term_id ] ) ? false : $term_ids[ $old_term_id ];

				if ( empty( $new_term_id ) ) {
					continue;
				}

				$data = preg_replace( '/(color_bg|color_text|text)_' . $old_term_id . '/', '$1__' . $new_term_id, $data );
			}

			/**
			 * Fix the temp spacing hack (__), to solve the over-replacement
			 * (IDs replaced multiple times, because they are changed concurrently).
			 * old ID 20 changes to 34, but then the original old ID 34 changes to 50 and
			 * this results to old IDs 20 and 34 to be both replaced to 50.
			 */
			$data = preg_replace( '/(color_bg|color_text|text)__(\d+)/', '$1_$2', $data );
		}

		$form = json_decode( $data, true );
		$k    = key( $form );

		if ( ! empty( $form[ $k ]['layout'] ) && ! empty( $form[ $k ]['data'] ) ) {
			$result[ $k ] = $form[$k];
		}

		if ( empty( $result ) ) {
			return false;
		}

		$plugin_option_slug = 'wpf_template';
		$option = get_option( $plugin_option_slug );
		$forms = empty( $option ) ? array() : $option;

		foreach ( $result as $slug => $v ) {
			if ( ! empty( $v['layout'] ) && ! empty( $v['data'] ) ) {
				$forms[ $slug ] = $v;
			}
		}

		update_option( $plugin_option_slug, $forms );

		return true;
	}


	/**
	 * Checks if any additional header elements (widgets / benefits bar) are shown
	 * on mobile for the current page being loaded.
	 *
	 * @return boolean
	 */
	public static function has_page_any_additional_header_elements_shown_on_mobile() {
		$elements = array(
			array(
				'theme_mod_prefix' => 'header_widget_area', // <theme_mod_prefix>_visibility, <theme_mod_prefix>_only_on_homepage
				'default_for_visibility' => 'hide_mobile', // has to match the default of the setting defined in customizer class
				'default_for_only_on_homepage' => false, // has to match the default of the setting defined in customizer class
			),
			array(
				'theme_mod_prefix' => 'benefit_bar',
				'default_for_visibility' => 'yes',
				'default_for_only_on_homepage' => true,
			),
		);

		$shown_on_mobile = array_map( function( $element ) {
			$element_visibility = get_theme_mod( $element['theme_mod_prefix'] . '_visibility', $element['default_for_visibility'] );
			$element_only_on_homepage = get_theme_mod( $element['theme_mod_prefix'] . '_only_on_homepage', $element['default_for_only_on_homepage'] );

			return ( 'yes' === $element_visibility ) && ( $element_only_on_homepage ? is_front_page() : true );
		}, $elements );

		return in_array( true, $shown_on_mobile, true );
	}


	/**
	 * Get WoonderShop skin
	 * @return string
	 */
	public static function get_skin() {
		return apply_filters( 'woondershop_skin', get_theme_mod( 'ws_skin', 'default' ) );
	}


	/**
	 * Check, if the passed WoonderShop skin is active.
	 * A array of skins can be passed as well, to check if one of them is active.
	 *
	 * @param string|array $skin The slug of the skin or an array, with list of skin slugs
	 */
	public static function is_skin_active( $skin ) {
		$active_skin = self::get_skin();

		if ( is_array( $skin ) ) {
			return in_array( $active_skin, $skin, true );
		}

		return $active_skin === $skin;
	}


	/**
	 * Get the position of the sidebar for the shop pages and conditionally for the single product.
	 *
	 * @return string Position of the sidebar ('none', 'left', 'right').
	 */
	public static function get_shop_sidebar_position() {
		if ( self::is_woocommerce_active() && is_product() ) {
			return get_theme_mod( 'single_product_sidebar', 'none' );
		}

		return get_field( 'sidebar', (int) get_option( 'woocommerce_shop_page_id' ) );
	}


	/**
	 * Output the WooCommerce product sorting options (as links).
	 *
	 * Taken from the WooCommerce `woocommerce_catalog_ordering` function from version 3.3.3.
	 */
	public static function output_woocommerce_ordering_links() {
		if ( ! self::is_woocommerce_active() ) {
			return false;
		}

		if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
			return false;
		}

		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => __( 'Default sorting', 'woondershop-pt' ),
			'popularity' => __( 'Sort by popularity', 'woondershop-pt' ),
			'rating'     => __( 'Sort by average rating', 'woondershop-pt' ),
			'date'       => __( 'Sort by newness', 'woondershop-pt' ),
			'price'      => __( 'Sort by price: low to high', 'woondershop-pt' ),
			'price-desc' => __( 'Sort by price: high to low', 'woondershop-pt' ),
		) );

		if ( wc_get_loop_prop( 'is_search' ) ) {
			$catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woondershop-pt' ) ), $catalog_orderby_options );
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
			unset( $catalog_orderby_options['rating'] );
		}

		foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<a href="#" class="mobile-sort__item<?php echo 'menu_order' === $id ? '  mobile-sort__item--active' : ''; ?>  js-mobile-sort-item" data-sort="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $name ); ?></a>
		<?php endforeach;
	}


	/**
	 * Helper function for outputting different parts of descriptions (from ACFs).
	 *
	 * @param string $part Which part of description to output ('above' or 'below').
	 *
	 * @return boolean (or HTML output).
	 */
	public static function add_acf_category_description( $part ) {
		if ( ! self::is_woocommerce_active() ) {
			return false;
		}

		if ( ! is_product_category() ) {
			return false;
		}

		$object = get_queried_object();

		if ( ! is_object( $object ) || empty( $object->term_id ) ) {
			return false;
		}

		$description = get_field( 'description_' . sanitize_key( $part ), 'category_' . absint( $object->term_id ) );

		if ( empty( $description ) ) {
			return false;
		}

		?>
		<div class="category-description category-description--<?php echo esc_attr( $part ); ?>">
			<?php echo wp_kses_post( $description ); ?>
		</div>
		<?php
	}


	/**
	 * Return the ID of the page the ACF should use to retrieve the ACF settings for.
	 *
	 * @return false|int
	 */
	public static function get_acf_page_id() {
		// If blog or single post use the ID of the blog.
		if ( is_home() || is_search() || is_singular( 'post' ) ) {
			return absint( get_option( 'page_for_posts' ) );
		}

		// If woocommerce page, use the shop page id.
		if ( self::is_woocommerce_active() && is_woocommerce() ) {
			return absint( get_option( 'woocommerce_shop_page_id', 0 ) );
		}

		return get_the_ID();
	}


	/**
	 * Return whether the breadcrumbs should be displayed or not.
	 *
	 * @param int $page_id The ID of the page to check the breadcrumbs settings for.
	 *
	 * @return bool
	 */
	public static function show_breadcrumbs( $page_id ) {
		$show_breadcrumbs = get_field( 'show_breadcrumbs', $page_id );

		if ( ! $show_breadcrumbs ) {
			$show_breadcrumbs = 'yes';
		}

		// Overwrite the settings with single product settings.
		if ( WoonderShopHelpers::is_woocommerce_active() && is_woocommerce() && is_product() ) {
			$show_breadcrumbs = get_theme_mod( 'single_product_show_breadcrumbs', true ) ? 'yes' : 'no' ;
		}

		return 'yes' === $show_breadcrumbs;
	}
}
