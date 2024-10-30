<?php
/**
 * Spin Wheel Report. Spin Wheel Click, Impression
 * 
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $wpdb;

// Taking some data
$date_options		= ibwpl_report_date_options();
$wheel_post_data	= ibwpl_get_posts( IBWPL_SPW_POST_TYPE );
?>

<div class="wrap ibwp-spw-wheel-report-wrp ibwp-pro-feature">

	<h2><?php echo __( 'Spin Wheel Reports ', 'inboundwp-lite' ) . ibwpl_upgrade_pro_link(); ?></h2>

	<div class="metabox-holder">
		<div class="post-box-container">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox ibwp-no-toggle">

					<h3 class="hndle">
						<span><?php esc_html_e( 'Spin Wheel Report', 'inboundwp-lite' ); ?></span>
					</h3>

					<div class="inside ibwp-report-wrp ibwp-cnt-wrap">
						<div class="ibwp-report-form-wrp ibwp-spw-report-form-wrp">
							<form id="ibwp-spw-post-report" class="ibwp-report-form ibwp-spw-report-form" method="get" action="">

								<input type="hidden" name="post_type" value="<?php echo IBWPL_SPW_POST_TYPE; ?>" />
								<input type="hidden" name="page" value="ibwp-spw-reports" />

								<select name="" class="ibwp-select ibwp-spw-sett-post-type" disabled>
									<?php if( ! empty( $wheel_post_data ) ) {
										foreach ( $wheel_post_data as $wheel_post_key => $wheel_post_val ) { ?>
											<option value=""><?php echo $wheel_post_val->post_title; ?></option>
									<?php }
									} ?>
								</select>

								<select name="" class="ibwp-select ibwp-date-range-filter ibwp-spw-date-filter" disabled>
									<?php foreach ( $date_options as $date_key => $date_val ) { ?>
										<option value=""><?php echo $date_val; ?></option>
									<?php } ?>
								</select>

								<button class="button button-secondary ibwp-btn ibwp-spw-filter-btn" type="submit" disabled><?php esc_html_e('Filter','inboundwp-lite'); ?></button>
							</form>
						</div>

						<hr/>
						<br/>

						<div class="ibwp-report-data-wrap ibwp-spw-report-data-wrap ibwp-row ibwp-clearfix">
							<div class="ibwp-spw-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('Viewing Record of : Today', 'inboundwp-lite'); ?></h4>
								<div class="ibwp-row">
									<div class="ibwp-medium-6 ibwp-columns">
										<div class="ibwp-report-box">
											<div class="ibwp-report-box-title"><?php _e('Clicks', 'inboundwp-lite'); ?></div>
											<div class="ibwp-report-box-inr">
												<span class="ibwp-report-box-no">0</span>
												<span class="ibwp-report-box-desc"><?php esc_html_e('Today', 'inboundwp-lite'); ?></span>
											</div>
										</div>
									</div>

									<div class="ibwp-medium-6 ibwp-columns">
										<div class="ibwp-report-box">
											<div class="ibwp-report-box-title"><?php _e('Views', 'inboundwp-lite'); ?></div>
											<div class="ibwp-report-box-inr">
												<span class="ibwp-report-box-no">0</span>
												<span class="ibwp-report-box-desc"><?php esc_html_e('Today', 'inboundwp-lite'); ?></span>
											</div>
										</div>
									</div>
								</div>
							</div><!-- end .ibwp-spw-stats-row -->

							<div class="ibwp-spw-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('All Time Records', 'inboundwp-lite'); ?></h4>
								<div class="ibwp-row">
									<div class="ibwp-medium-6 ibwp-columns">
										<div class="ibwp-report-box">
											<div class="ibwp-report-box-title"><?php _e('Total Clicks', 'inboundwp-lite'); ?></div>
											<div class="ibwp-report-box-inr">
												<span class="ibwp-report-box-no">0</span>
												<span class="ibwp-report-box-desc"><?php esc_html_e('Total', 'inboundwp-lite'); ?></span>
											</div>
										</div>
									</div>
									<div class="ibwp-medium-6 ibwp-columns">
										<div class="ibwp-report-box">
											<div class="ibwp-report-box-title"><?php _e('Total Views', 'inboundwp-lite'); ?></div>
											<div class="ibwp-report-box-inr">
												<span class="ibwp-report-box-no">0</span>
												<span class="ibwp-report-box-desc"><?php esc_html_e('Total', 'inboundwp-lite'); ?></span>
											</div>
										</div>
									</div>
								</div>
							</div><!-- end .ibwp-spw-stats-row -->
						</div><!-- end .ibwp-report-data-wrap -->

						<br/><br/>
						<div class="ibwp-sub-sett-title">
							<h3 class="ibwp-no-margin"><i class="dashicons dashicons-chart-bar"></i> <?php esc_html_e('Form Submission Report', 'inboundwp-lite'); ?></h3>
						</div>

						<!-- Start - Wheel Segment Report -->
						<div class="ibwp-report-data-wrap ibwp-spw-segment-wrap ibwp-row ibwp-clearfix">

							<h3 class="ibwp-report-sheading"><?php esc_html_e('Wheel Segments', 'inboundwp-lite'); ?></h3>

							<div class="ibwp-spw-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('Viewing Record of : Today', 'inboundwp-lite'); ?></h4>
								<div class="ibwp-row">
									<div class="ibwp-medium-12 ibwp-columns">
										<table class="widefat striped ibwp-report-tbl">
											<thead>
												<tr>
													<th><?php esc_html_e('ID', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Label', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Type', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Count', 'inboundwp-lite'); ?></th>
												</tr>
											</thead>

											<tbody>
												<tr>
													<td colspan="4"><?php esc_html_e('No records found.', 'inboundwp-lite'); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div><!-- end .ibwp-spw-stats-row -->

							<div class="ibwp-spw-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('All Time Records', 'inboundwp-lite'); ?></h4>
								<div class="ibwp-row">
									<div class="ibwp-medium-12 ibwp-columns">
										<table class="widefat striped ibwp-report-tbl">
											<thead>
												<tr>
													<th><?php esc_html_e('ID', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Label', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Type', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Count', 'inboundwp-lite'); ?></th>
												</tr>
											</thead>

											<tbody>
												<tr>
													<td colspan="4"><?php esc_html_e('No records found.', 'inboundwp-lite'); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div><!-- end .ibwp-spw-stats-row -->
						</div><!-- end .ibwp-report-data-wrap -->
						<!-- End - Wheel Segment Report -->

						<br/>

						<!-- Start - Reference Page URL Report -->
						<div class="ibwp-report-data-wrap ibwp-spw-refer-data-wrap ibwp-row ibwp-clearfix">

							<h3 class="ibwp-report-sheading"><?php esc_html_e('Top Reference Page URL', 'inboundwp-lite'); ?></h3>

							<div class="ibwp-spw-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('Viewing Record of : Today', 'inboundwp-lite'); ?></h4>
								<div class="ibwp-row">
									<div class="ibwp-medium-12 ibwp-columns">
										<table class="widefat striped ibwp-report-tbl">
											<thead>
												<tr>
													<th><?php esc_html_e('Reference Page URL', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Clicks', 'inboundwp-lite'); ?></th>
												</tr>
											</thead>

											<tbody>
												<tr>
													<td colspan="2"><?php esc_html_e('No records found.', 'inboundwp-lite'); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div><!-- end .ibwp-spw-stats-row -->

							<div class="ibwp-spw-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('All Time Records', 'inboundwp-lite'); ?></h4>
								<div class="ibwp-row">
									<div class="ibwp-medium-12 ibwp-columns">
										<table class="widefat striped ibwp-report-tbl">
											<thead>
												<tr>
													<th><?php esc_html_e('Reference Page URL', 'inboundwp-lite'); ?></th>
													<th><?php esc_html_e('Clicks', 'inboundwp-lite'); ?></th>
												</tr>
											</thead>

											<tbody>
												<tr>
													<td colspan="2"><?php esc_html_e('No records found.', 'inboundwp-lite'); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div><!-- end .ibwp-spw-stats-row -->
						</div><!-- end .ibwp-report-data-wrap -->
						<!-- End - Reference Page URL Report -->

					</div><!-- end .inside -->

				</div><!-- end .postbox -->
			</div><!-- end .meta-box-sortables -->
		</div><!-- end .post-box-container -->
	</div><!-- end .metabox-holder -->
</div><!-- end .ibwp-spw-wheel-report-wrp -->