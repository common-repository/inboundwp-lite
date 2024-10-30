<?php
/**
 * Handles Design Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$wheel_icon_pos_data	= ibwpl_spw_icon_position();
$img_repeat_data		= ibwpl_img_repeat_options();
$img_position_data		= ibwpl_img_position_options();
$wheel_design_data		= ibwpl_spw_wheel_designs();

$design				= get_post_meta( $post->ID, $prefix.'design', true );
$wheel_icon_pos		= isset( $design['wheel_icon_pos'] )		? $design['wheel_icon_pos']		: 'bottom-right';
$wheel_bg_img		= isset( $design['wheel_bg_img'] )			? $design['wheel_bg_img']		: '';
$wheel_img_size		= isset( $design['wheel_img_size'] )		? $design['wheel_img_size']		: '';
$wheel_img_repeat	= isset( $design['wheel_img_repeat'] )		? $design['wheel_img_repeat']	: '';
$wheel_img_pos		= isset( $design['wheel_img_pos'] )			? $design['wheel_img_pos']		: '';
$wheel_bg_clr		= isset( $design['wheel_bg_clr'] )			? $design['wheel_bg_clr']		: '';

$content_color			= isset( $design['content_color'] )			? $design['content_color']			: '';
$tooltip_bg_clr			= isset( $design['tooltip_bg_clr'] )		? $design['tooltip_bg_clr']			: '';
$tooltip_txt_clr		= isset( $design['tooltip_txt_clr'] )		? $design['tooltip_txt_clr']		: '';
$custom_close_txtclr	= isset( $design['custom_close_txtclr'] )	? $design['custom_close_txtclr']	: '';

$wheel_border_clr		= isset( $design['wheel_border_clr'] )		? $design['wheel_border_clr']		: '';
$wheel_dots_clr			= isset( $design['wheel_dots_clr'] )		? $design['wheel_dots_clr']			: '';
$wheel_pointer_bg_clr	= isset( $design['wheel_pointer_bg_clr'] )	? $design['wheel_pointer_bg_clr']	: '';
$wheel_pointer_clr		= isset( $design['wheel_pointer_clr'] )		? $design['wheel_pointer_clr']		: '';
?>

<div id="ibwp_spw_design_sett" class="ibwp-vtab-cnt ibwp-spw-design-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Design Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Wheel design settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-spw-icon-pos"><?php _e('Wheel Icon Position', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[wheel_icon_pos]" class="ibwp-select ibwp-spw-icon-pos" id="ibwp-spw-icon-pos">
						<?php foreach ( $wheel_icon_pos_data as $wheel_icon_pos_key => $wheel_icon_pos_val ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $wheel_icon_pos_key ); ?>" <?php selected( $wheel_icon_pos, $wheel_icon_pos_key ); ?>><?php echo $wheel_icon_pos_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select spin wheel icon position.', 'inboundwp-lite'); ?></span><br/>
					<span class="description ibwp-pro-feature"><?php echo __('If you want to more wheel icon position. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-wheel-design"><?php _e('Designs', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-spw-wheel-design" id="ibwp-spw-wheel-design" disabled>
						<?php foreach ( $wheel_design_data as $wheel_design_key => $wheel_design_val ) { ?>
							<option value=""><?php echo $wheel_design_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php echo __('Select spin wheel design. 5 types of spin wheel design. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-pop-pos"><?php _e('Popup Position', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-spw-pop-pos" id="ibwp-spw-pop-pos" disabled>
						<option value=""><?php esc_html_e('Left', 'inboundwp-lite'); ?></option>
						<option value=""><?php esc_html_e('Right', 'inboundwp-lite'); ?></option>
					</select><br/>
					<span class="description"><?php echo __('Select spin wheel popup position. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-fullscreen"><?php _e('Full Screen Wheel', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-spw-fullscreen" id="ibwp-spw-fullscreen" disabled /><br />
					<span class="description"><?php echo __('Check this box if you want to display full screen spin wheel. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>

			<!-- Start - Image & Color Settings -->
			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Image & Color Settings', 'inboundwp-lite'); ?></div>
				</th>
			</tr>

			<tr>
				<th>
					<label for="ibwp-spw-wheel-bg-img"><?php _e('Wheel Background Image', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo $prefix; ?>design[wheel_bg_img]" value="<?php echo ibwpl_esc_attr( $wheel_bg_img ); ?>" class="regular-text ibwp-url ibwp-spw-wheel-bg-img ibwp-img-upload-input" id="ibwp-spw-wheel-bg-img" />
					<input type="button" name="ibwp_spw_wheel_bg_img" class="button-secondary ibwp-image-upload" value="<?php esc_html_e( 'Upload Image', 'inboundwp-lite'); ?>" />
					<input type="button" name="ibwp_spw_wheel_bg_img_clear" id="ibwp-spw-url-clear" class="button button-secondary ibwp-image-clear" value="<?php esc_html_e( 'Clear', 'inboundwp-lite'); ?>" /> <br />
					<span class="description"><?php _e('Set spin wheel background image.', 'inboundwp-lite'); ?></span><br />
					<?php
						$image_preview = '';
						if( $wheel_bg_img != '' ) {
							$image_preview = '<img src="'.esc_url( $wheel_bg_img ).'" alt="" />';
						}
					?>
					<div class="ibwp-img-view"><?php echo $image_preview; ?></div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-wheel-img-size"><?php _e('Wheel Background Image Size', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo $prefix; ?>design[wheel_img_size]" class="ibwp-select ibwp-spw-wheel-img-size" id="ibwp-spw-wheel-img-size">
						<option value="cover" <?php selected( $wheel_img_size, 'cover' ); ?>><?php esc_html_e('Cover', 'inboundwp-lite'); ?></option>
						<option value="auto" <?php selected( $wheel_img_size, 'auto' ); ?>><?php esc_html_e('Auto', 'inboundwp-lite'); ?></option>
						<option value="contain" <?php selected( $wheel_img_size, 'contain' ); ?>><?php esc_html_e('Contain', 'inboundwp-lite'); ?></option>
					</select><br/>
					<span class="description"><?php _e('Select spin wheel background image size.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-wheel-img-repeat"><?php _e('Wheel Background Image Repeat', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo $prefix; ?>design[wheel_img_repeat]" class="ibwp-select ibwp-spw-wheel-img-repeat" id="ibwp-spw-wheel-img-repeat">
						<?php foreach ( $img_repeat_data as $img_repeat_key => $img_repeat_val ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $img_repeat_key ); ?>" <?php selected( $wheel_img_repeat, $img_repeat_key ); ?>><?php echo $img_repeat_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select spin wheel background image repeat.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-wheel-img-position"><?php _e('Wheel Background Image Position', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo $prefix; ?>design[wheel_img_pos]" class="ibwp-select ibwp-spw-wheel-img-position" id="ibwp-spw-wheel-img-position">
						<?php foreach ( $img_position_data as $img_position_key => $img_position_val ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $img_position_key ); ?>" <?php selected( $wheel_img_pos, $img_position_key ); ?>><?php echo $img_position_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select spin wheel background image position.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-bg-color"><?php _e('Wheel Background Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo $prefix; ?>design[wheel_bg_clr]" value="<?php echo ibwpl_esc_attr( $wheel_bg_clr ); ?>" class="ibwp-colorpicker ibwp-spw-bg-color" id="ibwp-spw-bg-color" data-alpha="true" /><br />
					<span class="description"><?php _e('Choose spin wheel background color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<!-- Start - Other Settings -->
			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Other Settings', 'inboundwp-lite'); ?></div>
				</th>
			</tr>

			<tr>
				<th>
					<label for="ibwp-spw-content-color"><?php _e('Content Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[content_color]" value="<?php echo ibwpl_esc_attr( $content_color ); ?>" class="ibwp-colorpicker ibwp-spw-content-color" id="ibwp-spw-content-color" /><br />
					<span class="description"><?php _e('Choose spin wheel content text color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-tooltip-bg-clr"><?php _e('Icon Tooltip BG Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[tooltip_bg_clr]" value="<?php echo ibwpl_esc_attr( $tooltip_bg_clr ); ?>" class="ibwp-colorpicker ibwp-spw-tooltip-bg-clr" id="ibwp-spw-tooltip-bg-clr" /><br />
					<span class="description"><?php _e('Choose spin wheel icon tooltip background color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-tooltip-txt-clr"><?php _e('Icon Tooltip Text Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[tooltip_txt_clr]" value="<?php echo ibwpl_esc_attr( $tooltip_txt_clr ); ?>" class="ibwp-colorpicker ibwp-spw-tooltip-txt-clr" id="ibwp-spw-tooltip-txt-clr" /><br />
					<span class="description"><?php _e('Choose spin wheel icon tooltip text color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-cus-close-txtclr"><?php _e('Custom Close Text Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[custom_close_txtclr]" value="<?php echo ibwpl_esc_attr( $custom_close_txtclr ); ?>" class="ibwp-colorpicker ibwp-spw-cus-close-txtclr" id="ibwp-spw-cus-close-txtclr" /><br />
					<span class="description"><?php _e('Choose spin wheel custom close text color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<!-- Start - Wheel Settings -->
			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Wheel Settings', 'inboundwp-lite'); ?></div>
				</th>
			</tr>

			<tr>
				<th>
					<label for="ibwp-spw-border-clr"><?php _e('Border Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[wheel_border_clr]" value="<?php echo ibwpl_esc_attr( $wheel_border_clr ); ?>" class="ibwp-text ibwp-colorpicker ibwp-spw-border-clr" id="ibwp-spw-border-clr" /><br/>
					<span class="description"><?php _e('Choose spin wheel border color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-dots-clr"><?php _e('Dots Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[wheel_dots_clr]" value="<?php echo ibwpl_esc_attr( $wheel_dots_clr ); ?>" class="ibwp-text ibwp-colorpicker ibwp-spw-dots-clr" id="ibwp-spw-dots-clr" /><br/>
					<span class="description"><?php _e('Choose spin wheel dots color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-pointer-bgclr"><?php _e('Pointer BG Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[wheel_pointer_bg_clr]" value="<?php echo ibwpl_esc_attr( $wheel_pointer_bg_clr ); ?>" class="ibwp-text ibwp-colorpicker ibwp-spw-pointer-bgclr" id="ibwp-spw-pointer-bgclr" data-alpha="true" /><br/>
					<span class="description"><?php _e('Choose spin wheel pointer background color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-pointer-clr"><?php _e('Pointer Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[wheel_pointer_clr]" value="<?php echo ibwpl_esc_attr( $wheel_pointer_clr ); ?>" class="ibwp-text ibwp-colorpicker ibwp-spw-pointer-clr" id="ibwp-spw-pointer-clr" /><br/>
					<span class="description"><?php _e('Choose spin wheel pointer color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<!-- Start - Title & Sub Title Settings -->
			<tr class="ibwp-pro-feature">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="2">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Title & Sub Title Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>

						<tr>
							<th>
								<label for="ibwp-spw-title-fontsize"><?php _e('Title Font Size', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-number ibwp-spw-title-fontsize" id="ibwp-spw-title-fontsize" disabled /> <?php esc_html_e('PX', 'inboundwp-lite'); ?><br />
								<span class="description"><?php _e('Enter spin wheel title font size.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-title-txtclr"><?php _e('Title Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-title-txtclr" id="ibwp-spw-title-txtclr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel title text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-sub-title-fontsize"><?php _e('Sub Title Font Size', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-number ibwp-spw-sub-title-fontsize" id="ibwp-spw-sub-title-fontsize" disabled /> <?php esc_html_e('PX', 'inboundwp-lite'); ?><br />
								<span class="description"><?php _e('Enter spin wheel sub heading font size.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-sub-title-txtcolor"><?php _e('Sub Title Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-sub-title-txtcolor" id="ibwp-spw-sub-title-txtcolor" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel sub heading text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<!-- Start - Form Field Settings -->
			<tr class="ibwp-pro-feature">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="2">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Form Field Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-field-lbl-clr"><?php _e('Field Label Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-field-lbl-clr" id="ibwp-spw-field-lbl-clr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel form field label color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-field-bg-clr"><?php _e('Field BG Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-field-bg-clr" id="ibwp-spw-field-bg-clr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel form field background color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-field-txt-clr"><?php _e('Field Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-field-txt-clr" id="ibwp-spw-field-txt-clr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel form field text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-field-btn-bg-clr"><?php _e('Button BG Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-field-btn-bg-clr" id="ibwp-spw-field-btn-bg-clr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel button background color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-field-btn-txt-clr"><?php _e('Button Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-field-btn-txt-clr" id="ibwp-spw-field-btn-txt-clr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel button text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-field-btn-hbg-clr"><?php _e('Button BG Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-field-btn-hbg-clr" id="ibwp-spw-field-btn-hbg-clr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel button background hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-spw-field-btn-htxt-clr"><?php _e('Button Text Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-spw-field-btn-htxt-clr" id="ibwp-spw-field-btn-htxt-clr" disabled /><br />
								<span class="description"><?php _e('Choose spin wheel button text hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- End - Form Field Settings -->
		</tbody>
	</table>
</div><!-- end .ibwp-spw-design-sett -->