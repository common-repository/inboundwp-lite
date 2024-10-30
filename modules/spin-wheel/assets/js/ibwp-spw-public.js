(function($) {
	"use strict";

	var ibwp_spw_timer;

	var ibwp_spw_second		= 0;
	var ibwp_spw_interval	= setInterval(function() {
		++ibwp_spw_second;
	}, 1000);

	jQuery( document ).ready(function() {

		ibwpl_render_optin_wheel();

		/* Resize Window */
		$(window).on("resize",function () {
			ibwpl_render_optin_wheel();
		});

		/* Function to spining a spin wheel */
		function ibwpl_spw_spins_wheel(stop_position, wheel_id, segment_label, wheel_speed, wheel_spin_dur) {

			var default_css		= '';
			var wheel_canvas	= $('#ibwp-spw-wheel-first-'+ wheel_id);

			var wheel_slices	= segment_label.length;
			var wheel_sliceDeg	= ( 360 / wheel_slices );
			var width			= wheel_canvas.width();

			if ( window.devicePixelRatio ) {
				default_css = 'width:' + width + 'px;height:' + width + 'px;';
			}

			wheel_canvas.attr('style', default_css);

			var stop_deg	= 360 - ( wheel_sliceDeg * stop_position );
			var wheel_stop	= wheel_speed * 360 * wheel_spin_dur + stop_deg;
			var style		= default_css + '-moz-transform: rotate(' + wheel_stop + 'deg);-webkit-transform: rotate(' + wheel_stop + 'deg);-o-transform: rotate(' + wheel_stop + 'deg);-ms-transform: rotate(' + wheel_stop + 'deg);transform: rotate(' + wheel_stop + 'deg);';
				style		+= '-webkit-transition: transform ' + wheel_spin_dur + 's ease-out;-moz-transition: transform ' + wheel_spin_dur + 's ease-out;-ms-transition: transform ' + wheel_spin_dur + 's ease-out;-o-transition: transform ' + wheel_spin_dur + 's ease-out;transition: transform ' + wheel_spin_dur + 's ease-out;';

			wheel_canvas.attr('style', style);

			setTimeout(function () {

				style = default_css + 'transform: rotate(' + stop_deg + 'deg);';
				wheel_canvas.attr('style', style);
			}, parseInt( wheel_spin_dur * 1000 ));
		}

		/* Process Form Field Submission */
		$(document).on('submit', '.ibwp-spw-fields-form', function(e) {

			e.preventDefault();

			var this_ele		= $(this);
			var wheel_conf		= $.parseJSON( this_ele.closest('.ibwp-spw-wheel-wrap').attr('data-conf') );
			var cls_form 		= $(this).closest('form');
			var cls_succ_ele	= $(this).closest('.ibwp-spw-wheel-form-process-jq');
			var storage_name	= wheel_conf.cookie_prefix+wheel_conf.id;

			cls_form.find('.ibwp-spw-form-field-row').removeClass('ibwp-spw-form-inp-err');
			cls_form.find('.ibwp-spw-form-submit').attr('disabled', 'disabled');
			cls_form.find('.ibwp-error').remove();
			this_ele.find('.ibwp-loader').removeClass('ibwp-hide');

			var wheel_data	= {
				'action'			: 'ibwpl_spw_wheel_form_submit',
				'form_data'			: cls_form.serialize(),
				'wheel_id'			: wheel_conf.id,
				'cookie_expire'		: wheel_conf.cookie_expire,
				'cookie_unit'		: wheel_conf.cookie_unit,
			};

			jQuery.post(ibwp_ajaxurl, wheel_data, function(response) {

				if( response.success == 0 ) {
					$.each(response.errors, function( key, err_data ) {
						cls_form.find('.'+key).closest('.ibwp-spw-form-field-row').addClass('ibwp-spw-form-inp-err');
					});

					this_ele.find('.ibwp-loader').addClass('ibwp-hide');
					cls_form.append( '<div class="ibwp-error">' + response.msg + '</div>' );
					cls_form.find('.ibwp-spw-form-submit').removeAttr('disabled', 'disabled');

				} else {

					/* Function to stop wheel based on Probability */
					ibwpl_spw_spins_wheel( response.stop_position, wheel_conf.id, wheel_conf.segment_label, wheel_conf.wheel_speed, wheel_conf.wheel_spin_dur );

					setTimeout(function() {

						/* If Redirect URL Or Not? */
						if( response.redirect_url && response.segment_type == 'thanks_page' ) {
							cls_succ_ele.html( response.redirect_msg );
							window.location = response.redirect_url;
						}

						/* If Segment Message Or Not? */
						if( response.custom_msg && response.segment_type == 'custom_msg' ) {
							cls_succ_ele.html( response.custom_msg );
						}

						this_ele.find('.ibwp-loader').addClass('ibwp-hide');
						cls_form.find('.ibwp-spw-form-submit').removeAttr('disabled', 'disabled');
					}, ( wheel_conf.wheel_spin_dur * 1000 ) + 1000 );

					/* Set Cookie */
					if( wheel_conf.cookie_expire !== '' ) {
						ibwpl_create_cookie( storage_name, 1, wheel_conf.cookie_expire, wheel_conf.cookie_unit );
					}
				}
			});

			return false;
		});

		/* Page Load Popup for Spin Wheel */
		$('.ibwp-spw-popup-page-load.ibwp-spw-wheel-wrap').each(function(e) {

			var options	= $(this).data('conf');

			/* Open Delay */
			setTimeout(function() {
				$('#ibwp-spw-wheel-icon-wrp-'+options.id).show();
			}, options.open_delay);
		});

		/* Open Spin Wheel Click Event */
		$(document).on('click', '.ibwp-spw-wheel-icon', function() {

			var cls_ele		= $(this).closest('.ibwp-spw-wheel-icon-wrp');
			var trigger_id	= $(this).data('id');
			var options		= $('#ibwp-spw-popup-' + trigger_id).data('conf');
			var mfp_opts	= ibwpl_spw_wheel_opts( $('.ibwp-spw-popup-' + trigger_id), options );

			if( $(this).hasClass('ibwp-spw-wheel-icon-open') ) {

				$.magnificPopup.close();

			} else {

				ibwpl_spw_wheel_open( mfp_opts );
				$(this).addClass('ibwp-spw-wheel-icon-open');

				if( ibwp_mobile == 0 && ibwp_is_ie == 0 ) {
					cls_ele.css({'right': '22px'});
				}
			}

			return false;
		});

		/* Custom Popup Close */
		$(document).on('click', '.ibwp-spw-wheel-close', function(e) {
			$.magnificPopup.close();
			return false;
		});
	});

	/* Render Optin Wheel */
	function ibwpl_render_optin_wheel() {

		/* Create Each Spin Wheel */
		$('.ibwp-spw-wheel-wrap').each(function(e) {

			var wheel_conf = $.parseJSON( $(this).attr('data-conf') );

			var wheel_id				= wheel_conf.id;
			var segment_lbl				= wheel_conf.segment_label;
			var segment_bg_clr			= wheel_conf.segment_bg_clr;
			var segment_lbl_clr			= wheel_conf.segment_lbl_clr;
			var wheel_border_clr		= wheel_conf.wheel_border_clr;
			var wheel_dots_clr			= wheel_conf.wheel_dots_clr;
			var wheel_pointer_bg_clr	= wheel_conf.wheel_pointer_bg_clr;
			var is_mobile				= ibwp_mobile;

			var max_text_width	= ( is_mobile ) ? 100 : 150;
			var wheel_slices	= segment_lbl.length;
			var wheel_sliceDeg	= ( 360 / wheel_slices );
			var wheel_deg		= -( wheel_sliceDeg / 2 );

			var content_width	= jQuery('.ibwp-spw-popup-'+ wheel_id).width();
			var wheel_canvas	= document.getElementById('ibwp-spw-wheel-first-'+ wheel_id);
			var wheel_content	= wheel_canvas.getContext('2d');
			var window_width	= window.innerWidth;
			var window_height	= window.innerHeight;
			var canvas_height	= ( window_height <= 420 ) ? 450 : window_width;
			canvas_height		= ( ibwp_mobile && canvas_height <= 550 ) ? canvas_height : 550;


			if( window_width >= 550 ) {
				wheel_canvas.width	= ( canvas_height * 0.75 ) + 16;
			} else {
				wheel_canvas.width	= ( window_width * 0.85 ) + 16;
			}

			wheel_canvas.height		= wheel_canvas.width;
			var width				= wheel_canvas.width;
			var center				= ( width / 2 );
			var wheel_icon_center	= 32;
			var wheel_lbl_size		= parseInt( width / 28 );

			$('.ibwp-spw-wheel-left-inr').css({'width': width + 'px', 'height': width + 'px'});
			$('.ibwp-spw-wheel-pointer-'+ wheel_id).css({'font-size': parseInt( width / 5 ) + 'px'});

			function ibwpl_spw_wheel_deg(wheel_deg) {
				return wheel_deg * Math.PI / 180;
			}

			/* Generate Spin Wheel Slices */
			function ibwpl_spw_wheel_slice(wheel_deg, color) {

				var r;
				wheel_content.beginPath();
				wheel_content.fillStyle = color;
				wheel_content.moveTo( center, center );

				if ( width <= 480 ) {
					r = ( width / 2 ) - 10;
				} else {
					r = ( width / 2 ) - 14;
				}

				wheel_content.arc( center, center, r, ibwpl_spw_wheel_deg( wheel_deg ), ibwpl_spw_wheel_deg( wheel_deg + wheel_sliceDeg ) );
				wheel_content.lineTo( center, center );
				wheel_content.fill();
			}

			/* Function to draw wheel segment label */
			function ibwpl_spw_wheel_label(wheel_deg, text, color) {

				wheel_content.save();
				wheel_content.translate( center, center );
				wheel_content.rotate( ibwpl_spw_wheel_deg( wheel_deg ) );

				wheel_content.textAlign		= "right";
				wheel_content.fillStyle		= color;
				wheel_content.font			= '600 ' + wheel_lbl_size + 'px Arial';
				wheel_content.shadowOffsetX	= 0;
				wheel_content.shadowOffsetY	= 0;

				text = text.replace(/&#(\d{1,4});/g, function (fullStr, code) {
					return String.fromCharCode( code );
				});

				var line		= '';
				var n			= 0;
				var lineHeight	= 16;
				var text_words	= text.split(" ");
				var x			= ( ( 7 * center ) / 8 );
				var y			= ( ( wheel_lbl_size / 2 ) - 2 );

				for ( n = 0; n < text_words.length; n++ ) {
					var line_break	= line + text_words[n] + " ";
					var metrics		= wheel_content.measureText( line_break );
					var text_width	= metrics.width;

					if ( text_width > max_text_width ) {
						wheel_content.fillText( line, x, y );
						line = text_words[n] + " ";
						y	+= lineHeight;

					} else {
						line = line_break;
					}
				}

				wheel_content.fillText( line, x, y );
				wheel_content.restore();
			}

			/* Function to draw wheel pointer */
			function ibwpl_spw_wheel_pointer(wheel_deg, color) {

				wheel_content.save();
				wheel_content.beginPath();

				wheel_content.fillStyle		= color;
				wheel_content.shadowBlur	= 4;
				wheel_content.shadowOffsetX	= 0;
				wheel_content.shadowOffsetY	= 0;
				wheel_content.shadowColor	= wheel_pointer_bg_clr;

				wheel_content.arc( center, center, width / 9, 0, 2 * Math.PI );
				wheel_content.fill();

				wheel_content.clip();
				wheel_content.restore();
			}

			/* Function to draw wheel border */
			function ibwpl_spw_wheel_border(borderC, dotC, lineW, dotR, des) {

				wheel_content.beginPath();

				wheel_content.strokeStyle	= borderC;
				wheel_content.lineWidth		= lineW;

				wheel_content.arc( center, center, (center - 5), 0, 2 * Math.PI );
				wheel_content.stroke();

				var wheel_icon_center = center - des;

				for (var i = 0; i < wheel_slices; i++) {

					wheel_content.beginPath();

					wheel_content.fillStyle	= dotC;
					var x_val				= center + wheel_icon_center * Math.cos( wheel_deg * Math.PI / 180 );
					var y_val				= center - wheel_icon_center * Math.sin( wheel_deg * Math.PI / 180 );

					wheel_content.arc( x_val, y_val, dotR, 0, 2 * Math.PI );
					wheel_content.fill();
					wheel_deg += wheel_sliceDeg;
				}
			}

			/* For Loop to draw spin wheel */
			for (var i = 0; i < wheel_slices; i++) {

				ibwpl_spw_wheel_slice( wheel_deg, segment_bg_clr[i] );
				ibwpl_spw_wheel_label( wheel_deg + wheel_sliceDeg / 2, segment_lbl[i], segment_lbl_clr[i] );

				wheel_deg += wheel_sliceDeg;
			}

			/* Wheel Canvas Second */
			wheel_canvas	= document.getElementById('ibwp-spw-wheel-second-'+ wheel_id);
			wheel_content	= wheel_canvas.getContext('2d');

			if( window_width >= 550 ) {
				wheel_canvas.width	= ( canvas_height * 0.75 ) + 16;
			} else {
				wheel_canvas.width	= ( window_width * 0.85 ) + 16;
			}
			wheel_canvas.height	= wheel_canvas.width;

			ibwpl_spw_wheel_pointer( wheel_deg, wheel_pointer_bg_clr );

			ibwpl_spw_wheel_border( wheel_border_clr, wheel_dots_clr, 10, 4, 5 );

			/* Function to draw wheel icon slices */
			function ibwpl_spw_wheel_icon_slice(wheel_deg, color) {

				wheel_content.beginPath();
				wheel_content.fillStyle = color;
				wheel_content.moveTo( wheel_icon_center, wheel_icon_center );
				wheel_content.arc( wheel_icon_center, wheel_icon_center, 32, ibwpl_spw_wheel_deg( wheel_deg ), ibwpl_spw_wheel_deg( wheel_deg + wheel_sliceDeg ) );
				wheel_content.lineTo( wheel_icon_center, wheel_icon_center );
				wheel_content.fill();
			}

			/* Function to draw wheel icon pointer */
			function ibwpl_spw_icon_pointer(color) {

				wheel_content.save();
				wheel_content.beginPath();
				wheel_content.fillStyle = color;
				wheel_content.arc( wheel_icon_center, wheel_icon_center, 8, 0, 2 * Math.PI );
				wheel_content.fill();
				wheel_content.restore();
			}

			/* Function to draw wheel icon border */
			function ibwpl_spw_icon_border(borderC, dotC, lineW, dotR, des) {

				wheel_content.beginPath();

				wheel_content.strokeStyle	= borderC;
				wheel_content.lineWidth		= lineW;

				wheel_content.arc( wheel_icon_center, wheel_icon_center, wheel_icon_center, 0, 2 * Math.PI );
				wheel_content.stroke();

				var center2	= wheel_icon_center - des;

				for (var i = 0; i < wheel_slices; i++) {

					wheel_content.beginPath();

					wheel_content.fillStyle = dotC;
					var x_val				= wheel_icon_center + center2 * Math.cos( wheel_deg * Math.PI / 180 );
					var y_val				= wheel_icon_center - center2 * Math.sin( wheel_deg * Math.PI / 180 );

					wheel_content.arc( x_val, y_val, dotR, 0, 2 * Math.PI );
					wheel_content.fill();

					wheel_deg += wheel_sliceDeg;
				}
			}

			/* Function to draw wheel icon */
			function ibwpl_spw_wheel_icon() {

				wheel_canvas	= document.getElementById('ibwp-spw-wheel-icon-'+ wheel_id);
				wheel_content	= wheel_canvas.getContext('2d');

				for ( var k = 0; k < wheel_slices; k++ ) {
					ibwpl_spw_wheel_icon_slice( wheel_deg, segment_bg_clr[k] );
					wheel_deg += wheel_sliceDeg;
				}
				ibwpl_spw_icon_pointer( wheel_pointer_bg_clr );
				ibwpl_spw_icon_border( wheel_border_clr, wheel_dots_clr, 4, 1, 0 );
			}

			/* Draw Wheel Icon */
			ibwpl_spw_wheel_icon();

		}); /* end .ibwp-spw-wheel-wrap */
	}

	/* Display Spin Wheel Popup */
	function ibwpl_spw_wheel_open( mfp_opts ) {

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

	/* Setup Spin Wheel Popup Options */
	function ibwpl_spw_wheel_opts( obj, options ) {

		var wheel_id	= obj.attr('id');

		var defaults	= {
							type			: 'inline',
							tClose			: ibwp_mfp_close_text,
							tLoading		: ibwp_mfp_load_text,
							mainClass		: 'ibwp-mfp-slide-in ibwp-mfp-popup ibwp-spw-mfp-popup ibwp-mfp-popup-'+ options.id,
							closeMarkup		: '<span title="%title%" class="ibwp-spw-close-btn mfp-close">&#215;</span>',
							removalDelay	: 300,
							items: {
								src: '#'+wheel_id,
							},
							callbacks: {
								open: function() {

									$('body, html').addClass('ibwp-mfp-lock');

									clearTimeout(ibwp_spw_timer);
								},
								close: function() {

									$('body, html').removeClass('ibwp-mfp-lock');
									$('.ibwp-spw-wheel-icon').removeClass('ibwp-spw-wheel-icon-open');
									$('.ibwp-spw-wheel-icon-wrp').css({'right': ''});
								},
							}
						}
		var mfp_opts = $.extend(defaults, options);
		return mfp_opts;
	}
})(jQuery);