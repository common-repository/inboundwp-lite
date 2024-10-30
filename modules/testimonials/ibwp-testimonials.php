<?php
/**
 * Testimonials Module
 * 
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

IBWP_Lite()->define( 'IBWPL_TM_DIR_NAME', 'testimonials' );
IBWP_Lite()->define( 'IBWPL_TM_DIR', dirname( __FILE__ ) );			// Plugin dir
IBWP_Lite()->define( 'IBWPL_TM_URL', plugin_dir_url( __FILE__ ) );	// Plugin url
IBWP_Lite()->define( 'IBWPL_TM_POST_TYPE', 'testimonial' );			// Post Type
IBWP_Lite()->define( 'IBWPL_TM_CAT', 'testimonial-category' );		// Category
IBWP_Lite()->define( 'IBWPL_TM_META_PREFIX', '_wtwp_' );				// Meta Prefix

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * stest default values for the plugin options.
 *
 * @since 1.0
 */
function ibwpl_tm_install() {

	// Custom post type and taxonomy function
	ibwpl_tm_register_post_type();
	ibwpl_tm_register_taxonomies();

	// Get settings for the plugin
	$wpwt_pro_options = get_option( 'wtwp_pro_options' );

	if( empty( $wpwt_pro_options ) ) { // Check plugin version option
		
		// Set default settings
		ibwpl_tm_default_settings();
		
		// Update plugin version to option
		update_option( 'ibwp_tm_plugin_version', '1.0', false );
	}

	// Unique key for security
	update_option( 'ibwp_sec_key_rand', ibwpl_gen_random_str( 16 ), false );

	// Need to call when custom post type is being used in plugin
	flush_rewrite_rules();
}

add_action( 'ibwp_module_activation_hook_testimonials', 'ibwpl_tm_install' );

// Global variables
global $wtwp_pro_options;

// Functions file
require_once( IBWPL_TM_DIR . '/includes/ibwp-tm-functions.php' );
$wtwp_pro_options = ibwpl_get_settings( 'wtwp_pro_options' );

// Plugin Settings
require_once( IBWPL_TM_DIR . '/includes/admin/settings/register-settings.php' );

// Register post type file
require_once( IBWPL_TM_DIR . '/includes/ibwp-tm-post-types.php' );

// Script class file
require_once( IBWPL_TM_DIR . '/includes/class-ibwp-tm-script.php' );

// Shortcode File
require_once( IBWPL_TM_DIR . '/includes/shortcode/ibwp-tm-grid.php' );
require_once( IBWPL_TM_DIR . '/includes/shortcode/ibwp-tm-slider.php' );

// Requiring Testimonial widget file
require_once( IBWPL_TM_DIR . '/includes/widgets/class-ibwp-tm-widget.php' );

// Load admin files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {

	// Admin class file
	require_once( IBWPL_TM_DIR . '/includes/admin/class-ibwp-tm-admin.php' );

	// Getting Started File
	require_once( IBWPL_TM_DIR . '/includes/admin/ibwp-tm-how-it-work.php' );
}