<?php
/**
 * Form Settings
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$form_fields_arr	= ibwpl_tm_form_fields();
$form_fields		= ! empty( $form_fields ) ? $form_fields : $form_fields_arr;
?>

<div class="postbox ibwp-no-toggle ibwp-pro-feature">
	<h3 class="hndle">
		<span><?php echo esc_html__( 'Form Settings ', 'inboundwp-lite' ) . ibwpl_upgrade_pro_link(); ?></span>
	</h3>

	<div class="inside">
		<table class="form-table ibwp-tbl">
			<tbody>
				<tr>
					<th>
						<label for="ibwp-tm-status"><?php _e('Testimonial Status', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="" id="ibwp-tm-status" class="ibwp-select ibwp-tm-status" disabled>
							<option value=""><?php esc_html_e('Pending', 'inboundwp-lite'); ?></option>
							<option value=""><?php esc_html_e('Approved', 'inboundwp-lite'); ?></option>
						</select><br/>
						<span class="description"><?php _e('Select testimonial default status when it is submitted via user.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-tm-btn-txt"><?php _e('Submit Button Text', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="" value="" id="ibwp-tm-btn-txt" class="ibwp-text large-text ibwp-tm-btn-txt" disabled /><br/>
						<span class="description"><?php _e('Enter form submit button text.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-tm-field-err-msg"><?php _e('Field Error Message', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="" value="" id="ibwp-tm-field-err-msg" class="ibwp-text large-text ibwp-tm-field-err-msg" disabled /><br/>
						<span class="description"><?php _e('Enter form error message.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-tm-form-err-msg"><?php _e('Validation Error Message', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="" value="" id="ibwp-tm-form-err-msg" class="ibwp-text large-text ibwp-tm-form-err-msg" disabled /><br/>
						<span class="description"><?php _e('Enter form validation error message.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-tm-succ-msg"><?php _e('Success Message', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="" value="" id="ibwp-tm-succ-msg" class="ibwp-text large-text ibwp-tm-succ-msg" disabled /><br/>
						<span class="description"><?php _e('Enter form success message.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<!-- Start - Form Fields Settings -->
				<tr>
					<td colspan="2" class="ibwp-no-padding">
						<table class="form-table">
							<tr>
								<th colspan="3">
									<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Form Field Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
								</th>
							</tr>
							<tr>
								<td class="ibwp-tm-form-field-row-wrp ibwp-no-padding">
									<?php if( ! empty( $form_fields ) ) {
										foreach ( $form_fields as $field_key => $form_field_data ) {

											$field = isset( $form_field_data['field'] )	? $form_field_data['field']	: '';

											// Original Form Data
											$orig_field_data	= isset( $form_fields_arr[$field_key] ) 		? $form_fields_arr[$field_key]		: array();
											$orig_field_name	= ! empty( $orig_field_data['label'] )			? $orig_field_data['label']			: $field;
											$orig_field_name	= ! empty( $orig_field_data['field_title'] )	? $orig_field_data['field_title']	: $orig_field_name;
										?>
										<table class="form-table ibwp-tm-form-field-row" data-key="<?php echo $field_key; ?>">
											<tbody>
												<tr>
													<th>
														<label for="ibwp-tm-field-name-<?php echo $field_key; ?>"><?php _e('Field', 'inboundwp-lite'); ?></label>
													</th>
													<td>
														<?php echo $orig_field_name; ?>
													</td>
													<td align="right" class="ibwp-disabled-field">
														<span class="ibwp-action-btn ibwp-action-drag-btn ibwp-tm-drag-form-field-row" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-tm-field-label-<?php echo $field_key; ?>"><?php _e('Field Label', 'inboundwp-lite'); ?></label></th>
													<td>
														<input type="text" name="" value="" class="ibwp-text regular-text ibwp-tm-field-label" id="ibwp-tm-field-label-<?php echo $field_key; ?>" disabled /><br/>
														<span class="description"><?php _e('Enter form field label.', 'inboundwp-lite'); ?></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-tm-field-err-msg-<?php echo $field_key; ?>"><?php _e('Error Message', 'inboundwp-lite'); ?></label></th>
													<td>
														<input type="text" name="" value="" class="ibwp-text regular-text ibwp-tm-field-err-msg" id="ibwp-tm-field-err-msg-<?php echo $field_key; ?>" disabled /><br/>
														<span class="description"><?php _e('Enter form field error message.', 'inboundwp-lite'); ?></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-tm-field-require-<?php echo $field_key; ?>"><?php _e('Required', 'inboundwp-lite'); ?></label></th>
													<td>
														<?php if( $field != 'content' && $field != 'captcha' ) { ?>
															<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-tm-field-require" id="ibwp-tm-field-require-<?php echo $field_key; ?>" disabled /><br/>
															<span class="description"><?php _e('Check this check box to required field.', 'inboundwp-lite'); ?></span>
														<?php } else { esc_html_e('Yes', 'inboundwp-lite'); } ?>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-tm-field-enable-<?php echo $field_key; ?>"><?php _e('Enable', 'inboundwp-lite'); ?></label></th>
													<td>
														<?php if( $field != 'content' ) { ?>
															<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-tm-field-enable" id="ibwp-tm-field-enable-<?php echo $field_key; ?>" disabled /><br/>
															<span class="description"><?php _e('Check this check box to enable field.', 'inboundwp-lite'); ?></span>
														<?php } else { esc_html_e('Yes', 'inboundwp-lite'); } ?>
													</td>
												</tr>
												<tr>
													<th colspan="3"><hr/></th>
												</tr>
											</tbody>
										</table>
										<?php }
									} ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- End - Form Fields Settings -->

				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_tm_sett_submit" class="button button-primary right ibwp-btn ibwp-tm-general-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" disabled />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->