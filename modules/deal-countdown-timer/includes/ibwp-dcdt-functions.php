<?php
/**
 * Plugin generic functions file
 *
 * @package InboundWP Lite
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get the timer position
 *
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_get_timer_position() {

	global $post;
	$timer_id 		= get_post_meta($post->ID, IBWPL_DCDT_META_PREFIX. 'timer_post', true);
	$timer_position	= get_post_meta($timer_id, IBWPL_DCDT_META_PREFIX. 'timer_position', true);
	
	return $timer_position;
}

/**
 * Display timer in woocommerce sale product
 *
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_get_sale_timer() {
	
	global $post;

	$product_id = $post->ID;
	if( empty( $product_id ) ) {
		return;
	}

	$timer_id 	= get_post_meta($product_id, IBWPL_DCDT_META_PREFIX. 'timer_post', true);
	if( empty( $timer_id ) || get_post_status( $timer_id ) != 'publish' ) {
		return;
	}

	$timer = ibwpl_dcdt_check_timer( $product_id, $timer_id );  	

	if( !empty( $timer ) && $timer['status'] ) {

		// Enqueue script
		wp_enqueue_script( 'ibwp-dcdt-countereverest-js' );
		if(class_exists('woocommerce')) {
			wp_enqueue_script( 'ibwp-dcdt-public-js' );
		}
		
		echo ibwpl_dcdt_timer_html( $timer, $product_id );
	}
}

/**
 * Check timer for woocommerce sale product only
 *
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_check_timer( $product_id, $timer_id ) {

	$prefix 		= IBWPL_DCDT_META_PREFIX;
	$check_timer 	= false;
	$sale_price		= get_post_meta($product_id, '_sale_price', true);
	$sale_from_date	= get_post_meta($product_id, '_sale_price_dates_from', true);
	$sale_to_date	= get_post_meta($product_id, '_sale_price_dates_to', true);
	
	// Condition to not empty start date & end date
	if( $sale_to_date && $sale_price ) {

		$current_date_time 		= current_time('timestamp'); //dcdt_get_current_date();
		
		// Get sale product start date & time
		$sale_start_time = get_post_meta($product_id, $prefix.'start_time', true);

		if(  empty ( $sale_from_date ) ) {
			$sale_from_date 		= date( 'Y-m-d', $current_date_time );
			$sale_start_date_time	= $sale_from_date.' '.$sale_start_time;
		} else {
			$sale_from_date 		= date( 'Y-m-d', $sale_from_date );
			$sale_start_date_time 	= new DateTime($sale_from_date.' '.$sale_start_time);
			$sale_start_date_time->modify('+1 day');
			$sale_start_date_time 	= $sale_start_date_time->format('Y-m-d H:i:s');
		}
		
		$sale_start_date 		= strtotime($sale_start_date_time);
		
		// Get sale product end date & time
		$sale_to_date			= date("Y-m-d", $sale_to_date );
		$sale_end_time			= get_post_meta($product_id, $prefix.'end_time', true);

		// Add 1 Day in Sale end Date
		$sale_end_date_time 	= new DateTime($sale_to_date.' '.$sale_end_time);
		$sale_end_date_time->modify('+1 day');
		$sale_end_date_time 	= $sale_end_date_time->format('Y-m-d H:i:s');
		$sale_end_date 		 	= strtotime($sale_end_date_time);

		if($current_date_time >= $sale_start_date && $current_date_time <= $sale_end_date) {
			$check_timer = true;	
		}
	}

	$timer = array(
		'status' => $check_timer,
		'id' => $timer_id,
		'start' => isset( $sale_start_date_time ) ? $sale_start_date_time : '',
		'end' => isset( $sale_end_date_time ) ? $sale_end_date_time : '',
	);

	return $timer;
}

/**
* Timer html function
*
* @subpackage Deal Countdown Timer
* @since 1.0
*/
function ibwpl_dcdt_timer_html( $timer, $post_id ) {

	$prefix 				= IBWPL_DCDT_META_PREFIX;
	$timer_id 				= $timer['id'];
	$timer_style 			= get_post_meta( $timer_id, $prefix.'timer_style', true );
	$textcolor				= get_post_meta( $timer_id, $prefix.'timertext_color', true );
	$digitcolor 			= get_post_meta( $timer_id, $prefix.'timerdigit_color', true );
	$timertext_fontsize 	= get_post_meta( $timer_id, $prefix.'timertext_fontsize', true );
	$timerdigit_fontsize 	= get_post_meta( $timer_id, $prefix.'timerdigit_fontsize', true );
	$circle_border_color 	= get_post_meta( $timer_id, $prefix.'circle_border_color', true );
	$circle_border_style 	= get_post_meta( $timer_id, $prefix.'circle_border_style', true );
	$circle_bg_color 		= get_post_meta( $timer_id, $prefix.'circle_bg_color', true );

	$height_width 			= 8;
	$height_width 			+= $timerdigit_fontsize 	? round( $timerdigit_fontsize * 1.2 ) 	: 0;
	$height_width 			+= $timertext_fontsize  	? round( $timertext_fontsize * 1.5 	)	: 0;
	$height_width 			+= 8;

	$html = '<style type="text/css">';

	if( $timer_style == 'circle' || $timer_style == 'circle-fill' ) {
		$html .= '.dcdt-count-timer-'.$timer_id.' .dcdt-clock .ce-col { width: '.$height_width.'px; }';
	}

	$html .= '.dcdt-count-timer-'.$timer_id.' .dcdt-clock .ce-col { color: '.$digitcolor.'; }';

	$html .= '.dcdt-count-timer-'.$timer_id.' .dcdt-timer-label { color: '.$textcolor.'; font-size: '.$timertext_fontsize.'px; }';

	$html .= '.dcdt-count-timer-'.$timer_id.' .dcdt-timer-digits { font-size: '.$timerdigit_fontsize.'px; }';

	if( $timer_style == 'circle' || $timer_style == 'circle-fill' ) {

		$html 	.= '.dcdt-count-timer-'.$timer_id.' .ce-flip-front,
					.dcdt-count-timer-'.$timer_id.' .ce-flip-back { height: '.$height_width.'px; }';

		$html .= '.dcdt-count-timer-'.$timer_id.' .dcdt-timer-digits { line-height: '.$height_width.'px; height: '.$height_width.'px; }';

	}

	if($timer_style == 'circle') {
		$html 	.= '.dcdt-count-timer-'.$timer_id.' .ce-flip-front,
					.dcdt-count-timer-'.$timer_id.' .ce-flip-back { border: 2px '.$circle_border_style.' '.$circle_border_color.'; }';
	}

	if($timer_style == 'circle-fill') {
		$html 	.= '.dcdt-count-timer-'.$timer_id.' .ce-flip-front,
					.dcdt-count-timer-'.$timer_id.' .ce-flip-back { background-color: '.$circle_bg_color.'; }';
	}

	$html 		.= '</style>';

	// Get General Options
	$unique				= ibwpl_get_unique();
	$timer_style 		= get_post_meta( $timer_id, $prefix.'timer_style', true );
	
	$timezone 			= get_option('gmt_offset');
	$tmzone 			= timezone_name_from_abbr("", $timezone*60*60 , 0) ; 	// get php time
	$current 			= new DateTime( "now", new DateTimeZone($tmzone) );
	$end_date 			= new DateTime( $timer['start'], new DateTimeZone($tmzone) );
	$totalseconds 		= $end_date->getTimestamp() - $current->getTimestamp();

	if( $totalseconds < 0 ) {
		$totalseconds = 0;
	}

	$current_date 	= date('c');
	$is_days		= get_post_meta($timer_id, $prefix.'is_timerdays', true);
	$is_hours		= get_post_meta($timer_id, $prefix.'is_timerhours', true);
	$is_minutes		= get_post_meta($timer_id, $prefix.'is_timerminutes', true);
	$is_seconds		= get_post_meta($timer_id, $prefix.'is_timerseconds', true);
	$days_text 		= get_post_meta($timer_id, $prefix.'timer_day_text', true);
	$hours_text 	= get_post_meta($timer_id, $prefix.'timer_hour_text', true);
	$minutes_text 	= get_post_meta($timer_id, $prefix.'timer_minute_text', true);
	$seconds_text 	= get_post_meta($timer_id, $prefix.'timer_second_text', true);
	$diff_date 		= ibwpl_dcdt_date_diff( $timer['end'] );
	$date_conf 		= compact('current_date','is_days','is_hours','is_minutes','is_seconds','days_text','hours_text','minutes_text','seconds_text','diff_date','timezone');

	$classes 		= '';

	if($timer_style == 'circle' || $timer_style == 'circle-fill') {
		$classes 	.= 'dcdt-countdown-timer-cf';
	}

	ob_start();

	include(IBWPL_DCDT_DIR.'/templates/clock.php');

	$html .= ob_get_clean();
	return $html;
}

