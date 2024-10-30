<?php
/**
 * Public Class
 *
 * Handles the public side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Ibwpl_Wtcs_Public {

	function __construct() {

		// Add Action to display chatbox
		add_action( 'wp_footer', array( $this, 'ibwpl_wtcs_render_chatbox' ) );
	}

	/**
	 * Function to add chatbox to site
	 * 
	 * @since 1.0
	 **/
	function ibwpl_wtcs_render_chatbox() {

		global $post, $ibwp_wtcs_chatbox_active;

		$prefix = IBWPL_WTCS_META_PREFIX; // Metabox Prefix
		$enable = ibwpl_wtcs_check_active();
		$enable	= apply_filters('ibwpl_wtcs_render_chatbox', $enable, $post );

		if( ! $enable ) {
			return false;
		}

		// Taking some data
		$online_agent_html		= '';
		$offline_agent_html		= '';
		$atts['main_title'] 	= ibwpl_wtcs_get_option( 'main_title' );
		$atts['sub_title'] 		= ibwpl_wtcs_get_option( 'sub_title' );
		$atts['notice'] 		= ibwpl_wtcs_get_option( 'notice' );
		$atts['toggle_text'] 	= ibwpl_wtcs_get_option( 'toggle_text' );
		$atts['btn_position']	= ibwpl_wtcs_get_option( 'btn_position' );
		$atts['btn_style']		= ibwpl_wtcs_get_option( 'btn_style', 'style-1' );
		$atts['unique']			= ibwpl_get_unique();

		$args = array (
			'post_type'				=> IBWPL_WTCS_POST_TYPE,
			'post_status'			=> array( 'publish' ),
			'order' 				=> 'DESC',
			'orderby'				=> 'date',
			'posts_per_page'		=> 3,
			'ignore_sticky_posts'	=> true,
			'no_found_rows'			=> true,
		);

		// WP Query
		$query = new WP_Query( $args );

		// If post is there
		if ( $query->have_posts() ) {

			ibwpl_get_template( IBWPL_WTCS_DIR_NAME, 'chatbox/header.php', $atts ); // Header File

			while ( $query->have_posts() ) : $query->the_post();
				
				$atts['status_msg']			= '';
				$atts['whatsapp_url']		= '';
				$atts['agent_wrap_cls']		= '';
				$atts['agent_name'] 		= get_post_meta( $post->ID, $prefix.'agent_name', true );
				$atts['country_code'] 		= get_post_meta( $post->ID, $prefix.'country_code', true );
				$atts['designation'] 		= get_post_meta( $post->ID, $prefix.'designation', true );
				$atts['custom_message'] 	= get_post_meta( $post->ID, $prefix.'custom_message', true );
				$atts['over_time_message'] 	= get_post_meta( $post->ID, $prefix.'over_time_message', true );
				$atts['whatapp_number'] 	= get_post_meta( $post->ID, $prefix.'whatapp_number', true );
				$atts['agent_name']			= ! empty( $atts['agent_name'] ) 		? $atts['agent_name']		: $post->post_title; 
				$atts['whatapp_number']		= ! empty( $atts['country_code'] )		? ( $atts['country_code'] . $atts['whatapp_number'] ) : $atts['whatapp_number'];
				$atts['agent_label']		= strip_tags( $atts['agent_name'] ) . ' - ' . $post->ID;
				$atts['status']				= get_post_meta( $post->ID, $prefix.'status', true );
				$atts['featured_img'] 		= ibwpl_get_featured_image( $post->ID, 'thumbnail', IBWPL_URL ."assets/images/person-placeholder.png" );

				if( $atts['status'] == 'online' ) {

					$atts['agent_wrap_cls'] .= ' ibwp-wtcs-online';
					$atts['whatsapp_url']	= add_query_arg(
												array(
													'phone' => $atts['whatapp_number'],
													'text'  => urlencode( $atts['custom_message'] )
												),
												IBWPL_WTCS_API
											);

					$online_agent_html .= ibwpl_get_template_html( IBWPL_WTCS_DIR_NAME, 'chatbox/body.php', $atts );

				} else {

					$atts['agent_wrap_cls']	.= ' ibwp-wtcs-offline';
					$atts['status_msg']		= ( $atts['status'] == 'custom' ) ? $atts['over_time_message'] : '';

					$offline_agent_html .= ibwpl_get_template_html( IBWPL_WTCS_DIR_NAME, 'chatbox/body.php', $atts );
				}

			endwhile;

			echo $online_agent_html . $offline_agent_html; // Print HTML

			ibwpl_get_template( IBWPL_WTCS_DIR_NAME, 'chatbox/footer.php', $atts ); // Footer File

			wp_reset_postdata(); // Reset WP Query
		}
	}
}

$ibwpl_wtcs_public = new Ibwpl_Wtcs_Public();