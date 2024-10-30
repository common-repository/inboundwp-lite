<?php
/**
 * Handles WhatsApp Chat Support metabox HTML
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$prefix = IBWPL_WTCS_META_PREFIX; // Metabox prefix

// Taking some data
$country_array	= ibwpl_country_phone_codes();
$weeks_arr		= ibwpl_get_weeks();
$times_arr		= ibwpl_get_times();

// Getting saved values
$enable				= ibwpl_wtcs_get_option( 'enable' );
$agent_name 		= get_post_meta( $post->ID, $prefix.'agent_name', true );
$country_code 		= get_post_meta( $post->ID, $prefix.'country_code', true );
$whatapp_number 	= get_post_meta( $post->ID, $prefix.'whatapp_number', true );
$designation 		= get_post_meta( $post->ID, $prefix.'designation', true );
$custom_message 	= get_post_meta( $post->ID, $prefix.'custom_message', true );
$status 			= get_post_meta( $post->ID, $prefix.'status', true );
$over_time_message 	= get_post_meta( $post->ID, $prefix.'over_time_message', true );
?>

<table class="form-table ibwp-tbl ibwp-wtcs-tbl">
	<tbody>
		<?php if( ! $enable ) { // Add general reminder when module is disabled from setting page ?>
		<tr>
			<td colspan="2" class="ibwp-no-padding">
				<div class="ibwp-info"><i class="dashicons dashicons-warning"></i> <?php esc_html_e('WhatsApp Chat is disabled from plugin setting page. Kindly enable it to use it.', 'inboundwp-lite'); ?></div>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2" class="ibwp-no-padding">
				<div class="ibwp-info ibwp-no-margin"><i class="dashicons dashicons-warning"></i> <?php echo __("InboundWP Lite supports 3 maximum agents. ". ibwpl_upgrade_pro_link() ." for unlimited agents.", 'inboundwp-lite'); ?></div>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ibwp-wtcs-agent-name"><?php _e('Agent Name', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo ibwpl_esc_attr( $agent_name ); ?>" class="ibwp-text large-text ibwp-wtcs-agent-name" id="ibwp-wtcs-agent-name" name="<?php echo $prefix; ?>agent_name" /><br/>
				<span class="description"><?php _e('Enter agent name. e.g. John Deo','inboundwp-lite')?></span>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ibwp-wtcs-whatapp-number"><?php _e('WhatsApp Number', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select class="ibwp-select2 wtcs-country-code" name="<?php echo $prefix; ?>country_code" id="wtcs-country-code" data-placeholder="<?php esc_html_e('Select Country Code', 'inboundwp-lite'); ?>">
					<option value=""></option>
					<?php foreach ($country_array as $country_key => $country_value) { ?>
						<option value="<?php echo ibwpl_esc_attr( $country_key ); ?>" <?php selected( $country_code, $country_key ); ?>><?php echo $country_value; ?></option>
					<?php } ?>
				</select>
				<input type="text" class="ibwp-text regular-text ibwp-number-input ibwp-wtcs-whatapp-number" id="ibwp-wtcs-whatapp-number" name="<?php echo $prefix; ?>whatapp_number" value="<?php echo ibwpl_esc_attr( $whatapp_number ); ?>" /><br/>
				<span class="description"><?php _e('Select country code and enter WhatsApp number.', 'inboundwp-lite')?></span>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ibwp-wtcs-designation"><?php _e('Designation', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" class="ibwp-text large-text ibwp-wtcs-designation" id="ibwp-wtcs-designation" name="<?php echo $prefix; ?>designation" value="<?php echo ibwpl_esc_attr( $designation ); ?>" /><br>
				<span class="description"><?php _e('Enter agent designation. e.g. Customer Support','inboundwp-lite')?></span>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ibwp-wtcs-status"><?php _e('Availability Status', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select name="<?php echo $prefix; ?>status" class="ibwp-select ibwp-wtcs-status ibwp-show-hide" id="ibwp-wtcs-status" data-prefix="wtcs-status">
					<option value="online" <?php selected( $status, 'online' ); ?>><?php esc_html_e('Always Available Online', 'inboundwp-lite'); ?></option>
					<option value="custom" <?php selected( $status, 'custom' ); ?>><?php esc_html_e('Custom Availability', 'inboundwp-lite'); ?></option>
				</select><br/>
				<span class="description"><?php _e( 'Select agent availability status.', 'inboundwp-lite' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ibwp-wtcs-custom-msg"><?php _e('Custom Message', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<textarea class="ibwp-textarea large-text ibwp-wtcs-custom-msg" id="ibwp-wtcs-custom-msg" name="<?php echo $prefix; ?>custom_message"><?php echo esc_textarea( $custom_message ); ?></textarea><br/>
				<span class="description"><?php _e( 'Enter WhatsApp predefined message e.g. Hello, I have visited your site and I need help from you.', 'inboundwp-lite' ); ?></span>
			</td>
		</tr>

		<!-- Custom Availability -->
		<tr class="ibwp-wtcs-offline ibwp-show-hide-row-wtcs-status ibwp-show-if-wtcs-status-custom" style="<?php if( $status != 'custom' ) { echo 'display: none;'; } ?>">
			<td class="ibwp-no-padding" colspan="2">
				<table class="form-table ibwp-tbl time-available">
					<tbody>
						<tr class="ibwp-wtcs-offline">
							<th scope="row">
								<label for="ibwp-wtcs-offline-message"><?php _e('Offline Message', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" value="<?php echo ibwpl_esc_attr( $over_time_message ); ?>" class="ibwp-text large-text ibwp-wtcs-over-time-message" id="ibwp-wtcs-over-time-message" name="<?php echo $prefix; ?>over_time_message" placeholder="<?php esc_html_e( 'I will be back soon', 'inboundwp-lite' ); ?>" /><br>
								<span class="description"><?php _e( 'Enter message when agent is offline. e.g I will be back soon.', 'inboundwp-lite' ); ?></span>
								<br/><br/>
								<div class="ibwp-pro-feature">
									<input type="text" value="" class="ibwp-text large-text ibwp-wtcs-offline-message" id="ibwp-wtcs-offline-message" name="" placeholder="<?php esc_html_e( 'I will be back in {back_to_work_time} (H:M)', 'inboundwp-lite' ); ?>" disabled /><br>
									<span class="description"><?php _e( 'Enter message when agent is about to online. e.g I will be back in {back_to_work_time} (H:M). Available template tags are:', 'inboundwp-lite' ); ?></span> <br/>
									<span class="description"><code class="ibwp-copy-clipboard">{back_to_work_time}</code> - <?php echo esc_html__( 'Display agent back to online time. ', 'inboundwp-lite' ) . ibwpl_upgrade_pro_link(); ?></span>
								</div>
							</td>
						</tr>
						<tr class="ibwp-pro-feature">
							<th scope="row">
								<label><?php echo __('Custom Availability', 'inboundwp-lite')?></label>
							</th>
							<td>
								<?php foreach ($weeks_arr as $week_key => $week_data) { ?>
								<div class="ibwp-loop-row">
									<label class="ibwp-row-lbl">
										<input value="" type="checkbox" name="" class="ibwp-checkbox ibwp-wtcs-availability" disabled / >
										<?php echo $week_data; ?>
									</label>

									<select name="" class="ibwp-select ibwp-wtcs-hour-start" disabled>
										<?php foreach ($times_arr as $time_key => $time_data) { ?>
											<option value=""><?php echo $time_data; ?></option>
										<?php } ?>
									</select>

									<select name="" class="ibwp-select ibwp-wtcs-hour-end" disabled>
										<?php foreach ($times_arr as $time_key => $time_data) { ?>
											<option value=""><?php echo $time_data; ?></option>
										<?php } ?>
									</select>
								</div>
								<?php } ?>
								<span class="description"><?php echo __('If you want to custom availability. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table><!-- end .ibwp-wtcs-tbl -->