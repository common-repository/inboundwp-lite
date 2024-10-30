<?php
/**
 * Setting Class
 *
 * Handles the Admin side setting options functionality of module
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get settings tab
 * 
 * @since 1.1
 */
function ibwpl_tm_settings_tab() {

	// Plugin settings tab
	$sett_tabs = array(
					'general'		=> esc_html__( 'General', 'inboundwp-lite' ),
					'form_sett'		=> esc_html__( 'Form Fields', 'inboundwp-lite' ),
					'notification'	=> esc_html__( 'Email Notification', 'inboundwp-lite' ),
				);

	return apply_filters( 'ibwpl_tm_settings_tab', $sett_tabs );
}

/**
 * Function to register plugin settings
 * 
 * @since 1.0
 */
function ibwpl_tm_register_settings() {

	// Reset default settings
	if( ! empty( $_POST['ibwp_tm_reset_settings'] ) ) {
		ibwpl_tm_default_settings();
	}

	register_setting( 'ibwp_tm_plugin_options', 'wtwp_pro_options', 'ibwpl_tm_validate_options' );
}

// Action to register plugin settings
add_action( 'admin_init', 'ibwpl_tm_register_settings' );

/**
 * Validate Settings Options
 * 
 * @since 1.0
 */
function ibwpl_tm_validate_options( $input ) {

	global $wtwp_pro_options;

	$input = $input ? $input : array();

	parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab and section
	$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

	// Run a general sanitization for the tab for special fields
	$input = apply_filters( 'ibwpl_tm_sett_sanitize_'.$tab, $input );

	// Run a general sanitization for the custom created tab
	$input = apply_filters( 'ibwpl_tm_sett_sanitize', $input, $tab );

	// Making merge of old and new input values
	$input = array_merge( $wtwp_pro_options, $input );

	return $input;
}

/**
 * Filter to validate general settings
 * 
 * @since 1.1
 */
function ibwpl_tm_sanitize_general_sett( $input ) {

	$input['default_img'] = ! empty( $input['default_img'] ) ? ibwpl_clean_url( $input['default_img'] ) : '';

	return $input;
}
add_filter( 'ibwpl_tm_sett_sanitize_general', 'ibwpl_tm_sanitize_general_sett' );