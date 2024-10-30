<?php
/**
 * Functions File
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update default settings
 * 
 * @since 1.0
 */
function ibwpl_tm_default_settings() {

	global $wtwp_pro_options;

	$wtwp_pro_options = array(
							'default_img' => IBWPL_URL ."assets/images/person-placeholder.png",
						);

	$default_options = apply_filters('ibwpl_tm_options_default_values', $wtwp_pro_options );

	// Update default options
	update_option( 'wtwp_pro_options', $default_options );

	// Overwrite global variable when option is update	
	$wtwp_pro_options = ibwpl_get_settings( 'wtwp_pro_options' );
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0
 */
function ibwpl_tm_get_option( $key = '', $default = false ) {
	global $wtwp_pro_options;
	return ibwpl_get_option( $key, $default, $wtwp_pro_options, 'testimonials' );
}

/**
 * Function to get user image
 *
 * @since 1.0
 */
function ibwpl_tm_get_image( $id, $size = 100, $style = "ibwp-tm-circle" ) {

	global $post;

	$response		= '';
	$size			= (! empty( $size ) && is_numeric( $size )) ? $size : 100;
	$default_image	= ibwpl_tm_get_option( 'default_img' );

	if ( has_post_thumbnail( $id ) ) {

		$response = get_the_post_thumbnail( $id, array( $size, $size ), array('class' => $style) );

	} elseif( ! empty( $post->post_author ) ) {

		$response = get_avatar( $post, $size, null, null, array('class' => $style) );

	} elseif( ! empty( $default_image ) ) {

		$response = '<img class="'.$style.'"  src="'.$default_image.'" width="'.$size.'" height="'.$size.'" alt="" />';
	}

	return $response;
}

/**
 * Function to get testimonial shortcode designs
 *
 * @since 1.0
 */
function ibwpl_tm_designs() {

	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'inboundwp-lite'),
		'design-2'	=> esc_html__('Design 2', 'inboundwp-lite'),
		'design-3'	=> esc_html__('Design 3', 'inboundwp-lite'),
		'design-4'	=> esc_html__('Design 4', 'inboundwp-lite'),
	);
	return apply_filters('ibwpl_tm_designs', $design_arr );
}

/**
 * Function to get testimonial form fields
 *
 * @since 1.0
 */
function ibwpl_tm_form_fields() {

	$form_fields_arr = array(
						0 => array(
								'field'			=> esc_html__('title', 'inboundwp-lite'),
								'field_title'	=> esc_html__('Testimonial Title', 'inboundwp-lite'),
								'label'			=> esc_html__('Title', 'inboundwp-lite'),
								'error_msg'		=> '',
								'require'		=> 1,
								'enable'		=> 1,
							),
						1 => array(
								'field'		=> esc_html__('category', 'inboundwp-lite'),
								'label'		=> esc_html__('Testimonial Category', 'inboundwp-lite'),
								'error_msg'	=> '',
								'require'	=> 0,
								'enable'	=> 1,
							),
						2 => array(
								'field'		=> esc_html__('client_name', 'inboundwp-lite'),
								'label'		=> esc_html__('Client Name', 'inboundwp-lite'),
								'error_msg'	=> '',
								'require'	=> 1,
								'enable'	=> 1,
							),
						3 => array(
								'field'		=> esc_html__('job_title', 'inboundwp-lite'),
								'label'		=> esc_html__('Job Title', 'inboundwp-lite'),
								'error_msg'	=> '',
								'require'	=> 0,
								'enable'	=> 1,
							),
						4 => array(
								'field'		=> esc_html__('company_name', 'inboundwp-lite'),
								'label'		=> esc_html__('Company Name', 'inboundwp-lite'),
								'error_msg'	=> '',
								'require'	=> 0,
								'enable'	=> 1,
							),
						5 => array(
								'field'		=> esc_html__('company_website', 'inboundwp-lite'),
								'label'		=> esc_html__('Company Website', 'inboundwp-lite'),
								'error_msg'	=> '',
								'require'	=> 0,
								'enable'	=> 1,
							),
						6 => array(
								'field'		=> esc_html__('rating', 'inboundwp-lite'),
								'label'		=> esc_html__('Rating', 'inboundwp-lite'),
								'error_msg'	=> '',
								'require'	=> 0,
								'enable'	=> 1,
							),
						7 => array(
								'field'		=> esc_html__('client_image', 'inboundwp-lite'),
								'label'		=> esc_html__('Image', 'inboundwp-lite'),
								'error_msg'	=> esc_html__('Please upload a valid image.', 'inboundwp-lite'),
								'require'	=> 0,
								'enable'	=> 1,
							),
						8 => array(
								'field'			=> esc_html__('content', 'inboundwp-lite'),
								'field_title'	=> esc_html__('Testimonial Content', 'inboundwp-lite'),
								'label'			=> esc_html__('Testimonial', 'inboundwp-lite'),
								'error_msg'		=> '',
								'require'		=> 1,
								'enable'		=> 1,
							),
						9 => array(
								'field'			=> esc_html__('captcha', 'inboundwp-lite'),
								'field_title'	=> esc_html__('Captcha', 'inboundwp-lite'),
								'label'			=> esc_html__('Are you Human?', 'inboundwp-lite'),
								'error_msg'		=> esc_html__('Sorry, Captcha is not validated.', 'inboundwp-lite'),
								'require'		=> 1,
								'enable'		=> 1,
							),
					);
	return apply_filters('ibwpl_tm_form_fields', $form_fields_arr );
}