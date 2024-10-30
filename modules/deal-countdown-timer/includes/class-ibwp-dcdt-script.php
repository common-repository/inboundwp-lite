<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Ibwpl_Dcdt_Script {

	function __construct() {

		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array( $this, 'ibwpl_dcdt_front_style' ) );

		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array( $this, 'ibwpl_dcdt_front_script' ) );

		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array( $this, 'ibwpl_dcdt_admin_style' ) );

		// Action to add script in backend
		add_action( 'admin_enqueue_scripts', array( $this, 'ibwpl_dcdt_admin_script' ) );
	}

	/**
	 * Function to add style at front side
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_front_style() {

		if ( class_exists( 'WooCommerce' ) || class_exists( 'Easy_Digital_Downloads' ) ) {
			// Registring and enqueing public css
			wp_register_style( 'ibwp-dcdt-public-css', IBWPL_DCDT_URL.'assets/css/ibwp-dcdt-public.css', array(), IBWPL_VERSION );
			wp_enqueue_style( 'ibwp-dcdt-public-css' );
		}
		
		wp_enqueue_style( 'wpos-slick-style' );
	}

	/**
	 * Function to add script at front side
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_front_script() {

		if ( class_exists( 'WooCommerce' ) || class_exists( 'Easy_Digital_Downloads' ) ) {
			wp_register_script( 'ibwp-dcdt-public-js', IBWPL_DCDT_URL.'assets/js/ibwp-dcdt-public.js', array('jquery'), IBWPL_VERSION, true );
					
			wp_register_script( 'ibwp-dcdt-countereverest-js', IBWPL_DCDT_URL.'assets/js/jquery.counteverest.min.js', array('jquery'), IBWPL_VERSION, true );
			wp_enqueue_script('wpos-slick-jquery');
		}
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_admin_style( $hook ) {

		global $post_type;

		// If page is plugin setting page then enqueue script
		if( $post_type == IBWPL_DCDT_POST_TYPE || $post_type == 'product' || $post_type == 'download') {

			wp_register_style( 'ibwp-dcdt-time-picker-css', IBWPL_DCDT_URL.'assets/css/ibwp-dcdt-time-picker.css', null, IBWPL_VERSION );
			wp_register_style( 'ibwp-dcdt-admin-css', IBWPL_DCDT_URL.'assets/css/ibwp-dcdt-admin.css', null, IBWPL_VERSION );

			wp_enqueue_style('wp-color-picker');			// Color Picker
			wp_enqueue_style('select2');					// Select2
			wp_enqueue_style( 'ibwp-dcdt-time-picker-css' );
			wp_enqueue_style( 'ibwp-dcdt-admin-css' );
		}
	}

	/**
	 * Enqueue admin script
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_admin_script( $hook ) {
		global $wp_version, $post_type;

		$new_ui = $wp_version >= '3.5' ? '1' : '0'; // Check wordpress version for older scripts
		
		// If page is plugin setting page then enqueue script
		if( $post_type == IBWPL_DCDT_POST_TYPE || $post_type == 'product' || $post_type == 'download') {

			wp_register_script( 'ibwp-dcdt-admin-js', IBWPL_DCDT_URL.'assets/js/ibwp-dcdt-admin.js', array('jquery'), IBWPL_VERSION, true );

			wp_enqueue_script( 'wp-color-picker' );			// ColorPicker
			wp_enqueue_script('select2');					// Select2
			wp_enqueue_script( 'jquery-ui-datepicker' );	// DatePicker
			wp_enqueue_script( 'ibwp-timepicker-script' );	// TimePicker
			wp_enqueue_script( 'ibwp-dcdt-admin-js' );
		}
	}
}

$ibwpl_dcdt_script = new Ibwpl_Dcdt_Script();