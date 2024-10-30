<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_Wtcs_Script {

	function __construct() {

		// Action to add style on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_wtcs_front_end_style') );

		// Action to add script on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_wtcs_front_end_script') );

		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'ibwpl_wtcs_admin_style_script') );
	}

	/**
	 * Function to add style at front side
	 * 
	 * @subpackage WhatsApp Chat Support
 	 * @since 1.0
 	 */
	function ibwpl_wtcs_front_end_style() {

		wp_enqueue_style('wpos-font-awesome');

		wp_register_style( 'ibwp-wtcs-public-style', IBWPL_WTCS_URL.'assets/css/ibwp-wtcs-public.css', array(), IBWPL_VERSION );
		wp_enqueue_style( 'ibwp-wtcs-public-style' );
	}

	/**
	 * Function to add script at front side
	 * 
	 * @subpackage WhatsApp Chat Support
	 * @since 1.0
	 */
	function ibwpl_wtcs_front_end_script() {

		// Taking some data
		$ganaly_enable	= ibwpl_wtcs_get_option( 'ganaly_enable' );
		$ganaly_id		= ibwpl_wtcs_get_option( 'ganaly_id' );

		wp_register_script( 'ibwp-wtcs-public-script', IBWPL_WTCS_URL.'assets/js/ibwp-wtcs-public.js', array('jquery'), IBWPL_VERSION, true );
		wp_localize_script( 'ibwp-wtcs-public-script', 'IBWPL_WTCS', array(
																	'google_analytics' => ( $ganaly_enable && $ganaly_id ) ? 1 : 0,
																));
		wp_enqueue_script( 'ibwp-wtcs-public-script' );
	}

	/**
	 * Enqueue admin styles & scripts
	 * 
	 * @subpackage WhatsApp Chat Support
	 * @since 1.0
	 */
	function ibwpl_wtcs_admin_style_script( $hook ) {

		global $typenow;

		if( $typenow == IBWPL_WTCS_POST_TYPE ) {

			/* Style */
			// Color Picker
			wp_enqueue_style('wp-color-picker');

			// Select2
			wp_enqueue_style('select2');


			/* Script */
			wp_enqueue_script('wp-color-picker');	// Color Picker
			wp_enqueue_script('select2');			// Select2
		}
	}
}

$ibwpl_wtcs_script = new IBWPL_Wtcs_Script();