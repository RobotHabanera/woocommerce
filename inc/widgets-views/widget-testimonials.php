<?php
// Parameters for the slick carousel slider in this widget.
$slick_data = apply_filters( 'pt-woondershop/slick_carousel_testimonials_data', array(
	'autoplay'         => ! empty( $instance['autocycle'] ) && 'yes' === $instance['autocycle'],
	'autoplaySpeed'    => empty( $instance['interval'] ) ? 5000 : $instance['interval'],
	'slidesToShow'     => 2,
	'appendArrows'     => '#testimonials-container-' . esc_attr( $args['widget_id'] ) . ' .js-testimonials-navigation',
	'prevArrow'        => '<button type="button" class="slick-prev  slick-arrow"><span class="screen-reader-text">' . esc_html__( 'Previous', 'woondershop-pt' ) . '</span><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
	'nextArrow'        => '<button type="button" class="slick-next  slick-arrow"><span class="screen-reader-text">' . esc_html__( 'Next', 'woondershop-pt' ) . '</span><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
	'centerMode'       => true,
	'centerPadding'    => '15%',
	'responsive'       => array(
		array(
			'breakpoint' => 992,
			'settings'   => array(
				'slidesToShow' => 1,
				'centerMode'   => false,
			),
		),
	),
) );
?>

<?php echo $args['before_widget']; ?>

<?php echo $args['before_title'] . wp_kses_post( $instance['title'] ) . $args['after_title']; ?>

<?php if ( 1 < count( $testimonials ) ) : ?>
<div class="testimonials__container" id="testimonials-container-<?php echo esc_attr( $args['widget_id'] ); ?>">
	<div class="testimonials  js-testimonials-initialize-carousel" data-slick='<?php echo wp_json_encode( $slick_data ); ?>'>
<?php endif; ?>
		<?php foreach ( $testimonials as $testimonial ) : ?>
			<div class="testimonial__container">
				<div class="testimonial">
					<blockquote class="testimonial__quote">
						<?php echo wp_kses_post( $testimonial['quote'] ); ?>
					</blockquote>
					<div class="testimonial__author-container">
						<?php if ( ! empty( $testimonial['author_avatar'] ) ) : ?>
							<div class="testimonial__author-avatar">
								<img src="<?php echo esc_url( $testimonial['author_avatar'] ); ?>" alt="<?php printf( esc_html__( 'Testimonial by: %s', 'woondershop-pt' ), esc_html( $testimonial['author'] ) ); ?>">
							</div>
						<?php endif; ?>
						<div class="testimonial__author-info">
							<cite class="testimonial__author">
								<?php echo esc_html( $testimonial['author'] ); ?>
							</cite>
							<?php if ( isset( $testimonial['display-ratings'] ) && $testimonial['display-ratings'] ) : ?>
								<div class="testimonial__rating">
									<?php foreach ( $testimonial['rating'] as $rating ) : ?>
										<i class="fas  fa-star"></i>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

<?php if ( 1 < count( $testimonials ) ) : ?>
	</div>

	<div class="testimonials__navigation  js-testimonials-navigation"></div>

</div>
<?php endif; ?>

<?php echo $args['after_widget']; ?>
