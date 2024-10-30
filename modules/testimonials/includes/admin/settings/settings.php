<?php
/**
 * Settings Page
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Plugin settings tab
$sett_tab	= ibwpl_tm_settings_tab();
$tab		= isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

// If no valid tab is there
if( ! isset( $sett_tab[ $tab ] ) ) {
	ibwpl_display_message( 'error' );
	return;
}
?>

<div class="wrap">

	<h2><?php _e( 'Testimonial - Settings', 'inboundwp-lite' ); ?></h2>

	<?php
	// Reset message
	if( ! empty( $_POST['ibwp_tm_reset_settings'] ) ) {
		ibwpl_display_message( 'reset' );
	}

	// Success message
	if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) {
		ibwpl_display_message( 'update' );
	}

	settings_errors( 'ibwp_tm_sett_error' );
	?>

	<h2 class="nav-tab-wrapper">
		<?php foreach ( $sett_tab as $tab_key => $tab_val ) {
			$tab_url 		= add_query_arg( array( 'post_type' => IBWPL_TM_POST_TYPE, 'page' => 'wtwp-pro-settings', 'tab' => $tab_key ), admin_url('edit.php') );
			$active_tab_cls = ($tab == $tab_key) ? 'nav-tab-active' : '';
		?>
			<a class="nav-tab <?php echo $active_tab_cls; ?>" href="<?php echo esc_url( $tab_url ); ?>"><?php echo $tab_val; ?></a>
		<?php } ?>
	</h2>

	<div class="ibwp-sett-wrap ibwp-tm-settings ibwp-pad-top-20">

		<!-- Plugin reset settings form -->
		<form action="" method="post" id="ibwp-tm-reset-sett-form" class="ibwp-right ibwp-tm-reset-sett-form">
			<input type="submit" class="button button-primary ibwp-btn ibwp-reset-sett ibwp-resett-sett-btn ibwp-tm-reset-sett" name="ibwp_tm_reset_settings" id="ibwp-tm-reset-sett" value="<?php esc_html_e( 'Reset All Settings', 'inboundwp-lite' ); ?>" <?php if( $tab != 'general' ) { echo 'disabled'; } ?> />
		</form>

		<form action="options.php" method="POST" id="ibwp-tm-settings-form" class="ibwp-tm-settings-form">

			<?php settings_fields( 'ibwp_tm_plugin_options' ); ?>

			<div class="textright ibwp-clearfix">
				<input type="submit" name="ibwp_tm_settings_submit" class="button button-primary right ibwp-btn ibwp-tm-sett-submit ibwp-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" <?php if( $tab != 'general' ) { echo 'disabled'; } ?> />
			</div>

			<div class="metabox-holder">
				<div class="post-box-container">
					<div class="meta-box-sortables ui-sortable">

						<?php
						// Setting files
						switch ( $tab ) {
							case 'general':
								include_once( IBWPL_TM_DIR . '/includes/admin/settings/general-settings.php' );
								break;

							case 'form_sett':
								include_once( IBWPL_TM_DIR . '/includes/admin/settings/form-settings.php' );
								break;

							case 'notification':
								include_once( IBWPL_TM_DIR . '/includes/admin/settings/notification-settings.php' );
								break;

							default:
								do_action( 'ibwpl_tm_sett_panel_' . $tab );
								do_action( 'ibwpl_tm_sett_panel', $tab );
								break;
						}
						?>

					</div><!-- end .meta-box-sortables -->
				</div><!-- end .post-box-container -->
			</div><!-- end .metabox-holder -->

		</form><!-- end .ibwp-tm-settings-form -->

	</div><!-- end .ibwp-sett-wrap -->
</div><!-- end .wrap -->