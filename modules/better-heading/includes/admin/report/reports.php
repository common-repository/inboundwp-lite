<?php
/**
 * Report Settings
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $wpdb;

// Taking some data
$from_date		= '';
$to_date		= '';
$date_options	= ibwpl_report_date_options();
$current_date	= date( 'Y-m-d', current_time( 'timestamp' ) );
/*$reg_post_types	= ibwpl_get_post_types( null, array('attachment', 'revision', 'nav_menu_item') );*/

$post_type		= ! empty( $_GET['post_types'] )			? ibwpl_clean( $_GET['post_types'] )			: 'post';
$post_titles	= ! empty( $_GET['post_titles'] )			? ibwpl_clean_number( $_GET['post_titles'] )	: 0;
$date_selected	= ! empty( $_GET['date_range'] )			? ibwpl_clean( $_GET['date_range'] )			: 'last_30_days';
$date_text		= isset( $date_options[ $date_selected ] )	? $date_options[ $date_selected ]			: '';

$selected_post 			= get_post( $post_titles );
$selected_post_id		= isset( $selected_post->ID ) ? $selected_post->ID : null;
$selected_post_title	= isset( $selected_post->post_title ) ? $selected_post->post_title : '';
$selected_post_type		= isset( $selected_post->post_type ) ? $selected_post->post_type : $post_type;

if( $date_selected == 'other' ) {
	$from_date	= isset( $_GET['from_date'] )	? date( 'Y-m-d', strtotime( $_GET['from_date'] ) )	: '';
	$to_date	= isset( $_GET['to_date'] )		? date( 'Y-m-d', strtotime( $_GET['to_date'] ) )	: '';
	$date_text	= $from_date .' '. __('to', 'inboundwp-lite') .' '. $to_date;
}

$date_range	= ibwpl_date_range_sql( $date_selected );

// Get post title data
$title_clicks_data = $wpdb->get_results( "SELECT post_id, title_id, title, SUM( title_click ) AS `title_click_sum` FROM `".IBWPL_BH_TBL."` WHERE 1=1 AND post_id = {$post_titles} {$date_range} GROUP BY `title_id` ORDER BY `title_click_sum` DESC" );

// Get post title total clicks
$total_clicks	= $wpdb->get_var( "SELECT SUM( title_click ) FROM `".IBWPL_BH_TBL."` WHERE 1=1 AND `post_id` = {$post_titles} {$date_range}" );
$total_clicks	= ! empty( $total_clicks ) ? $total_clicks : 0;

// Get post title total views
$total_views	= $wpdb->get_var( "SELECT COUNT( post_ids ) FROM `".IBWPL_BH_STATS_TBL."` WHERE 1=1 AND FIND_IN_SET({$post_titles}, `post_ids`) {$date_range}" );
$total_views	= ! empty( $total_views ) ? $total_views : 0;
?>

