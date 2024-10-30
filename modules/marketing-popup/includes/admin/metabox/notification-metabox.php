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
$notification = get_post_meta( $post->ID, $prefix.'notification', true );

// Taking some variables
$enable_email	= ! empty( $notification['enable_email'] )	? 1 : 0;
$email_subject	= isset( $notification['email_subject'] )	? $notification['email_subject']	: '';
$email_msg		= isset( $notification['email_msg'] )		? $notification['email_msg'] 		: '';
?>

<div id="ibwp_mp_notification_sett" class="ibwp-vtab-cnt ibwp-mp-notification-sett ibwp-clearfix">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Notification Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose popup notification settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-mp-enable-email"><?php _e('Enable', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>notification[enable_email]" value="1" <?php checked( $enable_email, 1 ); ?> class="ibwp-checkbox ibwp-mp-enable-email" id="ibwp-mp-enable-email" /><br />
					<span class="description"><?php _e('Check this box to enable email notification.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-email-subject"><?php _e('Subject', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>notification[email_subject]" value="<?php echo ibwpl_esc_attr( $email_subject ); ?>" class="ibwp-text large-text ibwp-mp-email-subject" id="ibwp-mp-email-subject" />
					<span class="description"><?php _e('Enter notification email subject. Available template tags are', 'inboundwp-lite'); ?></span><br/>
					<div class="ibwp-code-tag-wrap">
						<code class="ibwp-copy-clipboard">{name}</code> - <span class="description"><?php _e('Display user full name.', 'inboundwp-lite'); ?></span>
					</div>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-email-msg"><?php _e('Message', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<?php wp_editor( $email_msg, 'ibwp-mp-email-msg', array('textarea_name' => $prefix.'notification[email_msg]', 'textarea_rows' => 8, 'media_buttons' => true, 'class' => 'ibwp-mp-email-msg') ); ?>
					<span class="description"><?php _e('Enter notification email message. Available template tags are', 'inboundwp-lite'); ?></span><br/>
					<div class="ibwp-code-tag-wrap">
						<code class="ibwp-copy-clipboard">{name}</code> - <span class="description"><?php _e('Display user full name.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{email}</code> - <span class="description"><?php _e('Display user email address.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{phone}</code> - <span class="description"><?php _e('Display user phone number.', 'inboundwp-lite'); ?></span><br/>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-mp-notification-sett -->