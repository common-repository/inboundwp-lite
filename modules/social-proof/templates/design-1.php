<?php
/**
* Template for Social Proof Design 1
*
* This template can be overridden by copying it to yourtheme/inboundwp-lite/social-proof/design-1.php
*
* @package InboundWP Lite
* @subpackage Social Proof
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="ibwp-sp-notification-<?php echo $nf_id; ?>" class="ibwp-wrap ibwp-sp-notification-wrap ibwp-sp-notification-<?php echo $nf_id; ?> ibwp-sp-design-1 ibwp-sp-nf-bottom-left ibwp-sp-nf-slide">
	<div class="ibwp-sp-nf-inr">
		<?php if( $nf_image && $image ) { ?>
			<div class="ibwp-sp-nf-left-wrap">
				<div class="ibwp-sp-nf-left">
					<img class="ibwp-sp-nf-img" src="<?php echo esc_url( $image ); ?>" alt="" />
				</div>
			</div>
		<?php } ?>

		<div class="ibwp-sp-nf-right">
			<div class="ibwp-sp-nf-content">
				<?php echo nl2br( $nf_template );

				if( $show_credit ) { ?>
				| <a class="ibwp-sp-nf-credit-link" href="<?php echo esc_url( IBWPL_PRO_LINK ); ?>" target="_blank"><img src="<?php echo IBWPL_URL; ?>assets/images/wpos-logo-16.png" alt="WP OnlineSupport" /> <span class="ibwp-sp-nf-credit">WP OnlineSupport</span></a>
				<?php } ?>
			</div>
		</div>

		<?php if( $link_type && $url ) { ?>
		<a class="ibwp-sp-nf-link" href="<?php echo esc_url( $url ); ?>" target="<?php echo $link_target; ?>"></a>
		<?php } ?>

		<?php if( $cls_btn ) { ?>
		<span class="ibwp-sp-nf-close-btn" title="<?php esc_html_e('Close', 'inboundwp-lite'); ?>">x</span>
		<?php } ?>
	</div>
</div>