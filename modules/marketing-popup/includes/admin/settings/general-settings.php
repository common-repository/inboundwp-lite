<?php
/**
 * General Settings
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$global_location	= ibwpl_display_locations();
$reg_post_types		= ibwpl_get_post_types( null, array('attachment', 'revision', 'nav_menu_item') );
$cookie_prefix		= ibwpl_mp_get_option( 'cookie_prefix' );
$post_types			= ibwpl_mp_get_option( 'post_types', array() );
$welcome_popup		= ibwpl_mp_get_option( 'welcome_popup' );
$welcome_display_in	= ibwpl_mp_get_option( 'welcome_display_in', array() );

// Getting Some Data
$welcome_popup_post 	= ( ! empty( $welcome_popup ) )					? get_post( $welcome_popup )		: '';
$welcome_popup_title	= ! empty( $welcome_popup_post->post_title )	? $welcome_popup_post->post_title	: __('Post', 'inboundwp-lite');
?>

<div class="postbox ibwp-no-toggle">

	<h3 class="hndle">
		<span><?php esc_html_e( 'General Settings', 'inboundwp-lite' ); ?></span>
	</h3>

	<div class="inside">
		<table class="form-table ibwp-tbl">
			<tbody>
				<tr>
					<th>
						<label for="ibwp-mp-enable"><?php _e('Enable', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="ibwp_mp_options[enable]" value="1" <?php checked( ibwpl_mp_get_option('enable'), 1 ); ?> id="ibwp-mp-enable" class="ibwp-checkbox ibwp-mp-enable" /><br/>
						<span class="description"><?php _e('Check this box if you want to enable popup.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr>
					<th>
						<label for="ibwp-mp-cookie-prefix"><?php _e('Cookie Prefix', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="ibwp_mp_options[cookie_prefix]" value="<?php echo ibwpl_esc_attr( $cookie_prefix ); ?>" id="ibwp-mp-cookie-prefix" class="ibwp-text ibwp-mp-cookie-prefix"><br/>
						<span class="description"><?php _e('Enter cookie prefix. Changing the value will display the cookie based popup again. Default cookie prefix is "ibwp_mp_".', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr>
					<th>
						<label for="ibwp-mp-type"><?php _e('Post Types', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $reg_post_types ) ) {
							foreach ( $reg_post_types as $post_key => $post_label ) {
						?>
							<div class="ibwp-loop-irow">
								<label>
									<input type="checkbox" value="<?php echo ibwpl_esc_attr( $post_key ); ?>" name="ibwp_mp_options[post_types][]" <?php checked( in_array( $post_key, $post_types ), true ); ?>  />
									<?php echo $post_label; ?>
								</label>
							</div>
							<?php }
						} ?>
						<br/><span class="description"><?php _e('Check these boxes if you want to show different popups for individual posts and pages. This will enable the setting box at enabled post types.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<!-- Start - Welcome Popup Settings -->
				<tr>
					<th colspan="2"><div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php esc_html_e('Welcome Popup Settings', 'inboundwp-lite'); ?></div></th>
				</tr>
				<tr>
					<th>
						<label for="ibwp-mp-welcome-popup"><?php _e('Welcome Popup', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="ibwp_mp_options[welcome_popup]" id="ibwp-mp-welcome-popup" class="ibwp-select2 ibwp-post-title-sugg ibwp-mp-welcome-popup" data-placeholder="<?php esc_html_e('Select Welcome Popup', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_MP_POST_TYPE; ?>">
							<option></option>
							<?php if( $welcome_popup_post ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $welcome_popup_post->ID ); ?>" selected="selected"><?php echo $welcome_popup_title ." - (#{$welcome_popup_post->ID})"; ?></option>
							<?php } ?>
						</select><br/>
						<span class="description"><?php _e('Select welcome popup to display globally. You can search popup by its name or ID.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-mp-wel-displayin"><?php _e('Display In', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $global_location ) ) {
							foreach ( $global_location as $global_location_key => $global_location_val ) { ?>
								<div class="ibwp-loop-irow">
									<label>
										<input type="checkbox" name="ibwp_mp_options[welcome_display_in][<?php echo $global_location_key; ?>]" class="ibwp-checkbox ibwp-mp-wel-gbl-locs" value="1" <?php checked( array_key_exists( $global_location_key, $welcome_display_in ), true ); ?> />
										<?php echo $global_location_val; ?>
									</label>
								</div>
							<?php }
						} ?>
						<br/>
						<span class="description"><?php _e('Check this box to display welcome popup globally. You can still choose the popup for single posts and pages.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<!-- End - Welcome Popup Settings -->

				<!-- Start - Exit Popup Settings -->
				<tr class="ibwp-pro-feature">
					<td colspan="2" class="ibwp-no-padding">
						<table class="form-table">
							<tr>
								<th colspan="2"><div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo esc_html__('Exit Popup Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div></th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-exit-popup"><?php _e('Exit Popup', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<select name="" id="ibwp-mp-exit-popup" class="ibwp-select2 ibwp-mp-exit-popup" data-placeholder="<?php esc_html_e('Select Exit Popup', 'inboundwp-lite'); ?>" disabled >
										<option></option>
									</select><br/>
									<span class="description"><?php _e('Select exit popup to display globally. You can search popup by its name or ID.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-exit-displayin"><?php _e('Display In', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<?php if( ! empty( $global_location ) ) {
										foreach ( $global_location as $global_location_key => $global_location_val ) { ?>
											<div class="ibwp-loop-irow">
											<label>
												<input type="checkbox" name="" class="ibwp-checkbox ibwp-mp-exit-gbl-locs" disabled />
												<?php echo $global_location_val; ?>
											</label>
											</div>
										<?php }
									} ?>
									<br/>
									<span class="description"><?php _e('Check this box to display exit popup globally. You can still choose the popup for single posts and pages.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- End - Exit Popup Settings -->

				<!-- Start - HTML Element Popup Settings -->
				<tr class="ibwp-pro-feature">
					<td colspan="2" class="ibwp-no-padding">
						<table class="form-table">
							<tr>
								<th colspan="2"><div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo esc_html__('HTML Element Popup Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div></th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-html-popup"><?php _e('HTML Element Popup', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<select name="" id="ibwp-mp-html-popup" class="ibwp-select2 ibwp-mp-html-popup" data-placeholder="<?php esc_html_e('Select HTML Element Popup', 'inboundwp-lite'); ?>" disabled >
										<option></option>
									</select><br/>
									<span class="description"><?php _e('Select HTML popup to display globally. You can search popup by its name or ID.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-mp-html-displayin"><?php _e('Display In', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<?php if( ! empty( $global_location ) ) {
										foreach ( $global_location as $global_location_key => $global_location_val ) { ?>
											<div class="ibwp-loop-irow">
											<label>
												<input type="checkbox" name="" class="ibwp-checkbox ibwp-mp-html-gbl-locs" disabled />
												<?php echo $global_location_val; ?>
											</label>
											</div>
										<?php }
									} ?>
									<br/>
									<span class="description"><?php _e('Check this box to display HTML popup globally. You can still choose the popup for single posts and pages.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- End - HTML Element Popup Settings -->

				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_mp_settings_submit" class="button button-primary right ibwp-btn ibwp-mp-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->