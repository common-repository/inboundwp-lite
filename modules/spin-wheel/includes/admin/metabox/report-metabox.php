<?php
/**
 * Spin Wheel Report Metabox. Spin Wheel Click, Impression and Report Link
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="ibwp-spw-wheel-report-sett ibwp-cnt-wrap">
	<div class="ibwp-preview-btn-wrp">
		<button type="button" class="button button-large button-primary ibwp-btn ibwp-btn-large ibwp-module-preview-btn ibwp-spw-preview-btn ibwp-show-popup-modal" data-preview="1"><?php esc_html_e('Preview Spin Wheel', 'inboundwp-lite'); ?></button>
	</div>
	<div class="ibwp-pro-feature">
		<div class="ibwp-clearfix ibwp-center">
			<div class="ibwp-column ibwp-medium-6">
				<div class="ibwp-spw-report-title"><strong><?php _e('Impressions', 'inboundwp-lite'); ?></strong></div>
				<span class="ibwp-spw-report-no">0</span>
			</div>
			<div class="ibwp-column ibwp-medium-6">
				<div class="ibwp-spw-report-title"><strong><?php _e('Clicks', 'inboundwp-lite'); ?></strong></div>
				<span class="ibwp-spw-report-no">0</span>
			</div>
		</div>

		<p class="ibwp-spw-wheel-report-link ibwp-center">
			<a href="#" target="_blank"><?php esc_html_e('View Report', 'inboundwp-lite'); ?></a> | 
			<a href="#" target="_blank"><?php esc_html_e('View Entries', 'inboundwp-lite'); ?></a>
		</p>
		<hr/>

		<div class="ibwp-spw-flush-report-wrp">
			<button type="button" class="button button-secondary ibwp-btn ibwp-spw-flush-stats-btn" disabled ><?php esc_html_e('Flush Stats', 'inboundwp-lite'); ?></button>
			<span class="spinner ibwp-spinner"></span>
			<hr/>
			<span class="description"><?php esc_html_e('Note : Flush Stats button will only flush the `Impressions` and `Clicks` meta for this post. The spin wheel report will not be affected by this.', 'inboundwp-lite'); ?></span>
		</div>
		<div class="ibwp-center"><?php echo ibwpl_upgrade_pro_link(); ?></div>
	</div>
</div>