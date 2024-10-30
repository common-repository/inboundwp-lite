<?php
/**
 * General Settings
 *
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$global_location			= ibwpl_display_locations();
$reg_post_types				= ibwpl_get_post_types( null, array('attachment', 'revision', 'nav_menu_item') );
$post_types					= ibwpl_sp_get_option( 'post_types', array() );
$notification				= ibwpl_sp_get_option( 'notification' );
$notification_display_in	= ibwpl_sp_get_option( 'notification_display_in', array() );

// Getting Some Data
$notification_post 	= ( ! empty( $notification ) ) ? get_post( $notification )	: '';
$notification_title	= ! empty( $notification_post->post_title ) ? $notification_post->post_title	: __('Post', 'inboundwp-lite');
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
						<label for="ibwp-sp-enable"><?php _e('Enable', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="checkbox" name="ibwp_sp_options[enable]" value="1" <?php checked( ibwpl_sp_get_option('enable'), 1 ); ?> id="ibwp-sp-enable" class="ibwp-checkbox ibwp-sp-enable" /><br/>
						<span class="description"><?php _e('Check this box if you want to enable social proof.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr>
					<th>
						<label for="ibwp-sp-type"><?php _e('Post Types', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $reg_post_types ) ) {
							foreach ( $reg_post_types as $post_key => $post_label ) {
						?>
							<div class="ibwp-loop-irow">
								<label>
									<input type="checkbox" value="<?php echo ibwpl_esc_attr( $post_key ); ?>" name="ibwp_sp_options[post_types][]" <?php checked( in_array( $post_key, $post_types ), true ); ?>  />
									<?php echo $post_label; ?>
								</label>
							</div>
							<?php }
						} ?>
						<br/><span class="description"><?php _e('Check these boxes if you want to show different social proof for individual posts and pages. This will enable the setting box at enabled post types.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr>
					<th colspan="2"><div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php esc_html_e('Social Proof Settings', 'inboundwp-lite'); ?></div></th>
				</tr>
				<tr>
					<th>
						<label for="ibwp-sp-notification"><?php _e('Social Proof', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<select name="ibwp_sp_options[notification]" id="ibwp-sp-notification" class="ibwp-select2 ibwp-post-title-sugg ibwp-sp-notification" data-placeholder="<?php esc_html_e('Select Social Proof', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_SP_POST_TYPE; ?>">
							<option></option>
							<?php if( $notification_post ) { ?>
							<option value="<?php echo ibwpl_esc_attr( $notification_post->ID ); ?>" selected="selected"><?php echo $notification_title ." - (#{$notification_post->ID})"; ?></option>
							<?php } ?>
						</select><br/>
						<span class="description"><?php _e('Select Social Proof to display globally. You can search Social Proof by its name or ID.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="ibwp-sp-noti-displayin"><?php _e('Display In', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $global_location ) ) {
							foreach ( $global_location as $global_location_key => $global_location_val ) { ?>
								<div class="ibwp-loop-irow">
									<label>
										<input type="checkbox" name="ibwp_sp_options[notification_display_in][<?php echo $global_location_key; ?>]" class="ibwp-checkbox ibwp-sp-noti-gbl-locs" value="1" <?php checked( array_key_exists( $global_location_key, $notification_display_in ), true ); ?> />
										<?php echo $global_location_val; ?>
									</label>
								</div>
							<?php }
						} ?>
						<br/>
						<span class="description"><?php _e('Check this box to display Social Proof globally. You can still choose the conversion for single posts and pages.', 'inboundwp-lite'); ?></span>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_sp_settings_submit" class="button button-primary right ibwp-btn ibwp-sp-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->