<?php
/**
 * Post title popup HTML
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

$title_change_data = $wpdb->get_results( "SELECT `id`, `title`, `created_date`, SUM(title_click) AS `clicks` FROM `".IBWPL_BH_TBL."` WHERE 1=1 AND `post_id` = {$post_id} AND `title_id` = {$title_id} GROUP BY `title` ORDER BY `created_date` DESC LIMIT 50" );
$title_data_count	= count( $title_change_data );
?>
<div class="ibwp-popup-body ibwp-timeline-wrap">
	<?php if( $title_data_count >= 2 ) {
		foreach ( $title_change_data as $title_change_key => $title_data ) { ?>
			<div class="ibwp-timeline-item">
				<div class="ibwp-timeline-item-inr">
					<div class="ibwp-timeline-heading">
						<span><?php echo $title_data->created_date; ?></span>
					</div>
					<div class="ibwp-timeline-marker"></div>
					<div class="ibwp-timeline-content-wrp">
						<div class="ibwp-timeline-content-innr">
							<span class="ibwp-timeline-th"><?php esc_html_e('Title', 'inboundwp-lite'); ?> : </span>
							<span class="ibwp-timeline-td"><?php echo $title_data->title; ?></span>
						</div>
						<div class="ibwp-timeline-content-innr">
							<span class="ibwp-timeline-th"><?php esc_html_e('Clicks', 'inboundwp-lite'); ?> :</span>
							<span class="ibwp-timeline-td"><?php echo $title_data->clicks; ?></span>
						</div>
					</div>
				</div>
			</div>
		<?php }
	} else { ?>
		<p><?php esc_html_e('Sorry, No title changes found.', 'inboundwp-lite'); ?></p>
	<?php } ?>
</div>