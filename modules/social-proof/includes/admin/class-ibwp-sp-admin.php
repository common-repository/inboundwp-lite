<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_SP_Admin {
	
	function __construct() {

		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'ibwpl_sp_register_menu'), 15 );

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'ibwpl_sp_register_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this, 'ibwpl_sp_save_metabox_value') );

		// Action to add custom column to Social Proof listing
		add_filter( 'manage_'.IBWPL_SP_POST_TYPE.'_posts_columns', array($this, 'ibwpl_sp_posts_columns') );

		// Action to add custom column data to Social Proof listing
		add_action('manage_'.IBWPL_SP_POST_TYPE.'_posts_custom_column', array($this, 'ibwpl_sp_post_columns_data'), 10, 2);

		// Filter to add screen id
		add_filter( 'ibwpl_screen_ids', array( $this, 'ibwpl_sp_add_screen_id') );
	}

	/**
	 * Function to add menu
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_register_menu() {

		// Register Setting page
		add_submenu_page( 'edit.php?post_type='.IBWPL_SP_POST_TYPE, __('Settings - Social Proof - IBWP', 'inboundwp-lite'), __('Settings', 'inboundwp-lite'), 'manage_options', 'ibwp-sp-settings', array($this, 'ibwpl_sp_settings_page') );
	}

	/**
	 * Function to handle the setting page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_settings_page() {
		include_once( IBWPL_SP_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Register Metabox
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_register_metabox() {
		
		$sp_post_types = ibwpl_sp_get_option( 'post_types', array() );

		// Add metabox in social proof post
		add_meta_box( 'ibwp-sp-nf-sett', __( 'Social Proof', 'inboundwp-lite' ), array($this, 'ibwpl_sp_meta_box_content'), IBWPL_SP_POST_TYPE, 'normal', 'high' );

		// Add metabox in social proof post
		add_meta_box( 'ibwp-sp-nf-preview', __( 'Social Proof Preview', 'inboundwp-lite' ), array($this, 'ibwpl_sp_preview_meta_box_content'), IBWPL_SP_POST_TYPE, 'side', 'default' );

		if( $sp_post_types ) {
			add_meta_box( 'ibwp-sp-post-sett', __( 'Social Proof - IBWP', 'inboundwp-lite' ), array($this, 'ibwpl_sp_sett_mb_content'), $sp_post_types, 'normal', 'default' );
		}
	}

	/**
	 * Function to handle social proof post meta
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_meta_box_content() {
		include_once( IBWPL_SP_DIR .'/includes/admin/metabox/post-sett-metabox.php');
	}

	/**
	 * Function to handle preview metabox content
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_preview_meta_box_content() {
		include_once( IBWPL_SP_DIR .'/includes/admin/metabox/preview-metabox.php');
	}

	/**
	 * Function to handle social proof enabled post type meta
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_sett_mb_content() {
		include_once( IBWPL_SP_DIR .'/includes/admin/metabox/sp-sett-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_save_metabox_value( $post_id ) {

		global $post_type;

		$prefix		= IBWPL_SP_META_PREFIX; // Taking metabox prefix		
		$post_types	= ibwpl_sp_get_option( 'post_types', array() );

		// Individual Post Meta
		if ( ! ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                // Check Autosave
		&& ( isset( $_POST['post_ID'] ) && $post_id == $_POST['post_ID'] )  	// Check Revision
		&& ( in_array( $post_type, $post_types ) ) )              				// Check if correct post type
		{

			$notification = isset( $_POST[$prefix.'notification'] ) ? ibwpl_clean_number( $_POST[$prefix.'notification'], '', 'number' )	: '';

			update_post_meta( $post_id, $prefix.'notification', $notification );
		}

		// Social Proof Meta
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  IBWPL_SP_POST_TYPE ) )              					// Check if correct post type
		{
			return $post_id;
		}

		// Getting saved values
		$tab			= isset( $_POST[$prefix.'tab'] )			? ibwpl_clean( $_POST[$prefix.'tab'] )			: '';
		$type			= isset( $_POST[$prefix.'type'] )			? ibwpl_clean( $_POST[$prefix.'type'] )			: '';
		$source_type	= isset( $_POST[$prefix.'source_type'] )	? ibwpl_clean( $_POST[$prefix.'source_type'] )	: '';
		$source_type	= ( $source_type == 'custom' || $source_type == 'woocommerce' || $source_type == 'edd' )	? $source_type : 'custom';

		// Behaviour Settings
		$behaviour						= isset( $_POST[$prefix.'behaviour'] )		? $_POST[$prefix.'behaviour']							: array();
		$behaviour['initial_delay']		= isset( $behaviour['initial_delay'] )		? ibwpl_clean_number( $behaviour['initial_delay'], 3 ) 	: 3;
		$behaviour['delay_between']		= isset( $behaviour['delay_between'] )		? ibwpl_clean_number( $behaviour['delay_between'], 6 ) 	: 6;
		$behaviour['delay_between']		= ( $behaviour['delay_between'] > 1 )		? $behaviour['delay_between'] 							: 2;
		$behaviour['loop']				= ! empty( $behaviour['loop'] )				? 1 : 0;
		$behaviour['link_target']		= ! empty( $behaviour['link_target'] )		? 1 : 0;
		$behaviour['cls_btn']			= ! empty( $behaviour['cls_btn'] )			? 1 : 0;

		// Content Settings
		$content						= isset( $_POST[$prefix.'content'] )		? $_POST[$prefix.'content']									: array();
		$content['nf_template']			= ! empty( $content['nf_template'] )		? ibwpl_clean_html( trim( $content['nf_template'] ), true )	: "";
		$content['nf_template']			= ! empty( $content['nf_template'] )		? ibwpl_clean_line_breaks( $content['nf_template'] )		: "{name} from {country} just purchased\n{title}\nAbout {time} ago";
		$content['link_type']			= isset( $content['link_type'] )			? ibwpl_clean( $content['link_type'] )						: '';
		$content['custom_link']			= isset( $content['custom_link'] )			? ibwpl_clean_url( $content['custom_link'] )				: '';
		$content['nf_image']			= isset( $content['nf_image'] )				? ibwpl_clean( $content['nf_image'] )						: '';

		// Custom Notification
		$custom_nf_arr	= array();
		$custom_nf		= isset( $_POST[$prefix.'custom_nf'] ) ? $_POST[$prefix.'custom_nf'] : array();

		if( ! empty( $custom_nf ) ) {
			foreach ($custom_nf as $custom_nf_key => $custom_nf_data) {

				$custom_nf_title	= isset( $custom_nf_data['title'] )		? ibwpl_clean( $custom_nf_data['title'] )			: '';
				$custom_nf_name		= isset( $custom_nf_data['name'] )		? ibwpl_clean( $custom_nf_data['name'] )			: '';
				$custom_nf_email	= isset( $custom_nf_data['email'] )		? ibwpl_clean( $custom_nf_data['email'] )			: '';
				$custom_nf_city		= isset( $custom_nf_data['city'] )		? ibwpl_clean( $custom_nf_data['city'] )			: '';
				$custom_nf_state	= isset( $custom_nf_data['state'] )		? ibwpl_clean( $custom_nf_data['state'] )			: '';
				$custom_nf_country	= isset( $custom_nf_data['country'] )	? ibwpl_clean( $custom_nf_data['country'] )			: '';
				$custom_nf_time		= isset( $custom_nf_data['time'] )		? ibwpl_clean( $custom_nf_data['time'] )			: '';
				$custom_nf_image	= isset( $custom_nf_data['image'] )		? ibwpl_clean_url( $custom_nf_data['image'] )		: '';
				$custom_nf_url		= isset( $custom_nf_data['url'] )		? ibwpl_clean_url( $custom_nf_data['url'] )			: '';
				$custom_nf_rating	= isset( $custom_nf_data['rating'] )	? ibwpl_clean_number( $custom_nf_data['rating'] )	: '';

				$custom_nf_arr[ $custom_nf_key ]['title']	= $custom_nf_title;
				$custom_nf_arr[ $custom_nf_key ]['name']	= $custom_nf_name;
				$custom_nf_arr[ $custom_nf_key ]['email']	= $custom_nf_email;
				$custom_nf_arr[ $custom_nf_key ]['city']	= $custom_nf_city;
				$custom_nf_arr[ $custom_nf_key ]['state']	= $custom_nf_state;
				$custom_nf_arr[ $custom_nf_key ]['country']	= $custom_nf_country;
				$custom_nf_arr[ $custom_nf_key ]['image']	= $custom_nf_image;
				$custom_nf_arr[ $custom_nf_key ]['url']		= $custom_nf_url;
				$custom_nf_arr[ $custom_nf_key ]['time']	= $custom_nf_time;
				$custom_nf_arr[ $custom_nf_key ]['rating']	= $custom_nf_rating;
			}

			$custom_nf = $custom_nf_arr;
		}

		// Advance Tab Settings
		$advance					= isset( $_POST[$prefix.'advance'] )	? $_POST[$prefix.'advance']								: array();
		$advance['show_credit']		= ! empty( $advance['show_credit'] )	? 1	: 0;
		$advance['mobile_disable']	= ! empty( $advance['mobile_disable'] )	? 1	: 0;

		// Update Meta
		update_post_meta( $post_id, $prefix.'tab', $tab );
		update_post_meta( $post_id, $prefix.'type', $type );
		update_post_meta( $post_id, $prefix.'source_type', $source_type );
		update_post_meta( $post_id, $prefix.'behaviour', $behaviour );
		update_post_meta( $post_id, $prefix.'content', $content );
		update_post_meta( $post_id, $prefix.'custom_nf', $custom_nf );
		update_post_meta( $post_id, $prefix.'advance', $advance );
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_posts_columns( $columns ) {

		$new_columns['ibwp_sp_type']			= esc_html__('Type', 'inboundwp-lite');
		$new_columns['ibwpl_sp_source_type']	= esc_html__('Source', 'inboundwp-lite');

		$columns = ibwpl_add_array( $columns, $new_columns, 1, true );

		return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_post_columns_data( $column, $post_id ) {

		$prefix = IBWPL_SP_META_PREFIX;

		switch ($column) {
			case 'ibwp_sp_type':
				$types	= ibwpl_sp_type_options();
				$type	= get_post_meta( $post_id, $prefix.'type', true );
				$type	= isset( $types[ $type ] ) ? $types[ $type ] : $type;

				echo $type;
				break;

			case 'ibwpl_sp_source_type':
				$ource_types	= ibwpl_sp_source_type();
				$source_type	= get_post_meta( $post_id, $prefix.'source_type', true );
				$source_type	= isset( $ource_types[ $source_type ] ) ? $ource_types[ $source_type ] : $source_type;

				echo $source_type;
				break;
		}
	}

	/**
	 * Function to add screen id
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_add_screen_id( $screen_ids ) {

		$screen_ids['main'][] = IBWPL_SP_POST_TYPE;

		return $screen_ids;
	}
}

$ibwpl_sp_admin = new IBWPL_SP_Admin();