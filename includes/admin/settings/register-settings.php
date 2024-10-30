<?php
/**
 * Plugin setting functions file
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update default settings
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_default_settings() {

    global $ibwp_options;

    $ibwp_options = array();

    $default_options = apply_filters('ibwpl_options_default_values', $ibwp_options );

    // Update default options
    update_option( 'ibwp_opts', $default_options );

    // Overwrite global variable when option is update
    $ibwp_options = ibwpl_get_settings();
}

/**
 * Get Settings From Option Page
 * 
 * Handles to return all settings value
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_settings( $key = 'ibwp_opts' ) {

    $options    = get_option( $key );
    $settings   = is_array($options)  ? $options : array();

    return $settings;
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_option( $key = '', $default = false, $opts_arr = '', $unique = 'inboundwp-lite' ) {

	global $ibwp_options;

	$opts_arr	= ! empty( $opts_arr ) ? $opts_arr : $ibwp_options;
    $value		= ! empty( $opts_arr[ $key ] ) ? $opts_arr[ $key ] : $default;
    $value		= apply_filters( 'ibwpl_get_option', $value, $key, $default, $opts_arr, $unique );

    return apply_filters( 'ibwpl_get_option_' . $key, $value, $key, $default, $opts_arr, $unique );
}

// Action to register plugin settings
add_action ( 'admin_init', 'ibwpl_register_module_settings' );

/**
 * Function register setings
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_register_module_settings() {
	register_setting( 'ibwp_module_options', 'ibwp_opts', 'ibwpl_validate_module_options' );
}

/**
 * Validate Settings Options
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_validate_module_options( $input = array() ) {

	global $ibwp_options, $ibwp_module_intgs;

	// Taking some variables
	$input = $input ? $input : array();

	$doing_save = false;
	if ( ! empty( $_POST['_wp_http_referer'] ) ) {
		$doing_save = true;
	}

	if ( $doing_save ) {
		parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab
		$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'modules';

		// Run a general sanitization for the tab for special fields
		$input = apply_filters( 'ibwpl_settings_sanitize', $input );
		$input = apply_filters( 'ibwpl_settings_' . $tab . '_sanitize', $input );
	}

	// Merge our new settings with the existing
	$output = array_merge( $ibwp_options, $input );

	if( ! empty( $_POST['ibwp_save_module'] ) ) {

		$old_active_modules = IBWP_Lite()->active_modules;
		$new_active_modules = ibwpl_get_active_modules(true); // Get recently active modules

		$old_inactive_modules = IBWP_Lite()->inactive_modules;
		$new_inactive_modules = ibwpl_get_inactive_modules(true); // Get recently inactive modules

		$recently_active_module 	= array_diff_assoc($new_active_modules, $old_active_modules);
		$recently_deactive_module 	= array_diff_assoc($new_inactive_modules, $old_inactive_modules);

		$ibwp_modules_activity = array(
								'recently_active_module' 	=> $recently_active_module,
								'recently_deactive_module'	=> $recently_deactive_module
							);

		set_transient( 'ibwp_modules_activity', $ibwp_modules_activity, HOUR_IN_SECONDS );
	}

	return $output;
}

/**
 * Render plugin modules
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_render_modules( $tab, $module_cats, $modules, $active_modules ) {

	// If no module is there then continue
	if( empty($tab) || empty($modules[$tab]) ) {
		return false;
	}

	$count 					= 1;
	$supports_info 			= ibwpl_module_support_info();
	$module_name 			= !empty($module_cats[$tab]['name']) ? $module_cats[$tab]['name'] : __('No Title', 'inboundwp-lite');
	$cat_active_module 		= ibwpl_plugin_modules( 'active', $tab );
	$cat_inactive_module 	= ibwpl_plugin_modules( 'in_active', $tab );
	$cat_active_module_no	= count( $cat_active_module );
	$cat_inactive_module_no	= count( $cat_inactive_module );
?>

	<div class="ibwp-module-info-wrap">
		<div class="ibwp-module-title"><?php echo $module_name; ?></div>
		<?php if( !empty($module_cats[$tab]['desc']) ) { ?>
		<span class="ibwp-module-desc description"><?php echo $module_cats[$tab]['desc']; ?></span>
		<?php } ?>
	</div><!-- end .ibwp-module-info-wrap -->

	<div class="ibwp-site-modules-wrap ibwp-clearfix">
		<div class="ibwp-site-modules-inr-wrap ibwp-icolumns-wrap">

			<div class="ibwp-icolumns ibwp-medium-12 ibwp-module-sort-cat-wrap">
			<?php if( $tab == 'active_modules' ) {

				// Getting active category (Alt : array_columns)
				$active_cats = array_map(function($element){return $element['category'];}, $modules['active_modules']);
			?>
				<select class="ibwp-module-sort-cat ibwp-no-chage">
					<option value=""><?php _e('Select Category', 'inboundwp-lite'); ?></option>
					<?php foreach ($module_cats as $module_cat_key => $module_cat_data) {

						// If no module is there for this category or no module is active for this category then continue
						if( empty($module_cat_key) || !isset($modules[$module_cat_key]) || empty($module_cat_data['is_filter']) || !in_array($module_cat_key, $active_cats) ) {
							continue;
						}

						$module_cat_name = !empty($module_cat_data['name']) ? $module_cat_data['name'] : $module_cat_key;
					?>
					<option value="<?php echo $module_cat_key; ?>" class="ibwp-module-filtr-cat" data-filter=".ibwp-site-module-<?php echo $module_cat_key; ?>"><?php echo $module_cat_name; ?></option>
					<?php } ?>
				</select>
			<?php } else {
				$active_disabled 	= empty($cat_active_module_no) ? 'disabled="disabled" title="'.__('No Module is Enabled', 'inboundwp-lite').'"' 		: '';
				$inactive_disabled 	= empty($cat_inactive_module_no) ? 'disabled="disabled" title="'.__('No Module is Disabled', 'inboundwp-lite').'"' 	: '';
			?>
				<select class="ibwp-module-sort-cat ibwp-no-chage">
					<option value=""><?php _e('Select All', 'inboundwp-lite'); ?></option>
					<option value="active" <?php echo $active_disabled; ?>><?php _e('Enabled', 'inboundwp-lite'); ?></option>
					<option value="inactive" <?php echo $inactive_disabled; ?>><?php _e('Disabled', 'inboundwp-lite'); ?></option>
				</select>
			<?php } ?>
			</div><!-- end .ibwp-module-sort-cat-wrap -->

			<?php foreach ($modules[$tab] as $sub_module_key => $sub_module_data) {

				// If no module is there then continue
				if( empty( $sub_module_key ) ) {
					continue;
				}

				$sub_module_key 	= sanitize_title( $sub_module_key );
				$sub_module_cat 	= $sub_module_data['category'];
				$sub_module_name 	= ! empty( $sub_module_data['name'] )		? $sub_module_data['name'] : __('No Title', 'inboundwp-lite');
				$sub_module_name 	= ! empty( $sub_module_data['premium'] )	? $sub_module_name.' - '.ibwpl_upgrade_pro_link() : $sub_module_name;
				$conf_text			= ! empty( $sub_module_data['conf_text'] )	? $sub_module_data['conf_text'] : __('Configure', 'inboundwp-lite');
				$is_active_module 	= isset( $active_modules[$sub_module_key] )	? 1 : 0;

				$module_cls = "ibwp-site-module-{$sub_module_cat} ibwp-site-module-{$sub_module_key}";
				$module_cls	.= ( $is_active_module )					? ' ibwp-site-module-active'	: ' ibwp-site-module-inactive';
				$module_cls .= ! empty( $sub_module_data['premium'] )	? ' ibwp-site-module-premium'	: '';
			?>

			<div class="ibwp-site-module-wrap ibwp-medium-6 <?php echo $module_cls; ?>">
				<div class="ibwp-site-module-data-wrap">					
					<div class="ibwp-site-module-title">
						<div class="ibwp-site-module-act">
							<?php if( !empty($sub_module_data['extra_info']) ) { ?>
							<i class="ibwp-tooltip ibwp-module-extra-info dashicons dashicons-info" data-tooltip-content="#<?php echo $sub_module_key; ?>-tooltip-content"></i>
							<?php } ?>
							<?php if( !empty($sub_module_data['path']) ) { ?>
							<input type="hidden" name="ibwp_opts[<?php echo $sub_module_cat; ?>_pack][<?php echo $sub_module_key; ?>]" value="0" />
							<label class="ibwp-check-switch ibwp-module-check-switch"><input type="checkbox" name="ibwp_opts[<?php echo $sub_module_cat; ?>_pack][<?php echo $sub_module_key; ?>]" value="1" class="ibwp-module-check" <?php checked( $is_active_module, 1 ); ?> data-module="<?php echo $sub_module_key; ?>" /><div class="ibwp-check-slider ibwp-check-switch-round"></div></label>
							<?php } ?>
						</div>
						<span><?php echo $sub_module_name; ?></span>
					</div>

					<div class="ibwp-site-module-desc"><?php echo $sub_module_data['desc']; ?></div>

					<?php if( $is_active_module && (!empty($sub_module_data['conf_link']) || !empty($sub_module_data['widget_link'])) ) { ?>
					<div class="ibwp-site-module-conf-wrap">
						<?php if( !empty($sub_module_data['conf_link']) ) { ?>
						<span class="ibwp-site-module-conf">
							<i class="dashicons dashicons-admin-generic"></i>
							<a href="<?php echo $sub_module_data['conf_link']; ?>"><?php echo $conf_text; ?></a>
						</span>
						<?php } ?>

						<?php if( !empty($sub_module_data['widget_link']) ) { ?>
						<span class="ibwp-site-module-widget">
							<i class="dashicons dashicons-schedule"></i>
							<a href="<?php echo $sub_module_data['widget_link']; ?>"><?php _e('Widgets', 'inboundwp-lite'); ?></a>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if( !empty($sub_module_data['extra_info']) ) { ?>
					<div class="ibwp-tooltip-content ibwp-hide">
						<div id="<?php echo $sub_module_key; ?>-tooltip-content">
							<?php
							// If info is array then process else print simply
							if( is_array( $sub_module_data['extra_info'] ) ) {
								$info_title = !empty($sub_module_data['extra_info']['title']) ? $sub_module_data['extra_info']['title'] : $sub_module_name;
							?>
								<div class="ibwp-tooltip-title"><h3><?php echo $info_title; ?></h3></div>

								<?php if(!empty($sub_module_data['extra_info']['desc'])) { ?>
								<ul class="ibwp-info-features">
									<?php echo "<li>" . implode("</li><li>", (array)$sub_module_data['extra_info']['desc']) . "</li>" ?>
								</ul>
								<?php } ?>

								<?php if(!empty($sub_module_data['extra_info']['supports'])) { ?>
								<div class="ibwp-info-supports">
								<?php foreach ($sub_module_data['extra_info']['supports'] as $supp_key => $supp_val) {

									if( !isset($supports_info[$supp_val]) ) {
										continue;
									}

									$supports_title = isset($supports_info[$supp_val]['title']) ? $supports_info[$supp_val]['title'] 	: '';
									$supports_icon 	= !empty($supports_info[$supp_val]['icon']) ? $supports_info[$supp_val]['icon'] 	: 'dashicons-admin-generic';

									echo "<i title='{$supports_title}' class='dashicons {$supports_icon}'></i>";
								} ?>
								</div>
								<?php } ?>

							<?php } else {
								echo $sub_module_data['extra_info'];
							}
							?>
						</div>
					</div>
					<?php } // End of extra info ?>
				</div>
			</div><!-- end .ibwp-site-module-wrap -->

			<?php
				$count++;
			} ?>
			<div class="ibwp-columns ibwp-medium-12 ibwp-hide ibwp-no-module-search"><?php _e('Sorry, nothing matched to your search criteria. Please refine you search or search category.', 'inboundwp-lite'); ?></div>
		</div><!-- end .ibwp-site-modules-inr-wrap -->
	</div><!-- end .ibwp-site-modules-wrap -->
<?php
}
add_action( 'ibwpl_module_tab_cnt_before', 'ibwpl_render_modules', 10, 4 );

/**
 * Render active module tab cnt when no module is active
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_render_active_module_cnt( $module_cats, $modules, $active_modules ) {

	// If module is active then return
	if( ! empty( $active_modules ) ) {
		return false;
	}

	$module_link 		= add_query_arg( array('page' => IBWPL_PAGE_SLUG, 'tab' => 'modules'), admin_url('admin.php') );
	$appearance_link 	= add_query_arg( array('page' => IBWPL_PAGE_SLUG, 'tab' => 'appearance'), admin_url('admin.php') );
	$tour_link 			= ibwpl_get_plugin_link('tour');
?>

	<div class="ibwp-module-welcome-wrap ibwp-clearfix">
		<div class="ibwp-module-welcome-logo ibwp-center"><img src="<?php echo IBWPL_URL.'assets/images/inboundwp-pro.png'?>" alt="" /></div>

		<div class="ibwp-module-welcome-text">
			<?php _e('You have no module active!', 'inboundwp-lite'); ?> <br />
			<?php _e('Activate and Enjoy', 'inboundwp-lite'); ?>
		</div>

		<div class="ibwp-module-welcome-btn-group">
			<a class="ibwp-welcome-btn" href="<?php echo $module_link; ?>">
				<i class="dashicons dashicons-admin-plugins"></i> <?php _e('Add Modules', 'inboundwp-lite'); ?>
			</a>

			<a class="ibwp-welcome-btn ibwp-btn-yellow" href="<?php echo $appearance_link; ?>">
				<i class="dashicons dashicons-admin-appearance"></i> <?php _e('Site Appearance', 'inboundwp-lite'); ?>
			</a>

			<br/><br/>
			<a class="ibwp-welcome-btn ibwp-btn-red ibwp-btn-large" href="<?php echo $tour_link; ?>">
				<i class="dashicons dashicons-lightbulb"></i> <?php _e('Start a Tour', 'inboundwp-lite'); ?>
			</a>
		</div>
	</div><!-- end .ibwp-module-welcome-wrap -->

<?php
}
add_action( 'ibwpl_module_tab_cnt_active_modules', 'ibwpl_render_active_module_cnt', 10, 3 );