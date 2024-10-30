<?php
/**
 * Setting Class
 *
 * Handles the Admin side setting options functionality of module
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
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
function ibwpl_bh_settings_tab() {

	// Plugin settings tab
	$sett_tabs = array(
					'general'	=> array( 'name' => esc_html__('General', 'inboundwp-lite') ),
					'report'	=> array( 'name' => esc_html__('Report', 'inboundwp-lite'), 'submit_btn' => false ),
				);

	return apply_filters( 'ibwpl_bh_settings_tab', $sett_tabs );
}

/**
 * Function to register plugin settings
 * 
 * @since 1.0
 */
function ibwpl_bh_register_settings() {

	// Reset default settings
	if( ! empty( $_POST['ibwp_bh_reset_settings'] ) ) {
		ibwpl_bh_default_settings();
	}

	register_setting( 'ibwp_bh_plugin_options', 'ibwp_bh_options', 'ibwpl_bh_validate_options' );
}

// Action to register plugin settings
add_action( 'admin_init', 'ibwpl_bh_register_settings' );

/**
 * Validate Settings Options
 * 
 * @since 1.0
 */
function ibwpl_bh_validate_options( $input ) {

	global $ibwp_bh_options;

	$input = $input ? $input : array();

	parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab and section
	$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

	// Run a sanitization for the tab for special fields
	$input = apply_filters( 'ibwpl_bh_sett_sanitize_'.$tab, $input );

	// Run a general sanitization for the custom created tab
	$input = apply_filters( 'ibwpl_bh_sett_sanitize', $input, $tab );

	// Making merge of old and new input values
	$input = array_merge( $ibwp_bh_options, $input );

	return $input;
}

/**
 * Filter to validate general settings
 * 
 * @since 1.0
 */
function ibwpl_bh_sanitize_general_sett( $input ) {

	$input['post_types'] = ! empty( $input['post_types'] ) ? array('post') : array();

	return $input;
}
add_filter( 'ibwpl_bh_sett_sanitize_general', 'ibwpl_bh_sanitize_general_sett' );