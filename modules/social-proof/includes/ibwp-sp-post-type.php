<?php
/**
 * Post Type Functions
 *
 * Handles all custom post types of plugin
 *
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Setup Social Proof Post Type
 * 
 * @since 1.0 
 **/
function ibwpl_sp_register_post_types() {

	// Social Proof post type
	$sp_post_type_labels = array(
									'name'					=>	__('Social Proof', 'inboundwp-lite'),
									'singular_name'			=>	__('Social Proof', 'inboundwp-lite'),
									'add_new'				=>	__('Add New Social Proof', 'inboundwp-lite'),
									'add_new_item'			=>	__('Add New Social Proof', 'inboundwp-lite'),
									'edit_item'				=>	__('Edit Social Proof', 'inboundwp-lite'),
									'new_item'				=>	__('New Social Proof', 'inboundwp-lite'),
									'all_items'				=>	__('All Social Proofs', 'inboundwp-lite'),
									'view_item'				=>	__('View Social Proof', 'inboundwp-lite'),
									'search_items'			=>	__('Search Social Proof', 'inboundwp-lite'),
									'not_found'				=>	__('No Social Proof found', 'inboundwp-lite'),
									'not_found_in_trash'	=>	__('No Social Proof found in Trash', 'inboundwp-lite'),
									'parent_item_colon'		=>	'',
									'featured_image'		=> __('Social Proof Image', 'inboundwp-lite'),
									'set_featured_image'	=> __('Set Social Proof Image', 'inboundwp-lite'),
									'remove_featured_image'	=> __('Remove Social Proof Image', 'inboundwp-lite'),
									'menu_name'				=> __('Social Proof - IBWP', 'inboundwp-lite'),
								);

	$sp_post_type_args	= array(
									'labels'				=> $sp_post_type_labels,
									'public' 				=> false,
									'show_ui' 				=> true,
									'show_in_menu' 			=> true,
									'query_var' 			=> false,
									'exclude_from_search'	=> true,
									'rewrite' 				=> false,
									'capability_type' 		=> 'post',
									'hierarchical' 			=> false,
									'menu_icon'				=> 'dashicons-image-filter',
									'supports'				=> apply_filters( 'ibwpl_sp_post_supports', array('title') )
								);
	
	// Filter to modify social proof post type arguments
	$sp_post_type_args = apply_filters( 'ibwpl_sp_register_post_type', $sp_post_type_args );
	
	// Register social proof post type
	register_post_type( IBWPL_SP_POST_TYPE, $sp_post_type_args );
}

// Action to register post type
add_action( 'init', 'ibwpl_sp_register_post_types' );

/**
 * Function to update post message for button
 * 
 * @since 1.0
 */
function ibwpl_sp_post_updated_messages( $messages ) {

	global $post, $post_ID;

	$messages[IBWPL_SP_POST_TYPE] = array(
		0	=>	'', // Unused. Messages start at index 1.
		1	=>	sprintf( __( 'Social Proof updated.', 'inboundwp-lite' ) ),
		2	=>	__( 'Custom field updated.', 'inboundwp-lite' ),
		3	=>	__( 'Custom field deleted.', 'inboundwp-lite' ),
		4	=>	__( 'Social Proof updated.', 'inboundwp-lite' ),
		5	=>	isset( $_GET['revision'] ) ? sprintf( __( 'Social Proof restored to revision from %s', 'inboundwp-lite' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6	=>	sprintf( __( 'Social Proof published.', 'inboundwp-lite' ) ),
		7	=>	__( 'Social Proof saved.', 'inboundwp-lite' ),
		8	=>	sprintf( __( 'Social Proof submitted.', 'inboundwp-lite' ) ),
		9	=>	sprintf( __( 'Social Proof scheduled for: <strong>%1$s</strong>.', 'inboundwp-lite' ),date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ) ),
		10	=>	sprintf( __( 'Social Proof draft updated.', 'inboundwp-lite' ) ),
	);

	return $messages;
}

// Filter to update social proof post message
add_filter( 'post_updated_messages', 'ibwpl_sp_post_updated_messages' );