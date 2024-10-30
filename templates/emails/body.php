<?php
/**
 * Email Body
 *
 * @package InboundWP
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$wrapper            = "margin: 0; padding: 30px 0 30px 0; -webkit-text-size-adjust: none !important; width: 100%;";
$template_main_wrp  = "box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; border: 1px solid #dddddd; border-radius: 3px !important; border-collapse: collapse; word-wrap: break-word; word-break: break-word;";
$template_container = "border-collapse: collapse; word-wrap: break-word; word-break: break-word;";
$body_wrapper       = "padding: 0; text-align: left; color: #60666d; line-height: 21px; font-family: Arial, Helvetica, sans-serif;";
?>

<div style="<?php echo $wrapper; ?>" class="wrapper" id="wrapper">
	<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="600" style="<?php echo $template_main_wrp; ?>">
		<tbody>
			<tr>
				<td valign="top" align="center">
					<div id="email-header">
						<h1 style="background-color:#eeeeee; color:#000; margin:0; padding:20px; display: block; font-size:32px; font-weight:500;"><?php echo IBWP_Lite()->email->get_heading(); ?></h1>
					</div>

					<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" id="template-container" class="template-container" style="<?php echo $template_container; ?>">
						<tbody>
							<tr>
								<td valign="top" style="<?php echo $body_wrapper; ?>" class="body-wrapper">
									<div class="body-content" style="padding: 15px; font-size:15px; -webkit-text-size-adjust:100%;">
										{email}
									</div>
								</td>
							</tr>

							<tr>
								<td colspan="2" align="center" valign="middle" id="credit" style="border:0; color: #000000; font-size:13px; text-align:center;">
									<?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'ibwp_email_footer_text', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>' ) ) ) ); ?>
								</td>
							</tr>
						</tbody>
					</table><!-- end .template-container -->
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .wrapper -->