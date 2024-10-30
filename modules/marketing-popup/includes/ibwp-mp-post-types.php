<?php
/**
 * Post Type Functions
 *
 * Handles all custom post types of plugin
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Setup Popup Post Type
 * 
 * @since 1.0 
 **/
function ibwpl_mp_register_post_types() {
	
	// Popup post type
	$popup_post_type_labels = array(
									'name'					=>	__('Marketing PopUp', 'inboundwp-lite'),
									'singular_name'			=>	__('PopUp', 'inboundwp-lite'),
									'add_new'				=>	__('Add New Popup', 'inboundwp-lite'),
									'add_new_item'			=>	__('Add New Popup', 'inboundwp-lite'),
									'edit_item'				=>	__('Edit Popup', 'inboundwp-lite'),
									'new_item'				=>	__('New Popup', 'inboundwp-lite'),
									'all_items'				=>	__('All Popups', 'inboundwp-lite'),
									'view_item'				=>	__('View Popup', 'inboundwp-lite'),
									'search_items'			=>	__('Search Popup', 'inboundwp-lite'),
									'not_found'				=>	__('No Popup found', 'inboundwp-lite'),
									'not_found_in_trash'	=>	__('No Popup found in Trash', 'inboundwp-lite'),
									'parent_item_colon'		=>	'',
									'featured_image'		=> __('Popup Image', 'inboundwp-lite'),
									'set_featured_image'	=> __('Set Popup Image', 'inboundwp-lite'),
									'remove_featured_image'	=> __('Remove Popup Image', 'inboundwp-lite'),
									'menu_name'				=>	__('Marketing PopUp - IBWP', 'inboundwp-lite'),
								);
	$popup_post_type_args	= array(
									'labels'				=> $popup_post_type_labels,
									'public' 				=> false,
									'show_ui' 				=> true,
									'show_in_menu' 			=> true,
									'query_var' 			=> false,
									'exclude_from_search'	=> true,
									'rewrite' 				=> false,
									'capability_type' 		=> 'post',
									'hierarchical' 			=> false,
									'menu_icon'				=> 'dashicons-megaphone',
									'supports'				=> apply_filters( 'ibwpl_mp_post_supports', array('title') )
								);
	
	// Filter to modify popup post type arguments
	$popup_post_type_args = apply_filters( 'ibwpl_mp_register_popup_post_type', $popup_post_type_args );
	
	// Register popup post type
	register_post_type( IBWPL_MP_POST_TYPE, $popup_post_type_args );
}

// Action to register post type
add_action( 'init', 'ibwpl_mp_register_post_types' );

/**
 * Function to update post message for button
 * 
 * @since 1.0
 */
function ibwpl_mp_post_updated_messages( $messages ) {
	
	global $post, $post_ID;
	
	$messages[IBWPL_MP_POST_TYPE] = array(
		0	=>	'', // Unused. Messages start at index 1.
		1	=>	sprintf( __( 'Popup updated.', 'inboundwp-lite' ) ),
		2	=>	__( 'Custom field updated.', 'inboundwp-lite' ),
		3	=>	__( 'Custom field deleted.', 'inboundwp-lite' ),
		4	=>	__( 'Popup updated.', 'inboundwp-lite' ),
		5	=>	isset( $_GET['revision'] ) ? sprintf( __( 'Popup restored to revision from %s', 'inboundwp-lite' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6	=>	sprintf( __( 'Popup published.', 'inboundwp-lite' ) ),
		7	=>	__( 'Popup saved.', 'inboundwp-lite' ),
		8	=>	sprintf( __( 'Popup submitted.', 'inboundwp-lite' ) ),
		9	=>	sprintf( __( 'Popup scheduled for: <strong>%1$s</strong>.', 'inboundwp-lite' ),date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ) ),
		10	=>	sprintf( __( 'Popup draft updated.', 'inboundwp-lite' ) ),
	);
	
	return $messages;
}

// Filter to update marketing popup post message
add_filter( 'post_updated_messages', 'ibwpl_mp_post_updated_messages' );