<?php
/**
 * Public Class
 *
 * Handles the Public side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_Spw_Public {

	function __construct() {

		// Render Spin Wheel
		add_action( 'wp_footer', array($this, 'ibwpl_spw_render_wheel') );

		// Add action to process spin wheel form submission
		add_action( 'wp_ajax_ibwpl_spw_wheel_form_submit', array($this, 'ibwpl_spw_wheel_form_submit') );
		add_action( 'wp_ajax_nopriv_ibwpl_spw_wheel_form_submit', array($this,'ibwpl_spw_wheel_form_submit') );
	}

	/**
	 * Function to render spin wheel
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_render_wheel() {

		global $post;

		// Taking some data
		$prefix		= IBWPL_SPW_META_PREFIX;
		$post_id	= isset( $post->ID )		? $post->ID			: '';
		$post_type	= isset( $post->post_type )	? $post->post_type	: '';
		$enable 	= ibwpl_spw_get_option( 'enable' );
		$enable		= apply_filters('ibwpl_spw_render_wheel', $enable, $post );

		// If not globally enable
		if ( ! $enable ) {
			return false;
		}

		/* Display Welcome Spin Wheel Starts */
		$enabled_post_types 	= ibwpl_spw_get_option( 'post_types', array() );
		$welcome_wheel			= get_post_meta( $post_id, $prefix.'welcome_wheel', true );
		
		// Check Post Type Meta else Global
		if( $welcome_wheel && in_array( $post_type, $enabled_post_types ) ) {

			$enable_welcome_wheel = true;

		} else {

			$welcome_wheel			= ibwpl_spw_get_option( 'welcome_wheel' );
			$welcome_display_in 	= ibwpl_spw_get_option( 'welcome_display_in' );
			$enable_welcome_wheel	= ibwpl_spw_check_active( $welcome_display_in );
		}

		if( $welcome_wheel > 0 && $enable_welcome_wheel ) {
			$this->ibwpl_spw_create_wheel( $welcome_wheel );
		}
	}

	/**
	 * Function to create spin wheel HTML
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_create_wheel( $wheel_id = 0 ) {

		global $ibwp_spw_design_sett;

		$prefix			= IBWPL_SPW_META_PREFIX;
		$post_status	= ibwpl_get_post_status( $wheel_id );
		$advance 		= ibwpl_get_meta( $wheel_id, $prefix.'advance', true );
		$mobile_disable	= ! empty( $advance['mobile_disable'] ) ? 1 : 0;

		// If valid post is there
		if( $post_status != 'publish' || ( wp_is_mobile() && $mobile_disable ) ) {
			return false;
		}

		// Checking advance setting
		$current_time	= current_time( 'timestamp' );
		$cookie_prefix	= ibwpl_spw_get_option( 'cookie_prefix' );

		// Check Cookie
		if( isset( $advance['cookie_expire'] ) && $advance['cookie_expire'] !== '' && ! empty( $_COOKIE[ $cookie_prefix.$wheel_id ] ) ) {
			return false;
		}

		// Taking some prior data data
		$segment = ibwpl_get_meta( $wheel_id, $prefix.'segment', true );

		// Check Segment
		if( empty( $segment ) || ! is_array( $segment ) ) {
			return false;
		}

		// Taking some data
		$behaviour 	= ibwpl_get_meta( $wheel_id, $prefix.'behaviour', true );
		$content 	= ibwpl_get_meta( $wheel_id, $prefix.'content', true );
		$design 	= ibwpl_get_meta( $wheel_id, $prefix.'design', true );

		// Assign value to global var
		$ibwp_spw_design_sett	= $design;

		// Taking behaviour tab data
		$hide_close 	= ! empty( $behaviour['hide_close'] )	? false : true;
		$clsonesc		= ! empty( $behaviour['clsonesc'] )		? true	: false;
		$open_delay		= ! empty( $behaviour['open_delay'] )	? ( $behaviour['open_delay'] * 1000 )	: 0;
		$wheel_speed	= isset( $behaviour['wheel_speed'] )	? $behaviour['wheel_speed']				: '';
		$wheel_spin_dur	= isset( $behaviour['wheel_spin_dur'] )	? $behaviour['wheel_spin_dur']			: '';

		// Segmet data
		$wheel_segments = array_slice( $segment['wheel_segments'] , 0, 4 );

		foreach ( $wheel_segments as $wheel_segment_key => $wheel_segment_data ) {

			// Taking some variable
			$segment_label[]		= isset( $wheel_segment_data['label'] )		? $wheel_segment_data['label']		: '';
			$segment_lbl_clr[]		= isset( $wheel_segment_data['lbl_clr'] )	? $wheel_segment_data['lbl_clr']	: '';
			$segment_bg_clr[]		= isset( $wheel_segment_data['bg_clr'] )	? $wheel_segment_data['bg_clr']		: '';
		}

		// Taking content tab data
		$atts['wheel_id']			= $wheel_id;
		$atts['style']				= $this->ibwpl_spw_generate_wheel_style( $wheel_id );
		$atts['title']				= isset( $content['title'] )				? $content['title']						: '';
		$atts['sub_title']			= isset( $content['sub_title'] )			? $content['sub_title']					: '';
		$atts['icon_tooltip_txt']	= isset( $content['icon_tooltip_txt'] )		? $content['icon_tooltip_txt']			: '';
		$atts['button_txt']			= isset( $content['button_txt'] )			? $content['button_txt']				: '';
		$atts['cust_close_txt']		= isset( $content['cust_close_txt'] )		? $content['cust_close_txt']			: '';
		$atts['form_fields']		= isset( $content['form_fields'] )			? $content['form_fields']				: array();
		$atts['wheel_content']		= isset( $content['wheel_content'] )		? do_shortcode( wpautop( $content['wheel_content'] ) )	: '';

		// Taking design tab data
		$wheel_border_clr			= isset( $design['wheel_border_clr'] )		? $design['wheel_border_clr']		: '';
		$wheel_dots_clr				= isset( $design['wheel_dots_clr'] )		? $design['wheel_dots_clr']			: '';
		$wheel_pointer_bg_clr		= isset( $design['wheel_pointer_bg_clr'] )	? $design['wheel_pointer_bg_clr']	: '';
		$atts['wheel_icon_pos']		= isset( $design['wheel_icon_pos'] )		? $design['wheel_icon_pos']			: '';

		// Taking advance tab data
		$cookie_expire	= isset( $advance['cookie_expire'] )	? $advance['cookie_expire']	: '';
		$cookie_unit	= ! empty( $advance['cookie_unit'] )	? $advance['cookie_unit'] 	: 'day';

		$wheel_conf		= array(
							'id'					=> $wheel_id,
							'open_delay'			=> $open_delay,
							'cookie_prefix'			=> $cookie_prefix,
							'cookie_expire'			=> $cookie_expire,
							'cookie_unit'			=> $cookie_unit,
							'showCloseBtn'			=> $hide_close,
							'enableEscapeKey'		=> $clsonesc,
							'wheel_speed'			=> $wheel_speed,
							'wheel_spin_dur'		=> $wheel_spin_dur,
							'segment_label'			=> $segment_label,
							'segment_lbl_clr'		=> $segment_lbl_clr,
							'segment_bg_clr'		=> $segment_bg_clr,
							'wheel_border_clr'		=> $wheel_border_clr,
							'wheel_dots_clr'		=> $wheel_dots_clr,
							'wheel_pointer_bg_clr'	=> $wheel_pointer_bg_clr,
							'closeOnBgClick'		=> true,
							'fixedContentPos'		=> true,
							'modal'					=> false,
						);

		$atts['wheel_conf'] = htmlspecialchars( json_encode( $wheel_conf ) );

		// Print Inline Style
		echo "<style type='text/css'>{$atts['style']['inline']}</style>";

		ibwpl_get_template( IBWPL_SPW_DIR_NAME, "design-1.php", $atts, null, null, 'design-1.php' ); // Design File
	}

	/**
	 * Function to create popup HTML
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_generate_wheel_style( $wheel_id = 0 ) {

		global $ibwp_spw_design_sett;

		// If valid post is there
		if( empty( $wheel_id ) ) {
			return false;
		}

		// Taking some data
		$style	= array(
					'bg_img'	=> '',
					'bg_clr'	=> '',
					'inline'	=> '',
				);

		// Taking some variable
		$prefix		= IBWPL_SPW_META_PREFIX;
		$design 	= ( empty( $ibwp_spw_design_sett ) ) ? get_post_meta( $wheel_id, $prefix.'design', true ) : $ibwp_spw_design_sett;

		$wheel_bg_img			= isset( $design['wheel_bg_img'] )			? $design['wheel_bg_img']			: '';
		$wheel_img_size			= isset( $design['wheel_img_size'] )		? $design['wheel_img_size']			: '';
		$wheel_img_repeat		= isset( $design['wheel_img_repeat'] )		? $design['wheel_img_repeat']		: '';
		$wheel_img_pos			= isset( $design['wheel_img_pos'] )			? $design['wheel_img_pos']			: '';
		$wheel_bg_clr			= isset( $design['wheel_bg_clr'] )			? $design['wheel_bg_clr']			: '';
		$content_color			= isset( $design['content_color'] )			? $design['content_color']			: '';
		$tooltip_bg_clr			= isset( $design['tooltip_bg_clr'] )		? $design['tooltip_bg_clr']			: '';
		$tooltip_txt_clr		= isset( $design['tooltip_txt_clr'] )		? $design['tooltip_txt_clr']		: '';
		$custom_close_txtclr	= isset( $design['custom_close_txtclr'] )	? $design['custom_close_txtclr']	: '';
		$wheel_pointer_clr		= isset( $design['wheel_pointer_clr'] )		? $design['wheel_pointer_clr']		: '';

		// Create Wheel Popup Background Style
		if( $wheel_bg_img ) {
			$style['bg_img'] = "background: url({$wheel_bg_img}) {$wheel_img_repeat} {$wheel_img_pos}; background-size: {$wheel_img_size}; ";
		}
		if( $wheel_bg_clr ) {
			$style['bg_clr']	= "background-color:{$wheel_bg_clr}; ";
		}

		// Content Style
		if( $content_color ) {
			$style['inline'] .= ".ibwp-spw-popup-{$wheel_id} .ibwp-spw-wheel-form-process, .ibwp-spw-popup-{$wheel_id} .ibwp-spw-wheel-content{color: {$content_color};}";
		}

		// Tooltip Style
		if( $tooltip_bg_clr ) {
			$style['inline'] .= "#ibwp-spw-wheel-icon-wrp-{$wheel_id} .ibwp-spw-tooltip {background-color: {$tooltip_bg_clr};}";
			$style['inline'] .= "#ibwp-spw-wheel-icon-wrp-{$wheel_id} .ibwp-spw-tooltip:before {border-left-color: {$tooltip_bg_clr};}";
			$style['inline'] .= "#ibwp-spw-wheel-icon-wrp-{$wheel_id}.ibwp-spw-icon-top-left .ibwp-spw-tooltip:before, #ibwp-spw-wheel-icon-wrp-{$wheel_id}.ibwp-spw-icon-middle-left .ibwp-spw-tooltip:before, #ibwp-spw-wheel-icon-wrp-{$wheel_id}.ibwp-spw-icon-bottom-left .ibwp-spw-tooltip:before {border-left-color: transparent; border-right-color: {$tooltip_bg_clr};}";
		}
		if( $tooltip_txt_clr ) {
			$style['inline'] .= "#ibwp-spw-wheel-icon-wrp-{$wheel_id} .ibwp-spw-tooltip {color: {$tooltip_txt_clr};}";
		}

		// Custom Close Style
		if( $custom_close_txtclr ) {
			$style['inline'] .= ".ibwp-spw-popup-{$wheel_id} .ibwp-spw-custom-close {color: {$custom_close_txtclr}; }";
		}

		// Pointer Style
		if( $wheel_pointer_clr ) {
			$style['inline'] .= ".ibwp-spw-popup-{$wheel_id} .ibwp-spw-wheel-pointer {color: {$wheel_pointer_clr}; }";
		}

		return $style;
	}

	/**
	 * Function to process spin wheel form submission
	 * 
	 * @since 1.0
	 */
	function ibwpl_spw_wheel_form_submit() {

		global $wpdb;

		$prefix				= IBWPL_SPW_META_PREFIX;
		$wheel_data			= array();
		$form_store_data	= array();
		$post_data			= isset( $_POST['form_data'] )			? parse_str( $_POST['form_data'], $form_data )	: '';
		$wheel_id			= ! empty( $_POST['wheel_id'] )			? ibwpl_clean_number( $_POST['wheel_id'] )		: 0;
		$cookie_expire		= ! empty( $_POST['cookie_expire'] )	? ibwpl_clean_number( $_POST['cookie_expire'] )	: '';
		$cookie_unit		= ! empty( $_POST['cookie_unit'] )		? ibwpl_clean( $_POST['cookie_unit'] )			: 'day';

		// Taking some default variables
		$submission_data	= array( 'name' => '', 'email' => '', 'phone' => '' );
		$result				= array(
								'success'		=> 0,
								'msg' 			=> esc_html__( 'Sorry, One or more fields have an error. Please check and try again.', 'inboundwp-lite' )
							);

		// Taking Segment Tab Data
		$segment		= get_post_meta( $wheel_id, $prefix.'segment', true );
		$wheel_segments	= ! empty( $segment['wheel_segments'] ) ? $segment['wheel_segments'] : array();

		if( empty( $wheel_id ) || empty( $wheel_segments ) ) {
			wp_send_json( $result );
		}

		// Taking content tab data
		$content 		= get_post_meta( $wheel_id, $prefix.'content', true );
		$form_fields	= isset( $content['form_fields'] )	? $content['form_fields'] : '';

		if( $form_fields ) {
			foreach ($form_fields as $form_field_key => $form_field_data) {

				$require		= ! empty( $form_field_data['require'] ) 	? 1 : 0;
				$type			= isset( $form_field_data['type'] ) 		? $form_field_data['type'] : 'text';
				$submited_data	= isset( $form_data[ 'ibwp_spw_field_'.$form_field_key ] ) ? $form_data[ 'ibwp_spw_field_'.$form_field_key ] : '';
				$submited_key	= "ibwp_spw_field_{$form_field_key}";
				$submited_data	= ibwpl_clean( $submited_data );
				
				$form_store_data[ $form_field_key ] = $submited_data;

				/* Validation of Fields */
				if( $type == 'full_name' && $require && $submited_data == '' ) {
					$result['errors'][ $submited_key ] = esc_html__( 'Please enter required value.', 'inboundwp-lite' );
				}

				if( $type == 'email' && $require && ! is_email( $submited_data ) ) {
					$result['errors'][ $submited_key ] = esc_html__( 'Please enter valid email.', 'inboundwp-lite' );
				}

				if( $type == 'tel' && $require && ! preg_match('/^[0-9 .\-+]+$/i', $submited_data) ) {
					$result['errors'][ $submited_key ] = esc_html__( 'Please enter valid phone number.', 'inboundwp-lite' );
				}

				// Storing Submision Form Required Data
				$submission_data['email'] = isset( $form_store_data[0] ) ? $form_store_data[0] : '';
				if ( $type == 'full_name' && $submission_data['name'] == '' ) {
					$submission_data['name'] = $submited_data;
				}
				if ( $type == 'tel' && $submission_data['phone'] == '' ) {
					$submission_data['phone'] = $submited_data;
				}
			} // End foreach

		} // End if


		/* Insert Process When No Error OR Hide Form Field is Enabled */
		if( ! isset( $result['errors'] ) ) {

			$stop_position	= 0;
			$check_prob		= 0;

			// Get segment based on probability
			foreach ( $wheel_segments as $wheel_segment_key => $wheel_segment_data ) {

				$wheel_data['ids'][]			= $wheel_segment_key;
				$wheel_data['label'][]			= isset( $wheel_segment_data['label'] )				? $wheel_segment_data['label']			: '';
				$wheel_data['coupon_code'][]	= isset( $wheel_segment_data['coupon_code'] )		? $wheel_segment_data['coupon_code']	: '';
				$wheel_data['type'][]			= ! empty( $wheel_segment_data['type'] )			? $wheel_segment_data['type']			: 'custom_msg';
				$wheel_data['probability'][]	= ! empty( $wheel_segment_data['probability'] )		? $wheel_segment_data['probability']	: 0;
				$wheel_data['redirect_url'][]	= ! empty( $wheel_segment_data['redirect_url'] )	? $wheel_segment_data['redirect_url']	: '';
				$wheel_data['custom_msg'][]		= ! empty( $wheel_segment_data['custom_msg'] )		? $wheel_segment_data['custom_msg']		: __('Thanks for your time.', 'inboundwp-lite');
			}

			// Random Number
			$random_num	= rand( 1, array_sum( $wheel_data['probability'] ) );

			foreach ( $wheel_data['probability'] as $prob_key => $prob_val ) {
				
				$check_prob += $prob_val;

				if ( $check_prob >= $random_num ) {
					break;
				}
				$stop_position++;
			}

			$segment_id			= $wheel_data['ids'][$stop_position];
			$segment_label		= $wheel_data['label'][$stop_position];
			$segment_coupon		= $wheel_data['coupon_code'][$stop_position];
			$segment_custom_msg	= $wheel_data['custom_msg'][$stop_position];

			// Insert some entry
			$wpdb->insert( IBWPL_SPW_FORM_TBL, 
								array(
									'wheel_id'		=> $wheel_id,
									'seg_id'		=> $segment_id,
									'name'			=> $submission_data['name'],
									'email'			=> $submission_data['email'],
									'phone'			=> $submission_data['phone'],
									'created_date'	=> current_time('mysql'),
									'modified_date'	=> current_time('mysql'),
								)
			);
			$insert_id = $wpdb->insert_id;

			// If segment email is not enabled then check from global notification email
			$notification	= get_post_meta( $wheel_id, $prefix.'notification', true );
			$enable_email	= ! empty( $notification['enable_email'] )	? 1 : 0;
			$email_subject	= ! empty( $notification['email_subject'] )	? $notification['email_subject']	: '';
			$email_msg		= ! empty( $notification['email_msg'] )		? $notification['email_msg']		: '';

			// Check flag to send mail to user or not?
			if( $enable_email == '1' ) {

				// Taking some variable
				$site_name		= get_bloginfo( 'name' );					
				$email_subject	= ! empty( $email_subject )	? $email_subject	: esc_html__( 'Spin Wheel', 'inboundwp-lite' ) .' '. wp_specialchars_decode( $site_name );
				$email_subject	= str_replace( '{name}', $submission_data['name'], $email_subject );

				$email_msg		= ! empty( $email_msg )	? do_shortcode( wpautop( $email_msg ) )	: __('Thanks for your time.', 'inboundwp-lite');
				$email_msg		= str_replace( '{name}', $submission_data['name'], $email_msg );
				$email_msg		= str_replace( '{email}', $submission_data['email'], $email_msg );
				$email_msg		= str_replace( '{phone}', $submission_data['phone'], $email_msg );
				$email_msg		= str_replace( '{label}', $segment_label, $email_msg );
				$email_msg		= str_replace( '{coupon_code}', $segment_coupon, $email_msg );

				IBWP_Lite()->email->__set( 'module', IBWPL_SPW_DIR_NAME );
				IBWP_Lite()->email->__set( 'heading', esc_html__( 'Spin Wheel', 'inboundwp-lite' ) );
				IBWP_Lite()->email->send( $submission_data['email'], $email_subject, $email_msg );
			}

			// Replace custom message with tags
			$custom_msg	= ! empty( $segment_custom_msg ) ? do_shortcode( wpautop( $segment_custom_msg ) )	: __('Thanks for your time.', 'inboundwp-lite');
			$custom_msg	= str_replace( '{name}', $submission_data['name'], $custom_msg );
			$custom_msg	= str_replace( '{email}', $submission_data['email'], $custom_msg );
			$custom_msg	= str_replace( '{phone}', $submission_data['phone'], $custom_msg );
			$custom_msg	= str_replace( '{label}', $segment_label, $custom_msg );
			$custom_msg	= str_replace( '{coupon_code}', $segment_coupon, $custom_msg );

			$result['success']			= 1;
			$result['stop_position']	= $stop_position;
			$result['custom_msg']		= $custom_msg;
			$result['segment_type']		= $wheel_data['type'][ $stop_position ];
			$result['redirect_url']		= $wheel_data['redirect_url'][ $stop_position ];
			$result['redirect_msg']		= esc_html__('Please wait redirecting URL', 'inboundwp-lite') ." : ". $result['redirect_url'];
			$result['msg']				= esc_html__( 'Success', 'inboundwp-lite' );
		}

		wp_send_json( $result );
	}
}

$ibwpl_spw_public = new IBWPL_Spw_Public();