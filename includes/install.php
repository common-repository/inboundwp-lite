<?php
/**
 * Install Function
 *
 * @package InboundWP Lite
 * @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_install() {

	// Deactivate pro version
	if( is_plugin_active('inboundwp/inboundwp.php') ) {
		add_action('update_option_active_plugins', 'ibwpl_deactivate_pro_version');
	}

	ibwpl_run_install();

	// Getting active modules
	$active_modules = ibwpl_get_active_modules();

	// To call all active modules activation hook
	if( ! empty( $active_modules ) ) {
		$ibwp_modules_activity = array(
									'recently_active_module' => $active_modules,
								);
		set_transient( 'ibwp_modules_activity', $ibwp_modules_activity, HOUR_IN_SECONDS );
	}

	do_action( 'ibwpl_activation_hook' );
}
register_activation_hook( IBWPL_PLUGIN_FILE, 'ibwpl_install' );

/**
 * Deactivate Pro version of plugin
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_deactivate_pro_version() {
	deactivate_plugins('inboundwp/inboundwp.php', true);
}

/**
 * Function to display admin notice of activated plugin.
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_plugin_admin_notice() {

	global $pagenow;

	$dir = WP_PLUGIN_DIR . '/inboundwp/inboundwp.php';

	// If Free plugin is active and pro plugin exist
	if ( $pagenow == 'plugins.php' && current_user_can( 'install_plugins' ) && file_exists( $dir ) ) {

		$notice_transient = get_transient( 'ibwp_install_notice' );

		// If PRO plugin is active and free plugin exist
		if ( $notice_transient == false ) {

			$notice_link = add_query_arg( array('message' => 'ibwp-install-notice'), admin_url('plugins.php') );

			echo '<div id="message" class="updated notice" style="position:relative;">
					<p>'.sprintf( __('<strong>Thank you for activating %s</strong>.<br /> It looks like you had Pro version <strong>(%s)</strong> of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it.', 'inboundwp-lite'), 'InboundWP Lite', 'InboundWP' ).'</p>
					<a href="'.esc_url( $notice_link ).'" class="notice-dismiss" style="text-decoration:none;"></a>
				</div>';
		}
	}
}

// Action to display notice
add_action( 'admin_notices', 'ibwpl_plugin_admin_notice' );
	
/**
 * Run the Install process
 *
 * @since  1.0
 */
function ibwpl_run_install() {

	global $wpdb, $ibwp_options;

	// Get settings for the plugin
	$ibwp_options = get_option( 'ibwp_opts' );
	
	if( empty( $ibwp_options ) ) { // Check plugin version option
		
		// Set default settings
		ibwpl_default_settings();

		// Update plugin version to option
		update_option( 'ibwp_plugin_version', '1.1' );
	}
}

/**
 * Deactivation Hook
 * 
 * Register plugin deactivation hook.
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
register_deactivation_hook( __FILE__, 'ibwpl_uninstall');

/**
 * Plugin Deactivation
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_uninstall() {
    // Plugin deactivation process
}

/**
 * Set redirect transition on update or activation
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_set_welcome_page_redirect() {

	// return if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	// Add the transient to redirect
    set_transient( '_ibwp_activation_redirect', true, 30 );
}
add_action('ibwpl_activation_hook', 'ibwpl_set_welcome_page_redirect');

/**
 * Redirect to welcome page when plugin is activated
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_welcome_page_redirect() {

	global $pagenow;

	// If plugin notice is dismissed
	if( isset($_GET['message']) && $_GET['message'] == 'ibwp-install-notice' ) {
		set_transient( 'ibwp_install_notice', true, 604800 );
	}

	// return if not plugin install page
	if( $pagenow != 'plugins.php' ) {
		return;
	}

	// return if no activation redirect
    if ( ! get_transient( '_ibwp_activation_redirect' ) ) {
		return;
	}

	// Delete the redirect transient
	delete_transient( '_ibwp_activation_redirect' );

	// return if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	$redirect_link = ibwpl_get_plugin_link('about');

	// Redirect to about page
	wp_safe_redirect( $redirect_link );
	exit;
}
add_action( 'admin_init', 'ibwpl_welcome_page_redirect' );