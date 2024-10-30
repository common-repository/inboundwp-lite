<?php
/**
 * Plugin generic functions file 
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Create table for report and headings
 * 
 * @since 1.0 
 */
function ibwpl_bh_create_tables() {

	global $wpdb, $charset_collate;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$sql = "CREATE TABLE ".IBWPL_BH_TBL." (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		post_id bigint(20) NOT NULL,
		post_type text NOT NULL,
		title_id bigint(20) NOT NULL,
		title text NOT NULL,
		title_click bigint(20) NOT NULL,
		created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;

	CREATE TABLE ".IBWPL_BH_STATS_TBL." (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		uid text NOT NULL,
		post_ids text NOT NULL,
		title_ids text NOT NULL,
		created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

	dbDelta( $sql );

	// Migration (Remove Old Table)
	$wpdb->query( "DROP TABLE IF EXISTS `{$wpdb->dbname}`.`{$wpdb->prefix}ibwp_bh_log`" );
}

/**
 * Update default settings
 * 
 * @since 1.0 
 */
function ibwpl_bh_default_settings() {

	global $ibwp_bh_options;

	$ibwp_bh_options = array(
							'post_types' => array('post'),
						);

	$default_options = apply_filters('ibwpl_bh_options_default_values', $ibwp_bh_options );

	// Update default options
	update_option( 'ibwp_bh_options', $default_options );

	// Overwrite global variable when option is update
	$ibwp_bh_options = ibwpl_get_settings( 'ibwp_bh_options' );
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0
 */
function ibwpl_bh_get_option( $key = '', $default = false ) {
	global $ibwp_bh_options;
	$value	= ! empty( $ibwp_bh_options[ $key ] ) ? $ibwp_bh_options[ $key ] : $default;
	return $value;
}

/**
 * Function to update post title clicks
 * 
 * @since 1.0
 */
function ibwpl_bh_update_title_click( $post_id = 0, $title_id = null ) {

	$result = false;

	if( empty( $post_id ) || ! isset( $title_id ) ) {
		return $result;
	}

	$prefix			= IBWPL_BH_META_PREFIX;
	$title_clicks	= get_post_meta( $post_id, $prefix.'title_clicks', true );
	$title_clicks	= ! empty( $title_clicks ) ? $title_clicks : array();

	if( ! empty( $title_clicks ) && isset( $title_clicks[ $title_id ] ) ) {
		$title_clicks[ $title_id ] = $title_clicks[ $title_id ] + 1;
	} else {
		$title_clicks[ $title_id ] = 1;
	}

	return update_post_meta( $post_id, $prefix.'title_clicks', $title_clicks );
}

/**
 * Function to update post title views
 * 
 * @since 1.0
 */
function ibwpl_bh_update_title_view( $title_data = array() ) {

	if( empty( $title_data ) ) {
		return false;
	}

	$prefix	= IBWPL_BH_META_PREFIX;

	foreach ( $title_data as $title_values ) {
		
		$title_data_arr	= explode( ':', $title_values );
		$post_id		= $title_data_arr[0];
		$title_id		= $title_data_arr[1];

		$title_views	= get_post_meta( $post_id, $prefix.'title_views', true );
		$title_views	= ! empty( $title_views ) ? $title_views : array();

		if( ! empty( $title_views ) && isset( $title_views[ $title_id ] ) ) {
			$title_views[ $title_id ] = $title_views[ $title_id ] + 1;
		} else {
			$title_views[ $title_id ] = 1;
		}

		update_post_meta( $post_id, $prefix.'title_views', $title_views );
	}
}