<?php
/**
 * Plugin generic functions file
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_esc_attr($data) {
	return esc_attr( $data );
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'ibwpl_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_clean_number( $var, $fallback = null, $type = 'int' ) {

	if ( $type == 'number' ) {
		$data = intval( $var );
	} else if ( $type == 'abs' ) {
		$data = abs( $var );
	} else {
		$data = absint( $var );
	}

	return ( empty($data) && isset($fallback) ) ? $fallback : $data;
}

/**
 * Sanitize color value and return fallback value if it is blank
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_clean_color( $color, $fallback = null ) {

	if ( false === strpos( $color, 'rgba' ) ) {
		
		$data = sanitize_hex_color( $color );

	} else {

		$red	= 0;
		$green	= 0;
		$blue	= 0;
		$alpha	= 0.5;

		// By now we know the string is formatted as an rgba color so we need to further sanitize it.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		$data = 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
	}

	return ( empty($data) && $fallback ) ? $fallback : $data;
}

/**
 * Sanitize url
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_clean_url( $url ) {
	return esc_url_raw( trim($url) );
}

/**
 * Strip Slashes From Array
 *
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_clean_html($data = array(), $flag = false) {

	if( $flag != true ) {
		$data = ibwpl_nohtml_kses( $data );
	}

	$data = stripslashes_deep( $data );
	
	return $data;
}

/**
 * Remove blank lines from content.
 * 
 * @since 1.0
 */
function ibwpl_clean_line_breaks( $content = '' ) {

	$cnt_arr	= explode( "\n", $content );
	$cnt_arr	= array_map( 'trim', $cnt_arr );
	$cnt_arr	= array_filter( $cnt_arr );
	$content	= implode( "\n", $cnt_arr );

	return $content;
}

/**
 * Function to check email with comma separated values
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_check_email( $emails, $type = 'multiple' ) {

	$correct_email	= array();
	
	if( $type == 'multiple' ) {
	
		$email_ids = explode( ',', $emails );
		$email_ids = ibwpl_clean($email_ids);

		foreach ($email_ids as $email_key => $email_value) {
			if( is_email( $email_value ) ){
				$correct_email[] = $email_value;
			}
		}
	} else {
		$emails = ibwpl_clean( $emails );
		$correct_email[] = is_email( $emails ) ? $emails : ''; 
	}

	return implode( ', ', $correct_email );
}

/**
 * Strip Html Tags
 * It will sanitize text input (strip html tags, and escape characters)
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_nohtml_kses($data = array()) {

	if ( is_array($data) ) {

	$data = array_map('ibwpl_nohtml_kses', $data);

	} elseif ( is_string( $data ) ) {
		$data = trim( $data );
		$data = wp_filter_nohtml_kses($data);
	}

	return $data;
}

/**
 * Sanitize Multiple HTML class
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_sanitize_html_classes($classes, $sep = " ") {
	$return = "";

	if( $classes && !is_array($classes) ) {
		$classes = explode($sep, $classes);
	}

	if( !empty($classes) ) {
		foreach($classes as $class){
			$return .= sanitize_html_class($class) . " ";
		}
		$return = trim( $return );
	}

	return $return;
}

/**
 * Function to add array after specific key
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_add_array(&$array, $value, $index, $from_last = false) {

	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count    = count($array);
			$index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
		}
		
		$split_arr  = array_splice($array, max(0, $index));
		$array      = array_merge( $array, $value, $split_arr);
	}

	return $array;
}

/**
 * Function to unique number value
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_unique() {
	static $unique = 0;
	$unique++;

	return $unique;
}

/**
 * Function to generate random strings
 * 
 * @package InboundWP Lite
 * @since 1.1
 */
function ibwpl_gen_random_str( $length = 8 ) {
	$string	= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string	= str_shuffle( $string );

	return substr( $string, 0, $length );
}

/**
 * Function to get grid column based on grid
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_grid_column( $grid = '' ) {

	if( $grid == '2' ) {
		$grid_clmn = '6';
	} else if( $grid == '3' ) {
		$grid_clmn = '4';
	}  else if( $grid == '4' ) {
		$grid_clmn = '3';
	} else if ( $grid == '1' ) {
		$grid_clmn = '12';
	} else {
		$grid_clmn = '6';
	}
	return $grid_clmn;
}

/**
 * Function to get pagination
 * 
 * @package InboundWP Lite
 * @since 1.1
 */
function ibwpl_pagination( $args = array() ) {

	$big				= 999999999; // need an unlikely integer
	$page_links_temp	= array();	
	$pagination_type	= isset( $args['pagination_type'] ) ? $args['pagination_type'] : 'numeric';
	$multi_page			= ! empty( $args['multi_page'] ) 	? 1 : 0;

	$paging = array(
		'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format'	=> '?paged=%#%',
		'current'	=> max( 1, $args['paged'] ),
		'total'		=> $args['total'],
		'prev_next'	=> true,
		'prev_text'	=> '&laquo; '.__('Previous', 'inboundwp-lite'),
		'next_text'	=> __('Next', 'inboundwp-lite').' &raquo;',
	);

	// If pagination is prev-next and shortcode is placed in single post
	if( $multi_page ) {
		$paging['type']		= ( $pagination_type == 'prev-next' ) ? 'array' : 'plain';
		$paging['base']		= esc_url_raw( add_query_arg( 'ibwp_page', '%#%', false ) );
		$paging['format']	= '?ibwp_page=%#%';
	}

	$page_links = paginate_links( apply_filters( 'ibwp_paging_args', $paging ) );

	// For single post shortcode we just fetch the prev-next link
	if( $multi_page && $pagination_type == 'prev-next' && $page_links && is_array( $page_links ) ) {

		foreach ($page_links as $page_link_key => $page_link) {
			if( strpos( $page_link, 'next page-numbers') !== false || strpos( $page_link, 'prev page-numbers') !== false ) {
				$page_links_temp[ $page_link_key ] = $page_link;
			}
		}
		return join( "\n", $page_links_temp );
	}

	return $page_links;
}

