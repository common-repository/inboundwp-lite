<?php
/**
 * Template for Circle, Circle-Fill, Square, Square-Fill Design
 *
 * @package InboundWP Lite
 * @subpackage Deal Countdown Timer
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="dcdt-countdown-wrp dcdt-clearfix">
	<div id="dcdt-datecount-<?php echo $unique; ?>" data-product="<?php echo $post_id; ?>"  class="dcdt-countdown-timer-<?php echo $timer_style; ?> dcdt-count-timer-<?php echo $timer_id; ?> <?php echo $classes; ?>" data-id="<?php echo $timer_id; ?>" data-timer="<?php echo $totalseconds; ?>">
		<div class="dcdt-clock">
			<?php if($is_days == 1) { ?>
			<div class="ce-col">
				<div class="ce-days dcdt-timer-digits">
					<div class="ce-flip-wrap">
						<div class="ce-flip-front"></div>
						<div class="ce-flip-back"></div>
					</div>
				</div>
				<span class="ce-days-label dcdt-timer-label"></span>
			</div>
			<?php } ?>

			<?php if($is_hours == 1){ ?>
			<div class="ce-col">
				<div class="ce-hours dcdt-timer-digits">
					<div class="ce-flip-wrap">
						<div class="ce-flip-front"></div>
						<div class="ce-flip-back"></div>
					</div>
				</div>
				<span class="ce-hours-label dcdt-timer-label"></span>
			</div>
			<?php } ?>

			<?php if($is_minutes == 1){ ?>
			<div class="ce-col">
				<div class="ce-minutes dcdt-timer-digits">
					<div class="ce-flip-wrap">
						<div class="ce-flip-front"></div>
						<div class="ce-flip-back"></div>
					</div>
				</div>
				<span class="ce-minutes-label dcdt-timer-label"></span>
			</div>
			<?php } ?>

			<?php if($is_seconds == 1){ ?>
			<div class="ce-col">
				<div class="ce-seconds dcdt-timer-digits">
					<div class="ce-flip-wrap">
						<div class="ce-flip-front"></div>
						<div class="ce-flip-back"></div>
					</div>
				</div>
				<span class="ce-seconds-label dcdt-timer-label"></span>
			</div>
			<?php } ?>
		</div>
		<div class="dcdt-date-conf" data-conf="<?php echo htmlspecialchars(json_encode($date_conf)); ?>"></div>
	</div>
</div>