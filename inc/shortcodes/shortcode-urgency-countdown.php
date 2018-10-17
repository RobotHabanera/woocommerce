<?php
/**
 * Urgency counter shortcode.
 *
 * @package woondershop-pt
 */

class WS_Urgency_Counter {

	function __construct() {
		add_shortcode( 'urgency_countdown', array( $this, 'urgency_countdown' ) );
	}

	/**
	 * Shortcode for urgency counter.
	 *
	 * @param array $atts Shortcode attributes.
	 */
	public function urgency_countdown( $atts ) {
		$atts = shortcode_atts(
			array(
				'end_date' => '',
			),
			$atts
		);

		if ( empty( $atts['end_date'] ) ) {
			return false;
		}

		// Save the default timezone and set the WP timezone instead.
		$wp_timezone      = get_option('timezone_string');
		$default_timezone = date_default_timezone_get();

		if ( ! empty( $wp_timezone ) ) {
			date_default_timezone_set( $wp_timezone );
		}

		$now           = current_time( 'timestamp', 1 );
		$end_seconds   = strtotime( $atts['end_date'], $now );
		$total_seconds = $end_seconds - $now;

		// Restore the default timezone.
		if ( ! empty( $wp_timezone ) ) {
			date_default_timezone_set( $default_timezone );
		}

		if ( empty( $end_seconds ) ) {
			return '<span>' . esc_html__( 'invalid date and time format, for the urgency_counter shortcode', 'woondershop-pt' )  . '</span>';
		}

		$d = floor( $total_seconds / (60 * 60 * 24) );
		$h = floor( ( $total_seconds % (60 * 60 * 24) ) / (60 * 60) );
		$m = floor( ( $total_seconds % (60 * 60) ) / 60 );
		$s = floor( $total_seconds % 60 );

		ob_start();
		?>
			<span class="urgency-countdown  js-urgency-countdown-shortcode" data-total-seconds="<?php echo esc_attr( $total_seconds ); ?>">
				<?php
				printf(
					'%d %s, %d%s, %d%s, %d%s',
					$d,
					_n( 'day', 'days', $d, 'woondershop-pt' ),
					$h,
					esc_html_x( 'h', 'short version of: hours', 'woondershop-pt' ),
					$m,
					esc_html_x( 'min', 'short version of: minutes', 'woondershop-pt' ),
					$s,
					esc_html_x( 's', 'short version of: seconds', 'woondershop-pt' )
				);
				?>
			</span>
		<?php
		return ob_get_clean();
	}
}

$ws_urgency_counter = new WS_Urgency_Counter();
