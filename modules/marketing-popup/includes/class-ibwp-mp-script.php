<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_MP_Script {
	
	function __construct() {
		
		// Action to add style on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_mp_front_end_style') );

		// Action to add script on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_mp_front_end_script') );

		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'ibwpl_mp_admin_style_script') );
	}

	/**
	 * Function to add style at front side
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_front_end_style() {

		wp_register_style( 'ibwp-mp-public', IBWPL_MP_URL.'assets/css/ibwp-mp-public.css', array(), IBWPL_VERSION );

		// Enqueue Style
		wp_enqueue_style('wpos-font-awesome');
		wp_enqueue_style('wpos-magnific-style');
		wp_enqueue_style('ibwp-mp-public');
	}

	/**
	 * Function to add script at front side
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_front_end_script() {

		wp_register_script( 'ibwp-mp-public', IBWPL_MP_URL.'assets/js/ibwp-mp-public.js', array('jquery'), IBWPL_VERSION, true );

		// Enqueue Script
		wp_enqueue_script('wpos-magnific-script');
		wp_enqueue_script('ibwp-public-script');
		wp_enqueue_script('ibwp-mp-public');
	}

	/**
	 * Enqueue admin styles & scripts
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_admin_style_script( $hook ) {

		global $post, $post_type, $typenow;

		// Taking some data
		$mp_post_types	= ibwpl_mp_get_option( 'post_types', array() );
		$pages_arr		= array(
								IBWPL_MP_POST_TYPE.'_page_ibwp-mp-pro-settings',
								IBWPL_MP_POST_TYPE.'_page_ibwp-mp-tools'
							);

		// Styles
		wp_register_style( 'ibwp-mp-admin-style', IBWPL_MP_URL.'assets/css/ibwp-mp-admin.css', array(), IBWPL_VERSION );

		// Scripts
		wp_register_script( 'ibwp-mp-admin-script', IBWPL_MP_URL.'assets/js/ibwp-mp-admin.js', array('jquery'), IBWPL_VERSION, true );
		wp_localize_script( 'ibwp-mp-admin-script', 'IBWPL_MP_Admin', array(
																		'popup_id' => isset( $post->ID ) ? $post->ID : 0,
																	));

		// Enqueue Required Script and Style
		if( $post_type == IBWPL_MP_POST_TYPE && ($hook == 'post.php' || $hook == 'post-new.php') ) {

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
			wp_enqueue_media();								// For media uploader

			// WP CSS Code Editor
			wp_enqueue_code_editor( array(
					'type' 			=> 'text/css',
					'codemirror' 	=> array(
						'indentUnit' 	=> 2,
						'tabSize'		=> 2,
					),
				) );
		}

		// Enqueue Required Script and Style for Popup Post Type
		if( in_array( $hook, $pages_arr ) ) {

			// Style
			wp_enqueue_style('select2');					// Select2
			wp_enqueue_style('jquery-ui');					// jQuery UI

			// Script
			wp_enqueue_script('select2');					// Select2
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script('ibwp-timepicker-script');	// TimerPicker
		}

		// For Popup Post Type
		if( $typenow == IBWPL_MP_POST_TYPE ) {
			wp_enqueue_style( 'ibwp-mp-admin-style' );
			wp_enqueue_script('ibwp-mp-admin-script');
		}

		// Enqueue Required Script and Style
		if( in_array( $post_type, $mp_post_types ) && ($hook == 'post.php' || $hook == 'post-new.php') ) {

			// Style
			wp_enqueue_style('select2');				// Select2
			wp_enqueue_style('ibwp-admin-style');		// Admin style

			// Script
			wp_enqueue_script('select2');				// Select2
			wp_enqueue_script('ibwp-admin-script');		// Admin script
		}
	}
}

$ibwpl_mp_script = new IBWPL_MP_Script();