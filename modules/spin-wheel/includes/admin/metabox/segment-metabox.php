<?php
/**
 * Handles Segment Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$default_segments = array(
						1 => array(
								'label' 		=> esc_html__('Label 1', 'inboundwp-lite'),
								'probability'	=> 20,
								'bg_clr'		=> '#23282d',
								'lbl_clr'		=> '#ffffff',
							),
						2 => array(
								'label' 		=> esc_html__('Label 2', 'inboundwp-lite'),
								'probability'	=> 10,
								'bg_clr'		=> '#ffffff',
								'lbl_clr'		=> '#23282d',
							),
						3 => array(
								'label' 		=> esc_html__('Label 3', 'inboundwp-lite'),
								'probability'	=> 20,
								'bg_clr'		=> '#23282d',
								'lbl_clr'		=> '#ffffff',
							),
						4 => array(
								'label' 		=> esc_html__('Label 4', 'inboundwp-lite'),
								'probability'	=> 10,
								'bg_clr'		=> '#ffffff',
								'lbl_clr'		=> '#23282d',
							),
					);
$segment			= get_post_meta( $post->ID, $prefix.'segment', true );
$wheel_segments		= isset( $segment['wheel_segments'] ) ? $segment['wheel_segments'] : $default_segments;
$wheel_segments		= array_slice( $wheel_segments, 0, 4 );
?>

<div id="ibwp_spw_segment_sett" class="ibwp-vtab-cnt ibwp-spw-segment-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Segment Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Wheel segment settings.', 'inboundwp-lite'); ?></span>
	</div><br/>

	<table class="form-table ibwp-tbl ibwp-spw-segment-tbl">
		<tbody>
			<tr>
				<td colspan="2" class="ibwp-no-padding">
					<div class="ibwp-info ibwp-no-margin"><i class="dashicons dashicons-warning"></i> <?php echo __("InboundWP Lite supports 4 maximum segments. ". ibwpl_upgrade_pro_link() ." for more segments.", 'inboundwp-lite'); ?></div>
				</td>
			</tr>
			<tr class="ibwp-spw-segment-row-wrp">
				<td class="ibwp-no-padding">
					<?php foreach ( $wheel_segments as $wheel_segment_key => $wheel_segment_data ) {

						// Taking some variable
						$segment_type			= ! empty( $wheel_segment_data['type'] )			? $wheel_segment_data['type']			: 'custom_msg';
						$segment_label			= isset( $wheel_segment_data['label'] )				? $wheel_segment_data['label']			: '';
						$segment_coupon			= isset( $wheel_segment_data['coupon_code'] )		? $wheel_segment_data['coupon_code']	: '';
						$segment_probability	= isset( $wheel_segment_data['probability'] )		? $wheel_segment_data['probability']	: '';
						$segment_redirect_url	= isset( $wheel_segment_data['redirect_url'] )		? $wheel_segment_data['redirect_url']	: '';
						$segment_bg_clr			= isset( $wheel_segment_data['bg_clr'] )			? $wheel_segment_data['bg_clr']			: '';
						$segment_lbl_clr		= isset( $wheel_segment_data['lbl_clr'] )			? $wheel_segment_data['lbl_clr']		: '';
						$segment_custom_msg		= isset( $wheel_segment_data['custom_msg'] )		? $wheel_segment_data['custom_msg']		: '';

						$segment_type_text		= ( $segment_type == 'custom_msg' ) ? esc_html__('Custom Message', 'inboundwp-lite') : esc_html__('Thanks Page', 'inboundwp-lite');
					?>
						<div class="ibwp-spw-segment-row-inr" data-key="<?php echo $wheel_segment_key; ?>">
							<div class="ibwp-spw-segment-header">								
								<span class="ibwp-spw-segment-row-actions">
									<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-sett ibwp-tooltip" title="<?php esc_html_e('Show / Hide settings', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-admin-generic"></i></span>
									<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-add ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
									<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-delete ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
									<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-drag ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
								</span>
								<div class="ibwp-spw-segment-title ibwp-tooltip" title="<?php echo ibwpl_esc_attr( $segment_label ); ?>">
									<?php echo esc_html_e('Segment', 'inboundwp-lite'); ?> <span class="ibwp-spw-segment-no"></span>
									<div class="ibwp-spw-segment-info"><?php echo esc_html__('ID', 'inboundwp-lite') .' : '. $wheel_segment_key; ?> | <?php echo esc_html__('Type', 'inboundwp-lite') .' : '. $segment_type_text; ?></div>
								</div>
							</div>

							<div class="ibwp-spw-segment-row-data">
								<table class="form-table ibwp-tbl">
									<tbody>
										<tr>
											<th>
												<label for="ibwp-spw-segment-lbl-<?php echo $wheel_segment_key; ?>"><?php _e('Label', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][<?php echo $wheel_segment_key; ?>][label]" value="<?php echo ibwpl_esc_attr( $segment_label ); ?>" class="ibwp-text large-text ibwp-spw-segment-lbl" id="ibwp-spw-segment-lbl-<?php echo $wheel_segment_key; ?>" /><br/>
												<span class="description"><?php _e('Enter spin wheel segment label.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-spw-segment-coupon-<?php echo $wheel_segment_key; ?>"><?php _e('Coupon Code', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][<?php echo $wheel_segment_key; ?>][coupon_code]" value="<?php echo ibwpl_esc_attr( $segment_coupon ); ?>" class="ibwp-text large-text ibwp-spw-segment-coupon" id="ibwp-spw-segment-coupon-<?php echo $wheel_segment_key; ?>" /><br/>
												<span class="description"><?php _e('Enter spin wheel segment coupon code.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-spw-segment-probability-<?php echo $wheel_segment_key; ?>"><?php _e('Probability', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][<?php echo $wheel_segment_key; ?>][probability]" value="<?php echo ibwpl_esc_attr( $segment_probability ); ?>" class="ibwp-text large-text ibwp-spw-segment-probability" id="ibwp-spw-segment-probability-<?php echo $wheel_segment_key; ?>" /><br/>
												<span class="description"><?php _e('Enter spin wheel segment probability.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-spw-segment-bg-clr-<?php echo $wheel_segment_key; ?>"><?php _e('Background Color', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][<?php echo $wheel_segment_key; ?>][bg_clr]" value="<?php echo ibwpl_esc_attr( $segment_bg_clr ); ?>" class="ibwp-colorpicker ibwp-spw-segment-bg-clr" id="ibwp-spw-segment-bg-clr-<?php echo $wheel_segment_key; ?>" data-alpha="true" /><br/>
												<span class="description"><?php _e('Choose spin wheel segment background color.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-spw-segment-lbl-clr-<?php echo $wheel_segment_key; ?>"><?php _e('Label Text Color', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][<?php echo $wheel_segment_key; ?>][lbl_clr]" value="<?php echo ibwpl_esc_attr( $segment_lbl_clr ); ?>" class="ibwp-colorpicker ibwp-spw-segment-lbl-clr" id="ibwp-spw-segment-lbl-clr-<?php echo $wheel_segment_key; ?>" /><br/>
												<span class="description"><?php _e('Choose spin wheel segment label text color.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-spw-segment-type-<?php echo $wheel_segment_key; ?>"><?php _e('Type', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][<?php echo $wheel_segment_key; ?>][type]" class="ibwp-select ibwp-spw-segment-type" id="ibwp-spw-segment-type-<?php echo $wheel_segment_key; ?>">
													<option value="custom_msg" <?php selected( 'custom_msg', $segment_type ); ?>><?php esc_html_e('Custom Message' ,'inboundwp-lite'); ?></option>
													<option value="thanks_page" <?php selected( 'thanks_page', $segment_type ); ?>><?php esc_html_e('Thanks Page' ,'inboundwp-lite'); ?></option>
												</select><br/>
												<span class="description"><?php _e('Select spin wheel segment type.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr class="ibwp-spw-segment-type-hide ibwp-spw-type-thanks_page" style="<?php if( $segment_type == 'custom_msg' ) { echo 'display: none;'; } ?>">
											<th>
												<label for="ibwp-spw-segment-page-url-<?php echo $wheel_segment_key; ?>"><?php _e('Page URL', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][<?php echo $wheel_segment_key; ?>][redirect_url]" value="<?php echo ibwpl_esc_attr( $segment_redirect_url ); ?>" class="ibwp-text large-text ibwp-spw-segment-page-url" id="ibwp-spw-segment-page-url-<?php echo $wheel_segment_key; ?>" /><br/>
												<span class="description"><?php _e('Enter spin wheel segment page url where you want to redirect after submit.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr class="ibwp-spw-segment-type-hide ibwp-spw-type-custom_msg ibwp-wp-editor-row" style="<?php if( $segment_type == 'thanks_page' ) { echo 'display: none;'; } ?>">
											<th>
												<label for="ibwp-spw-segment-custom-msg-<?php echo $wheel_segment_key; ?>"><?php _e('Custom Message', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<?php wp_editor( $segment_custom_msg, "ibwp-spw-segment-custom-msg-{$wheel_segment_key}", array('textarea_name' => $prefix.'segment[wheel_segments]['.$wheel_segment_key.'][custom_msg]', 'textarea_rows' => 8, 'media_buttons' => true) ); ?>
												<span class="description"><?php _e('Enter spin wheel segment custom message. Available template tags are', 'inboundwp-lite'); ?></span><br/>
												<div class="ibwp-code-tag-wrap">
													<code class="ibwp-copy-clipboard">{label}</code> - <span class="description"><?php _e('Display segment label.', 'inboundwp-lite'); ?></span><br/>
													<code class="ibwp-copy-clipboard">{coupon_code}</code> - <span class="description"><?php _e('Display segment coupon code.', 'inboundwp-lite'); ?></span><br/>
													<code class="ibwp-copy-clipboard">{name}</code> - <span class="description"><?php _e('Display user full name.', 'inboundwp-lite'); ?></span><br/>
													<code class="ibwp-copy-clipboard">{email}</code> - <span class="description"><?php _e('Display user email address.', 'inboundwp-lite'); ?></span><br/>
													<code class="ibwp-copy-clipboard">{phone}</code> - <span class="description"><?php _e('Display user phone number.', 'inboundwp-lite'); ?></span>
												</div>
											</td>
										</tr>

										<tr class="ibwp-pro-feature">
											<td colspan="2" class="ibwp-no-padding">
												<table class="form-table">
													<tr>
														<th colspan="2">
															<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Notification Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div><br/>
															<div class="ibwp-info ibwp-no-margin"><?php _e('This is particular segment email notification. You can enable global notification from notification tab if you have common email content.', 'inboundwp-lite'); ?></div>
														</th>
													</tr>

													<tr>
														<th>
															<label for="ibwp-spw-email-type-<?php echo $wheel_segment_key; ?>"><?php _e('Email Type', 'inboundwp-lite'); ?></label>
														</th>
														<td>
															<select name="" class="ibwp-select ibwp-spw-email-type" id="ibwp-spw-email-type-<?php echo $wheel_segment_key; ?>" disabled>
																<option value=""><?php esc_html_e('Global Email', 'inboundwp-lite'); ?></option>
																<option value=""><?php esc_html_e('Segment Email', 'inboundwp-lite'); ?></option>
																<option value=""><?php esc_html_e('No Email', 'inboundwp-lite'); ?></option>
															</select><br/>
															<span class="description"><?php _e('Select email notification type. 3 types of email type.', 'inboundwp-lite'); ?></span>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div><!-- end .ibwp-spw-segment-row-inr -->
					<?php } ?>
				</td>
			</tr>
		</tbody>
	</table><!-- end .ibwp-spw-segment-tbl -->
</div><!-- end .ibwp-spw-segment-sett -->

<!-- Clone Wheel Segment Template -->
<script type="text/html" id="tmpl-ibwp-spw-segment-tmpl">
	<div class="ibwp-spw-segment-row-inr" data-key="1">
		<div class="ibwp-spw-segment-header">			
			<span class="ibwp-spw-segment-row-actions">
				<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-sett ibwp-tooltip" title="<?php esc_html_e('Show / Hide settings', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-admin-generic"></i></span>
				<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-add ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
				<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-delete ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
				<span class="ibwp-spw-segment-act-btn ibwp-spw-segment-row-move ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
			</span>
			<div class="ibwp-spw-segment-title">
				<?php echo esc_html_e('Segment', 'inboundwp-lite'); ?> <span class="ibwp-spw-segment-no"></span>
				<div class="ibwp-spw-segment-info"><?php echo esc_html__('ID', 'inboundwp-lite') .' : '; ?>{{data.segment_id}}</div>
			</div>
		</div>

		<div class="ibwp-spw-segment-row-data">
			<table class="form-table ibwp-tbl">
				<tbody>
					<tr>
						<th>
							<label for="ibwp-spw-segment-lbl-1"><?php _e('Label', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][1][label]" value="" class="ibwp-text large-text ibwp-spw-segment-lbl" id="ibwp-spw-segment-lbl-1" /><br/>
							<span class="description"><?php _e('Enter spin wheel segment label.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-spw-segment-coupon-1"><?php _e('Coupon Code', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][1][coupon_code]" value="" class="ibwp-text large-text ibwp-spw-segment-coupon" id="ibwp-spw-segment-coupon-1" /><br/>
							<span class="description"><?php _e('Enter spin wheel segment coupon code.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-spw-segment-probability-1"><?php _e('Probability', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][1][probability]" value="" class="ibwp-text large-text ibwp-spw-segment-probability" id="ibwp-spw-segment-probability-1" /><br/>
							<span class="description"><?php _e('Enter spin wheel segment probability.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-spw-segment-bg-clr-1"><?php _e('Background Color', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][1][bg_clr]" value="" class="ibwp-colorpicker ibwp-spw-segment-bg-clr" id="ibwp-spw-segment-bg-clr-1" data-alpha="true" /><br/>
							<span class="description"><?php _e('Choose spin wheel segment background color.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-spw-segment-lbl-clr-1"><?php _e('Label Text Color', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][1][lbl_clr]" value="" class="ibwp-colorpicker ibwp-spw-segment-lbl-clr" id="ibwp-spw-segment-lbl-clr-1" /><br/>
							<span class="description"><?php _e('Choose spin wheel segment label text color.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-spw-segment-type-1"><?php _e('Type', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][1][type]" class="ibwp-select ibwp-show-hide ibwp-spw-segment-type" id="ibwp-spw-segment-type-1" data-prefix="type">
								<option value="custom_msg"><?php esc_html_e('Custom Message', 'inboundwp-lite'); ?></option>
								<option value="thanks_page"><?php esc_html_e('Thanks Page', 'inboundwp-lite'); ?></option>
							</select><br/>
							<span class="description"><?php _e('Select spin wheel segment type.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr class="ibwp-spw-segment-type-hide ibwp-spw-type-thanks_page" style="display: none;">
						<th>
							<label for="ibwp-spw-segment-page-url-1"><?php _e('Page URL', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>segment[wheel_segments][1][redirect_url]" value="" class="ibwp-text large-text ibwp-spw-segment-page-url" id="ibwp-spw-segment-page-url-1" /><br/>
							<span class="description"><?php _e('Enter spin wheel segment page url where you want to redirect after submit.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr class="ibwp-spw-segment-type-hide ibwp-spw-type-custom_msg ibwp-wp-editor-row">
						<th>
							<label for="ibwp-spw-segment-custom-msg-1"><?php _e('Custom Message', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<textarea class="ibwp-wp-editor wp-editor-area" name="<?php echo $prefix; ?>segment[wheel_segments][1][custom_msg]" id="ibwp-spw-segment-custom-msg" data-media-button="true"></textarea>
							<span class="description"><?php _e('Enter spin wheel segment custom message. Available template tags are', 'inboundwp-lite'); ?></span><br/>
							<div class="ibwp-code-tag-wrap">
								<code class="ibwp-copy-clipboard">{label}</code> - <span class="description"><?php _e('Display segment label.', 'inboundwp-lite'); ?></span><br/>
								<code class="ibwp-copy-clipboard">{coupon_code}</code> - <span class="description"><?php _e('Display segment coupon code.', 'inboundwp-lite'); ?></span><br/>
								<code class="ibwp-copy-clipboard">{name}</code> - <span class="description"><?php _e('Display user full name.', 'inboundwp-lite'); ?></span><br/>
								<code class="ibwp-copy-clipboard">{email}</code> - <span class="description"><?php _e('Display user email address.', 'inboundwp-lite'); ?></span><br/>
								<code class="ibwp-copy-clipboard">{phone}</code> - <span class="description"><?php _e('Display user phone number.', 'inboundwp-lite'); ?></span>
							</div>
						</td>
					</tr>

					<tr class="ibwp-pro-feature">
						<td colspan="2" class="ibep-no-padding">
							<table class="form-table">
								<tr>
									<th colspan="2">
										<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Notification Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div><br/>
										<div class="ibwp-info ibwp-no-margin"><?php _e('This is particular segment email notification. You can enable global notification from notification tab if you have common email content.', 'inboundwp-lite'); ?></div>
									</th>
								</tr>

								<tr>
									<th>
										<label for="ibwp-spw-email-type-1"><?php _e('Email Type', 'inboundwp-lite'); ?></label>
									</th>
									<td>
										<select name="" class="ibwp-select ibwp-spw-email-type" id="ibwp-spw-email-type-1" disabled>
											<option value=""><?php esc_html_e('Global Email', 'inboundwp-lite'); ?></option>
											<option value=""><?php esc_html_e('Segment Email', 'inboundwp-lite'); ?></option>
											<option value=""><?php esc_html_e('No Email', 'inboundwp-lite'); ?></option>
										</select><br/>
										<span class="description"><?php _e('Select email notification type. 3 types of email type.', 'inboundwp-lite'); ?></span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><!-- end .ibwp-spw-segment-row-inr -->
</script><!-- end .tmpl-ibwp-segment-tmpl -->