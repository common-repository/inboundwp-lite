<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @package Social Proof 
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_SP_Script {

	function __construct() {

		// Action to add style on frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_sp_front_style_script') );

		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'ibwpl_sp_admin_style_script') );
	}

	/**
	 * Enqueue front end styles
	 * 
	 * @package Social Proof 
	 * @since 1.0
	 */
	function ibwpl_sp_front_style_script() {

		// Registring Styles
		wp_register_style( 'ibwp-sp-public-style', IBWPL_SP_URL.'assets/css/ibwp-sp-public.css', array(), IBWPL_VERSION );

		// Styles
		wp_enqueue_style('wpos-font-awesome');
		wp_enqueue_style('ibwp-sp-public-style');


		// Registring Scripts
		wp_register_script( 'ibwp-sp-public-js', IBWPL_SP_URL.'assets/js/ibwp-sp-public.js', array(), IBWPL_VERSION, true );

		// Scripts
		wp_enqueue_script('ibwp-public-script');
		wp_enqueue_script('ibwp-sp-public-js');
	}

	/**
	 * Enqueue admin styles & scripts
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_admin_style_script( $hook ) {

		global $post, $post_type, $typenow;

		// Taking some data
		$sp_post_types	= ibwpl_sp_get_option( 'post_types', array() );
		$pages_arr		= array(
								IBWPL_SP_POST_TYPE.'_page_ibwp-sp-settings',
							);

		// Styles
		wp_register_style( 'ibwp-sp-admin-style', IBWPL_SP_URL.'assets/css/ibwp-sp-admin.css', array(), IBWPL_VERSION );

		// Scripts
		wp_register_script( 'ibwp-sp-admin-script', IBWPL_SP_URL.'assets/js/ibwp-sp-admin.js', array('jquery'), IBWPL_VERSION, true );

		// Enqueue Required Script and Style
		if( $post_type == IBWPL_SP_POST_TYPE && ($hook == 'post.php' || $hook == 'post-new.php') ) {

			// Style
			wp_enqueue_style('select2');					// Select2
			wp_enqueue_style('wp-color-picker');			// Color Picker
			wp_enqueue_script('wp-color-picker-alpha');		// Color Picker Alpha
			wp_enqueue_style('ibwp-tooltip-style');			// Tooltip

			// Script
			wp_enqueue_script('select2');					// Select2
			wp_enqueue_script('wp-color-picker');			// Color Picker
			wp_enqueue_script( 'wpos-tooltip-script' );		// Tooltip
			wp_enqueue_media();								// For media uploader
		}

		// Enqueue Required Script and Style for Social Proof Post Type
		if( in_array( $hook, $pages_arr ) ) {

			// Style
			wp_enqueue_style('select2');	// Select2

			// Script
			wp_enqueue_script('select2');	// Select2
		}

		// For Social Proof Post Type
		if( $typenow == IBWPL_SP_POST_TYPE ) {
			wp_enqueue_style( 'ibwp-sp-admin-style' );
			wp_enqueue_script( 'ibwp-sp-admin-script' );
		}

		// Enqueue Required Script and Style
		if( in_array( $post_type, $sp_post_types ) && ($hook == 'post.php' || $hook == 'post-new.php') ) {

			// Style
			wp_enqueue_style('select2');				// Select2
			wp_enqueue_style('ibwp-admin-style');		// Admin style

			// Script
			wp_enqueue_script('select2');				// Select2
			wp_enqueue_script('ibwp-admin-script');		// Admin script
		}
	}
}

$ibwpl_sp_script = new IBWPL_SP_Script();