<?php
/**
 * Handles Behaviour Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$type_data		= ibwpl_sp_type_options();
$source_types	= ibwpl_sp_source_type();
$behaviour		= get_post_meta( $post->ID, $prefix.'behaviour', true );

$initial_delay	= ! empty( $behaviour['initial_delay'] )	? $behaviour['initial_delay']	: 3;
$delay_between	= ! empty( $behaviour['delay_between'] )	? $behaviour['delay_between']	: 6;
$loop			= ! empty( $behaviour['loop'] )				? 1	: 0;
$link_target	= ! empty( $behaviour['link_target'] )		? 1 : 0;
$cls_btn		= ! empty( $behaviour['cls_btn'] )			? 1 : 0;
?>

<div id="ibwp_sp_behaviour_sett" class="ibwp-vtab-cnt ibwp-sp-behaviour-sett ibwp-clearfix">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Behaviour Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Social Proof behaviour settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-sp-type"><?php _e('I would like to display', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>type" class="ibwp-select ibwp-show-hide ibwp-sp-type" id="ibwp-sp-type" data-prefix="spt">
						<?php
						if( ! empty( $type_data ) ) {
							foreach ( $type_data as $type_key => $type_val ) { ?>
								<option value="<?php echo ibwpl_esc_attr( $type_key ); ?>" <?php selected( $type, $type_key ); ?>><?php echo $type_val; ?></option>
						<?php }
						} ?>
					</select><br/>
					<span class="description"><?php _e('Select Social Proof Type.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-source-type"><?php _e('From', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>source_type" class="ibwp-select ibwp-show-hide ibwp-sp-source-type" id="ibwp-sp-source-type">
						<?php if( ! empty( $source_types ) ) {
							foreach ( $source_types as $source_key => $source_val ) { ?>
								<option value="<?php echo ibwpl_esc_attr( $source_key ); ?>" <?php selected( $source_type, $source_key ); ?> <?php if( $source_key == 'wordpress' || $source_key == 'wp-author' || $source_key == 'csv' ) { echo 'disabled'; } ?> ><?php echo $source_val; ?></option>
						<?php }
						}
						?>
					</select><br/>
					<span class="description"><?php _e('Select Social Proof Source Type.', 'inboundwp-lite'); ?></span><br/>
					<span class="description ibwp-pro-feature"><?php echo __('If you want to more source type. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>

			<!-- Start - Timing & Behaviour Settings -->
			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Timing & Behaviour Settings', 'inboundwp-lite'); ?></div>
				</th>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-delay"><?php _e('Initial Delay', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[initial_delay]" value="<?php echo ibwpl_esc_attr( $initial_delay ); ?>" class="ibwp-text ibwp-sp-delay" id="ibwp-sp-delay" /> <?php _e('Sec', 'inboundwp-lite'); ?><br/>
					<span class="description"><?php _e('Initial delay of displaying first notification. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-delay-between"><?php _e('Delay Between', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[delay_between]" value="<?php echo ibwpl_esc_attr( $delay_between ); ?>" class="ibwp-text ibwp-sp-delay-between" id="ibwp-sp-delay-between" /> <?php _e('Sec', 'inboundwp-lite'); ?><br/>
					<span class="description"><?php _e('Delay between two notifications. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-loop-nf"><?php _e('Loop Notification', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[loop]" value="1" <?php checked( $loop, 1 ); ?> class="ibwp-text ibwp-sp-loop-nf" id="ibwp-sp-loop-nf" /><br/>
					<span class="description"><?php _e('check this box to repeat the notification once complete.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-link-target"><?php _e('Open Link in New Tab', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[link_target]" value="1" <?php checked( $link_target, 1 ); ?> class="ibwp-text ibwp-sp-link-target" id="ibwp-sp-link-target" /><br/>
					<span class="description"><?php _e('check this box to open notification link in a new tab.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-close-btn"><?php _e('Show Close Button', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo ibwpl_esc_attr( $prefix ); ?>behaviour[cls_btn]" value="1" <?php checked( $cls_btn, 1 ); ?> class="ibwp-text ibwp-show-hide ibwp-sp-close-btn" id="ibwp-sp-close-btn" data-prefix="cls" data-label="true" /><br/>
					<span class="description"><?php _e('check this box to display close button in notification box.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-sp-display-time"><?php _e('Display Notification', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" class="ibwp-text ibwp-sp-display-time" id="ibwp-sp-display-time" disabled /> <?php _e('Sec', 'inboundwp-lite'); ?><br/>
					<span class="description"><?php _e('Display notification for number of second. 60 Sec = 1 Min', 'inboundwp-lite'); ?></span>
					<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-pro-feature">
				<th>
					<label for="ibwp-sp-per-page"><?php _e('Max Per Page', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" class="ibwp-text ibwp-sp-per-page" id="ibwp-sp-per-page" disabled /><br/>
					<span class="description"><?php _e('Enter number of notifications to display per page.', 'inboundwp-lite'); ?></span>
					<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr class="ibwp-show-hide-row-cls ibwp-show-if-cls-true ibwp-pro-feature" style="<?php if( $cls_btn != 1 ) { echo 'display: none;'; } ?>">
				<th>
					<label for="ibwp-sp-close-behav"><?php _e('Close Behaviour', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="" class="ibwp-select ibwp-sp-close-behav" id="ibwp-sp-close-behav" disabled>
						<option value=""><?php esc_html_e('Simple Close', 'inboundwp-lite'); ?></option>
						<option value=""><?php esc_html_e('Close & Do not Show Until Next Reload', 'inboundwp-lite'); ?></option>
						<option value=""><?php esc_html_e('Close & Do not Show Until Next Browser Session', 'inboundwp-lite'); ?></option>
					</select><br/>
					<span class="description"><?php _e('Select notification close button behaviour.', 'inboundwp-lite'); ?></span><br/>
					<span class="description"><?php echo __('3 types of close behaviour. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-sp-behaviour-sett -->