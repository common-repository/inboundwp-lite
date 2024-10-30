<?php
/**
 * Marketing Popup Module
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

IBWP_Lite()->define( 'IBWPL_MP_VERSION', '1.0' );
IBWP_Lite()->define( 'IBWPL_MP_DIR_NAME', 'marketing-popup' );
IBWP_Lite()->define( 'IBWPL_MP_DIR', dirname( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_MP_URL', plugin_dir_url( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_MP_POST_TYPE', 'ibwp_mp_popup' );					// Post Type
IBWP_Lite()->define( 'IBWPL_MP_META_PREFIX', '_ibwp_mp_' );						// Meta Prefix
IBWP_Lite()->define( 'IBWPL_MP_FORM_TBL', $wpdb->prefix.'ibwp_mp_submission' );	// Form Submission Table
IBWP_Lite()->define( 'IBWPL_MP_PREVIEW_LINK', add_query_arg( array('module' => 'marketing-popup' ), IBWPL_PREVIEW_LINK ) );

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup, set default values for the plugin options.
 *
 * @subpackage Marketing Popup
 * @since 1.0
 */
function ibwpl_mp_install() {

	// Custom post type function
	ibwpl_mp_register_post_types();

	// Get settings for the plugin
	$ibwp_mp_options = get_option( 'ibwp_mp_options' );
	
	if( empty( $ibwp_mp_options ) ) { // Check plugin version option
		
		// set default settings
		ibwpl_mp_default_settings();

		// Update plugin version to option
		update_option( 'ibwp_mp_plugin_version', '1.0', false );
	}

	// Create Table
	ibwpl_mp_create_tables();

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();
}
add_action( 'ibwp_module_activation_hook_marketing-popup', 'ibwpl_mp_install' );

// Taking some globals
global $ibwp_mp_options;

// Function File
require_once( IBWPL_MP_DIR . '/includes/ibwp-mp-functions.php' );
$ibwp_mp_options = ibwpl_get_settings( 'ibwp_mp_options' );

// Plugin Template Functions
require_once( IBWPL_MP_DIR . '/includes/ibwp-mp-template-functions.php' );

// Plugin Post Type File
require_once( IBWPL_MP_DIR . '/includes/ibwp-mp-post-types.php' );

// Script Class
require_once( IBWPL_MP_DIR . '/includes/class-ibwp-mp-script.php' );

// Public Class
require_once( IBWPL_MP_DIR . '/includes/class-ibwp-mp-public.php' );

// Shortcode File
require_once( IBWPL_MP_DIR . '/includes/shortcode/ibwp-mp-popup.php' );

// Load Admin side file only
if( is_admin() ) {

	// Admin Class
	require_once( IBWPL_MP_DIR . '/includes/admin/class-ibwp-mp-admin.php' );

	// Plugin Settings
	require_once( IBWPL_MP_DIR . '/includes/admin/settings/register-settings.php' );

	// Form Entries Functions
	require_once ( IBWPL_MP_DIR . '/includes/admin/form/form-entries-fuctions.php' );

	// Form Entries Export Function File
	require_once( IBWPL_MP_DIR . '/includes/admin/tools/export-functions.php' );
}