<?php
/**
* Template for Spin Wheel Design 1
*
* This template can be overridden by copying it to yourtheme/inboundwp-lite/spin-wheel/design-1.php
*
* @package InboundWP Lite
* @subpackage Spin Wheel
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="ibwp-mfp-popup-body ibwp-spw-wheel-wrap ibwp-spw-popup-<?php echo $wheel_id; ?> ibwp-spw-popup-page-load ibwp-spw-popup-left mfp-hide" id="ibwp-spw-popup-<?php echo $wheel_id; ?>" data-conf="<?php echo $wheel_conf; ?>" style="<?php echo $style['bg_img']; ?>">
	<div class="ibwp-spw-wheel-inr-wrap" style="<?php echo $style['bg_clr'] ?>">
		<div class="ibwp-mfp-popup-body-inr ibwp-spw-wheel-inr">
			<div class="ibwp-spw-wheel-left">
				<div class="ibwp-spw-wheel-left-inr">
					<canvas id="ibwp-spw-wheel-first-<?php echo $wheel_id; ?>" class="ibwp-spw-wheel-first"></canvas>
					<canvas id="ibwp-spw-wheel-second-<?php echo $wheel_id; ?>" class="ibwp-spw-wheel-second"></canvas>
					<div class="ibwp-spw-wheel-pointer-wrp">
						<div class="ibwp-spw-wheel-pointer-inr">
							<span class="ibwp-spw-pointer ibwp-spw-wheel-pointer ibwp-spw-wheel-pointer-<?php echo $wheel_id; ?>"></span>
						</div>
					</div>
				</div>
			</div>

			<div class="ibwp-spw-wheel-right">
				<div class="ibwp-spw-wheel-right-inr">
					<div class="ibwp-spw-wheel-form-process ibwp-spw-wheel-form-process-jq">
						<?php if( $title ) { ?>
							<div class="ibwp-spw-wheel-title"><?php echo $title; ?></div>
						<?php }

						if( $sub_title ) { ?>
							<div class="ibwp-spw-wheel-subtitle"><?php echo $sub_title; ?></div>
						<?php }

						if( $wheel_content ) { ?>
							<div class="ibwp-spw-wheel-content"><?php echo $wheel_content; ?></div>
						<?php }

						// Form Fields
						ibwpl_wheel_form_fields( $args ); ?>
					</div>

					<?php if( $cust_close_txt ) { ?>
						<div class="ibwp-spw-wheel-close-wrp"><span class="ibwp-spw-wheel-close ibwp-spw-custom-close"><?php echo $cust_close_txt; ?></span></div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ibwp-spw-wheel-icon-wrp ibwp-spw-icon-<?php echo $wheel_icon_pos; ?>" id="ibwp-spw-wheel-icon-wrp-<?php echo $wheel_id; ?>">
	<canvas id="ibwp-spw-wheel-icon-<?php echo $wheel_id; ?>" class="ibwp-spw-wheel-icon" data-id="<?php echo $wheel_id; ?>" width="64" height="64"></canvas>
	<?php if( $icon_tooltip_txt ) { ?>
		<span class="ibwp-spw-tooltip"><?php echo $icon_tooltip_txt; ?></span>
	<?php } ?>
</div>