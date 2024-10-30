<?php
/**
 * Public Class
 *
 * Handles the Public side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_MP_Public {

	function __construct() {

		// Render Popup
		add_action( 'wp_footer', array($this, 'ibwpl_mp_render_popup') );

		// Add action to process popup form submission
		add_action( 'wp_ajax_ibwpl_mp_popup_form_submit', array($this, 'ibwpl_mp_popup_form_submit') );
		add_action( 'wp_ajax_nopriv_ibwpl_mp_popup_form_submit', array($this,'ibwpl_mp_popup_form_submit') );
	}

	/**
	 * Function to render popup
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_render_popup() {

		global $post;

		// Taking some data
		$prefix			= IBWPL_MP_META_PREFIX;
		$post_id		= isset( $post->ID ) ? $post->ID : '';
		$post_type		= isset( $post->post_type ) ? $post->post_type : '';
		$enable 		= ibwpl_mp_get_option( 'enable' );
		$enable			= apply_filters('ibwpl_mp_render_popup', $enable, $post );

		// If not globally enable
		if ( ! $enable ) {
			return false;
		}

		/* Display Welcome Popup Starts */
		$enabled_post_types 	= ibwpl_mp_get_option( 'post_types', array() );
		$welcome_popup			= get_post_meta( $post_id, $prefix.'welcome_popup', true );
		
		// Check Post Type Meta else Global
		if( $welcome_popup && in_array( $post_type, $enabled_post_types ) ) {

			$enable_welcome_popup = true;

		} else {

			$welcome_popup			= ibwpl_mp_get_option( 'welcome_popup' );
			$welcome_display_in 	= ibwpl_mp_get_option( 'welcome_display_in' );
			$enable_welcome_popup	= ibwpl_mp_check_active( $welcome_display_in );
		}

		if( $welcome_popup > 0 && $enable_welcome_popup ) {
			$this->ibwpl_mp_create_popup( $welcome_popup );
		}
	}

	/**
	 * Function to create popup HTML
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_create_popup( $popup_id = 0 ) {

		global $ibwp_mp_design_sett, $ibwp_mp_behaviour_sett, $ibwp_mp_advance_sett, $ibwp_mp_popup_type;

		$prefix			= IBWPL_MP_META_PREFIX;
		$post_status	= ibwpl_get_post_status( $popup_id );
		$advance 		= ibwpl_get_meta( $popup_id, $prefix.'advance', true );
		$mobile_disable	= ! empty( $advance['mobile_disable'] ) ? 1 : 0;

		// If valid post is there
		if( $post_status != 'publish' || ( wp_is_mobile() && $mobile_disable ) ) {
			return false;
		}

		// Checking advance setting
		$current_time	= current_time( 'timestamp' );
		$cookie_prefix	= ibwpl_mp_get_option( 'cookie_prefix' );

		// Check Cookie
		if( isset( $advance['cookie_expire'] ) && $advance['cookie_expire'] !== '' && ! empty( $_COOKIE[ $cookie_prefix.$popup_id ] ) ) {
			return false;
		}

		// Taking some data
		$behaviour 		= ibwpl_get_meta( $popup_id, $prefix.'behaviour', true );
		$popup_goal 	= ibwpl_get_meta( $popup_id, $prefix.'popup_goal', true );
		$popup_type		= ibwpl_get_meta( $popup_id, $prefix.'popup_type', true );
		$design 		= ibwpl_get_meta( $popup_id, $prefix.'design', true );
		$social 		= ibwpl_get_meta( $popup_id, $prefix.'social', true );
		$content 		= ibwpl_get_meta( $popup_id, $prefix.'content', true );

		// Assign value to global var
		$ibwp_mp_design_sett	= $design;
		$ibwp_mp_behaviour_sett	= $behaviour;
		$ibwp_mp_popup_type		= $popup_type;
		$ibwp_mp_advance_sett	= $advance;

		// Taking design data
		$template = isset( $design['template'] ) ? $design['template'] : 'design-1';

		// Taking Behaviour data
		$hide_close = ! empty( $behaviour['hide_close'] )	? false : true;
		$clsonesc	= ! empty( $behaviour['clsonesc'] )		? true	: false;
		$open_delay	= ! empty( $behaviour['open_delay'] )	? ( $behaviour['open_delay'] * 1000 ) : 0;

		$atts['popup_goal']		= str_replace('_', '-', $popup_goal);
		$atts['style']			= $this->ibwpl_mp_generate_popup_style( $popup_id );
		$atts['template']		= $template;
		$atts['popup_id']		= $popup_id;
		$atts['popup_position']	= '';

		// Taking content data
		$atts['main_heading']	= isset( $content['main_heading'] )		? $content['main_heading']								: '';
		$atts['sub_heading']	= isset( $content['sub_heading'] )		? $content['sub_heading']								: '';
		$atts['security_note']	= isset( $content['security_note'] )	? $content['security_note']								: '';
		$atts['popup_content']	= isset( $content['popup_content'] )	? do_shortcode( wpautop( $content['popup_content'] ) )	: '';

		/* Social tab data */
		$atts['social_data'] = isset( $social['social_traffic'] ) ? ibwpl_mp_get_social_data( $social['social_traffic'] ) : '';

		// Advance Tab Data
		$cookie_expire			= isset( $advance['cookie_expire'] )	? $advance['cookie_expire']	: '';
		$cookie_unit			= ! empty( $advance['cookie_unit'] )	? $advance['cookie_unit'] 	: 'day';
		$atts['show_credit']	= ! empty( $advance['show_credit'] )	? 1	: 0;
		$atts['credit_link']	= 'onclick="window.open(\''.IBWPL_PRO_LINK.'\', \''.'_blank'.'\');"';

		/* Popup Goal : Collect Email */
		if( $popup_goal == 'email-lists' ) {
			$atts['form_fields']	= isset( $content['form_fields'] )		? $content['form_fields']		: '';
			$atts['submit_btn_txt']	= isset( $content['submit_btn_txt'] )	? $content['submit_btn_txt']	: '';
		}

		/* Popup Goal : Target URL */
		if( $popup_goal == 'target-url' ) {
			$atts['btn1_text']		= isset( $content['target_url']['btn1_text'] )		? $content['target_url']['btn1_text']		: '';
			$atts['btn1_link']		= isset( $content['target_url']['btn1_link'] )		? $content['target_url']['btn1_link']		: '';
			$atts['btn1_target']	= isset( $content['target_url']['btn1_target'] )	? $content['target_url']['btn1_target']		: '';

			$atts['btn2_text']		= isset( $content['target_url']['btn2_text'] )		? $content['target_url']['btn2_text']		: '';
			$atts['btn2_link']		= isset( $content['target_url']['btn2_link'] )		? $content['target_url']['btn2_link']		: '';
			$atts['btn2_target']	= isset( $content['target_url']['btn2_target'] )	? $content['target_url']['btn2_target']		: '';

			$atts['btn1_click']		= 'onclick="window.open(\''.$atts['btn1_link'].'\', \''.$atts['btn1_target'].'\');"';
			
			if( $atts['btn2_link'] ) {
				$atts['btn2_click']	= 'onclick="window.open(\''.$atts['btn2_link'].'\', \''.$atts['btn2_target'].'\');"';
			} else {
				$atts['btn2_click']	= 'onclick="jQuery.magnificPopup.close();"';
			}
		}

		/* Popup Goal : Phone Call */
		if( $popup_goal == 'phone-calls' ) {
			$atts['btn_txt']	= isset( $content['phone_calls']['btn_txt'] )	? $content['phone_calls']['btn_txt']	: '';
			$atts['phone_num']	= isset( $content['phone_calls']['phone_num'] )	? $content['phone_calls']['phone_num']	: '';
		}

		// Creating Popup Configuration
		$popup_conf = array(
							'id'				=> $popup_id,
							'popup_type'		=> $popup_type,
							'popup_goal'		=> $popup_goal,
							'template'			=> $template,
							'popup_position'	=> 'middle-center',
							'open_delay'		=> $open_delay,
							'cookie_prefix'		=> $cookie_prefix,
							'cookie_expire'		=> $cookie_expire,
							'cookie_unit'		=> $cookie_unit,
							'showCloseBtn'		=> $hide_close,
							'enableEscapeKey'	=> $clsonesc,
							'closeOnBgClick'	=> true,
							'fixedContentPos'	=> true,
							'modal'				=> false,
						);
		$atts['popup_conf'] = htmlspecialchars( json_encode($popup_conf) );

		// Print Inline Style
		echo "<style type='text/css'>{$atts['style']['inline']}</style>";

		ibwpl_get_template( IBWPL_MP_DIR_NAME, "{$popup_type}/{$popup_goal}/{$template}.php", $atts ); // Header File
	}

	/**
	 * Function to create popup HTML
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_generate_popup_style( $popup_id = 0 ) {

		global $ibwp_mp_design_sett, $ibwp_mp_behaviour_sett, $ibwp_mp_advance_sett, $ibwp_mp_popup_type;

		// If valid post is there
		if( empty( $popup_id ) ) {
			return false;
		}

		// Taking some data
		$style		= array(
								'bg_img'	=> '',
								'bg_clr'	=> '',
								'clr'		=> '',
								'inline'	=> '',
							);
		$prefix		= IBWPL_MP_META_PREFIX;
		$design 	= ( empty( $ibwp_mp_design_sett ) )		? get_post_meta( $popup_id, $prefix.'design', true )		: $ibwp_mp_design_sett;
		$behaviour 	= ( empty( $ibwp_mp_behaviour_sett ) )	? get_post_meta( $popup_id, $prefix.'behaviour', true )		: $ibwp_mp_behaviour_sett;
		$advance 	= ( empty( $ibwp_mp_advance_sett ) )	? get_post_meta( $popup_id, $prefix.'advance', true )		: $ibwp_mp_advance_sett;
		$popup_type = ( empty( $ibwp_mp_popup_type ) )		? get_post_meta( $popup_id, $prefix.'popup_type', true )	: $ibwp_mp_popup_type;

		$overlay_img		=  isset( $design['overlay_img'] )		? $design['overlay_img']		: '';
		$overlay_color		=  isset( $design['overlay_color'] )	? $design['overlay_color']		: '';
		$popup_img			=  isset( $design['popup_img'] )		? $design['popup_img']			: '';
		$popup_img_size		=  isset( $design['popup_img_size'] )	? $design['popup_img_size']		: '';
		$popup_img_repeat	=  isset( $design['popup_img_repeat'] )	? $design['popup_img_repeat']	: '';
		$popup_img_pos		=  isset( $design['popup_img_pos'] )	? $design['popup_img_pos']		: '';
		$bg_color			=  isset( $design['bg_color'] )			? $design['bg_color']			: '';
		$content_color		=  isset( $design['content_color'] )	? $design['content_color']		: '';
		$snote_txtcolor		=  isset( $design['snote_txtcolor'] )	? $design['snote_txtcolor']		: '';

		// Show Credit
		$show_credit = ! empty( $advance['show_credit'] ) ? 1 : 0;

		// Create Popup Background Style
		if( $popup_img ) {
			$style['bg_img'] = "background: url({$popup_img}) {$popup_img_repeat} {$popup_img_pos}; background-size: {$popup_img_size}; ";
		}
		if( $bg_color ) {
			$style['bg_clr']	= "background-color:{$bg_color}; ";
			$style['clr']		= "color:{$bg_color}; ";
		}

		// Overlay Style
		if( $overlay_img ) {
			$style['inline'] .= ".mfp-bg.ibwp-mfp-popup-{$popup_id} {background-image: url({$overlay_img}); background-repeat:repeat; background-position:top center;}";
		}
		if( $overlay_color ) {
			$style['inline'] .= ".mfp-bg.ibwp-mfp-popup-{$popup_id} {background-color:{$overlay_color} !important;}";
		}

		// Content Style
		if( $content_color ) {
			$style['inline'] .= ".ibwp-mp-popup.ibwp-mp-popup-{$popup_id} .ibwp-mp-popup-content {color: {$content_color}; }";
		}

		// Security Note Style
		if( $snote_txtcolor ) {
			$style['inline'] .= ".ibwp-mp-popup.ibwp-mp-popup-{$popup_id} .ibwp-mp-popup-snote {color: {$snote_txtcolor}; }";
		}

		// Show Credit Style
		if( $show_credit == 1 ) {
			$style['inline'] .= ".ibwp-mp-popup-{$popup_id} { margin: 0 0 40px 0; }";
			$style['inline'] .= ".ibwp-mp-middle-center .ibwp-mp-popup-{$popup_id} { margin-bottom: 40px; }";
		}

		return $style;
	}

	/**
	 * Function to process popup form submission
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_popup_form_submit() {

		global $wpdb;

		$prefix				= IBWPL_MP_META_PREFIX;
		$form_store_data	= array();
		$post_data			= isset( $_POST['form_data'] )	? parse_str( $_POST['form_data'], $form_data )	: '';
		$popup_id			= ! empty( $_POST['popup_id'] )	? ibwpl_clean_number( $_POST['popup_id'] )		: 0;

		// Taking Notification Tab Data
		$notification	= get_post_meta( $popup_id, $prefix.'notification', true );
		$enable_email	= ! empty( $notification['enable_email'] )	? 1	: 0;

		$submission_data	= array( 'name' => '', 'email' => '', 'phone' => '' );
		$result				= array(
								'success'	=> 0,
								'msg' 		=> esc_html__( 'Sorry, One or more fields have an error. Please check and try again.', 'inboundwp-lite' )
							);

		if( empty( $popup_id ) || empty( $form_data ) ) {
			wp_send_json( $result );
		}

		// Taking some data
		$content 		= get_post_meta( $popup_id, $prefix.'content', true );
		$form_fields	= isset( $content['form_fields'] )	? $content['form_fields'] : '';
		$form_data		= ibwpl_clean( $form_data );

		if( $form_fields ) {
			foreach ($form_fields as $form_field_key => $form_field_data) {
				
				$require		= ! empty( $form_field_data['require'] ) 	? 1 : 0;
				$type			= isset( $form_field_data['type'] ) 		? $form_field_data['type'] : 'text';
				$submited_data	= isset( $form_data[ 'ibwp_mp_field_'.$form_field_key ] ) ? $form_data[ 'ibwp_mp_field_'.$form_field_key ] : '';
				$submited_key	= "ibwp_mp_field_{$form_field_key}";
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

			} // End of foreach

			/* Insert Process When No Error */
			if( ! isset( $result['errors'] ) ) {

				// Insert some entry
				$wpdb->insert( IBWPL_MP_FORM_TBL, 
									array(
										'popup_id'		=> $popup_id,
										'name'			=> $submission_data['name'],
										'email'			=> $submission_data['email'],
										'phone'			=> $submission_data['phone'],
										'created_date'	=> current_time('mysql'),
										'modified_date'	=> current_time('mysql'),
									)
				);
				$insert_id = $wpdb->insert_id;

				// Check flag to send mail to user or not?
				if( $enable_email == 1 ) {

					// Taking some variable
					$email_subject	= isset( $notification['email_subject'] )	? $notification['email_subject']	: esc_html__( 'We have get your response.', 'inboundwp-lite' );
					$email_msg		= ! empty( $notification['email_msg'] )		? do_shortcode( wpautop( $notification['email_msg'] ) )	: esc_html__('Thanks for your time.', 'inboundwp-lite');
					$email_subject	= str_replace( '{name}', $submission_data['name'], $email_subject );
					$email_msg		= str_replace( '{name}', $submission_data['name'], $email_msg );
					$email_msg		= str_replace( '{email}', $submission_data['email'], $email_msg );
					$email_msg		= str_replace( '{phone}', $submission_data['phone'], $email_msg );

					IBWP_Lite()->email->__set( 'module', IBWPL_MP_DIR_NAME );
					IBWP_Lite()->email->__set( 'heading', 'InboundWP Lite Popup Email', IBWPL_MP_DIR_NAME );
					IBWP_Lite()->email->send( $submission_data['email'], $email_subject, $email_msg );
				}

				$result['success']		= 1;
				$result['msg']			= esc_html__( 'Success', 'inboundwp-lite' );
				$result['thanks_msg']	= ! empty( $content['thanks_msg'] ) ? do_shortcode( wpautop( $content['thanks_msg'] ) ) : esc_html__('Thanks for your submission.', 'inboundwp-lite');
			}
		}

		wp_send_json( $result );
	}
}

$ibwpl_mp_public = new IBWPL_MP_Public();