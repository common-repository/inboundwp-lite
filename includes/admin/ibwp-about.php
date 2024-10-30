<?php
/**
 * About InboundWP
 *
 * Handles the about us page HTML
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$ibwp_tabs = apply_filters('ibwpl_about_tabs', array(
					'ibwp_welcome' 	=> __("About", 'inboundwp-lite'),
					'ibwp_update' 	=> __("What's New", 'inboundwp-lite'),
				));
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'ibwp_welcome';
?>

<div class="wrap about-wrap ibwp-about-wrap">

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script><!-- FB Script -->

	<script>window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
	    t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);

	  t._e = [];
	  t.ready = function(f) {
	    t._e.push(f);
	  };

	  return t;
	}(document, "script", "twitter-wjs"));</script><!-- Twitter Script -->

	<h1><?php echo __('Welcome to', 'inboundwp-lite').' InboundWP Lite '.IBWPL_VERSION; ?></h1>

	<div class="about-text"><?php echo sprintf( __('Congratulations! You are about to use most powerful plugin for %s - InboundWP Lite Marketing Pack by %s.', 'inboundwp-lite'), 'WordPress', 'WP OnlineSupport'); ?></div>
	<div class="wp-badge ibwp-page-logo"><?php echo __('Version', 'inboundwp-lite') .' '. IBWPL_VERSION; ?></div>

	<a href="https://twitter.com/share" class="twitter-share-button" data-via="wordpress_wpos" data-text="Take your #WordPress site to the next level with InboundWP Lite" data-url="https://www.wponlinesupport.com/" data-size="large">Tweet</a>	
	<div style="vertical-align:top;" class="fb-like" data-href="https://www.facebook.com/wponlinesupport/" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>

	<?php if( ! empty( $ibwp_tabs ) ) { ?>
	<h2 class="nav-tab-wrapper">
		<?php foreach ($ibwp_tabs as $tab_key => $tab_val) { 

			if( empty($tab_key) ) {
				continue;
			}

			$active_tab_cls	= ($active_tab == $tab_key) ? 'nav-tab-active' : '';
			$tab_link 		= add_query_arg( array( 'page' => 'ibwp-about', 'tab' => $tab_key ), admin_url('admin.php') );
		?>
			<a class="nav-tab <?php echo $active_tab_cls; ?>" href="<?php echo $tab_link; ?>"><?php echo $tab_val; ?></a>
		<?php } ?>
	</h2>
	<?php } ?>

	<div class="ibwp-cnt-wrap ibwp-nav-tab-cnt-wrap ibwp-clearfix">
		
		<?php if( $active_tab == 'ibwp_welcome' ) { ?>

		<div class="ibwp-welcome-tab-cnt ibwp-clearfix">
			<div class="ibwp-intro-image ibwp-columns ibwp-medium-5">
				<img src="<?php echo IBWPL_URL; ?>assets/images/inboundWP-logo.png" alt="InboundWP" />
			</div>
			<div class="ibwp-columns ibwp-medium-7">
				<h3><?php _e('InboundWP Lite Marketing Pack', 'inboundwp-lite'); ?></h3>
				<p><?php _e('InboundWP Lite marketing plugin is about creating valuable experiences that have a positive impact on people and your business. How do you do that? You attract prospects and customers to your website and blog through relevant and helpful content. Once they arrive, you engage with them using conversational tools.', 'inboundwp-lite'); ?></p>
				<p><?php _e('Enable / Disable feature of particular module so enable only those modules which requires to your website so others will not disturb you'); ?> :)</p>
				<p><?php _e('Our module library is growing every week so you can get all updates easily.', 'inboundwp-lite'); ?></p>
			</div>

			<div class="ibwp-columns ibwp-medium-12">
				<hr/>
				<h2><?php _e('Exciting Modules - Filled With Power', 'inboundwp-lite'); ?></h2>
			</div>

			<div class="ibwp-icolumns-wrap ibwp-about-module-wrap ibwp-clearfix clear">
				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('Marketing PopUp', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-feedback"></i>
					</div>
				</div>

				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('WhatsApp Chat Support', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-format-chat"></i>
					</div>
				</div>

				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('Spin Wheel', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-sos"></i>
					</div>
				</div>

				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('Social Proof', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-image-filter"></i>
					</div>
				</div>

				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('Better Heading', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-admin-post"></i>
					</div>
				</div>

				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('Testimonial', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-format-quote"></i>
					</div>
				</div>

				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('Deal Countdown Timer', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-clock"></i>
					</div>
				</div>

				<div class="ibwp-icolumns ibwp-medium-3 ibwp-about-module ibwp-pro-feature">
					<div class="ibwp-about-module-inr">
						<div class="ibwp-about-module-title"><span><?php _e('Custom CSS and JS', 'inboundwp-lite'); ?></span></div>
						<i class="ibwp-about-module-icon dashicons dashicons-editor-code"></i>
					</div>
					<span class="description"><?php echo ibwpl_upgrade_pro_link(); ?></span>
				</div>
			</div><!-- end .ibwp-icolumns-wrap -->
		</div><!-- end .ibwp-welcome-tab-cnt -->

		<?php } elseif ( $active_tab == 'ibwp_update' ) { ?>
			
			<div class="ibwp-update-tab-cnt ibwp-clearfix">
				<iframe class="ibwp-changelog-iframe" src="https://www.wponlinesupport.com/readmefile/inboundWP/changelog-lite.html" allowtransparency="true" frameborder="0"></iframe>
			</div>

		<?php } else {
			do_action( 'ibwpl_about_tabs_cnt_'.$active_tab, $active_tab );
		} ?>
	</div><!-- end .ibwp-nav-tab-cnt-wrap -->

</div><!-- ibwp-about-wrap -->