<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWP_Lite_Admin {

	function __construct() {

		// Action to register admin menu
		add_action( 'admin_menu', array($this, 'ibwpl_register_menu'), 5 );

		// Action to register admin menu
		add_action( 'admin_menu', array($this, 'ibwpl_register_sub_menu'), 99 );

		// Module Preview Screen
		add_action( 'current_screen', array($this, 'ibwpl_module_preview_screen') );

		// Filter to modify wordpress admin footer text
		add_filter( 'admin_footer_text', array( $this, 'ibwpl_admin_footer_text' ), 1 );

		// Ajax call to update option
		add_action( 'wp_ajax_ibwpl_update_post_order', array($this, 'ibwpl_update_post_order'));
		add_action( 'wp_ajax_nopriv_ibwpl_update_post_order',array( $this, 'ibwpl_update_post_order'));

		// Action add admin posts hooks
		add_action( 'load-edit.php', array($this, 'ibwpl_admin_posts_hooks') );

		// Action for prior admin hooks and process
		add_action( 'admin_init', array($this, 'ibwpl_admin_init_process') );

		// Action to add category dropdown to post listing page
		add_action( 'restrict_manage_posts', array($this, 'ibwpl_add_post_cat_filters'), 50 );

		// Action to add 'Save Sort Order' button
		add_action( 'restrict_manage_posts', array($this, 'ibwpl_restrict_manage_posts'), 10, 2 );

		// Filter to add row data
		add_filter( 'post_row_actions', array($this, 'ibwpl_add_post_row_data'), 5, 2 );

		// Action to add custom column to post listing
		add_filter( 'manage_posts_columns', array($this, 'ibwpl_add_post_columns'), 15, 2 );

		// Action to add custom column data to faq listing
		add_action('manage_posts_custom_column', array($this, 'ibwpl_add_post_columns_data'), 15, 2);

		// Action to get post suggestion
		add_action( 'wp_ajax_ibwpl_post_title_sugg', array($this, 'ibwpl_post_title_sugg') );

		// Action to add menu at admin bar
		add_action( 'admin_bar_menu', array($this, 'ibwpl_admin_bar_menu'), 99 );

		// Filter to add plugin action link
		add_filter( 'plugin_action_links_' . IBWPL_BASENAME, array($this, 'ibwpl_plugin_action_links') );
	}

	/**
	 * Add Save button to post listing page
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_restrict_manage_posts( $post_type, $which ) {

		global $wp_query;

		$post_support = IBWP_Lite()->post_supports; // Post type supports

		if( isset($post_support[$post_type]['sorting']) && isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'menu_order title' ) {

			$html  = '';
			$html .= "<span class='spinner ibwp-ajax-spinner'></span>";
			$html .= "<input type='button' name='ibwp_".$post_type."_save_order' class='button button-secondary right ibwp-save-post-order' id='ibwp-save-post-order' value='".__('Save Sort Order', 'inboundwp-lite')."' />";
			
			echo $html;
		}
	}


	/**
	 * Add category dropdown to FAQ listing page
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_add_post_cat_filters() {

		global $post_type;

		$post_support 		= IBWP_Lite()->post_supports; // Post type supports
		$ibwp_cat 			= isset($post_support[$post_type]['cat_filter']['taxonomy']) ? $post_support[$post_type]['cat_filter']['taxonomy'] : '';
		$show_option_none 	= isset($post_support[$post_type]['cat_filter']['show_option_none']) ? $post_support[$post_type]['cat_filter']['show_option_none'] : __('All Categories', 'inboundwp-lite');

		if( $ibwp_cat ) {

			$ibwp_selected_cat = isset( $_GET[$ibwp_cat] ) ? $_GET[$ibwp_cat] : '';

			$dropdown_options = apply_filters('ibwpl_post_cat_filter_args', array(
					'show_option_none' 	=> $show_option_none,
					'option_none_value' => '',
					'hide_empty' 		=> 0,
					'hierarchical' 		=> 1,
					'show_count' 		=> 1,
					'orderby' 			=> 'name',
					'name'				=> $ibwp_cat,
					'taxonomy'			=> $ibwp_cat,
					'selected' 			=> $ibwp_selected_cat,
					'value_field'		=> 'slug',
				), $post_type, $ibwp_cat);

			wp_dropdown_categories( $dropdown_options );
		}
	}

	/**
	 * Admin post hooks
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_admin_posts_hooks() {

		$post_support = IBWP_Lite()->post_supports; // Post type supports

		if( !empty( $post_support ) ) {
			foreach ($post_support as $post_key => $post_data) {

				// Post Sorting
				if( !empty($post_key) && isset($post_data['sorting']) ) {

					// Action to add sorting link at post listing page
					add_filter( 'views_edit-'.$post_key, array($this, 'ibwpl_add_post_sorting_link') );
				}
			}
		}
	}

	/**
	 * Add sorting link at post listing page
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_add_post_sorting_link( $views ) {

		global $post_type, $wp_query;

		$post_support = IBWP_Lite()->post_supports; // Post type supports

		$sort_label			= isset($post_support[$post_type]['sorting']['sort_label']) ? $post_support[$post_type]['sorting']['sort_label'] : __('Sort Post', 'inboundwp-lite');
		$class            	= ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) ? 'current' : '';
		$query_string     	= remove_query_arg(array( 'orderby', 'order' ));
		$query_string     	= add_query_arg( 'orderby', urlencode('menu_order title'), $query_string );
		$query_string     	= add_query_arg( 'order', urlencode('ASC'), $query_string );
		$views['byorder'] 	= '<a href="' . esc_url( $query_string ) . '" class="' . ibwpl_esc_attr( $class ) . '">' . $sort_label . '</a>';

		return $views;
	}


	/**
	 * Update Faq order
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_update_post_order() {

		// Taking some defaults
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= esc_html__( 'Sorry, Something happened wrong.', 'inboundwp-lite' );

		if( !empty($_POST['form_data']) ) {

			$form_data 		= parse_str($_POST['form_data'], $output_arr);
			$ibwp_posts 	= !empty($output_arr['ibwp_post']) ? $output_arr['ibwp_post'] : '';

			if( !empty($ibwp_posts) ) {

				$post_menu_order = 0;

				// Loop od ids
				foreach ($ibwp_posts as $ibwp_post_key => $ibwp_post_data) {

					// Update post
					$update_post = array(
						'ID'           => $ibwp_post_data,
						'menu_order'   => $post_menu_order,
					);

					// Update the post into the database
					wp_update_post( $update_post );

					$post_menu_order++;
				}

				$result['success'] 	= 1;
				$result['msg'] 		= esc_html__('Sort order saved successfully.', 'inboundwp-lite');
			}
		}

		echo json_encode($result);
		exit;
	}

	/**
	 * Add custom column to post listing page
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_add_post_columns( $columns, $post_type ) {

		$post_support = IBWP_Lite()->post_supports; // Post type supports

		// Shortcode Column
		if( $post_type && isset($post_support[$post_type]['shortcode']) ) {

			$column_name 	= isset($post_support[$post_type]['sorting']['name']) 				? $post_support[$post_type]['sorting']['name'] 	: esc_html__('Shortcode', 'inboundwp-lite');
			$column_pos 	= isset($post_support[$post_type]['sorting']['column_pos']) 		? $post_support[$post_type]['sorting']['column_pos'] 	: 5;
			$clmn_from_last = !empty($post_support[$post_type]['sorting']['column_from_last']) 	? 1: 0;

			$new_columns['ibwp_shortcode'] = $column_name;
			$columns = ibwpl_add_array( $columns, $new_columns, $column_pos, $clmn_from_last );
		}

		// Order Column
		if( $post_type && isset($post_support[$post_type]['sorting']) ) {

			$column_name 	= isset($post_support[$post_type]['sorting']['column_name']) 		? $post_support[$post_type]['sorting']['column_name'] 	: esc_html__('Order', 'inboundwp-lite');
			$column_pos 	= isset($post_support[$post_type]['sorting']['column_pos']) 		? $post_support[$post_type]['sorting']['column_pos'] 	: 5;
			$clmn_from_last = !empty($post_support[$post_type]['sorting']['column_from_last']) 	? 1: 0;

			$new_columns['ibwp_order'] = $column_name;
			$columns = ibwpl_add_array( $columns, $new_columns, $column_pos, $clmn_from_last );
		}

		return $columns;
	}

	/**
	 * Add custom column data to post listing page
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_add_post_columns_data( $column, $post_id ) {

		global $post, $wp_query, $post_type;

		/* Little Tweak for While Quick Edit Post */
		if( wp_doing_ajax() && ! empty( $_REQUEST['post_type'] ) ) {
			$post_type = $_REQUEST['post_type'];
		}

		// Order Column
		if( $column == 'ibwp_order' ) {
			$post_menu_order = isset( $post->menu_order ) ? $post->menu_order : '';

			echo $post_menu_order;
			if( isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'menu_order title' ) {
				echo "<input type='hidden' value='{$post_id}' name='ibwp_post[]' class='ibwp-post-order' id='ibwp-post-order-{$post_id}' />";
			}
		}

		// Shortcode Column
		if( $column == 'ibwp_shortcode' ) {

			$post_support	= IBWP_Lite()->post_supports; // Post type supports
			$column_cnt		= isset( $post_support[$post_type]['shortcode']['content'] ) ? $post_support[$post_type]['shortcode']['content'] : '';
			$column_cnt		= str_replace('{post_id}', $post_id, $column_cnt);

			echo '<div class="ibwp-shortcode-preview ibwp-copy-clipboard">'.$column_cnt.'</div>';
		}
	}

	/**
	 * Function to register admin menus
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_register_menu() {
		add_menu_page( __('InboundWP Lite - By WP OnlineSupport', 'inboundwp-lite'), __('InboundWP Lite', 'inboundwp-lite'), 'manage_options', IBWPL_PAGE_SLUG, array($this, 'ibwpl_render_dashboard_page'), IBWPL_URL.'assets/images/inbound-logo-20.png', 4 );
	}

	/**
	 * Function to register admin sub menus
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_register_sub_menu() {

		global $ibwp_module_intgs;

		// Integration Page
		if( $ibwp_module_intgs ) {
			add_submenu_page( IBWPL_PAGE_SLUG, __('Integration InboundWP Lite', 'inboundwp-lite'), __('Integration', 'inboundwp-lite'), 'manage_options', 'ibwp-integration', array($this, 'ibwpl_render_integration_page') );
		}

		// About Page
		add_submenu_page( IBWPL_PAGE_SLUG, __('About', 'inboundwp-lite'), __('About', 'inboundwp-lite'), 'manage_options', 'ibwp-about', array($this, 'ibwpl_render_about_page') );

		// Upgrade to Pro Page
		add_submenu_page( IBWPL_PAGE_SLUG, __('Upgrade to PRO', 'inboundwp-lite'), '<span style="color:#2ecc71;">'.__('Upgrade to PRO', 'inboundwp-lite').'</span>', 'manage_options', 'ibwp-premium', array($this, 'ibwpl_upgrade_to_pro') );

		// Preview Page
		add_submenu_page( null, __('InboundWP Lite Module Preview', 'inboundwp-lite'), __('Inbound Lite Module Preview', 'inboundwp-lite'), 'edit_posts', 'ibwp-module-preview', array($this, 'ibwpl_module_preview_page') );
	}

	/**
	 * Function to handle the main dashboard page
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_render_dashboard_page() {
		include_once( IBWPL_DIR . '/includes/admin/ibwp-dashboard.php' );
	}

	/**
	 * Function to handle the third party integration
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_render_integration_page() {
		include_once( IBWPL_DIR . '/includes/admin/integration/ibwp-integration.php' );
	}

	/**
	 * Function to handle the about page html
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_render_about_page() {
		include_once( IBWPL_DIR . '/includes/admin/ibwp-about.php' );
	}

	/**
	 * Function to handle the upgrade to pro page html
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_upgrade_to_pro() {
		include_once( IBWPL_DIR . '/includes/admin/settings/premium.php' );
	}

	/**
	 * Function to handle module preview page
	 * 
	 * @since 1.0
	 */
	function ibwpl_module_preview_page() {
	}

	/**
	 * Function to handle module preview screen
	 * 
	 * @since 1.0
	 */
	function ibwpl_module_preview_screen( $screen ) {

		if( $screen->id == 'admin_page_ibwp-module-preview' ) {
			include_once( IBWPL_DIR . '/includes/admin/module-preview/module-preview.php' );
			exit;
		}
	}

	/**
	 * Function to modify WordPress admin footer text
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_admin_footer_text( $footer_text ) {

		$ibwp_screen = is_ibwpl_screen();

		if( $ibwp_screen ) {
			$footer_text = $footer_text .' | '. sprintf( __('Thank you for using <a href="%s" target="_blank">InboundWP Lite</a>. A huge thanks in advance!', 'inboundwp-lite'), IBWPL_FREE_LINK );
		}
		return $footer_text;
	}

	/**
	 * Admin taxonomy hooks
	 * 
	 * @package InboundWP Lite
 	 * @since 1.0
	 */
	function ibwpl_admin_init_process() {

		/***** Taxonomy Code *****/
		$tax_supports = IBWP_Lite()->taxonomy_supports; 	// Taxonomy supports

		if( !empty( $tax_supports ) ) {
			foreach ($tax_supports as $tax_key => $tax_data) {
				
				// Taxonomy columns
				if( !empty($tax_key) && isset($tax_data['shortcode_clmn']) ) {

					// Filter to add columns and data in category table
					add_filter('manage_edit-'.$tax_key.'_columns', array($this, 'ibwpl_manage_category_columns'));
					add_filter('manage_'.$tax_key.'_custom_column', array($this, 'ibwpl_cat_columns_data'), 10, 3);
				}

				// Taxonomy columns
				if( !empty($tax_key) && isset($tax_data['row_data_id']) ) {

					// Filter to add row action in category table
					add_filter( $tax_key.'_row_actions', array($this, 'ibwpl_add_tax_row_data'), 5, 2 );
				}
			}
		} // End of if
	}

	/**
	 * Function to add custom quick links at post listing page
	 * 
	 * @package InboundWP Lite
 	 * @since 1.0
	 */
	function ibwpl_add_post_row_data( $actions, $post ) {

		$post_support = IBWP_Lite()->post_supports; // Post type supports

		// Post row data filter
		if( isset($post_support[$post->post_type]['row_data_post_id']) ) {
			return array_merge( array( 'ibwp_id' => 'ID: ' . $post->ID ), $actions );
		}
		return $actions;
	}

	/**
	 * Function to add category columns
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_manage_category_columns( $columns ) {

		global $taxonomy;

		$tax_support = IBWP_Lite()->taxonomy_supports; // Taxonomy supports

		$new_columns['ibwp_tax_shortcode'] = isset($tax_support[$taxonomy]['shortcode_clmn']['column_name']) ? $tax_support[$taxonomy]['shortcode_clmn']['column_name'] : __('Category Shortcode', 'inboundwp-lite');

		$columns = ibwpl_add_array( $columns, $new_columns, 2 );
		
		return $columns;
	}

	/**
	 * Function to add category columns data
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_cat_columns_data( $ouput, $column_name, $tax_id ) {

		global $taxonomy;

		$tax_support = IBWP_Lite()->taxonomy_supports; // Taxonomy supports

		$column_cnt = isset($tax_support[$taxonomy]['shortcode_clmn']['column_cnt']) ? $tax_support[$taxonomy]['shortcode_clmn']['column_cnt'] : '';

		if( $column_name == 'ibwp_tax_shortcode' ){
			$ouput .= str_replace('{cat_id}', $tax_id, $column_cnt);
		}
		return $ouput;
	}

	/**
	 * Function to add category row action
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_add_tax_row_data( $actions, $tag ) {
		return array_merge( array( 'ibwp_id' => 'ID: ' . $tag->term_id ), $actions );
	}

	/**
	 * Function to get post suggestion based on search input
	 * 
 	 * @since 1.1
	 */
	function ibwpl_post_title_sugg() {

		$return		= array();
		$search		= isset( $_GET['search'] )		? trim( $_GET['search'] )	: '';
		$post_type	= isset( $_GET['post_type'] )	? $_GET['post_type']		: 'post';
		$nonce		= isset( $_GET['nonce'] )		? $_GET['nonce']			: '';
		$meta_data	= isset( $_GET['meta_data'] )	? ibwpl_clean( $_GET['meta_data'] ) : '';
		$meta_data	= json_decode( $meta_data, true );

		// Verify Nonce
		if( $search && wp_verify_nonce( $nonce, 'ibwp-post-title-sugg' ) ) {

			$args	= array(
						's'						=> $search,
						'post_type'				=> $post_type,
						'post_status'			=> 'publish',
						'order'					=> 'ASC',
						'orderby'				=> 'title',
						'posts_per_page'		=> 20
					);

			// If number is passed
			if( is_numeric( $search ) ) {
				$args['s'] = false;
				$args['p'] = $search;
			}

			// If meta query is set
			if( $meta_data ) {
				$args['meta_query'] = $meta_data;
			}

			$search_query = get_posts( $args );

			if( $search_query ) :

				foreach ( $search_query as $search_data ) {
					
					$post_title	= !empty( $search_data->post_title ) ? $search_data->post_title : __('Post', 'inboundwp-lite');
					$post_title	= $post_title . " - (#{$search_data->ID})";

					$return[]	= array( $search_data->ID, $post_title );
				}

			endif;
		}

		wp_send_json( $return );
	}

	/**
	 * Function to add menu at admin bar
	 * 
	 * @package InboundWP Lite
 	 * @since 1.0
	 */
	function ibwpl_admin_bar_menu() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		global $wp_admin_bar;

		$active_modules 	= ibwpl_plugin_modules('active');
		$module_cats 		= ibwpl_register_module_cats();
		$plugin_link		= ibwpl_get_plugin_link();

		$wp_admin_bar->add_menu( array(
			'id'	=> 'ibwp-menu',
			'title'	=> esc_html__('InboundWP Lite', 'inboundwp-lite'),
			'href'	=> $plugin_link,
		));

		// If active module is there then add sub menu
		if( $module_cats ) {
			foreach ($module_cats as $module_cat_key => $module_cat_data) {				

				if( empty( $module_cat_data ) || empty( $module_cat_data['name'] )  ) {
					continue;
				}

				$active_modules_data = isset( $active_modules[$module_cat_key] ) ? $active_modules[$module_cat_key] : array();

				// Category Menu
				$wp_admin_bar->add_menu( array(
					'parent'	=> 'ibwp-menu',
					'id'		=> "ibwpl-cat-{$module_cat_key}",
					'title'		=> $module_cat_data['name'],
					'href'		=> add_query_arg( array( 'tab' => $module_cat_key ), $plugin_link ),
				));

				// Category Sub Menu (Active Modules Menu)
				if( $active_modules_data ) {
					foreach ($active_modules_data as $active_module_key => $active_module_data) {
						
						if( empty( $active_module_data ) || empty( $active_module_data['name'] ) || empty( $active_module_data['conf_link'] ) ) {
							continue;
						}

						$wp_admin_bar->add_menu( array(
							'parent'	=> "ibwpl-cat-{$module_cat_key}",
							'id'		=> "ibwpl-{$active_module_key}",
							'title'		=> $active_module_data['name'],
							'href'		=> $active_module_data['conf_link'],
						));
					}
				}
			}
		} // End of main if
	}

	/**
	 * Function to add license plugins link
	 * 
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	function ibwpl_plugin_action_links( $links ) {

		$config_link 		= ibwpl_get_plugin_link();
		$links['config'] 	= '<a href="' . esc_url($config_link) . '" title="' . esc_attr( __( 'Configure Plugin', 'inboundwp-lite' ) ) . '">' . __( 'Configure', 'inboundwp-lite' ) . '</a>';

		return $links;
	}
}

$ibwp_lite_admin = new IBWP_Lite_Admin();