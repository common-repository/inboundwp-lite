<?php
/**
 * Register Post type functionality
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to register post type
 *
 * @since 1.0
 */
function ibwpl_tm_register_post_type () {

	$tm_post_labels = apply_filters( 'ibwpl_tm_testimonials_post_labels', array(
							'name' 					=> __( 'Testimonials - IBWP', 'post type general name', 'inboundwp-lite' ),
							'singular_name' 		=> __( 'Testimonial', 'post type singular name', 'inboundwp-lite' ),
							'add_new' 				=> __( 'Add New', 'testimonial', 'inboundwp-lite' ),
							'add_new_item' 			=> __( 'Add New Testimonial', 'inboundwp-lite' ),
							'edit_item' 			=> __( 'Edit Testimonial', 'inboundwp-lite' ),
							'new_item' 				=> __( 'New Testimonial', 'inboundwp-lite' ),
							'all_items' 			=> __( 'All Testimonials', 'inboundwp-lite' ),
							'view_item' 			=> __( 'View Testimonial', 'inboundwp-lite' ),
							'search_items' 			=> __( 'Search Testimonials', 'inboundwp-lite' ),
							'not_found' 			=> __( 'No Testimonials Found', 'inboundwp-lite' ),
							'not_found_in_trash'	=> __( 'No Testimonials Found In Trash', 'inboundwp-lite' ),
							'parent_item_colon' 	=> '',
							'featured_image'		=> __( 'Testimonial Image', 'inboundwp-lite' ),
							'set_featured_image'	=> __( 'Set testimonial image', 'inboundwp-lite' ),
							'remove_featured_image'	=> __( 'Remove testimonial image', 'inboundwp-lite' ),
							'use_featured_image'	=> __( 'Use as testimonial image', 'inboundwp-lite' ),
							'insert_into_item'		=> __( 'Insert into testimonial', 'inboundwp-lite' ),
							'uploaded_to_this_item'	=> __( 'Uploaded to this testimonial', 'inboundwp-lite' ),
							'menu_name' 			=> __( 'Testimonials - IBWP', 'inboundwp-lite' ),
						));

	$testimonial_args = array(
								'labels' 				=> $tm_post_labels,
								'public' 				=> true,
								'publicly_queryable' 	=> true,
								'show_ui' 				=> true,
								'show_in_menu' 			=> true,
								'query_var' 			=> true,
								'exclude_from_search'	=> false,
								'rewrite' 				=> array( 
																'slug' 			=> apply_filters( 'ibwpl_tm_testimonials_post_slug', 'testimonial' ),
																'with_front' 	=> false
															),
								'capability_type' 		=> 'post',
								'has_archive' 			=> apply_filters( 'ibwpl_tm_testimonials_archive_slug', false ),
								'hierarchical' 			=> false,
								'supports' 				=> apply_filters('ibwpl_tm_post_supports', array( 'title', 'author', 'editor', 'thumbnail', 'page-attributes', 'publicize', 'wpcom-markdown' )),
								'menu_icon' 			=> 'dashicons-format-quote',
							);

	// Register testimonial post type
	register_post_type( IBWPL_TM_POST_TYPE, apply_filters('ibwpl_tm_testimonials_post_type_args', $testimonial_args) );
}

// Action to register post type
add_action( 'init', 'ibwpl_tm_register_post_type');

/**
 * Function to register taxonomy
 *
 * @since 1.0
 */
function ibwpl_tm_register_taxonomies() {

	$tm_cat_labels = apply_filters('ibwpl_tm_testimonials_cat_labels', array(
					'name'				=> __( 'Category', 'inboundwp-lite' ),
					'singular_name'		=> __( 'Category', 'inboundwp-lite' ),
					'search_items'		=> __( 'Search Category', 'inboundwp-lite' ),
					'all_items'			=> __( 'All Category', 'inboundwp-lite' ),
					'parent_item'		=> __( 'Parent Category', 'inboundwp-lite' ),
					'parent_item_colon'	=> __( 'Parent Category', 'inboundwp-lite' ),
					'edit_item'			=> __( 'Edit Category', 'inboundwp-lite' ),
					'update_item'		=> __( 'Update Category', 'inboundwp-lite' ),
					'add_new_item'		=> __( 'Add New Category', 'inboundwp-lite' ),
					'new_item_name'		=> __( 'New Category Name', 'inboundwp-lite' ),
					'menu_name'			=> __( 'Category', 'inboundwp-lite' ),
				));

	$tm_cat_args = array(
					'hierarchical'		=> true,
					'labels'			=> $tm_cat_labels,
					'show_ui'			=> true,
					'show_admin_column'	=> true,
					'query_var'			=> true,
					'rewrite'			=> array( 'slug' => IBWPL_TM_CAT ),
				);

	// Register testimonial category
	register_taxonomy( IBWPL_TM_CAT, array( IBWPL_TM_POST_TYPE ), apply_filters('ibwpl_tm_testimonials_cat_args', $tm_cat_args) );
}

// Action to register taxonomies
add_action( 'init', 'ibwpl_tm_register_taxonomies');

/**
 * Function to update post message for testimonial post type
 *
 * @since 1.0
 */
function ibwpl_tm_post_updated_messages( $messages ) {

	global $post, $post_ID;

	$messages[IBWPL_TM_POST_TYPE] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __( 'Testimonial updated. <a href="%s">View Testimonial</a>', 'inboundwp-lite' ), esc_url( get_permalink( $post_ID ) ) ),
		2 => __( 'Custom field updated.', 'inboundwp-lite' ),
		3 => __( 'Custom field deleted.', 'inboundwp-lite' ),
		4 => __( 'Testimonial updated.', 'inboundwp-lite' ),
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Testimonial restored to revision from %s', 'inboundwp-lite' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __( 'Testimonial published. <a href="%s">View Testimonial</a>', 'inboundwp-lite' ), esc_url( get_permalink( $post_ID ) ) ),
		7 => __( 'Testimonial saved.', 'inboundwp-lite' ),
		8 => sprintf( __( 'Testimonial submitted. <a target="_blank" href="%s">Preview Testimonial</a>', 'inboundwp-lite' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		9 => sprintf( __( 'Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Testimonial</a>', 'inboundwp-lite' ),
			date_i18n( 'M j, Y @ G:i', strtotime($post->post_date) ), esc_url(get_permalink($post_ID)) ),
		10 => sprintf( __( 'Testimonial draft updated. <a target="_blank" href="%s">Preview Testimonial</a>', 'inboundwp-lite' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);

	return $messages;
}

// Filter to update testimonial post message
add_filter( 'post_updated_messages', 'ibwpl_tm_post_updated_messages' );