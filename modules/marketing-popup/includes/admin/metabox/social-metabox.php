<?php
/**
 * Handles Social Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$social_data	= ibwpl_mp_social_options();
$social			= get_post_meta( $post->ID, $prefix.'social', true );
$social_arr		= ! empty( $social['social_traffic'] ) ? $social['social_traffic'] : array( 0 => '' );
?>

<div id="ibwp_mp_social_sett" class="ibwp-vtab-cnt ibwp-mp-social-sett ibwp-clearfix">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Social Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Set various popup social settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl ibwp-mp-tbl ibwp-post-mp-table">
		<tbody>
			<?php foreach ( $social_arr as $social_key => $social_val ) {

				$social_name	= isset( $social_arr[$social_key]['name'] ) ? $social_arr[$social_key]['name'] : '';
				$social_link	= isset( $social_arr[$social_key]['link'] ) ? $social_arr[$social_key]['link'] : '';
			?>
				<tr class="ibwp-mp-social-title-row" data-key="<?php echo $social_key; ?>">
					<td>
						<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>social[social_traffic][<?php echo $social_key; ?>][name]" class="ibwp-select ibwp-mp-social-name" id="ibwp-mp-social-name-<?php echo $social_key; ?>">
							<?php foreach ( $social_data as $social_data_key => $social_data_val ) { ?>
								<option value="<?php echo ibwpl_esc_attr( $social_data_key ); ?>" <?php selected( $social_name, $social_data_key ); ?>><?php echo $social_data_val; ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>social[social_traffic][<?php echo $social_key; ?>][link]" value="<?php echo esc_url( $social_link ); ?>" class="ibwp-text large-text ibwp-mp-social-link" />
					</td>
					<td>
						<span class="ibwp-action-btn ibwp-action-add-btn ibwp-mp-add-social-row" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
						<span class="ibwp-action-btn ibwp-action-del-btn ibwp-mp-del-social-row" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>