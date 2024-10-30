<?php
/**
 * Export HTML
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variables
$redirect_url = add_query_arg( array( 'post_type' => IBWPL_SPW_POST_TYPE, 'page' => 'ibwp-spw-tools' ), admin_url('edit.php') );
?>

<div class="wrap ibwp-cnt-wrap ibwp-spw-wheel-tools-wrp">

	<h2><?php _e( 'Spin Wheel Tools', 'inboundwp-lite' ); ?></h2>

	<div class="metabox-holder">
		<div class="post-box-container">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox ibwp-no-toggle">

					<h3 class="hndle">
						<span><?php esc_html_e( 'Export Form Entries', 'inboundwp-lite' ); ?></span>
					</h3>

					<div class="inside ibwp-tools-wrp ibwp-spw-tools-wrp">
						
						<p><?php _e('Download a CSV of all form entries recorded.', 'inboundwp-lite'); ?></p>

						<form id="ibwp-spw-tools-entry-form" class="ibwp-tools-form ibwp-spw-tools-entry-form" method="post" action="">

							<input type="text" name="start_date" value="" class="ibwp-text ibwp-date ibwp-spw-start-date" placeholder="<?php esc_html_e('Choose start date', 'inboundwp-lite'); ?>" />
							<input type="text" name="end_date" value="" class="ibwp-text ibwp-date ibwp-spw-end-date" placeholder="<?php esc_html_e('Choose end date', 'inboundwp-lite'); ?>" />

							<select name="wheel_id" class="ibwp-select2 ibwp-post-title-sugg" data-placeholder="<?php esc_html_e('Select Spin Wheel', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_SPW_POST_TYPE; ?>">
								<option></option>
							</select>

							<span class="ibwp-tools-submit-wrp">
								<input type="submit" value="<?php esc_html_e('Generate CSV', 'inboundwp-lite'); ?>" class="button button-secondary ibwp-tools-submit" />
							</span>

							<input type="hidden" name="identifier" value="spw" />
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'ibwpl-spw-export-nonce' ); ?>" />
							<input type="hidden" name="redirect_url" value="<?php echo esc_url( $redirect_url ); ?>" />
						</form><!-- end .ibwp-tools-wrp -->
					</div><!-- end .inside -->
				</div><!-- end .postbox -->
			</div>
		</div><!-- end .post-box-container -->
	</div><!-- end .metabox-holder -->
</div><!-- end .wrap -->