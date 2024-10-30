<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_Wtcs_Admin {
	
	function __construct() {

		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'ibwpl_wtcs_register_menu'), 15 );

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'ibwpl_wtcs_add_agent_metabox') );

		// Action to save metabox
		add_action( 'save_post_'.IBWPL_WTCS_POST_TYPE, array($this,'ibwpl_wtcs_save_metabox_value') );

		// Action to add custom column at agent listing
		add_filter( 'manage_posts_columns', array($this, 'ibwpl_wtcs_posts_columns'), 10, 2 );

		// Action to add custom column data
		add_action('manage_'.IBWPL_WTCS_POST_TYPE.'_posts_custom_column', array($this, 'ibwpl_wtcs_post_columns_data'), 10, 2);

		// Add some support to post like sorting and etc
		add_filter( 'ibwpl_post_supports', array($this, 'ibwpl_wtcs_post_supports') );

		// Filter to add screen id
		add_filter( 'ibwpl_screen_ids', array( $this, 'ibwpl_wtcs_add_screen_id') );
	}

	/**
	 * Function to add menu
	 * 
	 * @since 1.0
	 */
	function ibwpl_wtcs_register_menu() {

		// Register Setting page
		add_submenu_page( 'edit.php?post_type='.IBWPL_WTCS_POST_TYPE, __('Settings - WhatsApp Chat Support', 'inboundwp-lite'), __('Settings', 'inboundwp-lite'), 'manage_options', 'ibwp-wtcs-settings', array($this, 'ibwpl_wtacs_settings_page') );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @since 1.0
	 */
	function ibwpl_wtacs_settings_page() {		
		include_once( IBWPL_WTCS_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Function to register metabox
	 * 
	 * @since 1.0
	 */
	function ibwpl_wtcs_add_agent_metabox() {
		
		// Agent Detial
		add_meta_box( 'ibwp-wtcs-details', __( 'Agent Details', 'inboundwp-lite' ), array($this, 'ibwpl_wtcs_meta_box_content'), IBWPL_WTCS_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Function to handle metabox content
	 * 
	 * @since 1.0
	 */
	function ibwpl_wtcs_meta_box_content() {
		include_once( IBWPL_WTCS_DIR .'/includes/admin/metabox/post-sett-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @since 1.0
	 */
	function ibwpl_wtcs_save_metabox_value( $post_id ) {

		global $post_type;

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  IBWPL_WTCS_POST_TYPE ) )              				// Check if correct post type
		{
			return $post_id;
		}

		$prefix = IBWPL_WTCS_META_PREFIX; // Taking metabox prefix

		// Getting saved values
		$agent_name		= isset( $_POST[$prefix.'agent_name'] ) 	? ibwpl_clean( $_POST[$prefix.'agent_name'] ) 		: '';
		$country_code 	= isset( $_POST[$prefix.'country_code'] )	? ibwpl_clean( $_POST[$prefix.'country_code'] ) 		: '';
		$whatapp_number = isset( $_POST[$prefix.'whatapp_number'] )	? ibwpl_clean( $_POST[$prefix.'whatapp_number'] ) 	: '';
		$designation 	= isset( $_POST[$prefix.'designation'] ) 	? ibwpl_clean( $_POST[$prefix.'designation'] ) 		: '';
		$status 		= !empty( $_POST[$prefix.'status'] ) 		? ibwpl_clean( $_POST[$prefix.'status'] ) 			: 'online';
		$custom_message = ! empty($_POST[$prefix.'custom_message']) ? sanitize_textarea_field( $_POST[$prefix.'custom_message'] ) : '';

		update_post_meta( $post_id, $prefix.'agent_name', $agent_name );
		update_post_meta( $post_id, $prefix.'country_code', $country_code );
		update_post_meta( $post_id, $prefix.'whatapp_number', $whatapp_number );
		update_post_meta( $post_id, $prefix.'designation', $designation );
		update_post_meta( $post_id, $prefix.'status', $status );
		update_post_meta( $post_id, $prefix.'custom_message', $custom_message );

		if( $status == 'custom' ) {
			$over_time_message	= ! empty( $_POST[$prefix.'over_time_message'] )	? ibwpl_clean( $_POST[$prefix.'over_time_message'] ) : '';
			update_post_meta( $post_id, $prefix.'over_time_message', $over_time_message );
		}
	}

	/**
	 * Add custom column to listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_wtcs_posts_columns( $columns, $post_type ) {

		if( $post_type == IBWPL_WTCS_POST_TYPE ) {

			$new_columns['ibwp_wtcs_status'] 	= esc_html__('Status', 'inboundwp-lite');
			$new_columns['ibwp_wtcs_image'] 	= esc_html__('Profile Image', 'inboundwp-lite');

			$columns = ibwpl_add_array( $columns, $new_columns, 1, true);
		}

		return $columns;
	}

	/**
	 * Add custom column data
	 * 
 	 * @since 1.0
	 */
	function ibwpl_wtcs_post_columns_data( $column, $post_id ) {
		
		$prefix = IBWPL_WTCS_META_PREFIX; // Metabox prefix

		switch ( $column ) {
			case 'ibwp_wtcs_image':

				$image = ibwpl_get_featured_image( $post_id, 'thumbnail' );
				$value = ( $image ) ? '<img class="ibwp-avatar-image" height="40" width="40" src="'.esc_url( $image ).'" alt="" />' : '--';

				echo $value;
				break;

			case 'ibwp_wtcs_status':

				$status = get_post_meta( $post_id, $prefix.'status', true );
				
				echo ucfirst( $status );
				break;
		}
	}

	/**
	 * Function to add support to post like sorting etc
	 * 
 	 * @since 1.0
	 */
	function ibwpl_wtcs_post_supports( $supports ) {

		$supports[IBWPL_WTCS_POST_TYPE] = array(
											'row_data_post_id' => true
										);
		return $supports;
	}

	/**
	 * Function to add screen id
	 * 
 	 * @since 1.0
	 */
	function ibwpl_wtcs_add_screen_id( $screen_ids ) {

		$screen_ids['main'][] = IBWPL_WTCS_POST_TYPE;

		return $screen_ids;
	}
}

$ibwpl_wtcs_admin = new IBWPL_Wtcs_Admin();