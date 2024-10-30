<?php
/**
 * Plugin Name: InboundWP Lite - A Complete Inbound Marketing Pack
 * Plugin URI: https://www.wponlinesupport.com/wp-plugin/inboundwp-marketing-plugin/
 * Description: InboundWP Lite - A method of attracting, engaging, and delighting people to grow a business that provides value and builds trust.
 * Author: WP OnlineSupport
 * Author URI: https://www.wponlinesupport.com/
 * Text Domain: inboundwp-lite
 * Domain Path: /languages/
 * Version: 1.1
 * 
 * @package WordPress
 * @author WP OnlineSupport
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'InboundWP_Lite' ) ) :

/**
 * Main InboundWP Class By WP Online Support.
 *
 * @package InboundWP Lite
 * @since 1.0
 */
final class InboundWP_Lite {

	/**
	 * @var Instance
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * @var Plugin DB Version
	 * @since 1.0
	 */
	public $db_version = null;

	/**
	 * Plugin Register Modules
	 *
	 * @since 1.0
	 */
	public $register_modules = array();

	/**
	 * Plugin Active Modules
	 *
	 * @since 1.0
	 */
	public $active_modules = array();

	/**
	 * Plugin Inactive Modules
	 *
	 * @since 1.0
	 */
	public $inactive_modules = array();

	/**
	 * Plugin post supports
	 *
	 * @since 1.0
	 */
	public $post_supports;

	/**
	 * Plugin taxonomy supports
	 *
	 * @since 1.0
	 */
	public $taxonomy_supports;

	/**
	 * Script Object.
	 *
	 * @since 1.0
	 */
	public $script;

	/**
	 * Script Object.
	 *
	 * @since 1.0
	 */
	public $email;

