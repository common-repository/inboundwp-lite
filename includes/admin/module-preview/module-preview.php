<?php
/**
 * Module Preview Screen
 *
 * Handles the module preview functionality of plugin
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="Content-Type" content="text/html;" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php esc_html_e("InboundWP Lite Module Preview", "inboundwp-lite"); ?></title>

		<?php wp_print_styles('common'); ?>
		<link rel="stylesheet" href="<?php echo IBWPL_URL; ?>assets/css/ibwp-public.css" type="text/css" />
		<style type="text/css">
			body{background: #fff; overflow-x: hidden;}
			.ibwp-customizer-container{padding:0 16px;}
		</style>
	</head>
	<body>
		<div id="ibwp-customizer-container" class="ibwp-customizer-container">
			<div class="ibwp-center">
				<img src="<?php echo IBWPL_URL; ?>assets/images/inboundwp-lite.png"><br/>
				<?php echo __('For a quick preview ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?>
			</div>
		</div>

		<?php if( ! empty( $localize_var['handler'] ) && ! empty( $localize_var['value'] ) ) { ?>
			<script type='text/javascript'>
			//<![CDATA[
			var <?php echo $localize_var['handler']; ?> = <?php echo wp_json_encode( $localize_var['value'] ); ?>;
			//]]>
			</script>
		<?php }	?>
	</body>
</html>