/**
 * Get InboundWP main screen ids.
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_main_screen_ids() {

	$screen_ids = array(
		'toplevel_page_ibwp-dashboard',
		IBWPL_SCREEN_ID.'_page_ibwp-integration',
		IBWPL_SCREEN_ID.'_page_ibwp-about',
		IBWPL_SCREEN_ID.'_page_ibwp-premium',
		IBWPL_SCREEN_ID.'_page_ibwp-license'
	);

	return $screen_ids;
}

/**
 * Get all InboundWP screen ids.
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_screen_ids( $type = 'main' ) {

	$module_screen_ids	= apply_filters( 'ibwpl_screen_ids', array() );
	$type_screen_ids	= isset( $module_screen_ids[$type] ) ? (array)$module_screen_ids[$type] : array();

	if( $type == 'main' ) {
		$screen_ids = ibwpl_main_screen_ids();
		$screen_ids = array_merge( $screen_ids, $type_screen_ids );
	} else {
		$screen_ids = $type_screen_ids;
	}

	return $screen_ids;
}

/**
 * Check it is a plugin screen or not
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function is_ibwpl_screen() {
	global $current_screen;

	$screen_ids 	= ibwpl_get_screen_ids();
	$curr_screen_id = $current_screen ? $current_screen->id : '';
	$curr_post_type = isset($current_screen->post_type) ? $current_screen->post_type : '';

	if( in_array($curr_screen_id, $screen_ids) || in_array($curr_post_type, $screen_ids) ) {
		return true;
	}
	return false;
}

/**
 * Function to get post excerpt
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_post_excerpt( $post_id = null, $content = '', $word_length = '55', $more = '...' ) {

	$has_excerpt  = false;
	$word_length  = !empty($word_length) ? $word_length : '55';

	// If post id is passed
	if( !empty($post_id) ) {
		if (has_excerpt($post_id)) {

		  $has_excerpt  = true;
		  $content    	= get_the_excerpt();

		} else {
		  $content = !empty($content) ? $content : get_the_content();
		}
	}

	if( !empty($content) && (!$has_excerpt) ) {
		$content = strip_shortcodes( $content ); // Strip shortcodes
		$content = wp_trim_words( $content, $word_length, $more );
	}
	return $content;
}

/**
 * Function to limit words
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_limit_words($string, $word_limit, $more = '...') {
	$string = wp_trim_words( $string, $word_limit, $more );
	return $string;
}

/**
 * Function to get post featured image
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_featured_image( $post_id = '', $size = 'full', $default_img = false ) {
	$size   = !empty($size) ? $size : 'full';
	$image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	if( ! empty( $image ) ) {
		$image = isset($image[0]) ? $image[0] : '';
	}

	// Getting default image
	if( $default_img && empty($image) ) {       
		return $default_img;
	}

	return $image;
}

/**
 * Function to get post featured image
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_image_src( $attachment_id = '', $size = 'full' ) {

	$size   = !empty($size) ? $size : 'full';
	$image  = wp_get_attachment_image_src( $attachment_id, $size );

	if( !empty($image) ) {
		$image = isset($image[0]) ? $image[0] : '';
	}

	return $image;
}

/**
 * Function to get old browser
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_old_browser() {
	global $is_IE, $is_safari, $is_edge;

	// Only for safari
	$safari_browser = ibwpl_check_browser_safari();

	if( $is_IE || $is_edge || ($is_safari && (isset($safari_browser['version']) && $safari_browser['version'] <= 7.1)) ) {
		return true;
	}
	return false;
}

/**
 * Determine if the browser is Safari or not (last updated 1.7)
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_check_browser_safari() {

	// Takinf some variables
	$browser    = array();
	$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";

	if (stripos($user_agent, 'Safari') !== false && stripos($user_agent, 'iPhone') === false && stripos($user_agent, 'iPod') === false) {
		$aresult = explode('/', stristr($user_agent, 'Version'));
		if (isset($aresult[1])) {
			$aversion = explode(' ', $aresult[1]);
			$browser['version'] = ($aversion[0]);
		} else {
			$browser['version'] = '';
		}
		$browser['browser'] = 'safari';
	}
	return $browser;
}

/**
 * Little Hack to avoid 503 error when too long URL is generate after multiple attemps at WP List Table Search
 * 
 * @subpackage InboundWP
 * @since 1.0
 */
function ibwpl_avoid_long_url() {
	$_SERVER['REQUEST_URI'] = remove_query_arg( '_wp_http_referer', $_SERVER['REQUEST_URI'] );
}

/**
 * Function to get post type supports like sorting and etc
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_post_supports() {
	return apply_filters('ibwpl_post_supports', array());
}

/**
 * Function to get taxonomy supports like sorting and etc
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_taxonomy_supports() {
	return apply_filters('ibwpl_taxonomy_supports', array());
}

/**
 * Function to display message, norice etc
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_display_message( $type = 'update', $msg = '', $echo = 1 ) {

	switch ( $type ) {
		case 'reset':
			$msg = !empty( $msg ) ? $msg : __( 'All settings reset successfully.', 'inboundwp-lite');
			$msg_html = '<div id="message" class="updated notice notice-success is-dismissible">
							<p><strong>' . $msg . '</strong></p>
						</div>';
			break;

		case 'error':
			$msg = !empty( $msg ) ? $msg : __( 'Sorry, Something happened wrong.', 'inboundwp-lite');
			$msg_html = '<div id="message" class="error notice is-dismissible">
							<p><strong>' . $msg . '</strong></p>
						</div>';
			break;

		default:
			$msg = !empty( $msg ) ? $msg : __('Your changes saved successfully.', 'inboundwp-lite');
			$msg_html = '<div id="message" class="updated notice notice-success is-dismissible">
							<p><strong>'. $msg .'</strong></p>
						</div>';
			break;
	}

	if( $echo ) {
		echo $msg_html;
	} else {
		return $msg_html;
	}
}

/**
 * Function to get plugin links
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_plugin_link( $type = 'main', $url_args = array() ) {

	$admin_url 	= admin_url('admin.php');
	$url_args	= is_array( $url_args ) ? $url_args : array();

	switch ($type) {
		case 'current':
			$link = add_query_arg( $url_args );
			break;

		case 'tour':
			$link = add_query_arg( array_merge( array('page' => IBWPL_PAGE_SLUG, 'tab' => 'modules', 'message' => 'ibwp-tutorial'), $url_args ), admin_url('admin.php') );
			break;

		case 'about':
			$link = add_query_arg( array_merge( array('page' => 'ibwp-about'), $url_args ), $admin_url );
			break;
		
		default:
			$link = add_query_arg( array_merge( array('page' => IBWPL_PAGE_SLUG), $url_args ), $admin_url );
			break;
	}
	return apply_filters('ibwpl_get_plugin_link', $link, $type);
}

/**
 * Function to get registered post types
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_post_types( $args = array(), $exclude_post = array() ) {     

	$post_types 		= array();
	$args       		= ( ! empty($args) && is_array($args) ) ? $args : array( 'public' => true );
	$default_post_types = get_post_types( $args, 'name' );
	$exclude_post 		= ! empty($exclude_post) ? (array) $exclude_post : array();

	if( ! empty( $default_post_types ) ) {
		foreach ($default_post_types as $post_type_key => $post_data) {
			if( ! in_array( $post_type_key, $exclude_post ) ) {
				$post_types[$post_type_key] = $post_data->label;
			}
		}
	}

	return apply_filters('ibwpl_get_post_types', $post_types );
}

/**
 * Function to get current page URL
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_get_current_page_url( $args = array() ) {
	
	$curent_page_url = is_ssl() ? 'https://' : 'http://';
	
	//check server port is not 80
	if ( $_SERVER["SERVER_PORT"] != "80" ) {
		$curent_page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$curent_page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}

	// Remove Query Args
	if( isset( $args['remove_args'] ) ) {
		$curent_page_url = remove_query_arg( $args['remove_args'], $curent_page_url );
	}

	return apply_filters( 'ibwpl_get_current_page_url', $curent_page_url );
}

/**
 * Function to check module preview screen is there or not
 * 
 * @since 1.0
 */
