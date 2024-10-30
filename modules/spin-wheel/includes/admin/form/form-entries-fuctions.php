<?php
/**
 * Form Submission Functions
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Process the bulk actions of Form Entries
 *
 * @since 1.0
 * @return void
 */
function ibwpl_spw_entries_process_actions() {

	global $wpdb;

	// Form Submission Page
	if( ( isset( $_GET['page'] ) && $_GET['page'] == 'ibwp-spw-form-entries' )
		&& ( (isset( $_GET['action'] ) && $_GET['action'] == 'delete') || (isset( $_GET['action2'] ) && $_GET['action2'] == 'delete') )
		&& ! empty( $_GET['ibwp_spw_entry'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'bulk-ibwp_spw_entry' )
	) {

		$ibwp_spw_entry = $_GET['ibwp_spw_entry'];
		$ibwp_spw_entry = implode( ',', $_GET['ibwp_spw_entry'] );

		$sql 	= "DELETE FROM `".IBWPL_SPW_FORM_TBL."` WHERE `id` in( $ibwp_spw_entry )";
		$wpdb->query( $sql );

		$redirect_url = add_query_arg( array('post_type' => IBWPL_SPW_POST_TYPE, 'page' => 'ibwp-spw-form-entries', 'message' => 1), admin_url('edit.php') );
		wp_redirect( $redirect_url );
		exit;
	}
}

// Action to process form entries action
add_action( 'admin_init', 'ibwpl_spw_entries_process_actions' );

/**
 * Get Form Entries Count
 * 
 * @since 1.0
 */
function ibwpl_spw_entries_count( $args = array() ) {

	global $wpdb;

	// Generating Args
	$args['search']		= isset( $args['search'] ) 		? trim( $args['search'] ) 							: '';
	$args['wheel_id']	= isset( $args['wheel_id'] )	? trim( $args['wheel_id'] )							: '';
	$args['start_date']	= !empty( $args['start_date'] )	? date( 'Y-m-d', strtotime($args['start_date']) ) 	: '';
	$args['end_date']	= !empty( $args['end_date'] )	? date( 'Y-m-d', strtotime($args['end_date']) ) 	: '';

	$sql = "SELECT COUNT(`id`) FROM ".IBWPL_SPW_FORM_TBL." WHERE 1=1";

	// Popu ID
	if( $args['wheel_id'] ) {
		$sql .= " AND `wheel_id`='{$args['wheel_id']}' ";
	}

	// Search
	if( $args['search'] ) {

		if ( is_email( $args['search'] ) ) {
			$sql .= " AND `email`='{$args['search']}' ";
		} else {
			$sql .= ' AND `form_fields` LIKE \'%'.$args['search'].'%\' ';
		}
	}

	// Start Date
	if( $args['start_date'] ) {
		$sql .= " AND DATE(created_date) >= '{$args['start_date']}' ";
	}
	
	// End Date
	if( $args['end_date'] ) {
		$sql .= " AND DATE(created_date) <= '{$args['end_date']}' ";
	}

	$entries_count = $wpdb->get_var( $sql );

	return $entries_count;
}

/**
 * Get Form Entries
 * 
 * @since 1.0
 */
function ibwpl_spw_get_entries( $args = array() ) {

	global $wpdb;

	$sql = "SELECT * FROM ".IBWPL_SPW_FORM_TBL." WHERE 1=1";

	$args['limit']		= ! empty( $args['limit'] )		? $args['limit']									: 15;
	$args['orderby']	= ! empty( $args['orderby'] )	? $args['orderby']									: 'created_date';
	$args['order']		= ! empty( $args['order'] )		? $args['order']									: 'DESC';
	$args['search']		= isset( $args['search'] )		? trim( $args['search'] )							: '';
	$args['wheel_id']	= isset( $args['wheel_id'] )	? trim( $args['wheel_id'] )							: '';
	$args['start_date']	= !empty( $args['start_date'] )	? date( 'Y-m-d', strtotime($args['start_date']) )	: '';
	$args['end_date']	= !empty( $args['end_date'] )	? date( 'Y-m-d', strtotime($args['end_date']) )		: '';

	if( ! empty( $args['page'] ) ) {
		$page = $args['page'];
	} else if ( ! empty( $_GET['paged'] ) ) {
		$page = $_GET['paged'];
	} else {
		$page = 1;
	}

	// Query Offset
	$page_offset = ( ( $page * $args['limit'] ) - $args['limit'] );

	// Search
	if( $args['search'] ) {

		if ( is_email( $args['search'] ) ) {
			$sql .= " AND `email`='{$args['search']}' ";
		} else {
			$sql .= ' AND `form_fields` LIKE \'%'.$args['search'].'%\' ';
		}
	}

	// Popu ID
	if( $args['wheel_id'] ) {
		$sql .= " AND `wheel_id`='{$args['wheel_id']}' ";
	}

	// Start Date
	if( $args['start_date'] ) {
		$sql .= " AND DATE(created_date) >= '{$args['start_date']}' ";
	}

	// End Date
	if( $args['end_date'] ) {
		$sql .= " AND DATE(created_date) <= '{$args['end_date']}' ";
	}

	// Order By
	if( $args['orderby'] ) {
		$sql .= " ORDER BY `{$args['orderby']}` {$args['order']} ";
	}

	// Limit
	if( $args['limit'] ) {
		$sql .= " LIMIT {$page_offset},{$args['limit']} ";
	}

	$form_entries = $wpdb->get_results( $sql );

	return $form_entries;
}