<?php
/**
 * Plugin Premium Offer Page
 *
 * @package InboundWP Lite
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="wrap">

	<h2><?php _e( 'InboundWP - Features', 'inboundwp-lite' ); ?></h2><br />

	<div class="ibwp-notice">
		<a href="https://www.wponlinesupport.com/wp-plugin/inboundwp-marketing-plugin/?ref=WposPratik" target="_blank">Upgrade to PRO</a> a plugin within a minute and unlock many features now!!!
	</div>

	<style>
		.ibwp-notice{padding: 10px; color: #3c763d; background-color: #dff0d8; border:1px solid #d6e9c6; margin: 0 0 20px 0;}
		.wpos-plugin-pricing-table thead th h2{font-weight: 400; font-size: 2.4em; line-height:normal; margin:0px; color: #2ECC71;}
		.wpos-plugin-pricing-table thead th h2 + p{font-size: 1.25em; line-height: 1.4; color: #999; margin:5px 0 5px 0;}

		table.wpos-plugin-pricing-table{width:90%; text-align: left; border-spacing: 0; border-collapse: collapse; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;}
		.wpos-plugin-pricing-table th, .wpos-plugin-pricing-table td{font-size:14px; line-height:normal; color:#444; vertical-align:middle; padding:12px;}

		.wpos-plugin-pricing-table colgroup:nth-child(1) { width: 31%; border: 0 none; }
		.wpos-plugin-pricing-table colgroup:nth-child(2) { width: 22%; border: 1px solid #ccc; }
		.wpos-plugin-pricing-table colgroup:nth-child(3) { width: 25%; border: 10px solid #2ECC71; }

		/* Tablehead */
		.wpos-plugin-pricing-table thead th {background-color: #fff; background:linear-gradient(to bottom, #ffffff 0%, #ffffff 100%); text-align: center; position: relative; border-bottom: 1px solid #ccc; padding: 1em 0 1em; font-weight:400; color:#999;}
		.wpos-plugin-pricing-table thead th:nth-child(1) {background: transparent;}
		.wpos-plugin-pricing-table thead th:nth-child(3) {padding:1em 0 3.5em 0;}		
		.wpos-plugin-pricing-table thead th:nth-child(3) p {color: #000;}
		.wpos-plugin-pricing-table thead th p.promo {font-size: 14px; color: #fff; position: absolute; bottom:0; left: -17px; z-index: 1000; width: 100%; margin: 0; padding: .625em 17px .75em; background-color: #ca4a1f; box-shadow: 0 2px 4px rgba(0,0,0,.25); border-bottom: 1px solid #ca4a1f;}
		.wpos-plugin-pricing-table thead th p.promo:before {content: ""; position: absolute; display: block; width: 0px; height: 0px; border-style: solid; border-width: 0 7px 7px 0; border-color: transparent #900 transparent transparent; bottom: -7px; left: 0;}
		.wpos-plugin-pricing-table thead th p.promo:after {content: ""; position: absolute; display: block; width: 0px; height: 0px; border-style: solid; border-width: 7px 7px 0 0; border-color: #900 transparent transparent transparent; bottom: -7px; right: 0;}

		/* Tablebody */
		.wpos-plugin-pricing-table tbody th{background: #fff; border-left: 1px solid #ccc; font-weight: 600;}
		.wpos-plugin-pricing-table tbody th span{font-weight: normal; font-size: 87.5%; color: #999; display: block;}

		.wpos-plugin-pricing-table tbody td{background: #fff; text-align: center;}
		.wpos-plugin-pricing-table tbody td .dashicons{height: auto; width: auto; font-size:30px;}
		.wpos-plugin-pricing-table tbody td .dashicons-no-alt{color: #ca4a1f;}
		.wpos-plugin-pricing-table tbody td .dashicons-yes{color: #2ECC71;}
		.wpos-plugin-pricing-table tbody td .ibwp-dashicons-icon{font-size: 20px; color: #666;}

		.wpos-plugin-pricing-table tbody tr:nth-child(even) th,
		.wpos-plugin-pricing-table tbody tr:nth-child(even) td { background: #f5f5f5; border: 1px solid #ccc; border-width: 1px 0 1px 1px; }
		.wpos-plugin-pricing-table tbody tr:last-child td {border-bottom: 0 none;}

		/* Table Footer */
		.wpos-plugin-pricing-table tfoot th, .wpos-plugin-pricing-table tfoot td{text-align: center; border-top: 1px solid #ccc;}
		.wpos-plugin-pricing-table tfoot a{font-weight: 600; color: #fff; text-decoration: none; text-transform: uppercase; display: inline-block; padding: 1em 2em; background: #59c7fb; border-radius: .2em;}
	</style>

	<table class="wpos-plugin-pricing-table">
		<colgroup></colgroup>
		<colgroup></colgroup>
		<colgroup></colgroup>	
		<thead>
			<tr>
				<th></th>
				<th>
					<h2>Free</h2>
					<p>$0 USD</p>
				</th>
				<th>
					<h2>Premium</h2>
					<p>Gain access to <strong>InboundWP</strong></p>
					<p class="promo">Our most valuable package!</p>
				</th>	    		
			</tr>
		</thead>

		<tfoot>
			<tr>
				<th></th>
				<td></td>
				<td>
					<a href="https://www.wponlinesupport.com/wp-plugin/inboundwp-marketing-plugin/?ref=WposPratik" target="_blank">Upgrade to PRO</a>
				</td>
			</tr>
		</tfoot>

		<tbody>
			<tr>
				<th>Plugins (Modules) <span>Number of Plugins</span></th>
				<td>Contains 7 Plugins</td>
				<td>Contains 8 Plugins (<a target="_blank" href="https://www.wponlinesupport.com/wp-plugin/inboundwp-marketing-plugin/?ref=WposPratik">Know More</a>)</td>
			</tr>
			<tr>
				<th>Better Heading</th>
				<td>Limited Features</td>
				<td>Advanced Features <i class="dashicons dashicons-info ibwp-dashicons-icon ibwp-dashicons-info ibwp-tooltip" data-tooltip-content="#better_heading-tooltip-content"></i></td>
			</tr>
			<tr>
				<th>Deal Countdown Timer</th>
				<td>Limited Features</td>
				<td>Advanced Features <i class="dashicons dashicons-info ibwp-dashicons-icon ibwp-dashicons-info ibwp-tooltip" data-tooltip-content="#countdown_timer-tooltip-content"></i></td>
			</tr>
			<tr>
				<th>Marketing Popup</th>
				<td>Limited Features</td>
				<td>Advanced Features <i class="dashicons dashicons-info ibwp-dashicons-icon ibwp-dashicons-info ibwp-tooltip" data-tooltip-content="#marketing_popup-tooltip-content"></i></td>
			</tr>
			<tr>
				<th>Social Proof</th>
				<td>Limited Features</td>
				<td>Advanced Features <i class="dashicons dashicons-info ibwp-dashicons-icon ibwp-dashicons-info ibwp-tooltip" data-tooltip-content="#social_proof-tooltip-content"></i></td>
			</tr>
			<tr>
				<th>Spin Wheel</th>
				<td>Limited Features</td>
				<td>Advanced Features <i class="dashicons dashicons-info ibwp-dashicons-icon ibwp-dashicons-info ibwp-tooltip" data-tooltip-content="#spin_wheel-tooltip-content"></i></td>
			</tr>
			<tr>
				<th>Testimonial</th>
				<td>Limited Features</td>
				<td>Advanced Features <i class="dashicons dashicons-info ibwp-dashicons-icon ibwp-dashicons-info ibwp-tooltip" data-tooltip-content="#testimonial-tooltip-content"></i></td>
			</tr>
			<tr>
				<th>WhatsApp Chat Support</th>
				<td>Limited Features</td>
				<td>Advanced Features <i class="dashicons dashicons-info ibwp-dashicons-icon ibwp-dashicons-info ibwp-tooltip" data-tooltip-content="#whatsapp-tooltip-content"></i></td>
			</tr>
			<tr>
				<th>Custom CSS and JS</th>
				<td><i class="dashicons dashicons-no-alt"></i></td>
				<td><i class="dashicons dashicons-yes"></i></td>
			</tr>
		</tbody>
	</table>

	<!-- TootlTip Content -->
	<div class="ibwp-tooltip-content ibwp-hide">
		<div id="better_heading-tooltip-content">
			<div class="ibwp-tooltip-title"><h3>Better Heading</h3></div>
			<ul class="ibwp-info-features">
				<li>Default post type & Custom post types support.</li>
				<li>Flush Status (Post wise flush click & impression).</li>
			</ul>
		</div><!-- end #better_heading-tooltip-content -->

		<div id="countdown_timer-tooltip-content">
			<div class="ibwp-tooltip-title"><h3>Deal Countdown Timer</h3></div>
			<ul class="ibwp-info-features">
				<li>WooCommerce Sale Product slider with timer.</li>
				<li>More designs.</li>
			</ul>
		</div><!-- end #countdown_timer-tooltip-content -->

		<div id="marketing_popup-tooltip-content">
			<div class="ibwp-tooltip-title"><h3>Marketing Popup</h3></div>
			<ul class="ibwp-info-features">
				<li>Bar, Push Notification popup.</li>
				<li>Popup Disappear, Hide Overlay.</li>
				<li>Popup Appear (Page load, exit intent, html element, etc).</li>
				<li>Fullscreen Popup, Popup Width, Popup Height, Popup Position.</li>
				<li>Do not Store Impression or Clicks Data.</li>
				<li>Do not Store Form Submission Data</li>
				<li>More designs, design related settings.</li>
				<li>Show For, Popup Schedule.</li>
				<li>Mailchimp Integration.</li>
				<li>Popup report.</li>
			</ul>
		</div><!-- end #marketing_popup-tooltip-content -->

		<div id="social_proof-tooltip-content">
			<div class="ibwp-tooltip-title"><h3>Social Proof</h3></div>
			<ul class="ibwp-info-features">
				<li>More source type (WordPress, WordPress Author, CSV).</li>
				<li>Display Notification, Max Per Page.</li>
				<li>Minimum Rating, Products Include, Products Exclude.</li>
				<li>Show For, Cache Duration.</li>
				<li>Tracking Settings.</li>
				<li>Designs Settings.</li>
			</ul>
		</div><!-- end #social_proof-tooltip-content -->

		<div id="spin_wheel-tooltip-content">
			<div class="ibwp-tooltip-title"><h3>Spin Wheel</h3></div>
			<ul class="ibwp-info-features">
				<li>Popup Appear (Page load, exit intent, html element, etc).</li>
				<li>Popup Disappear, Hide Overlay, More Segments.</li>
				<li>More Designs, Wheel Position, Fullscreen Wheel.</li>
				<li>Designs related settings, Do not Show Form Fields.</li>
				<li>Do not Store Impression or Clicks Data.</li>
				<li>Do not Store Form Submission Data</li>
				<li>Show For, Wheel Restriction, Spin Wheel Schedule.</li>
				<li>Mailchimp Integration.</li>
				<li>Spin Wheel report.</li>
			</ul>
		</div><!-- end "spin_wheel-tooltip-content -->

		<div id="testimonial-tooltip-content">
			<div class="ibwp-tooltip-title"><h3>Testimonial</h3></div>
			<ul class="ibwp-info-features">
				<li>Front-end testimonial submission form shortcode.</li>
				<li>Form Fields Settings.</li>
				<li>Email Notification Settings.</li>
				<li>More Parameters for Grid & Slider shortcode.</li>
			</ul>
		</div><!-- end "testimonial-tooltip-content -->

		<div id="whatsapp-tooltip-content">
			<div class="ibwp-tooltip-title"><h3>WhatsApp Chat Supprot</h3></div>
			<ul class="ibwp-info-features">
				<li>Agent Shortcode.</li>
				<li>Design Settings.</li>
				<li>Display Multiple Agents.</li>
				<li>Custom Availability, Category Supports.</li>
				<li>WooCommerce Settings.</li>
				<li>Hide on Locations, Agent Order By, Agent Order, Departments.</li>
			</ul>
		</div><!-- end "whatsapp-tooltip-content -->
	</div>
</div><!-- end .wrap -->