function ibwpl_is_module_preview() {

	global $ibwp_module_preview;

	if( (isset( $_SERVER['REQUEST_URI'] ) && strpos($_SERVER['REQUEST_URI'], '?page=ibwp-module-preview&module=') !== false) ||
		(isset( $_SERVER['HTTP_REFERER'] ) && strpos($_SERVER['HTTP_REFERER'], '?page=ibwp-module-preview&module=') !== false)
	) {
		$ibwp_module_preview = 1;
	}

	return $ibwp_module_preview;
}

/**
 * Function to display location.
 * 
 * @since 1.0
 */
function ibwpl_display_locations( $type = 'all', $all = true, $exclude = array() ) {

	$locations		= array();
	$exclude		= array_merge( array('attachment', 'revision', 'nav_menu_item'), $exclude);
	$all_post_types	= ibwpl_get_post_types();
	$post_types		= array();

	foreach ( $all_post_types as $post_type => $post_data ) {
		if( $all ) {
			$type_label = esc_html__( 'All', 'inboundwp-lite' ) .' '. $post_data;
		} else {
			$type_label = $post_data;
		}

		$locations[ $post_type ] = $type_label;
	}

	if ( 'global' != $type ) {
		
		$glocations = array(
			'is_front_page'	=> __( 'Front Page', 'inbount-wp' ),
			'is_search'		=> __( 'Search Results', 'inbount-wp' ),
			'is_404'		=> __( '404 Error Page', 'inbount-wp' ),
			'is_archive'	=> __( 'All Archives', 'inbount-wp' ),
			'all'			=> __( 'Whole Site', 'inbount-wp' ),
		);

		$locations = array_merge( $locations, $glocations );	
	}

	// Exclude some post type or location
	if( ! empty( $exclude ) ) {
		foreach ($exclude as $location_key) {
			unset( $locations[ $location_key ] );
		}
	}

	return $locations;
}

/**
 * Function to get status of post
 * 
 * @package InboundWP Lite
 * @since 1.0
 */
function ibwpl_post_status( $post_ids ) {

	if( empty( $post_ids ) ) {
		return;
	}

	$new_ids = array();
	if( is_array( $post_ids ) ) {
		foreach ( $post_ids as $key => $id ) {
			$post_status = get_post_status( $id );
			if( $post_status == "publish" ) {
				$new_ids[] = $id; 
			}
		}
	} else { 
		$post_status = get_post_status( $post_ids );
		if( $post_status == "publish" ) {
			$new_ids = $post_ids; 
		}
	}

	return $new_ids;
}

/**
 * Function get filter date options
 * 
 * @subpackage InboundWP
 * @since 1.0
 */
function ibwpl_report_date_options() {

	$date_options = array(
							'today'			=> esc_html__('Today', 'inboundwp-lite'),
							'yesterday'		=> esc_html__('Yesterday','inboundwp-lite'),
							'this_week'		=> esc_html__('This Week', 'inboundwp-lite'),
							'last_week'		=> esc_html__('Last Week', 'inboundwp-lite'),
							'last_30_days'	=> esc_html__('Last 30 Days', 'inboundwp-lite'),
							'this_month'	=> esc_html__('This Month', 'inboundwp-lite'),
							'last_month'	=> esc_html__('Last Month', 'inboundwp-lite'),
							'this_quarter'	=> esc_html__('This Quarter', 'inboundwp-lite'),
							'last_quarter'	=> esc_html__('Last Quarter', 'inboundwp-lite'),
							'this_year'		=> esc_html__('This Year', 'inboundwp-lite'),
							'last_year'		=> esc_html__('Last Year', 'inboundwp-lite'),
							'other'			=> esc_html__('Custom', 'inboundwp-lite'),
						);

	return apply_filters( 'ibwpl_report_date_options', $date_options );
}

/**
 * Function get filter date options
 * 
 * @subpackage InboundWP
 * @since 1.0
 */
function ibwpl_get_weeks() {

	$weeks = array(
			'sunday' 	=> esc_html__('Sunday', 'inboundwp-lite'),
			'monday' 	=> esc_html__('Monday', 'inboundwp-lite'),
			'tuesday' 	=> esc_html__('Tuesday', 'inboundwp-lite'),
			'wednesday' => esc_html__('Wednesday', 'inboundwp-lite'),
			'thursday' 	=> esc_html__('Thursday', 'inboundwp-lite'),
			'friday' 	=> esc_html__('Friday', 'inboundwp-lite'),
			'saturday' 	=> esc_html__('Saturday', 'inboundwp-lite'),
		);
	return $weeks;
}

/**
 * Function to get time options
 * 
 * @since 1.0
 */
function ibwpl_time_options() {

	$time_options = array(	
					'day'		=> esc_html__('Days', 'inboundwp-lite'),
					'hour'		=> esc_html__('Hours', 'inboundwp-lite'),
					'minutes'	=> esc_html__('Minutes', 'inboundwp-lite'),
				);
	return apply_filters( 'ibwpl_time_options', $time_options );
}

/**
 * Function get filter date options
 * 
 * @since 1.0
 */
function ibwpl_get_times( $interval = '+30 minutes' ) {

	$times_arr	= array();
	$current	= strtotime('00:00');
	$end		= strtotime('23:59');

	while ( $current <= $end ) {
		$time   = date('H:i', $current);

		$times_arr[ $time ] = date('h:i A', $current);
		$current			= strtotime($interval, $current);
	}

	return $times_arr;
}

/**
 * Function to get date range query
 * 
 * @since 1.1
 */
