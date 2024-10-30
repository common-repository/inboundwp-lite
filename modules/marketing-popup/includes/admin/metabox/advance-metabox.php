<?php
/**
 * Handles Advance Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Global variable
global $wp_roles;

// Taking some variable
$show_for_data		= ibwpl_show_for_options();
$popup_time_data	= ibwpl_time_options();
$advance			= get_post_meta( $post->ID, $prefix.'advance', true );
$cookie_expire		= isset( $advance['cookie_expire'] )	? $advance['cookie_expire']	: '';
$cookie_unit		= ! empty( $advance['cookie_unit'] )	? $advance['cookie_unit']	: 'days';
$show_credit		= !empty( $advance['show_credit'] )		? 1	: 0;
$mobile_disable		= !empty( $advance['mobile_disable'] )	? 1	: 0;
?>

<div id="ibwp_mp_advance_sett" class="ibwp-vtab-cnt ibwp-mp-advance-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Advance Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Popup advance settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-mp-mob-enable"><?php _e('Disable on Mobile', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[mobile_disable]" value="1" <?php checked( $mobile_disable, 1 ); ?> id="ibwp-mp-mob-enable" class="ibwp-checkbox ibwp-mp-mob-enable" /><br/>
					<span class="description"><?php _e('Check this box if you want to disable popup on mobile device.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-show-credit"><?php _e('Show Credit', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[show_credit]" value="1" <?php checked( $show_credit, 1 ); ?> class="ibwp-checkbox ibwp-mp-show-credit" id="ibwp-mp-show-credit" /><br/>
					<span class="description"><?php _e('Check this box to show credit of our work A huge thanks in advance :)', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-cookie-expire"><?php _e('Cookie Expiry Time', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[cookie_expire]" value="<?php echo ibwpl_esc_attr( $cookie_expire ); ?>" class="ibwp-text ibwp-mp-cookie-expire" id="ibwp-mp-cookie-expire" />
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[cookie_unit]" class="ibwp-select" style="vertical-align: top;">
						<?php if( ! empty( $popup_time_data ) ) {
							foreach ( $popup_time_data as $popup_time_key => $popup_time_val ) { ?>
								<option value="<?php echo ibwpl_esc_attr( $popup_time_key ); ?>" <?php selected( $cookie_unit, $popup_time_key ); ?> <?php if( $popup_time_key != 'day' ) { echo 'disabled'; } ?> ><?php echo $popup_time_val; ?></option>
							<?php }
						} ?>
					</select><br />
					<span class="description"><?php _e('Enter cookie expiry time after how many days user can see popup again. Some values are.', 'inboundwp-lite'); ?></span>
					<div class="ibwp-code-tag-wrap">
						<code><?php esc_html_e('Each Page Load', 'inboundwp-lite'); ?></code> - <span class="description"><?php esc_html_e('Leave it blank to display popup on each page load.', 'inboundwp-lite'); ?></span><br/>
						<code><?php esc_html_e('After X times', 'inboundwp-lite'); ?></code> - <span class="description"><?php esc_html_e('Enter cookie expiry time after how many times user can see popup again.', 'inboundwp-lite'); ?></span><br/>
						<span class="ibwp-pro-feature"><code><?php esc_html_e('Once Per Session', 'inboundwp-lite') ?></code> - <span class="description"><?php echo esc_html__('Enter 0 to display popup once per browser session. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span></span>
					</div>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-show-for"><?php _e('Show For', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-show-hide ibwp-mp-show-for" id="ibwp-mp-show-for" disabled />
						<?php if( ! empty( $show_for_data ) ) {
							foreach ( $show_for_data as $show_for_key => $show_for_val ) { ?>
								<option value=""><?php echo $show_for_val; ?></option>
							<?php }
						} ?>
					</select><br/>
					<span class="description"><?php echo __('Choose popup visibility for users. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-store-no-views"><?php _e('Do not Store Impression or Clicks Data', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-mp-store-no-views" id="ibwp-mp-store-no-views" disabled /><br/>
					<span class="description"><?php echo __('Check this box if you do not want to store popup impressions or clicks data in database. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-store-no-data"><?php _e('Do not Store Form Submission Data', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-mp-store-no-data" id="ibwp-mp-store-no-data" disabled /><br/>
					<span class="description"><?php echo __('Check this box if you do not want to store `Collect Email` popup form Submission data in database. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>

			<!-- Start - Schedule Settings -->
			<tr class="ibwp-pro-feature">
				<td colspan="2" class="iwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="3">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Popup Schedule Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>

						<tr>
							<th>
								<label for="ibwp-mp-schedule-start"><?php _e('Start Time', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-datetime ibwp-mp-schedule-start" id="ibwp-mp-schedule-start" disabled /><br/>
								<span class="description"><?php _e('Set popup start time.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-schedule-end"><?php _e('End Time', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-datetime ibwp-mp-schedule-end" id="ibwp-mp-schedule-end" disabled /><br/>
								<span class="description"><?php _e('Set popup end time.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-mp-advance-sett -->