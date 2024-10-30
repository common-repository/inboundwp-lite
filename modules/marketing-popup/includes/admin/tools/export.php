<?php
/**
 * Export HTML
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variables
$redirect_url = add_query_arg( array( 'post_type' => IBWPL_MP_POST_TYPE, 'page' => 'ibwp-mp-tools' ), admin_url('edit.php') );
?>

<div class="wrap ibwp-cnt-wrap ibwp-mp-popup-tools-wrp">

	<h2><?php _e( 'Marketing Popup Tools', 'inboundwp-lite' ); ?></h2>

	<div class="metabox-holder">
		<div class="post-box-container">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox ibwp-no-toggle">

					<h3 class="hndle">
						<span><?php esc_html_e( 'Export Form Entries', 'inboundwp-lite' ); ?></span>
					</h3>

					<div class="inside ibwp-tools-wrp ibwp-mp-tools-wrp">
						
						<p><?php _e('Download a CSV of all form entries recorded.', 'inboundwp-lite'); ?></p>

						<form id="ibwp-mp-tools-entry-form" class="ibwp-tools-form ibwp-mp-tools-entry-form" method="post" action="">

							<input type="text" name="start_date" value="" class="ibwp-text ibwp-date ibwp-mp-start-date" placeholder="<?php esc_html_e('Choose start date', 'inboundwp-lite'); ?>" />
							<input type="text" name="end_date" value="" class="ibwp-text ibwp-date ibwp-mp-end-date" placeholder="<?php esc_html_e('Choose end date', 'inboundwp-lite'); ?>" />

							<select name="popup_id" class="ibwp-select2 ibwp-post-title-sugg" data-placeholder="<?php esc_html_e('Select Collect Email Popup', 'inboundwp-lite'); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-post-title-sugg'); ?>" data-post-type="<?php echo IBWPL_MP_POST_TYPE; ?>" data-meta='{"key":"_ibwp_mp_popup_goal","value":"email-lists"}'>
								<option></option>
							</select>

							<span class="ibwp-tools-submit-wrp">
								<input type="submit" value="<?php esc_html_e('Generate CSV', 'inboundwp-lite'); ?>" class="button button-secondary ibwp-tools-submit" />
							</span>

							<input type="hidden" name="identifier" value="mp" />
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'ibwpl-mp-export-nonce' ); ?>" />
							<input type="hidden" name="redirect_url" value="<?php echo esc_url( $redirect_url ); ?>" />
						</form><!-- end .ibwp-tools-wrp -->
					</div><!-- end .inside -->
				</div><!-- end .postbox -->
			</div>
		</div><!-- end .post-box-container -->
	</div><!-- end .metabox-holder -->
</div><!-- end .wrap -->