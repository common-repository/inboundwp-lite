<?php
/**
 * Handles Advance Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$show_for_data		= ibwpl_show_for_options();
$wheel_time_data	= ibwpl_time_options();
$advance			= get_post_meta( $post->ID, $prefix.'advance', true );
$cookie_expire		= isset( $advance['cookie_expire'] )	? $advance['cookie_expire']	: '';
$cookie_unit		= ! empty( $advance['cookie_unit'] )	? $advance['cookie_unit']	: 'day';
$mobile_disable		= !empty( $advance['mobile_disable'] )	? 1	: 0;
?>

<div id="ibwp_spw_advance_sett" class="ibwp-vtab-cnt ibwp-spw-advance-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Advance Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Wheel advance settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-spw-mob-enable"><?php _e('Disable on Mobile', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[mobile_disable]" value="1" <?php checked( $mobile_disable, 1 ); ?> id="ibwp-spw-mob-enable" class="ibwp-checkbox ibwp-spw-mob-enable" /><br/>
					<span class="description"><?php _e('Check this box if you want to disable spin wheel on mobile device.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-cookie-expire"><?php _e('Cookie Expiry Time', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[cookie_expire]" value="<?php echo ibwpl_esc_attr( $cookie_expire ); ?>" class="ibwp-text ibwp-spw-cookie-expire" id="ibwp-spw-cookie-expire" />
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[cookie_unit]" class="ibwp-select" style="vertical-align: top;">
						<?php if( ! empty( $wheel_time_data ) ) {
							foreach ( $wheel_time_data as $wheel_time_key => $wheel_time_val ) { ?>
								<option value="<?php echo ibwpl_esc_attr( $wheel_time_key ); ?>" <?php selected( $cookie_unit, $wheel_time_key ); ?> <?php if( $wheel_time_key != 'day' ) { echo 'disabled'; } ?> ><?php echo $wheel_time_val; ?></option>
							<?php }
						} ?>
					</select><br />
					<span class="description"><?php _e('Enter cookie expiry time after how many days user can see spin wheel again. Some values are.', 'inboundwp-lite'); ?></span>
					<div class="ibwp-code-tag-wrap">
						<code><?php esc_html_e('Each Page Load', 'inboundwp-lite') ?></code> - <span class="description"><?php esc_html_e('Leave it blank to display spin wheel on each page load.', 'inboundwp-lite'); ?></span><br/>
						<code><?php esc_html_e('After X times', 'inboundwp-lite') ?></code> - <span class="description"><?php esc_html_e('Enter cookie expiry time after how many times user can see spin wheel again.', 'inboundwp-lite'); ?></span><br/>
						<span class="description ibwp-pro-feature"><code><?php esc_html_e('Once Per Session', 'inboundwp-lite') ?></code> - <span class="description"><?php echo __('Enter 0 to display spin wheel once per browser session. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span></span>
					</div>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-show-for"><?php _e('Show For', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-show-hide ibwp-spw-show-for" id="ibwp-spw-show-for" disabled />
						<?php if( ! empty( $show_for_data ) ) {
							foreach ( $show_for_data as $show_for_key => $show_for_val ) { ?>
								<option value=""><?php echo $show_for_val; ?></option>
							<?php }
						} ?>
					</select><br/>
					<span class="description"><?php echo __('Choose spin wheel visibility for users. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-store-no-views"><?php _e('Do not Store Impression or Clicks Data', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-spw-store-no-views" id="ibwp-spw-store-no-views" disabled /><br/>
					<span class="description"><?php echo __('Check this box if you do not want to store spin wheel impressions or clicks data in database. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-store-no-data"><?php _e('Do not Store Form Submission Data', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-spw-store-no-data" id="ibwp-spw-store-no-data" disabled /><br/>
					<span class="description"><?php echo __('Check this box if you do not want to store spin wheel form submission data in database. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<!-- Start - Wheel Restriction -->
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-restriction"><?php _e('Wheel Restriction', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-show-hide ibwp-spw-restriction" id="ibwp-spw-restriction" disabled >
						<option value=""><?php esc_html_e('No Restriction', 'inboundwp-lite'); ?></option>
						<option value=""><?php esc_html_e('Wheel Cookie', 'inboundwp-lite'); ?></option>
						<option value=""><?php esc_html_e('Wheel Spin Per Email', 'inboundwp-lite'); ?></option>
						<option value=""><?php esc_html_e('Delay Between Each Spin', 'inboundwp-lite'); ?></option>
					</select><br/>
					<span class="description"><?php echo __('Choose spin wheel restriction. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<!-- End - Wheel Restriction -->

			<tr class="ibwp-pro-feature">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="3">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Spin Wheel Schedule Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>

						<tr>
							<th>
								<label for="ibwp-spw-schedule-start"><?php _e('Start Time', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-datetime ibwp-spw-schedule-start" id="ibwp-spw-schedule-start" disabled /><br/>
								<span class="description"><?php _e('Set spin wheel start time.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-schedule-end"><?php _e('End Time', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-datetime ibwp-spw-schedule-end" id="ibwp-spw-schedule-end" disabled /><br/>
								<span class="description"><?php _e('Set spin wheel end time.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-spw-advance-sett -->