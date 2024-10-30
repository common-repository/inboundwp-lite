<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package InboundWP Lite
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$prefix 		= IBWPL_DCDT_META_PREFIX; // Metabox prefix
$get_timer_post = get_post_meta( $post->ID, $prefix.'timer_post', true );
?>

<table class="form-table ibwp-dcdt-page-sett-table">
	<tbody>
		<tr valign="top">
			<th scope="row">
				<label for="ibwp-dcdt-select-timer"><?php _e('Select Deal Countdown Timer', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<select name="<?php echo $prefix; ?>timer_post" class="large-text" id="ibwp-dcdt-select-timer">
					<option value=""><?php _e('Select timer','inboundwp-lite'); ?></option>
					<?php
					// Get the 'Deal Countdown Timer' post type
					$timer_posts = get_posts(
								array(
									'post_type'			=> IBWPL_DCDT_POST_TYPE, 
									'post_status'		=> 'publish', 
									'suppress_filters' 	=> false, 
									'posts_per_page'	=> -1
								)
							);
					
					foreach ($timer_posts as $timer_post) {
						echo '<option value="'. $timer_post->ID. '" '.selected( $get_timer_post, $timer_post->ID ).'>'. $timer_post->post_title. '</option>';
					} ?>
				</select>
			</td>
		</tr>
	</tbody>
</table>