	/**
	 * Main InboundWP Instance.
	 *
	 * Insures that only one instance of InboundWP exists in memory at any one time.
	 * Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0
	 * @uses InboundWP::setup_constants() Setup the constants needed.
	 * @uses InboundWP::includes() Include the required files.
	 * @uses InboundWP::ibwpl_plugins_loaded() load the language files.
	 * @see IBWP_Lite()
	 * @return object|InboundWP The one true InboundWP
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
			self::$_instance->db_version	= get_option( 'ibwp_plugin_version' );
			self::$_instance->script		= new IBWPL_Script();
			self::$_instance->email			= new IBWPL_Email();
		}

		return self::$_instance;
	}

	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'inboundwp-lite' ), '1.0' );
	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'inboundwp-lite' ), '1.0' );
	}

	/**
	 * Plugin Constructor.
	 */
	public function __construct() {
		$this->setup_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'inboundwp_loaded' );
	}

	/**
	 * Setup plugin constants. Basic plugin definitions
	 *
	 * @access private
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	private function setup_constants() {

		$this->define( 'IBWPL_VERSION', '1.1' );
		$this->define( 'IBWPL_PLUGIN_FILE', __FILE__ );
		$this->define( 'IBWPL_DIR', plugin_dir_path( __FILE__ ) );
		$this->define( 'IBWPL_URL', plugin_dir_url( __FILE__ ) );
		$this->define( 'IBWPL_BASENAME', plugin_basename( __FILE__ ) );
		$this->define( 'IBWPL_META_PREFIX', '_ibwp_' );
		$this->define( 'IBWPL_PAGE_SLUG', 'ibwp-dashboard' );
		$this->define( 'IBWPL_TEMPLATE_DEBUG_MODE', false );
		$this->define( 'IBWPL_STORE_URL', 'https://www.wponlinesupport.com' );
		$this->define( 'IBWPL_ITEM_NAME', 'InboundWP Lite' );
		$this->define( 'IBWPL_PRO_LINK', "https://www.wponlinesupport.com/wp-plugin/inboundwp-marketing-plugin/" );
		$this->define( 'IBWPL_FREE_LINK', "https://wordpress.org/plugins/inboundwp-lite/" );
		$this->define( 'IBWPL_UPGRADE_LINK', 'https://www.wponlinesupport.com/wp-plugin/inboundwp-marketing-plugin/?utm_source=WP&utm_medium=InboundWP&utm_campaign=Features-PRO'); // Upgrade Pro Link
		$this->define( 'IBWPL_PREVIEW_LINK', add_query_arg( array('page' => 'ibwp-module-preview'), admin_url( 'admin.php' ) ) );
	}

	/**
	 * Loads the plugin language files.
	 *
	 * @access public
	 * @package InboundWP Lite
	 * @since 1.0
	 * @return void
	 */
	public function ibwpl_load_plugin_textdomain() {
		global $wp_version;

		// Set filter for plugin's languages directory
		$ibwp_lang_dir = dirname( plugin_basename( IBWPL_PLUGIN_FILE ) ) . '/languages/';
		$ibwp_lang_dir = apply_filters( 'ibwpl_languages_directory', $ibwp_lang_dir );

		// Traditional WordPress plugin locale filter.
		$get_locale = get_locale();

		if ( $wp_version >= 4.7 ) {
			$get_locale = get_user_locale();
		}

		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale',  $get_locale, 'inboundwp-lite' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'inboundwp-lite', $locale );

		// Setup paths to current locale file
		$mofile_global  = WP_LANG_DIR . '/plugins/' . basename( IBWPL_DIR ) . '/' . $mofile;

		if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
			load_textdomain( 'inboundwp-lite', $mofile_global );
		} else { // Load the default language files
			load_plugin_textdomain( 'inboundwp-lite', false, $ibwp_lang_dir );
		}
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param  string $name
	 * @package InboundWP Lite
	 * @param  string|bool $value
	 */
	public function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	private function includes() {

		global $ibwp_options;

		require_once IBWPL_DIR . 'includes/ibwp-functions.php';
		require_once IBWPL_DIR . 'includes/ibwp-module-functions.php';
		require_once IBWPL_DIR . 'includes/admin/settings/register-settings.php';
		$ibwp_options = ibwpl_get_settings();

		require_once IBWPL_DIR . 'includes/install.php';
		require_once IBWPL_DIR . 'includes/class-ibwp-script.php';
		require_once IBWPL_DIR . 'includes/class-ibwp-email.php';
		require_once IBWPL_DIR . 'includes/ibwp-template-functions.php';

		require_once IBWPL_DIR . 'includes/admin/class-ibwp-admin.php';

		// Admin Only Files
		if ( is_admin() ) {
			require_once IBWPL_DIR . 'includes/admin/class-ibwp-admin-help.php';
			require_once IBWPL_DIR . 'includes/admin/class-ibwp-admin-pointers.php';
			include_once IBWPL_DIR . 'includes/admin/class-ibwp-upgrade.php';

			include_once IBWPL_DIR . 'includes/admin/dashboard-widgets.php';
			include_once IBWPL_DIR . 'includes/admin/ibwp-export-functions.php';
		}
	}

	/**
	 * Hook into actions and filters.
	 * @package InboundWP Lite
	 * @since  1.0
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'ibwpl_plugins_loaded' ), 12 );
		add_action( 'init', array( $this, 'ibwpl_init' ), 5 );
		add_action( 'admin_init', array( $this, 'ibwpl_admin_init' ), 5 );

		// Plugin updator
		//add_action( 'admin_init', array($this, 'ibwpl_plugin_updater'), 0 );
	}

	/**
	 * Loads the plugin language files.
	 *
	 * @access public
	 * @package InboundWP Lite
	 * @since 1.0
	 * @return void
	 */
	public function ibwpl_plugins_loaded() {

		global $pagenow, $ibwp_module_intgs;

		$this->ibwpl_load_plugin_textdomain(); // Load plugin text domain
		$this->define( 'IBWPL_SCREEN_ID', sanitize_title(__('InboundWP Lite', 'inboundwp-lite')) ); // Defining page slug after localization

		// If settings is reset
		if( ! empty( $_POST['ibwp_resett_sett'] ) ) {

			// Assign old modules to temp cache so deactivation hook is called
			$ibwp_modules_activity = array(
										'recently_deactive_module'	=> ibwpl_get_active_modules(),
									);
			set_transient( 'ibwp_modules_activity', $ibwp_modules_activity, HOUR_IN_SECONDS );

			ibwpl_default_settings(); // Set default settings

			update_option( 'ibwp_mc_info', '', false ); // Flush Integration Data
		}

		// Getting active / inactive modules
		$this->register_modules = ibwpl_register_modules();
		$this->active_modules 	= ibwpl_get_active_modules();
		$this->inactive_modules = ibwpl_get_inactive_modules();

		$register_modules 		= $this->register_modules;

		// Load active modules
		if( ! empty($this->active_modules) ) {
			foreach ($this->active_modules as $module_key => $module_val) {

				$module_key = sanitize_title( $module_key );

				if( ! empty($module_val) && ! empty($module_key) && isset($register_modules[$module_key]) && !empty($register_modules[$module_key]['path']) ) {
					include_once( $register_modules[$module_key]['path'] );
				}

				// If module has integration support
				if( ! empty( $register_modules[ $module_key ]['integration'] ) ) {
					$ibwp_module_intgs = 1;
				}
			}
		} // End of if


		/**
		 * Deactivation process of module
		 * Run only for Admin and Inbound Dashboard Page
		 */
		if( ( $pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == IBWPL_PAGE_SLUG && ! empty( $_GET['settings-updated'] ) ) ||
			( $pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == IBWPL_PAGE_SLUG && ! empty($_POST['ibwp_resett_sett']) ) ||
			( $pagenow == 'plugins.php' && isset($_GET['activate']) && $_GET['activate'] == 'true' )
		) {

			$ibwp_modules_activity = get_transient( 'ibwp_modules_activity' );

			if( ! empty($ibwp_modules_activity['recently_deactive_module']) ) {

				$recently_deactive_module = $ibwp_modules_activity['recently_deactive_module'];

				// If module is going to be deactive then include uninstall file for deactivation
				foreach ($recently_deactive_module as $deactive_module_key => $deactive_module_val) {

					if( ! empty($deactive_module_key) && isset($register_modules[$deactive_module_key]) && !empty($register_modules[$deactive_module_key]['path']) ) {
						$module_path 			= plugin_dir_path( $register_modules[$deactive_module_key]['path'] );
						$module_uninstall_file 	= $module_path.'uninstall.php';
						
						if( $module_path && file_exists($module_uninstall_file) ) {
							include_once( $module_uninstall_file );
						}
					}
				}
			}
		} // End of deactivation
	}

	/**
	 * Init InboundWP when WordPress Initialises.
	 */
	public function ibwpl_init() {

		global $pagenow;

		// Before init action.
		do_action( 'before_ibwpl_init' );

		// Run only for Admin and Inbound Dashboard
		if( ( $pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == IBWPL_PAGE_SLUG && ! empty( $_GET['settings-updated'] ) ) ||
			( $pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == IBWPL_PAGE_SLUG && ! empty( $_POST['ibwp_resett_sett'] ) ) ||
			( $pagenow == 'plugins.php' && isset($_GET['activate']) && $_GET['activate'] == 'true' )
		) {

			// Activation and deactivation hook of module
			$ibwp_modules_activity = get_transient( 'ibwp_modules_activity' );

			if( ! empty($ibwp_modules_activity) ) {

				$recently_active_module 	= isset($ibwp_modules_activity['recently_active_module']) 	? $ibwp_modules_activity['recently_active_module'] 		: array();
				$recently_deactive_module 	= isset($ibwp_modules_activity['recently_deactive_module']) ? $ibwp_modules_activity['recently_deactive_module'] 	: array();

				// Module deactivation hook
				if( ! empty( $recently_deactive_module ) ) {
					foreach ($recently_deactive_module as $deactive_module_key => $deactive_module_val) {
						do_action( 'ibwp_module_deactivation_hook_'.$deactive_module_key );
						do_action( 'ibwp_module_deactivation_hook', $deactive_module_key );
					}
				}

				// Module activation hook
				if( ! empty( $recently_active_module ) ) {
					foreach ($recently_active_module as $active_module_key => $active_module_val) {
						do_action( 'ibwp_module_activation_hook_'.$active_module_key );
						do_action( 'ibwp_module_activation_hook', $active_module_key );
					}
				}

				set_transient( 'ibwp_modules_activity', '', HOUR_IN_SECONDS ); // Flush the temp activity
			}
		}

		// Init action.
		do_action( 'ibwpl_init' );
	}

	/**
	 * InboundWP init hook at admin side
	 */
	public function ibwpl_admin_init() {

		// Before init action.
		do_action( 'before_ibwpl_admin_init' );

		$this->post_supports 		= ibwpl_post_supports(); 	// Post type supports
		$this->taxonomy_supports 	= ibwpl_taxonomy_supports(); // Taxonomy supports

		// Init action.
		do_action( 'ibwpl_admin_init' );
	}
}

endif; // End if class_exists check.

/**
 *
 * The main function responsible for returning the one true InboundWP
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $ibwp_pro = IBWP_Lite(); ?>
 *
 * @since 1.0
 * @return object|InboundWP The one true InboundWP Instance.
 */
function IBWP_Lite() {
	return InboundWP_Lite::instance();
}

// Get plugin Running.
IBWP_Lite();