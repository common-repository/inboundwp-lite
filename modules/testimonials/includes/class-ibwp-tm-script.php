<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_TM_Script {

	function __construct() {

		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'ibwpl_tm_admin_script_style') );

		// Action to add style on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_tm_front_end_style') );

		// Action to add script on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_tm_front_end_script') );
	}

	/**
	 * Enqueue admin styles and Script
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_admin_script_style( $hook ) {

		global $typenow;

		// Registring admin Style
		wp_register_style( 'ibwp-tm-admin-style', IBWPL_TM_URL.'assets/css/ibwp-tm-admin.css', array(), IBWPL_VERSION );

		// All testimonial pages
		if( $typenow == IBWPL_TM_POST_TYPE ) {
			wp_enqueue_style( 'ibwp-tm-admin-style' );
		}

		// Setting Page Screen
		if( $hook == IBWPL_TM_POST_TYPE . '_page_wtwp-pro-settings' ) {

			wp_enqueue_media(); // For media uploader
		}
	}

	/**
	 * Function to add style at front side
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_front_end_style() {

		// Registring testimonials style
		wp_register_style( 'ibwp-tm-public-style', IBWPL_TM_URL.'assets/css/ibwp-tm-public.css', array(), IBWPL_VERSION );

		wp_enqueue_style( 'wpos-slick-style' );		// Slick
		wp_enqueue_style( 'wpos-font-awesome' );	// FontAwesome
		wp_enqueue_style( 'ibwp-tm-public-style' );
	}

	/**
	 * Function to add script at front side
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_front_end_script() {

		// Registring public script
		wp_register_script( 'ibwp-tm-public-script', IBWPL_TM_URL.'assets/js/ibwp-tm-public.js', array('jquery'), IBWPL_VERSION, true );
	}
}

$ibwpl_tm_script = new IBWPL_TM_Script();