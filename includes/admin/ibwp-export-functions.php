<?php
/**
 * Export Data : Functions, Hooks and Filters
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to get file data if exist else create the new file
 * 
 * @since 1.0
 */
function ibwpl_get_export_file( $file = false ) {

	$file_data = '';
	
	if ( $file && @file_exists( $file ) ) {

		$file_data = @file_get_contents( $file );

	} else {

		@file_put_contents( $file, '' );
		@chmod( $file, 0664 );
	}
	return $file_data;
}

/**
 * Append data to export file
 *
 * @since 1.0
 */
function ibwpl_add_export_data( $file, $data = '' ) {

	$file_data = ibwpl_get_export_file( $file );
	$file_data .= $data;
	@file_put_contents( $file, $file_data );
}

/**
 * Form Entries Export File
 *
 * @since 1.0
 */
function ibwpl_export_file_path() {

	$upload_dir	= wp_upload_dir();
	$filename	= 'ibwpl-export-data.csv';
	$file		= trailingslashit( $upload_dir['basedir'] ) . $filename;

	return $file;
}

/**
 * Function to generate form entries CSV
 * 
 * @since 1.0
 */
function ibwpl_do_export_action() {

	// Taking form data
	parse_str( $_POST['form_data'], $form_data );

	// Taking some variable
	$results = array(
						'status' 	=> 0,
						'message'	=> esc_html__('Sorry, Something happened wrong.', 'inboundwp-lite')
					);
	$export_action	= isset( $form_data['export_action'] )	? ibwpl_clean( $form_data['export_action'] )		: '';
	$identifier		= isset( $form_data['identifier'] )		? ibwpl_clean( $form_data['identifier'] )		: '';
	$nonce			= isset( $form_data['nonce'] )			? ibwpl_clean( $form_data['nonce'] )				: '';
	$redirect_url	= isset( $form_data['redirect_url'] )	? ibwpl_clean_url( $form_data['redirect_url'] )	: '';
	$page 			= isset( $_POST['page'] )				? $_POST['page']								: 1;
	$total_count 	= isset( $_POST['total_count'] )		? $_POST['total_count']							: 0;
	$data_process 	= isset( $_POST['data_process'] )		? $_POST['data_process']						: 0;

	if( empty( $_POST['form_data'] ) || empty( $identifier ) || empty( $redirect_url ) || ! wp_verify_nonce( $nonce, "ibwpl-{$identifier}-export-nonce" ) ) {
		wp_send_json( $results );
	}

	// Gethering all data
	$form_data					= (array) $form_data;
	$form_data['limit']			= 300;
	$form_data['page']			= $page;
	$form_data['total_count']	= $total_count;
	$form_data['data_process']	= $data_process;

	if ( function_exists( 'ibwpl_'.$export_action ) ) {
		$results = call_user_func( 'ibwpl_'.$export_action, $form_data );
	} else {
		$results = ibwpl_export_form_entries( $form_data );
	}

	wp_send_json( $results );
}

// Action to process Ajax for export data
add_action( 'wp_ajax_ibwpl_do_export_action', 'ibwpl_do_export_action' );

/**
 * Function to export form entries
 * 
 * @since 1.0
 */
function ibwpl_export_form_entries( $args = array() ) {

	global $wpdb;

	// Taking some variables
	$col_data		= '';
	$row_data		= '';
	$file			= ibwpl_export_file_path();
	$result			= array(
						'status'	=> 0,
						'message'	=> esc_html__( 'Sorry, No data found for export parameters.', 'inboundwp-lite' )
					);

	$limit			= $args['limit'];
	$page			= !empty( $args['page'] )			? $args['page']			: 1;
	$data_process	= isset( $args['data_process'] )	? $args['data_process']	: 0;
	$total_count	= isset( $args['total_count'] )		? $args['total_count']	: 0;

	$cols 		= apply_filters( "ibwpl_{$args['identifier']}_export_columns", array(), $args );
	$csv_column	= count( $cols );

	// Getting data
	$entires_data = apply_filters( "ibwpl_{$args['identifier']}_export_data", array(), $args );

	// If data found
	if( $entires_data ) {

		// If process is newly started - Step 1
		if( $page < 2 ) {

			// Make sure we start with a fresh file on step 1
			@unlink( $file );
			$i = 1;

			foreach( $cols as $col_id => $column ) {
				$col_data .= '"' . addslashes( $column ) . '"';
				$col_data .= ( $i == $csv_column ) ? '' : ',';
				$i++;
			}

			$col_data .= "\r\n";
			ibwpl_add_export_data( $file, $col_data ); // Add columns to file

			// Taking total counts of data at first time
			$total_count = apply_filters( "ibwpl_{$args['identifier']}_export_data_count", 0, $args );
		}
		
		$count = 0;

		// Output each row
		foreach ( $entires_data as $row ) {
			$j = 1;
			$count++;
			
			foreach ( $cols as $col_id => $column ) {				

				if( $col_id == 'number' ) {
					
					$row_data .= '"' . ( $count+( ( $page-1 ) * $limit ) ) . '",';
					$j++;

				} elseif ( isset( $row->$col_id ) ) { // Make sure the column is valid

					$entry_data = apply_filters( "ibwpl_{$args['identifier']}_export_data_row", $row->$col_id, $col_id, $column, $args );

					$row_data .= '"' . addslashes( preg_replace( "/\"/","'", $entry_data ) ) . '"';
					$row_data .= $j == count( $cols ) ? '' : ',';
					$j++;
				}
			}
			$row_data .= "\r\n";
		}

		// Record total process data
		$data_process = ( $data_process + count( $entires_data ) );
		ibwpl_add_export_data( $file, $row_data ); // Add rows to file

		// Calculate percentage
		$percentage = 100;

		if( $total_count > 0 ) {
			$percentage = ( ( $limit * $page ) / $total_count ) * 100;
		}

		if( $percentage > 100 ) {
			$percentage = 100;
		}

		// If process is done
		if( $data_process >= $total_count ) {

			$result['url'] = add_query_arg( array( 'action' => 'ibwpl_process_export_file', '_wpnonce' => wp_create_nonce( 'ibwpl-download-export-file' ) ), $args['redirect_url'] );
		}

		$result['status'] 		= 1;
		$result['message']		= esc_html__('Entries exported successfully.', 'inboundwp-lite');
		$result['page']			= ( $page + 1 );
		$result['total_count'] 	= $total_count;
		$result['percentage'] 	= $percentage;
		$result['data_process'] = $data_process;

	} else {
		return $result;
	}

	return $result;
}

/**
 * Process the download file generated by a batch export
 * 
 * @since 1.0
 */
function ibwpl_download_export_file() {

	if( isset( $_GET['action'] ) && $_GET['action'] == 'ibwpl_process_export_file' && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'ibwpl-download-export-file' ) ) {

		// Set headers
		ignore_user_abort( true );
		set_time_limit( 0 );
		nocache_headers();

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=ibwpl-export-data-' . date( 'd-m-Y' ) . '.csv' );
		header( "Expires: 0" );

		$file_path 	= ibwpl_export_file_path();
		$file 		= ibwpl_get_export_file( $file_path );

		@unlink( $file_path );
		echo $file;
		exit();
	}
}

// Action to export download process
add_action( 'admin_init', 'ibwpl_download_export_file', 5 );