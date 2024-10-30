<?php
/**
 * Functions File
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update default settings
 * 
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */
function ibwpl_wtcs_default_settings() {

	global $ibwp_wtcs_options;

	$ibwp_wtcs_options = array(
							'enable'			=> 0,
							'mobile_enable'		=> 1,
							'chatbox_glob_locs'	=> array(),
							'btn_position'		=> 'bottom-right',
							'btn_style'			=> 'style-1',
							'main_title'		=> esc_html__('Start a Conversation', 'inboundwp-lite'),
							'sub_title'			=> esc_html__('Hi! Click one of our members below to chat on WhatsApp', 'inboundwp-lite'),
							'notice'			=> esc_html__('The team typically replies in a few minutes.', 'inboundwp-lite'),
							'toggle_text'		=> esc_html__('Need Help? Chat with us', 'inboundwp-lite'),
						);

	$default_options = apply_filters('ibwpl_wtcs_options_default_values', $ibwp_wtcs_options );

	// Update default options
	update_option( 'ibwp_wtcs_options', $default_options );

	// Overwrite global variable when option is update	
	$ibwp_wtcs_options = ibwpl_get_settings( 'ibwp_wtcs_options' );
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0
 */
function ibwpl_wtcs_get_option( $key = '', $default = false ) {
	global $ibwp_wtcs_options;
	return ibwpl_get_option( $key, $default, $ibwp_wtcs_options, 'whatsapp-chat-support' );
}

/**
 * Function to return wheather chatbox is active or not.
 * 
 * @since 1.0
 */
function ibwpl_wtcs_check_active() {

	global $post, $ibwp_wtcs_chatbox_active;

	$prefix 					= IBWPL_WTCS_META_PREFIX;
	$enable						= ibwpl_wtcs_get_option( 'enable' );
	$mobile_enable				= ibwpl_wtcs_get_option( 'mobile_enable' );
	$chatbox_glob_locs 			= ibwpl_wtcs_get_option( 'chatbox_glob_locs' );
	$ibwp_post_type				= isset( $post->post_type ) ? $post->post_type : '';
	$custom_location			= false;
	$ibwp_wtcs_chatbox_active	= false;

	// If not globally active
	if( ! $enable ) {
		$ibwp_wtcs_chatbox_active = false;
		return $ibwp_wtcs_chatbox_active;
	}

	// Whole Website
	if( ! empty( $chatbox_glob_locs['all'] ) ) {
		$ibwp_wtcs_chatbox_active = true;
	}

	// Post Type Wise
	if( ! empty( $chatbox_glob_locs[ $ibwp_post_type ] ) && is_singular() ) {
		$ibwp_wtcs_chatbox_active = true;
	}

	// Checking custom locations
	if( is_search() ) {
		$custom_location = "is_search";
	} else if( is_404() ) {
		$custom_location = "is_404";
	} else if( is_archive() ) {
		$custom_location = "is_archive";
	} else if( is_front_page() ) {
		$custom_location = "is_front_page";
	}

	if( $custom_location && ! empty( $chatbox_glob_locs[ $custom_location ] ) ) {
		$ibwp_wtcs_chatbox_active = true;
	}

	// Mobile Check
	if( wp_is_mobile() ) {
		$ibwp_wtcs_chatbox_active = ( $ibwp_wtcs_chatbox_active && $mobile_enable ) ? true : false;
	}

	return $ibwp_wtcs_chatbox_active;
}