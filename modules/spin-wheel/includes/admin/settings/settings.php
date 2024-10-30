<?php
/**
 * Settings Page
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Plugin settings tab
$sett_tab		= ibwpl_spw_settings_tab();
$sett_tab_count	= count( $sett_tab );
$tab			= isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

// If no valid tab is there
if( ! isset( $sett_tab[ $tab ] ) ) {
	ibwpl_display_message( 'error' );
	return;
}
?>

<div class="wrap">

	<h2><?php _e( 'Spin Wheel - Settings', 'inboundwp-lite' ); ?></h2>

	<?php
	// Reset message
	if( ! empty( $_POST['ibwp_spw_reset_settings'] ) ) {
		ibwpl_display_message( 'reset' );
	}

	// Success message
	if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) {
		ibwpl_display_message( 'update' );
	}

	settings_errors( 'ibwp_spw_sett_error' );

	// If more than one settings tab
	if( $sett_tab_count > 1 ) { ?>

	<h2 class="nav-tab-wrapper">
		<?php foreach ( $sett_tab as $tab_key => $tab_val ) {
			$tab_url 		= add_query_arg( array( 'post_type' => IBWPL_SPW_POST_TYPE, 'page' => 'ibwp-spw-settings', 'tab' => $tab_key ), admin_url('edit.php') );
			$active_tab_cls = ($tab == $tab_key) ? 'nav-tab-active' : '';
		?>
			<a class="nav-tab <?php echo $active_tab_cls; ?>" href="<?php echo esc_url( $tab_url ); ?>"><?php echo $tab_val; ?></a>
		<?php } ?>
	</h2>

	<?php } ?>

	<div class="ibwp-sett-wrap ibwp-spw-settings ibwp-pad-top-20">

		<!-- Plugin reset settings form -->
		<form action="" method="post" id="ibwp-spw-reset-sett-form" class="ibwp-right ibwp-spw-reset-sett-form">
			<input type="submit" class="button button-primary ibwp-btn ibwp-reset-sett ibwp-resett-sett-btn ibwp-spw-reset-sett" name="ibwp_spw_reset_settings" id="ibwp-spw-reset-sett" value="<?php esc_html_e( 'Reset All Settings', 'inboundwp-lite' ); ?>" />
		</form>

		<form action="options.php" method="POST" id="ibwp-spw-settings-form" class="ibwp-spw-settings-form">

			<?php settings_fields( 'ibwp_spw_plugin_options' ); ?>

			<div class="textright ibwp-clearfix">
				<input type="submit" name="ibwp_spw_settings_submit" class="button button-primary right ibwp-btn ibwp-spw-sett-submit ibwp-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
			</div>

			<div class="metabox-holder">
				<div class="post-box-container">
					<div class="meta-box-sortables ui-sortable">

						<?php
						// Setting files
						switch ( $tab ) {
							case 'general':
								include_once( IBWPL_SPW_DIR . '/includes/admin/settings/general-settings.php' );
								break;

							default:
								do_action( 'ibwpl_spw_sett_panel_' . $tab );
								do_action( 'ibwpl_spw_sett_panel', $tab );
								break;
						}
						?>

					</div><!-- end .meta-box-sortables -->
				</div><!-- end .post-box-container -->
			</div><!-- end .metabox-holder -->

		</form><!-- end .ibwp-spw-settings-form -->
	</div><!-- end .ibwp-sett-wrap -->
</div><!-- end .wrap -->