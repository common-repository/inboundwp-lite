<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package InboundWP Lite
 * @package Deal Countdown Timer
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $post;
$prefix = IBWPL_DCDT_META_PREFIX; // Metabox prefix

// get timezon from WP settings
$current_offset = get_option('gmt_offset');
$tzstring 		= get_option('timezone_string');

// Remove old Etc mappings. Fallback to gmt_offset.
if ( false !== strpos($tzstring,'Etc/GMT') ){
	$tzstring = '';
}

if ( empty($tzstring) ) { // Create a UTC+- zone if no timezone string exists
	if ( 0 == $current_offset ) {
		$tzstring = 'UTC+0';
	} elseif ($current_offset < 0) {
		$tzstring = 'UTC' . $current_offset;
	} else {
		$tzstring = 'UTC+' . $current_offset;
	}
}

// Getting saved values
$timer_style 			= get_post_meta( $post->ID, $prefix.'timer_style', true );
$timer_position 		= get_post_meta( $post->ID, $prefix.'timer_position', true );

// Circle Clock Settings values
$circle_border_color	= get_post_meta( $post->ID, $prefix.'circle_border_color', true );
$circle_border_style 	= get_post_meta( $post->ID, $prefix.'circle_border_style', true );

// Circle Fill Clock Settings values
$circle_bg_color		= get_post_meta( $post->ID, $prefix.'circle_bg_color', true );

// General Settings Values
$timertext_fontsize 	= get_post_meta( $post->ID, $prefix.'timertext_fontsize', true );
$timertext_color		= get_post_meta( $post->ID, $prefix.'timertext_color', true );

$timerdigit_fontsize 	= get_post_meta( $post->ID, $prefix.'timerdigit_fontsize', true );
$timerdigit_color 			= get_post_meta( $post->ID, $prefix.'timerdigit_color', true );

$is_days 				= get_post_meta( $post->ID, $prefix.'is_timerdays', true );
$is_days 				= ($is_days != '') 				? $is_days 				: 1;
$timer_day_text 		= get_post_meta( $post->ID, $prefix.'timer_day_text', true );
$timer_day_text 		= ($timer_day_text != '') 		? $timer_day_text 		: 'Days';

$is_hours 				= get_post_meta( $post->ID, $prefix.'is_timerhours', true );
$is_hours 				= ($is_hours != '') 			? $is_hours 			: 1;
$timer_hour_text 		= get_post_meta( $post->ID, $prefix.'timer_hour_text', true );
$timer_hour_text 		= ($timer_hour_text != '') 		? $timer_hour_text 		: 'Hours';

$is_minutes 			= get_post_meta( $post->ID, $prefix.'is_timerminutes', true );
$is_minutes 			= ($is_minutes != '') 			? $is_minutes 			: 1;
$timer_minute_text 		= get_post_meta( $post->ID, $prefix.'timer_minute_text', true );
$timer_minute_text 		= ($timer_minute_text != '')	? $timer_minute_text	: 'Minutes';

$is_seconds 			= get_post_meta( $post->ID, $prefix.'is_timerseconds', true );
$is_seconds 			= ($is_seconds != '') 			? $is_seconds 			: 1;
$timer_second_text 		= get_post_meta( $post->ID, $prefix.'timer_second_text', true );
$timer_second_text 		= ($timer_second_text != '') 	? $timer_second_text 	: 'Seconds';

// Inventory Stock Progress Bar Values
$stock_prog_bar 		= get_post_meta( $post->ID, $prefix.'stock_prog_bar', true );
$instock_text 			= get_post_meta( $post->ID, $prefix.'instock_text', true );
$outofstock_text 		= get_post_meta( $post->ID, $prefix.'outofstock_text', true );
$instock_color 			= get_post_meta( $post->ID, $prefix.'instock_color', true );
$outofstock_color 		= get_post_meta( $post->ID, $prefix.'outofstock_color', true );
$progress_bar_color 	= get_post_meta( $post->ID, $prefix.'progress_bar_color', true );

$timer_style_arr		= array( 'circle', 'circle-fill' ); 
?>

