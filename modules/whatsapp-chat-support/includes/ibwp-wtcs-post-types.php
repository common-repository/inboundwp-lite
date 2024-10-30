<?php
/**
 * Register Post type functionality
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to register post type
 * 
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */
function ibwpl_wtcs_register_post_type () {

	$ibwp_wtcs_post_labels = apply_filters( 'ibwpl_wtcs_post_labels', array(
							'name' 					=> __( 'Agents', 'inboundwp-lite' ),
							'singular_name' 		=> __( 'Agent', 'inboundwp-lite' ),
							'add_new' 				=> __( 'Add New', 'inboundwp-lite' ),
							'add_new_item' 			=> __( 'Add New Agent', 'inboundwp-lite' ),
							'edit_item' 			=> __( 'Edit Agent', 'inboundwp-lite' ),
							'new_item' 				=> __( 'New Agent', 'inboundwp-lite' ),
							'all_items' 			=> __( 'All Agents', 'inboundwp-lite' ),
							'view_item' 			=> __( 'View Agents', 'inboundwp-lite' ),
							'search_items' 			=> __( 'Search Agents', 'inboundwp-lite' ),
							'not_found' 			=> __( 'No Agents Found', 'inboundwp-lite' ),
							'not_found_in_trash'	=> __( 'No Agents Found in Trash', 'inboundwp-lite' ),
							'parent_item_colon' 	=> '',
							'featured_image'        => __( 'Profile Image', 'inboundwp-lite' ),
							'set_featured_image'    => __( 'Set Profile image', 'inboundwp-lite' ),
							'remove_featured_image' => __( 'Remove Profile image', 'inboundwp-lite' ),
							'use_featured_image'    => __( 'Use as profile image', 'inboundwp-lite' ),
							'insert_into_item'      => __( 'Insert into profile', 'inboundwp-lite' ),
							'uploaded_to_this_item' => __( 'Uploaded to this profile', 'inboundwp-lite' ),
							'menu_name' 			=> __( 'WhatsApp Chat - IBWP', 'inboundwp-lite' ),
						));

	$wtcs_args = array(
						'labels' 				=> $ibwp_wtcs_post_labels,
						'public' 				=> false,
						'show_ui' 				=> true,
						'show_in_menu' 			=> true,
						'query_var' 			=> false,
						'exclude_from_search'	=> true,
						'rewrite' 				=> false,
						'capability_type' 		=> 'post',
						'hierarchical' 			=> false,
						'supports' 				=> apply_filters( 'ibwpl_wtcs_post_supports', array('title', 'thumbnail') ),
						'menu_icon' 			=> 'dashicons-format-chat',
					);

	// Register testimonial post type
	register_post_type( IBWPL_WTCS_POST_TYPE, apply_filters('ibwpl_wtcs_post_type_args', $wtcs_args) );
}

// Action to register post type
add_action( 'init', 'ibwpl_wtcs_register_post_type');

/**
 * Function to update post message for WhatsApp Chat Support post type
 * 
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */
function ibwpl_wtcs_post_updated_messages( $messages ) {

	global $post, $post_ID;

	$messages[IBWPL_WTCS_POST_TYPE] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Agent updated.', 'inboundwp-lite' ),
		2 => __( 'Custom field updated.', 'inboundwp-lite' ),
		3 => __( 'Custom field deleted.', 'inboundwp-lite' ),
		4 => __( 'Agent updated.', 'inboundwp-lite' ),
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Agent restored to revision from %s', 'inboundwp-lite' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => __( 'Agent published.', 'inboundwp-lite' ),
		7 => __( 'Agent saved.', 'inboundwp-lite' ),
		8 => __( 'Agent submitted. ', 'inboundwp-lite' ),
		9 => sprintf( __( 'Agent scheduled for: <strong>%1$s</strong>.', 'inboundwp-lite' ),
		  date_i18n( 'M j, Y @ G:i', strtotime($post->post_date) ) ),
		10 => __( 'Agent draft updated.', 'inboundwp-lite' ),
	);

	return $messages;
}

// Filter to update whatsapp chat support post message
add_filter( 'post_updated_messages', 'ibwpl_wtcs_post_updated_messages' );