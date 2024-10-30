<?php
/**
 * Admin Class 
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_BH_Admin {

	function __construct() {

		// Action to register admin menu
		add_action( 'admin_menu', array($this, 'ibwpl_bh_register_menu') );

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'ibwpl_bh_register_metabox') );

		// Action to save metabox value
		add_action( 'save_post_post', array($this, 'ibwpl_bh_save_metabox_value'), 10, 3 );

		// Action to get title change history
		add_action( 'wp_ajax_ibwpl_bh_title_change_history', array($this, 'ibwpl_bh_title_change_history') );

		// Filter to add screen id
		add_filter( 'ibwpl_screen_ids', array( $this, 'ibwpl_bh_add_screen_id') );
	}

	/**
	 * Function to register admin menus
	 * 
	 * @since 1.0
	 */
	function ibwpl_bh_register_menu() {
		add_submenu_page( IBWPL_PAGE_SLUG, __('Better Heading InboundWP Lite', 'inboundwp-lite'), __('Better Heading', 'inboundwp-lite'), 'manage_options', 'ibwp-bh-settings', array($this, 'ibwpl_bh_setting_page') );
	}

	/**
	 * Function to handle the setting page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_bh_setting_page() {
		include_once( IBWPL_BH_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Register Metabox
	 * 
	 * @since 1.0
	 */
	function ibwpl_bh_register_metabox() {

		$bh_post_types = ibwpl_bh_get_option( 'post_types', array() );

		if( $bh_post_types ) {
			
			$bh_post_types = array( 'post' );

			add_meta_box( 'ibwp-bh-post-sett', __( 'Better Heading - IBWP', 'inboundwp-lite' ), array($this, 'ibwpl_bh_sett_mb_content'), $bh_post_types, 'normal', 'default' );
		}
	}

	/**
	 * Metabox HTML
	 * 
	 * @since 1.0
	 */
	function ibwpl_bh_sett_mb_content() {
		include_once( IBWPL_BH_DIR .'/includes/admin/metabox/bh-sett-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @since 1.0
	 */
	function ibwpl_bh_save_metabox_value( $post_id, $post, $update ) {

		global $post_type;

		$bh_post_types = ibwpl_bh_get_option( 'post_types', array() );

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )					// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )	// Check Revision
		|| ( ! in_array( $post_type, $bh_post_types ) ) )						// Check Post Type
		{
			return $post_id;
		}

		$prefix 		= IBWPL_BH_META_PREFIX; // Taking metabox prefix
		$post_titles	= array();
		$enable			= isset( $_POST[$prefix.'enable'] )	? 1 : 0;
		$titles			= isset( $_POST[$prefix.'titles'] )	? $_POST[$prefix.'titles'] : '';

		// Validate Post Headings
		if( ! empty( $titles ) ) {
			foreach ( $titles as $title_key => $title_data ) {
				if( ! empty( $title_data ) ) {
					$post_titles[ $title_key ] = ibwpl_clean( $title_data );
				}
			}
		}

		// Enter Original Post Heading
		if( ! empty( $post_titles ) ) {
			$post_titles[0] = $post->post_title;
			
			ksort($post_titles); // Sort Array
		}

		update_post_meta( $post_id, $prefix.'enable', $enable );
		update_post_meta( $post_id, $prefix.'titles', $post_titles );
	}

	/**
	 * Function to get title change history
	 * 
 	 * @since 1.1
	 */
	function ibwpl_bh_title_change_history() {
		
		$result				= array();
		$result['success']	= 0;
		$result['msg']		= esc_html__('Sorry, Something happened wrong.', 'inboundwp-lite');
		$post_id			= isset( $_POST['post_id'] )	? ibwpl_clean_number( $_POST['post_id'] )	: 0;
		$title_id			= isset( $_POST['title_id'] )	? ibwpl_clean_number( $_POST['title_id'] )	: -1;
		$nonce				= isset( $_POST['nonce'] )		? $_POST['nonce']	: '';

		if( $post_id && $title_id >= 0 && wp_verify_nonce( $nonce, 'ibwp-bh-title-history-'.$title_id.$post_id ) ) {

			ob_start();

			// Title popup Data File
			include( IBWPL_BH_DIR . '/includes/admin/views/title-change-history.php' );

			$title_result = ob_get_clean();

			$result['success']	= 1;
			$result['msg']		= esc_html__('Success', 'inboundwp-lite');
			$result['data']		= $title_result;
		}

		wp_send_json( $result );
	}

	/**
	 * Function to add screen id
	 * 
 	 * @since 1.0
	 */
	function ibwpl_bh_add_screen_id( $screen_ids ) {

		$screen_ids['main'][] = IBWPL_BH_PAGE_SLUG;

		return $screen_ids;
	}
}

$ibwpl_bh_admin = new IBWPL_BH_Admin();