<?php
/**
 * Popup Report. Popup Click, Impression
 * 
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some data
$date_options = ibwpl_report_date_options();
?>

<div class="wrap ibwp-mp-popup-report-wrp ibwp-pro-feature">

	<h2><?php echo __( 'Marketing Popup Reports ', 'inboundwp-lite' ) . ibwpl_upgrade_pro_link(); ?></h2>

	<div class="metabox-holder">
		<div class="post-box-container">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox ibwp-no-toggle">

					<h3 class="hndle">
						<span><?php _e( 'Marketing Popup Report', 'inboundwp-lite' ); ?></span>
					</h3>

					<div class="inside ibwp-report-wrp ibwp-cnt-wrap">
						<div class="ibwp-report-form-wrp ibwp-mp-report-form-wrp">
							<form id="ibwp-mp-post-report" class="ibwp-report-form ibwp-mp-report-form" method="get" action="">

								<input type="hidden" name="post_type" value="<?php echo IBWPL_MP_POST_TYPE; ?>" />
								<input type="hidden" name="page" value="ibwp-mp-reports" />

								<select name="" class="ibwp-select ibwp-mp-sett-post-type" disabled>
									<option><?php esc_html_e('Welcome Popup', 'inboundwp-lite'); ?></option>
								</select>

								<select name="" class="ibwp-select" disabled>
									<?php foreach ( $date_options as $date_key => $date_val ) { ?>
										<option value=""><?php echo $date_val; ?></option>
									<?php } ?>
								</select>
								<button class="button button-secondary ibwp-btn ibwp-mp-filter-btn" type="submit" disabled ><?php esc_html_e('Filter','inboundwp-lite'); ?></button>
							</form>
						</div>

						<hr/>
						<br/>

						<div class="ibwp-report-data-wrap ibwp-mp-report-data-wrap ibwp-row ibwp-clearfix">
							<div class="ibwp-mp-stats-row ibwp-medium-6 ibwp-columns">
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
							</div><!-- end .ibwp-mp-stats-row -->

							<div class="ibwp-mp-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('Viewing Total Records', 'inboundwp-lite'); ?></h4>
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
							</div><!-- end .ibwp-mp-stats-row -->
						</div><!-- end .ibwp-report-data-wrap -->

						<br/>
						<hr/>

						<!-- Start - Reference Page URL Report -->
						<div class="ibwp-report-data-wrap ibwp-mp-refer-data-wrap ibwp-row ibwp-clearfix">

							<h3 class="ibwp-columns"><?php esc_html_e('Top Reference Page URL (Collect Email Popup Only)', 'inboundwp-lite'); ?></h3>

							<div class="ibwp-mp-stats-row ibwp-medium-6 ibwp-columns">
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
							</div><!-- end .ibwp-mp-stats-row -->

							<div class="ibwp-mp-stats-row ibwp-medium-6 ibwp-columns">
								<h4><?php echo esc_html__('Viewing Total Records', 'inboundwp-lite'); ?></h4>
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
							</div><!-- end .ibwp-mp-stats-row -->
						</div><!-- end .ibwp-report-data-wrap -->
						<!-- End - Reference Page URL Report -->

					</div><!-- end .inside -->

				</div><!-- end .postbox -->
			</div><!-- end .meta-box-sortables -->
		</div><!-- end .post-box-container -->
	</div><!-- end .metabox-holder -->
</div><!-- end .ibwp-mp-popup-report-wrp -->