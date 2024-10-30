<?php
/**
 * Post Type Functions
 *
 * Handles all custom post types of plugin
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Setup Spin Wheel Post Type
 * 
 * @since 1.0 
 **/
function ibwpl_spw_register_post_types() {

	// Spin Wheel post type
	$wheel_post_type_labels = array(
									'name'					=>	__('Spin Wheel', 'inboundwp-lite'),
									'singular_name'			=>	__('Spin Wheel', 'inboundwp-lite'),
									'add_new'				=>	__('Add New Wheel', 'inboundwp-lite'),
									'add_new_item'			=>	__('Add New Wheel', 'inboundwp-lite'),
									'edit_item'				=>	__('Edit Spin Wheel', 'inboundwp-lite'),
									'new_item'				=>	__('New Spin Wheel', 'inboundwp-lite'),
									'all_items'				=>	__('All Spin Wheels', 'inboundwp-lite'),
									'view_item'				=>	__('View Spin Wheel', 'inboundwp-lite'),
									'search_items'			=>	__('Search Spin Wheel', 'inboundwp-lite'),
									'not_found'				=>	__('No Spin Wheel found', 'inboundwp-lite'),
									'not_found_in_trash'	=>	__('No Spin Wheel found in Trash', 'inboundwp-lite'),
									'parent_item_colon'		=>	'',
									'featured_image'		=> __('Spin Wheel Image', 'inboundwp-lite'),
									'set_featured_image'	=> __('Set Spin Wheel Image', 'inboundwp-lite'),
									'remove_featured_image'	=> __('Remove Spin Wheel Image', 'inboundwp-lite'),
									'menu_name'				=>	__('Spin Wheel - IBWP', 'inboundwp-lite'),
								);
	$wheel_post_type_args	= array(
									'labels'				=> $wheel_post_type_labels,
									'public' 				=> false,
									'show_ui' 				=> true,
									'show_in_menu' 			=> true,
									'query_var' 			=> false,
									'exclude_from_search'	=> true,
									'rewrite' 				=> false,
									'capability_type' 		=> 'post',
									'hierarchical' 			=> false,
									'menu_icon'				=> 'dashicons-sos',
									'supports'				=> apply_filters( 'ibwpl_spw_post_supports', array('title') )
								);
	
	// Filter to modify wheel post type arguments
	$wheel_post_type_args = apply_filters( 'ibwpl_spw_register_post_type', $wheel_post_type_args );

	// Register wheel post type
	register_post_type( IBWPL_SPW_POST_TYPE, $wheel_post_type_args );
}

// Action to register post type
add_action( 'init', 'ibwpl_spw_register_post_types' );

/**
 * Function to update post message for button
 * 
 * @since 1.0
 */
function ibwpl_spw_post_updated_messages( $messages ) {

	global $post;

	$messages[IBWPL_SPW_POST_TYPE] = array(
		0	=>	'', // Unused. Messages start at index 1.
		1	=>	sprintf( __( 'Spin Wheel updated.', 'inboundwp-lite' ) ),
		2	=>	__( 'Custom field updated.', 'inboundwp-lite' ),
		3	=>	__( 'Custom field deleted.', 'inboundwp-lite' ),
		4	=>	__( 'Spin Wheel updated.', 'inboundwp-lite' ),
		5	=>	isset( $_GET['revision'] ) ? sprintf( __( 'Spin Wheel restored to revision from %s', 'inboundwp-lite' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6	=>	sprintf( __( 'Spin Wheel published.', 'inboundwp-lite' ) ),
		7	=>	__( 'Spin Wheel saved.', 'inboundwp-lite' ),
		8	=>	sprintf( __( 'Spin Wheel submitted.', 'inboundwp-lite' ) ),
		9	=>	sprintf( __( 'Spin Wheel scheduled for: <strong>%1$s</strong>.', 'inboundwp-lite' ),date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ) ),
		10	=>	sprintf( __( 'Spin Wheel draft updated.', 'inboundwp-lite' ) ),
	);
	
	return $messages;
}

// Filter to update slider post message
add_filter( 'post_updated_messages', 'ibwpl_spw_post_updated_messages' );