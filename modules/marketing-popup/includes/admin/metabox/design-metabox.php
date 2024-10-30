<?php
/**
 * Handles Design Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some function data
$design_data		= ibwpl_mp_popup_designs();
$img_repeat_data	= ibwpl_img_repeat_options();
$img_position_data	= ibwpl_img_position_options();
$mn_position_data	= ibwpl_mp_mn_position_options();

// Take some variables
$design				= get_post_meta( $post->ID, $prefix.'design', true );
$template			= isset( $design['template'] )			? $design['template']			: '';
$overlay_img		= isset( $design['overlay_img'] )		? $design['overlay_img']		: '';
$overlay_color		= isset( $design['overlay_color'] )		? $design['overlay_color']		: '';
$overlay_opacity	= isset( $design['overlay_opacity'] )	? $design['overlay_opacity']	: '';
$popup_img			= isset( $design['popup_img'] )			? $design['popup_img']			: '';
$popup_img_size		= isset( $design['popup_img_size'] )	? $design['popup_img_size']		: '';
$popup_img_repeat	= isset( $design['popup_img_repeat'] )	? $design['popup_img_repeat']	: '';
$popup_img_pos		= isset( $design['popup_img_pos'] )		? $design['popup_img_pos']		: '';
$bg_color			= isset( $design['bg_color'] )			? $design['bg_color']			: '';
$content_color		= isset( $design['content_color'] )		? $design['content_color']		: '';
$snote_txtcolor		= isset( $design['snote_txtcolor'] )	? $design['snote_txtcolor']		: '';
?>

<div id="ibwp_mp_design_sett" class="ibwp-vtab-cnt ibwp-mp-design-sett ibwp-clearfix">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Design Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Set various popup design settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl ibwp-sett-tbl ibwp-mp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-mp-design-temp"><?php _e('Template', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[template]" class="ibwp-select ibwp-mp-design-temp" id="ibwp-mp-design-temp">
						<?php foreach ( $design_data as $design_key => $design_val ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $design_key ); ?>" <?php selected( $template, $design_key ); ?> <?php if( !( $design_key == 'design-1' || $design_key == 'design-2' ) ) { echo 'disabled'; } ?>><?php echo $design_val; ?></option>
						<?php } ?>
					</select>
					<br />
					<span class="description"><?php _e('Select popup template.', 'inboundwp-lite'); ?></span><br/>
					<span class="description ibwp-pro-feature"><?php echo __('If you want to more popup template. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>

			<tr class="ibwp-pro-feature">
				<td class="ibwp-no-padding" colspan="2">
					<table class="form-table ibwp-tbl">
						<tr>
							<th>
								<label for="ibwp-mp-fullscreen"><?php _e('Full Screen Popup', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-show-hide ibwp-mp-fullscreen" id="ibwp-mp-fullscreen" data-label="screen" data-prefix="full" disabled /><br />
								<span class="description"><?php echo __('Check this box if you want to display full screen popup. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-popup-width"><?php _e('Popup Width', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-text ibwp-mp-popup-width" id="ibwp-mp-popup-width" disabled /> <?php esc_html_e('PX', 'inboundwp-lite'); ?><br/>
								<span class="description"><?php echo __('Set popup width in PX. Leave empty for default width. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
							</td>
						</tr>

						<tr>
							<th>
								<label for="ibwp-mp-popup-height"><?php _e('Popup Height', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-number ibwp-mp-popup-height" id="ibwp-mp-popup-height" disabled /> <?php esc_html_e('PX', 'inboundwp-lite'); ?><br />
								<span class="description"><?php echo __('Set popup height in PX. Leave empty for default height. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
							</td>
						</tr>

						<tr>
							<th>
								<label for="ibwp-mp-popup-mn-position"><?php _e('Popup Position', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<select name="" class="ibwp-select ibwp-mp-popup-mn-position" id="ibwp-mp-popup-mn-position" disabled>
									<?php foreach ( $mn_position_data as $mn_position_key => $mn_position_val ) { ?>
										<option value=""><?php echo $mn_position_val; ?></option>
									<?php } ?>
								</select><br/>
								<span class="description"><?php echo __('9 types of popup position. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Image & Color Settings', 'inboundwp-lite'); ?></div>
				</th>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-overlay-img"><?php _e('Overlay Background Image', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo $prefix; ?>design[overlay_img]" value="<?php echo esc_url( $overlay_img ); ?>" class="ibwp-url regular-text ibwp-mp-overlay-img ibwp-img-upload-input" id="ibwp-mp-overlay-img" />
					<input type="button" name="ibwp_mp_overlay_img" id="ibwp_mp_url" class="button-secondary ibwp-image-upload" value="<?php esc_html_e( 'Upload Image', 'inboundwp-lite'); ?>" /> 
					<input type="button" name="ibwp_mp_overlay_img_clear" class="button button-secondary ibwp-image-clear" value="<?php esc_html_e( 'Clear', 'inboundwp-lite'); ?>" /><br />
					<span class="description"><?php _e('Set overlay background image.', 'inboundwp-lite'); ?></span><br />
					<?php
						$overlay_image = '';
						if( $overlay_img != '' ) {
							$overlay_image = '<img src="'.esc_url( $overlay_img ).'" alt="" />';
						}
					?>
					<div class="ibwp-img-view"><?php echo $overlay_image; ?></div>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-overlay-color"><?php _e('Overlay Background Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo $prefix; ?>design[overlay_color]" value="<?php echo ibwpl_esc_attr( $overlay_color ); ?>" class="ibwp-colorpicker ibwp-mp-overlay-color" id="ibwp-mp-overlay-color" data-alpha="true" /><br />
					<span class="description"><?php _e('Choose overlay background color. Leave empty for default color.', 'inboundwp-lite'); ?></span><br/>
					<span class="description"><?php _e('<strong>Note:</strong> This will only work when overlay background image is not there or image is transparent.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-popup-img"><?php _e('Popup Background Image', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo $prefix; ?>design[popup_img]" value="<?php echo ibwpl_esc_attr( $popup_img ); ?>" class="regular-text ibwp-url ibwp-mp-popup-img ibwp-img-upload-input" id="ibwp-mp-popup-img" />
					<input type="button" name="ibwp_mp_popup_img" class="button-secondary ibwp-image-upload" value="<?php esc_html_e( 'Upload Image', 'inboundwp-lite'); ?>" />
					<input type="button" name="ibwp_mp_popup_img_clear" class="button button-secondary ibwp-image-clear" value="<?php esc_html_e( 'Clear', 'inboundwp-lite'); ?>" /> <br />
					<span class="description"><?php _e('Set popup background image.', 'inboundwp-lite'); ?></span><br />
					<?php
						$popup_image = '';
						if( $popup_img != '' ) {
							$popup_image = '<img src="'.esc_url( $popup_img ).'" alt="" />';
						}
					?>
					<div class="ibwp-img-view"><?php echo $popup_image; ?></div>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-popup-img-size"><?php _e('Popup Background Image Size', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo $prefix; ?>design[popup_img_size]" class="ibwp-select ibwp-mp-popup-img-size" id="ibwp-mp-popup-img-size">
						<option value="cover" <?php selected( $popup_img_size, 'cover' ); ?>><?php esc_html_e('Cover', 'inboundwp-lite'); ?></option>
						<option value="auto" <?php selected( $popup_img_size, 'auto' ); ?>><?php esc_html_e('Auto', 'inboundwp-lite'); ?></option>
						<option value="contain" <?php selected( $popup_img_size, 'contain' ); ?>><?php esc_html_e('Contain', 'inboundwp-lite'); ?></option>
					</select><br/>
					<span class="description"><?php _e('Select popup background image size.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-popup-img-repeat"><?php _e('Popup Background Image Repeat', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo $prefix; ?>design[popup_img_repeat]" class="ibwp-select ibwp-mp-popup-img-repeat" id="ibwp-mp-popup-img-repeat">
						<?php foreach ( $img_repeat_data as $img_repeat_key => $img_repeat_val ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $img_repeat_key ); ?>" <?php selected( $popup_img_repeat, $img_repeat_key ); ?>><?php echo $img_repeat_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select popup background image repeat.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-popup-img-position"><?php _e('Popup Background Image Position', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo $prefix; ?>design[popup_img_pos]" class="ibwp-select ibwp-mp-popup-img-position" id="ibwp-mp-popup-img-position">
						<?php foreach ( $img_position_data as $img_position_key => $img_position_val ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $img_position_key ); ?>" <?php selected( $popup_img_pos, $img_position_key ); ?>><?php echo $img_position_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Select popup background image position.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-bg-color"><?php _e('Popup Background Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo $prefix; ?>design[bg_color]" value="<?php echo ibwpl_esc_attr( $bg_color ); ?>" class="ibwp-colorpicker ibwp-mp-bg-color" id="ibwp-mp-bg-color" data-alpha="true" /><br />
					<span class="description"><?php _e('Choose popup background color.', 'inboundwp-lite'); ?></span>
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
					<label for="ibwp-mp-content-color"><?php _e('Content Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[content_color]" value="<?php echo ibwpl_esc_attr( $content_color ); ?>" class="ibwp-colorpicker ibwp-mp-content-color" id="ibwp-mp-content-color"><br />
					<span class="description"><?php _e('Choose content text color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-secur-note-color"><?php _e('Security Note Text Color', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>design[snote_txtcolor]" value="<?php echo ibwpl_esc_attr( $snote_txtcolor ); ?>" class="ibwp-colorpicker ibwp-mp-secur-note-color" id="ibwp-mp-secur-note-color"><br />
					<span class="description"><?php _e('Choose security note text color.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-secondary-con-clr"><?php _e('Secondary Content Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-secondary-con-clr" id="ibwp-mp-secondary-con-clr" /><br />
					<span class="description"><?php echo __('Choose secondary content text color. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-cus-close-txt-clr"><?php _e('Custom Close Text Color', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-cus-close-txt-clr" id="ibwp-mp-cus-close-txt-clr" /><br />
					<span class="description"><?php echo __('Choose custom close text color. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>

			<!-- Start - Heading Settings -->
			<tr class="ibwp-pro-feature">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="2">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Heading Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-mheading-fontsize"><?php _e('Main Heading Font Size', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-number ibwp-mp-mheading-fontsize" id="ibwp-mp-mheading-fontsize" disabled /> <?php esc_html_e('PX', 'inboundwp-lite'); ?><br />
								<span class="description"><?php _e('Enter main heading font size.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-mheading-txtclr"><?php _e('Main Heading Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-mheading-txtclr" id="ibwp-mp-mheading-txtclr" /><br />
								<span class="description"><?php _e('Choose main heading text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-sheading-fontsize"><?php _e('Sub Heading Font Size', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<input type="text" name="" value="" class="ibwp-number ibwp-mp-sheading-fontsize" id="ibwp-mp-sheading-fontsize" disabled /> <?php esc_html_e('PX', 'inboundwp-lite'); ?><br />
								<span class="description"><?php _e('Enter sub heading font size.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-sheading-txtcolor"><?php _e('Sub Heading Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-sheading-txtcolor" id="ibwp-mp-sheading-txtcolor" /><br />
								<span class="description"><?php _e('Choose sub heading text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<!-- Start - Collect Email Settings -->
			<tr class="ibwp-show-hide-row-goal ibwp-show-if-goal-email-lists ibwp-pro-feature" style="<?php if( $popup_goal != 'email-lists' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="2">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Collect Email Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-field-lbl-clr"><?php _e('Field Label Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-field-lbl-clr" id="ibwp-mp-field-lbl-clr"><br />
								<span class="description"><?php _e('Choose field label color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-field-bg-clr"><?php _e('Field BG Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-field-bg-clr" id="ibwp-mp-field-bg-clr"><br />
								<span class="description"><?php _e('Choose field background color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-field-txt-clr"><?php _e('Field Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-field-txt-clr" id="ibwp-mp-field-txt-clr"><br />
								<span class="description"><?php _e('Choose field text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-field-btn-bg-clr"><?php _e('Button BG Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-field-btn-bg-clr" id="ibwp-mp-field-btn-bg-clr"><br />
								<span class="description"><?php _e('Choose button background color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-field-btn-txt-clr"><?php _e('Button Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-field-btn-txt-clr" id="ibwp-mp-field-btn-txt-clr"><br />
								<span class="description"><?php _e('Choose button text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-field-btn-hbg-clr"><?php _e('Button BG Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-field-btn-hbg-clr" id="ibwp-mp-field-btn-hbg-clr"><br />
								<span class="description"><?php _e('Choose button background hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-field-btn-htxt-clr"><?php _e('Button Text Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-field-btn-htxt-clr" id="ibwp-mp-field-btn-htxt-clr"><br />
								<span class="description"><?php _e('Choose button text hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- End - Collect Email Settings -->

			<!-- Start - Target URL Settings -->
			<tr class="ibwp-show-hide-row-goal ibwp-show-if-goal-target-url ibwp-pro-feature" style="<?php if( $popup_goal != 'target-url' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="2">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Target URL Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn1-bg-clr"><?php _e('Button 1 BG Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn1-bg-clr" id="ibwp-mp-url-btn1-bg-clr" /><br />
								<span class="description"><?php _e('Choose button 1 backgournd color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn1-txt-clr"><?php _e('Button 1 Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn1-txt-clr" id="ibwp-mp-url-btn1-txt-clr" /><br />
								<span class="description"><?php _e('Choose button 1 text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn1-hbg-clr"><?php _e('Button 1 BG Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn1-hbg-clr" id="ibwp-mp-url-btn1-hbg-clr" /><br />
								<span class="description"><?php _e('Choose button 1 backgournd hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn1-htxt-clr"><?php _e('Button 1 Text Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn1-htxt-clr" id="ibwp-mp-url-btn1-htxt-clr" /><br />
								<span class="description"><?php _e('Choose button 1 text hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn2-bg-clr"><?php _e('Button 2 BG Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn2-bg-clr" id="ibwp-mp-url-btn2-bg-clr" /><br />
								<span class="description"><?php _e('Choose button 2 backgournd color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn2-txt-clr"><?php _e('Button 2 Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn2-txt-clr" id="ibwp-mp-url-btn2-txt-clr" /><br />
								<span class="description"><?php _e('Choose button 2 text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn2-hbg-clr"><?php _e('Button 2 BG Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn2-hbg-clr" id="ibwp-mp-url-btn2-hbg-clr" /><br />
								<span class="description"><?php _e('Choose button 2 backgournd hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-url-btn2-htxt-clr"><?php _e('Button 2 Text Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-url-btn2-htxt-clr" id="ibwp-mp-url-btn2-htxt-clr" /><br />
								<span class="description"><?php _e('Choose button 2 text hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- End - Target URL Settings -->

			<!-- Start - Phone Calls Settings -->
			<tr class="ibwp-show-hide-row-goal ibwp-show-if-goal-phone-calls ibwp-pro-feature" style="<?php if( $popup_goal != 'phone-calls' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th colspan="2">
								<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Phone Calls Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
							</th>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-call-btn-bg-clr"><?php _e('Button BG Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-call-btn-bg-clr" id="ibwp-mp-call-btn-bg-clr" /><br />
								<span class="description"><?php _e('Choose button background color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-call-btn-txt-clr"><?php _e('Button Text Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-call-btn-txt-clr" id="ibwp-mp-call-btn-txt-clr" /><br />
								<span class="description"><?php _e('Choose button text color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-call-btn-hbg-clr"><?php _e('Button BG Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-call-btn-hbg-clr" id="ibwp-mp-call-btn-hbg-clr" /><br />
								<span class="description"><?php _e('Choose button background hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-mp-call-btn-htxt-clr"><?php _e('Button Text Hover Color', 'inboundwp-lite'); ?></label>
							</th>
							<td class="ibwp-disabled-field">
								<input type="text" name="" value="" class="ibwp-colorpicker ibwp-mp-call-btn-htxt-clr" id="ibwp-mp-call-btn-htxt-clr" /><br />
								<span class="description"><?php _e('Choose button text hover color.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- End - Phone Calls Settings -->

			<tr class="ibwp-pro-feature">
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Custom CSS ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
				</th>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-custom-css"><?php _e('Custom CSS', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<textarea id="ibwp-mp-custom-css" name="" class="ibwp-code-editor ibwp-code-editor-small ibwp-css-editor large-text" data-mode="css"></textarea>
					<span class="description"><?php _e('Enter custom CSS for popup. Note: Do not include `style` tag.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-mp-design-sett -->