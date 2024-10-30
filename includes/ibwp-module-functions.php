<?php
/**
 * Plugin module generic functions file
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to to filter array to get only keys which has zero value
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_zero($var) {
	return( ($var == 0) );
}

/**
 * Function to sort module array on name
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_sort_modules($x, $y) {

	if( !isset($x['name']) || !isset($y['name']) ) {
		return false;
	}

	return strcasecmp($x['name'], $y['name']);
}

/**
 * Function to sort module key array on priority
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_sort_modules_cat($a, $b) {
	$a_priority = (!empty($a['priority']) && $a['priority'] > 0) ? $a['priority'] : 999;
	$b_priority = (!empty($b['priority']) && $b['priority'] > 0) ? $b['priority'] : 999;
	
	if ($a_priority == $b_priority) {
		return 0;
	}
	return ($a_priority < $b_priority) ? -1 : 1;
}

/**
 * Function to register plugin modules categories
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_register_module_cats() {
	$module_cats = array(
		'active_modules'=> array(
							'name'		=> __('Active Modules', 'inboundwp-lite'),
							'desc'		=> __('Activated modules on your website.' ,'inboundwp-lite'),
							'icon'		=> 'dashicons dashicons-dashboard',
							'priority'	=> 1,
						),
		'modules' 		=> array(
							'name'		=> __('Modules', 'inboundwp-lite'),
							'desc'		=> __('Enable various modules for your website.' ,'inboundwp-lite'),
							'icon'		=> 'dashicons dashicons-admin-plugins',
							'priority'	=> 2,
							'is_filter'	=> true,
						),
		'appearance'	=> array(
							'name'		=> __('Appearance', 'inboundwp-lite'),
							'desc'		=> __('Choose styling modules for your website.' ,'inboundwp-lite'),
							'icon'		=> 'dashicons dashicons-admin-appearance',
							'priority'	=> 3,
							'is_filter'	=> true,
						),
	);

	$module_cats = apply_filters( 'ibwpl_register_site_module_cats', $module_cats );
	uasort($module_cats, "ibwpl_sort_modules_cat"); // sort array on priority

	return $module_cats;
}

/**
 * Function to register plugin modules
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_register_modules() {

	$active_modules 	= ibwpl_active_modules();
	$widget_link 		= admin_url( 'widgets.php' );
	$admin_url 			= admin_url( 'admin.php' );
	$edit_url 			= admin_url( 'edit.php' );

	$modules = array(
		// Social Proof
		'social-proof' => array(
			'name'			=> __('Social Proof', 'inboundwp-lite'),
			'desc'			=> __('Display real time customer activity data like purchase and etc on website. Unique ways to influence the purchase decision & convert your visitors into paying customers.' ,'inboundwp'),
			'extra_info'	=> array(
				'title'		=> __('Social Proof & FOMO', 'inboundwp'),
				'desc'		=> array(
									__('Unique ways to influence the purchase decision & convert your visitors into paying customers.', 'inboundwp'),
									__('Leverages the true power of social proof to let your existing subscribers and customers do the selling for you.', 'inboundwp'),
									__('Allows you to show WooCommerce and Easy Digital Download sales & reviews notification to visitor.', 'inboundwp'),
									__('Allows you to show WordPress ORG Plugin, Theme stats and reviews notification to visitor.', 'inboundwp'),
									__('Allows you to show custom notification OR read data from Google Sheet.', 'inboundwp'),
									__('Page level targeting for different notifications.', 'inboundwp'),
									__('5 different designs for notification.', 'inboundwp'),
								),
				'supports'	=> array( 'analytics', 'multilanguage', 'responsive' )
			),
			'category'		=> 'modules',
			'path'			=> IBWPL_DIR.'modules/social-proof/ibwp-social-proof.php',
			'conf_link'		=> add_query_arg( array( 'post_type' => 'ibwp_sp', 'page' => 'ibwp-sp-settings' ), $edit_url ),
		),

		// Better Heading
		'better_heading' => array(
			'name'			=> __('Better Heading', 'inboundwp-lite'),
			'desc'			=> __('Split (A/B) test multiple titles for a post and discover which gets more page views. Great way to increase click through rates.' ,'inboundwp'),
			'extra_info'	=> array(
				'desc'		=> array(
					__('Split (A/B) test multiple titles for a post and discover which gets more page views. Great way to increase click through rates.', 'inboundwp'),
					__('Check daily, weekly and monthly report of every title for a post.', 'inboundwp'),
				),
				'supports'	=> array( 'analytics', 'multilanguage', 'responsive' )
			),
			'category'		=> 'modules',
			'path'			=> IBWPL_DIR.'modules/better-heading/ibwp-better-heading.php',
			'conf_link'		=> add_query_arg( array('page' => 'ibwp-bh-settings'), $admin_url ),
		),

		// Testimonial
		'testimonials' => array(
			'name'			=> __('Testimonials', 'inboundwp-lite'),
			'desc'			=> __('Testimonial OR showing reviews is an important part of product or site. Build the credebility by displaying testimonials given by users.' ,'inboundwp'),
			'extra_info'	=> array(
									'desc'		=> array(
														__('Display testimonials in a grid, slider or carousel view.', 'inboundwp'),
														__('Accepts user testimonial with form submission.', 'inboundwp'),
														__('Widget to display testimonials in a side bar.', 'inboundwp'),
														__('20 cool and stunning layouts to disply testimonials.', 'inboundwp'),
														__('Fully responsive and 100% multilanguage.', 'inboundwp'),
													),
									'supports'	=> array('shortcode', 'widget', 'multilanguage', 'responsive')
								),
			'category'		=> 'modules',
			'path'			=> IBWPL_DIR.'modules/testimonials/ibwp-testimonials.php',
			'conf_link'		=> add_query_arg( array('post_type' => 'testimonial', 'page' => 'wtwp-pro-designs'), $edit_url ),
			'widget_link'	=> $widget_link,
		),

		// Deal Countdown Timer
		'deal-countdown-timer' => array(
			'name'			=> __('Deal Countdown timer', 'inboundwp-lite'),
			'desc'			=> __('Sale Countdown Timer helps you to create flash sales and increase revenues. You can add multiple flash sales with a start and end date. Plugin also shows stock progress bar.' ,'inboundwp'),
			'extra_info'	=> array(
				'desc'		=> array(
					__('A fully responsive module to display countdown clock with multiple designs.', 'inboundwp'),
					__('You can add stock progressbar for WooCommerce product.', 'inboundwp'),
					__('Work with WooCommerce & EDD single page only.', 'inboundwp'),
					__('Provide sale product slider shortcode for WooCommerce with timer.', 'inboundwp'),

				),
				'supports'	=> array('shortcode', 'multilanguage', 'responsive')
			),
			'category'		=> 'modules',
			'path'			=> IBWPL_DIR.'modules/deal-countdown-timer/ibwp-deal-countdown-timer.php',
			'conf_link'		=> add_query_arg( array('post_type' => 'ibwp_dcdt_countdown'), $edit_url ),
		),

		// Marketing popup
		'marketing-popup' => array(
			'name'			=> __('Marketing Popup', 'inboundwp-lite'),
			'desc'			=> __('Display Popup when users click any HTML element, on exit intent, on scrolling, on idle and on page load (once per X days, every time) with certain delays.' ,'inboundwp'),
			'extra_info'	=> array(
								'desc' => array(
											__('Display Popup when users click any HTML element, on exit intent, on scrolling, on idle and on page load (once, once per session, once per X days, every time) with certain delays.', 'inboundwp'),
											__('4 types of Popup goal Email Lists, Target URL, Announcement and Get Phone Calls.', 'inboundwp'),
											__('3 types of Popup Bar, Modal and Push Notification.', 'inboundwp'),
											__('Marketing system integrations with MailChimp.', 'inboundwp'),
											__('A/B Testing and Statistics.', 'inboundwp'),
										),
				'supports'	=> array( 'shortcode', 'analytics', 'multilanguage', 'responsive' )
			),
			'category'		=> 'modules',
			'path'			=> IBWPL_DIR.'modules/marketing-popup/ibwp-marketing-popup.php',
			'conf_link'		=> add_query_arg( array('post_type' => 'ibwp_mp_popup', 'page' => 'ibwp-mp-pro-settings'), $edit_url ),
			'integration'	=> 1,
		),

		// Spin Wheel
		'spin-wheel' => array(
			'name'			=> __('Spin Wheel', 'inboundwp-lite'),
			'desc'			=> __('Grow your email list or grow your sales by offering your visitors a chance to win a coupon, or other prize through spinning the wheel of fortune.' ,'inboundwp'),
			'extra_info'	=> array(
									'desc'		=> array(
														__('Spin Wheel formaly known as Optin Wheel or Lucky Wheel.', 'inboundwp'),
														__('A fully responsive module to display Spin Wheel with custom design options to attract visitors.', 'inboundwp'),
														__('Supported with Woocommerce and Easy Digital Download.', 'inboundwp'),
														__('Set your desired goal by email notification, custom message or thank you page redirect.', 'inboundwp'),
														__('Marketing system integrations with MailChimp.', 'inboundwp'),
														__('A/B Testing and Statistics.', 'inboundwp'),
													),
									'supports'	=> array( 'shortcode', 'analytics', 'multilanguage', 'responsive' ),
								),
			'category'		=> 'modules',
			'path'			=> IBWPL_DIR.'modules/spin-wheel/ibwp-spin-wheel.php',
			'conf_link'		=> add_query_arg( array('post_type' => 'ibwp_spw_spin_wheel', 'page' => 'ibwp-spw-settings'), $edit_url ),
			'integration'	=> 1,
		),

		// Appearance
		'custom_cj'	=> array(
			'name'			=> __('Custom CSS and JS', 'inboundwp-lite'),
			'desc'			=> __('Customize site appearance by easily adding custom CSS or JS code without even having to modify your theme or plugin files.' ,'inboundwp'),
			'extra_info'	=> array(
								'desc'	=> array(
											__('Customize site appearance by easily adding custom CSS or JS code without even having to modify your theme or plugin files.', 'inboundwp'),
											__('Add CSS or JS globally or add per post or page wise.', 'inboundwp'),
										)
								),
			'category'	=> 'appearance',
			'premium'	=> true,
		),

		// WhatsApp Chat Support
		'whatsapp-chat-support' => array(
			'name'			=> __('WhatsApp Chat Support', 'inboundwp-lite'),
			'desc'			=> __('Connect, Interact and Offer support to your customers directly as well as build trust and increase loyalty with WhatsApp from any where.' ,'inboundwp'),
			'extra_info'	=> array(
								'desc' => array(
										__('One of the best way to connect and interact with your customers. Offer support directly as well as build trust and increase customer loyalty with WhatsApp from any where.', 'inboundwp'),
										__('Add a WhatsApp chatbox to your site.', 'inboundwp'),
										__('Add multiple agents and set agent status with custom messages.', 'inboundwp'),
										__('Set default message to send directly to your customer.', 'inboundwp'),
										__('Integration with WooCommerce.', 'inboundwp'),
									),
								'supports'	=> array( 'shortcode', 'analytics', 'multilanguage', 'responsive' )
							),
			'category'		=> 'modules',
			'path'			=> IBWPL_DIR.'modules/whatsapp-chat-support/ibwp-whatsapp-chat-support.php',
			'conf_link'		=> add_query_arg( array( 'post_type' => 'ibwp_wtacs', 'page' => 'ibwp-wtcs-settings' ), $edit_url ),
		),
	);

	$modules = (array) apply_filters( 'ibwpl_register_site_modules', $modules );
	uasort($modules, "ibwpl_sort_modules"); // sort array on name

	return $modules;
}

/**
 * Function to get plugin modules category wise
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_plugin_modules( $status = 'all', $category = '' ) {

	global $ibwp_options;

	$plugin_modules 	= array();
	$modules 			= IBWP_Lite()->register_modules;
	$active_modules 	= IBWP_Lite()->active_modules;
	$module_cats 		= ibwpl_register_module_cats();

	switch ($status) {
		case 'active':
		case 'in_active':
			$status_modules = ($status == 'in_active') ? IBWP_Lite()->inactive_modules : $active_modules;
			if( !empty($status_modules) ) {
				foreach ($status_modules as $module_key => $module_val) {

					$module_cat = isset($modules[$module_key]['category']) ? $modules[$module_key]['category'] : '';

					if( isset($modules[$module_key]) && $module_cat && isset($module_cats[$module_cat]) ) {
						$plugin_modules[$module_cat][$module_key] = $modules[$module_key];
					}
				}
			}
			break;

		default:
			if( !empty($modules) ) {
				foreach ($modules as $module_key => $module_data) {

					// If key is empty then continue
					if( empty($module_key) || empty($module_data['category']) || !isset($module_cats[$module_data['category']]) ) {
						continue;
					}

					$plugin_modules[$module_data['category']][$module_key] = $module_data;

					// Adding active modules
					if( !empty($active_modules) && !empty($active_modules[$module_key]) ) {
						$plugin_modules['active_modules'][$module_key] = $module_data;
					}
				}
			}
			break;
	}

	// If category is passed
	if( $category ) {
		$plugin_modules = isset($plugin_modules[$category]) ? $plugin_modules[$category] : array();
	}

	return $plugin_modules;
}

/**
 * Function to get active plugin modules
 * This is similar of ibwpl_get_active_modules() But this is for a little twik and fix for ibwpl_register_modules()
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_active_modules() {

	global $ibwp_options;

	$result_arr			= array();
	$module_cats 		= ibwpl_register_module_cats();

	if( !empty($module_cats) ) {
		foreach ($module_cats as $module_cat_key => $module_cat_val) {

			$module_cat_key = sanitize_title($module_cat_key);

			if( isset( $ibwp_options[$module_cat_key.'_pack'] ) ) {
				$result_arr = array_merge( $result_arr, $ibwp_options[$module_cat_key.'_pack'] );
				$result_arr = array_filter($result_arr);
			}
		}
	}
	return $result_arr;
}

/**
 * Function to get active plugin modules
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_active_modules( $by_post = false ) {

	global $ibwp_options;

	$result_arr			= array();
	$active_modules		= array();
	$register_modules 	= !empty(IBWP_Lite()->register_modules) ? IBWP_Lite()->register_modules : ibwpl_register_modules();
	$module_cats 		= ibwpl_register_module_cats();
	$ibwp_module_opts	= ($by_post && isset($_POST['ibwp_opts'])) ? ibwpl_clean( $_POST['ibwp_opts'] ) : $ibwp_options;

	if( !empty($module_cats) ) {
		foreach ($module_cats as $module_cat_key => $module_cat_val) {

			$module_cat_key = sanitize_title($module_cat_key);

			if( isset($ibwp_module_opts[$module_cat_key.'_pack']) ) {
				$result_arr = array_merge( $result_arr, $ibwp_module_opts[$module_cat_key.'_pack'] );
				$result_arr = array_filter($result_arr);
			}
		}

		// Checking the result array in registered modules so unnecessary module key will not remain
		if( !empty($result_arr) ) {
			foreach ($result_arr as $res_key => $res_val) {
				if( array_key_exists($res_key, $register_modules) ) {
					$active_modules[$res_key] = $res_val;
				}
			}
		}
	}

	return $active_modules;
}

/**
 * Function to get inactive plugin modules
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_inactive_modules( $by_post = false ) {

	global $ibwp_options;

	$result_arr	= array();

	// If post is passed
	if( $by_post && isset($_POST['ibwp_opts']) ) {

		$module_cats 		= ibwpl_register_module_cats();
		$ibwp_module_opts	= ibwpl_clean( $_POST['ibwp_opts'] );

		if( !empty($module_cats) ) {
			foreach ($module_cats as $module_cat_key => $module_cat_val) {

				$module_cat_key = sanitize_title($module_cat_key);

				if( isset($ibwp_module_opts[$module_cat_key.'_pack']) ) {
					$result_arr 		= ($result_arr + $ibwp_module_opts[$module_cat_key.'_pack']);
					$result_arr 		= array_filter( $result_arr, 'ibwpl_get_zero' );
				}
			}
		}

	} else {

		$active_modules 	= IBWP_Lite()->active_modules;
		$register_modules 	= IBWP_Lite()->register_modules;

		$active_modules_arr 	= array_keys( $active_modules );
		$register_modules_arr 	= array_keys( $register_modules );

		if( !empty($register_modules) ) {
			foreach ($register_modules as $module_key => $module_val) {
				if( !isset( $active_modules[$module_key] ) ) {
					$result_arr[$module_key] = 0;
				}
			}
		}
	}

	return $result_arr;
}

/**
 * Function to get module supports
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_module_support_info() {
	$supports = array(
			'shortcode' 	=> array(
									'title' => esc_html__('Has Shortcode', 'inboundwp-lite'),
									'icon'	=> 'dashicons-menu',
								),
			'widget'		=> array(
									'title' => esc_html__('Has Widget', 'inboundwp-lite'),
									'icon'	=> 'dashicons-welcome-widgets-menus',
								),
			'analytics'		=> array(
									'title' => esc_html__('Has Analytics', 'inboundwp-lite'),
									'icon'	=> 'dashicons-chart-bar',
								),
			'page_builder'	=> array(
									'title' => esc_html__('Has Visual Composer Support', 'inboundwp-lite'),
									'icon'	=> 'dashicons-schedule',
								),
			'multilanguage'	=> array(
									'title' => esc_html__('100% Multilanguage', 'inboundwp-lite'),
									'icon'	=> 'dashicons-translation',
								),
			'responsive'	=> array(
									'title' => esc_html__('Fully Responsive', 'inboundwp-lite'),
									'icon'	=> 'dashicons-smartphone',
								),
		);
	return apply_filters('ibwpl_module_support_info', $supports);
}