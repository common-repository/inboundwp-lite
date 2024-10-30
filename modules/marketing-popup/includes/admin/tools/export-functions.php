<?php
/**
 * Export Entries Functions
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to return columns for export entries data
 * 
 * @since 1.0
 */
function ibwpl_mp_export_form_entry_columns( $cols, $args ) {

	// CSV Columns
	$cols = array(
			'id'			=> __( 'ID', 'inboundwp-lite' ),
			'email'			=> __( 'Email Address', 'inboundwp-lite' ),
			'name'			=> __( 'Name', 'inboundwp-lite' ),
			'phone'			=> __( 'Phone Number', 'inboundwp-lite' ),
			'created_date'	=> __( 'Registered Date', 'inboundwp-lite' ),
		);

	return $cols;
}
add_filter( 'ibwpl_mp_export_columns', 'ibwpl_mp_export_form_entry_columns', 5, 2 );

/**
 * Function to return total count of entries
 * 
 * @since 1.0
 */
function ibwpl_mp_export_data_count( $total_count, $args ) {
	
	$total_count = ibwpl_mp_entries_count( $args );

	return $total_count;
}
add_filter( 'ibwpl_mp_export_data_count', 'ibwpl_mp_export_data_count', 5, 2 );

/**
 * Function to return total data of entries
 * 
 * @since 1.0
 */
function ibwpl_mp_export_data( $data, $args ) {

	if( empty( $args['popup_id'] ) ) {
		return $data;
	}

	$data = ibwpl_mp_get_entries( $args );
	return $data;
}
add_filter( 'ibwpl_mp_export_data', 'ibwpl_mp_export_data', 5, 2 );

/**
 * Function to filter value for entry data
 * 
 * @since 1.0
 */
function ibwpl_mp_export_data_row( $data, $col_id, $column_name, $args ) {

	if( $col_id == 'phone' ) {
		$data = str_replace('+', ' +', $data);
		$data = str_replace('-', ' -', $data);
	}

	return $data;
}
add_filter( 'ibwpl_mp_export_data_row', 'ibwpl_mp_export_data_row', 5, 4 );