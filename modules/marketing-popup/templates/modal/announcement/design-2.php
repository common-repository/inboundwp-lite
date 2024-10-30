<?php
/**
* Template for Modal Popup Announcement Design 2
*
* This template can be overridden by copying it to yourtheme/inboundwp-lite/marketing-popup/modal/announcement/design-2.php
*
* @package InboundWP Lite
* @subpackage Marketing Popup
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="ibwp-mfp-popup-body ibwp-mp-popup ibwp-mp-modal-popup ibwp-mp-popup-<?php echo $popup_id; ?> ibwp-mp-popup-js ibwp-mp-popup-page-load ibwp-mp-popup-<?php echo $popup_goal; ?> ibwp-mp-<?php echo $template; ?> ibwp-mp-ann-<?php echo $template; ?> ibwp-right mfp-hide" id="ibwp-mp-popup-<?php echo $popup_id; ?>" data-conf="<?php echo $popup_conf; ?>">
	<div class="ibwp-mp-popup-inr-wrap">
		<div class="ibwp-display-flex">
			<?php if ( $style['bg_img'] ) { ?>
				<div class="ibwp-bg-img-section" style="<?php echo $style['bg_img'].' '.$style['clr']; ?>"></div>
			<?php } ?>
			
			<div class="<?php echo ( $style['bg_img'] ) ? '' : 'ibwp-center ibwp-no-image'; ?> ibwp-mp-popup-con-bg" style="<?php echo $style['bg_clr']; ?>">
				<div class="ibwp-mp-popup-inr">

					<?php if( $main_heading ) { ?>
						<div class="ibwp-mp-popup-mheading"><?php echo $main_heading; ?></div>
					<?php }

					if( $sub_heading ) { ?>
						<div class="ibwp-mp-popup-sheading"><?php echo $sub_heading; ?></div>
					<?php }

					if( $popup_content ) { ?>
						<div class="ibwp-mp-popup-content"><?php echo $popup_content; ?></div>
					<?php } ?>

					<?php ibwpl_popup_social_links( $args ); ?>

					<?php if( $security_note ) { ?>
						<div class="ibwp-mp-popup-snote"><i class="fa fa-lock"></i> <span><?php echo $security_note; ?></span></div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<?php if( $show_credit ) { ?>
		<div class="ibwp-mp-credit-wrp">
			<span class="ibwp-mp-credit-inr" <?php echo $credit_link; ?> title="<?php esc_html_e('Powered by', 'inboundwp-lite'); ?> WP OnlineSupport">
				<img src="<?php echo IBWPL_URL; ?>assets/images/wpos-logo-16.png" alt="WP OnlineSupport" />
				<span>WP OnlineSupport</span>
			</span>
		</div>
	<?php } ?>
</div>