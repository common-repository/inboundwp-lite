<?php
/**
 * Template for Chatbox Header
 *
 * This template can be overridden by copying it to yourtheme/inboundwp-lite/whatsapp-chat-support/chatbox/header.php
 *
 * @package InboundWP Lite
 * @subpackage WhatsApp Chat Support
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="ibwp-wrap ibwp-wtcs-chatbox-wrp ibwp-wtcs-toggle-wrap ibwp-wtcs-<?php echo $btn_position .' ibwp-wtcs-'. $btn_style; ?>">
	<div class="ibwp-wrap ibwp-wtcs-btn-popup">
		<?php if( ! empty( $toggle_text) ) { ?>
		<div class="ibwp-wtcs-ctbx-tgl-txt"><?php echo $toggle_text; ?></div>
		<?php } ?>
		<div class="ibwp-wtcs-ctbx-tgl-icon"></div>
	</div>

	<div class="ibwp-wtcs-chatbox">
		<div class="ibwp-wtcs-ctbx-heading">
			<?php if( ! empty( $main_title ) ){ ?>
			<div class="ibwp-wtcs-ctbx-title"><?php echo $main_title; ?></div>
			<?php } ?>

			<?php if( ! empty( $sub_title ) ) { ?>
			<div class="ibwp-wtcs-ctbx-stitle"><?php echo $sub_title; ?></div>
			<?php } ?>
		</div>

		<div class="ibwp-wtcs-ctbx-cnt-wrp ibwp-wtcs-filtr-js">
			<?php if( ! empty( $notice ) ) { ?>
			<div class="ibwp-wtcs-ctbx-notice"><?php echo $notice; ?></div>
			<?php } ?>
			<div class="ibwp-wtcs-ctbx-cnt-inr ibwp-wtcs-filtr-cnt-js">