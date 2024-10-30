<?php
/**
 * View Form Submission Entry
 *
 * @package InboundWP Lite
 * @subpackage Spin Wheel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb, $post;

// Taking some variable
$prefix		= IBWPL_SPW_META_PREFIX;
$entry_id	= isset( $_GET['entry_id'] ) ? $_GET['entry_id'] : 0;

// Get User Detail
$sql		= "SELECT * FROM ".IBWPL_SPW_FORM_TBL." WHERE 1=1 AND `id` = '{$entry_id}'";
$form_entry = $wpdb->get_row( $sql );

$id				= isset( $form_entry->id )				? $form_entry->id				: '-';
$wheel_id		= isset( $form_entry->wheel_id )		? $form_entry->wheel_id			: '';
$name			= isset( $form_entry->name )			? $form_entry->name				: '-';
$created_date	= isset( $form_entry->created_date )	? $form_entry->created_date		: '-';

// Print Error if no valid entry is found
if( empty( $form_entry ) ) {
	echo '<div class="error notice notice-error">
			<p><strong>'.esc_html__('Sorry, Something happened wrong.', 'inboundwp-lite').'</strong></p>
		</div>';
	exit;
}
?>

<div class="wrap ibwp-spw-entry-view-wrap">

	<h2><?php echo esc_html__( 'Form Entry', 'inboundwp-lite' ) . " #{$entry_id}"; ?></h2>
	<br/>

	<table class="wp-list-table widefat fixed striped ibwp-tbl">
		<thead>
			<tr>
				<th><strong><?php esc_html_e('Fields', 'inboundwp-lite'); ?></strong></th>
				<th><strong><?php esc_html_e('Values', 'inboundwp-lite'); ?></strong></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>
					<label><?php _e('Entry ID', 'inboundwp-lite'); ?></label>
				</th>
				<td><?php echo $id; ?></td>
			</tr>

			<tr>
				<th>
					<label><?php _e('Popup', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<?php $wheel_name = ( $wheel_id ) ? get_the_title( $wheel_id ) : ''; ?>
					<a href="<?php echo get_edit_post_link( $wheel_id ); ?>" target="_blank"><?php echo $wheel_name . " - {$wheel_id}" ?></a>
				</td>
			</tr>

			<tr>
				<th>
					<label><?php _e('Name', 'inboundwp-lite'); ?></label>
				</th>
				<td><?php echo $name; ?></td>
			</tr>

			<tr>
				<th>
					<label><?php _e('Email', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<?php if( $form_entry->email ) { ?>
					<a href="mailto:<?php echo $form_entry->email; ?>"><?php echo $form_entry->email; ?></a>
					<?php } else { echo '-'; } ?>
				</td>
			</tr>

			<tr>
				<th>
					<label><?php _e('Phone', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<?php if( $form_entry->phone ) { ?>
					<a href="tel:<?php echo $form_entry->phone; ?>"><?php echo $form_entry->phone; ?></a>
					<?php } else { echo '-'; } ?>
				</td>
			</tr>
			<tr>
				<th>
					<label><?php _e('Submitted Date', 'inboundwp-lite'); ?></label>
				</th>
				<td><?php echo $created_date; ?></td>
			</tr>
		</tbody>
	</table>
</div><!-- end .ibwp-spw-entry-view-wrap -->