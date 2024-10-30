<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

// Taking some variables
$prefix			= IBWPL_SPW_META_PREFIX;
$welcome_wheel	= get_post_meta( $post->ID, $prefix.'welcome_wheel', true );
$pre_data		= array( 'id' => -1, 'text' => esc_html__('No Spin Wheel', 'inboundwp-lite') );

// Getting Some Data
$welcome_wheel_post 	= ( ! empty( $welcome_wheel ) ) ? get_post( $welcome_wheel )	: '';
$welcome_wheel_title	= ! empty( $welcome_wheel_post->post_title ) ? $welcome_wheel_post->post_title : __('Post', 'inboundwp-lite');
?>

<table class="form-table ibwp-tbl ibwp-post-spw-table">
	<tbody>
		<tr>
			<th>
				<label for="ibwp-spw-welcome-wheel"><?php _e('Welcome Spin Wheel', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select id="ibwp-spw-welcome-wheel" class="ibwp-select2 ibwp-post-title-sugg ibwp-spw-welcome-wheel" name="<?php echo ibwpl_esc_attr( $prefix ); ?>welcome_wheel" data-placeholder="<?php esc_html_e('Select Welcome Spin Wheel', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_SPW_POST_TYPE; ?>" data-predefined='<?php echo json_encode($pre_data); ?>'>
					<option></option>
					<?php if( $welcome_wheel < 0 ) { ?>
						<option value="-1" selected="selected"><?php esc_html_e('No Spin Wheel', 'inboundwp-lite'); ?></option>
					<?php }
					elseif( $welcome_wheel_post && $welcome_wheel_post->post_status == 'publish' && $welcome_wheel_post->post_type == IBWPL_SPW_POST_TYPE ) { ?>
						<option value="<?php echo ibwpl_esc_attr( $welcome_wheel_post->ID ); ?>" selected="selected"><?php echo $welcome_wheel_title ." - (#{$welcome_wheel_post->ID})"; ?></option>
					<?php } ?>
				</select><br/>
				<span class="description"><?php _e('Select welcome spin wheel to display. You can search spin wheel by its name or ID.', 'inboundwp-lite'); ?></span><br/>
				<span class="description"><?php _e('Note : Type No Spin Wheel and choose it to do not display any spin wheel on this page.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>

		<tr class="ibwp-pro-feature">
			<th>
				<label for="ibwp-spw-exit-wheel"><?php _e('Exit Spin Wheel', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select id="ibwp-spw-exit-wheel" class="ibwp-select2 ibwp-spw-exit-wheel" name="" data-placeholder="<?php esc_html_e('Select Exit Spin Wheel', 'inboundwp-lite'); ?>" disabled >
					<option></option>
				</select><br/>
				<span class="description"><?php echo __('Select exit spin wheel to display. You can search spin wheel by its name or ID. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span><br/>
				<span class="description"><?php _e('Note : Type No Spin Wheel and choose it to do not display any spin wheel on this page.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>

		<tr class="ibwp-pro-feature">
			<th>
				<label for="ibwp-spw-html-wheel"><?php _e('HTML Element Spin Wheel', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select id="ibwp-spw-html-wheel" class="ibwp-select2 ibwp-spw-html-wheel" name="" data-placeholder="<?php esc_html_e('Select HTML Element Spin Wheel', 'inboundwp-lite'); ?>" disabled >
					<option></option>
				</select><br/>
				<span class="description"><?php echo __('Select HTML Element spin wheel to display. You can search spin wheel by its name or ID. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span><br/>
				<span class="description"><?php _e('Note : Type No Spin Wheel and choose it to do not display any spin wheel on this page.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>
	</tbody>
</table><!-- end .form-table -->