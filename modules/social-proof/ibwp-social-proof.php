<?php
/**
 * Social Proof Module
 * 
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Basic plugin definitions
 * 
 * @subpackage Social Proof
 * @since 1.0
 */
IBWP_Lite()->define( 'IBWPL_SP_VERSION', '1.0' );
IBWP_Lite()->define( 'IBWPL_SP_DIR_NAME', 'social-proof' );
IBWP_Lite()->define( 'IBWPL_SP_DIR', dirname( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_SP_URL', plugin_dir_url( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_SP_POST_TYPE', 'ibwp_sp' );				// Plugin post type
IBWP_Lite()->define( 'IBWPL_SP_META_PREFIX', '_ibwp_sp_' );			// Plugin meta prefix
IBWP_Lite()->define( 'IBWPL_SP_PREVIEW_LINK', add_query_arg( array('module' => 'social-proof' ), IBWPL_PREVIEW_LINK ) );

/**
 * Plugin Module Activation Function
 * Does the initial setup, sets the default values for the plugin module options
 * 
 * @subpackage Social Proof
 * @since 1.0
 */
function ibwpl_sp_install() {

	// Custom post type function
	ibwpl_sp_register_post_types();

	// Get settings for the plugin
	$ibwp_sp_options = get_option( 'ibwp_sp_options' );

	if( empty( $ibwp_sp_options ) ) { // Check plugin version option
		
		// set default settings
		ibwpl_sp_default_settings();

		// Update plugin version to option
		update_option( 'ibwp_sp_plugin_version', '1.0', false );
	}

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();
}
add_action( 'ibwp_module_activation_hook_social-proof', 'ibwpl_sp_install' );

global $ibwp_sp_options;

// Function File
require_once( IBWPL_SP_DIR . '/includes/ibwp-sp-functions.php' );
$ibwp_sp_options = ibwpl_get_settings( 'ibwp_sp_options' );

// Post Type File
require_once( IBWPL_SP_DIR . '/includes/ibwp-sp-post-type.php' );

// Script Class
require_once( IBWPL_SP_DIR . '/includes/class-ibwp-sp-script.php' );

// Public Class
require_once( IBWPL_SP_DIR . '/includes/class-ibwp-sp-public.php' );

// Load Admin side file only
if( is_admin() ) {

	// Admin Class
	require_once( IBWPL_SP_DIR . '/includes/admin/class-ibwp-sp-admin.php' );

	// Plugin Settings
	require_once( IBWPL_SP_DIR . '/includes/admin/settings/register-settings.php' );
}