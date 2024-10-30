<?php
/**
 * Upgrade Class
 *
 * Handles the plugin upgrade functionality
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWP_Lite_Upgrade {

	function __construct() {

		// Action to display notice
		add_action( 'admin_notices', array($this, 'ibwpl_plugin_upgrade_notice') );

		// Action to upgrade DB process
		add_action( 'admin_init', array($this, 'ibwpl_plugin_upgrade_process') );
	}

	/**
	 * Function to display plugin upgrade notice
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_plugin_upgrade_notice() {

		// Take current DB version
		$ibwp_db_version	= IBWP_Lite()->db_version;
		$active_modules		= IBWP_Lite()->active_modules;

		if( version_compare( $ibwp_db_version, '1.1' ) < 0 && $active_modules ) {

			$upgrade_path = add_query_arg( array( 'page' => 'ibwp-dashboard', 'ibwp_action' => 'db_upgrade' ), admin_url( 'admin.php' ) );
			$upgrade_path = wp_nonce_url( $upgrade_path, 'ibwp-upgrade-db' );

			echo '<div class="notice notice-info">
					<p><strong>'.esc_html__('InboundWP Lite database update required', 'inboundwp-lite').'</strong></p>
					<p><strong>'.esc_html__('InboundWP Lite has been updated with awesome many more features and better user experience! To keep things running smoothly, we have to update your database to the newest version.', 'inboundwp-lite').'</strong></p>
					<p><a class="button button-primary" href="'.esc_url( $upgrade_path ).'">'.esc_html__('Upgrade Now', 'inboundwp-lite').'</a></p>
				</div>';
		}

		// DB Updated Notice
		if( isset( $_GET['message'] ) && $_GET['message'] == 'ibwp-upgrade-db' ) {
			echo '<div class="notice notice-success">
					<p><strong>'.esc_html__('InboundWP Lite - Data update process has been done successfully.', 'inboundwp-lite').'</strong></p>
				</div>';
		}
	}

	/**
	 * Function to run plugin upgrade process
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_plugin_upgrade_process() {

		if( isset( $_GET['page'] ) && $_GET['page'] == IBWPL_PAGE_SLUG && isset( $_GET['ibwp_action'] ) && $_GET['ibwp_action'] == 'db_upgrade' && check_admin_referer('ibwp-upgrade-db') ) {

			$active_modules = IBWP_Lite()->active_modules;

			// To call all active modules activation hook
			if( ! empty( $active_modules ) ) {
				$ibwp_modules_activity = array(
											'recently_active_module' => $active_modules,
										);
				set_transient( 'ibwp_modules_activity', $ibwp_modules_activity, HOUR_IN_SECONDS );
			}

			// Update plugin version to latest number
			update_option( 'ibwp_plugin_version', '1.1' );

			// Redirect
			$redirect_link = ibwpl_get_plugin_link( null, array('settings-updated' => 'true', 'message' => 'ibwp-upgrade-db') );
			wp_safe_redirect( $redirect_link );
			exit;
		}
	}
}

$ibwp_lite_upgrade = new IBWP_Lite_Upgrade();