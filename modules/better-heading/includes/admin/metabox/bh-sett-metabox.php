<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package InboundWP Lite
 * @subpackage Better Heading
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$prefix			= IBWPL_BH_META_PREFIX; // Metabox Prefix
$enable			= get_post_meta( $post->ID, $prefix.'enable', true );
$titles			= get_post_meta( $post->ID, $prefix.'titles', true );
$title_clicks	= get_post_meta( $post->ID, $prefix.'title_clicks', true );
$title_views	= get_post_meta( $post->ID, $prefix.'title_views', true );
$titles			= ! empty( $titles ) ? $titles : array( 1 => '' );

$title_clicks	= ( is_array( $title_clicks ) )	? $title_clicks		: array();
$title_click	= ! empty( $title_clicks[0] )	? $title_clicks[0]	: 0;
$title_view		= ! empty( $title_views[0] )	? $title_views[0]	: 0;

arsort( $title_clicks ); // Sort High to Low
$highest_click_title	= key( $title_clicks );
$report_page_url		= add_query_arg( array('page' => 'ibwp-bh-settings', 'tab' => 'report', 'post_types' => $post->post_type, 'post_titles' => $post->ID), admin_url('admin.php') );
?>

<table class="form-table ibwp-post-bh-table">
	<tbody>

		<?php if( $title_clicks || $title_view ) { ?>
		<tr>
			<td colspan="3" align="right">
				<button type="button" class="button button-secondary ibwp-btn ibwp-bh-flush-stats-btn" disabled ><?php esc_html_e('Flush Stats', 'inboundwp-lite'); ?></button>
				<a href="<?php echo esc_url( $report_page_url ); ?>" class="button button-secondary ibwp-btn ibwp-icon-btn" target="_blank"><i class="dashicons dashicons-chart-bar"></i> <?php esc_html_e('Full Report', 'inboundwp-lite'); ?></a>
			</td>
		</tr>
		<?php } ?>

		<tr>
			<th scope="row">
				<label for="ibwp-bh-enable"><?php _e('Enable', 'inboundwp-lite'); ?></label>
			</th>
			<td>
				<input type="checkbox" id="ibwp-bh-enable" class="ibwp-checkbox ibwp-bh-enable" name="<?php echo $prefix; ?>enable" <?php checked( $enable, 1 ); ?> value="1" /><br/>
				<span class="description"><?php _e('Check this box to enable better heading.', 'inboundwp-lite'); ?></span>
			</td>
		</tr>

		<tr class="ibwp-bh-primary-title-row">
			<th scope="row">
				<label for="ibwp-bh-title"><?php _e('Primary Heading', 'inboundwp-lite'); ?></label>
			</th>
			<td colspan="2">
				<span class="ibwp-bh-primary-title"><?php echo strip_tags( $post->post_title ); ?></span>
				<div class="ibwp-bh-post-stats">
					<span class="ibwp-bh-post-stats-data"><?php echo esc_html__('Clicks', 'inboundwp-lite') . ' : ' . $title_click; ?></span>
					<span class="ibwp-bh-post-stats-data"><?php echo esc_html__('Views', 'inboundwp-lite') . ' : ' . $title_view; ?></span>
					<label class="ibwp-bh-post-stats-info" title="<?php esc_html_e("Click and View reports of post title. \n\nClicks can be differ from Views because Views are uniquely counted while Clicks are counted per browser session each day. \n\nThe main part is how many Clicks you got for the title.", 'inboundwp-lite'); ?>">[?]</label>

					<?php if( $highest_click_title === 0 ) { ?>
					<span class="ibwp-bh-post-stats-hclick"><?php esc_html_e('Highest Click', 'inboundwp-lite'); ?></span>
					<?php } ?>
				</div>
			</td>
		</tr>

		<?php if( ! empty( $titles ) ) {
				foreach ( $titles as $title_key => $title_val ) {

					if( empty( $title_key ) ) {
						continue;
					}

					$title_click	= ! empty( $title_clicks[ $title_key ] )	? $title_clicks[ $title_key ]	: 0;
					$title_view		= ! empty( $title_views[ $title_key ] )		? $title_views[ $title_key ]	: 0;
		?>
		<tr class="ibwp-bh-title-row" data-key="<?php echo ibwpl_esc_attr( $title_key ); ?>">
			<th scope="row">
				<label class="ibwp-bh-title-label" for="ibwp-bh-title-<?php echo ibwpl_esc_attr( $title_key ); ?>"><?php echo __('Heading', 'inboundwp-lite') .' '. ibwpl_esc_attr( $title_key ); ?></label>
			</th>
			<td>
				<input type="text" name="<?php echo $prefix; ?>titles[<?php echo $title_key; ?>]" id="ibwp-bh-title-<?php echo $title_key; ?>" class="large-text ibwp-bh-title" value="<?php echo ibwpl_esc_attr( $title_val ); ?>" />
				<div class="ibwp-bh-post-stats">
					<span class="ibwp-bh-post-stats-data"><?php echo esc_html__('Clicks', 'inboundwp-lite') . ' : ' . $title_click; ?></span>
					<span class="ibwp-bh-post-stats-data"><?php echo esc_html__('Views', 'inboundwp-lite') . ' : ' . $title_view; ?></span>
					<label class="ibwp-bh-post-stats-info" title="<?php esc_html_e("Click and View reports of post title. \n\nClicks can be differ from Views because Views are uniquely counted while Clicks are counted per browser session each day. \n\nThe main part is how many Clicks you got for the title.", 'inboundwp-lite'); ?>">[?]</label>
					
					<?php if( $highest_click_title && $highest_click_title == $title_key ) { ?>
					<span class="ibwp-bh-post-stats-hclick"><?php esc_html_e('Highest Click', 'inboundwp-lite'); ?></span>
					<?php } ?>
				</div>
			</td>
			<td style="vertical-align:top;">
				<span class="ibwp-action-btn ibwp-action-add-btn ibwp-bh-add-row" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
				<span class="ibwp-action-btn ibwp-action-del-btn ibwp-bh-del-row" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
			</td>
		</tr>
		<?php }
		} ?>
	</tbody>
</table>