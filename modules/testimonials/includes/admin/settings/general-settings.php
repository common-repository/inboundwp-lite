<?php
/**
 * General Settings
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$default_img = ibwpl_tm_get_option('default_img');
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
						<label for="ibwp-tm-default-img"><?php _e('Default Featured Image', 'inboundwp-lite'); ?></label>
					</th>
					<td>
						<input type="text" name="wtwp_pro_options[default_img]" value="<?php echo esc_url( ibwpl_tm_get_option('default_img') ); ?>" id="ibwp-tm-default-img" class="ibwp-url regular-text ibwp-tm-default-img ibwp-img-upload-input" />
						<input type="button" name="wtwp_pro_default_img" class="button-secondary ibwp-image-upload" value="<?php esc_html_e( 'Upload Image', 'inboundwp-lite'); ?>" />
						<input type="button" name="wtwp_pro_default_img_clear" id="ibwp-tm-default-img-clear" class="button button-secondary ibwp-image-clear" value="<?php esc_html_e( 'Clear', 'inboundwp-lite'); ?>" /> <br />
						<span class="description"><?php _e( 'Upload default featured image or provide an external URL of image. If your testimonial does not have image then this will be displayed instead blank box.', 'inboundwp-lite' ); ?></span>
						<?php
							$default_img_html = '';
							if( $default_img ) {
								$default_img_html = '<img src="'.esc_url( $default_img ).'" alt="" />';
							}
						?>
						<div class="ibwp-img-view"><?php echo $default_img_html; ?></div>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<input type="submit" name="ibwp_tm_sett_submit" class="button button-primary right ibwp-btn ibwp-tm-general-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- end .inside -->
</div><!-- end .postbox -->