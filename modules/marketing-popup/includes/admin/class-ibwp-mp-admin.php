<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_MP_Admin {

	function __construct() {

		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'ibwpl_mp_register_menu'), 15 );

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'ibwpl_mp_register_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this, 'ibwpl_mp_save_metabox_value') );

		// Action to add custom column to Popup listing
		add_filter( 'manage_'.IBWPL_MP_POST_TYPE.'_posts_columns', array($this, 'ibwpl_mp_posts_columns') );

		// Action to add custom column data to Popup listing
		add_action('manage_'.IBWPL_MP_POST_TYPE.'_posts_custom_column', array($this, 'ibwpl_mp_post_columns_data'), 10, 2);

		// Filter to add row data
		add_filter( 'post_row_actions', array($this, 'ibwpl_mp_add_post_row_data'), 10, 2 );

		// Filter to add screen id
		add_filter( 'ibwpl_screen_ids', array( $this, 'ibwpl_mp_add_screen_id') );
	}

	/**
	 * Function to add menu
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_register_menu() {

		// Register Form Entries page
		add_submenu_page( 'edit.php?post_type='.IBWPL_MP_POST_TYPE, __('Form Entries - Marketing Popup', 'inboundwp-lite'), __('Form Entries', 'inboundwp-lite'), 'manage_options', 'ibwp-mp-form-entries', array($this, 'ibwpl_mp_form_entries_page') );

		// Register Report page
		add_submenu_page( 'edit.php?post_type='.IBWPL_MP_POST_TYPE, __('Reports - Marketing Popup', 'inboundwp-lite'), __('Reports', 'inboundwp-lite'), 'manage_options', 'ibwp-mp-reports', array($this, 'ibwpl_mp_report_page') );

		// Register Export page
		add_submenu_page( 'edit.php?post_type='.IBWPL_MP_POST_TYPE, __('Tools - Marketing Popup', 'inboundwp-lite'), __('Tools', 'inboundwp-lite'), 'manage_options', 'ibwp-mp-tools', array($this, 'ibwpl_mp_tools_page') );

		// Register Setting page
		add_submenu_page( 'edit.php?post_type='.IBWPL_MP_POST_TYPE, __('Settings - Marketing Popup - IBWP', 'inboundwp-lite'), __('Settings', 'inboundwp-lite'), 'manage_options', 'ibwp-mp-pro-settings', array($this, 'ibwpl_mp_settings_page') );
	}

	/**
	 * Function to handle the setting page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_settings_page() {
		include_once( IBWPL_MP_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Function to handle the report page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_report_page() {
		include_once( IBWPL_MP_DIR . '/includes/admin/report/reports.php' );
	}

	/**
	 * Function to handle the export page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_tools_page() {
		include_once( IBWPL_MP_DIR . '/includes/admin/tools/export.php' );
	}

	/**
	 * Function to handle the form entries page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_form_entries_page() {

		if( isset( $_GET['action'] ) && $_GET['action'] == 'view' && ! empty( $_GET['entry_id'] ) ) {
			include_once( IBWPL_MP_DIR . '/includes/admin/form/form-entries-view.php' );
		} else {
			include_once( IBWPL_MP_DIR . '/includes/admin/form/form-entries.php' );
		}
	}

	/**
	 * Register Metabox
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_register_metabox() {
		
		$mp_post_types = ibwpl_mp_get_option( 'post_types', array() );

		// Add metabox in popup posts
		add_meta_box( 'ibwp-mp-popup-sett', __( 'Marketing Popup', 'inboundwp-lite' ), array($this, 'ibwpl_mp_meta_box_content'), IBWPL_MP_POST_TYPE, 'normal', 'high' );

		// Add metabox in popup posts
		add_meta_box( 'ibwp-mp-popup-report', __( 'Popup Report', 'inboundwp-lite' ), array($this, 'ibwpl_mp_report_meta_box_content'), IBWPL_MP_POST_TYPE, 'side', 'default' );

		if( $mp_post_types ) {
			add_meta_box( 'ibwp-mp-post-sett', __( 'Marketing Popup - IBWP', 'inboundwp-lite' ), array($this, 'ibwpl_mp_sett_mb_content'), $mp_post_types, 'normal', 'default' );
		}
	}

	/**
	 * Function to handle metabox content
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_meta_box_content() {
		include_once( IBWPL_MP_DIR .'/includes/admin/metabox/post-sett-metabox.php');
	}

	/**
	 * Function to handle metabox content
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_report_meta_box_content() {
		include_once( IBWPL_MP_DIR .'/includes/admin/metabox/report-metabox.php');
	}

	/**
	 * Metabox HTML
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_sett_mb_content() {
		include_once( IBWPL_MP_DIR .'/includes/admin/metabox/mp-sett-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_save_metabox_value( $post_id ) {

		global $post_type;

		$prefix		= IBWPL_MP_META_PREFIX; // Taking metabox prefix		
		$post_types	= ibwpl_mp_get_option( 'post_types', array() );

		// Individual Post Meta
		if ( ! ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                // Check Autosave
		&& ( isset( $_POST['post_ID'] ) && $post_id == $_POST['post_ID'] )  	// Check Revision
		&& ( in_array( $post_type, $post_types ) ) )              				// Check if correct post type
		{

			$welcome_popup	= isset( $_POST[$prefix.'welcome_popup'] )	? ibwpl_clean_number( $_POST[$prefix.'welcome_popup'], '', 'number' )	: '';

			update_post_meta( $post_id, $prefix.'welcome_popup', $welcome_popup );
		}

		// Popup Meta
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  IBWPL_MP_POST_TYPE ) )              					// Check if correct post type
		{
			return $post_id;
		}

		// Getting saved values
		$tab			= isset( $_POST[$prefix.'tab'] )			? ibwpl_clean( $_POST[$prefix.'tab'] )			: '';
		$popup_goal		= isset( $_POST[$prefix.'popup_goal'] )		? ibwpl_clean( $_POST[$prefix.'popup_goal'] )	: __('email-lists', 'inboundwp-lite');
		$popup_type		= isset( $_POST[$prefix.'popup_type'] )		? ibwpl_clean( $_POST[$prefix.'popup_type'] )	: __('modal', 'inboundwp-lite');
		$popup_type		= ( $popup_type == 'modal' )				? $popup_type									: 'modal';
		
		// Behaviour Settings
		$behaviour					= isset( $_POST[$prefix.'behaviour'] )	? $_POST[$prefix.'behaviour'] : array();
		$behaviour['open_delay']	= isset( $behaviour['open_delay'] )		? ibwpl_clean_number( $behaviour['open_delay'], '') : '';
		$behaviour['hide_close']	= ! empty( $behaviour['hide_close'] )	? 1	: 0;
		$behaviour['clsonesc']		= ! empty( $behaviour['clsonesc'] )		? 1	: 0;

		// Content Settings
		$content					= isset( $_POST[$prefix.'content'] )	? $_POST[$prefix.'content']								: array();
		$content['main_heading']	= isset( $content['main_heading'] )		? ibwpl_clean( $content['main_heading'] )				: '';
		$content['sub_heading']		= isset( $content['sub_heading'] )		? ibwpl_clean( $content['sub_heading'] )				: '';
		$content['security_note']	= isset( $content['security_note'] )	? ibwpl_clean( $content['security_note'] )				: '';
		$content['popup_content']	= isset( $content['popup_content'] )	? ibwpl_clean_html( $content['popup_content'], true )	: '';

		// Collect Email Settings
		$form_fields				= array();
		$content['form_fields']		= isset( $content['form_fields'] )		? $content['form_fields']							: array();
		$content['submit_btn_txt']	= isset( $content['submit_btn_txt'] )	? ibwpl_clean( $content['submit_btn_txt'] )			: '';
		$content['thanks_msg']		= isset( $content['thanks_msg'] )		? ibwpl_clean_html( $content['thanks_msg'], true )	: '';

		// Email Field always be there and required by default
		$content['form_fields'][0]['type'] 		= 'email';
		$content['form_fields'][0]['require']	= 1;

		if( ! empty( $content['form_fields'] ) ) {
			foreach ($content['form_fields'] as $field_key => $field_data) {

				$field_require		= ! empty( $field_data['require'] )		? 1	: 0;
				$field_type			= ! empty( $field_data['type'] )		? ibwpl_clean( $field_data['type'] )			: 'text';
				$field_label		= isset( $field_data['label'] )			? ibwpl_clean( $field_data['label'] )		: '';
				$field_placeholder	= isset( $field_data['placeholder'] )	? ibwpl_clean( $field_data['placeholder'] )	: '';

				$form_fields[ $field_key ]['type']			= $field_type;
				$form_fields[ $field_key ]['label']			= $field_label;
				$form_fields[ $field_key ]['placeholder']	= $field_placeholder;
				$form_fields[ $field_key ]['require']		= $field_require;
			}

			$content['form_fields'] = $form_fields;
		}

		// Target URL Settings
		$content['target_url']['btn1_text']		= isset( $content['target_url']['btn1_text'] )		? ibwpl_clean( $content['target_url']['btn1_text'] )		: '';
		$content['target_url']['btn1_link']		= isset( $content['target_url']['btn1_link'] )		? ibwpl_clean_url( $content['target_url']['btn1_link'] )	: '';
		$content['target_url']['btn1_target']	= isset( $content['target_url']['btn1_target'] )	? ibwpl_clean( $content['target_url']['btn1_target'] )	: '';
		$content['target_url']['btn2_text']		= isset( $content['target_url']['btn2_text'] )		? ibwpl_clean( $content['target_url']['btn2_text'] )		: '';
		$content['target_url']['btn2_link']		= isset( $content['target_url']['btn2_link'] )		? ibwpl_clean_url( $content['target_url']['btn2_link'] )	: '';
		$content['target_url']['btn2_target']	= isset( $content['target_url']['btn2_target'] )	? ibwpl_clean( $content['target_url']['btn2_target'] )	: '';

		// Phone Calls Settings
		$content['phone_calls']['btn_txt']		= isset( $content['phone_calls']['btn_txt'] )	? ibwpl_clean( $content['phone_calls']['btn_txt'] )				: '';
		$content['phone_calls']['phone_num']	= isset( $content['phone_calls']['phone_num'] )	? ibwpl_clean_number( $content['phone_calls']['phone_num'], '' )	: '';

		// Social Settings
		$social						= isset( $_POST[$prefix.'social'] )	? $_POST[$prefix.'social']	: array();
		$social_traffic_data		= array();
		$social['social_traffic']	= isset( $social['social_traffic'] ) ? $social['social_traffic'] : array();

		if( ! empty( $social['social_traffic'] ) ) {
			foreach ($social['social_traffic'] as $social_key => $social_data) {
				
				$social_data_name = isset( $social_data['name'] ) ? ibwpl_clean( $social_data['name'] )		: '';
				$social_data_link = isset( $social_data['link'] ) ? ibwpl_clean_url( $social_data['link'] )	: '';

				if( empty( $social_data_name ) || empty( $social_data_link ) ) {
					continue;
				}

				$social_traffic_data[ $social_key ]['name'] = $social_data_name;
				$social_traffic_data[ $social_key ]['link'] = $social_data_link;
			}

			$social['social_traffic'] = $social_traffic_data;
		}

		// Design Settings
		$design							= isset( $_POST[$prefix.'design'] )			? $_POST[$prefix.'design']									: array();
		$design['template']				= isset( $design['template'] )				? ibwpl_clean( $design['template'] )						: '';
		$design['overlay_img']			= isset( $design['overlay_img'] )			? ibwpl_clean_url( $design['overlay_img'] )					: '';
		$design['overlay_color']		= ! empty( $design['overlay_color'] )		? ibwpl_clean_color( $design['overlay_color'] )				: 'rgba(11,11,11,0.8)';
		$design['popup_img']			= isset( $design['popup_img'] )				? ibwpl_clean_url( $design['popup_img'] )					: '';
		$design['popup_img_size']		= isset( $design['popup_img_size'] )		? ibwpl_clean( $design['popup_img_size'] )					: '';
		$design['popup_img_repeat']		= isset( $design['popup_img_repeat'] )		? ibwpl_clean( $design['popup_img_repeat'] )				: '';
		$design['popup_img_pos']		= isset( $design['popup_img_pos'] )			? ibwpl_clean( $design['popup_img_pos'] )					: '';
		$design['bg_color']				= isset( $design['bg_color'] )				? ibwpl_clean_color( $design['bg_color'] )					: '';
		$design['content_color']		= isset( $design['content_color'] )			? ibwpl_clean_color( $design['content_color'] )				: '';
		$design['snote_txtcolor']		= isset( $design['snote_txtcolor'] )		? ibwpl_clean_color( $design['snote_txtcolor'] )			: '';

		// Notification Settings
		$notification					= isset( $_POST[$prefix.'notification'] )	? $_POST[$prefix.'notification']						: array();
		$notification['email_subject']	= isset( $notification['email_subject'] )	? ibwpl_clean( $notification['email_subject'] ) 			: '';
		$notification['email_msg']		= isset( $notification['email_msg'] )		? ibwpl_clean_html( $notification['email_msg'], true ) 	: '';
		$notification['enable_email']	= ! empty( $notification['enable_email'] )	? 1	: 0;

		// Advance Settings
		$advance					= isset( $_POST[$prefix.'advance'] )	? $_POST[$prefix.'advance']								: array();
		$advance['cookie_expire']	= isset( $advance['cookie_expire'] )	? ibwpl_clean( $advance['cookie_expire'] ) 				: '';
		$advance['cookie_expire']	= ( $advance['cookie_expire'] != '' )	? ibwpl_clean_number( $advance['cookie_expire'], '' )	: '';
		$advance['cookie_unit']		= ( $advance['cookie_unit'] == 'day' )	? ibwpl_clean( $advance['cookie_unit'] )				: 'day';
		$advance['show_credit']		= ! empty( $advance['show_credit'] )	? 1	: 0;
		$advance['mobile_disable']	= ! empty( $advance['mobile_disable'] )	? 1	: 0;

		// Update Meta
		update_post_meta( $post_id, $prefix.'tab', $tab );
		update_post_meta( $post_id, $prefix.'popup_goal', $popup_goal );
		update_post_meta( $post_id, $prefix.'popup_type', $popup_type );
		update_post_meta( $post_id, $prefix.'behaviour', $behaviour );
		update_post_meta( $post_id, $prefix.'content', $content );
		update_post_meta( $post_id, $prefix.'design', $design );
		update_post_meta( $post_id, $prefix.'social', $social );
		update_post_meta( $post_id, $prefix.'notification', $notification );
		update_post_meta( $post_id, $prefix.'advance', $advance );
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_posts_columns( $columns ) {

		$new_columns['ibwp_mp_popup_goal']	= esc_html__('Goal', 'inboundwp-lite');
		$new_columns['ibwp_mp_popup_type']	= esc_html__('Type', 'inboundwp-lite');

		$columns = ibwpl_add_array( $columns, $new_columns, 1, true );

		return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_post_columns_data( $column, $post_id ) {

		$prefix 		= IBWPL_MP_META_PREFIX;
		$popup_views 	= 0;
		$popup_clicks 	= 0;

		switch ($column) {
			case 'ibwp_mp_popup_goal':
				$popup_goals	= ibwpl_mp_popup_goals();
				$popup_goal		= get_post_meta( $post_id, $prefix.'popup_goal', true );
				$popup_goal		= isset( $popup_goals[ $popup_goal ]['name'] ) ? $popup_goals[ $popup_goal ]['name'] : $popup_goal;

				echo $popup_goal;
				break;

			case 'ibwp_mp_popup_type':
				$popup_types	= ibwpl_mp_popup_types();
				$popup_type		= get_post_meta( $post_id, $prefix.'popup_type', true );
				$popup_type		= isset( $popup_types[ $popup_type ]['name'] ) ? $popup_types[ $popup_type ]['name'] : $popup_type;

				echo $popup_type;
				break;
		}
	}

	/**
	 * Function to add custom quick links at post listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_add_post_row_data( $actions, $post ) {

		// Post row data filter
		if( $post->post_type == IBWPL_MP_POST_TYPE ) {

			$entry_link		= add_query_arg( array( 'post_type' => IBWPL_MP_POST_TYPE, 'page' => 'ibwp-mp-form-entries', 'popup_id' => $post->ID ), admin_url( 'edit.php' ) );

			$new_actions	= array( 'ibwp_mp_entry' => '<a href="'.esc_url( $entry_link ).'" target="_blank">'.esc_html__( 'Entries', 'inboundwp-lite' ).'</a>' );
			$actions		= ibwpl_add_array( $actions, $new_actions, 2 );
		}

		return $actions;
	}

	/**
	 * Function to add screen id
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_add_screen_id( $screen_ids ) {

		$screen_ids['main'][] = IBWPL_MP_POST_TYPE;

		return $screen_ids;
	}
}

$ibwpl_mp_admin = new IBWPL_MP_Admin();