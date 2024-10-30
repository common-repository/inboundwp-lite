(function( $ ) {

	var ibwp_mp_timer;

	var ibwp_mp_second		= 0;
	var ibwp_mp_interval	= setInterval(function() {
		++ibwp_mp_second;
	}, 1000);

	jQuery( document ).ready(function() {

		/* Welcome Popup for Modal */
		$('.ibwp-mp-popup-page-load.ibwp-mp-popup-js').each(function(e) {

			var options		= $(this).data('conf');
			var mfp_opts	= ibwpl_mp_popup_opts( $(this), options );

			/* Open Delay */
			setTimeout(function() {
				ibwpl_mp_popup_open( mfp_opts );
			}, options.open_delay);
		});

		/* Custom Popup Close */
		$(document).on('click', '.ibwp-mp-popup-close', function(e) {
			$.magnificPopup.close();
			return false;
		});

		/* Process Form Field Submission */
		$(document).on('submit', '.ibwp-mp-fields-form', function(e) {

			e.preventDefault();

			var this_ele		= $(this);
			var options			= $(this).closest('.ibwp-mp-popup-email-lists').data('conf');
			var cls_form 		= $(this).closest('form');
			var cls_succ_ele	= $(this).closest('.ibwp-mp-popup-form-process');

			cls_form.find('.ibwp-mp-form-field-row').removeClass('ibwp-mp-form-inp-err');
			cls_form.find('.ibwp-mp-form-submit').attr('disabled', 'disabled');
			cls_form.find('.ibwp-error').remove();
			this_ele.find('.ibwp-loader').removeClass('ibwp-hide');

			var popup_data	= {
				'action'	: 'ibwpl_mp_popup_form_submit',
				'form_data'	: cls_form.serialize(),
				'popup_id'	: options.id,
			};

			jQuery.post(ibwp_ajaxurl, popup_data, function(response) {

				if( response.success == 0 ) {
					$.each(response.errors, function( key, err_data ) {
						cls_form.find('.'+key).closest('.ibwp-mp-form-field-row').addClass('ibwp-mp-form-inp-err');
					});
				} else {
					cls_succ_ele.html( response.thanks_msg );
				}

				this_ele.find('.ibwp-loader').addClass('ibwp-hide');
				cls_form.append( '<div class="ibwp-error">' + response.msg + '</div>' );
				cls_form.find('.ibwp-mp-form-submit').removeAttr('disabled', 'disabled');
			});

			return false;
		});
	});

	/* Display Popup */
	function ibwpl_mp_popup_open( mfp_opts ) {

		if( $.magnificPopup.instance.isOpen == true ) {
			var ibwp_mfp_opened = 1;
		} else {
			var ibwp_mfp_opened = 0;
		}

		$.magnificPopup.close();

		if( ibwp_mfp_opened == 0 ) {
			$.magnificPopup.open( mfp_opts );
		} else {

			setTimeout(function() {
				$.magnificPopup.open( mfp_opts );
			}, 300 );
		}
	}

	/* Setup Popup Options */
	function ibwpl_mp_popup_opts( obj, options ) {

		var popup_id	= obj.attr('id');
		var cookie_name	= options.cookie_prefix+options.id;

		var defaults	= {
							type			: 'inline',
							tClose			: ibwp_mfp_close_text,
							tLoading		: ibwp_mfp_load_text,
							mainClass		: 'ibwp-mfp-zoom-in ibwp-mfp-popup ibwp-mfp-mp-popup ibwp-mfp-popup-'+options.id+' ibwp-mp-'+options.template+' ibwp-mfp-wrap-popup-'+options.popup_type+' ibwp-mfp-wrap-popup-'+options.popup_goal+' ibwp-mp-'+options.popup_position,
							closeMarkup		: '<span title="%title%" class="ibwp-mp-popup-close-btn mfp-close">&#215;</span>',
							removalDelay	: 300,
							items: {
								src: '#'+popup_id,
							},
							callbacks: {
								open: function() {

									var calc_window_height	= $.magnificPopup.instance.wH;
									var calc_popup_height	= $('#'+popup_id).height();

									clearTimeout(ibwp_mp_timer);
								},
								close: function() {

									/* Set Cookie */
									if( options.cookie_expire !== '' ) {
										ibwpl_create_cookie( cookie_name, 1, options.cookie_expire, options.cookie_unit );
									}
								},
							}
						}
		var mfp_opts = $.extend(defaults, options);
		return mfp_opts;
	}
})( jQuery );