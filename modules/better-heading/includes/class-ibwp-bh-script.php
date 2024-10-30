<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_BH_Script {

	function __construct() {

		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'ibwpl_bh_admin_style_script') );

		// Action to add script in frontend
		add_action( 'wp_enqueue_scripts', array($this, 'ibwpl_bh_public_scripts') );
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @since 1.0
	 */
	function ibwpl_bh_admin_style_script( $hook ) {

		global $post, $post_type;

		// Taking some data
		$bh_post_types = ibwpl_bh_get_option( 'post_types', array() );

		// Scripts
		wp_register_script( 'ibwp-bh-admin-script', IBWPL_BH_URL.'assets/js/ibwp-bh-admin.js', array('jquery'), IBWPL_VERSION, true );
		wp_localize_script( 'ibwp-bh-admin-script', 'IBWPL_BH_Admin', array(
																		'remove_msg'	=> esc_html__('Click OK to remove title.', 'inboundwp-lite'),
																		'post_id'		=> isset( $post->ID ) ? $post->ID : 0,
																	));

		// Enqueue Required Script and Style
		if( ( in_array( $post_type, $bh_post_types ) && ($hook == 'post.php' || $hook == 'post-new.php') ) ) {
			
			// Style
			wp_enqueue_style( 'ibwp-admin-style' ); // Admin style

			// Script
			wp_enqueue_script( 'ibwp-admin-script' ); // Admin script
			wp_enqueue_script( 'ibwp-bh-admin-script' );
		}

		// Enqueue required Script and Style for setting page
		if( $hook == IBWPL_SCREEN_ID.'_page_ibwp-bh-settings' ) {

			// Select2
			wp_enqueue_style('select2');

			// Select2
			wp_enqueue_script('select2');
			wp_enqueue_script( 'ibwp-bh-admin-script' );
		}
	}

	/**
	 * Enqueue Public Scripts
	 * 
	 * @since 1.0
	 */
	function ibwpl_bh_public_scripts() {

		global $post;

		// Taking some data
		$prefix				= IBWPL_BH_META_PREFIX;
		$view_id			= 0;
		$home_url			= get_home_url();
		$post_id			= isset( $post->ID ) ? $post->ID : 0;
		$post_type			= isset( $post->post_type ) ? $post->post_type : false;
		$title_enable		= get_post_meta( $post_id, $prefix.'enable', true );
		$bh_post_types		= ibwpl_bh_get_option( 'post_types', array() );

		if( ! empty( $post_id ) && $title_enable && ! current_user_can('administrator') && ! empty( $_COOKIE['ibwp_bh_visitor'] ) && in_array($post_type, $bh_post_types) && is_singular($bh_post_types) && !is_preview() && !is_front_page() && !is_home() && !is_feed() && !is_robots() ) {

			/**
			 * If post page is directly open then only set title but no increment in title count
			 * If web page request is from another domain only set title but no increment in title count
			 */
			if( empty( $_SERVER['HTTP_REFERER'] ) || (isset( $_SERVER['HTTP_HOST'] ) && strpos( $home_url, $_SERVER['HTTP_HOST'] ) == false ) ) {
				$view_id = 0;
			} else {
				$view_id = $post_id;
			}
		}

		// Scripts
		wp_register_script( 'ibwp-bh-public-script', IBWPL_BH_URL.'assets/js/ibwp-bh-public.js', array('jquery'), IBWPL_VERSION, true );
		wp_localize_script( 'ibwp-bh-public-script', 'IBWPL_BH_Public', array(
																		'post_id' 	=> $view_id,
																		'post_type'	=> $post_type,
																	));

		if( $view_id ) {
			wp_enqueue_script( 'ibwp-bh-public-script' );
		}
	}
}

$ibwpl_bh_script = new IBWPL_BH_Script();