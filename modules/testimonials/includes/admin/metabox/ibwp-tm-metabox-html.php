<?php
/**
 * Handles testimonial metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$prefix = IBWPL_TM_META_PREFIX; // Metabox prefix

// Getting saved values
$client 	= get_post_meta( $post->ID, '_testimonial_client', true );
$job 		= get_post_meta( $post->ID, '_testimonial_job', true );
$company 	= get_post_meta( $post->ID, '_testimonial_company', true );
$url 		= get_post_meta( $post->ID, '_testimonial_url', true );
$rating 	= get_post_meta( $post->ID, $prefix.'rating', true );
?>

<table class="form-table ibwp-tbl">
	<tbody>
		<tr valign="top">
			<th scope="row">
				<label for="ibwp-tm-client-name"><?php _e('Client Name', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo ibwpl_esc_attr($client); ?>" class="ibwp-text large-text ibwp-tm-client-name" id="ibwp-tm-client-name" name="_testimonial_client" /><br/>
				<span class="description"><?php _e( 'Enter client name.', 'inboundwp-lite' ); ?></span>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label for="ibwp-tm-job-title"><?php _e('Job Title', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo ibwpl_esc_attr($job); ?>" class="ibwp-text large-text ibwp-tm-job-title" id="ibwp-tm-job-title" name="_testimonial_job" /><br/>
				<span class="description"><?php _e( 'Enter job title.', 'inboundwp-lite' ); ?></span>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label for="ibwp-tm-company"><?php _e('Company', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo ibwpl_esc_attr($company); ?>" class="ibwp-text large-text ibwp-tm-company" id="ibwp-tm-company" name="_testimonial_company" /><br/>
				<span class="description"><?php _e( 'Enter company name.', 'inboundwp-lite' ); ?></span>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label for="ibwp-tm-url"><?php _e('URL', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo esc_url( $url ); ?>" class="ibwp-text large-text ibwp-tm-url" id="ibwp-tm-url" name="_testimonial_url" /><br/>
				<span class="description"><?php _e( 'Enter company or job url.', 'inboundwp-lite' ); ?></span>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label for="ibwp-tm-rating"><?php _e('Rating', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select name="<?php echo $prefix; ?>rating" class="ibwp-select ibwp-tm-rating" id="ibwp-tm-rating">
					<option value=""><?php _e('None', 'inboundwp-lite'); ?></option>
					<?php for( $i=1; $i<=5; $i++ ) { ?>
					<option value="<?php echo $i; ?>" <?php selected( $rating, $i ); ?>><?php echo $i; ?></option>
					<?php } ?>
				</select><br/>
				<span class="description"><?php _e( 'Select testimonial rating.', 'inboundwp-lite' ); ?></span>
			</td>
		</tr>

	</tbody>
</table><!-- end .ibwp-tbl -->