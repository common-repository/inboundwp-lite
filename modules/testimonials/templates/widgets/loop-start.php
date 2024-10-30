<?php
/**
 * Template for WP Testimonials with rotator widget Pro -Loop Start
 *
 * This template can be overridden by copying it to yourtheme/inboundwp-lite/testimonials/widgets/loop-start.php
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="ibwp-tm-slider-wrp" data-conf="<?php echo htmlspecialchars(json_encode( $slider_conf )); ?>">
	<div class="ibwp-tm-slide-widget <?php echo $main_wrap; ?>" id="ibwp-tm-testimonials-<?php echo $unique; ?>">