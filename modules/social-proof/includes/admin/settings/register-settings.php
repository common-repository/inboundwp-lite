<?php
/**
 * Setting Class
 *
 * Handles the Admin side setting options functionality of module
 *
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get settings tab
 * 
 * @since 1.0
 */
function ibwpl_sp_settings_tab() {

	// Plugin settings tab
	$sett_tabs = array(
					'general' => esc_html__( 'General', 'inboundwp-lite' ),
				);

	return apply_filters( 'ibwpl_sp_settings_tab', (array)$sett_tabs );
}

/**
 * Function to register plugin settings
 * 
 * @since 1.0
 */
function ibwpl_sp_register_settings() {

	// Reset default settings
	if( ! empty( $_POST['ibwp_sp_reset_settings'] ) ) {
		ibwpl_sp_default_settings();
	}

	register_setting( 'ibwp_sp_plugin_options', 'ibwp_sp_options', 'ibwpl_sp_validate_options' );
}

// Action to register plugin settings
add_action( 'admin_init', 'ibwpl_sp_register_settings' );

/**
 * Validate Settings Options
 * 
 * @since 1.0
 */
function ibwpl_sp_validate_options( $input ) {

	global $ibwp_sp_options;

	$input = $input ? $input : array();

	parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab and section
	$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

	// Run a general sanitization for the tab for special fields
	$input = apply_filters( 'ibwpl_sp_sett_sanitize_'.$tab, $input );

	// Run a general sanitization for the custom created tab
	$input = apply_filters( 'ibwpl_sp_sett_sanitize', $input, $tab );

	// Making merge of old and new input values
	$input = array_merge( $ibwp_sp_options, $input );

	return $input;
}

/**
 * Filter to validate general settings
 * 
 * @since 1.0
 */
function ibwpl_sp_sanitize_general_sett( $input ) {

	$input['enable']					= isset( $input['enable'] )						? 1													: 0;
	$input['post_types']				= ! empty( $input['post_types'] )				? ibwpl_clean( $input['post_types'] )				: array();
	$input['notification']				= ! empty( $input['notification'] )				? ibwpl_clean_number( $input['notification'] )		: '';
	$input['notification_display_in']	= ! empty( $input['notification_display_in'] )	? ibwpl_clean( $input['notification_display_in'] )	: array();

	return $input;
}
add_filter( 'ibwpl_sp_sett_sanitize_general', 'ibwpl_sp_sanitize_general_sett' );