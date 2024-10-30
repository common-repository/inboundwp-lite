<?php
/**
 * Template Functions File
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to display wheel form fields
 * 
 * @since 1.0
 */
function ibwpl_wheel_form_fields( $template_args, $echo = true ) {

	if( $echo ) {
		ibwpl_get_template( IBWPL_SPW_DIR_NAME, "form-fields.php", $template_args );
	} else {
		return ibwpl_get_template_html( IBWPL_SPW_DIR_NAME, "form-fields.php", $template_args );
	}
}