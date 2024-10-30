<?php
/**
* Template for Popup Form Fields Design
*
* This template can be overridden by copying it to yourtheme/inboundwp-lite/marketing-popup/form-fields.php
*
* @package InboundWP Lite
* @subpackage Marketing Popup
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( empty( $form_fields ) ) {
	return;
}

$field_type_data = ibwpl_form_field_type_options();
?>
<div class="ibwp-mp-form-fields">
	<form class="ibwp-mp-fields-form ibwp-mp-fields-form-<?php echo $popup_id; ?>" action="" method="POST" novalidate="novalidate">
		<?php foreach ( $form_fields as $form_field_key => $form_field_val ) {
				
			$type			= isset( $form_field_val['type'] )				? $form_field_val['type']			: 'text';
			$field_type		= isset( $field_type_data[ $type ]['type'] )	? $field_type_data[ $type ]['type']	: 'text';
			$label			= isset( $form_field_val['label'] )				? $form_field_val['label']			: '';
			$placeholder	= isset( $form_field_val['placeholder'] )		? $form_field_val['placeholder']	: '';
			$require		= ! empty( $form_field_val['require'] )			? 1 : 0;
			$require_lbl	= ( $require ) 									? "<span>*</span>" : '';

			?>
				<div class="ibwp-mp-form-field-row">
					<?php if( $label ) { ?>
					<label class="ibwp-mp-form-lbl" for="ibwp-mp-form-<?php echo $popup_id .'-'. $form_field_key; ?>"><?php echo $label; ?> <?php echo $require_lbl; ?></label>
					<?php } ?>
					<input type="<?php echo $field_type; ?>" name="ibwp_mp_field_<?php echo $form_field_key; ?>" value="" class="ibwp-mp-form-inp ibwp-mp-form-<?php echo $popup_id .'-'. $form_field_key; ?> ibwp_mp_field_<?php echo $form_field_key; ?>" id="ibwp-mp-form-<?php echo $popup_id .'-'. $form_field_key; ?>" placeholder="<?php echo $placeholder; ?>" />
				</div>

		<?php } // End of foreach ?>

		<div class="ibwp-mp-form-submit-row">
			<button type="submit" name="" class="ibwp-mp-form-submit"><?php echo $submit_btn_txt; ?> <span class="ibwp-loader ibwp-hide"></span></button>
		</div>
	</form>
</div>