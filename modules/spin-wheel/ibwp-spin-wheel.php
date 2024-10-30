<?php
/**
 * Spin Wheel Module
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

IBWP_Lite()->define( 'IBWPL_SPW_VERSION', '1.0' );
IBWP_Lite()->define( 'IBWPL_SPW_DIR_NAME', 'spin-wheel' );
IBWP_Lite()->define( 'IBWPL_SPW_DIR', dirname( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_SPW_URL', plugin_dir_url( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_SPW_POST_TYPE', 'ibwp_spw_spin_wheel' ); 				// Plugin post type
IBWP_Lite()->define( 'IBWPL_SPW_META_PREFIX', '_ibwp_spw_' ); 						// Plugin meta prefix
IBWP_Lite()->define( 'IBWPL_SPW_FORM_TBL', $wpdb->prefix.'ibwp_spw_submission' );	// Email Table
IBWP_Lite()->define( 'IBWPL_SPW_PREVIEW_LINK', add_query_arg( array('module' => 'spin-wheel' ), IBWPL_PREVIEW_LINK ) );

/**
 * Plugin Activation Function
 * Does the initial setup, sets the default values for the plugin options
 * 
 * @since 1.0
 */
function ibwpl_spw_install() {

	// Custom post type function
	ibwpl_spw_register_post_types();

	// Get settings for the plugin
	$ibwp_spw_options = get_option( 'ibwp_spw_options' );

	if( empty( $ibwp_spw_options ) ) { // Check plugin version option

		// Set default settings
		ibwpl_spw_default_settings();

		// Update plugin version to option
		update_option( 'ibwp_spw_plugin_version', '1.0', false );
	}

	// Create Table
	ibwpl_spw_create_tables();

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();
}

add_action( 'ibwp_module_activation_hook_spin-wheel', 'ibwpl_spw_install' );

//Taking some globals
global $ibwp_spw_options;

// Function File
require_once ( IBWPL_SPW_DIR . '/includes/ibwp-spw-functions.php' );
$ibwp_spw_options = ibwpl_get_settings( 'ibwp_spw_options' );

// Plugin Template Functions
require_once( IBWPL_SPW_DIR . '/includes/ibwp-spw-template-functions.php' );

// Plugin Post Type File
require_once( IBWPL_SPW_DIR . '/includes/ibwp-spw-post-type.php' );

// Script Class File
require_once ( IBWPL_SPW_DIR . '/includes/class-ibwp-spw-script.php' );

// Public Class
require_once ( IBWPL_SPW_DIR . '/includes/class-ibwp-spw-public.php' );

// Load admin files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {

	// Admin Class File
	require_once( IBWPL_SPW_DIR . '/includes/admin/class-ibwp-spw-admin.php' );

	// Plugin Settings
	require_once( IBWPL_SPW_DIR . '/includes/admin/settings/register-settings.php' );

	// Form Entries Functions
	require_once( IBWPL_SPW_DIR . '/includes/admin/form/form-entries-fuctions.php' );

	// Form Entries Export Function File
	require_once( IBWPL_SPW_DIR . '/includes/admin/tools/export-functions.php' );
}