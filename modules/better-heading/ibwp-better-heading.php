<?php
/**
 * Better Heading
 * 
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

/**
 * Basic plugin definitions
 * 
 * @subpackage Better Heading
 * @since 1.0
 */
IBWP_Lite()->define( 'IBWPL_BH_DIR', dirname( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_BH_URL', plugin_dir_url( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_BH_META_PREFIX', '_ibwp_bh_' );							// Plugin meta prefix
IBWP_Lite()->define( 'IBWPL_BH_PAGE_SLUG', IBWPL_SCREEN_ID.'_page_ibwp-bh-settings' );	// Plugin Setting Page
IBWP_Lite()->define( 'IBWPL_BH_TBL', $wpdb->prefix.'ibwp_bh_report' );				// Table name 
IBWP_Lite()->define( 'IBWPL_BH_STATS_TBL', $wpdb->prefix.'ibwp_bh_stats' );			// Table name 

/**
 * Plugin Setup (On Activation)
 * Does the initial setup, set default values for the plugin options.
 * 
 * @since 1.0
 */
function ibwpl_bh_install() {

	// Get settings for the plugin
	$ibwp_bh_options = get_option( 'ibwp_bh_options' );

	if( empty( $ibwp_bh_options ) ) { // Check plugin version option

		// Default Settings
		ibwpl_bh_default_settings();

		// Update plugin version to option
		update_option( 'ibwp_bh_plugin_version', '1.0', false );
	}

	// Create Table
	ibwpl_bh_create_tables();
}
add_action( 'ibwp_module_activation_hook_better_heading', 'ibwpl_bh_install' );

// Taking some global
global $ibwp_bh_options;

// Functions file
require_once( IBWPL_BH_DIR . '/includes/ibwp-bh-functions.php' );
$ibwp_bh_options = ibwpl_get_settings( 'ibwp_bh_options' );

// Script Class
require_once( IBWPL_BH_DIR . '/includes/class-ibwp-bh-script.php' );

// Public Class
require_once( IBWPL_BH_DIR . '/includes/class-ibwp-bh-public.php' );

// Load Admin side file only
if( is_admin() ) {

	// Admin class
	require_once( IBWPL_BH_DIR . '/includes/admin/class-ibwp-bh-admin.php' );

	// Plugin Settings
	require_once( IBWPL_BH_DIR . '/includes/admin/settings/register-settings.php' );
}