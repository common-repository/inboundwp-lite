<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_Script {

	function __construct() {

		// Action to define global javascript variable
		add_action( 'wp_print_scripts', array($this, 'ibwpl_global_script'), 5 );

		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_front_styles') );
		
		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_front_scripts') );
		
		// Action to add style and scripts in backend
		add_action( 'admin_enqueue_scripts', array($this, 'ibwpl_admin_styles_scripts') );
	}

	/**
	 * Function to define global javascript variable
	 * 
	 * @since 1.0
	 */
	function ibwpl_global_script() {

		global $is_IE, $ibwp_module_preview;

		$script_vars = array(
							'ibwp_is_rtl' 			=> is_rtl() 			? 1 : 0,
							'ibwp_is_ie' 			=> $is_IE				? 1 : 0,
							'ibwp_mobile' 			=> wp_is_mobile() 		? 1 : 0,
							'ibwpl_old_browser' 	=> ibwpl_old_browser() 	? 1 : 0,
							'ibwp_user_login'		=> is_user_logged_in()	? 1 : 0,
							'ibwp_ajaxurl' 			=> admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
							'ibwp_url' 				=> ibwpl_get_current_page_url(),
							'ibwp_mfp_close_text' 	=> __('Close', 'inboundwp-lite'),
							'ibwp_mfp_load_text' 	=> __('Loading...', 'inboundwp-lite'),
							'ibwp_module_preview'	=> $ibwp_module_preview,
						);
		$script_vars = apply_filters( 'ibwpl_global_script', $script_vars );

		$script  = "<script type='text/javascript'>";
		if( ! empty( $script_vars ) ) {
			foreach ($script_vars as $var_key => $var_val) {
				if( is_numeric( $var_val ) ) {
					$script .= "var {$var_key} = {$var_val}; ";
				} else {
					$script .= "var {$var_key} = '".esc_js($var_val)."'; ";
				}
			}
		}
		$script .= "</script>";

		echo $script;
	}

	/**
	 * Function to add style at front side
	 * 
	 * @since 1.0
	 */
	function ibwpl_front_styles() {

		// Registring font awesome css
		if( ! wp_style_is( 'wpos-font-awesome', 'registered' ) ) {
			wp_register_style( 'wpos-font-awesome', IBWPL_URL.'assets/css/font-awesome.min.css', array(), IBWPL_VERSION );
		}

		// Registring and enqueing tooltip css
		if( ! wp_style_is( 'ibwp-tooltip-style', 'registered' ) ) {
			wp_register_style( 'ibwp-tooltip-style', IBWPL_URL.'assets/css/tooltipster.min.css', array(), IBWPL_VERSION );
		}

		// Registring slick slider css
		if( ! wp_style_is( 'wpos-slick-style', 'registered' ) ) {
			wp_register_style( 'wpos-slick-style', IBWPL_URL.'assets/css/slick.css', array(), IBWPL_VERSION );
		}

		// Registring Magnific Popup CSS
		if( ! wp_style_is( 'wpos-magnific-style', 'registered' ) ) {
			wp_register_style( 'wpos-magnific-style', IBWPL_URL.'assets/css/magnific-popup.css', array(), IBWPL_VERSION );
		}

		// Registring Magnific Popup CSS
		if( ! wp_style_is( 'animate', 'registered' ) ) {
			wp_register_style( 'animate', IBWPL_URL.'assets/css/animate.min.css', array(), IBWPL_VERSION );
		}

		// Registring public style
		wp_register_style( 'ibwp-public-style', IBWPL_URL.'assets/css/ibwp-public.css', null, IBWPL_VERSION );
		wp_enqueue_style('ibwp-public-style');
	}

	/**
	 * Function to add script at front side
	 * 
	 * @since 1.0
	 */
	function ibwpl_front_scripts() {

		// Enqueue built in script
		wp_enqueue_script( 'jquery' );

		// Registring tooltip script
		if( ! wp_script_is( 'wpos-tooltip-script', 'registered' ) ) {
			wp_register_script( 'wpos-tooltip-script', IBWPL_URL.'assets/js/tooltipster.min.js', array('jquery'), IBWPL_VERSION, true );
		}

		// Filter JS
		if( ! wp_script_is( 'wpos-filter-script', 'registered' ) ) {
			wp_register_script( 'wpos-filter-script', IBWPL_URL.'assets/js/jquery.mixitup.min.js', array('jquery'), IBWPL_VERSION, true );
		}

		// Registring slick slider script
		if( ! wp_script_is( 'wpos-slick-jquery', 'registered' ) ) {
			wp_register_script( 'wpos-slick-jquery', IBWPL_URL.'assets/js/slick.min.js', array('jquery'), IBWPL_VERSION, true );
		}
		
		// Registring Magnific Popup Script
		if( ! wp_script_is( 'wpos-magnific-script', 'registered' ) ) {
			wp_register_script( 'wpos-magnific-script', IBWPL_URL.'assets/js/jquery.magnific-popup.min.js', array('jquery'), IBWPL_VERSION, true );
		}

		// Registring magnific popup script
		wp_register_script( 'ibwp-public-script', IBWPL_URL.'assets/js/ibwp-public.js', array('jquery'), IBWPL_VERSION, true );
	}

	/**
	 * Enqueue admin Styles and Scripts
	 * 
	 * @since 1.0
	 */
	function ibwpl_admin_styles_scripts( $hook ) {

		global $current_screen, $post_type, $wp_query, $wp_version;

		$post_support 	= IBWP_Lite()->post_supports; // Post type supports
		$ibwp_screen 	= is_ibwpl_screen();
		$screen_id    	= $current_screen ? $current_screen->id : '';
		$new_ui 		= $wp_version >= '3.5' ? 1 : 0;

		/*=== Admin Styles Start ===*/
		// Registring jQuery UI style
		wp_register_style( 'jquery-ui', IBWPL_URL.'assets/css/jquery-ui.min.css', array(), IBWPL_VERSION );

		// Registring Select 2 Style
		wp_register_style( 'select2', IBWPL_URL.'assets/css/select2.min.css', array(), IBWPL_VERSION );

		// Registring Tooltip Style
		wp_register_style( 'ibwp-tooltip-style', IBWPL_URL.'assets/css/tooltipster.min.css', array(), IBWPL_VERSION );		

		// Registring Admin Style
		wp_register_style( 'ibwp-admin-style', IBWPL_URL.'assets/css/ibwp-admin.css', array(), IBWPL_VERSION );
		/* Admin Styles Ends */


		/*=== Admin Script Starts ===*/
		// Color Picker Alpha
		wp_register_script( 'wp-color-picker-alpha', IBWPL_URL.'assets/js/wp-color-picker-alpha.js', array('wp-color-picker'), IBWPL_VERSION, true );

		// Filter JS
		wp_register_script( 'wpos-filter-script', IBWPL_URL.'assets/js/jquery.mixitup.min.js', array('jquery'), IBWPL_VERSION, true );

		// Registring select 2 script
		wp_register_script( 'select2', IBWPL_URL.'assets/js/select2.min.js', array('jquery'), IBWPL_VERSION, true );

		// Registring tooltip script
		wp_register_script( 'wpos-tooltip-script', IBWPL_URL.'assets/js/tooltipster.min.js', array('jquery'), IBWPL_VERSION, true );

		// Registring Jquery UI TimerPicker Addon Script
		wp_register_script( 'ibwp-timepicker-script', IBWPL_URL.'assets/js/jquery-ui-timepicker-addon.min.js', array('jquery'), IBWPL_VERSION, true );

		// Post sort ordering script
		wp_register_script( 'ibwp-ordering', IBWPL_URL . 'assets/js/ibwp-ordering.js', array( 'jquery-ui-sortable' ), IBWPL_VERSION, true );

		// Admin Script
		wp_register_script( 'ibwp-admin-script', IBWPL_URL.'assets/js/ibwp-admin.js', array('jquery'), IBWPL_VERSION, true );
		wp_localize_script( 'ibwp-admin-script', 'IBWPLAdmin', array(
														'new_ui' 				=>	$new_ui,
														'is_mobile' 			=> (wp_is_mobile()) ? 1 : 0,
														'syntax_highlighting'	=> ( 'false' === wp_get_current_user()->syntax_highlighting ) ? 0 : 1,
														'module_search_url'		=> ibwpl_get_current_page_url( array('remove_args' => array('search', 'settings-updated', 'message')) ),
														'reset_msg'				=> esc_html__( 'Click OK to reset all options. All settings will be lost!', 'inboundwp-lite' ),
														'cofirm_msg'			=> esc_html__( 'Are you sure you want to do this?', 'inboundwp-lite' ),
														'sorry_msg'				=> esc_html__( 'Sorry, Something happened wrong.', 'inboundwp-lite' ),
													));
		/* Admin Script Ends */


		// Post sorting - only when sorting by menu order on the post page
		if ( isset($post_support[$post_type]['sorting']) && $screen_id == 'edit-'.$post_type && isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) {
			wp_enqueue_script( 'ibwp-ordering' );
		}

		// Enqueue admin style and script on dashboard page
		if( $screen_id == 'toplevel_page_ibwp-dashboard' ) {
			wp_enqueue_style( 'ibwp-tooltip-style' );

			wp_enqueue_script( 'wpos-filter-script' );
			wp_enqueue_script( 'wpos-tooltip-script' );
		}

		// If page is plugin setting page then enqueue script
		if( $ibwp_screen || $screen_id == 'dashboard' ) {

			wp_enqueue_style( 'ibwp-admin-style' ); // Admin style

			wp_enqueue_script( 'ibwp-admin-script' ); // Admin script
		}

		// Premium Features Screen
		if( $screen_id == IBWPL_SCREEN_ID.'_page_ibwp-premium' ) {
			wp_enqueue_style( 'ibwp-tooltip-style' );
			wp_enqueue_script( 'wpos-tooltip-script' );
		}
	}
}