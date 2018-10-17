<?php
/**
 * Time left shortcode.
 *
 * @package woondershop-pt
 */

class WS_Time_Left {

	function __construct() {
		add_shortcode( 'time_left', array( $this, 'time_left' ) );
	}

	/**
	 * Time left shortcode callback.
	 *
	 * @param array $atts Shortcode attributes.
	 */
	public function time_left( $atts ) {
		$atts = shortcode_atts(
			array(
				'time' => '',
			),
			$atts
		);

		if ( empty( $atts['time'] ) ) {
			return false;
		}

		$regex_results = array();
		preg_match( '/(\d+):(\d{2}):(\d{2})/', $atts['time'], $regex_results );

		if ( empty( $regex_results ) ) {
			return '<span>' . esc_html__( '[invalid time format, for the time_left shortcode]', 'woondershop-pt' )  . '</span>';
		}

		$hours   = intval( $regex_results[1] );
		$minutes = WoonderShopHelpers::bound( intval( $regex_results[2] ), 0, 59 );
		$seconds = WoonderShopHelpers::bound( intval( $regex_results[3] ), 0, 59 );

		$total_seconds = $seconds + ( 60 * $minutes ) + ( 60 * 60 * $hours );

		ob_start();
		?>
			<span class="time-left-shortcode  js-time-left-shortcode" data-total-seconds="<?php echo esc_attr( $total_seconds ); ?>" data-id="<?php echo esc_attr( sanitize_key( $atts['time'] ) ); ?>"></span>
		<?php
		return ob_get_clean();
	}
}

$ws_time_left = new WS_Time_Left();
