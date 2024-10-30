<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

// Taking some variables
$prefix			= IBWPL_SP_META_PREFIX;
$notification	= get_post_meta( $post->ID, $prefix.'notification', true );
$pre_data		= array( 'id' => -1, 'text' => esc_html__('No Social Proof', 'inboundwp-lite') );

// Getting Some Data
$notification_post 	= ( ! empty( $notification ) )				? get_post( $notification )			: '';
$notification_title	= ! empty( $notification_post->post_title ) ? $notification_post->post_title	: __('Post', 'inboundwp-lite');
?>

<table class="form-table ibwp-tbl ibwp-post-sp-table">
	<tbody>
		<tr>
			<th>
				<label for="ibwp-sp-notification"><?php _e('Social Proof', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select id="ibwp-sp-notification" class="ibwp-select2 ibwp-post-title-sugg ibwp-sp-notification" name="<?php echo ibwpl_esc_attr( $prefix ); ?>notification" data-placeholder="<?php esc_html_e('Select Social Proof', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_SP_POST_TYPE; ?>" data-predefined='<?php echo json_encode($pre_data); ?>'>
					<option></option>
					<?php if( $notification < 0 ) { ?>
						<option value="-1" selected="selected"><?php esc_html_e('No Social Proof', 'inboundwp-lite'); ?></option>
					<?php }
					else if( $notification_post && $notification_post->post_status == 'publish' && $notification_post->post_type == IBWPL_SP_POST_TYPE ) { ?>
						<option value="<?php echo ibwpl_esc_attr( $notification_post->ID ); ?>" selected="selected"><?php echo $notification_title ." - (#{$notification_post->ID})"; ?></option>
					<?php } ?>
				</select><br/>
				<span class="description"><?php _e('Select social proof to display. You can search social proof by its name or ID.', 'inboundwp-lite'); ?></span><br/>
				<span class="description"><?php _e('Note : Type No Social Proof and choose it to do not display any social proof on this page.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>
	</tbody>
</table>