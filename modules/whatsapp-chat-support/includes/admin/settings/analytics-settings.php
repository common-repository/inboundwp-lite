<?php
/**
 * Analytics Settings
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some data
$ganaly_enable	= ibwpl_wtcs_get_option( 'ganaly_enable' );
$ganaly_id		= ibwpl_wtcs_get_option( 'ganaly_id' );
?>

<div class="postbox">

	<button class="handlediv button-link" type="button"><span class="toggle-indicator"></span></button>

	<h3 class="hndle">
		<span><?php _e( 'Google Analytics', 'inboundwp-lite' ); ?></span>
	</h3>

	<div class="inside">
		<table class="form-table ibwp-tbl">
			<tbody>
				<tr>
					<th>
						<label for="ibwp-wtcs-ganaly-enable"><?php _e( 'Enable', 'inboundwp-lite' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="ibwp_wtcs_options[ganaly_enable]" id="ibwp-wtcs-ganaly-enable" value="1" <?php checked( $ganaly_enable, 1 ); ?> class="ibwp-checkbox ibwp-wtcs-ganaly-enable" /><br/>
						<span class="description"><?php _e('Check this box to enable Google Analytics. An event is recorded at Google Analytics when any user click on Chat toggle OR click on agent to chat.', 'inboundwp-lite'); ?></span><br/>
						<span class="description"><?php _e('You can read more about the Google Analytics event <a href="https://support.google.com/analytics/answer/1033068?hl=en" target="_blank">here</a>. Note: Google Analytics code must be present on your website to work.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-ganaly-id"><?php _e( 'Google Analytic ID', 'inboundwp-lite' ); ?></label>
					</th>
					<td>
						<input type="text" name="ibwp_wtcs_options[ganaly_id]" id="ibwp-wtcs-ganaly-id" value="<?php echo ibwpl_esc_attr( $ganaly_id ); ?>" class="regular-text ibwp-wtcs-ganaly-id" /><br/>
						<span class="description"><?php _e('Enter Google Analytic id here. You can find Google Analytic id from your site analytic code. e.g UA-XXXXXX', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_wtcs_sett_submit" class="button button-primary right ibwp-btn ibwp-ganaly-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->