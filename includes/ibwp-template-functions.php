<?php
/**
 * Template Functions
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * InboundWP upload dir path
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_upload_dir() {
	$wp_upload_dir 	= wp_upload_dir();
	$path 			= $wp_upload_dir['basedir'] . '/inboundwp-lite/';

	return apply_filters( 'ibwpl_get_upload_dir', $path );
}

/**
 * InboundWP upload URL path
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_upload_url() {
	$wp_upload_dir 	= wp_upload_dir();
	$path 			= $wp_upload_dir['baseurl'] . '/inboundwp-lite/';

	return apply_filters( 'ibwpl_get_upload_url', $path );
}

/**
 * Returns the path to the plugin templates directory
 *
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_templates_dir( $module ) {
	
	if( $module ) {
		$templates_dir = IBWPL_DIR . 'modules/' . $module . '/templates';
	} else {
		$templates_dir = IBWPL_DIR . 'templates';
	}

	return apply_filters( 'ibwpl_template_dir', $templates_dir, $module );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *	yourtheme/$template_path/$template_name
 *	yourtheme/$template_name
 *	$default_path/$template_name
 * 
 * @package InboundWP Lite
 * @since 1.0
 * 
 */
function ibwpl_locate_template( $module, $template_name, $template_path = '', $default_path = '', $default_template = '' ) {

	$module = $module ? $module : null;
	
	if ( ! $template_path ) {
		$template_path = trailingslashit( 'inboundwp-lite/'.$module );
	}

	if ( ! $default_path ) {
		$default_path = trailingslashit( ibwpl_get_templates_dir( $module ) );
	}

	// Look within passed path within the theme - this is priority.
	$template_lookup = array(
							trailingslashit( $template_path ) . $template_name,
						);

	// Adding default path to check
	if( !empty($default_template) ) {
		$template_lookup[] = trailingslashit( $template_path ) . $default_template;
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template( $template_lookup );

	// Look within plugin template folder
	if ( ! $template || IBWPL_TEMPLATE_DEBUG_MODE ) {
		$template = $default_path . $template_name;
	}

	// If template does not exist then load passed $default_template
	if ( !empty($default_path) && !file_exists($template) ) {
		$template = $default_path . $default_template;
	}

	// Return what we found
	return apply_filters('ibwpl_locate_template', $template, $template_name, $template_path);
}

/**
 * Get other templates (e.g. attributes) passing attributes and including the file.
 *
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_template( $module = false, $template, $args = array(), $template_path = '', $default_path = '', $default_template = '' ) {

	$located = ibwpl_locate_template( $module, $template, $template_path, $default_path, $default_template );

	if ( ! file_exists( $located ) ) {
		return;
	}

	if ( $args && is_array($args) ) {
		extract( $args );
	}

	do_action( 'ibwpl_before_template_part', $module, $template, $template_path, $located, $args );

	include( $located );

	do_action( 'ibwpl_after_template_part', $module, $template, $template_path, $located, $args );
}

/**
 * Like ibwpl_get_template, but returns the HTML instead of outputting.
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_template_html( $module = false, $template_name, $args = array(), $template_path = '', $default_path = '', $default_template = '' ) {
	ob_start();
	ibwpl_get_template( $module, $template_name, $args, $template_path, $default_path, $default_template );
	return ob_get_clean();
}

/**
 * Add extra class to body
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_body_class( $classes ) {
	
	global $is_IE, $is_safari;

	if( $is_IE ) {
		$classes[] = 'ibwp-ie';
	}

	return $classes;
}
add_filter( 'body_class', 'ibwpl_body_class' );