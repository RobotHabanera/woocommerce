<?php
/**
 * Countdown Widget
 *
 * @package woondershop-pt
 */

if ( ! class_exists( 'PW_Countdown' ) ) {
	class PW_Countdown extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false, // ID, auto generate when false.
				esc_html__( 'ProteusThemes: Countdown', 'woondershop-pt'),
				array(
					'description' => esc_html__( 'Countdown timer to a specific date and time.', 'woondershop-pt'),
					'classname'   => 'widget-countdown',
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$current_wp_time = current_time( 'timestamp' );
			$timestamp       = empty( $instance['date'] ) ? $current_wp_time : strtotime( $instance['date'], $current_wp_time );
			$hide_label      = ! empty( $instance['hide_label'] ) ? 1 : 0;

			// Is date and time in correct format?
			$timestamp = empty( $timestamp ) ? 0 : $timestamp;

			echo $args['before_widget'];
			?>
				<div class="countdown  js-pt-countdown-widget" data-timestamp="<?php echo esc_attr( $timestamp ); ?>" data-hide-labels="<?php echo esc_attr( $hide_label ); ?>">
				</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['date']       = sanitize_text_field( $new_instance['date'] );
			$instance['hide_label'] = ! empty( $new_instance['hide_label'] ) ? sanitize_key( $new_instance['hide_label'] ) : '';


			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$date       = empty( $instance['date'] ) ? '' : $instance['date'];
			$hide_label = empty( $instance['hide_label'] ) ? '' : $instance['hide_label'];

			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php esc_html_e( 'End date and time:', 'woondershop-pt'); ?>
					<?php
					$timestamp = strtotime( $date );

					if ( ! empty( $date ) & empty( $timestamp ) ) :
					?>
						<span style="color: red; margin-left: 10px;">
							<?php esc_html_e( 'The date and time format is not correct! Please take a look at the example bellow and update the page.', 'woondershop-pt' ); ?>
						</span>
					<?php endif; ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="text" placeholder="01/30/2019 16:00" value="<?php echo esc_attr( $date ); ?>" />
				<small><?php esc_html_e( 'Input the future date and time for the countdown. Example date format: 04/25/2017 4:00 pm or 25.4.2017 16:00', 'woondershop-pt' ); ?></small>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $hide_label, 'on'); ?> id="<?php echo $this->get_field_id( 'hide_label' ); ?>" name="<?php echo $this->get_field_name( 'hide_label' ); ?>" value="on" />
				<label for="<?php echo $this->get_field_id( 'hide_label' ); ?>"><?php esc_html_e('Hide labels?', 'woondershop-pt'); ?></label>
			</p>

			<?php
		}

	}

	register_widget( 'PW_Countdown' );
}
