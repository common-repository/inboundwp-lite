<?php
/**
 * Template Functions File
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to display popup form fields
 * 
 * @since 1.0
 */
function ibwpl_popup_social_links( $template_args, $type = 'icon', $echo = true ) {

	// Merge socail icon type to template args
	$template_args['social_type'] = $type;

	if( $echo ) {
		ibwpl_get_template( IBWPL_MP_DIR_NAME, "social.php", $template_args );
	} else {
		return ibwpl_get_template_html( IBWPL_MP_DIR_NAME, "social.php", $template_args );
	}
}

/**
 * Function to display popup social links
 * 
 * @since 1.0
 */
function ibwpl_popup_form_fields( $template_args, $echo = true ) {

	if( $echo ) {
		ibwpl_get_template( IBWPL_MP_DIR_NAME, "form-fields.php", $template_args );
	} else {
		return ibwpl_get_template_html( IBWPL_MP_DIR_NAME, "form-fields.php", $template_args );
	}
}