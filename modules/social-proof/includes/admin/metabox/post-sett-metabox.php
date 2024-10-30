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
$prefix			= IBWPL_SP_META_PREFIX; // Metabox prefix
$enable			= ibwpl_sp_get_option( 'enable' );
$selected_tab	= get_post_meta( $post->ID, $prefix.'tab', true );
$type			= get_post_meta( $post->ID, $prefix.'type', true );
$source_type	= get_post_meta( $post->ID, $prefix.'source_type', true );
$source_type	= ! empty( $source_type ) ? $source_type : 'custom';

// Add general reminder when module is disabled from setting page
if( ! $enable ) { ?>
<div class="ibwp-info ibwp-no-margin ibwp-no-radius"><i class="dashicons dashicons-warning"></i> <?php esc_html_e('Social Proof is disabled from plugin setting page. Kindly enable it to use it.', 'inboundwp-lite'); ?></div>
<?php } ?>

<div class="ibwp-vtab-wrap ibwp-clearfix">
	<ul class="ibwp-vtab-nav-wrap">
		<li class="ibwp-vtab-nav ibwp-active-vtab">
			<a href="#ibwp_sp_behaviour_sett"><i class="dashicons dashicons-welcome-view-site" aria-hidden="true"></i> <?php esc_html_e('Behaviour', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_sp_content_sett"><i class="dashicons dashicons-text-page" aria-hidden="true"></i> <?php esc_html_e('Content', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_sp_design_sett"><i class="dashicons dashicons-admin-customizer" aria-hidden="true"></i> <?php esc_html_e('Design', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_sp_advance_sett"><i class="dashicons dashicons-admin-settings" aria-hidden="true"></i> <?php esc_html_e('Advance', 'inboundwp-lite'); ?></a>
		</li>
		<li class="ibwp-vtab-nav">
			<a href="#ibwp_sp_tracking_sett"><i class="dashicons dashicons-chart-bar" aria-hidden="true"></i> <?php esc_html_e('Tracking', 'inboundwp-lite'); ?></a>
		</li>
	</ul>

	<div class="ibwp-vtab-cnt-wrp">
		<?php
			// Behaviour Settings
			include_once( IBWPL_SP_DIR . '/includes/admin/metabox/behaviour-metabox.php' );

			// Content Settings
			include_once( IBWPL_SP_DIR . '/includes/admin/metabox/content-metabox.php' );

			// Design Settings
			include_once( IBWPL_SP_DIR . '/includes/admin/metabox/design-metabox.php' );

			// Advance Settings
			include_once( IBWPL_SP_DIR . '/includes/admin/metabox/advance-metabox.php' );

			// Tracking Settings
			include_once( IBWPL_SP_DIR . '/includes/admin/metabox/tracking-metabox.php' );
		?>
	</div>
	<input type="hidden" value="<?php echo ibwpl_esc_attr( $selected_tab ); ?>" class="ibwp-selected-tab" name="<?php echo ibwpl_esc_attr( $prefix ); ?>tab" />
</div>

<div class="ibwp-sp-meta-notify ibwp-hide"><?php esc_html_e('Changing the Social Proof type will enable some settings in Content tab.', 'inboundwp-lite'); ?></div>

<?php ibwpl_module_preview_popup( array(
				'preview_link'	=> IBWPL_SP_PREVIEW_LINK,
				'title'			=> esc_html__('Social Proof Preview', 'inboundwp-lite'),
				'info'			=> esc_html__("Some setting options will not work here like 'Advance Settings' and etc for better user experience and preview restriction.", 'inboundwp-lite')
			) ); ?>