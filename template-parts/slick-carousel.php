<?php
/**
 * Template part for Slick carousel
 *
 * @package woondershop-pt
 */

$slider_content   = get_field( 'slider_content' );
$cycle_interval   = (int) get_field( 'cycle_interval' );
$transition_speed = (int) get_field( 'transition_speed' );
$slide_effect     = get_field( 'slide_effects' );
$slider_width     = get_field( 'slider_width' );
$slider_background_color = get_field( 'slider_background_color' );

if ( 'boxed' === $slider_width && 'caption' === $slider_content ) { // boxed slider has captions turned off by default
	$slider_content = apply_filters( 'woondershop_slider_captions_when_boxed', 'none' );
}

$slick_data = apply_filters( 'pt-woondershop/slick_carousel_data', array(
	'autoplay'       => get_field( 'auto_cycle' ),
	'autoplaySpeed'  => empty( $cycle_interval ) ? 5000 : $cycle_interval,
	'fade'           => 'fade' === $slide_effect,
	'dots'           => get_field( 'navigation_dots' ),
	'arrows'         => get_field( 'navigation_arrows' ),
	'adaptiveHeight' => get_field( 'adaptive_height' ),
	'speed'          => empty( $transition_speed ) ? 300 : $transition_speed,
	'prevArrow'      => '<button type="button" class="slick-prev  slick-arrow"><span class="screen-reader-text">' . esc_html__( 'Previous', 'woondershop-pt' ) . '</span><i class="fas fa-chevron-left" aria-hidden="true"></i></button>',
	'nextArrow'      => '<button type="button" class="slick-next  slick-arrow"><span class="screen-reader-text">' . esc_html__( 'Next', 'woondershop-pt' ) . '</span><i class="fas fa-chevron-right" aria-hidden="true"></i></button>',
));

?>

