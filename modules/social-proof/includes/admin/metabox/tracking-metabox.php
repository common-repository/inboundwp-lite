<?php
/**
 * Handles Tracking Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div id="ibwp_sp_tracking_sett" class="ibwp-vtab-cnt ibwp-sp-tracking-sett ibwp-clearfix ibwp-pro-feature">
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Tracking Settings ', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php echo __('Choose Social Proof analytics tracking settings. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tr>
			<th>
				<label for="ibwp-sp-utm-source"><?php _e('Campaign Source', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" name="" value="" class="large-text ibwp-text ibwp-sp-utm-source" id="ibwp-sp-utm-source" disabled /><br/>
				<span class="description"><?php _e('Enter campaign source.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="ibwp-sp-utm-medium"><?php _e('Campaign Medium', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" name="" value="" class="large-text ibwp-text ibwp-sp-utm-medium" id="ibwp-sp-utm-medium" disabled /><br/>
				<span class="description"><?php _e('Enter campaign medium.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="ibwp-sp-utm-campaign"><?php _e('Campaign Name', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" name="" value="" class="large-text ibwp-text ibwp-sp-utm-campaign" id="ibwp-sp-utm-campaign" disabled /><br/>
				<span class="description"><?php _e('Enter campaign name.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>
	</table>
</div><!-- end .ibwp-sp-tracking-sett -->