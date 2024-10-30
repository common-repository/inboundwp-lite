<?php
/**
 * Setting Class
 *
 * Handles the Admin side setting options functionality of module
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
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
function ibwpl_mp_settings_tab() {

	// Plugin settings tab
	$sett_tabs = array(
					'general' => esc_html__( 'General', 'inboundwp-lite' ),
				);

	return apply_filters( 'ibwpl_mp_settings_tab', (array)$sett_tabs );
}

/**
 * Function to register plugin settings
 * 
 * @since 1.0
 */
function ibwpl_mp_register_settings() {

	// Reset default settings
	if( ! empty( $_POST['ibwp_mp_reset_settings'] ) ) {
		ibwpl_mp_default_settings();
	}

	register_setting( 'ibwp_mp_plugin_options', 'ibwp_mp_options', 'ibwpl_mp_validate_options' );
}

// Action to register plugin settings
add_action( 'admin_init', 'ibwpl_mp_register_settings' );

/**
 * Validate Settings Options
 * 
 * @since 1.0
 */
function ibwpl_mp_validate_options( $input ) {

	global $ibwp_mp_options;

	$input = $input ? $input : array();

	parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab and section
	$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

	// Run a general sanitization for the tab for special fields
	$input = apply_filters( 'ibwpl_mp_sett_sanitize_'.$tab, $input );

	// Run a general sanitization for the custom created tab
	$input = apply_filters( 'ibwpl_mp_sett_sanitize', $input, $tab );

	// Making merge of old and new input values
	$input = array_merge( $ibwp_mp_options, $input );

	return $input;
}

/**
 * Filter to validate general settings
 * 
 * @since 1.0
 */
function ibwpl_mp_sanitize_general_sett( $input ) {

	$input['enable']				= isset( $input['enable'] )					? 1												: 0;
	$input['cookie_prefix']			= ! empty( $input['cookie_prefix'] )		? ibwpl_clean( $input['cookie_prefix'] )			: 'ibwp_mp_';
	$input['post_types']			= ! empty( $input['post_types'] )			? ibwpl_clean( $input['post_types'] )			: array();
	$input['welcome_popup']			= ! empty( $input['welcome_popup'] )		? ibwpl_clean_number( $input['welcome_popup'] )	: '';
	$input['welcome_display_in']	= ! empty( $input['welcome_display_in'] )	? ibwpl_clean( $input['welcome_display_in'] )	: array();

	return $input;
}
add_filter( 'ibwpl_mp_sett_sanitize_general', 'ibwpl_mp_sanitize_general_sett' );