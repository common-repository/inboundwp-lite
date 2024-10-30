<?php
/**
 * Email Notification Settings
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="postbox ibwp-no-toggle ibwp-pro-feature">
	<h3 class="hndle">
		<span><?php echo esc_html__( 'Admin Email Notification Settings ', 'inboundwp-lite' ) . ibwpl_upgrade_pro_link(); ?></span>
	</h3>

	<div class="inside">
		<table class="form-table ibwp-tbl">
			<tbody>
				<tr>
					<th>
						<label for="ibwp-tm-email-enable"><?php _e('Enable', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-tm-email-enable" id="ibwp-tm-email-enable" disabled /><br/>
						<span class="description"><?php _e('Check this box to enable email notification.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-tm-emails"><?php _e('To Email', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="" value="" class="ibwp-text large-text ibwp-tm-emails" id="ibwp-tm-emails" disabled /><br/>
						<span class="description"><?php _e('Enter email address.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-tm-email-subject"><?php _e('Subject', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="" value="" class="ibwp-text large-text ibwp-tm-email-subject" id="ibwp-tm-email-subject" disabled /><br/>
						<span class="description"><?php _e('Enter notification email subject.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-tm-email-msg"><?php _e('Message', 'inboundwp-lite'); ?></label>
					</th>
					<td class="ibwp-disabled-field">
						<?php wp_editor( '', 'ibwp-tm-email-msg', array('textarea_name' => '', 'textarea_rows' => 8, 'media_buttons' => true, 'class' => 'ibwp-tm-email-msg') ); ?>
						<span class="description"><?php _e('Enter notification email message. Available template tags are', 'inboundwp-lite'); ?></span><br/>
						<div class="ibwp-code-tag-wrap">
							<code class="ibwp-copy-clipboard">{title}</code> - <span class="description"><?php _e('Display testimonial title.', 'inboundwp-lite'); ?></span><br/>
							<code class="ibwp-copy-clipboard">{content}</code> - <span class="description"><?php _e('Display testimonial content.', 'inboundwp-lite'); ?></span><br/>
							<code class="ibwp-copy-clipboard">{rating}</code> - <span class="description"><?php _e('Display rating.', 'inboundwp-lite'); ?></span><br/>
							<code class="ibwp-copy-clipboard">{name}</code> - <span class="description"><?php _e('Display username.', 'inboundwp-lite'); ?></span><br/>
							<code class="ibwp-copy-clipboard">{job_title}</code> - <span class="description"><?php _e('Display user job title.', 'inboundwp-lite'); ?></span><br/>
							<code class="ibwp-copy-clipboard">{company_name}</code> - <span class="description"><?php _e('Display user company name.', 'inboundwp-lite'); ?></span><br/>
							<code class="ibwp-copy-clipboard">{company_website}</code> - <span class="description"><?php _e('Display user company website.', 'inboundwp-lite'); ?></span><br/>
							<code class="ibwp-copy-clipboard">{category}</code> - <span class="description"><?php _e('Display testimonial category.', 'inboundwp-lite'); ?></span><br/>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_tm_sett_submit" class="button button-primary right ibwp-btn ibwp-tm-general-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" disabled />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->