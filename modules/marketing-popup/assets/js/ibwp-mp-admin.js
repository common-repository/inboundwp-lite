jQuery( document ).ready(function($) {

	var ibwp_mp_meta_notify_timer;

	/* Add row for Social Icons */
	$( document ).on('click', '.ibwp-mp-add-social-row', function() {

		cls_ele 	= $(this).closest('.ibwp-post-mp-table');
		clone_ele	= $(this).closest('.ibwp-mp-social-title-row').clone();

		/* Retrieve the highest current key */
		var key = highest = -1;
		cls_ele.find( 'tr.ibwp-mp-social-title-row' ).each(function() {
			var current = $(this).data( 'key' );
			if( parseInt( current ) > highest ) {
				highest = current;
			}
		});
		key = highest += 1;

		clone_ele.attr( 'data-key', key );
		clone_ele.find( 'input, textarea' ).val( '' );

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

		clone_ele.find('.ibwp-mp-title-name').text('');

		clone_ele.appendTo( cls_ele ); /* Clone and insert */
	});

	/* Delete Social Row */
	$(document).on('click', '.ibwp-mp-del-social-row', function() {
		var num_of_row = $('.ibwp-post-mp-table .ibwp-mp-social-title-row').length;

		if( num_of_row == 1 ) {
			$(this).closest('.ibwp-mp-social-title-row').find('input').val('');
			return false;
		} else {
			$(this).closest('tr.ibwp-mp-social-title-row').remove();
		}
	});

	/* Add Row for Form Fields */
	$( document ).on('click', '.ibwp-mp-add-form-field-row', function() {

		var cls_ele 	= $(this).closest('.ibwp-mp-form-field-row-wrp');
		var template	= wp.template('ibwp-mp-form-field-tmpl');

		/* Retrieve the highest current key */
		var key = highest = -1;
		cls_ele.find( '.ibwp-mp-form-field-row' ).each(function() {
			var current = $(this).data( 'key' );
			if( parseInt( current ) > highest ) {
				highest = current;
			}
		});
		key = highest += 1;

		var tmpl_data = {
			field_key : key
		};
		template	= template( tmpl_data );
		clone_ele	= $( template );

		clone_ele.attr( 'data-key', key );
		clone_ele.find( 'input[type="text"], textarea' ).val( '' );

		clone_ele.find( 'input, select, textarea' ).each(function() {
				var name = $( this ).attr( 'name' );
				var id   = $( this ).attr( 'id' );

				if( name ) {
					name = name.replace( /\[(\d+)\]/, '[' + parseInt( key ) + ']');
					$( this ).attr( 'name', name );
				}

				if( typeof id != 'undefined' ) {
					id = id.replace( /(\d+)/, parseInt( key ) );
					$( this ).attr( 'id', id );
				}
			});

		clone_ele.find( 'label' ).each(function() {
			var label = $( this ).attr( 'for' );

			if( typeof label != 'undefined' ) {
				label = label.replace( /(\d+)/, parseInt( key ) );
				$( this ).attr( 'for', label );
			}
		});

		$(this).closest('.ibwp-mp-form-field-row').after( clone_ele );

		ibwpl_tooltip();
	});

	/* Delete Form Field Row */
	$(document).on('click', '.ibwp-mp-del-form-field-row', function() {

		var num_of_row = $('.ibwp-mp-form-field-row-wrp .ibwp-mp-form-field-row').length;

		if( num_of_row > 1 ) {
			var ans = confirm( IBWPLAdmin.cofirm_msg );
			if( ans ) {
				$(this).closest('.ibwp-mp-form-field-row').remove();
			}
		}
		return false;
	});

	/* Show save notice */
	$(document).on('click', '.ibwp-mp-behav-box-wrp', function() {

		var anim_bottom = '50px';
		if( ibwp_mobile == 1 ) {
			anim_bottom = 0;
		}

		$('.ibwp-mp-meta-notify').show().animate({bottom: anim_bottom}, 500);

		clearTimeout(ibwp_mp_meta_notify_timer);
		ibwp_mp_meta_notify_timer = setTimeout(function() {
										$('.ibwp-mp-meta-notify').fadeOut( "slow", function() {
											$(this).css({bottom:''});
										});
									}, 5000);
	});

	/* Drag and Drop Social Services */
	if( $( '.ibwp-mp-form-field-row-wrp' ).length > 0 ) {
		$( '.ibwp-mp-form-field-row-wrp' ).sortable({
			items 				: '.ibwp-mp-form-field-row',
			handle 				: ".ibwp-mp-drag-form-field-row",
			cursor 				: 'move',
			axis 				: 'y',
			scrollSensitivity   : 40,
			placeholder         : "ibwp-mp-form-field-row-highlight",
			helper: function( event, ui ) {
				return ui;
			},
			start: function( event, ui ) {
				ui.placeholder.html("<tr><td colspan='3'></td><tr>")
				if ( ! ui.item.hasClass( 'alternate' ) ) {
					ui.item.css( 'background-color', '#ffffff' );
				}
			},
			stop: function( event, ui ) {
			},
			update: function( event, ui ) {
				if ( ! ui.item.hasClass( 'alternate' ) ) {
					ui.item.css( 'background-color', '' );
				}
			}
		});
	}
});