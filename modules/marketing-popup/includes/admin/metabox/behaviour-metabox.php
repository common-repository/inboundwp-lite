<?php
/**
 * Handles Behaviour Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$popup_appear_data	= ibwpl_when_appear_options();
$popup_goals		= ibwpl_mp_popup_goals();
$popup_types		= ibwpl_mp_popup_types();
$behaviour			= get_post_meta( $post->ID, $prefix.'behaviour', true );

// Taking some data
$open_delay			= isset( $behaviour['open_delay'] ) 	? $behaviour['open_delay']	: '';
$hide_close			= !empty( $behaviour['hide_close'] )	? 1							: 0;
$clsonesc			= !empty( $behaviour['clsonesc'] )		? 1							: 0;
?>
<div id="ibwp_mp_behaviour_sett" class="ibwp-vtab-cnt ibwp-mp-behaviour-sett ibwp-clearfix">
	
	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Behaviour Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Popup behaviour settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<td colspan="3" class="ibwp-no-lr-padding">
					<div class="ibwp-row ibwp-icolumns-wrap ibwp-columns-margin">
						<?php
						if( ! empty( $popup_goals ) ) {
							foreach ($popup_goals as $popup_goal_key => $popup_goal_val) {

								$name = isset( $popup_goal_val['name'] ) ? $popup_goal_val['name'] : $popup_goal_key;
								$icon = isset( $popup_goal_val['icon'] ) ? $popup_goal_val['icon'] : 'dashicons dashicons-admin-generic';
						?>
								<label class="ibwp-mp-behav-box-wrp ibwp-mp-goal-wrap ibwp-icolumns ibwp-medium-4">
									<input type="radio" name="<?php echo ibwpl_esc_attr($prefix); ?>popup_goal" value="<?php echo ibwpl_esc_attr( $popup_goal_key ); ?>" class="ibwp-radio ibwp-show-hide ibwp-mp-goal-input" <?php checked( $popup_goal, $popup_goal_key ); ?> data-prefix="goal" />
									<span class="ibwp-mp-behav-block ibwp-mp-goal-block">
										<i class="<?php echo $icon; ?>"></i>
										<span class="ibwp-mp-behav-title"><?php echo $name; ?></span>
									</span>
								</label>
						<?php
							}
						}
						?>
					</div>
				</td>
			</tr>

			<tr>
				<th colspan="3">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Popup Type', 'inboundwp-lite'); ?></div>
				</th>
			</tr>
			<tr>
				<td colspan="3" class="ibwp-no-lr-padding">
					<div class="ibwp-row ibwp-icolumns-wrap ibwp-columns-margin">
						<?php
						if( ! empty( $popup_types ) ) {
							foreach ($popup_types as $popup_type_key => $popup_type_val) {

								$name = isset( $popup_type_val['name'] ) ? $popup_type_val['name'] : $popup_type_key;
								$icon = isset( $popup_type_val['icon'] ) ? $popup_type_val['icon'] : 'dashicons dashicons-admin-generic';
							?>
								<label class="ibwp-mp-behav-box-wrp ibwp-mp-type-main ibwp-icolumns ibwp-medium-4 ibwp-center <?php if( $popup_type_key != 'modal' ) { echo 'ibwp-pro-feature'; } ?>">
									<input type="radio" name="<?php echo ibwpl_esc_attr($prefix); ?>popup_type" value="<?php echo ibwpl_esc_attr( $popup_type_key ); ?>" class="ibwp-radio ibwp-show-hide ibwp-mp-type-input" <?php checked( $popup_type, $popup_type_key ); ?> data-prefix="type" <?php if( $popup_type_key != 'modal' ) { echo 'disabled'; } ?> />
									<span class="ibwp-mp-type-block ibwp-mp-behav-block">
										<i class="<?php echo $icon; ?>"></i>
										<span class="ibwp-mp-behav-title"><?php echo $name; ?></span>
									</span>
									<?php if( $popup_type_key != 'modal' ) { ?>
										<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
									<?php } ?>
								</label>
						<?php
							}
						}
						?>
					</div>
				</td>
			</tr>

			<tr>
				<th colspan="3">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Popup Display', 'inboundwp-lite'); ?></div>
				</th>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-delay"><?php _e('Popup Delay', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[open_delay]" value="<?php echo ibwpl_esc_attr( $open_delay ); ?>" class="ibwp-text ibwp-mp-delay" id="ibwp-mp-delay" min="0"> <?php _e('Sec', 'inboundwp-lite'); ?><br />
					<span class="description"><?php _e('Enter no of second to open popup. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-hide-close-btn"><?php _e('Hide Close Button', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[hide_close]" value="1" <?php checked( $hide_close, 1 ); ?> class="ibwp-checkbox ibwp-mp-hide-close-btn" id="ibwp-mp-hide-close-btn" /><br />
					<span class="description"><?php _e('Check this box if you want to hide the close button of popup.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-mp-clsonesc"><?php _e('Close Popup On Esc', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[clsonesc]" value="1" <?php checked( $clsonesc, 1 ); ?> class="ibwp-checkbox ibwp-mp-clsonesc" id="ibwp-mp-clsonesc" /><br />
					<span class="description"><?php _e('Check this box if you want to close the popup on esc key.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-popup-appear"><?php _e('When Popup Appear?', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-mp-popup-appear" id="ibwp-mp-popup-appear" disabled>
						<?php foreach ( $popup_appear_data as $popup_appear_key => $popup_appear_val ) { ?>
							<option value=""><?php echo $popup_appear_val; ?></option>
						<?php } ?>
					</select><br/>
					<span class="description"><?php echo __('Choose when popup should come. 6 types of popup appear. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-disappear"><?php _e('Popup Disappear', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" class="ibwp-text ibwp-mp-disappear" id="ibwp-mp-disappear" disabled /> <?php _e('Sec', 'inboundwp-lite'); ?><br />
					<span class="description"><?php echo __('Enter no of second to hide popup after open. 60 Sec = 1 Min ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-mp-hide-overlay"><?php _e('Hide Overlay', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="" class="ibwp-checkbox ibwp-mp-hide-overlay" id="ibwp-mp-hide-overlay" disabled /><br />
					<span class="description"><?php echo __('Check this box if you do not want to display popup ovarlay. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-mp-behaviour-sett -->