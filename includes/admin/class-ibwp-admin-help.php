<?php
/**
 * Add some content to the help tab
 *
 * @package InboundWP Lite
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class IBWPL_Admin_Help {

	function __construct() {
	
		// Action to add help tab
		add_action( 'current_screen', array( $this, 'ibwpl_add_help_tabs' ), 50 );
	}

	/**
	 * Add Contextual help tabs.
	 * @since 1.1
	 */
	public function ibwpl_add_help_tabs() {

		global $current_screen;

		$screen 		= isset( $current_screen->id ) ? $current_screen->id : '';
		$main_screens 	= ibwpl_main_screen_ids();

		// If not inbound main screen then return
		if( ! in_array($screen, $main_screens) ) {
			return;
		}

		// Taking some variables
		$tour_link = ibwpl_get_plugin_link('tour');

		$current_screen->add_help_tab( array(
			'id'        => 'ibwp_support_tab',
			'title'     => __( 'Help &amp; Support', 'inboundwp-lite' ),
			'content'   =>
				'<h2>' . __( 'Help &amp; Support', 'inboundwp-lite' ) . '</h2>' .
				'<p>' . sprintf(
					__( 'Should you need help understanding, using, or extending InboundWP Lite, <a href="%s" target="_blank">please read our documentation</a>. You will find all kinds of resources including snippets, tutorials and much more.', 'inboundwp-lite' ),
					'https://docs.wponlinesupport.com/category/inboundwp/?utm_source=ibwp&utm_medium=plugin&utm_campaign=help_tab'
				) . '</p>' .
				'<p>' . __( 'Before asking for help we recommend you to check plugin documentation.', 'inboundwp-lite' ) . '</p>' .
				'<p><a href="https://docs.wponlinesupport.com/category/inboundwp-lite/?utm_source=ibwp&utm_medium=plugin&utm_campaign=help_tab" target="_blank" class="button button-primary ibwp-icon-btn ibwp-btn"><i class="dashicons dashicons-admin-page"></i> ' . __( 'Plugin Documentation', 'inboundwp-lite' ) . '</a> <a href="'.$tour_link.'" class="button button-primary ibwp-icon-btn ibwp-btn"><i class="dashicons dashicons-lightbulb"></i> ' . __( 'Newbie? Take a Tour', 'inboundwp-lite' ) . '</a></p>'
		));

		$current_screen->add_help_tab( array(
			'id'        => 'ibwp_bugs_tab',
			'title'     => __( 'Found a bug?', 'inboundwp-lite' ),
			'content'   =>
				'<h2>' . __( 'Found a bug?', 'inboundwp-lite' ) . '</h2>' .
				'<p>' . sprintf( __( 'If you find a bug within InboundWP Lite you can create a ticket via <a href="%1$s" target="_blank">Support Portal</a>', 'inboundwp-lite' ), 'https://wordpress.org/support/plugin/inboundwp-lite/') . '</p>'
		));

		$current_screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'inboundwp-lite' ) . '</strong></p>' .
			'<p><a href="' . 'https://wordpress.org/plugins/inboundwp-lite/?utm_source=ibwp&utm_medium=plugin&utm_campaign=help_tab' . '" target="_blank">' . __( 'About InboundWP Lite', 'inboundwp-lite' ) . '</a></p>' .
			'<p><a href="'.$tour_link.'">' . __( 'Newbie? Take a Tour', 'inboundwp-lite' ) . '</a></p>' .
			'<p><a href="https://docs.wponlinesupport.com/category/inboundwp-lite/?utm_source=ibwp&utm_medium=plugin&utm_campaign=help_tab" target="_blank">' . __( 'Plugin Documentation', 'inboundwp-lite' ) . '</a></p>'
		);
	}
}

$ibwpl_admin_help = new IBWPL_Admin_Help();