function ibwpl_date_range_sql( $date_selected ) {

	$dates 	= '';

	switch ( $date_selected ) {
		case 'today':
			$today				= date( 'Y-m-d', current_time('timestamp') );

			$dates				= " AND DATE(created_date) = '{$today}'";
			break;

		case 'yesterday':
			$yesterday			= date( 'Y-m-d', strtotime('-1 days') );

			$dates				= " AND DATE(created_date) = '{$yesterday}'";
			break;

		case 'this_week':
		case 'last_week':
			$base_time			= ( $date_selected === 'this_week' ) ? current_time( 'mysql' ) : date( 'Y-m-d h:i:s', current_time( 'timestamp' ) - WEEK_IN_SECONDS );
			$last_week			= get_weekstartend( $base_time, get_option( 'start_of_week' ) );
			$lweek_start		= date( 'Y-m-d', $last_week['start'] );
			$lweek_end			= date( 'Y-m-d', $last_week['end'] );

			$dates				= " AND DATE(created_date) BETWEEN '{$lweek_start}' AND '{$lweek_end}'";
			break;

		case 'last_30_days' :
			$start_dates		= date( 'Y-m-d', current_time('timestamp') );
			$end_dates			= date( 'Y-m-d', strtotime('-30 days') );

			$dates				= " AND DATE(created_date) BETWEEN '{$end_dates}' AND '{$start_dates}'";

			break;

		case 'this_month':
			$this_month_start	= date('Y-m-01');
			$this_month_end		= date('Y-m-t');

			$dates				= " AND DATE(created_date) BETWEEN '{$this_month_start}' AND '{$this_month_end}'";
			break;

		case 'last_month':
			$month_start		= new DateTime("first day of last month");
			$month_end			= new DateTime("last day of last month");
			$last_month_start	= $month_start->format('Y-m-d');
			$last_month_end		= $month_end->format('Y-m-d');

			$dates				= " AND DATE(created_date) BETWEEN '{$last_month_start}' AND '{$last_month_end}'";
			break;

		case 'this_quarter':
			$current_month		= date('n', current_time( 'timestamp' ));

			if($current_month <= 3) {

				$this_quarter_start	= date('Y-01-01');
				$this_quarter_end	= date('Y-03-t');
			}

			else if($current_month <= 6) {

				$this_quarter_start	= date('Y-04-01');
				$this_quarter_end	= date('Y-06-t');
			}

			else if($current_month <= 9) {

				$this_quarter_start	= date('Y-07-01');
				$this_quarter_end	= date('Y-09-t');
			}

			else {

				$this_quarter_start	= date('Y-10-01');
				$this_quarter_end	= date('Y-12-t');
			}

			$dates				= " AND DATE(created_date) BETWEEN '{$this_quarter_start}' AND '{$this_quarter_end}'";
			break;

		case 'last_quarter':
			$current_month		= date('n');

			if($current_month <= 3) {

				$last_year			= date('Y')-1;
				$last_quarter_start	= date( $last_year.'-10-01' );
				$last_quarter_end	= date( $last_year.'-12-t' );
			}

			else if($current_month <= 6) {

				$last_quarter_start	= date('Y-01-01');
				$last_quarter_end	= date('Y-03-t');
			}

			else if($current_month <= 9) {

				$last_quarter_start	= date('Y-04-01');
				$last_quarter_end	= date('Y-06-t');
			}

			else {

				$last_quarter_start	= date('Y-07-01');
				$last_quarter_end	= date('Y-09-t');
			}

			$dates				= " AND DATE(created_date) BETWEEN '{$last_quarter_start}' AND '{$last_quarter_end}'";
			break;

		case 'this_year':
			$this_year_start	= date('Y-01-01');
			$this_year_end		= date('Y-12-t');

			$dates				= " AND DATE(created_date) BETWEEN '{$this_year_start}' AND '{$this_year_end}'";
			break;

		case 'last_year':
			$last_year			= date('Y')-1;
			$last_year_start	= date( $last_year.'-01-01' );
			$last_year_end		= date( $last_year.'-12-t' );

			$dates				= " AND DATE(created_date) BETWEEN '{$last_year_start}' AND '{$last_year_end}'";
			break;

		case 'other':
			$from_date			= isset( $_GET['from_date'] ) 	? date( 'Y-m-d', strtotime( $_GET['from_date'] ) ) 	: '';
			$to_date			= isset( $_GET['to_date'] ) 	? date( 'Y-m-d', strtotime( $_GET['to_date'] ) ) 	: '';

			$dates				= " AND DATE(created_date) BETWEEN '{$from_date}' AND '{$to_date}'";
			break;
	}

	return $dates;
}

/**
 * Function to get country phone codes
 * 
 * @since 1.0.2
 */
