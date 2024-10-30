jQuery( document ).ready(function($) {

	$(document).on('keyup change focus', '#post-title-0, #title', function() {
		var post_title =  $(this).val();
		$('.ibwp-post-bh-table .ibwp-bh-primary-title').text( post_title );
	});

	/* Add row for Heading Title */
	$( document ).on('click', '.ibwp-bh-add-row', function(){

		cls_ele 	= $(this).closest('.ibwp-post-bh-table');
		clone_ele	= $(this).closest('.ibwp-bh-title-row').clone();

		/* Retrieve the highest current key */
		var key = highest = -1;
		cls_ele.find( 'tr.ibwp-bh-title-row' ).each(function() {
			var current = $(this).data( 'key' );
			if( parseInt( current ) > highest ) {
				highest = current;
			}
		});
		key = highest += 1;

		clone_ele.attr( 'data-key', key );
		clone_ele.find( 'input, select, textarea' ).val( '' );
		clone_ele.find('.ibwp-bh-post-stats').remove();

		clone_ele.find( 'input, select, textarea' ).each(function() {
				var name = $( this ).attr( 'name' );
				var id   = $( this ).attr( 'id' );

				if( name ) {
					name = name.replace( /\[(\d+)\]/, '[' + parseInt( key ) + ']');
					$( this ).attr( 'name', name );
				}

				$( this ).attr( 'data-key', key );

				if( typeof id != 'undefined' ) {
					id = id.replace( /(\d+)/, parseInt( key ) );
					$( this ).attr( 'id', id );
				}
			});

		var lbl_for = clone_ele.find('.ibwp-bh-title-label').attr('for').replace( /(\d+)/, parseInt( key ) );
		clone_ele.find('.ibwp-bh-title-label').attr( 'for', lbl_for );

		var lbl_text = clone_ele.find('.ibwp-bh-title-label').text().replace( /(\d+)/, parseInt( key ) );
		clone_ele.find('.ibwp-bh-title-label').text( lbl_text );

		clone_ele.appendTo( cls_ele ); /* Clone and insert */
	});

	/* Delete Row */
	$(document).on('click', '.ibwp-bh-del-row', function() {
		var num_of_row = $('.ibwp-post-bh-table .ibwp-bh-title-row').length;

		if( num_of_row == 1 ) {
			$(this).closest('.ibwp-bh-title-row').find('input').val('');
			return false;
		} else {
			var remove = confirm( IBWPL_BH_Admin.remove_msg );

			if( remove ) {
				$(this).closest('tr.ibwp-bh-title-row').remove();
			}
			return false;
		}
	});

	/* Get title change history */
	$(document).on('click', '.ibwp-bh-chnage-history', function() {
		$('.ibwp-popup-overlay').show();
		$('.ibwp-popup-data-wrp').show();
		$('body').addClass('ibwp-no-overflow');
		$('.ibwp-img-loader').show();

		var current_obj	= $(this);
		var post_id		= current_obj.data('post-id');
		var title_id	= current_obj.data('title-id');
		var nonce		= current_obj.data('nonce');

		var data = {
					action		: 'ibwpl_bh_title_change_history',
					post_id		: post_id,
					title_id	: title_id,
					nonce		: nonce,
				};

		$.post(ajaxurl, data, function(response) {
			if( response.success == 1 ) {
				$('.ibwp-bh-chng-his-wrp .ibwp-bh-popup-body-wrp').html( response.data );
			} else {
				$('.ibwp-bh-chng-his-wrp .ibwp-bh-popup-body-wrp').html( response.msg );
			}
			$('.ibwp-img-loader').hide();
		});

		return false;
	});
});