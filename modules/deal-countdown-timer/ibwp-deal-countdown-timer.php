<?php
/**
 * Countdown Module
 *
 * @package InboundWP Lite
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */

/**
 * Basic plugin definitions
 * 
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */

IBWP_Lite()->define( 'IBWPL_DCDT_DIR', dirname( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_DCDT_URL', plugin_dir_url( __FILE__ ) );
IBWP_Lite()->define( 'IBWPL_DCDT_POST_TYPE', 'ibwp_dcdt_countdown' ); 	// post type
IBWP_Lite()->define( 'IBWPL_DCDT_META_PREFIX', '_ibwp_dcdt_' ); 	// meta prefix
IBWP_Lite()->define( 'IBWPL_DCDT_VERSION', '1.0' );

/**
 * Plugin Setup (On Activation)
 *
 * Does the initial setup, set default values for the plugin options.
 *
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */
function ibwpl_dcdt_install() {

    ibwpl_dcdt_register_post_type();

    // IMP need to flush rules for custom registered post type
    flush_rewrite_rules();

    // Update plugin version to option
	update_option( 'ibwp_dcdt_plugin_version', '1.0', false );

}
add_action( 'ibwp_module_activation_hook_deal-countdown-timer', 'ibwpl_dcdt_install' );

// Functions file
require_once( IBWPL_DCDT_DIR . '/includes/ibwp-dcdt-functions.php' );

// Plugin Post Type File
require_once( IBWPL_DCDT_DIR . '/includes/ibwp-dcdt-post-types.php' );

// Admin Class File
require_once( IBWPL_DCDT_DIR . '/includes/admin/class-ibwp-dcdt-admin.php' );

// Script Class File
require_once( IBWPL_DCDT_DIR . '/includes/class-ibwp-dcdt-script.php' );

// Public File
require_once( IBWPL_DCDT_DIR . '/includes/class-ibwp-dcdt-public.php' );