function ibwpl_country_phone_codes() {

	return apply_filters( 'ibwpl_country_phone_codes', array(
			'93'	=> esc_html__('Afghanistan (+93)', 'inboundwp-lite'),
			'355'	=> esc_html__('Albania (+355)', 'inboundwp-lite'),
			'213'	=> esc_html__('Algeria (+213)', 'inboundwp-lite'),
			'684'	=> esc_html__('American Samoa (+684)', 'inboundwp-lite'),
			'376'	=> esc_html__('Andorra (+376)', 'inboundwp-lite'),
			'244'	=> esc_html__('Angola (+244)', 'inboundwp-lite'),
			'1264'	=> esc_html__('Anguilla (+1264)', 'inboundwp-lite'),
			'672'	=> esc_html__('Antarctica (+672)', 'inboundwp-lite'),
			'1268'	=> esc_html__('Antigua and Barbuda (+1268)', 'inboundwp-lite'),
			'54'	=> esc_html__('Argentina (+54)', 'inboundwp-lite'),
			'374'	=> esc_html__('Armenia (+374)', 'inboundwp-lite'),
			'297'	=> esc_html__('Aruba (+297)', 'inboundwp-lite'),
			'61'	=> esc_html__('Australia (+61)', 'inboundwp-lite'),
			'43'	=> esc_html__('Austria (+43)', 'inboundwp-lite'),
			'994'	=> esc_html__('Azerbaijan (+994)', 'inboundwp-lite'),
			'1242'	=> esc_html__('Bahamas (+1242)', 'inboundwp-lite'),
			'973'	=> esc_html__('Bahrain (+973)', 'inboundwp-lite'),
			'880'	=> esc_html__('Bangladesh (+880)', 'inboundwp-lite'),
			'1246'	=> esc_html__('Barbados (+1246)', 'inboundwp-lite'),
			'375'	=> esc_html__('Belarus (+375)', 'inboundwp-lite'),
			'32'	=> esc_html__('Belgium (+32)', 'inboundwp-lite'),
			'501'	=> esc_html__('Belgium (+501)', 'inboundwp-lite'),
			'229'	=> esc_html__('Benin (+229)', 'inboundwp-lite'),
			'1441'	=> esc_html__('Bermuda (+1441)', 'inboundwp-lite'),
			'975'	=> esc_html__('Bhutan (+975)', 'inboundwp-lite'),
			'591'	=> esc_html__('Bolivia (+591)', 'inboundwp-lite'),
			'387'	=> esc_html__('Bosnia and Herzegovina (+387)', 'inboundwp-lite'),
			'267'	=> esc_html__('Botswana (+267)', 'inboundwp-lite'),
			'55'	=> esc_html__('Brazil (+55)', 'inboundwp-lite'),
			'246'	=> esc_html__('British Indian Ocean Territory (+246)', 'inboundwp-lite'),
			'1284'	=> esc_html__('British Virgin Islands (+1284)', 'inboundwp-lite'),
			'673'	=> esc_html__('Brunei (+673)', 'inboundwp-lite'),
			'359'	=> esc_html__('Bulgaria (+359)', 'inboundwp-lite'),
			'226'	=> esc_html__('Burkina Faso (+226)', 'inboundwp-lite'),
			'257'	=> esc_html__('Burundi (+257)', 'inboundwp-lite'),
			'855'	=> esc_html__('Cambodia (+855)', 'inboundwp-lite'),
			'237'	=> esc_html__('Cameroon (+237)', 'inboundwp-lite'),
			'1'		=> esc_html__('Canada (+1)', 'inboundwp-lite'),
			'238'	=> esc_html__('Cape Verde (+238)', 'inboundwp-lite'),
			'1345'	=> esc_html__('Cayman Islands (+1345)', 'inboundwp-lite'),
			'236'	=> esc_html__('Central African Republic (+236)', 'inboundwp-lite'),
			'235'	=> esc_html__('Chad (+235)', 'inboundwp-lite'),
			'56'	=> esc_html__('Chile (+56)', 'inboundwp-lite'),
			'86'	=> esc_html__('China (+86)', 'inboundwp-lite'),
			'61'	=> esc_html__('Christmas Island (+61)', 'inboundwp-lite'),
			'57'	=> esc_html__('Colombia (+57)', 'inboundwp-lite'),
			'269'	=> esc_html__('Comoros (+269)', 'inboundwp-lite'),
			'682'	=> esc_html__('Cook Islands (+682)', 'inboundwp-lite'),
			'506'	=> esc_html__('Costa Rica (+506)', 'inboundwp-lite'),
			'385'	=> esc_html__('Croatia (+385)', 'inboundwp-lite'),
			'53'	=> esc_html__('Cuba (+53)', 'inboundwp-lite'),
			'599'	=> esc_html__('Curacao (+599)', 'inboundwp-lite'),
			'357'	=> esc_html__('Cyprus (+357)', 'inboundwp-lite'),
			'420'	=> esc_html__('Czech Republic (+420)', 'inboundwp-lite'),
			'243'	=> esc_html__('Democratic Republic of the Congo (+243)', 'inboundwp-lite'),
			'45'	=> esc_html__('Denmark (+45)', 'inboundwp-lite'),
			'253'	=> esc_html__('Djibouti (+253)', 'inboundwp-lite'),
			'767'	=> esc_html__('Dominica (+767)', 'inboundwp-lite'),
			'1'		=> esc_html__('Dominican Republic (+1)', 'inboundwp-lite'),
			'670'	=> esc_html__('East Timor (+670)', 'inboundwp-lite'),
			'593'	=> esc_html__('Ecuador (+593)', 'inboundwp-lite'),
			'20'	=> esc_html__('Egypt (+20)', 'inboundwp-lite'),
			'503'	=> esc_html__('El Salvador (+503)', 'inboundwp-lite'),
			'240'	=> esc_html__('Equatorial Guinea (+240)', 'inboundwp-lite'),
			'291'	=> esc_html__('Eritrea (+291)', 'inboundwp-lite'),
			'372'	=> esc_html__('Estonia (+372)', 'inboundwp-lite'),
			'251'	=> esc_html__('Ethiopia (+251)', 'inboundwp-lite'),
			'500'	=> esc_html__('Falkland Islands (+500)', 'inboundwp-lite'),
			'298'	=> esc_html__('Faroe Islands (+298)', 'inboundwp-lite'),
			'679'	=> esc_html__('Fiji (+679)', 'inboundwp-lite'),
			'358'	=> esc_html__('Finland (+358)', 'inboundwp-lite'),
			'33'	=> esc_html__('France (+33)', 'inboundwp-lite'),
			'689'	=> esc_html__('French Polynesia (+689)', 'inboundwp-lite'),
			'241'	=> esc_html__('Gabon (+241)', 'inboundwp-lite'),
			'220'	=> esc_html__('Gambia (+220)', 'inboundwp-lite'),
			'995'	=> esc_html__('Georgia (+995)', 'inboundwp-lite'),
			'49'	=> esc_html__('Germany (+49)', 'inboundwp-lite'),
			'233'	=> esc_html__('Ghana (+233)', 'inboundwp-lite'),
			'350'	=> esc_html__('Gibraltar (+350)', 'inboundwp-lite'),
			'30'	=> esc_html__('Greece (+30)', 'inboundwp-lite'),
			'299'	=> esc_html__('Greenland (+299)', 'inboundwp-lite'),
			'1473'	=> esc_html__('Grenada (+1473)', 'inboundwp-lite'),
			'1'		=> esc_html__('Guam (+1)', 'inboundwp-lite'),
			'502'	=> esc_html__('Guatemala (+502)', 'inboundwp-lite'),
			'44'	=> esc_html__('Guernsey (+44)', 'inboundwp-lite'),
			'224'	=> esc_html__('Guinea (+224)', 'inboundwp-lite'),
			'245'	=> esc_html__('Guinea-Bissau (+245)', 'inboundwp-lite'),
			'592'	=> esc_html__('Guyana (+592)', 'inboundwp-lite'),
			'509'	=> esc_html__('Haiti (+509)', 'inboundwp-lite'),
			'504'	=> esc_html__('Honduras (+504)', 'inboundwp-lite'),
			'852'	=> esc_html__('Hong Kong (+852)', 'inboundwp-lite'),
			'36'	=> esc_html__('Hungary (+36)', 'inboundwp-lite'),
			'354'	=> esc_html__('Iceland (+354)', 'inboundwp-lite'),
			'91'	=> esc_html__('India (+91)', 'inboundwp-lite'),
			'62'	=> esc_html__('Indonesia (+62)', 'inboundwp-lite'),
			'98'	=> esc_html__('Iran (+98)', 'inboundwp-lite'),
			'964'	=> esc_html__('Iraq (+964)', 'inboundwp-lite'),
			'353'	=> esc_html__('Ireland (+353)', 'inboundwp-lite'),
			'44'	=> esc_html__('Isle of Man (+44)', 'inboundwp-lite'),
			'972'	=> esc_html__('Israel (+972)', 'inboundwp-lite'),
			'39'	=> esc_html__('Italy (+39)', 'inboundwp-lite'),
			'225'	=> esc_html__('Ivory Coast (+225)', 'inboundwp-lite'),
			'876'	=> esc_html__('Jamaica (+876)', 'inboundwp-lite'),
			'81'	=> esc_html__('Japan (+81)', 'inboundwp-lite'),
			'44'	=> esc_html__('Jersey (+44)', 'inboundwp-lite'),
			'962'	=> esc_html__('Jordan (+962)', 'inboundwp-lite'),
			'77'	=> esc_html__('Kazakhstan (+77)', 'inboundwp-lite'),
			'254'	=> esc_html__('Kenya (+254)', 'inboundwp-lite'),
			'686'	=> esc_html__('Kiribati (+686)', 'inboundwp-lite'),
			'383'	=> esc_html__('Kosovo (+383)', 'inboundwp-lite'),
			'965'	=> esc_html__('Kuwait (+965)', 'inboundwp-lite'),
			'996'	=> esc_html__('Kyrgyzstan (+996)', 'inboundwp-lite'),
			'856'	=> esc_html__('Laos (+856)', 'inboundwp-lite'),
			'371'	=> esc_html__('Latvia (+371)', 'inboundwp-lite'),
			'961'	=> esc_html__('Lebanon (+961)', 'inboundwp-lite'),
			'266'	=> esc_html__('Lesotho (+266)', 'inboundwp-lite'),
			'231'	=> esc_html__('Liberia (+231)', 'inboundwp-lite'),
			'218'	=> esc_html__('Libya (+218)', 'inboundwp-lite'),
			'423'	=> esc_html__('Liechtenstein (+423)', 'inboundwp-lite'),
			'370'	=> esc_html__('Lithuania (+370)', 'inboundwp-lite'),
			'352'	=> esc_html__('Luxembourg (+352)', 'inboundwp-lite'),
			'853'	=> esc_html__('Macau (+853)', 'inboundwp-lite'),
			'389'	=> esc_html__('Macedonia (+389)', 'inboundwp-lite'),
			'265'	=> esc_html__('Malawi (+265)', 'inboundwp-lite'),
			'60'	=> esc_html__('Malaysia (+60)', 'inboundwp-lite'),
			'960'	=> esc_html__('Maldives (+960)', 'inboundwp-lite'),
			'223'	=> esc_html__('Mali (+223)', 'inboundwp-lite'),
			'356'	=> esc_html__('Malta (+356)', 'inboundwp-lite'),
			'692'	=> esc_html__('Marshall Islands (+692)', 'inboundwp-lite'),
			'222'	=> esc_html__('Mauritania (+222)', 'inboundwp-lite'),
			'230'	=> esc_html__('Mauritius (+230)', 'inboundwp-lite'),
			'262'	=> esc_html__('Mayotte (+262)', 'inboundwp-lite'),
			'52'	=> esc_html__('Mexico (+52)', 'inboundwp-lite'),
			'691'	=> esc_html__('Micronesia (+691)', 'inboundwp-lite'),
			'373'	=> esc_html__('Moldova (+373)', 'inboundwp-lite'),
			'377'	=> esc_html__('Monaco (+377)', 'inboundwp-lite'),
			'976'	=> esc_html__('Mongolia (+976)', 'inboundwp-lite'),
			'382'	=> esc_html__('Montenegro (+382)', 'inboundwp-lite'),
			'1'		=> esc_html__('Montserrat (+1)', 'inboundwp-lite'),
			'212'	=> esc_html__('Morocco (+212)', 'inboundwp-lite'),
			'258'	=> esc_html__('Mozambique (+258)', 'inboundwp-lite'),
			'95'	=> esc_html__('Myanmar (+95)', 'inboundwp-lite'),
			'264'	=> esc_html__('Namibia (+264)', 'inboundwp-lite'),
			'674'	=> esc_html__('Nauru (+674)', 'inboundwp-lite'),
			'977'	=> esc_html__('Nepal (+977)', 'inboundwp-lite'),
			'31'	=> esc_html__('Netherlands (+31)', 'inboundwp-lite'),
			'599'	=> esc_html__('Netherlands Antilles (+599)', 'inboundwp-lite'),
			'687'	=> esc_html__('New Caledonia (+687)', 'inboundwp-lite'),
			'64'	=> esc_html__('New Zealand (+64)', 'inboundwp-lite'),
			'505'	=> esc_html__('Nicaragua (+505)', 'inboundwp-lite'),
			'227'	=> esc_html__('Niger (+227)', 'inboundwp-lite'),
			'234'	=> esc_html__('Nigeria (+234)', 'inboundwp-lite'),
			'683'	=> esc_html__('Niue (+683)', 'inboundwp-lite'),
			'850'	=> esc_html__('North Korea (+850)', 'inboundwp-lite'),
			'1'		=> esc_html__('Northern Mariana Islands (+1)', 'inboundwp-lite'),
			'47'	=> esc_html__('Norway (+47)', 'inboundwp-lite'),
			'968'	=> esc_html__('Oman (+968)', 'inboundwp-lite'),
			'92'	=> esc_html__('Pakistan (+92)', 'inboundwp-lite'),
			'680'	=> esc_html__('Palau (+680)', 'inboundwp-lite'),
			'970'	=> esc_html__('Palestine (+970)', 'inboundwp-lite'),
			'507'	=> esc_html__('Panama (+507)', 'inboundwp-lite'),
			'675'	=> esc_html__('Papua New Guinea (+675)', 'inboundwp-lite'),
			'595'	=> esc_html__('Paraguay (+595)', 'inboundwp-lite'),
			'51'	=> esc_html__('Peru (+51)', 'inboundwp-lite'),
			'63'	=> esc_html__('Philippines (+63)', 'inboundwp-lite'),
			'64'	=> esc_html__('Pitcairn (+64)', 'inboundwp-lite'),
			'48'	=> esc_html__('Poland (+48)', 'inboundwp-lite'),
			'351'	=> esc_html__('Portugal (+351)', 'inboundwp-lite'),
			'1'		=> esc_html__('Puerto Rico (+1)', 'inboundwp-lite'),
			'974'	=> esc_html__('Qatar (+974)', 'inboundwp-lite'),
			'242'	=> esc_html__('Republic of the Congo (+242)', 'inboundwp-lite'),
			'262'	=> esc_html__('Reunion (+262)', 'inboundwp-lite'),
			'40'	=> esc_html__('Romania (+40)', 'inboundwp-lite'),
			'7'		=> esc_html__('Russia (+7)', 'inboundwp-lite'),
			'250'	=> esc_html__('Rwanda (+250)', 'inboundwp-lite'),
			'590'	=> esc_html__('Saint Barthelemy (+590)', 'inboundwp-lite'),
			'290'	=> esc_html__('Saint Helena (+290)', 'inboundwp-lite'),
			'1869'	=> esc_html__('Saint Kitts and Nevis (+1869)', 'inboundwp-lite'),
			'1758'	=> esc_html__('Saint Lucia (+1758)', 'inboundwp-lite'),
			'590'	=> esc_html__('Saint Martin (+590)', 'inboundwp-lite'),
			'508'	=> esc_html__('Saint Pierre and Miquelon (+508)', 'inboundwp-lite'),
			'1784'	=> esc_html__('Saint Vincent and the Grenadines (+1784)', 'inboundwp-lite'),
			'685'	=> esc_html__('Samoa (+685)', 'inboundwp-lite'),
			'378'	=> esc_html__('San Marino (+378)', 'inboundwp-lite'),
			'239'	=> esc_html__('Sao Tome and Principe (+239)', 'inboundwp-lite'),
			'966'	=> esc_html__('Saudi Arabia (+966)', 'inboundwp-lite'),
			'221'	=> esc_html__('Senegal (+221)', 'inboundwp-lite'),
			'381'	=> esc_html__('Serbia (+381)', 'inboundwp-lite'),
			'248'	=> esc_html__('Seychelles (+248)', 'inboundwp-lite'),
			'232'	=> esc_html__('Sierra Leone (+232)', 'inboundwp-lite'),
			'65'	=> esc_html__('Singapore (+65)', 'inboundwp-lite'),
			'599'	=> esc_html__('Sint Maarten (+599)', 'inboundwp-lite'),
			'421'	=> esc_html__('Slovakia (+421)', 'inboundwp-lite'),
			'677'	=> esc_html__('Solomon Islands (+677)', 'inboundwp-lite'),
			'252'	=> esc_html__('Somalia (+252)', 'inboundwp-lite'),
			'27'	=> esc_html__('South Africa (+27)', 'inboundwp-lite'),
			'82'	=> esc_html__('South Korea (+82)', 'inboundwp-lite'),
			'211'	=> esc_html__('South Sudan (+211)', 'inboundwp-lite'),
			'34'	=> esc_html__('Spain (+34)', 'inboundwp-lite'),
			'94'	=> esc_html__('Sri Lanka (+94)', 'inboundwp-lite'),
			'249'	=> esc_html__('Sudan (+249)', 'inboundwp-lite'),
			'597'	=> esc_html__('Suriname (+597)', 'inboundwp-lite'),
			'47'	=> esc_html__('Svalbard and Jan Mayen (+47)', 'inboundwp-lite'),
			'268'	=> esc_html__('Swaziland (+268)', 'inboundwp-lite'),
			'46'	=> esc_html__('Sweden (+46)', 'inboundwp-lite'),
			'41'	=> esc_html__('Switzerland (+41)', 'inboundwp-lite'),
			'963'	=> esc_html__('Syria (+963)', 'inboundwp-lite'),
			'886'	=> esc_html__('Taiwan (+886)', 'inboundwp-lite'),
			'992'	=> esc_html__('Tajikistan (+992)', 'inboundwp-lite'),
			'255'	=> esc_html__('Tanzania (+255)', 'inboundwp-lite'),
			'66'	=> esc_html__('Thailand (+66)', 'inboundwp-lite'),
			'228'	=> esc_html__('Togo (+228)', 'inboundwp-lite'),
			'690'	=> esc_html__('Tokelau (+690)', 'inboundwp-lite'),
			'676'	=> esc_html__('Tonga (+676)', 'inboundwp-lite'),
			'868'	=> esc_html__('Trinidad and Tobago (+868)', 'inboundwp-lite'),
			'216'	=> esc_html__('Tunisia (+216)', 'inboundwp-lite'),
			'90'	=> esc_html__('Turkey (+90)', 'inboundwp-lite'),
			'993'	=> esc_html__('Turkmenistan (+993)', 'inboundwp-lite'),
			'1'		=> esc_html__('Turks and Caicos Islands (+1)', 'inboundwp-lite'),
			'688'	=> esc_html__('Tuvalu (+688)', 'inboundwp-lite'),
			'1'		=> esc_html__('U.S. Virgin Islands (+1)', 'inboundwp-lite'),
			'256'	=> esc_html__('Uganda (+256)', 'inboundwp-lite'),
			'380'	=> esc_html__('Ukraine (+380)', 'inboundwp-lite'),
			'971'	=> esc_html__('United Arab Emirates (+971)', 'inboundwp-lite'),
			'44'	=> esc_html__('United Kingdom (+44)', 'inboundwp-lite'),
			'1'		=> esc_html__('United States (+1)', 'inboundwp-lite'),
			'598'	=> esc_html__('Uruguay (+598)', 'inboundwp-lite'),
			'998'	=> esc_html__('Uzbekistan (+998)', 'inboundwp-lite'),
			'678'	=> esc_html__('Vanuatu (+678)', 'inboundwp-lite'),
			'379'	=> esc_html__('Vatican (+379)', 'inboundwp-lite'),
			'58'	=> esc_html__('Venezuela (+58)', 'inboundwp-lite'),
			'84'	=> esc_html__('Vietnam (+84)', 'inboundwp-lite'),
			'681'	=> esc_html__('Wallis and Futuna (+681)', 'inboundwp-lite'),
			'212'	=> esc_html__('Western Sahara (+212)', 'inboundwp-lite'),
			'967'	=> esc_html__('Yemen (+967)', 'inboundwp-lite'),
			'260'	=> esc_html__('Zambia (+260)', 'inboundwp-lite'),
			'263'	=> esc_html__('Zimbabwe (+263)', 'inboundwp-lite'),
	));
}

