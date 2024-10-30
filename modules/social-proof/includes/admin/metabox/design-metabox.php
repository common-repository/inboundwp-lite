<?php
/**
 * Handles Design Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$design_data	= ibwpl_sp_nf_designs();
$position_data	= ibwpl_sp_nf_positions();
$animation_data	= ibwpl_sp_nf_animation_type();
?>

<div id="ibwp_sp_design_sett" class="ibwp-vtab-cnt ibwp-sp-design-sett ibwp-clearfix ibwp-pro-feature">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Design Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php echo __('Choose Social Proof design settings. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-sp-design"><?php _e('Designs', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-sp-design" id="ibwp-sp-design" disabled>
						<?php foreach ( $design_data as $design_key => $design_val ) { ?>
							<option value=""><?php echo $design_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select social proof design. 5 types of notification design.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-position"><?php _e('Position', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-sp-nf-position" id="ibwp-sp-nf-position" disabled>
						<?php foreach ( $position_data as $position_key => $position_val ) { ?>
							<option value=""><?php echo $position_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select notification position. 4 types of notification position.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-anim-in"><?php _e('Animation', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-sp-nf-anim-in" id="ibwp-sp-nf-anim-in" disabled>
						<?php foreach ( $animation_data as $animation_in_key => $animation_in_val ) { ?>
							<option value=""><?php echo $animation_in_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select notification animation. 3 types of notification animation.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Background & Color Settings', 'inboundwp-lite'); ?></div>
				</th>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-bgclr"><?php _e('Background Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-sp-nf-bgclr" id="ibwp-sp-nf-bgclr" /><br />
					<span class="description"><?php _e('Choose Notification background color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-txtclr"><?php _e('Text Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-sp-nf-txtclr" id="ibwp-sp-nf-txtclr" /><br />
					<span class="description"><?php _e('Choose Notification text color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-titleclr"><?php _e('Title Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-sp-nf-titleclr" id="ibwp-sp-nf-titleclr" /><br />
					<span class="description"><?php _e('Choose Notification title color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-ratingclr"><?php _e('Rating Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-sp-nf-ratingclr" id="ibwp-sp-nf-ratingclr" /><br />
					<span class="description"><?php _e('Choose Notification rating color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-rating-fclr"><?php _e('Rating Fill Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-sp-nf-rating-fclr" id="ibwp-sp-nf-rating-fclr" /><br />
					<span class="description"><?php _e('Choose Notification rating fill color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-clsclr"><?php _e('Close Button Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-sp-nf-clsclr" id="ibwp-sp-nf-clsclr" /><br />
					<span class="description"><?php _e('Choose Notification close button color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-sp-design-sett -->