<div class="theme-slider-wrapper" style="<?php ( empty( $slider_background_color ) || 'boxed' !== $slider_width ) ? '' : printf( 'background-color: %s;', esc_attr( $slider_background_color ) ); ?>">
	<div class="pt-slick-carousel <?php echo 'boxed' === $slider_width ? 'container' : ''; ?>" tabindex="0">
		<div class="pt-slick-carousel__slides  js-pt-slick-carousel-initialize-slides  pt-slick-carousel__slides--<?php echo 'caption' === $slider_content ? 'with-captions' : 'no-captions'; ?>" data-slick='<?php echo wp_json_encode( $slick_data ); ?>'>
			<?php
			$slider_captions = array();
			$slider_counter  = 0;

			while ( have_rows( 'slides' ) ) :
				the_row();
				$slider_counter++;

				$slider_sizes = array( 'woondershop-jumbotron-slider-l', 'woondershop-jumbotron-slider-m', 'woondershop-jumbotron-slider-s' );

				$image_or_video     = get_sub_field( 'image_or_video' );
				$slide_link         = get_sub_field( 'slide_link' );
				$slide_video_url    = get_sub_field( 'video_url' );
				$slide_image        = get_sub_field( 'slide_image' );
				$slider_src_img     = wp_get_attachment_image_src( absint( $slide_image ), 'woondershop-jumbotron-slider-s' );
				$slide_image_srcset = WoonderShopHelpers::get_image_srcset( $slide_image, $slider_sizes );

				if ( 'caption' === $slider_content ) {
					$slider_captions[] = array(
						'title'    => get_sub_field( 'slide_title' ),
						'text'     => get_sub_field( 'slide_text' ),
						'is_video' => 'video' === $image_or_video,
					);
				}
			?>

				<div class="carousel-item  carousel-item--<?php echo sanitize_html_class( $image_or_video ); ?>">
					<?php if ( 'image' === $image_or_video && ! empty( $slide_image ) ) : ?>

						<?php if ( 'link' === $slider_content && ! empty( $slide_link ) ) : ?>
							<a href="<?php echo esc_url( $slide_link ); ?>" target="<?php echo ( get_sub_field( 'slide_open_link_in_new_window' ) ) ?  '_blank' : '_self' ?>">
						<?php endif; ?>

							<img src="<?php echo esc_url( $slider_src_img[0] ); ?>" srcset="<?php echo esc_attr( $slide_image_srcset ); ?>" sizes="100vw" alt="<?php echo esc_attr( get_sub_field( 'slide_title' ) ); ?>" class="carousel-item__slide-image">

						<?php if ( 'link' === $slider_content && ! empty( $slide_link ) ) : ?>
							</a>
						<?php endif; ?>

					<?php	elseif ( 'video' === $image_or_video && ! empty( $slide_video_url ) ) : ?>

						<?php
							$video_class      = '';
							$video_link_class = '';

							if ( strstr( $slide_video_url, 'youtube.com/' ) ) {
								$video_class = '  js-carousel-item-yt-video';
							}
							elseif ( strstr( $slide_video_url, 'vimeo.com/' ) ) {
								$video_class = '  js-carousel-item-vimeo-video';
							}

							if ( ! empty( $video_class ) ) {
								$video_link_class = $video_class . '-link';
							}
						?>

						<a class="carousel-item__video-link<?php echo esc_attr( $video_link_class ); ?>" href="#" data-video-id="<?php echo 'pt-sc-video-' . absint( $slider_counter ); ?>" data-toggle="modal" data-target="#pt-sc-video-modal-<?php echo esc_attr( $slider_counter ); ?>">
							<img class="carousel-item__video-thumbnail" src="<?php echo esc_url( $slider_src_img[0] ); ?>" srcset="<?php echo esc_attr( $slide_image_srcset ); ?>" sizes="100vw" alt="<?php echo esc_attr( wp_strip_all_tags( get_sub_field( 'slide_title' ) ) ); ?>">
						</a>

						<div class="carousel-item__video_modal  js-pt-slick-carousel-video-modal-container" style="display: none;">
						<!-- This parent div will be moved to before closing body tag via JS, so that the modal windows will work properly -->
							<div class="modal  fade  js-pt-slick-carousel-video-modal" id="pt-sc-video-modal-<?php echo esc_attr( $slider_counter ); ?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog  modal-dialog-centered  modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i class="fas fa-times" aria-hidden="true"></i>
											</button>
										</div>
										<div class="modal-body">
											<div class="embed-responsive  embed-responsive-16by9<?php echo esc_attr( $video_class ); ?>">
												<?php
												echo wp_oembed_get(
													esc_url( $slide_video_url ),
													array(
														'api' => '1',
														'player_id' => 'pt-sc-video-' . absint( $slider_counter ),
													)
												);
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					<?php endif; ?>
				</div>

			<?php endwhile; ?>
		</div>

		<?php if ( ! empty( $slider_captions ) ) : ?>

		<!-- Slider Content - is populated by JS -->
		<div class="pt-slick-carousel__container  js-pt-slick-carousel-captions-container<?php echo $slider_captions[0]['is_video'] ? '  pt-slick-carousel__container--video' : ''; ?>">
			<div class="pt-slick-carousel__content  js-pt-slick-carousel-captions<?php echo $slider_captions[0]['is_video'] ? '  pt-slick-carousel__content--video' : ''; ?>">
				<div class="pt-slick-carousel__content-title  h1  js-pt-slick-carousel-captions-title<?php echo $slider_captions[0]['is_video'] ? '  pt-slick-carousel__content-title--video' : ''; ?>"><?php echo wp_kses_post( $slider_captions[0]['title'] ); ?></div>
				<div class="pt-slick-carousel__content-description  js-pt-slick-carousel-captions-text">
					<?php echo wp_kses_post( $slider_captions[0]['text'] ); ?>
				</div>
				<img class="carousel-item__video-play-button js-pt-slick-carousel-video-play-icon" src="<?php echo esc_attr( get_template_directory_uri() ) . '/assets/images/play_icon.svg'; ?>" alt="<?php esc_html_e( 'Play button' , 'woondershop-pt' ); ?>">
			</div>
		</div>
		<?php endif; ?>

		<?php if ( ! empty( $slider_captions ) ) : ?>
		<script>window.WoonderShopSliderCaptions = <?php echo wp_json_encode( $slider_captions ); ?>;</script>
		<?php endif; ?>

	</div>
</div>