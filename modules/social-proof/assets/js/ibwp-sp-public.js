(function($) {
	"use strict";

	var ibwp_nf_interval, ibwp_nf_conf;

	jQuery( document ).ready(function() {

		/* Display Notification */
		$('.ibwp-sp-nf-conf').each(function(e) {

			ibwp_nf_conf = $(this).data('conf');
			ibwpl_sp_process_nf( ibwp_nf_conf );
		});

		/* Close Notification */
		$(document).on('click', '.ibwp-sp-nf-close-btn', function() {

			var cls_ele = $(this).closest('.ibwp-sp-notification-wrap');

			ibwpl_sp_hide_nf( cls_ele );
		});

		/* Fetch Notification Data & Process */
		function ibwpl_sp_process_nf( nf_conf ) {

			/* Initialize Notification */
			if ( 'undefined' === typeof nf_conf ) {
				return;
			}

			var sp_data	= {
							'action'	: 'ibwpl_sp_display_notification',
							'conf'		: nf_conf,
						};

			jQuery.post(ibwp_ajaxurl, sp_data, function( response ) {
				if( response.success == 1 ) {
					ibwpl_sp_render_nf( response.content, nf_conf );
				}
			});
		}

		/* Render Notification Data */
		function ibwpl_sp_render_nf( nf_html, config ) {

			var nf_count			= 0;
			var interval_nf_count	= 0;
			var interval_last_nf	= -1;
			var nf_html				= $( nf_html );
			var last_nf				= ibwpl_sp_last_nf_data( config.id );

			if( last_nf > -1 ) {
				last_nf		= ( last_nf < nf_html.length ) ? last_nf : -1;
				nf_count	= ( nf_html.length > (last_nf + 1) ) ? (last_nf + 1) : nf_count;
			}

			/* Display first notification after initial time */
			setTimeout(function() {

				/* Show first notification */
				ibwpl_sp_show_nf( $( nf_html[nf_count] ), config, nf_count );

				setTimeout(function() {

					/* Hide notification when duration time is over */
					ibwpl_sp_hide_nf( $( nf_html[nf_count] ), config );

					/* Increase notification nf_count */
					nf_count++;

				}, config.display_time);

				/* Notification Interval
				 *
				 * Only start the interval when loop is enabled or remaining notification is there
				 */
				if( nf_html.length == 1 && config.loop == 0 ) {

				} else {

					if( (nf_count >= (nf_html.length - 1)) ) {
						interval_nf_count = 0;
					} else {
						interval_nf_count = (nf_count + 1);
					}
					interval_last_nf = ( last_nf >= 0 ) ? last_nf : (nf_html.length - 1);

					ibwpl_sp_nf_interval( nf_html, config, interval_nf_count, interval_last_nf );
				}

			}, config.initial_delay);
		}

		/* Notification Interval */
		function ibwpl_sp_nf_interval( nf_html, config, nf_count, last_nf ) {

			/* Render next notification */
			ibwp_nf_interval = setInterval(function() {

				/* Show next notification */
				ibwpl_sp_show_nf( $( nf_html[nf_count] ), config, nf_count );

				setTimeout(function() {

					/* Hide notification when duration time is over */
					ibwpl_sp_hide_nf( $( nf_html[nf_count] ), config );

					if ( ( nf_count >= nf_html.length - 1 ) || ( config.loop <= 0 && last_nf == nf_count ) ) {

						if ( config.loop <= 0 && last_nf == nf_count ) {
							clearInterval( ibwp_nf_interval );
						}
						nf_count = 0;

					} else {
						nf_count++;
					}

				}, config.display_time);

			}, (config.delay_between + config.display_time) );
		}

		/* Show Notification */
		function ibwpl_sp_show_nf( ele_wrap, config, nf_count ) {
			$('body').append( ele_wrap );

			if( ele_wrap.hasClass('ibwp-sp-nf-bottom-left') ) {

				if( ele_wrap.hasClass('ibwp-sp-nf-slide') ) {

					var animate_obj = {'bottom': '0', 'opacity': '1'};
				}
			}

			if( animate_obj ) {
				ele_wrap.animate(animate_obj, {
					queue		: false,
					duration	: 600,
				});
			}

			/* Function to save last notification */
			ibwpl_sp_last_nf_data( config.id, nf_count, 'set' );
		}

		/* Hide Notification */
		function ibwpl_sp_hide_nf( ele_wrap, config ) {

			var config = config ? config : false;

			if( ele_wrap.hasClass('ibwp-sp-nf-bottom-left') ) {

				if( ele_wrap.hasClass('ibwp-sp-nf-slide') ) {

					var animate_obj = {'bottom': '-150px', 'opacity': '1'};
				}
			}

			if( animate_obj ) {
				ele_wrap.animate(animate_obj, {
					queue		: false,
					duration	: 600,
					complete	: function() {
									ele_wrap.remove();
								}
				});
			}
		}

		/* Function to store last notification data (object) in local storage */
		function ibwpl_sp_last_nf_data( nf_id, nf_count, type ) {

			var get_last	= -1;
			var stored_data = '';
			nf_count 		= nf_count	? nf_count 	: 0;
			type 			= type		? type 		: 'get';

			/* Check browser support */
			if ( typeof(Storage) !== "undefined" && nf_id > 0 ) {

				if( type == 'set' ) {

					localStorage.setItem( 'ibwp_sp_nf_'+nf_id, nf_count );

				} else if( type == 'get' ) {

					get_last = localStorage.getItem( 'ibwp_sp_nf_'+nf_id );
					get_last = parseInt( get_last );
				}
			}

			return get_last;
		}
	});
})(jQuery);