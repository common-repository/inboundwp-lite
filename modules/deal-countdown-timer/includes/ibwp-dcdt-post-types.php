<?php
/**
 * Register Post type functionality
 *
 * @package InboundWP Lite
 * @package Deal Countdown Timer
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Function to register post type
 * 
 * @package Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_register_post_type() {

	$dcdt_post_lbls = apply_filters( 'dcdt_timer_post_labels', array(
								'name'                 	=> __('Deal Countdown Timer', 'inboundwp-lite'),
								'singular_name'        	=> __('Deal Countdown Timer', 'inboundwp-lite'),
								'all_items'				=> __('All Timer', 'inboundwp-lite'),
								'add_new'              	=> __('Add Timer', 'inboundwp-lite'),
								'add_new_item'         	=> __('Add New Timer', 'inboundwp-lite'),
								'edit_item'            	=> __('Edit Timer', 'inboundwp-lite'),
								'new_item'             	=> __('New Timer', 'inboundwp-lite'),
								'view_item'            	=> __('View Timer', 'inboundwp-lite'),
								'search_items'         	=> __('Search Timer', 'inboundwp-lite'),
								'not_found'            	=> __('No Timer Found', 'inboundwp-lite'),
								'not_found_in_trash'   	=> __('No Timer Found in Trash', 'inboundwp-lite'),
								'parent_item_colon'    	=> '',
								'menu_name'           	=> __('Deal Countdown Timer - IBWP', 'inboundwp-lite')
							));

	$dcdt_slider_args = array(
		'labels'				=> $dcdt_post_lbls,
		'public'				=> false,
		'show_ui'				=> true,
		'query_var'				=> false,
		'rewrite'				=> false,
		'capability_type'		=> 'post',
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-clock',
		'supports'				=> apply_filters('dcdt_timer_post_supports', array('title')),
	);

	// Register slick slider post type
	register_post_type( IBWPL_DCDT_POST_TYPE, apply_filters( 'dcdt_registered_post_type_args', $dcdt_slider_args ) );
}

// Action to register plugin post type
add_action('init', 'ibwpl_dcdt_register_post_type');

/**
 * Function to update post message for team showcase
 * 
 * @package Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_post_updated_messages( $messages ) {

	global $post, $post_ID;

	$messages[IBWPL_DCDT_POST_TYPE] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __( 'Timer updated.', 'inboundwp-lite' ) ),
		2 => __( 'Custom field updated.', 'inboundwp-lite' ),
		3 => __( 'Custom field deleted.', 'inboundwp-lite' ),
		4 => __( 'Timer updated.', 'inboundwp-lite' ),
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Timer restored to revision from %s', 'inboundwp-lite' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __( 'Timer published.', 'inboundwp-lite' ) ),
		7 => __( 'Timer saved.', 'inboundwp-lite' ),
		8 => sprintf( __( 'Timer submitted.', 'inboundwp-lite' ) ),
		9 => sprintf( __( 'Timer scheduled for: <strong>%1$s</strong>.', 'inboundwp-lite' ),
		  date_i18n( __( 'M j, Y @ G:i', 'inboundwp-lite' ), strtotime( $post->post_date ) ) ),
		10 => sprintf( __( 'Timer draft updated.', 'inboundwp-lite' ) ),
	);

	return $messages;
}

// Filter to update slider post message
add_filter( 'post_updated_messages', 'ibwpl_dcdt_post_updated_messages' );