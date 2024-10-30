<?php
/**
 * Functions File
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Create table for Submission & Spin Wheel report
 * 
 * @since 1.0 
 */
function ibwpl_spw_create_tables() {

	global $wpdb, $charset_collate;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$sql = "CREATE TABLE `".IBWPL_SPW_FORM_TBL."` (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		wheel_id bigint(20) NOT NULL,
		seg_id bigint(20) NOT NULL,
		name text NOT NULL,
		email text NOT NULL,
		phone text NOT NULL,
		created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

	dbDelta( $sql );

	// Migration (Remove Old Table)
	//$wpdb->query( "DROP TABLE IF EXISTS `{$wpdb->dbname}`.`{$wpdb->prefix}ibwp_spw_email_list`" );
}

/**
 * Update default settings
 * 
 * @since 1.0
 */
function ibwpl_spw_default_settings() {
	
	global $ibwp_spw_options;
	
	$ibwp_spw_options = array(
							'enable'				=> 1,
							'cookie_prefix'			=> 'ibwp_spw_',
							'post_types'			=> array('post'),
							'welcome_wheel'			=> '',
							'welcome_display_in'	=> array(),
						);

	$default_options = apply_filters('ibwpl_spw_options_default_values', $ibwp_spw_options );

	// Update default options
	update_option( 'ibwp_spw_options', $default_options );

	// Overwrite global variable when option is update	
	$ibwp_spw_options = ibwpl_get_settings( 'ibwp_spw_options' );
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0
 */
function ibwpl_spw_get_option( $key = '', $default = false ) {
	global $ibwp_spw_options;
	return ibwpl_get_option( $key, $default, $ibwp_spw_options, 'spin-wheel' );
}

/**
 * Function to get wheel icon position options
 * 
 * @since 1.0
 */
function ibwpl_spw_icon_position() {

	$wheel_icon_position = array(
							'bottom-left'	=> esc_html__('Bottom Left', 'inboundwp-lite'),
							'bottom-right'	=> esc_html__('Bottom Right', 'inboundwp-lite'),
						);
	return apply_filters( 'ibwpl_spw_icon_position', $wheel_icon_position );
}

/**
 * Function to get wheel design options
 * 
 * @since 1.0
 */
function ibwpl_spw_wheel_designs() {

	$wheel_designs = array(	
						'design-1'		=> esc_html__('Design 1', 'inboundwp-lite'),
						'design-2'		=> esc_html__('Design 2', 'inboundwp-lite'),
						'design-3'		=> esc_html__('Design 3', 'inboundwp-lite'),
						'design-4'		=> esc_html__('Design 4', 'inboundwp-lite'),
						'design-5'		=> esc_html__('Design 5', 'inboundwp-lite'),
					);
	return apply_filters( 'ibwpl_spw_wheel_designs', $wheel_designs );
}

/**
 * Function to return wheather spin wheel is active or not.
 * 
 * @since 1.0
 */
function ibwpl_spw_check_active( $glob_locs = array() ) {

	global $post, $ibwp_spw_wheel_active;

	$prefix 				= IBWPL_SPW_META_PREFIX;
	$ibwp_post_type			= isset( $post->post_type ) ? $post->post_type : '';
	$custom_location		= false;
	$ibwp_spw_wheel_active	= false;

	// Whole Website
	if( ! empty( $glob_locs['all'] ) ) {
		$ibwp_spw_wheel_active = true;
	}

	// Post Type Wise
	if( ! empty( $glob_locs[ $ibwp_post_type ] ) && is_singular() ) {
		$ibwp_spw_wheel_active = true;
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
		$ibwp_spw_wheel_active = true;
	}

	return $ibwp_spw_wheel_active;
}