/**
 * Function to get date diff
 * 
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_date_diff( $datetime ) {
	
	$diff_date 				= array();
	$diff_date['year']		= (int)date( 'Y', strtotime( $datetime ) );
	$diff_date['month']		= (int)date( 'm', strtotime( $datetime ) );
	$diff_date['day']		= (int)date( 'd', strtotime( $datetime ) );
	$diff_date['hour']		= (int)date( 'H', strtotime( $datetime ) );
	$diff_date['min']		= (int)date( 'i', strtotime( $datetime ) );
	$diff_date['second']	= (int)date( 's', strtotime( $datetime ) );
	return $diff_date;
}

/**
 * Function to option of border style 
 * 
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_border_style( $border_style ) { ?>
	<option value="solid" <?php if($border_style == 'solid') { echo 'selected'; } ?>><?php _e('Solid','inboundwp-lite'); ?></option>
	<option value="dashed" <?php if($border_style == 'dashed') { echo 'selected'; } ?>><?php _e('Dashed','inboundwp-lite'); ?></option>
	<option value="dotted" <?php if($border_style == 'dotted') { echo 'selected'; } ?>><?php _e('Dotted','inboundwp-lite'); ?></option>
	<option value="inset" <?php if($border_style == 'inset') { echo 'selected'; } ?>><?php _e('Inset','inboundwp-lite'); ?></option>
	<option value="outset" <?php if($border_style == 'outset') { echo 'selected'; } ?>><?php _e('Outset','inboundwp-lite'); ?></option>
<?php		
}