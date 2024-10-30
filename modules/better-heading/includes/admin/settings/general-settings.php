<?php
/**
 * General Settings
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$reg_post_types	= ibwpl_get_post_types( null, array('attachment', 'revision', 'nav_menu_item') );
$post_types		= ibwpl_bh_get_option( 'post_types', array() );
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
					<th scope="row">
						<label for="ibwp-bh-post-types"><?php _e('Post Types', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<?php if( ! empty( $reg_post_types ) ) {
							foreach ( $reg_post_types as $post_key => $post_label ) {
						?>
							<div class="<?php if( $post_key != 'post' ) { echo 'ibwp-pro-feature'; } ?>">
								<label>
									<input type="checkbox" value="<?php echo ibwpl_esc_attr( $post_key ); ?>" name="ibwp_bh_options[post_types][]" <?php checked( in_array( $post_key, $post_types ), true ); ?> <?php if( $post_key != 'post' ) { echo 'disabled'; } ?>  />
									<?php echo $post_label; ?>
								</label>
							</div>
							<?php }
						} ?>
						<br/><span class="description"><?php _e('Check these boxes to enable Better Heading for posts. Better Heading box will be added for posts and you can add titles from there.', 'inboundwp-lite'); ?></span><br/>
						<span class="description ibwp-pro-feature"><?php echo __('If you want to more post types. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
					</td>
				</tr>

				<tr>
					<td colspan="2" scope="row">
						<input type="submit" name="ibwp_bh_sett_submit" class="button button-primary right ibwp-btn ibwp-bh-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->