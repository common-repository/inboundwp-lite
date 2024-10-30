<?php
/**
 * Handles Content Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$field_type_data	= ibwpl_form_field_type_options();
$content			= get_post_meta( $post->ID, $prefix.'content', true );

$pre_form_data	= array(
						0 => array(
								'label'			=> esc_html__( 'Email', 'inboundwp-lite' ),
								'placeholder'	=> esc_html__( 'Enter Your Email', 'inboundwp-lite' )
							),
					);

$title				= isset( $content['title'] )				? $content['title']				: '';
$sub_title			= isset( $content['sub_title'] )			? $content['sub_title']			: '';
$wheel_content		= isset( $content['wheel_content'] )		? $content['wheel_content']		: '';
$icon_tooltip_txt	= isset( $content['icon_tooltip_txt'] )		? $content['icon_tooltip_txt']	: '';
$button_txt			= isset( $content['button_txt'] )			? $content['button_txt']		: '';
$cust_close_txt		= isset( $content['cust_close_txt'] )		? $content['cust_close_txt']	: '';
$form_fields		= ! empty( $content['form_fields'] )		? $content['form_fields']		: $pre_form_data;
?>

<div id="ibwp_spw_content_sett" class="ibwp-vtab-cnt ibwp-spw-content-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Content Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Wheel content settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-spw-main-title"><?php _e('Title', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[title]" value="<?php echo ibwpl_esc_attr( $title ); ?>" class="large-text ibwp-text ibwp-spw-main-title" id="ibwp-spw-main-title" />
					<span class="description"><?php _e('Enter spin wheel title text.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-spw-sub-title"><?php _e('Sub Title', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[sub_title]" value="<?php echo ibwpl_esc_attr( $sub_title ); ?>" class="large-text ibwp-text ibwp-spw-sub-title" id="ibwp-spw-sub-title" />
					<span class="description"><?php _e('Enter spin wheel sub title text.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr class="ibwp-wp-editor-row">
				<th>
					<label for="ibwp-spw-wheel-cont"><?php _e('Wheel Content', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<?php wp_editor( $wheel_content, 'ibwp-spw-wheel-cont', array('textarea_name' => $prefix.'content[wheel_content]', 'textarea_rows' => 8, 'media_buttons' => true) ); ?>
					<span class="description"><?php _e('Enter spin wheel content.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-spw-tooltip-txt"><?php _e('Icon Tooltip Text', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[icon_tooltip_txt]" value="<?php echo ibwpl_esc_attr( $icon_tooltip_txt ); ?>" class="large-text ibwp-text ibwp-spw-tooltip-txt" id="ibwp-spw-tooltip-txt" />
					<span class="description"><?php _e('Enter spin wheel icon tooltip text.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-spw-btn-text"><?php _e('Button Text', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[button_txt]" value="<?php echo ibwpl_esc_attr( $button_txt ); ?>" class="large-text ibwp-text ibwp-spw-btn-text" id="ibwp-spw-btn-text" />
					<span class="description"><?php _e('Enter spin wheel button text.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="ibwp-spw-cus-close-txt"><?php _e('Custom Close Text', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[cust_close_txt]" value="<?php echo ibwpl_esc_attr( $cust_close_txt ); ?>" class="large-text ibwp-text ibwp-spw-cus-close-txt" id="ibwp-spw-cus-close-txt" />
					<span class="description"><?php _e('Enter custom close text. e.g No, thank you. I do not want.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<!-- Start - Form Fields Settings -->
			<tr>
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tbody>
							<tr>
								<th colspan="2">
									<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Form Fields Settings', 'inboundwp-lite'); ?></div>
								</th>
							</tr>
							<tr class="ibwp-pro-feature">
								<th>
									<label for="ibwp-spw-fields-enable"><?php _e('Do not Show Form Fields', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-spw-fields-enable" id="ibwp-spw-fields-enable" disabled /><br/>
									<span class="description"><?php _e('Check this box if you do not want to show form fields.', 'inboundwp-lite'); ?></span>
									<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
								</td>
							</tr>
							<tr>
								<th colspan="2">
									<hr/>
								</th>
							</tr>
							<tr>
								<td colspan="2" class="ibwp-spw-form-field-row-wrp ibwp-no-padding">
									<?php foreach ( $form_fields as $field_key => $form_field_data ) {

										$type			= isset( $form_field_data['type'] )			? $form_field_data['type']			: '';
										$label			= isset( $form_field_data['label'] )		? $form_field_data['label']			: '';
										$placeholder	= isset( $form_field_data['placeholder'] )	? $form_field_data['placeholder']	: '';
										$require		= ! empty( $form_field_data['require'] )	? 1 : 0;
									?>
										<table class="form-table ibwp-spw-form-field-row" data-key="<?php echo $field_key; ?>">
											<tbody>
												<tr>
													<th><label for="ibwp-spw-field-type-<?php echo $field_key; ?>"><?php _e('Field Type', 'inboundwp-lite'); ?></label></th>
													<td>
														<?php if( $field_key > 0 ) { ?>
														<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key; ?>][type]" class="ibwp-select ibwp-spw-field-type" id="ibwp-spw-field-type-<?php echo $field_key; ?>">
															<?php foreach ( $field_type_data as $field_type_key => $field_type_val ) {
																$field_label = ! empty( $field_type_val['label'] ) ? $field_type_val['label'] : $field_type_key;
															?>
																<option value="<?php echo ibwpl_esc_attr( $field_type_key ); ?>" <?php selected( $type, $field_type_key ); ?>><?php echo $field_label; ?></option>
															<?php } ?>
														</select><br/>
														<span class="description ibwp-spw-email-fields"><?php _e('Select form field type.', 'inboundwp-lite'); ?></span>
														<?php } else { esc_html_e('Email', 'inboundwp-lite'); } ?>
													</td>
													<td align="right">
														<span class="ibwp-action-btn ibwp-action-add-btn ibwp-spw-add-form-field-row ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
														<?php if( $field_key > 0 ) { ?>
														<span class="ibwp-action-btn ibwp-action-del-btn ibwp-spw-del-form-field-row ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
														<?php } ?>
														<span class="ibwp-action-btn ibwp-action-drag-btn ibwp-spw-drag-form-field-row ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-spw-field-label-<?php echo $field_key; ?>"><?php _e('Field Label', 'inboundwp-lite'); ?></label></th>
													<td>
														<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key ?>][label]" value="<?php echo ibwpl_esc_attr( $label ); ?>" class="ibwp-text large-text ibwp-spw-field-label" id="ibwp-spw-field-label-<?php echo $field_key; ?>">
														<span class="description ibwp-spw-email-fields"><?php _e('Enter form field label.', 'inboundwp-lite'); ?></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-spw-field-plch-<?php echo $field_key; ?>"><?php _e('Field Placeholder', 'inboundwp-lite'); ?></label></th>
													<td>
														<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key ?>][placeholder]" value="<?php echo ibwpl_esc_attr( $placeholder ); ?>" class="ibwp-text large-text ibwp-spw-field-placeholder" id="ibwp-spw-field-plch-<?php echo $field_key; ?>" />
														<span class="description ibwp-spw-email-fields"><?php _e('Enter form field placeholder.', 'inboundwp-lite'); ?></span>
													</td>
												</tr>
												<tr>
													<th><label for="ibwp-spw-field-require-<?php echo $field_key; ?>"><?php _e('Required', 'inboundwp-lite'); ?></label></th>
													<td>
														<?php if( $field_key > 0 ) { ?>
														<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][<?php echo $field_key ?>][require]" value="1" <?php checked( $require, 1 ); ?> class="ibwp-text regular-text ibwp-spw-field-require" id="ibwp-spw-field-require-<?php echo $field_key; ?>" /><br/>
														<span class="description ibwp-spw-email-fields"><?php _e('Check this check box to enable required field.', 'inboundwp-lite'); ?></span>
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
										</table><!-- end .ibwp-spw-form-field-row -->
									<?php } // End for each ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!-- End - Form Fields Settings -->
		</tbody>
	</table>
</div><!-- end .ibwp-spw-content-sett -->

<script type="text/html" id="tmpl-ibwp-spw-form-field-tmpl">
	<table class="form-table ibwp-spw-form-field-row" data-key="1">
		<tbody>
			<tr>
				<th><label for="ibwp-spw-field-type-1"><?php _e('Field Type', 'inboundwp-lite'); ?></label></th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][type]" class="ibwp-select ibwp-spw-field-type" id="ibwp-spw-field-type-1">
						<?php foreach ( $field_type_data as $field_type_key => $field_type_val ) {
							$field_label = ! empty( $field_type_val['label'] ) ? $field_type_val['label'] : $field_type_key;
						?>
							<option value="<?php echo ibwpl_esc_attr( $field_type_key ); ?>"><?php echo $field_label; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description ibwp-spw-email-fields"><?php _e('Select form field type.', 'inboundwp-lite'); ?></span>
				</td>
				<td align="right">
					<span class="ibwp-action-btn ibwp-action-add-btn ibwp-spw-add-form-field-row ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
					<span class="ibwp-action-btn ibwp-action-del-btn ibwp-spw-del-form-field-row ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
					<span class="ibwp-action-btn ibwp-action-drag-btn ibwp-spw-drag-form-field-row ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
				</td>
			</tr>
			<tr>
				<th><label for="ibwp-spw-field-label-1"><?php _e('Field Label', 'inboundwp-lite'); ?></label></th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][label]" value="" class="ibwp-text large-text ibwp-spw-field-label" id="ibwp-spw-field-label-1">
					<span class="description ibwp-spw-email-fields"><?php _e('Enter form field label.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="ibwp-spw-field-plch-1"><?php _e('Field Placeholder', 'inboundwp-lite'); ?></label></th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][placeholder]" value="" class="ibwp-text large-text ibwp-spw-field-placeholder" id="ibwp-spw-field-plch-1" />
					<span class="description ibwp-spw-email-fields"><?php _e('Enter form field placeholder.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="ibwp-spw-field-require-1"><?php _e('Required', 'inboundwp-lite'); ?></label></th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[form_fields][1][require]" value="1" class="ibwp-text regular-text ibwp-spw-field-require" id="ibwp-spw-field-require-1" /><br/>
					<span class="description ibwp-spw-email-fields"><?php _e('Check this check box to enable required field.', 'inboundwp-lite'); ?></span>
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