<?php
/*
 * Custom customizer control: Separator
 */

class WoonderShop_Separator_Custom_Control extends WP_Customize_Control{
	public $type = 'separator';

	public function __construct( $manager, $id, array $args = array() ) {
		// Create a new dummy separator setting, so we don't have to define it every time we use this control.
		if ( ! isset( $args['settings'] ) ) {
			$manager->add_setting( 'separator' );
			$args['settings'] = 'separator';
		}

		parent::__construct( $manager, $id, $args );
	}

	public function render_content(){
		?>
		<p><hr></p>
		<?php
	}
}