<table class="form-table dcdt-post-sett-table">
	<tbody>
		<tr>
			<td colspan="2">
				<div class="ibwp-info-note">
					<?php echo sprintf( __('Deal Countdown Timer is work with WordPress timezone which you had set from <a href="%s" target="_blank">General Setting</a> page.', 'inboundwp-lite'), admin_url('options-general.php') ); ?> <br/>
					<?php echo __('Your current timezone is', 'inboundwp-lite') .' : '. $tzstring; ?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label for="dcdt-timer-style"><?php _e('Timer Style','inboundwp-lite'); ?></label>
			</th>
			<td>
				<select name="<?php echo $prefix ?>timer_style" class="dcdt-timer-style" id="dcdt-timer-style">
					<?php foreach ($timer_style_arr as $style) { 
						$timer_name = str_replace( "-", " ", $style );
						?>
						<option value="<?php echo $style; ?>" <?php selected($timer_style, $style); ?>><?php echo ucwords( $timer_name ); ?></option>
					<?php } ?>
				</select><br>
				<span class="description"><?php _e('Select timer style for a single product page & product slider.','inboundwp-lite'); ?></span><br/>
				<span class="description ibwp-pro-feature"><?php echo __('If you want to more timer style. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
			</td>
		</tr>

		<tr class="ibwp-dcdt-style-img">
			<th scope="row"></th>
			<?php
			$i = 1;
			foreach ($timer_style_arr as $style) {?>
				<td class="dcdt-timer-<?php echo $style; ?> dcdt-timer-image-prev dcdt-post-common" style="<?php if($timer_style == $style || ( $timer_style == '' && $i == 1 ) ) { echo 'display:block'; } else { echo 'display:none'; } ?>">
					<img src="<?php echo IBWPL_DCDT_URL.'assets/images/'.$style.'.png'; ?>">
				</td>
			<?php $i++; } ?>
		</tr>
		<?php if ( class_exists( 'WooCommerce' ) ) { ?>
		<tr>
			<th scope="row">
				<label for="dcdt-timer-position"><?php _e('Timer Position','inboundwp-lite'); ?></label>
			</th>
			<td>
				<select name="<?php echo $prefix; ?>timer_position" class="dcdt-timer-position" id="dcdt-timer-position">
					<option value="before-title" <?php if($timer_position == 'before-title'){echo 'selected'; } ?>><?php _e( 'Before The Title', 'inboundwp-lite'); ?></option>
					<option value="after-title" <?php if($timer_position == 'after-title'){echo 'selected'; } ?>><?php _e( 'After The Title', 'inboundwp-lite'); ?></option>
					<option value="after-price" <?php if($timer_position == 'after-price'){echo 'selected'; } ?>><?php _e( 'After The Price', 'inboundwp-lite'); ?></option>
					<option value="before-cart-btn" <?php if($timer_position == 'before-cart-btn'){echo 'selected'; } ?>><?php _e( 'Before Add to Cart Button', 'inboundwp-lite'); ?></option>
					<option value="after-cart-btn" <?php if($timer_position == 'after-cart-btn'){echo 'selected'; } ?>><?php _e( 'After Add to Cart Button', 'inboundwp-lite'); ?></option>
					<option value="after-product-meta" <?php if($timer_position == 'after-product-meta'){echo 'selected'; } ?>><?php _e( 'After Product Meta', 'inboundwp-lite'); ?></option>
				</select><br>
				<span class="description"><?php _e('Select Timer Position only for Single Product Page <b>(WooCommerce Only)</b>.','inboundwp-lite'); ?></span>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<hr>

<!-- Circle Clock options starts -->
<div class="dcdt-timer-style-circle dcdt-post-common" style="<?php if($timer_style == 'circle' || $timer_style == ''){ echo 'display:block';  }else{ echo 'display:none'; } ?>">

	<h3><?php _e('Circle Clock Settings', 'inboundwp-lite'); ?></h3>
	<table class="form-table dcdt-post-sett-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="dcdt-circle-border-color"><?php _e('Border Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" class="ibwp-colorpicker" name="<?php echo $prefix; ?>circle_border_color" value="<?php echo ibwpl_esc_attr($circle_border_color); ?>" id="dcdt-circle-border-color">
					<span class="description"><?php _e('Select circle clock border color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="dcdt-circle-border-style"><?php _e('Border Style','inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo $prefix ?>circle_border_style" class="dcdt-circle-border-style" id="dcdt-circle-border-style">
						<?php ibwpl_dcdt_border_style( $circle_border_style ); ?>
					</select><br>
					<span class="description"><?php _e('Select circle clock border style','inboundwp-lite'); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
</div>
<!-- Circle Clock options ends -->

<!-- Circle Fill Clock options starts -->
<div class="dcdt-timer-style-circle-fill dcdt-post-hide dcdt-post-common" style="<?php if($timer_style == 'circle-fill'){ echo 'display:block';  }else{ echo 'display:none'; } ?>">

	<h3><?php _e('Circle Fill Clock Settings', 'inboundwp-lite'); ?></h3>
	<table class="form-table dcdt-post-sett-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="dcdt-circle-bg-color"><?php _e('Background Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" class="ibwp-colorpicker" name="<?php echo $prefix; ?>circle_bg_color" value="<?php echo ibwpl_esc_attr($circle_bg_color); ?>" id="dcdt-circle-bg-color">
					<span class="description"><?php _e('Select circle fill clock background color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
</div>
<!-- Circle Fill Clock options ends -->

<!-- General Options Start -->
<div class="dcdt-post-general-sett">
	<h3><?php _e('General Settings', 'inboundwp-lite'); ?></h3>
	<table class="form-table dcdt-post-sett-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="dcdt-lbl-font-size"><?php _e('Timer Label Font Size','inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="number" name="<?php echo $prefix; ?>timertext_fontsize" value="<?php echo ibwpl_esc_attr($timertext_fontsize); ?>" class="dcdt-timertext-font-size" id="dcdt-lbl-font-size">
					<span><?php _e( 'px', 'inboundwp-lite' ); ?></span><br>
					<span class="description"><?php _e('Set timer label font size.','inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="dcdt-lbl-text-color"><?php _e('Timer Label Text Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" class="ibwp-colorpicker" name="<?php echo $prefix; ?>timertext_color" value="<?php echo ibwpl_esc_attr($timertext_color); ?>" id="dcdt-lbl-text-color">
					<span class="description"><?php _e('Select timer label color like Days, Hours, Minutes and Seconds.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="dcdt-digit-font-size"><?php _e('Timer Digit Font Size','inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="number" name="<?php echo $prefix; ?>timerdigit_fontsize" value="<?php echo ibwpl_esc_attr($timerdigit_fontsize); ?>" class="dcdt-timerdigit-font-size" id="dcdt-digit-font-size">
					<span><?php _e( 'px', 'inboundwp-lite' ); ?></span><br>
					<span class="description"><?php _e('Set timer digit font size.','inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="dcdt-digit-text-color"><?php _e('Timer Digit Text Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" class="ibwp-colorpicker" name="<?php echo $prefix; ?>timerdigit_color" value="<?php echo ibwpl_esc_attr($timerdigit_color); ?>" data-default-color="#ff9900" id="dcdt-digit-text-color">
					<span class="description"><?php _e('Select timer clock digit color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="dcdt-clock-text"><?php _e('Timer Clock Text', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<table>
						<tr>
							<td>
								<label>
									<input type="checkbox" name="<?php echo $prefix; ?>is_timerdays" value="1" <?php checked($is_days,1); ?> />
									<input type="text" id="dcdt-countdown-day-text" class="dcdt-countdown-day-text" name="<?php echo ibwpl_esc_attr($prefix); ?>timer_day_text" value="<?php echo ibwpl_esc_attr($timer_day_text); ?>">
								</label><br/>
								<span class="description"><?php _e('Check this box to enable Days in timer and add your desired text.', 'inboundwp-lite'); ?></span>
							</td>

							<td>
								<label>
									<input type="checkbox" name="<?php echo $prefix; ?>is_timerhours" value="1" <?php checked($is_hours,1); ?>>
									<input type="text" id="dcdt-countdown-hour-text" class="dcdt-countdown-hour-text" name="<?php echo ibwpl_esc_attr($prefix); ?>timer_hour_text" value="<?php echo ibwpl_esc_attr($timer_hour_text); ?>">
								</label><br/>
								<span class="description"><?php _e('Check this box to enable Hours in timer and add your desired text.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<td>
								<label>
									<input type="checkbox" name="<?php echo $prefix; ?>is_timerminutes" value="1" <?php checked($is_minutes,1); ?>>
									<input type="text" id="dcdt-countdown-minutes-text" class="dcdt-countdown-minutes-text" name="<?php echo ibwpl_esc_attr($prefix); ?>timer_minute_text" value="<?php echo ibwpl_esc_attr($timer_minute_text); ?>">
								</label><br/>
								<span class="description"><?php _e('Check this box to enable Minutes in timer and add your desired text.', 'inboundwp-lite'); ?></span>
							</td>

							<td>
								<label>
									<input type="checkbox" name="<?php echo $prefix; ?>is_timerseconds" value="1" <?php checked($is_seconds,1); ?>>
									<input type="text" id="dcdt-countdown-seconds-text" class="dcdt-countdown-seconds-text" name="<?php echo ibwpl_esc_attr($prefix); ?>timer_second_text" value="<?php echo ibwpl_esc_attr($timer_second_text); ?>">
								</label><br/>
								<span class="description"><?php _e('Check this box to enable Seconds in timer and add your desired text.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- General Options End -->

<!-- Stock management progress bar options start -->
<?php if ( class_exists( 'WooCommerce' ) ) { ?>
	<hr>
	<div class="dcdt-stock-management-prog">
		<h3><?php _e('Product Inventory Stock Progress Bar', 'inboundwp-lite'); ?></h3>
		<table class="form-table dcdt-post-sett-table">
			<tbody>
				<tr>
					<td colspan="2">
						<div class="ibwp-info-note">
							<?php _e('Deal Countdown Timer Inventory Stock Progress Bar is only work with Woocommerce.<br>For that, you have to set inventory stock from product and then enable this setting.','inboundwp-lite'); ?>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dcdt-stock-progress-enable"><?php _e('Enable','inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="<?php echo $prefix; ?>stock_prog_bar" value="1" class="dcdt-stock-progress-enable" <?php checked($stock_prog_bar,1); ?> id="dcdt-stock-progress-enable"><br>
						<span class="description"><?php _e('Check this checkbox to show the Product Stock progress bar only on single product page.','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dcdt-instock-text"><?php _e('In Stock','inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="<?php echo $prefix; ?>instock_text" value="<?php echo ibwpl_esc_attr($instock_text); ?>" class="dcdt-instock-text" placeholder="Just % items left in stock" id="dcdt-instock-text"><br>
						<span class="description"><?php _e('Enter product in stock text. But %s is the product stock value.','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dcdt-outofstock-text"><?php _e('Out Of Stock','inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="<?php echo $prefix; ?>outofstock_text" value="<?php echo ibwpl_esc_attr($outofstock_text); ?>" class="dcdt-outofstock-text" placeholder="Out of stock" id="dcdt-outofstock-text"><br>
						<span class="description"><?php _e('Enter product out of stock text.','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="dcdt-instock-text-color"><?php _e('In Stock Text Color','inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="<?php echo $prefix; ?>instock_color" value="<?php echo ibwpl_esc_attr($instock_color); ?>" class="dcdt-instock-color ibwp-colorpicker" id="dcdt-instock-text-color">
						<span class="description"><?php _e('Select in stock text color.','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="dcdt-outofstock-text-color"><?php _e('Out Of Stock Text Color','inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="<?php echo $prefix; ?>outofstock_color" value="<?php echo ibwpl_esc_attr($outofstock_color); ?>" class="dcdt-outofstock-color ibwp-colorpicker" id="dcdt-outofstock-text-color">
						<span class="description"><?php _e('Select out of stock text color.','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="dcdt-progress-bar-color"><?php _e('Progress Bar Color','inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="<?php echo $prefix; ?>progress_bar_color" value="<?php echo ibwpl_esc_attr($progress_bar_color); ?>" class="dcdt-progress-bar-color ibwp-colorpicker" id="dcdt-progress-bar-color">
						<span class="description"><?php _e('Select progress bar color.','inboundwp-lite'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php } ?>
<!-- Stock management progress bar options end -->