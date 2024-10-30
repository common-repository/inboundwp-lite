<?php
/**
 * Social Proof Preview Metabox
 * 
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

?>
<div class="ibwp-sp-nf-preview-sett ibwp-cnt-wrap">
	<div class="ibwp-preview-btn-wrp">
		<button type="button" class="button button-large button-primary ibwp-btn ibwp-btn-large ibwp-module-preview-btn ibwp-sp-nf-preview-btn ibwp-show-popup-modal" data-preview="1"><?php esc_html_e('Preview Social Proof', 'inboundwp-lite'); ?></button>
	</div>
</div>