<?php
/**
 * WooCommerce Settings
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="postbox ibwp-pro-feature">

	<button class="handlediv button-link" type="button"><span class="toggle-indicator"></span></button>

	<h3 class="hndle">
		<span><?php echo __( 'WooCommerce Setting ', 'inboundwp-lite' ) . ibwpl_upgrade_pro_link(); ?></span>
	</h3>

	<div class="inside">
		<table class="form-table ibwp-tbl">
			<tbody>
				<tr>
					<th>
						<label for="ibwp-wtcs-woo-enable"><?php _e( 'Enable', 'inboundwp-lite' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="" id="ibwp-wtcs-woo-enable" class="ibwp-checkbox ibwp-wtcs-woo-enable" value="" disabled /><br/>
						<span class="description"><?php _e('Check this box to enable WhatsApp Chat tab for WooCommerce on product page.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-woo-tab-txt"><?php _e( 'Tab Text', 'inboundwp-lite' ); ?></label>
					</th>
					<td>
						<input type="text" name="" id="ibwp-wtcs-woo-tab-txt" class="regular-text ibwp-wtcs-woo-tab-txt" value="" disabled /><br/>
						<span class="description"><?php _e('Enter WooCommerce WhatsApp Chat tab name. Default is WhatsApp Chat.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_wtcs_sett_submit" class="button button-primary right ibwp-btn ibwp-wtcs-woo-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" disabled />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->