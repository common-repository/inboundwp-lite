<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

// Taking some variables
$prefix			= IBWPL_MP_META_PREFIX;
$welcome_popup	= get_post_meta( $post->ID, $prefix.'welcome_popup', true );
$pre_data		= array( 'id' => -1, 'text' => esc_html__('No Popup', 'inboundwp-lite') );

// Getting Some Data
$welcome_popup_post 	= ( ! empty( $welcome_popup ) ) ? get_post( $welcome_popup )	: '';
$welcome_popup_title	= ! empty( $welcome_popup_post->post_title ) ? $welcome_popup_post->post_title : __('Post', 'inboundwp-lite');
?>

<table class="form-table ibwp-tbl ibwp-post-mp-table">
	<tbody>
		<tr>
			<th>
				<label for="ibwp-mp-welcome-popup"><?php _e('Welcome Popup', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select id="ibwp-mp-welcome-popup" class="ibwp-select2 ibwp-post-title-sugg ibwp-mp-welcome-popup" name="<?php echo ibwpl_esc_attr( $prefix ); ?>welcome_popup" data-placeholder="<?php esc_html_e('Select Welcome Popup', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_MP_POST_TYPE; ?>" data-predefined='<?php echo json_encode($pre_data); ?>'>
					<option></option>
					<?php if( $welcome_popup < 0 ) { ?>
						<option value="-1" selected="selected"><?php esc_html_e('No Popup', 'inboundwp-lite'); ?></option>
					<?php }
					elseif( $welcome_popup_post && $welcome_popup_post->post_status == 'publish' && $welcome_popup_post->post_type == IBWPL_MP_POST_TYPE ) { ?>
						<option value="<?php echo ibwpl_esc_attr( $welcome_popup_post->ID ); ?>" selected="selected"><?php echo $welcome_popup_title ." - (#{$welcome_popup_post->ID})"; ?></option>
					<?php } ?>
				</select><br/>
				<span class="description"><?php _e('Select welcome popup to display. You can search popup by its name or ID.', 'inboundwp-lite'); ?></span><br/>
				<span class="description"><?php _e('Note : Type No Popup and choose it to do not display any popup on this page.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>

		<tr class="ibwp-pro-feature">
			<th>
				<label for="ibwp-mp-exit-popup"><?php _e('Exit Popup', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select id="ibwp-mp-exit-popup" class="ibwp-select2 ibwp-mp-exit-popup" name="" data-placeholder="<?php esc_html_e('Select Exit Popup', 'inboundwp-lite'); ?>" disabled >
					<option></option>
				</select><br/>
				<span class="description"><?php echo __('Select exit popup to display. You can search popup by its name or ID. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span><br/>
				<span class="description"><?php _e('Note : Type No Popup and choose it to do not display any popup on this page.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>

		<tr class="ibwp-pro-feature">
			<th>
				<label for="ibwp-mp-html-popup"><?php _e('HTML Element Popup', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select id="ibwp-mp-html-popup" class="ibwp-select2 ibwp-mp-html-popup" name="" data-placeholder="<?php esc_html_e('Select HTML Element Popup', 'inboundwp-lite'); ?>" disabled >
					<option></option>
				</select><br/>
				<span class="description"><?php echo __('Select HTML Element popup to display. You can search popup by its name or ID. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span><br/>
				<span class="description"><?php _e('Note : Type No Popup and choose it to do not display any popup on this page.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>
	</tbody>
</table>