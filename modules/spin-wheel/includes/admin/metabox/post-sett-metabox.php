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
$prefix			= IBWPL_SPW_META_PREFIX; // Metabox prefix
$enable			= ibwpl_spw_get_option( 'enable' );
$selected_tab	= get_post_meta( $post->ID, $prefix.'tab', true );

// Add general reminder when module is disabled from setting page
if( ! $enable ) { ?>
<div class="ibwp-info ibwp-no-margin ibwp-no-radius"><i class="dashicons dashicons-warning"></i> <?php esc_html_e('Spin Wheel is disabled from plugin setting page. Kindly enable it to use it.', 'inboundwp-lite'); ?></div>
<?php } ?>

<div class="ibwp-vtab-wrap ibwp-clearfix ibwp-spw-metabox-wrp">
	<ul class="ibwp-vtab-nav-wrap">
		<li class="ibwp-vtab-nav ibwp-active-vtab">
			<a href="#ibwp_spw_behaviour_sett"><i class="dashicons dashicons-welcome-view-site" aria-hidden="true"></i> <?php esc_html_e('Behaviour', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_spw_segment_sett"><i class="dashicons dashicons-sos" aria-hidden="true"></i> <?php esc_html_e('Segment', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_spw_content_sett"><i class="dashicons dashicons-text-page" aria-hidden="true"></i> <?php esc_html_e('Content', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_spw_design_sett"><i class="dashicons dashicons-admin-customizer" aria-hidden="true"></i> <?php esc_html_e('Design', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_spw_notification_sett"><i class="dashicons dashicons-email-alt" aria-hidden="true"></i> <?php esc_html_e('Notification', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_spw_advance_sett"><i class="dashicons dashicons-admin-settings" aria-hidden="true"></i> <?php esc_html_e('Advance', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_spw_integration_sett"><i class="dashicons dashicons-networking" aria-hidden="true"></i> <?php esc_html_e('Integration', 'inboundwp-lite'); ?></a>
		</li>
	</ul>

	<div class="ibwp-vtab-cnt-wrp">
		<?php

			// Segment Settings
			include_once( IBWPL_SPW_DIR . '/includes/admin/metabox/behaviour-metabox.php' );

			// Segment Settings
			include_once( IBWPL_SPW_DIR . '/includes/admin/metabox/segment-metabox.php' );

			// Content Settings
			include_once( IBWPL_SPW_DIR . '/includes/admin/metabox/content-metabox.php' );

			// Design Settings
			include_once( IBWPL_SPW_DIR . '/includes/admin/metabox/design-metabox.php' );

			// Notification Settings
			include_once( IBWPL_SPW_DIR . '/includes/admin/metabox/notification-metabox.php' );

			// Advance Settings
			include_once( IBWPL_SPW_DIR . '/includes/admin/metabox/advance-metabox.php' );

			// Integration Settings
			include_once( IBWPL_SPW_DIR . '/includes/admin/metabox/integration-metabox.php' );
		?>
	</div>
	<input type="hidden" value="<?php echo ibwpl_esc_attr( $selected_tab ); ?>" class="ibwp-selected-tab" name="<?php echo ibwpl_esc_attr( $prefix ); ?>tab" />
</div>

<?php ibwpl_module_preview_popup( array(
				'preview_link'	=> IBWPL_SPW_PREVIEW_LINK,
				'title'			=> esc_html__('Spin Wheel Preview', 'inboundwp-lite'),
				'info'			=> esc_html__("Some setting options will not work here like 'When Wheel Appear?', 'Cookie Expiry Time', 'Advance Settings' and etc for better user experience and preview restriction.", 'inboundwp-lite')
			) ); ?>