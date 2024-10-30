<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Ibwpl_Spw_Script {

	function __construct() {

		// Action to add style on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_spw_front_end_style') );

		// Action to add script on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_spw_front_end_script') );

		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'ibwpl_spw_admin_style_script') );
	}

	/**
	 * Function to add style at front side
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_front_end_style() {

		wp_register_style( 'ibwp-spw-public-style', IBWPL_SPW_URL.'assets/css/ibwp-spw-public.css', array(), IBWPL_VERSION );

		// Enqueue Style
		wp_enqueue_style('wpos-font-awesome');
		wp_enqueue_style('wpos-magnific-style');
		wp_enqueue_style('ibwp-spw-public-style');
	}

	/**
	 * Function to add script at front side
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_front_end_script() {

		wp_register_script( 'ibwp-spw-public-script', IBWPL_SPW_URL.'assets/js/ibwp-spw-public.js', array('jquery'), IBWPL_VERSION, true );

		// Enqueue Script
		wp_enqueue_script('wpos-magnific-script');
		wp_enqueue_script('ibwp-public-script');
		wp_enqueue_script('ibwp-spw-public-script');
	}

	/**
	 * Enqueue admin styles & scripts
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_admin_style_script( $hook ) {

		global $post, $post_type, $typenow;

		// Taking some data
		$spw_post_types = ibwpl_spw_get_option( 'post_types', array() );
		$pages_arr		= array(
								IBWPL_SPW_POST_TYPE.'_page_ibwp-spw-settings',
								IBWPL_SPW_POST_TYPE.'_page_ibwp-spw-reports',
								IBWPL_SPW_POST_TYPE.'_page_ibwp-spw-tools'
							);

		// Styles
		wp_register_style( 'ibwp-spw-admin-style', IBWPL_SPW_URL.'assets/css/ibwp-spw-admin.css', array(), IBWPL_VERSION );

		// Scripts
		wp_register_script( 'ibwp-spw-admin-script', IBWPL_SPW_URL.'assets/js/ibwp-spw-admin.js', array('jquery'), IBWPL_VERSION, true );
		wp_localize_script( 'ibwp-spw-admin-script', 'IBWPL_SPW_Admin', array(
																		'wheel_id'			=> isset( $post->ID ) ? $post->ID : 0,
																		'segment_limit_msg' => __('You can add only 4 segments of spin wheel.', 'inboundwp-lite'),
																	));

		// Enqueue Required Script and Style
		if( $post_type == IBWPL_SPW_POST_TYPE && ($hook == 'post.php' || $hook == 'post-new.php') ) {

			// Style
			wp_enqueue_style('wp-color-picker');			// Color Picker
			wp_enqueue_script('wp-color-picker-alpha');		// Color Picker Alpha
			wp_enqueue_style('select2');					// Select2
			wp_enqueue_style('jquery-ui');					// jQuery UI
			wp_enqueue_style('ibwp-tooltip-style');			// Tooltip

			// Script
			wp_enqueue_script('wp-color-picker');			// Color Picker
			wp_enqueue_script('select2');					// Select2
			wp_enqueue_script( 'jquery-ui-datepicker' );	// TimerPicker
			wp_enqueue_script('ibwp-timepicker-script');
			wp_enqueue_script( 'wpos-tooltip-script' );		// Tooltip
			wp_enqueue_editor();							// WP Editor
			wp_enqueue_media();								// For media uploader
		}

		// Enqueue Required Script and Style for Wheel Post Type
		if( in_array( $hook, $pages_arr ) ) {

			// Style
			wp_enqueue_style('select2');					// Select2
			wp_enqueue_style('jquery-ui');					// jQuery UI

			// Script
			wp_enqueue_script('select2');					// Select2
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script('ibwp-timepicker-script');	// TimerPicker
		}

		// For Spin Wheel Post Type
		if( $typenow == IBWPL_SPW_POST_TYPE ) {
			wp_enqueue_style( 'ibwp-spw-admin-style' );
			wp_enqueue_script('ibwp-spw-admin-script');
		}

		// Enqueue Required Script and Style for Post Type metabox
		if( in_array( $post_type, $spw_post_types ) && ($hook == 'post.php' || $hook == 'post-new.php') ) {

			// Style
			wp_enqueue_style('select2');				// Select2
			wp_enqueue_style('ibwp-admin-style');		// Admin style

			// Script
			wp_enqueue_script('select2');				// Select2
			wp_enqueue_script('ibwp-admin-script');		// Admin script
		}
	}
}

$ibwpl_spw_script = new Ibwpl_Spw_Script();