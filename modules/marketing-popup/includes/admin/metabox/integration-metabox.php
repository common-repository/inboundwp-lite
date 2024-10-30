<?php
/**
 * Handles Notification Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$intgs_page = add_query_arg( array( 'page' => 'ibwp-integration' ), admin_url('admin.php') );
?>

<div id="ibwp_mp_integration_sett" class="ibwp-vtab-cnt ibwp-mp-integration-sett ibwp-clearfix ibwp-pro-feature">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Integration Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php echo esc_html__('Choose popup mail integration settings. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-mp-mc-enable"><?php _e('Enable','inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" id="ibwp-mp-mc-enable" disabled /><br/>
					<span class="description"><?php _e('Check this box to enable MailChimp integration.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="ibwp-notice"><?php _e('MailChimp account is not connected. Please configure it from', 'inboundwp-lite'); ?> <a href="<?php echo esc_url( $intgs_page ); ?>" target="_blank"><?php esc_html_e('here', 'inboundwp-lite'); ?></a>.</div>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-mp-integration-sett -->