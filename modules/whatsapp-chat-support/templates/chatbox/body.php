<?php
/**
 * Template for Chatbox Body
 *
 * This template can be overridden by copying it to yourtheme/inboundwp-lite/whatsapp-chat-support/chatbox/body.php
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="ibwp-wtcs-item-wrp <?php echo $agent_wrap_cls; ?>">
	<div class="ibwp-wtcs-item-inr ibwp-wtcs-open-chat" data-href="<?php echo $whatsapp_url; ?>" data-label="<?php echo ibwpl_esc_attr( $agent_label ); ?>">
		<div class="ibwp-wtcs-agent-avatar">
			<div class="ibwp-wtcs-agent-img" style="background-image:url(<?php echo esc_url( $featured_img ); ?>);"></div>
		</div>

		<div class="ibwp-wtcs-item-cnt">
			<?php if( ! empty( $agent_name ) ) { ?>
			<div class="ibwp-wtcs-agent-name"><?php echo $agent_name; ?></div>
			<?php }

			if( ! empty( $designation ) ) { ?>
			<div class="ibwp-wtcs-agent-desg"><?php echo $designation; ?></div>
			<?php }

			if( $status_msg ) { ?>
			<div class="ibwp-wtcs-agent-status">
				<span class="ibwp-wtcs-status-text"><?php echo $status_msg; ?></span>
			</div>
			<?php } ?>
		</div>
	</div>
</div>