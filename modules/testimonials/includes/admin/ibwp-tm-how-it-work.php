<?php
/**
 * Display all the shortcodes
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Action to add menu
add_action('admin_menu', 'ibwpl_tm_register_getting_started');

/**
 * Register plugin design page in admin menu
 *
 * @since 1.1
 */
function ibwpl_tm_register_getting_started() {
	add_submenu_page( 'edit.php?post_type='.IBWPL_TM_POST_TYPE, __('Getting Started - Testimonials - IBWP', 'inboundwp-lite'), __('Getting Started', 'inboundwp-lite'), 'edit_posts', 'wtwp-pro-designs', 'ibwpl_tm_designs_page' );
}

/**
 * Function to display plugin design HTML
 *
 * @since 1.1
 */
function ibwpl_tm_designs_page() {

	$tm_feed_tabs	= ibwpl_tm_help_tabs();
	$active_tab		= isset($_GET['tab']) ? $_GET['tab'] : 'how-it-work';
?>

	<div class="wrap ibwp-tm-wrap">

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($tm_feed_tabs as $tab_key => $tab_val) {
				$tab_name	= $tab_val['name'];
				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array( 'post_type' => IBWPL_TM_POST_TYPE, 'page' => 'wtwp-pro-designs', 'tab' => $tab_key), admin_url('edit.php') );
			?>

			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo esc_url($tab_link); ?>"><?php echo $tab_name; ?></a>

			<?php } ?>
		</h2>

		<div class="ibwp-tm-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'how-it-work' ) {
				ibwpl_tm_howitwork_page();
			}
		?>
		</div><!-- end .ibwp-tm-tab-cnt-wrp -->

	</div><!-- end .ibwp-tm-wrap -->

<?php
}

/**
 * Function to get plugin feed tabs
 *
 * @since 1.1
 */
function ibwpl_tm_help_tabs() {
	$tm_feed_tabs = array(
						'how-it-work' => array(
											'name' => esc_html__( 'How It Works', 'inboundwp-lite' ),
										),
					);
	return $tm_feed_tabs;
}

/**
 * Function to get 'How It Works' HTML
 *
 * @since 1.1
 */
function ibwpl_tm_howitwork_page() { ?>

	<style type="text/css">
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.ibwp-tm-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
	</style>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<!--How it workd HTML -->
			<div id="post-body-content">
				<div class="meta-box-sortables">
					<div class="postbox">

						<h3 class="hndle">
							<span><?php _e( 'How It Works - Display Shortcodes & Designs', 'inboundwp-lite' ); ?></span>
						</h3>

						<div class="inside">
							<table class="form-table">
								<tbody>
									<tr>
										<th>
											<label><?php _e('Getting Started', 'inboundwp-lite'); ?></label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1: This plugin create a Testimonials - IBWP tab in WordPress menu section.', 'inboundwp-lite'); ?></li>
												<li><?php _e('Step-2: Go to Testimonials - IBWP > Add New Testimonial.', 'inboundwp-lite'); ?></li>
												<li><?php _e('Step-3: Add Testimonial title,  Testimonial details, Testimonial image and etc.', 'inboundwp-lite'); ?></li>
												<li><?php _e('Step-4: Now, paste below shortcode  as per your need in any page and your testimonial is ready!!!', 'inboundwp-lite'); ?></li>
											</ul>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('All Shortcodes', 'inboundwp-lite'); ?></label>
										</th>
										<td>
											<div class="ibwp-code-tag-wrap">
												<code class="ibwp-copy-clipboard">[sp_testimonials]</code> – <?php _e('Display in testimonial grid with 4 designs', 'inboundwp-lite'); ?> <br />
												<code class="ibwp-copy-clipboard">[sp_testimonials_slider]</code> – <?php _e('Display in testimonial slider with 4 designs', 'inboundwp-lite'); ?>
											</div>
										</td>
									</tr>
									<tr>
										<th>
											<label><?php _e('Widget', 'inboundwp-lite'); ?>:</label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1. Go to Appearance -> Widget.', 'inboundwp-lite'); ?></li>
												<li><?php _e('Step-2. Use WP Testimonials Slider to display Testimonials in widget area with slider', 'inboundwp-lite'); ?></li>
											</ul>												
										</td>
									</tr>	
								</tbody>
							</table>
						</div><!-- .inside -->
					</div><!-- #general -->
				</div><!-- .meta-box-sortables -->
			</div><!-- #post-body-content -->

			<!--Upgrad to Pro HTML -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">

					<div class="postbox wpos-pro-box">
						<h3 class="hndle">
							<span><?php _e( 'Need Support?', 'inboundwp-lite' ); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Check plugin document for shortcode parameters and demo for designs.', 'inboundwp-lite'); ?></p>
							<a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://docs.wponlinesupport.com/wp-testimonials-with-rotator-widget-pro/?utm_source=ibwp_pro&utm_medium=hp&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Documentation', 'inboundwp-lite'); ?></a>
							<p><a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://demo.wponlinesupport.com/prodemo/pro-testimonials-with-rotator-widget/?utm_source=ibwp_pro&utm_medium=hp&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Demo for Designs', 'inboundwp-lite'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->

					<div class="postbox wpos-pro-box">
						<h3 class="hndle">
							<span><?php _e('Need PRO Support?', 'inboundwp-lite'); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Hire our experts for any WordPress task.', 'inboundwp-lite'); ?></p>
							<p><a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://www.wponlinesupport.com/wordpress-support/?utm_source=testimonial_pro&utm_medium=hp&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Know More', 'inboundwp-lite'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->
				</div><!-- .meta-box-sortables -->
			</div><!-- #post-container-1 -->

		</div><!-- #post-body -->
	</div><!-- #poststuff -->
<?php }