<?php
/**
 * Handles Advance Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Global variable
global $wp_roles;

// Taking some variable
$show_for_data	= ibwpl_show_for_options();
$advance		= get_post_meta( $post->ID, $prefix.'advance', true );
$show_credit	= ! empty( $advance['show_credit'] )	? 1	: 0;
$mobile_disable	= ! empty( $advance['mobile_disable'] )	? 1	: 0;
?>

<div id="ibwp_sp_advance_sett" class="ibwp-vtab-cnt ibwp-sp-advance-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Advance Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Social Proof advance settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-sp-show-credit"><?php _e('Show Credit', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[show_credit]" value="1" <?php checked( $show_credit, 1 ); ?> class="ibwp-checkbox ibwp-sp-show-credit" id="ibwp-sp-show-credit" /><br/>
					<span class="description"><?php _e('Check this box to show credit of our work A huge thanks in advance :)', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-mob-enable"><?php _e('Disable on Mobile', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>advance[mobile_disable]" value="1" <?php checked( $mobile_disable, 1 ); ?> id="ibwp-sp-mob-enable" class="ibwp-checkbox ibwp-sp-mob-enable" /><br/>
					<span class="description"><?php _e('Check this box if you want to disable social proof on mobile device.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-sp-show-for"><?php _e('Show For', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-show-hide ibwp-sp-show-for" id="ibwp-sp-show-for" disabled />
						<?php foreach ( $show_for_data as $show_for_key => $show_for_val ) { ?>
							<option value=""><?php echo $show_for_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php _e('Choose Social Proof visibility for users.', 'inboundwp-lite'); ?></span>
					<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-sp-cache-duration"><?php _e('Cache Duration', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" id="ibwp-sp-cache-duration" class="ibwp-checkbox ibwp-sp-cache-duration" disabled /> <?php _e('Minutes', 'inboundwp-lite'); ?><br/>
					<span class="description"><?php _e('Enter cache duration. Minimum value should not be less than 5 minutes.', 'inboundwp-lite'); ?></span>
					<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-sp-advance-sett -->