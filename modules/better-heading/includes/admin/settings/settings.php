<?php
/**
 * Settings Page
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Plugin settings tab
$sett_tab	= ibwpl_bh_settings_tab();
$tab		= isset( $_GET['tab'] )	? $_GET['tab']	: 'general';

// Check wheather to display submit button or not
if( isset( $sett_tab[$tab]['submit_btn'] ) && $sett_tab[$tab]['submit_btn'] !== true ) {
	$submit_btn = false;
} else {
	$submit_btn = true;
}
?>

<div class="wrap">

	<h2><?php _e( 'Better Heading', 'inboundwp-lite' ); ?></h2>

	<?php
	// Reset message
	if( ! empty( $_POST['ibwp_bh_reset_settings'] ) ) {
		ibwpl_display_message( 'reset' );
	}
	// Success message
	if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) {
		ibwpl_display_message( 'update' );
	}

	settings_errors( 'ibwp_bh_sett_error' );
	?>

	<h2 class="nav-tab-wrapper">
		<?php foreach ($sett_tab as $tab_key => $tab_val) {
			$tab_url		= add_query_arg( array( 'page' => 'ibwp-bh-settings', 'tab' => $tab_key ), admin_url('admin.php') );
			$active_tab_cls	= ( $tab == $tab_key )	? 'nav-tab-active'	: '';
		?>
			<a class="nav-tab <?php echo $active_tab_cls; ?>" href="<?php echo esc_url( $tab_url ); ?>"><?php echo $tab_val['name']; ?></a>
		<?php } ?>
	</h2>

	<div class="ibwp-sett-wrap ibwp-bh-settings ibwp-pad-top-20">

		<?php if( $submit_btn == 1 ) { ?>

		<!-- Plugin reset settings form -->
		<form action="" method="post" id="ibwp-bh-reset-sett-form" class="ibwp-right ibwp-bh-reset-sett-form">
			<input type="submit" class="button button-primary ibwp-btn ibwp-reset-sett ibwp-resett-sett-btn ibwp-bh-reset-sett" name="ibwp_bh_reset_settings" id="ibwp-bh-reset-sett" value="<?php esc_html_e( 'Reset All Settings', 'inboundwp-lite' ); ?>" />
		</form>

		<form action="options.php" method="POST" id="ibwp-bh-settings-form" class="ibwp-bh-settings-form">

			<?php settings_fields( 'ibwp_bh_plugin_options' ); ?>

			<div class="textright ibwp-clearfix">
				<input type="submit" name="ibwp_bh_settings_submit" class="button button-primary right ibwp-btn ibwp-bh-sett-submit ibwp-sett-submit" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" />
			</div>

		<?php } ?>

			<div class="metabox-holder">
				<div class="post-box-container">
					<div class="meta-box-sortables">
						<?php
						// Setting files
						switch ( $tab ) {
							case 'general':
								include_once( IBWPL_BH_DIR . '/includes/admin/settings/general-settings.php' );
								break;

							case 'report':
								include_once( IBWPL_BH_DIR . '/includes/admin/report/reports.php' );
								break;

							default:
								do_action( 'ibwpl_bh_sett_panel_' . $tab );
								do_action( 'ibwpl_bh_sett_panel', $tab );
								break;
						} ?>
					</div>
				</div>
			</div>

		<?php if( $submit_btn == 1 ) { ?>
		</form><!-- end .ibwp-bh-settings-form -->
		<?php } ?>

	</div><!-- end .ibwp-sett-wrap -->
</div><!-- end .wrap -->