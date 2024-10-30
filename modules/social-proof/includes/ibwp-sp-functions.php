<?php
/**
 * Functions File
 *
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update default settings
 * 
 * @since 1.0
 */
function ibwpl_sp_default_settings() {

	global $ibwp_sp_options;

	$ibwp_sp_options = array(
							'enable'					=> 1,
							'post_types'				=> array('post'),
							'notification'				=> '',
							'notification_display_in'	=> array(),
						);

	$default_options = apply_filters('ibwpl_sp_options_default_values', $ibwp_sp_options );

	// Update default options
	update_option( 'ibwp_sp_options', $default_options );

	// Overwrite global variable when option is update  
	$ibwp_sp_options = ibwpl_get_settings( 'ibwp_sp_options' );
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0
 */
function ibwpl_sp_get_option( $key = '', $default = false ) {
	global $ibwp_sp_options;
	return ibwpl_get_option( $key, $default, $ibwp_sp_options, 'social-proof' );
}

/**
 * Function to get social proof type options
 * 
 * @since 1.0
 */
function ibwpl_sp_type_options() {

	$sp_type_options = array(	
							'conversion'	=> esc_html__('Conversion', 'inboundwp-lite'),
							'review'		=> esc_html__('Review', 'inboundwp-lite'),
						);
	return apply_filters( 'ibwpl_sp_type_options', $sp_type_options );
}

/**
 * Function to get social proof source types
 * 
 * @since 1.0
 */
function ibwpl_sp_source_type() {

	$source_type = array(
					'custom'	=> esc_html__('Custom (Manual Entry)', 'inboundwp-lite')
				);

	if( class_exists('WooCommerce') ) {
		$source_type['woocommerce'] = esc_html__('WooCommerce', 'inboundwp-lite');
	}
	if( class_exists('Easy_Digital_Downloads') ) {
		$source_type['edd'] = esc_html__('Easy Digital Downloads', 'inboundwp-lite');
	}

	$source_type['wordpress']	= esc_html__('WordPress', 'inboundwp-lite');
	$source_type['wp-author']	= esc_html__('WordPress Author', 'inboundwp-lite');
	$source_type['csv']			= esc_html__('CSV', 'inboundwp-lite');

	return apply_filters( 'ibwpl_sp_source_type', $source_type );
}

/**
 * Function to get notification design options
 * 
 * @since 1.0
 */
function ibwpl_sp_nf_designs() {

	$nf_designs = array(	
							'design-1'	=> esc_html__('Design 1', 'inboundwp-lite'),
							'design-2'	=> esc_html__('Design 2', 'inboundwp-lite'),
							'design-3'	=> esc_html__('Design 3', 'inboundwp-lite'),
							'design-4'	=> esc_html__('Design 4', 'inboundwp-lite'),
							'design-5'	=> esc_html__('Design 5', 'inboundwp-lite'),
						);
	return apply_filters( 'ibwpl_sp_nf_designs', $nf_designs );
}

/**
 * Function to get notification positions options
 * 
 * @since 1.0
 */
function ibwpl_sp_nf_positions() {

	$nf_positions = array(	
							'bottom-left'	=> esc_html__('Bottom Left', 'inboundwp-lite'),
							'bottom-right'	=> esc_html__('Bottom Right', 'inboundwp-lite'),
							'top-left'		=> esc_html__('Top Left', 'inboundwp-lite'),
							'top-right'		=> esc_html__('Top Right', 'inboundwp-lite'),
						);
	return apply_filters( 'ibwpl_sp_nf_positions', $nf_positions );
}

/**
 * Function to get notification animation type
 * 
 * @since 1.0
 */
function ibwpl_sp_nf_animation_type() {

	$animations = array(
					'slide'			=> esc_html__('Slide Vertical', 'inboundwp-lite'),
					'slide-side'	=> esc_html__('Slide Horizontal', 'inboundwp-lite'),
					'fade'			=> esc_html__('Fade', 'inboundwp-lite'),
				);

	return apply_filters( 'ibwpl_sp_nf_animation_type', $animations );
}

/**
 * Function to return wheather social proof is active or not.
 * 
 * @since 1.0
 */
function ibwpl_sp_check_active( $glob_locs = array() ) {

	global $post, $ibwp_sp_nf_active;

	$ibwp_post_type		= isset( $post->post_type ) ? $post->post_type : '';
	$custom_location	= false;
	$ibwp_sp_nf_active	= false;

	// Whole Website
	if( ! empty( $glob_locs['all'] ) ) {
		$ibwp_sp_nf_active = true;
	}

	// Post Type Wise
	if( ! empty( $glob_locs[ $ibwp_post_type ] ) && is_singular() ) {
		$ibwp_sp_nf_active = true;
	}

	// Checking custom locations
	if( is_search() ) {
		$custom_location = "is_search";
	} else if( is_404() ) {
		$custom_location = "is_404";
	} else if( is_archive() ) {
		$custom_location = "is_archive";
	} else if( is_front_page() ) {
		$custom_location = "is_front_page";
	}

	if( $custom_location && ! empty( $glob_locs[ $custom_location ] ) ) {
		$ibwp_sp_nf_active = true;
	}

	return $ibwp_sp_nf_active;
}

/**
 * Function to get EDD(Easy Digital Downloads) payments
 * 
 * @since 1.0
 */
function ibwpl_sp_get_edd_payments( $limit = 10 ) {

	global $edd_logs;

	$edd_payments	= array();
	$limit			= 10;

	$args = array(
				'post_type'					=> 'edd_log',
				'post_status'				=> array( 'publish' ),
				'posts_per_page'			=> $limit,
				'fields'					=> 'ids',
				'no_found_rows'				=> true,
				'update_post_term_cache'	=> false,
				'update_post_meta_cache'	=> false,
				'cache_results'				=> false,
				'tax_query'					=> array(
												array(
													'taxonomy'	=> 'edd_log_type',
													'field'		=> 'slug',
													'terms'		=> 'sale',
												),
											)
			);

	$log_ids = get_posts( $args );

	if ( ! empty( $log_ids ) ) {
		foreach ( $log_ids as $log_id ) {
			$edd_payments[] = get_post_meta( $log_id, '_edd_log_payment_id', true );
		}
	}

	return $edd_payments;
}

/**
 * Function to sort notofocation data based on rating
 * 
 * @since 1.0
 */
function ibwpl_sp_custom_nf_data( $custom_nf = array(), $args = array() ) {

	$limit		= 10;
	$nf_data	= array();
	$type		= ! empty( $args['type'] )	? $args['type']		: '';
	$nf_id		= ! empty( $args['nf_id'] )	? $args['nf_id']	: 0;

	// If no data is there
	if( empty( $custom_nf ) ) {
		return $nf_data;
	}

	$nf_data = array_slice( $custom_nf, 0, $limit );

	return apply_filters( 'ibwpl_sp_notification_data', $nf_data, 'custom', $args );
}

/**
 * Function to get WooCommerce order & review data
 * 
 * @since 1.0
 */
function ibwpl_sp_wc_nf_data( $args = array() ) {

	global $wpdb;

	// Taking some variable
	$product_count	= 0;
	$limit			= 10;
	$wc_data		= array();
	$wc_countries	= WC()->countries->countries;
	$type			= ! empty( $args['type'] )	? $args['type']		: '';
	$nf_id			= ! empty( $args['nf_id'] )	? $args['nf_id']	: 0;

	// Get Review Data
	if( $type == 'review' ) {

		$wc_cust_data	= array();
		$review_args	= array(
							'post_type'	=> 'product',
							'status'	=> 'approve',
							'number'	=> $limit,
						);

		$wc_reviews	= get_comments( $review_args );

		if( ! empty( $wc_reviews ) ) {
			foreach ( $wc_reviews as $wc_review_key => $wc_review_data ) {

				$country		= '';
				$state			= '';
				$city			= '';
				$id				= $wc_review_data->comment_post_ID;
				$comment_email	= $wc_review_data->comment_author_email;
				$date			= $wc_review_data->comment_date;
				$rating			= get_comment_meta( $wc_review_data->comment_ID, 'rating', true );
				$time			= human_time_diff( strtotime( $date ), current_time('timestamp') );
				$image			= wp_get_attachment_image_src( get_post_thumbnail_id( $wc_review_data->comment_post_ID ), 'thumbnail' );

				// Get Orders Detail From Comment Email if any (To get City, State and etc)
				if( ! isset( $wc_cust_data[ $comment_email ] ) ) {

					$get_wc_orders = array(
										'post_type'			=> 'shop_order',
										'post_status'		=> 'wc-completed',
										'meta_key'			=> '_billing_email',
										'meta_value'		=> $comment_email,
										'orderby'			=> 'date',
										'order'				=> 'DESC',
										'fields'			=> 'ids',
										'posts_per_page'	=> 1,
									);

					$wc_order_data = get_posts( $get_wc_orders );

					if( ! empty( $wc_order_data ) ) {

						$order_id		= $wc_order_data[0];
						$city			= get_post_meta( $order_id, '_billing_city', true );
						$state			= get_post_meta( $order_id, '_billing_state', true );
						$country_code	= get_post_meta( $order_id, '_billing_country', true );
						$wc_states		= WC()->countries->get_states( $country_code );
						$country		= isset( $wc_countries[ $country_code ] ) ? $wc_countries[ $country_code ] : $country_code;
						$state			= ( isset( $wc_states[$state] ) && is_string( $wc_states[$state] ) ) ? $wc_states[$state] : $state;

						$wc_cust_data[$comment_email] = array(
															'order_id'	=> $order_id,
															'city'		=> $city,
															'state'		=> $state,
															'country'	=> $country,
														);
					}

				} else {

					$country	= $wc_cust_data[ $comment_email ]['country'];
					$state		= $wc_cust_data[ $comment_email ]['state'];
					$city		= $wc_cust_data[ $comment_email ]['city'];
				}

				// Store Data in Array
				$wc_data[ $wc_review_key ] = array(
												'name'		=> $wc_review_data->comment_author,
												'email'		=> $wc_review_data->comment_author_email,
												'country'	=> $country,
												'state'		=> $state,
												'city'		=> $city,
												'time'		=> $time,
												'url'		=> get_permalink( $id ),
												'title'		=> get_the_title( $id ),
												'image'		=> isset( $image[0] ) ? $image[0] : '',
												'rating'	=> ( ($rating * 100) / 5 ),
											);
			}
		}

	} else { // Conversion Data

		$wc_sql	= " SELECT p.ID as ID,
						wi.order_item_id,
						wim.meta_value as product_id,
						pm.meta_value as `rating`
					FROM {$wpdb->prefix}posts as p,
						{$wpdb->prefix}postmeta as pm,
						{$wpdb->prefix}woocommerce_order_items as wi,
						{$wpdb->prefix}woocommerce_order_itemmeta as wim
					WHERE 1=1
						AND p.ID = wi.order_id
						AND p.post_type = 'shop_order'
						AND p.post_status = 'wc-completed'
						AND wim.meta_key = '_product_id'
						AND pm.meta_key = '_wc_average_rating'
						AND pm.post_id = wim.meta_value
						AND wi.order_item_id = wim.order_item_id ";

		// Orderby order_id
		$wc_sql .= " ORDER BY p.ID DESC limit {$limit}";

		$wc_conversions = $wpdb->get_results( $wc_sql );

		if( ! empty( $wc_conversions ) ) {
			foreach ( $wc_conversions as $wc_conv_key => $wc_conv_data ) {

				$wc_order		= new WC_Order( $wc_conv_data->ID );

				$order_item_id	= $wc_conv_data->order_item_id;
				$products		= $wc_order->get_items();
				$email			= $wc_order->get_billing_email();
				$country_code	= $wc_order->get_billing_country();
				$state			= $wc_order->get_billing_state();
				$wc_states		= WC()->countries->get_states( $country_code );
				$date			= wc_format_datetime( $wc_order->get_date_created(), 'Y-m-d H:i:s' );
				$country		= isset( $wc_countries[ $country_code ] ) ? $wc_countries[ $country_code ] : $country_code;
				$time			= human_time_diff( strtotime( $date ), current_time('timestamp') );

				$products		= isset( $products[ $order_item_id ] ) ? $products[ $order_item_id ] : reset( $products );
				$product		= ( $products ) ? $products->get_product() : '';

				// Store Data in Array
				$wc_data[ $wc_conv_key ] = array(
												'name'		=> $wc_order->get_formatted_billing_full_name(),
												'city'		=> $wc_order->get_billing_city(),
												'state'		=> ( isset( $wc_states[$state] ) && is_string( $wc_states[$state] ) ) ? $wc_states[$state] : $state,
												'country'	=> $country,
												'email'		=> $email,
												'time'		=> $time,
											);

				if( $product ) {

					$rating	= $product->get_average_rating();

					$wc_data[ $wc_conv_key ]['title']	= $product->get_name();
					$wc_data[ $wc_conv_key ]['rating']	= ( ($rating * 100) / 5 );
					$wc_data[ $wc_conv_key ]['image']	= get_the_post_thumbnail_url( $product->get_id(), 'thumbnail' );
					$wc_data[ $wc_conv_key ]['url']		= get_permalink( $product->get_id() );
				}
			}
		}
	}

	return apply_filters( 'ibwpl_sp_notification_data', $wc_data, 'woo', $args );
}

/**
 * Function to get EDD(Easy Digital Download) orders & review data
 * 
 * @since 1.0
 */
function ibwpl_sp_edd_nf_data( $args = array() ) {

	// Taking some variable
	$limit		= 10;
	$edd_data	= array();
	$nf_id		= ! empty( $args['nf_id'] )	? $args['nf_id']	: 0;
	$type		= ! empty( $args['type'] )	? $args['type']		: '';

	// Get Review Data
	if( $type == 'review' ) {

		$edd_cust_data	= array();
		$review_args	= array(
							'post_type'		=> 'download',
							'post_status'	=> 'publish', 
							'status'		=> 'approve', 
							'type'			=> array( 'edd_review' ),
							'number'		=> $limit,
						);

		remove_action( 'pre_get_comments', array( edd_reviews(), 'hide_reviews' ) );

		$edd_reviews = get_comments( $review_args );

		add_action( 'pre_get_comments', array( edd_reviews(), 'hide_reviews' ) );

		if( $edd_reviews ) {
			foreach ($edd_reviews as $edd_review_key => $edd_review_data) {

				$id				= $edd_review_data->comment_post_ID;
				$comment_email	= $edd_review_data->comment_author_email;
				$date			= $edd_review_data->comment_date;
				$rating			= get_comment_meta( $edd_review_data->comment_ID, 'edd_rating', true );
				$time			= human_time_diff( strtotime( $date ), current_time('timestamp') );
				$image			= wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'thumbnail' );

				// Get User Detail From Comment Email if any
				if( ! isset( $edd_cust_data[ $comment_email ] ) ) {

					$edd_customer = new EDD_Customer( $comment_email );

					if( ! empty( $edd_customer->user_id ) ) {
						$address = get_user_meta( $edd_customer->user_id, '_edd_user_address', true );
					}

					$city			= isset( $address['city'] )		? $address['city']		: '';
					$state_code		= isset( $address['state'] )	? $address['state']		: '';
					$country_code	= isset( $address['country'] )	? $address['country']	: '';
					$state			= edd_get_state_name( $country_code, $state_code );
					$country		= edd_get_country_name( $country_code );
					$state			= isset( $state )	? $state	: $state_code;
					$country		= isset( $country )	? $country	: $country_code;

					$edd_cust_data[$comment_email] = array(
														'city'		=> $city,
														'state'		=> $state,
														'country'	=> $country,
													);

				} else {

					$country	= $edd_cust_data[ $comment_email ]['country'];
					$state		= $edd_cust_data[ $comment_email ]['state'];
					$city		= $edd_cust_data[ $comment_email ]['city'];
				}

				// Store Data in Array
				$edd_data[ $edd_review_key ] = array(
												'name'		=> $edd_review_data->comment_author,
												'email'		=> $edd_review_data->comment_author_email,
												'city'		=> $city,
												'state'		=> $state,
												'country'	=> $country,
												'image'		=> $image[0],
												'time'		=> $time,
												'title'		=> get_the_title( $id ),
												'url'		=> get_permalink( $id ),
												'rating'	=> ( ($rating * 100) / 5 ),
											);
			}
		}

	} else { // Conversion Data

		$edd_conversions = ibwpl_sp_get_edd_payments( $limit );

		foreach ( $edd_conversions as $edd_conv_key => $edd_conv_id ) {

			// Get EDD post data
			$edd_payment = new EDD_Payment( $edd_conv_id );

			$user_info				= $edd_payment->user_info;
			$user_info['address']	= ! empty( $user_info['address'] ) ? $user_info['address'] : get_user_meta( $edd_payment->user_id, '_edd_user_address', true );
			$date					= $edd_payment->date;
			$cart_details			= $edd_payment->cart_details;
			$first_name				= $edd_payment->first_name;
			$last_name				= $edd_payment->last_name;
			$edd_pdt_data			= $cart_details[0];
			$city					= isset( $user_info['address']['city'] )	? $user_info['address']['city']		: '';
			$state_code				= isset( $user_info['address']['state'] )	? $user_info['address']['state']	: '';
			$country_code			= isset( $user_info['address']['country'] )	? $user_info['address']['country']	: '';
			$state					= edd_get_state_name( $country_code, $state_code );
			$country				= edd_get_country_name( $country_code );
			$state					= isset( $state )	? $state	: $state_code;
			$country				= isset( $country )	? $country	: $country_code;
			$cart_simple_data		= wp_list_pluck( $cart_details, 'id' );

			$edd_id	= $edd_pdt_data['id'];
			$rating	= get_post_meta( $edd_id, 'edd_reviews_average_rating', true );
			$rating	= is_numeric( $rating ) ? $rating : 0;

			$edd_data[ $edd_conv_key ]['title']		= $edd_pdt_data['name'];
			$edd_data[ $edd_conv_key ]['name']		= $first_name.' '.$last_name;
			$edd_data[ $edd_conv_key ]['city']		= $city;
			$edd_data[ $edd_conv_key ]['state']		= $state;
			$edd_data[ $edd_conv_key ]['country']	= $country;
			$edd_data[ $edd_conv_key ]['url']		= get_permalink( $edd_id );
			$edd_data[ $edd_conv_key ]['image']		= get_the_post_thumbnail_url( $edd_id, 'thumbnail' );
			$edd_data[ $edd_conv_key ]['time']		= human_time_diff( strtotime( $date ), current_time('timestamp') );
			$edd_data[ $edd_conv_key ]['rating']	= ( ($rating * 100) / 5 );
		}
	}

	return apply_filters( 'ibwpl_sp_notification_data', $edd_data, 'edd', $args );
}