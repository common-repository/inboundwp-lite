<?php
/**
 * General Settings
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$global_location	= ibwpl_display_locations();
$reg_post_types		= ibwpl_get_post_types( null, array('attachment', 'revision', 'nav_menu_item') );
$cookie_prefix		= ibwpl_spw_get_option( 'cookie_prefix' );
$post_types			= ibwpl_spw_get_option( 'post_types', array() );
$welcome_wheel		= ibwpl_spw_get_option( 'welcome_wheel' );
$welcome_display_in	= ibwpl_spw_get_option( 'welcome_display_in', array() );

// Getting Some Data
$welcome_wheel_post 	= ( ! empty( $welcome_wheel ) ) ? get_post( $welcome_wheel )	: '';
$welcome_wheel_title	= ! empty( $welcome_wheel_post->post_title ) ? $welcome_wheel_post->post_title : __('Post', 'inboundwp-lite');
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
						<label for="ibwp-spw-enable"><?php _e('Enable', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="ibwp_spw_options[enable]" value="1" <?php checked( ibwpl_spw_get_option('enable'), 1 ); ?> id="ibwp-spw-enable" class="ibwp-checkbox ibwp-spw-enable" /><br/>
						<span class="description"><?php _e('Check this box if you want to enable spin wheel.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr>
					<th>
						<label for="ibwp-spw-cookie-prefix"><?php _e('Cookie Prefix', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="ibwp_spw_options[cookie_prefix]" value="<?php echo ibwpl_esc_attr( $cookie_prefix ); ?>" id="ibwp-spw-cookie-prefix" class="ibwp-text ibwp-spw-cookie-prefix"><br/>
						<span class="description"><?php _e('Enter cookie prefix. Changing the value will display the cookie based spin wheel again. Default cookie prefix is "ibwp_spw_".', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr>
					<th>
						<label for="ibwp-spw-type"><?php _e('Post Types', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $reg_post_types ) ) {
							foreach ( $reg_post_types as $post_key => $post_label ) {
						?>
							<div class="ibwp-loop-irow">
								<label>
									<input type="checkbox" value="<?php echo ibwpl_esc_attr( $post_key ); ?>" name="ibwp_spw_options[post_types][]" <?php checked( in_array( $post_key, $post_types ), true ); ?>  />
									<?php echo $post_label; ?>
								</label>
							</div>
							<?php }
						} ?>
						<br/><span class="description"><?php _e('Check these boxes if you want to show different spin wheel for individual posts and pages. This will enable the setting box at enabled post types.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<!-- Start - Welcome Spin Wheel Settings -->
				<tr>
					<th colspan="2"><div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php esc_html_e('Welcome Spin Wheel Settings', 'inboundwp-lite'); ?></div></th>
				</tr>
				<tr>
					<th>
						<label for="ibwp-spw-welcome-wheel"><?php _e('Welcome Spin Wheel', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="ibwp_spw_options[welcome_wheel]" id="ibwp-spw-welcome-wheel" class="ibwp-select2 ibwp-post-title-sugg ibwp-spw-welcome-wheel" data-placeholder="<?php esc_html_e('Select Welcome Spin Wheel', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_SPW_POST_TYPE; ?>">
							<option></option>
							<?php if( $welcome_wheel_post ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $welcome_wheel_post->ID ); ?>" selected="selected"><?php echo $welcome_wheel_title ." - (#{$welcome_wheel_post->ID})"; ?></option>
							<?php } ?>
						</select><br/>
						<span class="description"><?php _e('Select welcome spin wheel to display globally. You can search spin wheel by its name or ID.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-spw-wel-displayin"><?php _e('Display In', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $global_location ) ) {
							foreach ( $global_location as $global_location_key => $global_location_val ) { ?>
								<div class="ibwp-loop-irow">
									<label>
										<input type="checkbox" name="ibwp_spw_options[welcome_display_in][<?php echo $global_location_key; ?>]" class="ibwp-checkbox ibwp-spw-wel-gbl-locs" value="1" <?php checked( array_key_exists( $global_location_key, $welcome_display_in ), true ); ?> />
										<?php echo $global_location_val; ?>
									</label>
								</div>
							<?php }
						} ?>
						<br/>
						<span class="description"><?php _e('Check this box to display welcome spin wheel globally. You can still choose the spin wheel for single posts and pages.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<!-- End - Welcome Spin Wheel Settings -->

				<!-- Start - Exit Spin Wheel Settings -->
				<tr class="ibwp-pro-feature">
					<td colspan="2" class="ibwp-no-padding">
						<table class="form-table">
							<tr>
								<th colspan="2"><div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Exit Spin Wheel Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div></th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-spw-exit-wheel"><?php _e('Exit Spin Wheel', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<select name="" id="ibwp-spw-exit-wheel" class="ibwp-select2 ibwp-spw-exit-wheel" data-placeholder="<?php esc_html_e('Select Exit Spin Wheel', 'inboundwp-lite'); ?>" disabled >
										<option></option>
									</select><br/>
									<span class="description"><?php _e('Select exit spin wheel to display globally. You can search spin wheel by its name or ID.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-spw-exit-displayin"><?php _e('Display In', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<?php if( ! empty( $global_location ) ) {
										foreach ( $global_location as $global_location_key => $global_location_val ) { ?>
											<div class="ibwp-loop-irow">
											<label>
												<input type="checkbox" name="" class="ibwp-checkbox ibwp-spw-exit-gbl-locs" value="" disabled />
												<?php echo $global_location_val; ?>
											</label>
											</div>
										<?php }
									} ?>
									<br/>
									<span class="description"><?php _e('Check this box to display exit spin wheel globally. You can still choose the spin wheel for single posts and pages.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- End - Exit Spin Wheel Settings -->

				<!-- Start - HTML Element Spin Wheel Settings -->
				<tr class="ibwp-pro-feature">
					<td colspan="2" class="ibwp-no-padding">
						<table class="form-table">
							<tr>
								<th colspan="2"><div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('HTML Element Spin Wheel Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div></th>
							</tr>
							<tr>
								<th>
									<label for="ibwp-spw-html-wheel"><?php _e('HTML Element Spin Wheel', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<select name="" id="ibwp-spw-html-wheel" class="ibwp-select2 ibwp-spw-html-wheel" data-placeholder="<?php esc_html_e('Select HTML Element Spin Wheel', 'inboundwp-lite'); ?>" disabled >
										<option></option>
									</select><br/>
									<span class="description"><?php _e('Select HTML spin wheel to display globally. You can search spin wheel by its name or ID.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="ibwp-spw-html-displayin"><?php _e('Display In', 'inboundwp-lite'); ?></label>
								</th>
								<td>
									<?php if( ! empty( $global_location ) ) {
										foreach ( $global_location as $global_location_key => $global_location_val ) { ?>
											<div class="ibwp-loop-irow">
											<label>
												<input type="checkbox" name="" class="ibwp-checkbox ibwp-spw-html-gbl-locs" value="" disabled />
												<?php echo $global_location_val; ?>
											</label>
											</div>
										<?php }
									} ?>
									<br/>
									<span class="description"><?php _e('Check this box to display HTML spin wheel globally. You can still choose the spin wheel for single posts and pages.', 'inboundwp-lite'); ?></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- End - HTML Element Spin Wheel Settings -->

				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_spw_settings_submit" class="button button-primary right ibwp-btn ibwp-spw-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->