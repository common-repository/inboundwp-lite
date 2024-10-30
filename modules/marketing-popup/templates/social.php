<?php
/**
* Template for Popup Social Design
*
* This template can be overridden by copying it to yourtheme/inboundwp-lite/marketing-popup/social.php
*
* @package InboundWP Lite
* @subpackage Marketing Popup
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( empty( $social_data ) ) {
	return;
}
?>
<div class="ibwp-mp-social-wrap">
	<?php foreach ( $social_data as $social_data_key => $social_arr ) {
		if( $social_type == 'text' ) { ?>
			<a class="ibwp-mp-social-icon ibwp-mp-<?php echo $social_arr['name']; ?>-icon" href="<?php echo esc_url( $social_arr['link'] ); ?>" target="_blank"><span class="ibwp-mp-<?php echo $social_arr['name']; ?>-text"><?php echo $social_arr['title']; ?></span></a>
		<?php } elseif ( $social_type == 'icon-text' ) { ?>
			<a class="ibwp-mp-social-icon ibwp-mp-<?php echo $social_arr['name']; ?>-icon" href="<?php echo esc_url( $social_arr['link'] ); ?>" target="_blank"><i class="fa fa-<?php echo $social_arr['name']; ?>"></i> <span class="ibwp-mp-<?php echo $social_arr['name']; ?>-text"><?php echo $social_arr['title']; ?></span></a>
		<?php } else { ?>
			<a class="ibwp-mp-social-icon ibwp-mp-<?php echo $social_arr['name']; ?>-icon" href="<?php echo esc_url( $social_arr['link'] ); ?>" target="_blank"><i class="fa fa-<?php echo $social_arr['name']; ?>"></i></a>
		<?php }
	} ?>
</div>