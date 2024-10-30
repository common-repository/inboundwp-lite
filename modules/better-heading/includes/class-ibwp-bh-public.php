<?php
/**
 * Public Class
 *
 * Handles the public side functionality of plugin
 *
 * @package InboundWP
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWPL_BH_Public {

	function __construct() {

		// Prior Init Actions
		add_action( 'init', array($this, 'ibwpl_bh_init_actions') );

		// Action to render the post title
		add_filter( 'the_title', array($this, 'ibwpl_bh_render_title'), 10, 2 );

		// Action to process the post titles
		add_action( 'wp_footer', array($this, 'ibwpl_bh_process_titles'), 99 );

		// Action to process title click on single pages
		add_action( 'wp_ajax_ibwpl_bh_process_title_click', array($this, 'ibwpl_bh_process_title_click') );
		add_action( 'wp_ajax_nopriv_ibwpl_bh_process_title_click', array($this,'ibwpl_bh_process_title_click') );
	}

	/**
	 * Prior Init Actions
	 * 
	 * @since 1.0 
	 */
	function ibwpl_bh_init_actions() {

		// For fornt side only
		if( ! is_admin() ) {
			$this->ibwpl_set_unique_visitor();
		}
	}

	/**
	 * Set unique visitor flag in cookie.
	 * 
	 * @since 1.0 
	 */
	function ibwpl_set_unique_visitor() {

		if( empty( $_COOKIE['ibwp_bh_visitor'] ) ) {

			$current_time	= current_time('timestamp');
			$unique			= ibwpl_gen_random_str() .'-'. $current_time;

			setcookie( 'ibwp_bh_visitor', $unique, ($current_time + (2 * 365 * 24 * 60 * 60)), COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, false, false );
			$_COOKIE['ibwp_bh_visitor'] = $unique; // Tweak to avoid one page reload
		}
	}

	/**
	 * Function to render the better title for post
	 * 
	 * @since 1.0 
	 */
	function ibwpl_bh_render_title( $title, $id ) {

		// If admin then return original title
		if( (is_admin() && ! defined( 'DOING_AJAX' )) || (defined('REST_REQUEST') && REST_REQUEST) || current_user_can('administrator') ) {
			return $title;
		}

		global $ibwp_bh_rendered_post, $ibwp_bh_posts_stats, $wpdb;

		$prefix			= IBWPL_BH_META_PREFIX;
		$original_title	= $title;
		$title_enable	= get_post_meta( $id, $prefix.'enable', true );

		if( $title_enable ) {

			$titles				= get_post_meta( $id, $prefix.'titles', true );
			$bh_post_types		= ibwpl_bh_get_option( 'post_types', array() );
			$title_post_type	= get_post_type( $id );
			$unique_visitor		= isset( $_COOKIE['ibwp_bh_visitor'] ) ? $_COOKIE['ibwp_bh_visitor'] : false;

			// If post type is not enabled from setting
			if( ! in_array( $title_post_type, $bh_post_types ) || empty( $titles ) ) {
				return $title;
			}

			// Gettting the stored the stats for post from DB
			if( ! $ibwp_bh_posts_stats ) {
				$ibwp_bh_posts_stats = $wpdb->get_row( "SELECT `id`,`uid`,`post_ids`,`title_ids` FROM `".IBWPL_BH_STATS_TBL."` WHERE uid = '{$unique_visitor}' ORDER BY `created_date` DESC LIMIT 1", ARRAY_A );
			}

			if( $ibwp_bh_posts_stats && ! empty( $ibwp_bh_posts_stats['post_ids'] ) && ! empty( $ibwp_bh_posts_stats['title_ids'] ) ) {
				
				$title_data			= array();
				$stats_title_arr	= explode( ',', $ibwp_bh_posts_stats['title_ids'] );

				foreach ($stats_title_arr as $stats_title_data) {
					$title_data_arr = explode( ':', $stats_title_data );

					$title_data[ $title_data_arr[0] ] = $title_data_arr[1];
				}

				if( isset( $title_data[ $id ] ) ) {
					$ibwp_bh_rendered_post[ $id ] = $title_data[ $id ];
				}
			}

			// Render title from global or take new one
			if( isset( $ibwp_bh_rendered_post[ $id ] ) && isset( $titles[ $ibwp_bh_rendered_post[$id] ] ) ) {

				$title = $titles[ $ibwp_bh_rendered_post[ $id ] ];

			} else {

				$random_title_key = array_rand( $titles );

				// New Post Title
				$title = $titles[ $random_title_key ];

				// Assign to Global
				$ibwp_bh_rendered_post[ $id ] = $random_title_key;
			}

			// Specially when Ajax is there at frontend
			if( is_admin() && (defined( 'DOING_AJAX' ) && DOING_AJAX) ) {
				$this->ibwpl_bh_process_titles();
			}

			$title = ( $title == '' ) ? $original_title : $title;
		}

		return $title;
	}

	/**
	 * Function to process the post titles and its entry to DB
	 * 
	 * @since 1.0 
	 */
	function ibwpl_bh_process_titles() {

		global $ibwp_bh_rendered_post, $ibwp_bh_posts_stats, $wpdb;

		// If unique visitor flag is there
		if( ! empty( $ibwp_bh_rendered_post ) && is_array( $ibwp_bh_rendered_post ) && ! empty( $_COOKIE['ibwp_bh_visitor'] ) ) {

			// Taking some data
			$title_data			= array();
			$unique_visitor 	= $_COOKIE['ibwp_bh_visitor'];
			$rendered_post_ids	= array_keys( $ibwp_bh_rendered_post );

			foreach ($ibwp_bh_rendered_post as $rendered_post_id => $rendered_post_data) {
				$title_data[] =  $rendered_post_id .':'. $rendered_post_data;
			}			

			if( empty( $ibwp_bh_posts_stats ) ) {

				$post_ids	= implode(',', $rendered_post_ids );
				$title_ids	= implode(',', $title_data );

				// Insert some entry
				$wpdb->insert( IBWPL_BH_STATS_TBL, 
											array(
												'uid'			=> $unique_visitor,
												'post_ids'		=> $post_ids,
												'title_ids'		=> $title_ids,
												'created_date'	=> current_time('mysql'),
												'modified_date'	=> current_time('mysql'),
											)
				);

				ibwpl_bh_update_title_view( $title_data );

			} else { // Update It

				$stored_title_arr	= array();
				$new_title_data		= array();
				$stored_post_ids	= ! empty( $ibwp_bh_posts_stats['post_ids'] ) ? explode( ',', $ibwp_bh_posts_stats['post_ids'] ) : array();
				$stored_title_ids	= ! empty( $ibwp_bh_posts_stats['title_ids'] ) ? explode( ',', $ibwp_bh_posts_stats['title_ids'] ) : array();
				$updated_post_ids	= array_unique( array_merge($stored_post_ids, $rendered_post_ids) );
				$updated_title_ids	= array_unique( array_merge($stored_title_ids, $title_data) );

				$post_diff			= array_diff( $updated_post_ids, $stored_post_ids );
				$title_diff			= array_diff( $updated_title_ids, $stored_title_ids );

				// If any diifference in post id or title id is there
				if( $post_diff || $title_diff ) {

					/* Process to get new / updated title data with stored one */
					foreach ( $stored_title_ids as $stored_title_data ) {
						$title_data_arr							= explode( ':', $stored_title_data );
						$stored_title_arr[ $title_data_arr[0] ]	= $title_data_arr[1];
					}

					$updated_title_data = ( $ibwp_bh_rendered_post + $stored_title_arr );

					foreach ($updated_title_data as $rendered_post_id => $rendered_post_data) {
						$new_title_data[] =  $rendered_post_id .':'. $rendered_post_data;
					}
					/**/

					$post_ids	= implode(',', $updated_post_ids );
					$title_ids	= implode(',', $new_title_data );

					// Update some entry
					$wpdb->update( IBWPL_BH_STATS_TBL, 
												array(
													'post_ids'		=> $post_ids,
													'title_ids'		=> $title_ids,
													'modified_date'	=> current_time('mysql'),
												),
												array( 'id' => $ibwp_bh_posts_stats['id'] )
					);

					ibwpl_bh_update_title_view( $title_diff );
				}
			} // End of else
		} // End of main IF
	}

	/**
	 * Function to count the title click ID on single post page
	 * 
	 * @since 1.0 
	 */
	function ibwpl_bh_process_title_click() {

		global $wpdb;

		$prefix			= IBWPL_BH_META_PREFIX;
		$today_date		= date( 'Y-m-d', current_time('timestamp') );
		$post_id		= ! empty( $_POST['post_id'] )		? ibwpl_clean_number( $_POST['post_id'] )	: 0;
		$post_type		= ! empty( $_POST['post_type'] )	? ibwpl_clean( $_POST['post_type'] )			: '';
		$unique_visitor = $_COOKIE['ibwp_bh_visitor'];
		$result			= array(
								'success'	=> 0,
								'msg' 		=> esc_html__( 'Sorry, Something happened wrong.', 'inboundwp-lite' )
							);

		$title_stats = $wpdb->get_row( "SELECT `id`, `title_ids` FROM `".IBWPL_BH_STATS_TBL."` WHERE uid = '{$unique_visitor}' AND FIND_IN_SET({$post_id}, `post_ids`) ORDER BY `created_date` DESC LIMIT 1", ARRAY_A );

		// Return if no ref ID is stored in stats tbl
		if( empty( $title_stats['title_ids'] ) ) {
			wp_send_json( $result );
		}

		$title_data			= array();
		$stored_title_ids 	= explode( ',', $title_stats['title_ids'] );
		$titles				= get_post_meta( $post_id, $prefix.'titles', true );

		foreach ( $stored_title_ids as $stored_title_data ) {
			$title_data_arr						= explode( ':', $stored_title_data );
			$title_data[ $title_data_arr[0] ]	= $title_data_arr[1];
		}

		$title_id = isset( $title_data[ $post_id ] ) ? $title_data[ $post_id ] : -1; // Title ID Ref

		// If no title id OR DB has no title reference
		if( $title_id < 0 || ! isset($titles[ $title_id ]) ) {
			
			$result	= array(
							'msg' => esc_html__( 'Sorry, No title id found in record.', 'inboundwp-lite' )
						);

			wp_send_json( $result );
		}


		// Get if title click entry is exist for the day
		$title_report = $wpdb->get_row( "SELECT `id`, `post_id`, `title_id`, `title`, `title_click` FROM `".IBWPL_BH_TBL."` WHERE title_id = '{$title_id}' AND post_id = '{$post_id}' AND title = '{$titles[ $title_id ]}' AND DATE_FORMAT(created_date, '%Y-%m-%d') = '{$today_date}' LIMIT 1", ARRAY_A );

		// Update entry
		if( $title_report ) {

			$wpdb->query( "UPDATE ".IBWPL_BH_TBL." SET `title_click`= `title_click` + 1, `modified_date` = '".current_time('mysql')."' WHERE `id` = '{$title_report['id']}'" );
			$record_id = $title_report['id'];

		} else { // Insert Entry

			// Insert some entry
			$wpdb->insert( IBWPL_BH_TBL, 
								array(
									'post_id'		=> $post_id,
									'title_id'		=> $title_id,
									'title'			=> $titles[ $title_id ],
									'post_type'		=> $post_type,
									'title_click'	=> 1,
									'created_date'	=> current_time('mysql'),
									'modified_date'	=> current_time('mysql'),
								)
			);
			$record_id = $wpdb->insert_id;
		}

		// If data is inserted successfully
		if( $record_id ) {

			// Save to Post Meta
			ibwpl_bh_update_title_click( $post_id, $title_id );

			$result	= array(
							'success'	=> 1,
							'msg'		=> esc_html__( 'Success', 'inboundwp-lite' )
						);

			wp_send_json( $result );
		}

		wp_send_json( $result );
	}
}

$ibwpl_bh_public = new IBWPL_BH_Public();