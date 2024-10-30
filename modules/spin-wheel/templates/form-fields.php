<?php
/**
* Template for Spin Wheel Form Fields Design
*
* This template can be overridden by copying it to yourtheme/inboundwp-lite/spin-wheel/form-fields.php
*
* @package InboundWP Lite
* @subpackage Spin Wheel
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( empty( $form_fields ) ) {
	return;
}

$field_type_data = ibwpl_form_field_type_options(); ?>

<div class="ibwp-spw-form-fields">
	<form class="ibwp-spw-fields-form ibwp-spw-fields-form-<?php echo $wheel_id; ?>" action="" method="POST" novalidate="novalidate">
		<?php foreach ( $form_fields as $form_field_key => $form_field_val ) {

			$type			= isset( $form_field_val['type'] )				? $form_field_val['type']			: 'text';
			$field_type		= isset( $field_type_data[ $type ]['type'] )	? $field_type_data[ $type ]['type']	: 'text';
			$label			= isset( $form_field_val['label'] )				? $form_field_val['label']			: '';
			$placeholder	= isset( $form_field_val['placeholder'] )		? $form_field_val['placeholder']	: '';
			$require		= ! empty( $form_field_val['require'] )			? 1 : 0;
			$require_lbl	= ( $require ) 									? "<span>*</span>" : '';
		?>
			<div class="ibwp-spw-form-field-row">
				<?php if( $label ) { ?>
				<label class="ibwp-spw-form-lbl" for="ibwp-spw-form-<?php echo $wheel_id .'-'. $form_field_key; ?>"><?php echo $label; ?> <?php echo $require_lbl; ?></label>
				<?php } ?>
				<input type="<?php echo $field_type; ?>" name="ibwp_spw_field_<?php echo $form_field_key; ?>" value="" class="ibwp-spw-form-inp ibwp-spw-form-<?php echo $wheel_id .'-'. $form_field_key; ?> ibwp_spw_field_<?php echo $form_field_key; ?>" id="ibwp-spw-form-<?php echo $wheel_id .'-'. $form_field_key; ?>" placeholder="<?php echo $placeholder; ?>" />
			</div>
		<?php } ?>

		<div class="ibwp-spw-form-submit-row">
			<button type="submit" class="ibwp-spw-form-submit"><?php echo ibwpl_esc_attr( $button_txt ); ?> <span class="ibwp-loader ibwp-hide"></span></button>
		</div>
	</form>
</div>