/**
 * Function to get Mailchimp Account Info
 * 
 * @since 1.1
 */
function ibwpl_get_mc_info( $type = 'lists' ) {

	$mc_info = get_option('ibwp_mc_info');
	return isset( $mc_info[ $type ] ) ? $mc_info[ $type ] : false;
}

/**
 * Function get image repeat options
 * 
 * @subpackage InboundWP
 * @since 1.0
 */
function ibwpl_img_repeat_options() {

	$img_repeat_options = array(	
							'no-repeat' => esc_html__('No Repeat', 'inboundwp-lite'),
							'repeat' 	=> esc_html__('Repeat', 'inboundwp-lite'),
							'repeat-x' 	=> esc_html__('Repeat X', 'inboundwp-lite'),
							'repeat-y' 	=> esc_html__('Repeat Y', 'inboundwp-lite'),
						);

	return apply_filters('ibwpl_img_repeat_options', $img_repeat_options );
}

/**
 * Function to get image position options
 * 
 * @since 1.0
 */
function ibwpl_img_position_options() {

	$img_position_options = array(	
							'center top'	=> esc_html__('Center Top', 'inboundwp-lite'),
							'center center'	=> esc_html__('Center Center', 'inboundwp-lite'),
							'center bottom'	=> esc_html__('Center Bottom', 'inboundwp-lite'),
							'left top'		=> esc_html__('Left Top', 'inboundwp-lite'),
							'left center'	=> esc_html__('Left Center', 'inboundwp-lite'),
							'left bottom'	=> esc_html__('Left Bottom', 'inboundwp-lite'),
							'right top'		=> esc_html__('Right Top', 'inboundwp-lite'),
							'right center'	=> esc_html__('Right Center', 'inboundwp-lite'),
							'right bottom'	=> esc_html__('Right Bottom', 'inboundwp-lite'),
						);

	return apply_filters('ibwpl_img_position_options', $img_position_options );
}

