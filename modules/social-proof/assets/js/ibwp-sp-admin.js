jQuery( document ).ready(function($) {

	var ibwp_sp_meta_notify_timer;

	/* Show save notice */
	$(document).on('change', '.ibwp-sp-source-type', function() {

		var anim_bottom = '50px';

		if( ibwp_mobile == 1 ) {
			anim_bottom = 0;
		}

		$('.ibwp-sp-meta-notify').show().animate({bottom: anim_bottom}, 500);

		clearTimeout(ibwp_sp_meta_notify_timer);
		ibwp_sp_meta_notify_timer = setTimeout(function() {
										$('.ibwp-sp-meta-notify').fadeOut( "slow", function() {
											$(this).css({bottom:''});
										});
									}, 5000);
	});

	/* Notificattion Show / Hide */
	$(document).on('click', '.ibwp-sp-custom-nf-row-sett, .ibwp-sp-custom-nf-ttl', function(e) {

		e.preventDefault();
		var cls_ele = $(this).closest('.ibwp-sp-custom-nf-row-inr');

		cls_ele.find('.ibwp-sp-custom-nf-row-data').slideToggle('fast', function() {

			$('.ibwp-sp-custom-nf-row-inr').removeClass('ibwp-sp-custom-nf-active');
			cls_ele.addClass('ibwp-sp-custom-nf-active');
		});
	});

	/* Add Row for Notificattion */
	$( document ).on('click', '.ibwp-sp-custom-nf-row-add', function() {

		var curr_ele	= $(this).closest('.ibwp-sp-custom-nf-row-inr');
		var cls_ele     = $(this).closest('.ibwp-sp-custom-nf-row-wrp');
		var curr_key	= curr_ele.attr('data-key');
		
		cls_ele.find( '.ibwp-sp-custom-nf-row-inr' ).removeClass( 'ibwp-sp-custom-nf-active' );

		var clone_ele	= wp.template('ibwp-sp-custom-nf-tmpl');
		clone_ele		= $( clone_ele() );

		/* Retrieve the highest current key */
		var key = highest = -1;
		cls_ele.find( '.ibwp-sp-custom-nf-row-inr' ).each(function() {
			var current = $(this).data( 'key' );
			if( parseInt( current ) > highest ) {
				highest = current;
			}
		});
		key = highest += 1;

		clone_ele.attr( 'data-key', key );
		clone_ele.addClass( 'ibwp-sp-custom-nf-active' );
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

			var curr_ele_name	= name.replace( /\[(\d+)\]/, '[' + parseInt( curr_key ) + ']');
			var curr_ele_val	= $('[name="'+curr_ele_name+'"]').val();

			if( curr_ele_val ) {
				$( this ).val( curr_ele_val );
			}
		});

		clone_ele.find( 'label' ).each(function() {
			var label = $( this ).attr( 'for' );

			if( typeof label != 'undefined' ) {
				label = label.replace( /(\d+)/, parseInt( key ) );
				$( this ).attr( 'for', label );
			}
		});

		$(this).closest('.ibwp-sp-custom-nf-row-inr').after( clone_ele );

		ibwpl_tooltip();

	});

	/* Delete Notificattion Row */
	$(document).on('click', '.ibwp-sp-custom-nf-row-delete', function() {

		var num_of_row = $('.ibwp-sp-custom-nf-row-wrp .ibwp-sp-custom-nf-row-inr').length;

		if( num_of_row > 1 ) {
			var ans = confirm( IBWPLAdmin.cofirm_msg );
			if( ans ) {
				$(this).closest('.ibwp-sp-custom-nf-row-inr').remove();
			}
		}
		return false;
	});

	/* Drag and Drop Custom Notificaion */
	if( $( '.ibwp-sp-custom-nf-row-wrp' ).length > 0 ) {
		$( '.ibwp-sp-custom-nf-row-wrp' ).sortable({
			items 				: '.ibwp-sp-custom-nf-row-inr',
			handle 				: ".ibwp-sp-custom-nf-row-drag",
			cursor 				: 'move',
			axis 				: 'y',
			scrollSensitivity   : 40,
			containment			: '.ibwp-sp-custom-nf-row-wrp',
			placeholder         : "ibwp-sp-drag-highlight ibwp-sp-custom-nf-row-highlight",
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