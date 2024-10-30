<?php
/**
 * `sp_testimonials` Shortcode
 * 
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Function to handle testimonial shortcode
 *
 * @since 1.0
 */
function ibwpl_tm_testimonial_grid( $atts, $content ) {

	// Taking some globals
	global $post;

	$atts = shortcode_atts(array(
		'limit' 				=> 20,
		'design'				=> 'design-1',
		'per_row' 				=> 3,
		'orderby' 				=> 'date',
		'order' 				=> 'DESC',
		'display_client' 		=> 'true',
		'display_avatar' 		=> 'true',
		'display_job' 			=> 'true',
		'display_company' 		=> 'true',
		'image_style'			=> 'circle',
		'size' 					=> 100,
		'category' 				=> '',
	), $atts, 'sp_testimonials' );

	$shortcode_designs 			= ibwpl_tm_designs();
	$atts['limit'] 				= ibwpl_clean_number( $atts['limit'], 20, 'number' );
	$atts['per_row'] 			= ibwpl_clean_number( $atts['per_row'], 3 );
	$atts['size'] 				= ibwpl_clean_number( $atts['size'], 100 );
	$atts['design'] 			= ( $atts['design'] && ( array_key_exists( trim( $atts['design'] ), $shortcode_designs ) ) ) ? trim( $atts['design'] ) 	: 'design-1';
	$atts['orderby'] 			= !empty( $atts['orderby'] ) 					? $atts['orderby'] 								: 'date';
	$atts['order'] 				= ( strtolower( $atts['order'] ) == 'asc' ) 	? 'ASC' 										: 'DESC';
	$atts['cat'] 				= ( !empty($atts['category'] ) )				? explode( ',',$atts['category'] ) 				: '';
	$atts['display_client'] 	= ( $atts['display_client'] == 'true' ) 		? 1 											: 0;
	$atts['display_avatar'] 	= ( $atts['display_avatar'] == 'true' ) 		? 1 											: 0;
	$atts['display_job'] 		= ( $atts['display_job'] == 'true' ) 			? 1 											: 0;
	$atts['display_company']	= ( $atts['display_company'] == 'true' ) 		? 1 											: 0;
	$atts['image_style'] 		= ( $atts['image_style'] == 'circle' ) 			? 'ibwp-tm-circle' 								: 'ibwp-tm-square';

	extract( $atts );

	// Taking some globals
	global $post;

	// Taking some variables
	$count 		= 0;
	$prefix 	= IBWPL_TM_META_PREFIX;
	$tper_row	= ibwpl_grid_column( $per_row );

	// Query Parameter
	$args = array (
		'post_type' 			=> IBWPL_TM_POST_TYPE,
		'post_status'			=> array( 'publish' ),
		'order' 				=> $order,
		'orderby'				=> $orderby,
		'posts_per_page' 		=> $limit,
		'ignore_sticky_posts'	=> true,
	);

	// Category Parameter
	if($cat != '') {

		$args['tax_query'] = array(
								array(
									'taxonomy' 	=> IBWPL_TM_CAT,
									'field' 	=> 'term_id',
									'terms' 	=> $cat,
							));

	}

	// WP Query
	$query = new WP_Query($args);

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {

		ibwpl_get_template( IBWPL_TM_DIR_NAME, "grid/loop-start.php", $atts ); // loop start

		while ( $query->have_posts() ) : $query->the_post();

			$count++;
			$atts['css_class'] 	= 'ibwp-tm-quote ibwp-tm-medium-'.$tper_row.' ibwp-tm-columns';
			$atts['css_class']	.= ( $count % $per_row == 1 )	? ' ibwp-tm-first' : '';
			$atts['css_class']	.= ( $count % $per_row == 0 )	? ' ibwp-tm-last'	: '';

			$job_data					= array();
			$atts['author_image'] 		= ibwpl_tm_get_image( $post->ID, $size, $image_style );
			$atts['author'] 			= get_post_meta( $post->ID, '_testimonial_client', true );
			$atts['job_title']			= get_post_meta( $post->ID, '_testimonial_job', true );
			$atts['company'] 			= get_post_meta( $post->ID, '_testimonial_company', true );
			$atts['url'] 				= get_post_meta( $post->ID, '_testimonial_url', true );
			$atts['rating'] 			= get_post_meta( $post->ID, $prefix.'rating', true );
			$atts['testimonial_title']	= get_the_title();

			// Add a CSS class if no image is available.
			if( empty( $atts['author_image'] ) ) {
				$atts['css_class'] .= ' ibwp-tm-no-image';
			}

			// Testimonial Meta
			if( $display_job && $atts['job_title'] ) {
				$job_data[] = $atts['job_title'];
			}
			if( $display_company && $atts['company'] ) {
				$job_data[] = !empty( $atts['url'] ) ? '<a href="'.esc_url( $atts['url'] ).'" target="_blank">'.$atts['company'].'</a>' : $atts['company'];
			}
			$atts['job_meta'] = join( ' / ', $job_data );

			// Include shortcode html file
			ibwpl_get_template( IBWPL_TM_DIR_NAME, "grid/{$design}.php", $atts, null, null, "designs/{$design}.php" );

			endwhile;

		ibwpl_get_template( IBWPL_TM_DIR_NAME, "grid/loop-end.php", $atts ); // loop end

	} // end of have_post()

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// Testimonial Grid Shortcode
add_shortcode( 'sp_testimonials', 'ibwpl_tm_testimonial_grid' );
add_shortcode( 'ibwp_tmw_grid', 'ibwpl_tm_testimonial_grid' );