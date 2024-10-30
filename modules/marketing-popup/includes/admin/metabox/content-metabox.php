<?php
/**
 * Handles Content Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$field_type_data	= ibwpl_form_field_type_options();
$content			= get_post_meta( $post->ID, $prefix.'content', true );

// Taking some variables
$main_heading		= isset( $content['main_heading'] )			? $content['main_heading']		: '';
$sub_heading		= isset( $content['sub_heading'] )			? $content['sub_heading']		: '';
$popup_content		= isset( $content['popup_content'] )		? $content['popup_content']		: '';
$security_note		= isset( $content['security_note'] )		? $content['security_note']		: '';
$thanks_msg			= isset( $content['thanks_msg'] )			? $content['thanks_msg']		: '';

// Form field settings data
$pre_form_data	= array(
						0 => array(
								'label'			=> esc_html__( 'Email', 'inboundwp-lite' ),
								'placeholder'	=> esc_html__( 'Enter Your Email', 'inboundwp-lite' )
							),
					);
$form_fields	= ! empty( $content['form_fields'] )	? $content['form_fields']		: $pre_form_data;
$submit_btn_txt	= isset( $content['submit_btn_txt'] )	? $content['submit_btn_txt']	: __('Submit', 'inboundwp-lite');

// Target URL settings data
$btn1_text		= isset( $content['target_url']['btn1_text'] )		? $content['target_url']['btn1_text']	: '';
$btn1_link		= isset( $content['target_url']['btn1_link'] )		? $content['target_url']['btn1_link']	: '';
$btn1_target	= isset( $content['target_url']['btn1_target'] )	? $content['target_url']['btn1_target']	: '';
$btn2_text		= isset( $content['target_url']['btn2_text'] )		? $content['target_url']['btn2_text']	: '';
$btn2_link		= isset( $content['target_url']['btn2_link'] )		? $content['target_url']['btn2_link']	: '';
$btn2_target	= isset( $content['target_url']['btn2_target'] )	? $content['target_url']['btn2_target']	: '';

// Phone Calls settings data
$btn_txt		= isset( $content['phone_calls']['btn_txt'] )	? $content['phone_calls']['btn_txt']	: '';
$phone_num		= isset( $content['phone_calls']['phone_num'] )	? $content['phone_calls']['phone_num']	: '';
?>

<div id="ibwp_mp_content_sett" class="ibwp-vtab-cnt ibwp-mp-content-sett ibwp-clearfix">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Content Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Popup content settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-mp-main-heading"><?php _e('Main Heading', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[main_heading]" value="<?php echo ibwpl_esc_attr( $main_heading ); ?>" class="large-text ibwp-text ibwp-mp-main-heading" id="ibwp-mp-main-heading" />
					<span class="description"><?php _e('Enter popup main heading text.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-sub-heading"><?php _e('Sub Heading', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[sub_heading]" value="<?php echo ibwpl_esc_attr( $sub_heading ); ?>" class="large-text ibwp-text ibwp-mp-sub-heading" id="ibwp-mp-sub-heading" />
					<span class="description"><?php _e('Enter popup sub heading text.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-mp-popup-cont"><?php _e('Popup Content', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<?php wp_editor( $popup_content, 'ibwp-mp-popup-cont', array('textarea_name' => $prefix.'content[popup_content]', 'textarea_rows' => 8, 'media_buttons' => true) ); ?>
					<span class="description"><?php _e('Enter popup content.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-secur-note"><?php _e('Security Note', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[security_note]" value="<?php echo ibwpl_esc_attr( $security_note ); ?>" class="large-text ibwp-text ibwp-mp-secur-note" id="ibwp-mp-secur-note" />
					<span class="description"><?php _e('Enter security note text.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-secondary-con"><?php _e('Secondary Content', 'inboundwp-lite'); ?></label>
				</th>
				<td class="ibwp-disabled-field">
					<?php wp_editor( '', 'ibwp-mp-secondary-con', array('textarea_name' => '', 'textarea_rows' => 8, 'media_buttons' => true) ); ?>
					<span class="description"><?php echo __('Enter popup secondary content which will display after respective `Call to Action` like email form etc. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>

			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-cus-close-txt"><?php _e('Custom Close Text', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" class="large-text ibwp-text ibwp-mp-cus-close-txt" id="ibwp-mp-cus-close-txt" disabled />
					<span class="description"><?php echo __('Enter custom close text. e.g No, thank you. I do not want. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>

			<!-- Start - Collect Email Settings -->
			<tr class="ibwp-show-hide-row-goal ibwp-show-if-goal-email-lists" style="<?php if( $popup_goal != 'email-lists' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tbody>
							<tr>
								<th colspan="2">
									<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Collect Email Settings', 'inboundwp-lite'); ?></div>
								</th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-field-btn"><?php _e('Button Text', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[submit_btn_txt]" value="<?php echo ibwpl_esc_attr( $submit_btn_txt ); ?>" class="ibwp-text large-text ibwp-mp-field-btn" id="ibwp-mp-field-btn">
									<span class="description"><?php _e('Enter form submit button text.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-thanks-msg"><?php _e('Thank You Message', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<?php wp_editor( $thanks_msg, 'ibwp-mp-thanks-msg', array('textarea_name' => $prefix.'content[thanks_msg]', 'textarea_rows' => 6, 'media_buttons' => true) ); ?>
									<span class="description"><?php _e('Enter thank you message once the form is submitted.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th colspan="2">
									<div class="ibwp-sub-sett-title"><?php _e('Collect Email Form Fields', 'inboundwp-lite'); ?></div>
								</th>
							</tr>
							<tr>
								<td colspan="2" class="ibwp-mp-form-field-row-wrp ibwp-no-padding">
									<?php foreach ( $form_fields as $field_key => $form_field_data ) {

										$type			= isset( $form_field_data['type'] )			? $form_field_data['type']			: '';
										$label			= isset( $form_field_data['label'] )		? $form_field_data['label']			: '';
										$placeholder	= isset( $form_field_data['placeholder'] )	? $form_field_data['placeholder']	: '';
										$require		= ! empty( $form_field_data['require'] )	? 1 : 0;
									?>
										<table class="form-table ibwp-mp-form-field-row" data-key="<?php echo $field_key; ?>">
											<tbody>
												<tr>
													<th><label for="ibwp-mp-field-type-<?php echo $field_key; ?>"><?php _e('Field Type', 'inboundwp-lite'); ?></label></th>
													<td>
														<?php if( $field_key > 0 ) { ?>
														<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key; ?>][type]" class="ibwp-select ibwp-mp-field-type" id="ibwp-mp-field-type-<?php echo $field_key; ?>">
															<?php foreach ( $field_type_data as $field_type_key => $field_type_val ) {
																$field_label = ! empty( $field_type_val['label'] ) ? $field_type_val['label'] : $field_type_key;
															?>
																<option value="<?php echo ibwpl_esc_attr( $field_type_key ); ?>" <?php selected( $type, $field_type_key ); ?>><?php echo $field_label; ?></option>
															<?php } ?>
														</select><br/>
														<span class="description ibwp-mp-email-fields"><?php _e('Select form field type.', 'inboundwp-lite'); ?></span>
														<?php } else { esc_html_e('Email', 'inboundwp-lite'); } ?>
													</td>
													<td align="right" style="vertical-align: top;">
														<span class="ibwp-action-btn ibwp-action-add-btn ibwp-mp-add-form-field-row ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
														<?php if( $field_key > 0 ) { ?>
														<span class="ibwp-action-btn ibwp-action-del-btn ibwp-mp-del-form-field-row ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
														<?php } ?>
														<span class="ibwp-action-btn ibwp-action-drag-btn ibwp-mp-drag-form-field-row ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-mp-field-label-<?php echo $field_key; ?>"><?php _e('Field Label', 'inboundwp-lite'); ?></label></th>
													<td>
														<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key ?>][label]" value="<?php echo ibwpl_esc_attr( $label ); ?>" class="ibwp-text large-text ibwp-mp-field-label" id="ibwp-mp-field-label-<?php echo $field_key; ?>">
														<span class="description ibwp-mp-email-fields"><?php _e('Enter form field label.', 'inboundwp-lite'); ?></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-mp-field-plch-<?php echo $field_key; ?>"><?php _e('Field Placeholder', 'inboundwp-lite'); ?></label></th>
													<td>
														<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key ?>][placeholder]" value="<?php echo ibwpl_esc_attr( $placeholder ); ?>" class="ibwp-text large-text ibwp-mp-field-placeholder" id="ibwp-mp-field-plch-<?php echo $field_key; ?>" />
														<span class="description ibwp-mp-email-fields"><?php _e('Enter form field placeholder.', 'inboundwp-lite'); ?></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-mp-field-require-<?php echo $field_key; ?>"><?php _e('Required', 'inboundwp-lite'); ?></label></th>
													<td>
														<?php if( $field_key > 0 ) { ?>
														<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key ?>][require]" value="1" <?php checked( $require, 1 ); ?> class="ibwp-text regular-text ibwp-mp-field-require" id="ibwp-mp-field-require-<?php echo $field_key; ?>" /><br/>
														<span class="description ibwp-mp-email-fields"><?php _e('Check this check box to enable required field.', 'inboundwp-lite'); ?></span>
													<?php } else { esc_html_e('Yes', 'inboundwp-lite'); } ?>
													</td>
												</tr>
												<tr>
													<th><label><?php _e('Field Key', 'inboundwp-lite'); ?></label></th>
													<td>
														<?php echo $field_key; ?>
													</td>
												</tr>
												<tr>
													<th colspan="3"><hr/></th>
												</tr>
											</tbody>
										</table><!-- end email form fields -->
									<?php } // End for each ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!-- End - Collect Email Settings -->

			<!-- Start - Target URL Settings -->
			<tr class="ibwp-show-hide-row-goal ibwp-show-if-goal-target-url" style="<?php if( $popup_goal != 'target-url' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tbody>
							<tr>
								<th colspan="2">
									<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Target URL Settings', 'inboundwp-lite'); ?></div>
								</th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-url-btn1-txt"><?php _e('Button 1 Text', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[target_url][btn1_text]" value="<?php echo ibwpl_esc_attr( $btn1_text ); ?>" class="large-text ibwp-text ibwp-mp-url-btn1-txt" id="ibwp-mp-url-btn1-txt" />
									<span class="description"><?php _e('Enter button 1 text.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-url-btn1-link"><?php _e('Button 1 Link', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[target_url][btn1_link]" value="<?php echo esc_url( $btn1_link ); ?>" class="large-text ibwp-text ibwp-mp-url-btn1-link" id="ibwp-mp-url-btn1-link" />
									<span class="description"><?php _e('Enter button 1 link.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-url-btn1-target"><?php _e('Button 1 Link Target', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[target_url][btn1_target]" class="ibwp-select ibwp-mp-url-btn1-target" id="ibwp-mp-url-btn1-target">
										<option value="_self" <?php selected( $btn1_target, '_self' ); ?>><?php esc_html_e('Same Tab', 'inboundwp-lite'); ?></option>
										<option value="_blank" <?php selected( $btn1_target, '_blank' ); ?>><?php esc_html_e('New Tab', 'inboundwp-lite'); ?></option>
									</select><br/>
									<span class="description"><?php _e('Select button 1 link target.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>

							<tr>
								<th>
									<label for="ibwp-mp-url-btn2-txt"><?php _e('Button 2 Text', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[target_url][btn2_text]" value="<?php echo ibwpl_esc_attr( $btn2_text ); ?>" class="large-text ibwp-text ibwp-mp-url-btn2-txt" id="ibwp-mp-url-btn2-txt" />
									<span class="description"><?php _e('Enter button 2 text.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-url-btn2-link"><?php _e('Button 2 Link', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[target_url][btn2_link]" value="<?php echo esc_url( $btn2_link ); ?>" class="large-text ibwp-text ibwp-mp-url-btn2-link" id="ibwp-mp-url-btn2-link" />
									<span class="description"><?php _e('Enter button 2 link. Leave it blank to close the popup on click.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-url-btn2-target"><?php _e('Button 2 Link Target', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[target_url][btn2_target]" class="ibwp-select ibwp-mp-url-btn2-target" id="ibwp-mp-url-btn2-target">
										<option value="_self" <?php selected( $btn2_target, '_self' ); ?>><?php esc_html_e('Same Tab', 'inboundwp-lite'); ?></option>
										<option value="_blank" <?php selected( $btn2_target, '_blank' ); ?>><?php esc_html_e('New Tab', 'inboundwp-lite'); ?></option>
									</select><br/>
									<span class="description"><?php _e('Select button 2 link target.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!-- End - Target URL Settings -->

			<!-- Start - Phone Calls Settings -->
			<tr class="ibwp-show-hide-row-goal ibwp-show-if-goal-phone-calls" style="<?php if( $popup_goal != 'phone-calls' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tbody>
							<tr>
								<th colspan="2">
									<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Phone Calls Settings', 'inboundwp-lite'); ?></div>
								</th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-call-btn-txt"><?php _e('Button Text', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[phone_calls][btn_txt]" value="<?php echo ibwpl_esc_attr( $btn_txt ); ?>" class="ibwp-text large-text ibwp-mp-call-btn-txt" id="ibwp-mp-call-btn-txt" />
									<span class="description"><?php _e('Enter Button Text.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-call-number"><?php _e('Phone Number', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[phone_calls][phone_num]" value="<?php echo ibwpl_esc_attr( $phone_num ); ?>" class="ibwp-text large-text ibwp-mp-call-number" id="ibwp-mp-call-number" />
									<span class="description"><?php _e('Enter Phone nmumber. e.g. 447911123456 Note : Please do not include plus (+) sign.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</td>				
			</tr>
			<!-- End - Phone Calls Settings -->
		</tbody>
	</table>
</div><!-- end .ibwp-mp-content-sett -->

<script type="text/html" id="tmpl-ibwp-mp-form-field-tmpl">
	<table class="form-table ibwp-mp-form-field-row" data-key="1">
		<tbody>
			<tr>
				<th><label for="ibwp-mp-field-type-1"><?php _e('Field Type', 'inboundwp-lite'); ?></label></th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][type]" class="ibwp-select ibwp-mp-field-type" id="ibwp-mp-field-type-1">
						<?php foreach ( $field_type_data as $field_type_key => $field_type_val ) {
							$field_label = ! empty( $field_type_val['label'] ) ? $field_type_val['label'] : $field_type_key;
						?>
							<option value="<?php echo ibwpl_esc_attr( $field_type_key ); ?>"><?php echo $field_label; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description ibwp-mp-email-fields"><?php _e('Select form field type.', 'inboundwp-lite'); ?></span>
				</td>
				<td align="right" style="vertical-align: top;">
					<span class="ibwp-action-btn ibwp-action-add-btn ibwp-mp-add-form-field-row ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
					<span class="ibwp-action-btn ibwp-action-del-btn ibwp-mp-del-form-field-row ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
					<span class="ibwp-action-btn ibwp-action-drag-btn ibwp-mp-drag-form-field-row ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
				</td>
			</tr>
			<tr>
				<th><label for="ibwp-mp-field-label-1"><?php _e('Field Label', 'inboundwp-lite'); ?></label></th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][label]" value="" class="ibwp-text large-text ibwp-mp-field-label" id="ibwp-mp-field-label-1">
					<span class="description ibwp-mp-email-fields"><?php _e('Enter form field label.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="ibwp-mp-field-plch-1"><?php _e('Field Placeholder', 'inboundwp-lite'); ?></label></th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][placeholder]" value="" class="ibwp-text large-text ibwp-mp-field-placeholder" id="ibwp-mp-field-plch-1" />
					<span class="description ibwp-mp-email-fields"><?php _e('Enter form field placeholder.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="ibwp-mp-field-require-1"><?php _e('Required', 'inboundwp-lite'); ?></label></th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][require]" value="1" class="ibwp-text regular-text ibwp-mp-field-require" id="ibwp-mp-field-require-1" /><br/>
					<span class="description ibwp-mp-email-fields"><?php _e('Check this check box to enable required field.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th><label><?php _e('Field Key', 'inboundwp-lite'); ?></label></th>
				<td>
					{{data.field_key}}
				</td>
			</tr>
			<tr>
				<th colspan="3"><hr/></th>
			</tr>
		</tbody>
	</table>
</script>