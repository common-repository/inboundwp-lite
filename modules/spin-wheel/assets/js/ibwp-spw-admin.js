jQuery( document ).ready(function($) {

	/* Segment Show / Hide */
	$(document).on('click', '.ibwp-spw-segment-row-sett, .ibwp-spw-segment-title', function(e) {

		e.preventDefault();
		var cls_ele	= $(this).closest('.ibwp-spw-segment-row-inr');

		cls_ele.find('.ibwp-spw-segment-row-data').slideToggle('fast', function() {

			$('.ibwp-spw-segment-row-inr').removeClass('ibwp-spw-segment-active');
			cls_ele.addClass('ibwp-spw-segment-active');
		});
	});

	/* Add Row for Segment */
	$( document ).on('click', '.ibwp-spw-segment-row-add', function() {

		cls_ele 	= $(this).closest('.ibwp-spw-segment-row-wrp');
		segment_row	= cls_ele.find('.ibwp-spw-segment-row-inr');
		cls_ele.find( '.ibwp-spw-segment-row-inr' ).removeClass( 'ibwp-spw-segment-active' );

		if( segment_row.length >= 4 ) {

			var limit_msg = IBWPL_SPW_Admin.segment_limit_msg;
			alert( limit_msg );

		} else {

			var template = wp.template('ibwp-spw-segment-tmpl');

			/* Retrieve the highest current key */
			var key = highest = -1;
			cls_ele.find( '.ibwp-spw-segment-row-inr' ).each(function() {
				var current = $(this).data( 'key' );
				if( parseInt( current ) > highest ) {
					highest = current;
				}
			});
			key = highest += 1;

			var tmpl_data = {
				segment_id : key
			};
			template	= template( tmpl_data );
			clone_ele	= $( template );

			clone_ele.attr( 'data-key', key );
			clone_ele.addClass( 'ibwp-spw-segment-active' );
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

			$(this).closest('.ibwp-spw-segment-row-inr').after( clone_ele );

			ibwpl_init_wp_editor();

			ibwpl_tooltip();

			// Initialize ColorPicker
			if( $('.ibwp-colorpicker').length > 0 ) {
				$('.ibwp-colorpicker').wpColorPicker();
			}
		}
	});

	/* Delete Segment Row */
	$(document).on('click', '.ibwp-spw-segment-row-delete', function() {

		var num_of_row = $('.ibwp-spw-segment-row-wrp .ibwp-spw-segment-row-inr').length;

		if( num_of_row > 1 ) {
			var ans = confirm( IBWPLAdmin.cofirm_msg );
			if( ans ) {
				$(this).closest('.ibwp-spw-segment-row-inr').remove();
			}
		}
		return false;
	});

	/* Add Row for Form Fields */
	$( document ).on('click', '.ibwp-spw-add-form-field-row', function() {

		var cls_ele 	= $(this).closest('.ibwp-spw-form-field-row-wrp');
		var template	= wp.template('ibwp-spw-form-field-tmpl');

		/* Retrieve the highest current key */
		var key = highest = -1;
		cls_ele.find( '.ibwp-spw-form-field-row' ).each(function() {
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

		$(this).closest('.ibwp-spw-form-field-row').after( clone_ele );

		ibwpl_tooltip();
	});

	/* Delete Form Field Row */
	$(document).on('click', '.ibwp-spw-del-form-field-row', function() {

		var num_of_row = $('.ibwp-spw-form-field-row-wrp .ibwp-spw-form-field-row').length;

		if( num_of_row > 1 ) {
			var ans = confirm( IBWPLAdmin.cofirm_msg );
			if( ans ) {
				$(this).closest('.ibwp-spw-form-field-row').remove();
			}
		}
		return false;
	});

	/* Show / Hide redirect url and custom message on change segment type */
	$( document ).on('change', '.ibwp-spw-segment-type', function() {
		var cls_ele		= $(this).closest('.ibwp-spw-segment-row-inr');
		var type_val	= $(this).val();

		cls_ele.find('.ibwp-spw-segment-type-hide').hide();
		cls_ele.find('.ibwp-spw-type-' + type_val ).show();
	});

	/* Drag and Drop Form Fields */
	if( $( '.ibwp-spw-form-field-row-wrp' ).length > 0 ) {
		$( '.ibwp-spw-form-field-row-wrp' ).sortable({
			items 				: '.ibwp-spw-form-field-row',
			handle 				: ".ibwp-spw-drag-form-field-row",
			cursor 				: 'move',
			axis 				: 'y',
			scrollSensitivity   : 40,
			placeholder         : "ibwp-spw-drag-highlight ibwp-spw-form-field-row-highlight",
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

	/* Drag and Drop Wheel Segments */
	if( $( '.ibwp-spw-segment-row-wrp' ).length > 0 ) {
		$( '.ibwp-spw-segment-row-wrp' ).sortable({
			items 				: '.ibwp-spw-segment-row-inr',
			handle 				: ".ibwp-spw-segment-row-drag",
			cursor 				: 'move',
			axis 				: 'y',
			scrollSensitivity   : 40,
			placeholder         : "ibwp-spw-drag-highlight ibwp-spw-segment-row-highlight",
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