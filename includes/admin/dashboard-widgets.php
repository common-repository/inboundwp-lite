<?php
/**
 * Plugin Dashboard Widgets
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the dashboard widgets
 *
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_register_dashboard_widgets() {
	if ( current_user_can( 'manage_options' ) ) {
		wp_add_dashboard_widget( 'ibwp_dashboard', __('InboundWP Lite - Marketing Plugin', 'inboundwp-lite' ), 'ibwpl_render_dashboard_widget' );
	}
}
add_action('wp_dashboard_setup', 'ibwpl_register_dashboard_widgets' );

/**
 * InboundWP Dashboard Summery
 *
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_render_dashboard_widget() {

	$active_modules			= IBWP_Lite()->active_modules;
	$active_modules_no		= count( $active_modules );
	$ibwp_module_cats		= ibwpl_register_module_cats();
	$dashboard_link			= ibwpl_get_plugin_link();
	$cat_modules			= ibwpl_plugin_modules();
	$cat_active_modules		= ibwpl_plugin_modules( 'active' );
	$count					= 0;
?>
	<div class="ibwp-dashboard-widget ibwp-cnt-wrap">

		<div class="ibwp-dashboard-widget-logo ibwp-center"><img src="<?php echo IBWPL_URL.'assets/images/inboundwp-pro.png'?>" alt="" /></div>

		<?php if( !empty( $ibwp_module_cats ) ) { ?>
		<div class="ibwp-wdgt-modules-wrap ibwp-clearfix">
			<?php foreach ($ibwp_module_cats as $module_cat_key => $module_cat_data) {

					if( $module_cat_key == 'active_modules' ) {
						continue;
					}

					$count++;
					$class					= ( $count % 2 == 1 ) ? 'ibwp-wdgt-module-first' : 'ibwp-wdgt-module-last';
					$module_link			= ibwpl_get_plugin_link( 'default', array('tab' => $module_cat_key) );
					$total_cat_module		= !empty( $cat_modules[ $module_cat_key ] ) ? count( $cat_modules[ $module_cat_key ] ) : 0;
					$total_active_module	= !empty( $cat_active_modules[ $module_cat_key ] ) ? count( $cat_active_modules[ $module_cat_key ] ) : 0;
			?>
				<div class="ibwp-wdgt-module <?php echo $class; ?>">
					<div class="ibwp-wdgt-module-inr-wrap">
						<div class="ibwp-wdgt-module-data">
							<i class="<?php echo $module_cat_data['icon']; ?>"></i>
							<a href="<?php echo esc_url( $module_link ); ?>"><?php echo $module_cat_data['name']; ?></a>
						</div>
						<div class="ibwp-wdgt-module-msg"><?php echo esc_html__('Total', 'inboundwp-lite') .' : '. $total_cat_module .' &mdash; '. esc_html__('Active', 'inboundwp-lite') .' : '. $total_active_module; ?></div>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php } ?>

		<?php do_action( 'ibwpl_dashboard_widget' ); ?>

		<hr/>
		<p class="ibwp-version-message"><?php echo sprintf( __('InboundWP Lite %s running <a href="%s">%s modules</a>.', 'inboundwp-lite'), IBWPL_VERSION, $dashboard_link, $active_modules_no ); ?></p>
	</div>

<?php
}