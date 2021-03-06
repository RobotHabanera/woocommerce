<?php
/**
 * Title with Button Widget
 *
 * @package woondershop-pt
 */

if ( ! class_exists( 'PW_Title_With_Button' ) ) {
	class PW_Title_With_Button extends WP_Widget {

		// Basic widget settings.
		function widget_id_base() { return 'title_with_button'; }
		function widget_name() { return esc_html__( 'Title with Button', 'woondershop-pt' ); }
		function widget_description() { return esc_html__( 'Title with Button widget for Page Builder.', 'woondershop-pt' ); }
		function widget_class() { return 'widget-title-with-button'; }

		public function __construct() {
			parent::__construct(
				'pw_' . $this->widget_id_base(),
				sprintf( 'ProteusThemes: %s', $this->widget_name() ),
				array(
					'description' => $this->widget_description(),
					'classname'   => $this->widget_class(),
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
			echo $args['before_widget'];
			?>
				<div class="title-with-button">
					<h2 class="title-with-button__title"><?php echo esc_html( $instance['title'] ); ?></h2>
					<a href="<?php echo esc_url( $instance['button_link'] ); ?>" target="<?php echo empty( $instance['new_tab'] ) ? '_self' : '_blank'; ?>" class="title-with-button__button" title="<?php echo esc_attr( $instance['button_text'] ); ?>"><?php echo esc_html( $instance['button_text'] ); ?></a>
				</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance The new options.
		 * @param array $old_instance The previous options.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['title']       = sanitize_text_field( $new_instance['title'] );
			$instance['button_text'] = sanitize_text_field( $new_instance['button_text'] );
			$instance['button_link'] = esc_url_raw( $new_instance['button_link'] );
			$instance['new_tab']     = ! empty( $new_instance['new_tab'] ) ? sanitize_key( $new_instance['new_tab'] ) : '';

			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance The widget options.
		 */
		public function form( $instance ) {
			$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : esc_html__( 'Read more', 'woondershop-pt' );
			$button_link = ! empty( $instance['button_link'] ) ? $instance['button_link'] : '';
			$new_tab     = ! empty( $instance['new_tab'] ) ? $instance['new_tab'] : '';
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'woondershop-pt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button text', 'woondershop-pt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"><?php esc_html_e( 'Button link', 'woondershop-pt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>" type="text" value="<?php echo esc_attr( $button_link ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $new_tab, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e( 'Open Link in New Tab', 'woondershop-pt' ); ?></label>
			</p>

			<?php
		}
	}
	register_widget( 'PW_Title_With_Button' );
}