/**
 * Function to get show for options
 * 
 * @since 1.0
 */
function ibwpl_show_for_options() {

	$show_for_options = array(	
							'all'		=> esc_html__('Every One', 'inboundwp-lite'),
							'guest'		=> esc_html__('Guest User', 'inboundwp-lite'),
							'member'	=> esc_html__('Logged In User', 'inboundwp-lite'),
						);
	return apply_filters('ibwpl_show_for_options', $show_for_options );
}

/**
 * Function to get post type posts
 * 
 * @since 1.0
 */
function ibwpl_get_posts( $post_type = '' ) {

	$post_args = array(
		'post_type' 		=> $post_type,
		'post_status' 		=> 'publish',
		'posts_per_page' 	=> -1,
		'order'				=> 'DESC',
		'orderby' 			=> 'date',
	);

	$ibwp_posts = get_posts( $post_args );

	return apply_filters('ibwpl_get_posts', $ibwp_posts, $post_args );
}

/**
 * Function to get When appear sett
 * 
 * @since 1.0
 */
function ibwpl_when_appear_options() {

	$popup_appear = array(
						'page_load'		=>	esc_html__('Page Load', 'inboundwp-lite'),
						'inactivity'	=>	esc_html__('After X Second of Inactivity', 'inboundwp-lite'),
						'scroll'		=>	esc_html__('When Page Scroll Down', 'inboundwp-lite'),
						'scroll_up'		=>	esc_html__('When Page Scroll UP', 'inboundwp-lite'),
						'exit'			=> 	esc_html__('Exit Intent', 'inboundwp-lite'),
						'html_element'	=> 	esc_html__('HTML Element Click', 'inboundwp-lite'),
					);

	return apply_filters('ibwpl_when_appear_options', $popup_appear );
}

