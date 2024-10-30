<?php
/**
 * Shortcode File
 *
 * Handles the 'ibwp_mp_popup' shortcode of plugin
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * 'ibwp_mp_popup' shortcode
 * 
 * @since 1.0
 */
function ibwpl_mp_render_inline_popup( $atts, $content = null ) {

	// Shortcode Parameter
	$atts = shortcode_atts(array(
				'id' => '',
		), $atts, 'ibwp_mp_popup');

	// Extract Shortcode Var
	extract( $atts );

	// If Popup ID is not set
	if( empty( $id ) ) {
		return $content;
	}

	$popup_post = get_post( $id );

	// If valid post is not there
	if( empty( $popup_post ) ) {
		return $content;
	}

	// If valid post is not there
	if( $popup_post->post_status != 'publish' || $popup_post->post_type != IBWPL_MP_POST_TYPE ) {
		return $content;
	}

	// Taking some globals
	global $post;

	ob_start();

	// Taking some data
	$design 	= get_post_meta( $id, $prefix.'design', true );
	$content 	= get_post_meta( $id, $prefix.'content', true );

	$content .= ob_get_clean();
	return $content;
}

// Inline Popup Shortcode
add_shortcode( 'ibwp_mp_popup', 'ibwpl_mp_render_inline_popup' );