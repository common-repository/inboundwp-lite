<?php
/**
 * Public Class
 *
 * Handles the public side functionality of plugin
 *
 * @package InboundWP Lite
 * @package Deal Countdown Timer
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class IBWPL_Dcdt_Public {
	
	function __construct() {

		// Add action to timer before the title
		add_action( 'woocommerce_single_product_summary', array($this, 'ibwpl_dcdt_before_the_title'), 4);
		
		// Add action to timer after the title
		add_action( 'woocommerce_single_product_summary', array($this, 'ibwpl_dcdt_after_the_title'), 5);
		
		// Add action to timer after the price
		add_action( 'woocommerce_single_product_summary', array($this, 'ibwpl_dcdt_after_the_price'), 10);
		
		// Add action to timer before the add to cart btn
		add_action( 'woocommerce_before_add_to_cart_form', array($this, 'ibwpl_dcdt_before_cart_btn'), 5);
		
		// Add action to timer after the add to cart btn
		add_action( 'woocommerce_after_add_to_cart_form', array($this, 'ibwpl_dcdt_after_cart_btn'), 5);
		
		// Add action to timer after the meta
		add_action( 'woocommerce_product_meta_end', array($this, 'ibwpl_dcdt_after_meta'), 5 );

		// Add filter to WC product stock management
		add_filter( 'woocommerce_get_stock_html', array($this,'ibwpl_dcdt_woo_stock_progressbar'), 10, 2 );

		// Modify EDD price to Sale Price
		add_filter( 'edd_get_download_price', array( $this, 'ibwpl_dcdt_single_edd_sale_price' ), 10, 2 );

		// Checkout EDD price
		add_filter( 'edd_cart_item_price_label', array( $this, 'ibwpl_dcdt_checkout_edd_sale_price' ), 10, 3 );

		// Add Action to EDD Countdown Timer Display on single post
		add_action( 'edd_purchase_link_top', array($this, 'ibwpl_dcdt_edd_add_timer'), 10, 2 );

		// Add action to complete timer ajax
		add_action( 'wp_ajax_ibwpl_dcdt_on_time_done', array($this, 'ibwpl_dcdt_on_time_done') );
		add_action( 'wp_ajax_nopriv_ibwpl_dcdt_on_time_done', array($this, 'ibwpl_dcdt_on_time_done') );
	}

	/**
	 * Display timer before the title in woocommerce sale product
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_before_the_title() {
		$timer_position = ibwpl_dcdt_get_timer_position();

	    if($timer_position == 'before-title') {
	    	echo ibwpl_dcdt_get_sale_timer();
	    }
	}

	/**
	 * Display timer after the title in woocommerce sale product
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_after_the_title() {
		$timer_position = ibwpl_dcdt_get_timer_position();

	    if($timer_position == 'after-title') {
	    	echo ibwpl_dcdt_get_sale_timer();
	    }
	}

	/**
	 * Display timer after the price in woocommerce sale product
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_after_the_price() {
		$timer_position = ibwpl_dcdt_get_timer_position();

	    if($timer_position == 'after-price') {
	    	echo ibwpl_dcdt_get_sale_timer();
	    }
	}

	/**
	 * Display timer before the add to cart btn in woocommerce sale product
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_before_cart_btn() {
		$timer_position = ibwpl_dcdt_get_timer_position();

	    if($timer_position == 'before-cart-btn') {
	    	echo ibwpl_dcdt_get_sale_timer();
	    }
	}

	/**
	 * Display timer after the add to cart btn in woocommerce sale product
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_after_cart_btn() {
		$timer_position = ibwpl_dcdt_get_timer_position();

	    if($timer_position == 'after-cart-btn') {
	    	echo ibwpl_dcdt_get_sale_timer();
	    }
	}
 
	/**
	 * Display timer after the meta in woocommerce sale product
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_after_meta() {
		$timer_position = ibwpl_dcdt_get_timer_position();

	    if($timer_position == 'after-product-meta') {
			echo ibwpl_dcdt_get_sale_timer();
		}
	}

	/**
	 * Display WC Product Stock management progress bar
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	function ibwpl_dcdt_woo_stock_progressbar( $html, $product ) {

		global $post;

		$prefix 	= IBWPL_DCDT_META_PREFIX;
		$product_id = $post->ID;

		if( empty( $product_id ) ) {
			return;
		}

		$timer_id = get_post_meta( $product_id, $prefix.'timer_post', true );
		if( empty( $timer_id ) ) {
			return;
		}

		$timer 			= ibwpl_dcdt_check_timer( $product_id, $timer_id ); 
		$stock_prog_bar = get_post_meta( $timer_id, $prefix.'stock_prog_bar', true );

		if( !empty($timer) && $timer['status'] && $stock_prog_bar ) {

			$manage_stock 		= get_post_meta( $product_id, '_manage_stock', true );
			$stock_status 		= get_post_meta( $product_id, '_stock_status', true );
			$left_stock 		= get_post_meta( $product_id, '_stock', true );
			
			$availability 		= $product->get_availability();
	 		$sold_stock			= $product->get_total_sales();
	 		$total_stock 		= $left_stock + $sold_stock;

	 		$instock_text 		= get_post_meta( $timer_id, $prefix.'instock_text', true );
			$instock_text 		= str_replace('%s', '<b>'.$left_stock.'</b>', $instock_text);
			$outofstock_text 	= get_post_meta( $timer_id, $prefix.'outofstock_text', true );
			$instock_color 		= get_post_meta( $timer_id, $prefix.'instock_color', true );
			$outofstock_color 	= get_post_meta( $timer_id, $prefix.'outofstock_color', true );
			$progress_bar_color = get_post_meta( $timer_id, $prefix.'progress_bar_color', true );

			$html = '';
			if ( $manage_stock == 'yes' && $stock_status == 'instock' ) {
				$percentage 	= intval( $left_stock * 100 / $total_stock ); 
				if($left_stock == '0') { 
					$html .= '<div class="dcdt-out-of-stock">
						<span style="color:'.$outofstock_color.'">'. __('Out Of Stock','inboundwp-lite') .'</span>
				   	</div>';
				} else { 
					$html .= '<div class="dcdt-product-in-stock">
						<span style="color:'.$instock_color.'">'.$instock_text.'</span>
						<div class="dcdt-stock-proress-bar">
							<div class="dcdt-progress-bar-inn progress-bar" role="progressbar" aria-valuenow="'.ibwpl_esc_attr($percentage).'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%;background-color: '.$progress_bar_color.'"></div>
						</div>
				   	</div>';
				}
			} else if( ( $manage_stock == 'no' && $stock_status == 'outofstock' ) || $left_stock == '0' ) {
				$html .= '<div class="dcdt-out-of-stock">
					<span style="color:'.$outofstock_color.'">'. __('Out Of Stock','inboundwp-lite') .'</span>
			   	</div>';
			}
		}

		return $html;
	}

	/**
	 * Display EDD Product Sale Price on Product Page
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_single_edd_sale_price( $price, $download_id ) {

		$prefix 	= IBWPL_DCDT_META_PREFIX;

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) :
			return $price;
		endif;

		$current_date_time 	= current_time('timestamp');//dcdt_get_current_date();

		// Get sale EDD product end date
		$edd_sale_end_date	= get_post_meta($download_id, $prefix.'edd_sale_end_date', true);
		$edd_sale_end_date 	= strtotime($edd_sale_end_date);

		$regular_price 		= get_post_meta( $download_id, 'edd_price', true );
		$sale_price 		= get_post_meta( $download_id, $prefix.'edd_sale_price', true );

		if ( ! empty( $sale_price ) ) :
			$price = $sale_price;
		endif;

		if($edd_sale_end_date) {
			if($current_date_time <= $edd_sale_end_date) {
				return $price;
			} else {
				return $regular_price;
			}
		} else {
			return $regular_price;
		}
	}

	/**
	 * Display the sale price, and the regular price with a strike at the checkout.
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_checkout_edd_sale_price( $label, $item_id, $options ) {

		global $edd_options;
		$prefix 		= IBWPL_DCDT_META_PREFIX;
		$download		= new EDD_Download( $item_id );
		$regular_price 	= get_post_meta( $item_id, 'edd_price', true );
		$price 			= edd_get_cart_item_price( $item_id, $options );

		// Get sale price if it exists
		if ( $download->has_variable_prices() ) :
			$prices = $download->get_prices();
			$regular_price 	= isset( $prices[ $options['price_id'] ]['regular_amount'] ) ? $prices[ $options['price_id'] ]['regular_amount'] : $regular_price;
			$sale_price 	= isset( $prices[ $options['price_id'] ]['edd_sale_price'] ) ? $prices[ $options['price_id'] ]['edd_sale_price'] : '';
		else :
			$sale_price	= get_post_meta( $item_id, $prefix.'edd_sale_price', true );
		endif;

		if ( empty( $sale_price ) ) :
			return $label;
		endif;

		$label 		= '';
		$price_id 	= isset( $options['price_id'] ) ? $options['price_id'] : false;

		if ( ! edd_is_free_download( $item_id, $price_id ) && ! edd_download_is_tax_exclusive( $item_id ) ) {

			if ( edd_prices_show_tax_on_checkout() && ! edd_prices_include_tax() ) {

				$regular_price 	+= edd_get_cart_item_tax( $item_id, $options, $regular_price );
				$price 			+= edd_get_cart_item_tax( $item_id, $options, $price );

			} if ( ! edd_prices_show_tax_on_checkout() && edd_prices_include_tax() ) {

				$regular_price 	-= edd_get_cart_item_tax( $item_id, $options, $regular_price );
				$price 			-= edd_get_cart_item_tax( $item_id, $options, $price );

			}

			if ( edd_display_tax_rate() ) {
				$label 	= '&nbsp;&ndash;&nbsp;';

				if ( edd_prices_show_tax_on_checkout() ) {
					$label .= sprintf( __( 'includes %s tax', 'edd' ), edd_get_formatted_tax_rate() );
				} else {
					$label .= sprintf( __( 'excludes %s tax', 'edd' ), edd_get_formatted_tax_rate() );
				}

				$label = apply_filters( 'edd_cart_item_tax_description', $label, $item_id, $options );
			}
		}

		$regular_price 	= '<del>' . edd_currency_filter( edd_format_amount( $regular_price ) ) . '</del>';
		$price 			= edd_currency_filter( edd_format_amount( $price ) );

		return $regular_price . ' ' . $price . $label;
	}

	/**
	 * Display timer in EDD single post view only
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	public function ibwpl_dcdt_edd_add_timer() {

		global $post, $post_type;

		if( $post_type != 'download' ) {
			return;
		}

		$prefix 		= IBWPL_DCDT_META_PREFIX;
		$download_id 	= $post->ID;

		$unique				= ibwpl_get_unique();
		$timer_id			= get_post_meta($download_id, $prefix.'timer_post', true);
		$edd_sale_price		= get_post_meta($download_id, $prefix.'edd_sale_price', true);
		$sale_from_date		= get_post_meta($download_id, $prefix.'edd_sale_start_date', true);
		$sale_to_date		= get_post_meta($download_id, $prefix.'edd_sale_end_date', true);

		// Condition to not empty start date & end date
		if($sale_to_date && $edd_sale_price && $timer_id) {

			$current_date_time 		= current_time('timestamp');//dcdt_get_current_date();
			
			if( $sale_from_date ) {
				$sale_start_date_time 	= $sale_from_date;
				$sale_start_date 		= strtotime($sale_start_date_time);
			} else {
				$sale_start_date_time 	= current_time('mysql');
				$sale_start_date 		= $current_date_time;
			}

			$sale_end_date_time 	= $sale_to_date;
			$sale_end_date 			= strtotime($sale_end_date_time);

			$timer = array(
				'status' => true,
				'id' => $timer_id,
				'start' => $sale_start_date_time,
				'end' => $sale_end_date_time,
			);
			
			// Conditon for current date time greater then sale start date and current date time less then sale end date
			if($current_date_time >= $sale_start_date && $current_date_time <= $sale_end_date) {

				// Enqueue Script
				wp_enqueue_script( 'ibwp-dcdt-countereverest-js' );
				wp_enqueue_script( 'ibwp-dcdt-public-js' );

				echo ibwpl_dcdt_timer_html( $timer, $download_id );
			}
		}
	}

	/**
	 * Timer done function to display completion message
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	function ibwpl_dcdt_on_time_done() {

		$prefix 	= IBWPL_DCDT_META_PREFIX;
		// Taking some variables
		$id			= isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';
		$post_type 	= get_post_type($id);
		$result		= array();
		// Simply return if id is not there
		if( empty($id) ) {
			return 0;
		}
		
		if( $post_type == 'product' ) {
			update_post_meta( $id, '_sale_price', '' );
	        $regular_price = get_post_meta( $id, '_regular_price', true );
	        update_post_meta( $id, '_price', $regular_price );

	        update_post_meta( $id, '_sale_price_dates_from', '' );
	        update_post_meta( $id, '_sale_price_dates_to', '' );

	        update_post_meta( $id, $prefix.'start_time', '' );
	        update_post_meta( $id, $prefix.'end_time', '' );
	    } 

	    if( $post_type == 'download' ) {
	    	update_post_meta( $id, $prefix.'edd_sale_price', '' );
	    	update_post_meta( $id, $prefix.'edd_sale_start_date', '');
	    	update_post_meta( $id, $prefix.'edd_sale_end_date', '');
	    }

        // we're on a variable product
        if( has_term( 'variable', 'product_type', $id ) ){
           variable_product_sync( $id );
        }

        wp_send_json_success( __('Good Job','inboundwp-lite') );

        die();

	}
}
$ibwpl_dcdt_public = new IBWPL_Dcdt_Public();