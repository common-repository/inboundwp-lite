<?php
/**
 * Handles Behaviour Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$wheel_appear_data	= ibwpl_when_appear_options();
$behaviour			= get_post_meta( $post->ID, $prefix.'behaviour', true );

// Taking some data
$wheel_speed		= ! empty( $behaviour['wheel_speed'] ) 		? $behaviour['wheel_speed']			: 3;
$wheel_spin_dur		= ! empty( $behaviour['wheel_spin_dur'] ) 	? $behaviour['wheel_spin_dur']		: 5;
$open_delay			= isset( $behaviour['open_delay'] ) 		? $behaviour['open_delay']			: '';
$hide_close			= ! empty( $behaviour['hide_close'] )		? 1									: 0;
$clsonesc			= ! empty( $behaviour['clsonesc'] )			? 1									: 0;
?>

<div id="ibwp_spw_behaviour_sett" class="ibwp-vtab-cnt ibwp-spw-behaviour-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Behaviour Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Spin Wheel behaviour settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-spw-wheel-speed"><?php _e('Wheel Speed', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[wheel_speed]" value="<?php echo ibwpl_esc_attr( $wheel_speed ); ?>" class="ibwp-text ibwp-spw-wheel-speed" id="ibwp-spw-wheel-speed" /> <?php _e('Sec', 'inboundwp-lite'); ?><br />
					<span class="description"><?php _e('Enter no of rotation for wheel speed in a second. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-spining-dur"><?php _e('Wheel Spining Duration', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[wheel_spin_dur]" value="<?php echo ibwpl_esc_attr( $wheel_spin_dur ); ?>" class="ibwp-text ibwp-spw-spining-dur" id="ibwp-spw-spining-dur" /> <?php _e('Sec', 'inboundwp-lite'); ?><br />
					<span class="description"><?php _e('Enter no of second to rotate a spin wheel. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
				</td>
			</tr>

			<tr>
				<th colspan="3">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Spin Wheel Display', 'inboundwp-lite'); ?></div>
				</th>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-delay"><?php _e('Wheel Delay', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[open_delay]" value="<?php echo ibwpl_esc_attr( $open_delay ); ?>" class="ibwp-text ibwp-spw-delay" id="ibwp-spw-delay" min="0"> <?php _e('Sec', 'inboundwp-lite'); ?><br />
					<span class="description"><?php _e('Enter no of second to open spin wheel. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-hide-close-btn"><?php _e('Hide Close Button', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[hide_close]" value="1" <?php checked( $hide_close, 1 ); ?> class="ibwp-checkbox ibwp-spw-hide-close-btn" id="ibwp-spw-hide-close-btn" /><br />
					<span class="description"><?php _e('Check this box if you want to hide the close button of popup.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-spw-clsonesc"><?php _e('Close Popup On Esc', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[clsonesc]" value="1" <?php checked( $clsonesc, 1 ); ?> class="ibwp-checkbox ibwp-spw-clsonesc" id="ibwp-spw-clsonesc" /><br />
					<span class="description"><?php _e('Check this box if you want to close the popup on esc key.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-spin wheel-appear"><?php _e('When Wheel Appear?', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-spw-spin wheel-appear" id="ibwp-spw-spin wheel-appear" disabled>
						<?php if( ! empty( $wheel_appear_data ) ) {
							foreach ( $wheel_appear_data as $wheel_appear_key => $wheel_appear_val ) { ?>
								<option value=""><?php echo $wheel_appear_val; ?></option>
							<?php }
						} ?>
					</select><br/>
					<span class="description"><?php echo __('Choose when spin wheel should come. 6 types of popup appear. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-disappear"><?php _e('Wheel Disappear', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" class="ibwp-text ibwp-spw-disappear" id="ibwp-spw-disappear" disabled /> <?php _e('Sec', 'inboundwp-lite'); ?><br />
					<span class="description"><?php _e('Enter no of second to hide spin wheel after open. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
					<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-spw-hide-overlay"><?php _e('Hide Overlay', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-spw-hide-overlay" id="ibwp-spw-hide-overlay" disabled /><br />
					<span class="description"><?php _e('Check this box if you do not want to display popup ovarlay.', 'inboundwp-lite'); ?></span>
					<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-spw-behaviour-sett -->