<div class="postbox ibwp-no-toggle">

	<h3 class="hndle">
		<span><?php esc_html_e( 'Report Settings', 'inboundwp-lite' ); ?></span>
	</h3>

	<div class="inside ibwp-report-wrp ibwp-cnt-wrap">
		<div class="ibwp-report-form-wrp ibwp-bh-report-form-wrp">
			<form id="ibwp-bh-post-report" class="ibwp-report-form ibwp-bh-report-form" method="get" action="">

				<input type="hidden" name="page" value="ibwp-bh-settings" />
				<input type="hidden" name="tab" value="report" />

				<select name="post_titles" class="ibwp-select ibwp-select2 ibwp-post-title-sugg ibwp-bh-post-title" data-placeholder="<?php esc_html_e('Search Post By Title or ID', 'inboundwp-lite'); ?>" data-post-type="post" data-nonce="<?php echo wp_create_nonce( 'ibwp-post-title-sugg' ); ?>">
					<option value="<?php echo ibwpl_esc_attr( $selected_post_id ); ?>" <?php selected( $post_titles, $selected_post_id ); ?>><?php echo ibwpl_esc_attr( $selected_post_title ); ?></option>
				</select>

				<select name="date_range" class="ibwp-select ibwp-select2 ibwp-date-range-filter ibwp-bh-date-filter">
					<?php foreach ( $date_options as $date_key => $date_val ) { ?>
						<option value="<?php echo ibwpl_esc_attr( $date_key ) ?>" <?php selected( $date_selected, $date_key ); ?>><?php echo $date_val; ?></option>
					<?php } ?>
				</select>

				<div class="ibwp-date-range-field ibwp-bh-search-date" style="<?php if( $date_selected != 'other' ) { echo "display: none;"; } ?>">
					<span><?php esc_html_e('From', 'inboundwp-lite'); ?>: </span>
					<input type="date" name="from_date" value="<?php echo ibwpl_esc_attr( $from_date ); ?>" max="<?php echo ibwpl_esc_attr( $current_date ); ?>" id="ibwp-bh-from-date" class="ibwp-start-date ibwp-date-field ibwp-bh-from-date" />
					
					<span><?php esc_html_e('To', 'inboundwp-lite'); ?>: </span>
					<input type="date" name="to_date" value="<?php echo ibwpl_esc_attr( $to_date ); ?>" max="<?php echo ibwpl_esc_attr( $current_date ); ?>" id="ibwp-bh-to-date" class="ibwp-end-date ibwp-date-field ibwp-bh-to-date" />
				</div>
				<button class="button button-secondary ibwp-btn ibwp-bh-filter-btn" type="submit"><?php esc_html_e('Filter','inboundwp-lite'); ?></button>
			</form>
		</div>

		<hr/>
		<br/>

		<h4><?php echo esc_html__('Viewing Record of', 'inboundwp-lite') . ' : ' . $date_text; ?></h4>

		<div class="ibwp-report-data-wrap ibwp-bh-report-data-wrap ibwp-row ibwp-clearfix">
			<div class="ibwp-bh-title-report-tbl ibwp-medium-6 ibwp-columns">
				<table class="widefat striped ibwp-report-tbl">
					<thead>
						<tr>
							<th><?php esc_html_e('Title ID', 'inboundwp-lite'); ?></th>
							<th><?php esc_html_e('Title', 'inboundwp-lite'); ?></th>
							<th><?php esc_html_e('Clicks', 'inboundwp-lite'); ?></th>
							<th><?php esc_html_e('Views', 'inboundwp-lite'); ?></th>
							<th><?php esc_html_e('Action', 'inboundwp-lite'); ?></th>
						</tr>
					</thead>

					<tbody>
					<?php if( $title_clicks_data ) { ?>
						<?php foreach ( $title_clicks_data as $get_click_key => $get_click_val ) {

							$post_ids		= $get_click_val->post_id;
							$title_ids		= $get_click_val->title_id;
							$post_title		= $get_click_val->title;
							$title_clicks	= $get_click_val->title_click_sum;

							// Get post title wise views
							$title_views	= $wpdb->get_var( "SELECT COUNT( post_ids ) AS title_views_sum FROM `".IBWPL_BH_STATS_TBL."` WHERE 1=1 AND FIND_IN_SET('{$post_ids}:{$title_ids}', `title_ids`) {$date_range}" );
						?>
							<tr class="ibwp-bh-title-row-data">
								<td><?php echo $title_ids; ?></td>
								<td><?php echo $post_title; ?></td>
								<td><?php echo $title_clicks; ?></td>
								<td><?php echo $title_views; ?></td>
								<td><a href="#" class="ibwp-bh-chnage-history" data-title-id="<?php echo ibwpl_esc_attr( $title_ids ); ?>" data-post-id="<?php echo ibwpl_esc_attr( $post_ids ); ?>" data-nonce="<?php echo wp_create_nonce('ibwp-bh-title-history-' . $title_ids.$post_ids); ?>"><?php esc_html_e('Change History', 'inboundwp-lite'); ?></a></td>
							</tr>
						<?php
						}
					} else { ?>
						<tr>
							<td colspan="5"><?php _e('No Records Found.', 'inboundwp-lite'); ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div><!-- end .ibwp-bh-title-report-tbl -->

			<div class="ibwp-bh-title-stats-tbl ibwp-medium-6 ibwp-columns">
				<div class="ibwp-row">
					<div class="ibwp-medium-6 ibwp-columns">
						<div class="ibwp-report-box">
							<div class="ibwp-report-box-title"><?php _e('Total Clicks', 'inboundwp-lite'); ?></div>
							<div class="ibwp-report-box-inr">
								<span class="ibwp-report-box-no"><?php echo $total_clicks; ?></span>
								<span class="ibwp-report-box-desc"><?php echo $date_text; ?></span>
							</div>
						</div>
					</div>

					<div class="ibwp-medium-6 ibwp-columns">
						<div class="ibwp-report-box">
							<div class="ibwp-report-box-title"><?php _e('Total Views', 'inboundwp-lite'); ?></div>
							<div class="ibwp-report-box-inr">
								<span class="ibwp-report-box-no"><?php echo $total_views; ?></span>
								<span class="ibwp-report-box-desc"><?php echo $date_text; ?></span>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<p class="description"><?php _e('Note: Clicks can be differ from Views because Views are uniquely counted while Clicks are counted per browser session each day. The main part is how many Clicks you got for the title.', 'inboundwp-lite'); ?></p>
			</div><!-- end .ibwp-bh-title-stats-tbl -->
		</div><!-- end .ibwp-report-data-wrap -->

	</div><!-- end .inside -->
</div><!-- end .postbox -->

<!-- Title change history popup box -->
<div class="ibwp-popup-data-wrp ibwp-bh-chng-his-wrp ibwp-hide" data-flush="1">
	<div class="ibwp-popup-data-cnt">
		<div class="ibwp-popup-data-cnt-block ibwp-popup-bh-cnt-block">
			<div class="ibwp-popup-close ibwp-popup-close-wrp"><img src="<?php echo IBWPL_URL; ?>assets/images/close.png" alt="<?php esc_html_e('Close', 'inboundwp-lite'); ?>" title="<?php esc_html_e('Close', 'inboundwp-lite'); ?>" /></div>
			<div class="ibwp-popup-title ibwp-bh-popup-title"><?php esc_html_e('Post Title Change History', 'inboundwp-lite'); ?></div>

			<div class="ibwp-popup-body-wrp ibwp-bh-popup-body-wrp">
			</div><!-- end .ibwp-bh-popup-body-wrp -->

			<div class="ibwp-img-loader ibwp-bh-img-loader"><?php _e('Please Wait', 'inboundwp-lite'); ?> <span class="spinner"></span></div>

		</div><!-- end .ibwp-popup-data-cnt-block -->
	</div><!-- end .ibwp-popup-data-cnt -->
</div><!-- end .ibwp-bh-img-data-wrp -->
<div class="ibwp-popup-overlay ibwp-bh-popup-overlay"></div>