(function($) {
	"use strict";

	$(document).ready(function() {

		$(".ibwp-wtcs-open-chat").on("click", function() {

			var url				= $(this).attr('data-href');
			var analytic_lbl	= $(this).attr('data-label');

			if( url != '' ) {

				if( IBWPL_WTCS.google_analytics == 1 ) {
					ibwpl_wtcs_google_analytics( analytic_lbl );
				}

				window.open(url, '_blank');
			}
		});

		$(".ibwp-wtcs-btn-popup").on("click", function() {
			if ( $(".ibwp-wtcs-chatbox").hasClass("ibwp-wtcs-active") ) { /* Close Chatbox */

				$(".ibwp-wtcs-chatbox").removeClass("ibwp-wtcs-active");
				$(this).removeClass("ibwp-wtcs-active");

			} else {

				$(this).addClass("ibwp-wtcs-active");
				$(".ibwp-wtcs-chatbox").addClass("ibwp-wtcs-active");

				if( IBWPL_WTCS.google_analytics == 1 ) {
					ibwpl_wtcs_google_analytics( 'IBWP - Chat Toggle' );
				}
			}
		});

		/* Open Chat - Short Link */
		$(document).on('click', '.ibwp-wtcs-open-chatbox', function() {
			if ( ! $(".ibwp-wtcs-chatbox").hasClass("ibwp-wtcs-active") ) {
				$(".ibwp-wtcs-btn-popup").trigger('click');
			}
			return false;
		});

		/* Esc key press */
		$(document).keyup(function(e) {
			if ( e.keyCode == 27 ) {
				if ( $(".ibwp-wtcs-chatbox").hasClass("ibwp-wtcs-active") ) {
					$(".ibwp-wtcs-btn-popup").trigger('click');
				}
			}
		});
	});

	/* Function to recored google analytics event */
	function ibwpl_wtcs_google_analytics( label = '' ) {

		label = label ? label : 'IBWP Chat Label';

		if( typeof(gtag) !== 'undefined' ) {
			gtag('event', 'IBWP Chat', {'event_category': 'IBWP', 'event_label': label});
		} else if( typeof(ga) !== 'undefined' ) {
			ga( 'send', 'event', 'IBWP', 'IBWP Chat', label );
		} else {
			console.log('Sorry, There is something wrong with analytics.');
		}
	}
})(jQuery);