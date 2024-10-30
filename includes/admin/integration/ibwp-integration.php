<?php
/**
 * InboundWP Integrations
 *
 * Handles the third party integration
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="wrap ibwp-sett-wrap ibwp-pro-feature">

	<h2><?php echo __( 'InboundWP Lite Integrations ', 'inboundwp-lite' ) . ibwpl_upgrade_pro_link(); ?></h2><br />

	<form action="options.php" method="POST" id="ibwp-intgs-settings-form" class="ibwp-intgs-settings-form">

		<?php settings_fields( 'ibwp_module_options' ); ?>

		<div class="metabox-holder">
			<div class="meta-box-sortables">

				<!-- MailChimp Integration Settings Starts -->
				<div id="ibwp-intgs-mailchimp-sett" class="postbox ibwp-postbox ibwp-intgs-mailchimp-sett">

					<button class="handlediv button-link" type="button"><span class="toggle-indicator"></span></button>

					<h3 class="hndle">
						<span><?php _e( 'MailChimp Integration', 'inboundwp-lite' ); ?></span>
					</h3>

					<div class="inside">
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row"> 
										<label for="ibwp-intgs-mc-api-key"><?php _e('API Key', 'inboundwp-lite'); ?></label>
									</th>
									<td>
										<input type="text" name="" class="large-text" id="ibwp-intgs-mc-api-key" value="" disabled /><br/>
										<span class="description"><?php echo sprintf( __('The API key for connecting with your Mailchimp account. <a href="%s" target="_blank">Get your API key here</a>.', 'inboundwp-lite'), 'https://admin.mailchimp.com/account/api' ); ?></span>
									</td>
								</tr>

								<tr>
									<th colspan="3">
										<label for="ibwp-mc-ac-info"><?php _e('Account Information','inboundwp-lite'); ?></label>
										<hr>
									</th>
								</tr>
								<tr>
									<th>
										<label><?php _e('Account Name', 'inboundwp-lite'); ?></label>
									</th>
									<td>
										<span><?php _e('WP OnlineSupport', 'inboundwp-lite'); ?></span>
									</td>
								</tr>
								<tr>
									<th>
										<label><?php _e('Account Email', 'inboundwp-lite'); ?></label>
									</th>
									<td>
										<span><?php _e('support@wponlinesupport.com', 'inboundwp-lite'); ?></span>
									</td>
								</tr>

								<tr>
									<td colspan="2">
										<input type="submit" name="ibwp_intgs_mc_sett_submit" class="button button-primary right ibwp-btn ibwp-intgs-sett-submit ibwp-intgs-mc-sett-submit ibwp-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" disabled />
									</td>
								</tr>
							</tbody>
						 </table>
					</div><!-- .inside -->
				</div><!-- MailChimp Integration End -->

			</div><!-- end .meta-box-sortables -->
		</div><!-- end .metabox-holder -->
	</form>

</div><!-- wrap -->