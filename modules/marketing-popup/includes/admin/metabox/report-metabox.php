<?php
/**
 * Popup Report Metabox. Popup Click, Impression and Report Link
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="ibwp-mp-popup-report-sett ibwp-cnt-wrap">
	<div class="ibwp-preview-btn-wrp">
		<button type="button" class="button button-large button-primary ibwp-btn ibwp-btn-large ibwp-module-preview-btn ibwp-mp-preview-btn ibwp-show-popup-modal" data-preview="1"><?php esc_html_e('Preview Popup', 'inboundwp-lite'); ?></button>
	</div>

	<div class="ibwp-pro-feature ibwp-upgrade-overlay">
		<div class="ibwp-clearfix ibwp-center">
			<div class="ibwp-column ibwp-medium-6">
				<div class="ibwp-mp-report-title"><strong><?php _e('Impressions', 'inboundwp-lite'); ?></strong></div>
				<span class="ibwp-mp-report-no">0</span>
			</div>
			<div class="ibwp-column ibwp-medium-6">
				<div class="ibwp-mp-report-title"><strong><?php _e('Clicks', 'inboundwp-lite'); ?></strong></div>
				<span class="ibwp-mp-report-no">0</span>
			</div>
		</div>

		<p class="ibwp-mp-popup-report-link ibwp-center">
			<a href="#" target="_blank"><?php esc_html_e('View Report', 'inboundwp-lite'); ?></a> | 
			<a href="#" target="_blank"><?php esc_html_e('View Entries', 'inboundwp-lite'); ?></a>
		</p>
		<hr/>

		<div class="ibwp-mp-flush-report-wrp">
			<button type="button" class="button button-secondary ibwp-btn ibwp-mp-flush-stats-btn" disabled><?php esc_html_e('Flush Stats', 'inboundwp-lite'); ?></button>
			<hr/>
			<span class="description"><?php esc_html_e('Note : Flush Stats button will only flush the `Impressions` and `Clicks` meta for this post. The popup report will not be affected by this.', 'inboundwp-lite'); ?></span>
		</div>
		<div class="ibwp-center"><?php echo ibwpl_upgrade_pro_link(); ?></div>
	</div>
</div>