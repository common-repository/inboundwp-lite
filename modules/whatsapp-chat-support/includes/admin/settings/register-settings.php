<?php
/**
 * Setting Class
 *
 * Handles the Admin side setting options functionality of module
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
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
function ibwpl_wtcs_settings_tab() {

	// Plugin settings tab
	$sett_tabs = array(
					'general' => esc_html__( 'General', 'inboundwp-lite' ),
				);

	if( class_exists('WooCommerce') ) {
		$sett_tabs[ 'woo' ] = esc_html__( 'WooCommerce', 'inboundwp-lite' );
	}

	$sett_tabs[ 'analytics' ] = esc_html__( 'Analytics', 'inboundwp-lite' );

	return apply_filters( 'ibwpl_wtcs_settings_tab', $sett_tabs );
}

/**
 * Function to register plugin settings
 * 
 * @since 1.0
 */
function ibwpl_wtcs_register_settings() {

	// Reset default settings
	if( ! empty( $_POST['ibwp_wtcs_reset_settings'] ) ) {
		ibwpl_wtcs_default_settings();
	}

	register_setting( 'ibwp_wtcs_plugin_options', 'ibwp_wtcs_options', 'ibwpl_wtcs_validate_options' );
}

// Action to register plugin settings
add_action( 'admin_init', 'ibwpl_wtcs_register_settings' );

/**
 * Validate Settings Options
 * 
 * @since 1.0
 */
function ibwpl_wtcs_validate_options( $input ) {

	global $ibwp_wtcs_options;

	$input = $input ? $input : array();

	parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab and section
	$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

	// Run a general sanitization for the tab for special fields
	$input = apply_filters( 'ibwpl_wtcs_sett_sanitize_'.$tab, $input );

	// Run a general sanitization for the custom created tab
	$input = apply_filters( 'ibwpl_wtcs_sett_sanitize', $input, $tab );

	// Making merge of old and new input values
	$input = array_merge( $ibwp_wtcs_options, $input );

	return $input;
}

/**
 * Filter to validate general settings
 * 
 * @since 1.1
 */
function ibwpl_wtcs_sanitize_general_sett( $input ) {

	$input['enable'] 				= isset( $input['enable'] ) 				? 1 													: 0;
	$input['mobile_enable'] 		= isset( $input['mobile_enable'] ) 			? 1 													: 0;
	$input['chatbox_glob_locs'] 	= ! empty( $input['chatbox_glob_locs'] ) 	? ibwpl_clean( $input['chatbox_glob_locs'] )			: array();
	$input['btn_position']			= ! empty( $input['btn_position'] ) 		? ibwpl_clean( $input['btn_position'] )					: 'bottom-right';
	$input['btn_style']				= ! empty( $input['btn_style'] ) 			? ibwpl_clean( $input['btn_style'] )					: 'style-1';
	
	$input['main_title'] 			= ! empty( $input['main_title'] ) 			? ibwpl_clean( $input['main_title'] )					: '';
	$input['sub_title'] 			= ! empty( $input['sub_title'] ) 			? ibwpl_clean( $input['sub_title'] )					: '';
	$input['notice'] 				= ! empty( $input['notice'] ) 				? ibwpl_clean( $input['notice'] )						: '';
	$input['toggle_text'] 			= ! empty( $input['toggle_text'] ) 			? ibwpl_clean( $input['toggle_text'] )					: '';

	return $input;
}
add_filter( 'ibwpl_wtcs_sett_sanitize_general', 'ibwpl_wtcs_sanitize_general_sett' );

/**
 * Filter to validate analytics settings
 * 
 * @since 1.1
 */
function ibwpl_wtcs_sanitize_analytics_sett( $input ) {

	$input['ganaly_enable']	= isset( $input['ganaly_enable'] )	? 1	: 0;
	$input['ganaly_id']		= ! empty( $input['ganaly_id'] )	? ibwpl_clean( $input['ganaly_id'] )	: '';

	return $input;
}
add_filter( 'ibwpl_wtcs_sett_sanitize_analytics', 'ibwpl_wtcs_sanitize_analytics_sett' );