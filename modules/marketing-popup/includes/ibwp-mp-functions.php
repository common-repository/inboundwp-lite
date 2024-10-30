<?php
/**
 * Functions File
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Create table for form submission & popup report
 * 
 * @since 1.0
 */
function ibwpl_mp_create_tables() {

	global $wpdb, $charset_collate;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$sql = "CREATE TABLE ".IBWPL_MP_FORM_TBL." (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		popup_id bigint(20) NOT NULL,
		name text NOT NULL,
		email text NOT NULL,
		phone text NOT NULL,
		created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

	dbDelta( $sql );
}

/**
 * Update default settings
 * 
 * @since 1.0
 */
function ibwpl_mp_default_settings() {
	
	global $ibwp_mp_options;
	
	$ibwp_mp_options = array(
							'enable'				=> 1,
							'cookie_prefix'			=> 'ibwp_mp_',
							'post_types'			=> array('post'),
							'welcome_popup'			=> '',
							'welcome_display_in'	=> array(),
						);

	$default_options = apply_filters('ibwpl_mp_options_default_values', $ibwp_mp_options );

	// Update default options
	update_option( 'ibwp_mp_options', $default_options );

	// Overwrite global variable when option is update	
	$ibwp_mp_options = ibwpl_get_settings( 'ibwp_mp_options' );
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0
 */
function ibwpl_mp_get_option( $key = '', $default = false ) {
	global $ibwp_mp_options;
	return ibwpl_get_option( $key, $default, $ibwp_mp_options, 'marketing-popup' );
}

/**
 * Function to return wheather popup is active or not.
 * 
 * @since 1.0
 */
function ibwpl_mp_check_active( $glob_locs = array() ) {

	global $post, $ibwp_mp_popup_active;

	$prefix 				= IBWPL_MP_META_PREFIX;
	$ibwp_post_type			= isset( $post->post_type ) ? $post->post_type : '';
	$custom_location		= false;
	$ibwp_mp_popup_active	= false;

	// Whole Website
	if( ! empty( $glob_locs['all'] ) ) {
		$ibwp_mp_popup_active = true;
	}

	// Post Type Wise
	if( ! empty( $glob_locs[ $ibwp_post_type ] ) && is_singular() ) {
		$ibwp_mp_popup_active = true;
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

	if( $custom_location && ! empty( $glob_locs[ $custom_location ] ) ) {
		$ibwp_mp_popup_active = true;
	}

	return $ibwp_mp_popup_active;
}

/**
 * When popup goal function
 * 
 * @since 1.0
 */
function ibwpl_mp_popup_goals() {

	$popup_goals = array(
						'email-lists'	=>	array(
												'name'	=> esc_html__('Collect Email', 'inboundwp-lite'),
												'icon'	=> "dashicons dashicons-email-alt",
											),
						'target-url'	=>	array(
												'name'	=> esc_html__('Target URL', 'inboundwp-lite'),
												'icon'	=> "dashicons dashicons-admin-links",
											),
						'announcement'	=>	array(
												'name'	=> esc_html__('Announcement', 'inboundwp-lite'),
												'icon'	=> "dashicons dashicons-megaphone",
											),
						'phone-calls'	=>	array(
												'name'	=> esc_html__('Phone Calls', 'inboundwp-lite'),
												'icon'	=> "dashicons dashicons-phone",
											),
					);

	return apply_filters('ibwpl_mp_popup_goals', $popup_goals );
}

/**
 * When popup type function
 * 
 * @since 1.0
 */
function ibwpl_mp_popup_types() {

	$popup_types = array(
						'modal'				=>	array(
													'name'	=> esc_html__('Modal Popup', 'inboundwp-lite'),
													'icon'	=> "dashicons dashicons-admin-page",
												),
						'bar'				=>	array(
													'name'	=> esc_html__('Bar', 'inboundwp-lite'),
													'icon'	=> "dashicons dashicons-schedule",
												),
						'push-notification'	=>	array(
													'name'	=> esc_html__('Push Notification', 'inboundwp-lite'),
													'icon'	=> "dashicons dashicons-admin-comments",
												),
					);

	return apply_filters('ibwpl_mp_popup_types', $popup_types );
}

/**
 * Popup templates function
 * 
 * @since 1.0
 */
function ibwpl_mp_popup_designs() {

	$popup_designs	= array(
						'design-1'	=>	esc_html__('Template 1', 'inboundwp-lite'),
						'design-2'	=>	esc_html__('Template 2', 'inboundwp-lite'),
					);

	return apply_filters('ibwpl_mp_popup_designs', $popup_designs );
}

/**
 * Function to get social options
 * 
 * @since 1.0
 */
function ibwpl_mp_social_options() {

	$social_options = array(	
							'facebook'		=> esc_html__('Facebook', 'inboundwp-lite'),
							'twitter'		=> esc_html__('Twitter', 'inboundwp-lite'),
							'linkedin'		=> esc_html__('Linkedin', 'inboundwp-lite'),
							'youtube'		=> esc_html__('Youtube', 'inboundwp-lite'),
							'pinterest'		=> esc_html__('Pinterest', 'inboundwp-lite'),
							'instagram'		=> esc_html__('Instagram', 'inboundwp-lite'),
							'tumblr'		=> esc_html__('Tumblr', 'inboundwp-lite'),
							'flickr'		=> esc_html__('Flickr', 'inboundwp-lite'),
							'reddit'		=> esc_html__('Reddit', 'inboundwp-lite'),
							'whatsapp'		=> esc_html__('WhatsApp', 'inboundwp-lite'),
						);

	return apply_filters('ibwpl_mp_social_options', $social_options );
}

/**
 * Function to get modal & push notification popup position options
 * 
 * @since 1.0
 */
function ibwpl_mp_mn_position_options() {

	$mn_position_option = array(	
							'top-left'		=> esc_html__('Top Left', 'inboundwp-lite'),
							'top-center'	=> esc_html__('Top Center', 'inboundwp-lite'),
							'top-right'		=> esc_html__('Top Right', 'inboundwp-lite'),
							'middle-left'	=> esc_html__('Middle Left', 'inboundwp-lite'),
							'middle-center'	=> esc_html__('Middle Center', 'inboundwp-lite'),
							'middle-right'	=> esc_html__('Middle Right', 'inboundwp-lite'),
							'bottom-left'	=> esc_html__('Bottom Left', 'inboundwp-lite'),
							'bottom-center'	=> esc_html__('Bottom Center', 'inboundwp-lite'),
							'bottom-right'	=> esc_html__('Bottom Right', 'inboundwp-lite'),
						);
	return apply_filters('ibwpl_mp_mn_position_options', $mn_position_option );
}

/**
 * Function to get social data of plugin
 * 
 * @since 1.0
 */
function ibwpl_mp_get_social_data( $social_arr = array() ) {

	$result			= array();
	$social_options	= ibwpl_mp_social_options();
	$social_arr		= ! is_array( $social_arr ) ? (array)$social_arr : $social_arr;

	if( ! empty( $social_arr ) ) {
		foreach ($social_arr as $social_key => $social_data) {

			if( empty( $social_data['name'] ) || empty( $social_data['link'] ) ) {
				continue;
			}

			$result[ $social_key ]			= $social_data;
			$result[ $social_key ]['title'] = isset( $social_options[ $social_data['name'] ] ) ? $social_options[ $social_data['name'] ] : $social_data['name'];
		}
	}

	return $result;
}