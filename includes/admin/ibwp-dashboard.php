<?php
/**
 * Plugin Dashboard Functionality
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $ibwp_options;

$ibwp_module_cats 	= ibwpl_register_module_cats();
$ibwp_modules 		= ibwpl_plugin_modules();
$active_modules 	= IBWP_Lite()->active_modules;
$active_tab 		= ! empty( $_GET['tab'] ) ? $_GET['tab'] : 'active_modules';
?>

<div class="wrap ibwp-dashboard-wrap">
	<h2><?php _e('InboundWP Lite Dashboard', 'inboundwp-lite'); ?></h2>

	<?php if(isset($_POST['ibwp_resett_sett']) && !empty($_POST['ibwp_resett_sett'])) {

		// Resett message
		echo '<div id="message" class="updated notice notice-success is-dismissible">
				<p><strong>' . __( 'All settings reset successfully.', 'inboundwp-lite') . '</strong></p>
			  </div>';
			
	} else if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) {
		
		// Success message
		echo '<div id="message" class="updated notice notice-success is-dismissible">
				<p><strong>'.__("Your changes saved successfully.", "inboundwp-lite").'</strong></p>
			  </div>';
	}
	?>

	<form action="" method="post" class="ibwp-right">
		<div class="textright">
			<input type="submit" name="ibwp_resett_sett" value="<?php esc_html_e('Reset Settings', 'inboundwp-lite'); ?>" class="ibwp-btn button button-primary button-large ibwp-reset-sett ibwp-resett-sett-btn" id="ibwp-resett-module-btn" />
		</div>
	</form><!-- Reset settings form -->

	<form action="options.php" method="POST" class="ibwp-module-form" id="ibwp-module-form">

		<?php
			settings_fields( 'ibwp_module_options' );
		?>

		<div class="textright ibwp-clearfix">
			<input type="submit" name="ibwp_save_module" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" class="ibwp-btn ibwp-save-module-btn button button-primary button-large" id="ibwp-save-module-btn" />
		</div>

		<div class="ibwp-dashboard-header ibwp-clearfix" id="ibwp-dashboard-header">
			<div class="ibwp-dashboard-header-title"><?php _e('InboundWP', 'inboundwp-lite'); ?></div>
			<div class="ibwp-dashboard-search-icon"><span class="ibwp-tooltip" title="<?php _e('Search', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-search"></i></span></div>
			<div class="ibwp-dashboard-search-wrap ibwp-hide">
				<input class="large-text ibwp-dashboard-search" placeholder="<?php _e('Search for a module', 'inboundwp-lite'); ?>" type="text" />
			</div>
		</div><!-- end .ibwp-dashboard-header -->

		<div class="ibwp-module-vtabs-wrap ibwp-clearfix" data-default-tab="ibwp-tab-cnt-modules">
			<?php if( ! empty( $ibwp_module_cats ) && isset( $ibwp_module_cats[$active_tab] ) && ! empty( $ibwp_modules ) ) { ?>

			<ul class="ibwp-module-vtabs-nav-wrap">
			<?php foreach ($ibwp_module_cats as $module_cat_key => $module_cat_data) {

					// If no module is there for this category then continue
					if( empty($module_cat_key) ) {
						continue;
					}

					$module_cat_key 	= sanitize_title($module_cat_key);
					$module_cat_icon	= !empty($module_cat_data['icon']) ? $module_cat_data['icon'] 	: 'dashicons dashicons-admin-generic';
					$module_name		= !empty($module_cat_data['name']) ? $module_cat_data['name'] 	: __('No Title', 'inboundwp-lite');
					$active_tab_cls 	= ($module_cat_key == $active_tab) ? 'ibwp-module-active-vtab'	: '';
					$tab_link			= add_query_arg( array('page' => IBWPL_PAGE_SLUG, 'tab' => $module_cat_key), admin_url('admin.php') );
			?>

				<li class="ibwp-module-vtabs-nav <?php echo $active_tab_cls; ?>" id="ibwp-module-nav-<?php echo $module_cat_key; ?>">
					<a href="<?php echo $tab_link; ?>" data-cls="ibwp-tab-cnt-<?php echo $module_cat_key; ?>"><i class="<?php echo $module_cat_icon; ?>"></i> <?php echo $module_name; ?></a>
				</li>

			<?php } ?>
			</ul><!-- tab navigation -->

			<div class="ibwp-module-cnt-wrp ibwp-tab-cnt-<?php echo $active_tab; ?> ibwp-clearfix">

				<?php
				// Tab content before action
				do_action( 'ibwpl_module_tab_cnt_before', $active_tab, $ibwp_module_cats, $ibwp_modules, $active_modules );

				// Tab content action
				do_action( 'ibwpl_module_tab_cnt_'.$active_tab, $ibwp_module_cats, $ibwp_modules, $active_modules );

				// Tab content after action
				do_action( 'ibwpl_module_tab_cnt_after', $active_tab, $ibwp_module_cats, $ibwp_modules, $active_modules );
				?>

			</div><!-- end .ibwp-module-cnt-wrp -->

			<?php } else { ?>

			<div class="ibwp-no-module"><?php _e('Sorry, something happend wrong.', 'inboundwp-lite'); ?></div>

			<?php } ?>

			<div class="ibwp-save-info-wrap ibwp-hide">
				<?php _e('Hey, Sparky some settings has been changed. Do not forget to save.', 'inboundwp-lite'); ?>
				<div class="ibwp-save-info-btn-wrap"><input id="ibwp-save-notify-btn" class="ibwp-btn ibwp-save-notify-btn" name="ibwp_save_module" value="<?php esc_html_e('Save Changes', 'inboundwp-lite'); ?>" type="submit" /><span class="ibwp-save-info-close" title="<?php _e('Close', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-dismiss"></i></span></div>
			</div>
		</div><!-- end .ibwp-module-vtabs-wrap -->

		<div class="ibwp-dashboard-footer ibwp-clearfix" id="ibwp-dashboard-footer">
			<?php echo __('InboundWP Lite', 'inboundwp-lite') .' '. IBWPL_VERSION; ?>
		</div><!-- end .ibwp-dashboard-footer -->
	</form>
</div><!-- end .wrap -->