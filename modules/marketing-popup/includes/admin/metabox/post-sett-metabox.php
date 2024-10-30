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
$prefix			= IBWPL_MP_META_PREFIX; // Metabox prefix
$enable			= ibwpl_mp_get_option( 'enable' );
$selected_tab	= get_post_meta( $post->ID, $prefix.'tab', true );
$popup_goal		= get_post_meta( $post->ID, $prefix.'popup_goal', true );
$popup_type		= get_post_meta( $post->ID, $prefix.'popup_type', true );
$popup_goal		= ! empty( $popup_goal ) ? ibwpl_clean( $popup_goal ) : 'email-lists';
$popup_type		= ! empty( $popup_type ) ? ibwpl_clean( $popup_type ) : 'modal';

// Add general reminder when module is disabled from setting page
if( ! $enable ) { ?>
<div class="ibwp-info ibwp-no-margin ibwp-no-radius"><i class="dashicons dashicons-warning"></i> <?php esc_html_e('Marketing Popup is disabled from plugin setting page. Kindly enable it to use it.', 'inboundwp-lite'); ?></div>
<?php } ?>

<div class="ibwp-vtab-wrap ibwp-clearfix">
	<ul class="ibwp-vtab-nav-wrap">
		<li class="ibwp-vtab-nav ibwp-active-vtab">
			<a href="#ibwp_mp_behaviour_sett"><i class="dashicons dashicons-welcome-view-site" aria-hidden="true"></i> <?php esc_html_e('Behaviour', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_mp_content_sett"><i class="dashicons dashicons-text-page" aria-hidden="true"></i> <?php esc_html_e('Content', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_mp_social_sett"><i class="dashicons dashicons-share" aria-hidden="true"></i> <?php esc_html_e('Social', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_mp_design_sett"><i class="dashicons dashicons-admin-customizer" aria-hidden="true"></i> <?php esc_html_e('Design', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_mp_notification_sett"><i class="dashicons dashicons-email-alt" aria-hidden="true"></i> <?php esc_html_e('Notification', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_mp_advance_sett"><i class="dashicons dashicons-admin-settings" aria-hidden="true"></i> <?php esc_html_e('Advance', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_mp_integration_sett"><i class="dashicons dashicons-networking" aria-hidden="true"></i> <?php esc_html_e('Integration', 'inboundwp-lite'); ?></a>
		</li>
	</ul>

	<div class="ibwp-vtab-cnt-wrp">
		<?php
			// Behaviour Settings
			include_once( IBWPL_MP_DIR . '/includes/admin/metabox/behaviour-metabox.php' );

			// Content Settings
			include_once( IBWPL_MP_DIR . '/includes/admin/metabox/content-metabox.php' );

			// Design Settings
			include_once( IBWPL_MP_DIR . '/includes/admin/metabox/social-metabox.php' );

			// Design Settings
			include_once( IBWPL_MP_DIR . '/includes/admin/metabox/design-metabox.php' );

			// Notification Settings
			include_once( IBWPL_MP_DIR . '/includes/admin/metabox/notification-metabox.php' );

			// Advance Settings
			include_once( IBWPL_MP_DIR . '/includes/admin/metabox/advance-metabox.php' );

			// Integration Settings
			include_once( IBWPL_MP_DIR . '/includes/admin/metabox/integration-metabox.php' );
		?>
	</div>
	<input type="hidden" value="<?php echo ibwpl_esc_attr( $selected_tab ); ?>" class="ibwp-selected-tab" name="<?php echo ibwpl_esc_attr( $prefix ); ?>tab" />
</div>

<div class="ibwp-mp-meta-notify ibwp-hide"><?php esc_html_e('Changing the Popup Bahaviour or Popup Type will enable some settings in Content and Designs tab.', 'inboundwp-lite'); ?></div>

<?php ibwpl_module_preview_popup( array(
				'preview_link'	=> IBWPL_MP_PREVIEW_LINK,
				'title'			=> esc_html__('Marketing Popup Preview', 'inboundwp-lite'),
				'info'			=> esc_html__("Some setting options will not work here like 'When Popup Appear?', 'Cookie Expiry Time', 'Advance Settings' and etc for better user experience and preview restriction.", 'inboundwp-lite')
			) ); ?>