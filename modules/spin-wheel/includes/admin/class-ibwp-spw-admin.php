<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Ibwpl_Spw_Admin {

	function __construct() {

		// Action to add admin menu
		add_action( 'admin_menu', array( $this, 'ibwpl_spw_register_menu' ), 9 );

		// Action to add metabox
		add_action( 'add_meta_boxes', array( $this, 'ibwpl_spw_register_metabox' ) );

		// Action to save metabox
		add_action( 'save_post', array($this, 'ibwpl_spw_save_metabox_value') );

		// Filter to add row data
		add_filter( 'post_row_actions', array($this, 'ibwpl_spw_add_post_row_data'), 10, 2 );

		// Filter to add screen id
		add_filter( 'ibwpl_screen_ids', array( $this, 'ibwpl_spw_add_screen_id') );
	}

	/**
	 * Function to register admin menus
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_register_menu() {

		// Register Form Entries page
		add_submenu_page( 'edit.php?post_type='.IBWPL_SPW_POST_TYPE, __('Form Entries - Spin Wheel', 'inboundwp-lite'), __('Form Entries', 'inboundwp-lite'), 'manage_options', 'ibwp-spw-form-entries', array($this, 'ibwpl_spw_form_entries_page') );

		// Register Report page
		add_submenu_page( 'edit.php?post_type='.IBWPL_SPW_POST_TYPE, __('Reports - Spin Wheel', 'inboundwp-lite'), __('Reports', 'inboundwp-lite'), 'manage_options', 'ibwp-spw-reports', array($this, 'ibwpl_spw_report_page') );

		// Register Export page
		add_submenu_page( 'edit.php?post_type='.IBWPL_SPW_POST_TYPE, __('Tools - Spin Wheel', 'inboundwp-lite'), __('Tools', 'inboundwp-lite'), 'manage_options', 'ibwp-spw-tools', array($this, 'ibwpl_spw_tools_page') );

		// Register Settings Page
		add_submenu_page( 'edit.php?post_type='.IBWPL_SPW_POST_TYPE, __('Settings Spin Wheel - IBWP', 'inboundwp-lite'), __('Settings', 'inboundwp-lite'), 'manage_options', 'ibwp-spw-settings', array($this, 'ibwpl_spw_settings_page') );		
	}

	/**
	 * Function to handle the form entries page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_form_entries_page() {

		if( isset( $_GET['action'] ) && $_GET['action'] == 'view' && ! empty( $_GET['entry_id'] ) ) {
			include_once( IBWPL_SPW_DIR . '/includes/admin/form/form-entries-view.php' );
		} else {
			include_once( IBWPL_SPW_DIR . '/includes/admin/form/form-entries.php' );
		}
	}

	/**
	 * Function to handle the report page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_report_page() {
		include_once( IBWPL_SPW_DIR . '/includes/admin/report/reports.php' );
	}

	/**
	 * Function to handle the export page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_tools_page() {
		include_once( IBWPL_SPW_DIR . '/includes/admin/tools/export.php' );
	}

	/**
	 * Function to handle the setting page html
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_settings_page() {
		include_once( IBWPL_SPW_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Register Metabox
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_register_metabox() {

		$spw_post_types = ibwpl_spw_get_option( 'post_types', array() );

		// Add metabox in spin wheel post
		add_meta_box( 'ibwp-spw-wheel-sett', __( 'Spin Wheel', 'inboundwp-lite' ), array($this, 'ibwpl_spw_meta_box_content'), IBWPL_SPW_POST_TYPE, 'normal', 'high' );

		// Add metabox in spin wheel report
		add_meta_box( 'ibwp-spw-wheel-report', __( 'Spin Wheel Report', 'inboundwp-lite' ), array($this, 'ibwpl_spw_report_meta_box_content'), IBWPL_SPW_POST_TYPE, 'side', 'default' );

		if( $spw_post_types ) {
			add_meta_box( 'ibwp-spw-post-sett', __( 'Spin Wheel - IBWP', 'inboundwp-lite' ), array($this, 'ibwpl_spw_sett_mb_content'), $spw_post_types, 'normal', 'default' );
		}
	}

	/**
	 * Function to handle metabox content
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_sett_mb_content() {
		include_once( IBWPL_SPW_DIR .'/includes/admin/metabox/spw-sett-metabox.php');
	}

	/**
	 * Function to handle metabox content
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_report_meta_box_content() {
		include_once( IBWPL_SPW_DIR .'/includes/admin/metabox/report-metabox.php');
	}

	/**
	 * Function to handle metabox content
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_meta_box_content() {
		include_once( IBWPL_SPW_DIR .'/includes/admin/metabox/post-sett-metabox.php');
	}

	/**
	* Save metabox value
	* 
	* @since 1.0
	*/
	function ibwpl_spw_save_metabox_value( $post_id ) {

		global $post_type;

		$prefix		= IBWPL_SPW_META_PREFIX; // Taking metabox prefix		
		$post_types	= ibwpl_spw_get_option( 'post_types', array() );

		// Individual Post Meta
		if ( ! ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                // Check Autosave
		&& ( isset( $_POST['post_ID'] ) && $post_id == $_POST['post_ID'] )  	// Check Revision
		&& ( in_array( $post_type, $post_types ) ) )              				// Check if correct post type
		{

			$welcome_wheel	= isset( $_POST[$prefix.'welcome_wheel'] )	? ibwpl_clean_number( $_POST[$prefix.'welcome_wheel'], '', 'number' )	: '';

			update_post_meta( $post_id, $prefix.'welcome_wheel', $welcome_wheel );
		}

		// Popup Meta
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  IBWPL_SPW_POST_TYPE ) )              				// Check if correct post type
		{
			return $post_id;
		}
	   
		// Taking metabox prefix
		$tab = isset($_POST[$prefix.'tab'])	?  ibwpl_clean( $_POST[$prefix.'tab'] ) : '';

		// Behaviour Tab Settings
		$behaviour						= isset( $_POST[$prefix.'behaviour'] )		? $_POST[$prefix.'behaviour']								: array();
		$behaviour['wheel_speed']		= isset( $behaviour['wheel_speed'] )		? ibwpl_clean_number( $behaviour['wheel_speed'], '') 		: '';
		$behaviour['wheel_spin_dur']	= isset( $behaviour['wheel_spin_dur'] )		? ibwpl_clean_number( $behaviour['wheel_spin_dur'], '') 	: '';
		$behaviour['open_delay']		= isset( $behaviour['open_delay'] )			? ibwpl_clean_number( $behaviour['open_delay'], '') 		: '';
		$behaviour['hide_close']		= ! empty( $behaviour['hide_close'] )		? 1	: 0;
		$behaviour['clsonesc']			= ! empty( $behaviour['clsonesc'] )			? 1	: 0;

		// Segment Tab Settings
		$wheel_segments				= array();
		$segment					= isset( $_POST[$prefix.'segment'] )	? $_POST[$prefix.'segment']		: array();
		$segment['wheel_segments']	= isset( $segment['wheel_segments'] )	? $segment['wheel_segments']	: array();

		if( ! empty( $segment['wheel_segments'] ) ) {
			foreach ($segment['wheel_segments'] as $segment_key => $segment_data) {

				$segment_type			= isset( $segment_data['type'] )			? ibwpl_clean( $segment_data['type'] )					: '';
				$segment_label			= isset( $segment_data['label'] )			? ibwpl_clean( $segment_data['label'] )					: '';
				$segment_coupon			= isset( $segment_data['coupon_code'] )		? ibwpl_clean( $segment_data['coupon_code'] )			: '';
				$segment_probability	= isset( $segment_data['probability'] )		? ibwpl_clean_number( $segment_data['probability'] )	: '';
				$segment_redirect_url	= isset( $segment_data['redirect_url'] )	? ibwpl_clean_url( $segment_data['redirect_url'] )		: '';
				$segment_bg_clr			= ! empty( $segment_data['bg_clr'] )		? ibwpl_clean_color( $segment_data['bg_clr'] )			: '#23282d';
				$segment_lbl_clr		= ! empty( $segment_data['lbl_clr'] )		? ibwpl_clean_color( $segment_data['lbl_clr'] )			: '#ffffff';
				$segment_custom_msg		= isset( $segment_data['custom_msg'] )		? ibwpl_clean_html( $segment_data['custom_msg'], true )	: '';

				$wheel_segments[ $segment_key ]['type']				= $segment_type;
				$wheel_segments[ $segment_key ]['label']			= $segment_label;
				$wheel_segments[ $segment_key ]['coupon_code']		= $segment_coupon;
				$wheel_segments[ $segment_key ]['probability']		= $segment_probability;
				$wheel_segments[ $segment_key ]['redirect_url']		= $segment_redirect_url;
				$wheel_segments[ $segment_key ]['bg_clr']			= $segment_bg_clr;
				$wheel_segments[ $segment_key ]['lbl_clr']			= $segment_lbl_clr;
				$wheel_segments[ $segment_key ]['custom_msg']		= $segment_custom_msg;
			}

			$wheel_segments				= array_slice( $wheel_segments, 0, 4 );
			$segment['wheel_segments']	= $wheel_segments;
		}

		// Content Tab Settings
		$content						= isset( $_POST[$prefix.'content'] )		? $_POST[$prefix.'content']								: array();
		$content['title']				= isset( $content['title'] )				? ibwpl_clean( $content['title'] )						: '';
		$content['sub_title']			= isset( $content['sub_title'] )			? ibwpl_clean( $content['sub_title'] )					: '';
		$content['icon_tooltip_txt']	= isset( $content['icon_tooltip_txt'] )		? ibwpl_clean( $content['icon_tooltip_txt'] )			: '';
		$content['button_txt']			= ! empty( $content['button_txt'] )			? ibwpl_clean( $content['button_txt'] )					: 'Try to Spin';
		$content['cust_close_txt']		= isset( $content['cust_close_txt'] )		? ibwpl_clean( $content['cust_close_txt'] )				: '';
		$content['wheel_content']		= isset( $content['wheel_content'] )		? ibwpl_clean_html( $content['wheel_content'], true )	: '';

		// Collect Email Settings
		$form_fields			= array();
		$content['form_fields']	= isset( $content['form_fields'] ) ? $content['form_fields'] : array();

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

		// Design Tab Settings
		$design							= isset( $_POST[$prefix.'design'] )				? $_POST[$prefix.'design']									: array();
		$design['wheel_icon_pos']		= isset( $design['wheel_icon_pos'] )			? ibwpl_clean( $design['wheel_icon_pos'] )					: 'bottom-right';
		$design['wheel_bg_img']			= isset( $design['wheel_bg_img'] )				? ibwpl_clean_url( $design['wheel_bg_img'] )					: '';
		$design['wheel_img_size']		= isset( $design['wheel_img_size'] )			? ibwpl_clean( $design['wheel_img_size'] )					: '';
		$design['wheel_img_repeat']		= isset( $design['wheel_img_repeat'] )			? ibwpl_clean( $design['wheel_img_repeat'] )					: '';
		$design['wheel_img_pos']		= isset( $design['wheel_img_pos'] )				? ibwpl_clean( $design['wheel_img_pos'] )					: '';
		$design['wheel_bg_clr']			= isset( $design['wheel_bg_clr'] )				? ibwpl_clean_color( $design['wheel_bg_clr'] )				: '';
		$design['content_color']		= isset( $design['content_color'] )				? ibwpl_clean_color( $design['content_color'] )				: '';
		$design['tooltip_bg_clr']		= isset( $design['tooltip_bg_clr'] )			? ibwpl_clean_color( $design['tooltip_bg_clr'] )				: '';
		$design['tooltip_txt_clr']		= isset( $design['tooltip_txt_clr'] )			? ibwpl_clean_color( $design['tooltip_txt_clr'] )			: '';
		$design['custom_close_txtclr']	= isset( $design['custom_close_txtclr'] )		? ibwpl_clean_color( $design['custom_close_txtclr'] )		: '';
		$design['wheel_pointer_clr']	= isset( $design['wheel_pointer_clr'] )			? ibwpl_clean_color( $design['wheel_pointer_clr'] )			: '';
		$design['wheel_border_clr']		= ! empty( $design['wheel_border_clr'] )		? ibwpl_clean_color( $design['wheel_border_clr'] )			: '#ffffff';
		$design['wheel_dots_clr']		= ! empty( $design['wheel_dots_clr'] )			? ibwpl_clean_color( $design['wheel_dots_clr'] )				: '#23282d';
		$design['wheel_pointer_bg_clr']	= ! empty( $design['wheel_pointer_bg_clr'] )	? ibwpl_clean_color( $design['wheel_pointer_bg_clr'] )		: '#ffffff';

		// Advance Tab Settings
		$advance						= isset( $_POST[$prefix.'advance'] )		? $_POST[$prefix.'advance']								: array();
		$advance['cookie_expire']		= isset( $advance['cookie_expire'] )		? ibwpl_clean( $advance['cookie_expire'] ) 				: '';
		$advance['cookie_expire']		= ( $advance['cookie_expire'] != '' )		? ibwpl_clean_number( $advance['cookie_expire'], '' )	: '';
		$advance['cookie_unit']			= ( $advance['cookie_unit'] == 'day' )		? ibwpl_clean( $advance['cookie_unit'] )				: 'day';
		$advance['mobile_disable']		= ! empty( $advance['mobile_disable'] )		? 1	: 0;

		// Notification Settings
		$notification					= isset( $_POST[$prefix.'notification'] )	? $_POST[$prefix.'notification']						: array();
		$notification['email_subject']	= isset( $notification['email_subject'] )	? ibwpl_clean( $notification['email_subject'] ) 			: '';
		$notification['email_msg']		= isset( $notification['email_msg'] )		? ibwpl_clean_html( $notification['email_msg'], true ) 	: '';
		$notification['enable_email']	= ! empty( $notification['enable_email'] )	? 1	: 0;

		// Update Meta
		update_post_meta( $post_id, $prefix.'tab', $tab );
		update_post_meta( $post_id, $prefix.'behaviour', $behaviour );
		update_post_meta( $post_id, $prefix.'segment', $segment );
		update_post_meta( $post_id, $prefix.'content', $content );
		update_post_meta( $post_id, $prefix.'design', $design );
		update_post_meta( $post_id, $prefix.'advance', $advance );
		update_post_meta( $post_id, $prefix.'notification', $notification );
	}

	/**
	 * Function to add custom quick links at post listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_add_post_row_data( $actions, $post ) {

		// Post row data filter
		if( $post->post_type == IBWPL_SPW_POST_TYPE ) {

			$entry_link		= add_query_arg( array( 'post_type' => IBWPL_SPW_POST_TYPE, 'page' => 'ibwp-spw-form-entries', 'wheel_id' => $post->ID ), admin_url( 'edit.php' ) );

			$new_actions	= array( 'ibwp_spw_entry' => '<a href="'.esc_url( $entry_link ).'" target="_blank">'.esc_html__( 'Entries', 'inboundwp-lite' ).'</a>' );
			$actions		= ibwpl_add_array( $actions, $new_actions, 2 );
		}

		return $actions;
	}

	/**
	 * Function to add screen id
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_add_screen_id( $screen_ids ) {

		$screen_ids['main'][] = IBWPL_SPW_POST_TYPE;

		return $screen_ids;
	}
}

$ibwpl_spw_admin = new Ibwpl_Spw_Admin();