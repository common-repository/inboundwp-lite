<?php
/**
 * General Settings
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$display_locations	= ibwpl_display_locations();
$btn_position		= ibwpl_wtcs_get_option( 'btn_position' );
$btn_style			= ibwpl_wtcs_get_option( 'btn_style', 'style-1' );
$chatbox_glob_locs	= ibwpl_wtcs_get_option( 'chatbox_glob_locs', array() );
?>

<div class="postbox">

	<button class="handlediv button-link" type="button"><span class="toggle-indicator"></span></button>

	<h3 class="hndle">
		<span><?php esc_html_e( 'General Settings', 'inboundwp-lite' ); ?></span>
	</h3>

	<div class="inside">
		<table class="form-table ibwp-tbl">
			<tbody>
				<tr>
					<td colspan="2" class="ibwp-no-padding">
						<div class="ibwp-info ibwp-no-margin"><i class="dashicons dashicons-warning"></i> <?php echo __("InboundWP Lite supports 3 maximum agents. ". ibwpl_upgrade_pro_link() ." for unlimited agents.", 'inboundwp-lite'); ?></div>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-enable"><?php _e('Enable', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="ibwp_wtcs_options[enable]" id="ibwp-wtcs-enable" class="ibwp-checkbox ibwp-wtcs-enable" value="1" <?php checked( ibwpl_wtcs_get_option('enable'), 1 ); ?> /><br/>
						<span class="description"><?php _e('Check this checkbox if you want to enable chatbox on front end.','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-mob-enable"><?php _e('Display on Mobile', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="ibwp_wtcs_options[mobile_enable]" id="ibwp-wtcs-mob-enable" class="ibwp-checkbox ibwp-wtcs-mob-enable" value="1" <?php checked( ibwpl_wtcs_get_option('mobile_enable'), 1 ); ?> /><br/>
						<span class="description"><?php _e('Check this checkbox if you want to enable chatbox toggle on mobile device.','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ibwp-wtcs-chatbox-glob-locs"><?php _e('Global Locations', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $display_locations ) ) {
							foreach ( $display_locations as $location_key => $location_val ) { ?>
								<div class="ibwp-loop-irow">
									<label>
										<input type="checkbox" name="ibwp_wtcs_options[chatbox_glob_locs][<?php echo $location_key; ?>]" class="ibwp-checkbox ibwp-wtcs-chatbox-glob-locs" value="1" <?php if( array_key_exists($location_key, $chatbox_glob_locs ) ) { checked( true ); } ?> />
										<?php echo $location_val; ?>
									</label>
								</div>
						<?php } } ?>
						<br/>
						<span class="description"><?php _e('Check these boxes to enable chatbox on various locations.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-toggle-btn-pos"><?php _e('Chat Toggle Position', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="ibwp_wtcs_options[btn_position]" class="ibwp-select ibwp-wtcs-toggle-btn-pos" id="ibwp-wtcs-toggle-btn-pos">
							<option value="bottom-right" <?php selected( $btn_position, 'bottom-right' ); ?>><?php esc_html_e( 'Bottom Right', 'inboundwp-lite'); ?></option>
							<option value="bottom-left" <?php selected( $btn_position, 'bottom-left' ); ?>><?php esc_html_e( 'Bottom Left', 'inboundwp-lite'); ?></option>
							<option value="middle-left" <?php selected( $btn_position, 'middle-left' ); ?>><?php esc_html_e( 'Middle Left', 'inboundwp-lite'); ?></option>
							<option value="middle-right" <?php selected( $btn_position, 'middle-right' ); ?>><?php esc_html_e( 'Middle Right', 'inboundwp-lite'); ?></option>
						</select><br/>
						<span class="description"><?php _e('Select chat toggle display position.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-toggle-btn-style"><?php _e('Chatbox Style', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="ibwp_wtcs_options[btn_style]" class="ibwp-select ibwp-wtcs-toggle-btn-style" id="ibwp-wtcs-toggle-btn-style">
							<option value="style-1" <?php selected( $btn_style, 'style-1' ); ?>><?php esc_html_e( 'Style 1', 'inboundwp-lite' ); ?></option>
							<option value="style-2" <?php selected( $btn_style, 'style-2' ); ?>><?php esc_html_e( 'Style 2', 'inboundwp-lite' ); ?></option>
						</select><br/>
						<span class="description"><?php _e('Select chatbox display style.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr class="ibwp-pro-feature">
					<th>
						<label for="ibwp-wtcs-hide-locs"><?php _e('Hide on Locations', 'inboundwp-lite'); ?></label>
					</th>
					<td class="ibwp-disabled-field">
						<textarea name="" id="ibwp-wtcs-hide-locs" class="large-text ibwp-textarea ibwp-wtcs-hide-locs"></textarea><br/>
						<span class="description"><?php echo __('Enter one location (URL) fragment per line. Use * character as a wildcard. Example: category/peace/* to target all matching URLs. ','inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
					</td>
				</tr>
				<tr class="ibwp-pro-feature">
					<th>
						<label for="ibwp-wtcs-agent-orderby"><?php _e('Agent Order By', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="" class="ibwp-select ibwp-wtcs-agent-orderby" id="ibwp-wtcs-agent-orderby" disabled>
							<option value=""><?php esc_html_e( 'Post Date', 'inboundwp-lite'); ?></option>
							<option value=""><?php esc_html_e( 'Post ID', 'inboundwp-lite'); ?></option>
							<option value=""><?php esc_html_e( 'Post Title', 'inboundwp-lite'); ?></option>
							<option value=""><?php esc_html_e( 'Post Modified Date', 'inboundwp-lite'); ?></option>
							<option value=""><?php esc_html_e( 'Random', 'inboundwp-lite'); ?></option>
							<option value=""><?php esc_html_e( 'Menu Order (Sort Order)', 'inboundwp-lite'); ?></option>
						</select><br/>
						<span class="description"><?php echo __('Choose agent display orderby. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
					</td>
				</tr>
				<tr class="ibwp-pro-feature">
					<th>
						<label for="ibwp-wtcs-agent-order"><?php _e('Agent Order', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="" class="ibwp-select ibwp-wtcs-agent-order" id="ibwp-wtcs-agent-order" disabled>
							<option value=""><?php esc_html_e( 'Descending', 'inboundwp-lite'); ?></option>
							<option value=""><?php esc_html_e( 'Ascending', 'inboundwp-lite'); ?></option>
						</select><br/>
						<span class="description"><?php echo __('Choose agent display order. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
					</td>
				</tr>
				<tr class="ibwp-pro-feature">
					<th>
						<label for="ibwp-wtcs-agent-cat"><?php _e('Departments', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="" class="ibwp-select2 ibwp-select2-mul ibwp-wtcs-agent-cat" id="ibwp-wtcs-agent-cat" data-placeholder="<?php esc_html_e('Select Departments', 'inboundwp-lite'); ?>" multiple="multiple" disabled>
							<option></option>
						</select><br/>
						<span class="description"><?php echo __('Select departments to display agents. ','inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
					</td>
				</tr>

				<tr>
					<th colspan="2">
						<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Chatbox Text Settings', 'inboundwp-lite'); ?></div>
					</th>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-main-title"><?php _e('Main Title', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" class="large-text ibwp-text ibwp-wtcs-main-title" id="ibwp-wtcs-main-title" name="ibwp_wtcs_options[main_title]" value="<?php echo ibwpl_esc_attr( ibwpl_wtcs_get_option('main_title') ); ?>" /><br/>
						<span class="description"><?php _e('Enter chatbox heading main title. e.g. Start a Conversation','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-sub-title"><?php _e('Sub Title', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="ibwp_wtcs_options[sub_title]" class="large-text ibwp-text ibwp-wtcs-sub-title" id="ibwp-wtcs-sub-title" value="<?php echo ibwpl_esc_attr( ibwpl_wtcs_get_option('sub_title') ); ?>" /><br/>
						<span class="description"><?php _e('Enter chatbox heading sub title. e.g. Hi! Click one of our members below to chat on WhatsApp','inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-notice"><?php _e('Notice Message', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="ibwp_wtcs_options[notice]" class="large-text ibwp-text ibwp-wtcs-notice" id="ibwp-wtcs-notice" value="<?php echo ibwpl_esc_attr( ibwpl_wtcs_get_option('notice') ); ?>" /><br/>
						<span class="description"><?php _e('Enter chatbox notice message. e.g. The team typically replies in a few minutes.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-wtcs-toggle-text"><?php _e('Toggle Button Text', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="ibwp_wtcs_options[toggle_text]" class="large-text ibwp-text ibwp-wtcs-toggle-text" id="ibwp-wtcs-toggle-text" value="<?php echo ibwpl_esc_attr( ibwpl_wtcs_get_option('toggle_text') ); ?>" /><br/>
						<span class="description"><?php _e('Enter chatbox toggle button text. e.g. Need Help? Chat with us.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr class="ibwp-pro-feature">
					<td colspan="2" class="ibwp-no-padding">
						<table class="form-table">
							<tr>
								<th colspan="2">
									<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Chatbox Design Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
								</th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-wtcs-chatbox-bg"><?php _e('Chatbox Background Color', 'inboundwp-lite'); ?></label>
								</th>
								<td class="ibwp-disabled-field">
									<input type="text" name="" value="" class="ibwp-colorpicker ibwp-wtcs-chatbox-bg" id="ibwp-wtcs-chatbox-bg" disabled /><br/>
									<span class="description"><?php _e('Select chatbox background color.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-wtcs-chatbox-header-bg"><?php _e('Header Background Color', 'inboundwp-lite'); ?></label>
								</th>
								<td class="ibwp-disabled-field">
									<input type="text" name="" value="" class="ibwp-colorpicker ibwp-wtcs-chatbox-header-bg" id="ibwp-wtcs-chatbox-header-bg" disabled /><br/>
									<span class="description"><?php _e('Select chatbox header background color.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-wtcs-online-brd-clr"><?php _e('Online Agent Border Color', 'inboundwp-lite'); ?></label>
								</th>
								<td class="ibwp-disabled-field">
									<input type="text" name="" value="" class="ibwp-colorpicker ibwp-wtcs-online-brd-clr" id="ibwp-wtcs-online-brd-clr" disabled /><br/>
									<span class="description"><?php _e('Select online agent border color.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-wtcs-offline-brd-clr"><?php _e('Offline Agent Border Color', 'inboundwp-lite'); ?></label>
								</th>
								<td class="ibwp-disabled-field">
									<input type="text" name="" value="" class="ibwp-colorpicker ibwp-wtcs-offline-brd-clr" id="ibwp-wtcs-offline-brd-clr" disabled /><br/>
									<span class="description"><?php _e('Select offline agent border color.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-wtcs-toggle-bg"><?php _e('Toggle Button Background Color', 'inboundwp-lite'); ?></label>
								</th>
								<td class="ibwp-disabled-field">
									<input type="text" name="" value="" class="ibwp-colorpicker ibwp-wtcs-toggle-bg" id="ibwp-wtcs-toggle-bg" disabled /><br/>
									<span class="description"><?php _e('Select toggle button background color.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_wtcs_sett_submit" class="button button-primary right ibwp-btn ibwp-wtcs-general-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->