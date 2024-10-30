<?php
/**
 * Public Class
 *
 * The Public side functionality of plugin
 *
 * @package InboundWP Lite
 * @package Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_SP_Public {

	function __construct() {

		// Render Social Proof
		add_action( 'wp_footer', array($this, 'ibwpl_sp_render_notification') );

		// Add action to process display notification
		add_action( 'wp_ajax_ibwpl_sp_display_notification', array($this, 'ibwpl_sp_display_notification') );
		add_action( 'wp_ajax_nopriv_ibwpl_sp_display_notification', array($this,'ibwpl_sp_display_notification') );
	}

	/**
	 * Function to render social proof
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_render_notification() {

		global $post;

		// Taking some data
		$prefix			= IBWPL_SP_META_PREFIX;
		$post_id		= isset( $post->ID )		? $post->ID			: '';
		$post_type		= isset( $post->post_type )	? $post->post_type	: '';
		$enable 		= ibwpl_sp_get_option( 'enable' );
		$enable			= apply_filters('ibwpl_sp_render_notification', $enable, $post );

		// If not globally enable
		if ( ! $enable ) {
			return false;
		}

		/* Display Social Proof Notification Starts */
		$enabled_post_types = ibwpl_sp_get_option( 'post_types', array() );
		$notification		= get_post_meta( $post_id, $prefix.'notification', true );

		// Check Post Type Meta else Global Setting
		if( $notification && in_array( $post_type, $enabled_post_types ) ) {

			$enable_notification = true;

		} else {

			$notification				= ibwpl_sp_get_option( 'notification' );
			$notification_display_in 	= ibwpl_sp_get_option( 'notification_display_in' );
			$enable_notification		= ibwpl_sp_check_active( $notification_display_in );
		}

		if( $notification > 0 && $enable_notification ) {
			$this->ibwpl_sp_get_notification( $notification );
		}
	}

	/**
	 * Function to create social proof HTML
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_get_notification( $nf_id = 0 ) {

		$prefix			= IBWPL_SP_META_PREFIX;
		$post_status	= ibwpl_get_post_status( $nf_id );
		$advance 		= ibwpl_get_meta( $nf_id, $prefix.'advance', true );
		$mobile_disable	= ! empty( $advance['mobile_disable'] ) ? 1	: 0;

		// If valid post is there
		if( $post_status != 'publish' || ( wp_is_mobile() && $mobile_disable ) ) {
			return false;
		}

		// Checking advance setting
		$show_credit		= ! empty( $advance['show_credit'] )	? 1 : 0;

		// Behaviour Settings
		$behaviour			= ibwpl_get_meta( $nf_id, $prefix.'behaviour', true );
		$initial_delay		= ! empty( $behaviour['initial_delay'] )	? ( $behaviour['initial_delay'] * 1000 )	: '';
		$delay_between		= ! empty( $behaviour['delay_between'] )	? ( $behaviour['delay_between'] * 1000 )	: '';
		$loop				= ! empty( $behaviour['loop'] )				? 1 : 0;
		$cls_btn			= ! empty( $behaviour['cls_btn'] )			? 1 : 0;
		$link_target		= ! empty( $behaviour['link_target'] )		? "_blank" : "_self";

		// Creating Conf
		$conf = array(
			'id'				=> $nf_id,
			'show_credit'		=> $show_credit,
			'cache_duration'	=> 5,
			'initial_delay'		=> $initial_delay,
			'display_time'		=> 5000,
			'delay_between'		=> $delay_between,
			'loop'				=> $loop,
			'cls_btn'			=> $cls_btn,
			'link_target'		=> $link_target,
			'nonce'				=> wp_create_nonce('ibwpl-sp-notifications'),
		);

		echo '<div class="ibwp-conf ibwp-sp-nf-conf" data-conf="'. htmlspecialchars( json_encode( $conf ) ) .'"></div>';
	}

	/**
	 * Function to process display notification
	 * 
	 * @since 1.0
	 */
	function ibwpl_sp_display_notification() {

		$count			= 0;
		$html			= '';
		$prefix			= IBWPL_SP_META_PREFIX;
		$result			= array( 'success' => 0 );
		$nf_conf		= isset( $_POST['conf'] )		? ibwpl_clean( $_POST['conf'] )	: '';
		$nonce			= isset( $nf_conf['nonce'] )	? $nf_conf['nonce']				: '';
		$nf_id			= isset( $nf_conf['id'] )		? $nf_conf['id']				: 0;
		$modified_date	= get_the_modified_date( 'Y-m-d H:i:s', $nf_id );

		$transient_data	= get_transient( 'ibwp_sp_nf_'.$nf_id );
		$cache_html		= isset( $transient_data['html'] )			? $transient_data['html']			: false;
		$cache_date		= isset( $transient_data['modified_date'] ) ? $transient_data['modified_date']	: false;

		if( ! empty( $nf_id ) && wp_verify_nonce( $nonce, 'ibwpl-sp-notifications' ) ) {

			// If cache is there into database
			if( ! empty( $cache_html ) && ( $modified_date == $cache_date ) ) {

				$result['success']	= 1;
				$result['cache']	= 1;
				$result['content']	= $cache_html;

			} else {

				// Taking some data
				$type 			= ibwpl_get_meta( $nf_id, $prefix.'type', true );
				$source_type	= ibwpl_get_meta( $nf_id, $prefix.'source_type', true );
				$content 		= ibwpl_get_meta( $nf_id, $prefix.'content', true );
				$custom_nf 		= ibwpl_get_meta( $nf_id, $prefix.'custom_nf', true );

				// Taking Behaviour Data
				$cache_duration			= $nf_conf['cache_duration'];
				$atts['cls_btn']		= $nf_conf['cls_btn'];
				$atts['link_target']	= $nf_conf['link_target'];

				// Taking Design Data
				$atts['type']			= $type;
				$atts['nf_id']			= $nf_id;
				$atts['source_type']	= $source_type;
				$atts['show_credit']	= ! empty( $nf_conf['show_credit'] )	? 1 : 0;

				// Taking Content Data
				$atts['nf_image']		= isset( $content['nf_image'] )		? $content['nf_image']		: '';
				$atts['link_type']		= isset( $content['link_type'] )	? $content['link_type']		: '';
				$atts['custom_link']	= isset( $content['custom_link'] )	? $content['custom_link']	: '';
				$nf_template 			= isset( $content['nf_template'] )	? $content['nf_template']	: '';
				$custom_nf		 		= isset( $custom_nf )				? $custom_nf				: array();
				$args					= array(
											'type'	=> $type,
											'nf_id'	=> $nf_id,
										);


				// Notification Data
				if( $source_type == 'woocommerce' ) {

					$notification_data	= ibwpl_sp_wc_nf_data( $args );

				} else if( $source_type == 'edd' ) {

					$notification_data = ibwpl_sp_edd_nf_data( $args );

				} else if( $source_type == 'custom' ) {

					$notification_data = ibwpl_sp_custom_nf_data( $custom_nf, $args );
				}

				if( ! empty( $notification_data ) ) {
					foreach ( $notification_data as $nf_key => $nf_data ) {

						// Taking some variable
						$rating_html		= '';
						$atts['name']		= ! empty( $nf_data['name'] )	? ucfirst( $nf_data['name'] )	: esc_html__('Someone', 'inboundwp-lite');
						$atts['email']		= isset( $nf_data['email'] )	? $nf_data['email']				: '';
						$atts['title']		= isset( $nf_data['title'] )	? $nf_data['title']				: '';
						$atts['city']		= isset( $nf_data['city'] )		? $nf_data['city']				: '';
						$atts['state']		= isset( $nf_data['state'] )	? $nf_data['state']				: '';
						$atts['country']	= isset( $nf_data['country'] )	? $nf_data['country']			: '';
						$atts['time']		= isset( $nf_data['time'] )		? $nf_data['time']				: '';
						$atts['image']		= isset( $nf_data['image'] )	? $nf_data['image']				: '';
						$atts['url']		= isset( $nf_data['url'] )		? $nf_data['url']				: '';
						$atts['rating']		= isset( $nf_data['rating'] )	? $nf_data['rating']			: '';

						// Product Link
						if( $atts['link_type'] == 'custom_url' && $atts['custom_link'] ) {
							$atts['url'] = $atts['custom_link'];
						}

						// Calculate rating percentage for custom manual entry
						if( $source_type == 'custom' ) {
							$atts['rating'] = ( ($atts['rating'] * 100) / 5 );
						}

						// Create rating html
						if( $atts['rating'] >= 0 ) {
							$rating_html .= '<span class="ibwp-sp-rating-wrap"><span class="ibwp-sp-rating"><span class="ibwp-sp-rating-inr" style="width:'.$atts['rating'].'%;"></span></span></span>';
						}

						// Replace notification template tags
						$atts['nf_template']	= apply_filters( 'ibwp_sp_nf_template', $nf_template, $nf_data, $type, $source_type, $content );
						$atts['nf_template']	= str_replace( '{title}', '<span class="ibwp-sp-nf-title">'. $atts['title'] .'</span>', $atts['nf_template'] );
						$atts['nf_template']	= str_replace( '{name}', '<span class="ibwp-sp-nf-name">'. $atts['name'] .'</span>', $atts['nf_template'] );
						$atts['nf_template']	= str_replace( '{city}', '<span class="ibwp-sp-nf-city">'. $atts['city'] .'</span>', $atts['nf_template'] );
						$atts['nf_template']	= str_replace( '{state}', '<span class="ibwp-sp-nf-state">'. $atts['state'] .'</span>', $atts['nf_template'] );
						$atts['nf_template']	= str_replace( '{country}', '<span class="ibwp-sp-nf-country">'. $atts['country'] .'</span>', $atts['nf_template'] );
						$atts['nf_template']	= str_replace( '{time}', '<span class="ibwp-sp-nf-time">'. $atts['time'] .'</span>', $atts['nf_template'] );
						$atts['nf_template']	= str_replace( '{rating}', $rating_html, $atts['nf_template'] );

						// Design File
						$html .= ibwpl_get_template_html( IBWPL_SP_DIR_NAME, "design-1.php", $atts, null, null, 'design-1.php' );
					}

					$result['success']	= 1;
					$result['content']	= $html;

					// Store Cache Data
					$transient_data	= array(
										'html'			=> $html,
										'modified_date'	=> $modified_date,
									);

					// Set cache into the database
					set_transient( 'ibwp_sp_nf_'.$nf_id, $transient_data, $cache_duration * MINUTE_IN_SECONDS );
				}
			}

		} // Main IF

		wp_send_json( $result );
	}
}

$ibwpl_sp_public = new IBWPL_SP_Public();