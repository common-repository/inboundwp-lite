<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_TM_Admin {

	function __construct() {

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'ibwpl_tm_add_testimonial_metabox') );

		// Action to save metabox
		add_action( 'save_post_'.IBWPL_TM_POST_TYPE, array($this,'ibwpl_tm_save_metabox_value') );

		// Action to register admin menu
		add_action( 'admin_menu', array($this, 'ibwpl_tm_register_menu') );

		// Action to add custom column at agent listing
		add_filter( 'manage_posts_columns', array($this, 'ibwpl_tm_posts_columns'), 10, 2 );

		// Action to add custom column data
		add_action('manage_'.IBWPL_TM_POST_TYPE.'_posts_custom_column', array($this, 'ibwpl_tm_post_columns_data'), 10, 2);

		// Add some support to post like sorting and etc
		add_filter( 'ibwpl_post_supports', array($this, 'ibwpl_tm_post_supports') );

		// Add some support to taxonomy like shortcode column and etc
		add_filter( 'ibwpl_taxonomy_supports', array($this, 'ibwpl_tm_taxonomy_supports') );

		// Filter to add screen id
		add_filter( 'ibwpl_screen_ids', array( $this, 'ibwpl_tm_add_screen_id') );
	}

	/**
	 * Function to register metabox
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_add_testimonial_metabox() {
		add_meta_box( 'testimonial-details', __( 'Testimonial Details', 'inboundwp-lite' ), array($this, 'ibwpl_tm_meta_box_content'), IBWPL_TM_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Function to handle metabox content
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_meta_box_content() {
		include_once( IBWPL_TM_DIR .'/includes/admin/metabox/ibwp-tm-metabox-html.php');
	}

	/**
	 * Function to save metabox values
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_save_metabox_value( $post_id ) {

		global $post_type;

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )					// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )	// Check Revision
		|| ( $post_type !=  IBWPL_TM_POST_TYPE ) )								// Check if current post type is supported.
		{
			return $post_id;
		}

		$prefix = IBWPL_TM_META_PREFIX; // Taking metabox prefix

		// Getting saved values
		$client 	= isset( $_POST['_testimonial_client'] )	? ibwpl_clean( $_POST['_testimonial_client'] ) 		: '';
		$job 		= isset( $_POST['_testimonial_job'] )		? ibwpl_clean( $_POST['_testimonial_job'] ) 			: '';
		$company 	= isset( $_POST['_testimonial_company'] )	? ibwpl_clean( $_POST['_testimonial_company'] ) 		: '';
		$url 		= isset( $_POST['_testimonial_url'] )		? ibwpl_clean_url( $_POST['_testimonial_url'] ) 		: '';
		$rating 	= isset( $_POST[$prefix.'rating'] )			? ibwpl_clean_number( $_POST[$prefix.'rating'] ) 	: '';

		update_post_meta( $post_id, '_testimonial_client', $client );
		update_post_meta( $post_id, '_testimonial_job', $job );
		update_post_meta( $post_id, '_testimonial_company', $company );
		update_post_meta( $post_id, '_testimonial_url', $url );
		update_post_meta( $post_id, $prefix.'rating', $rating );
	}

	/**
	 * Function to register admin menus
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_register_menu() {

		//Settings Page
		add_submenu_page( 'edit.php?post_type='.IBWPL_TM_POST_TYPE, __('Settings - Testimonials - IBWP', 'inboundwp-lite'), __('Settings', 'inboundwp-lite'), 'manage_options', 'wtwp-pro-settings', array($this, 'ibwpl_tm_settings_page') );
	}

	/**
	 * Function to handle the setting page html
	 *
	 * @since 1.0
	 */
	function ibwpl_tm_settings_page() {
		include_once( IBWPL_TM_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Add custom column to listing page
	 * 
	 * @since 1.0
	 */
	function ibwpl_tm_posts_columns( $columns, $post_type ) {

		if( $post_type == IBWPL_TM_POST_TYPE ) {

			$new_columns['ibwp_tm_image'] 	= esc_html__('Profile Image', 'inboundwp-lite');
			$new_columns['ibwp_tm_rating'] 	= esc_html__('Rating', 'inboundwp-lite');

			$columns = ibwpl_add_array( $columns, $new_columns, 1, true );
		}

		return $columns;
	}

	/**
	 * Add custom column data
	 * 
 	 * @since 1.0
	 */
	function ibwpl_tm_post_columns_data( $column, $post_id ) {

		$prefix = IBWPL_TM_META_PREFIX; // Metabox prefix

		switch ( $column ) {
			case 'ibwp_tm_image':

				$image = ibwpl_tm_get_image( $post_id, 50, 'square');

				echo $image;
				break;

			case 'ibwp_tm_rating':

				$rating = get_post_meta( $post_id, $prefix.'rating', true );

				for( $i = 0; $i < 5; $i++ ) {
					if( $i < $rating ) {
						echo '<i class="dashicons dashicons-star-filled"></i>';
					} else {
						echo '<i class="dashicons dashicons-star-empty"></i>';
					}
				}
				break;
		}
	}

	/**
	 * Function to add support to post like sorting etc
	 * 
 	 * @since 1.0
	 */
	function ibwpl_tm_post_supports( $supports ) {

		$supports[IBWPL_TM_POST_TYPE] = array(
											'cat_filter' => array(
															'taxonomy'			=> IBWPL_TM_CAT,
															'show_option_none' 	=> esc_html__( 'All Categories', 'inboundwp-lite' ),
														),
											'row_data_post_id' => true
										);
		return $supports;
	}

	/**
	 * Function to add support to taxonomy like shortcode column etc
	 * 
 	 * @since 1.1
	 */
	function ibwpl_tm_taxonomy_supports( $supports ) {
		$supports[IBWPL_TM_CAT] = array(
									'row_data_id' => true
									);
		return $supports;
	}

	/**
	 * Function to add screen id
	 * 
	 * @since 1.0
	 */
	function ibwpl_tm_add_screen_id( $screen_ids ) {

		$screen_ids['main'][] = IBWPL_TM_POST_TYPE;

		return $screen_ids;
	}
}

$ibwpl_tm_admin = new IBWPL_TM_Admin();