/**
 * Function to get form field type options
 * 
 * @since 1.0
 */
function ibwpl_form_field_type_options() {

	$field_type_options = array(
							'email'		=> array( 'type' => 'email', 'label' => esc_html__('Email', 'inboundwp-lite') ),
							'full_name'	=> array( 'type' => 'text', 'label' => esc_html__('Full Name (First Name & Last Name)', 'inboundwp-lite') ),
							'tel'		=> array( 'type' => 'tel', 'label' => esc_html__('Phone Number', 'inboundwp-lite') ),
						);
	return apply_filters('ibwpl_form_field_type_options', $field_type_options );
}

/**
 * Get post meta
 * If preview is there then get run time post meta
 * 
 * @since 1.0
 */
function ibwpl_get_meta( $post_id, $meta_key, $flag = true ) {

	global $ibwp_module_preview;

	$post_meta = get_post_meta( $post_id, $meta_key, $flag );

	// If module preview is there
	if( $ibwp_module_preview && ! empty( $_POST['ibwp_preview_form_data'] ) ) {
		$form_data = $_POST['ibwp_preview_form_data'];
		$post_meta = isset( $form_data[ $meta_key ] ) ? stripslashes_deep( $form_data[ $meta_key ] ) : '';
	}

	return $post_meta;
}

/**
 * Get post meta
 * If preview is there then get run time post meta
 * 
 * @since 1.0
 */
function ibwpl_get_post_status( $post_id ) {

	global $ibwp_module_preview;

	$post_status = get_post_status( $post_id );

	// If module preview is there
	if( $ibwp_module_preview && ! empty( $_POST['ibwp_preview_form_data'] ) ) {
		$post_status = 'publish';
	}

	return $post_status;
}

/**
 * Function to check Testimonial Pro Plugin is active or not
 * 
 * @since 1.0
 */
function ibwpl_is_testimonial_active() {

}

/**
 * Function to get module preview popup HTML
 * 
 * @since 1.0
 */
function ibwpl_module_preview_popup( $args = array() ) {

	$default_args = array(
							'title' 		=> '',
							'preview_link'	=> '',
							'info'			=> '',
						);
	$args = wp_parse_args( $args, $default_args );
?>
	<div class="ibwp-popup-modal ibwp-cnt-wrap">
		<div class="ibwp-popup-modal-act-btn-wrp">
			<span class="ibwp-popup-modal-act-btn ibwp-popup-modal-info" title="<?php echo esc_html__("Note: Preview will be displayed according to responsive layout mode. Live preview may display differently when added to your page based on inheritance from some styles.", 'inboundwp-lite'); ?>"><i class="dashicons dashicons-info"></i></span>
			<span class="ibwp-popup-modal-act-btn ibwp-popup-modal-close ibwp-popup-close" title="<?php esc_html_e('Close', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-no-alt"></i></span>
		</div>
		<div class="ibwp-popup-modal-title-wrp">
			<span class="ibwp-popup-modal-title"><?php echo $args['title']; ?></span>
		</div>
		<div class="ibwp-popup-modal-cnt">
			<iframe src="about:blank" data-src="<?php echo esc_url( $args['preview_link'] ); ?>" class="ibwp-preview-frame ibwp-spw-preview-frame" name="ibwp_preview_frame" scrolling="auto" frameborder="0"></iframe>
			<div class="ibwp-popup-modal-loader"></div>
		</div>
	</div>
	<div class="ibwp-popup-modal-overlay"></div>
<?php
}

/**
 * Function to get upgrade to pro link
 * 
 * @since 1.0
 */
function ibwpl_upgrade_pro_link() {

	$updrade_link = "<a href=".IBWPL_UPGRADE_LINK." target='_blank' class='ibwp-pro-link'>". esc_html__('Upgrade to Premium', 'inboundwp-lite') ."</a>";

	return $updrade_link;
}