jQuery( document ).ready(function($) {

	$('.dcdt-start-timepicker').timepicker({
		timeFormat: 'HH:mm:ss',
	});

	$('.dcdt-end-timepicker').timepicker({
		timeFormat: 'HH:mm:ss',
	});

	$('#edd-sale-start-date').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:ss',
        minDate: 0,
        changeMonth: true,
        changeYear: true,
	});

	$('#edd-sale-end-date').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:ss',
        minDate: 0,
        changeMonth: true,
        changeYear: true,
	});
	
	/* On change of style */
	$(document).on('change', ".dcdt-timer-style", function() {

		var style 	= $(this).val();
		$(".dcdt-post-common").addClass("dcdt-post-hide");
		$(".dcdt-timer-style-"+style).removeClass("dcdt-post-hide");
		$(".dcdt-timer-style-"+style).fadeIn(300);
		$(".dcdt-timer-"+style).removeClass("dcdt-post-hide");
		$(".dcdt-timer-"+style).css('display','block');
		$(".dcdt-post-hide").css('display','none');
	});

	/* Hide Sale Price box on Enable Variable Price */
    $(document.body).on('change','#edd_variable_pricing', function(){
        var checked     = $(this).is(':checked');
        var sale_price  = $( '#edd_sale_price_field' );
        var start_date  = $( '#edd_sale_start_date_field' );
        var end_date  	= $( '#edd_sale_end_date_field' );
        if ( checked ) {
            sale_price.hide();
            start_date.hide();
            end_date.hide();
            sale_price.find('input').val('');
            start_date.find('input').val('');
            end_date.find('input').val('');
        } else {
            sale_price.show();
            start_date.show();
            end_date.show();
        }
    });

    // Sale price schedule click to show, hide start time & end time for simple product.
	$( '.sale_price_dates_fields' ).each( function() {
		var $these_sale_dates = $( this );
		var sale_schedule_set = false;
		var $wrap = $these_sale_dates.closest( 'div, table' );

		$these_sale_dates.find( 'input' ).each( function() {
			if ( '' !== $( this ).val() ) {
				sale_schedule_set = true;
			}
		});

		if ( sale_schedule_set ) {
			$wrap.find( '.sale_schedule' ).hide();

			$wrap.find( '._ibwp_dcdt_start_time_field' ).show();
			$wrap.find( '._ibwp_dcdt_end_time_field' ).show();
		} else {
			$wrap.find( '.sale_schedule' ).show();
			$wrap.find( '._ibwp_dcdt_start_time_field' ).hide();
			$wrap.find( '._ibwp_dcdt_end_time_field' ).hide();
		}
	});

	// Sale price schedule click to show start time & end time for variable product.
    $( '#woocommerce-product-data' ).on( 'click', '.sale_schedule', function() {
		var wrap = $( this ).closest( 'div, table' );
		
		$( this ).hide();
		wrap.find( '.dcdt_sale_price_times_fields' ).show();
		wrap.find( '._ibwp_dcdt_start_time_field' ).show();
		wrap.find( '._ibwp_dcdt_end_time_field' ).show();

		$('.dcdt-variable-start-time').timepicker({
			timeFormat: 'HH:mm:ss',
		});
		$('.dcdt-variable-end-time').timepicker({
			timeFormat: 'HH:mm:ss',
		});
		return false;
	});

    // Sale price schedule click to hide start time & end time for variable product.
	$( '#woocommerce-product-data' ).on( 'click', '.cancel_sale_schedule', function() {
		var wrap = $( this ).closest( 'div, table' );
		
		$( this ).hide();
		wrap.find( '.sale_schedule' ).show();
		wrap.find( '.dcdt_sale_price_times_fields' ).hide();
		wrap.find( '._ibwp_dcdt_start_time_field' ).hide();
		wrap.find( '._ibwp_dcdt_end_time_field' ).hide();
		wrap.find( '.dcdt_sale_price_times_fields' ).find( 'input' ).val('');
		wrap.find( '._ibwp_dcdt_start_time_field' ).find( 'input' ).val('');
		wrap.find( '._ibwp_dcdt_end_time_field' ).find( 'input' ).val('');

		return false;
	});
});