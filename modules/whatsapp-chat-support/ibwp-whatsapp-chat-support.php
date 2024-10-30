<?php
/**
 * WhatsApp Chat Support Module
 * 
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

IBWP_Lite()->define( 'IBWPL_WTCS_DIR_NAME', 'whatsapp-chat-support' );
IBWP_Lite()->define( 'IBWPL_WTCS_DIR', dirname( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_WTCS_URL', plugin_dir_url( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_WTCS_POST_TYPE', 'ibwp_wtacs' );
IBWP_Lite()->define( 'IBWPL_WTCS_META_PREFIX', '_ibwp_wtacs_' );

/* Set For Mobile and Desktop Visitor */
if( wp_is_mobile() ) {
	IBWP_Lite()->define( 'IBWPL_WTCS_API', 'whatsapp://send' );
} else {
	IBWP_Lite()->define( 'IBWPL_WTCS_API', 'https://web.whatsapp.com/send' );
}

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup, set default values for the plugin options.
 *
 * @subpackage WhatsApp Chat Support
 * @since 1.0
 */
function ibwpl_wtcs_install() {

	ibwpl_wtcs_register_post_type();

	// Get settings for the plugin
	$ibwp_wtcs_options = get_option( 'ibwp_wtcs_options' );

	if( empty( $ibwp_wtcs_options ) ) { // Check plugin version option

		// Set default settings
		ibwpl_wtcs_default_settings();

		// Update plugin version to option
		update_option( 'ibwp_wtcs_plugin_version', '1.0', false );
	}

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();
}
add_action( 'ibwp_module_activation_hook_whatsapp-chat-support', 'ibwpl_wtcs_install' );

//Taking some globals
global $ibwp_wtcs_options;

// Function File
require_once( IBWPL_WTCS_DIR . '/includes/ibwp-wtcs-functions.php' );
$ibwp_wtcs_options = ibwpl_get_settings( 'ibwp_wtcs_options' );

// Plugin Settings
require_once( IBWPL_WTCS_DIR . '/includes/admin/settings/register-settings.php' );

// Post Type File
require_once( IBWPL_WTCS_DIR . '/includes/ibwp-wtcs-post-types.php' );

// Script Class File
require_once( IBWPL_WTCS_DIR . '/includes/class-ibwp-wtcs-script.php' );

// Admin Class File
require_once( IBWPL_WTCS_DIR . '/includes/admin/class-ibwp-wtcs-admin.php' );

// Public Class File
require_once( IBWPL_WTCS_DIR . '/includes/class-ibwp-wtcs-public.php' );