jQuery(document).ready(function($) {

	var simple_par 	= $('.dcdt-countdown-timer-simple').find('.dcdt-timer-digits');
	simple_par.after('<i>:</i>');
	var slenght = $('.dcdt-countdown-timer-simple').find('.ce-col');
	slenght.find('i').last().remove();

	// Circle, Circle-Fill JS
	$( '.dcdt-countdown-timer-cf' ).each(function( index ) {

		var current_obj     = $(this);
		var clock_id		= current_obj.attr('data-id');
		var date_id			= current_obj.attr('id');
		var product_id		= current_obj.attr('data-product');
		var date_id			= date_id+ ' .dcdt-clock';

		var date_conf 		= $.parseJSON( current_obj.find('.dcdt-date-conf').attr('data-conf'));
		var is_days 		= date_conf.is_days;
		var is_hours 		= date_conf.is_hours;
		var is_minutes 		= date_conf.is_minutes;
		var is_seconds 		= date_conf.is_seconds;
		var days_text 		= date_conf.days_text;
		var hours_text 		= date_conf.hours_text;
		var minutes_text 	= date_conf.minutes_text;
		var seconds_text 	= date_conf.seconds_text;
		var diff_date   	= date_conf.diff_date;
		var current_date	= date_conf.current_date;
		var timeZone 		= date_conf.timezone;

		$("#"+date_id).DcdtClock({
			day				: diff_date['day'],
			month			: diff_date['month'],
			year			: diff_date['year'],
			hour			: diff_date['hour'],
			minute			: diff_date['min'],
			second			: diff_date['second'],
			currentDateTime	: current_date,
			timeZone		: (timeZone != '')		? parseFloat(timeZone) 	: parseFloat(timezone),
			daysLabel		: (days_text != '')		? days_text				: 'Days',
			hoursLabel		: (hours_text != '')	? hours_text			: 'Hours',
			minutesLabel	: (minutes_text != '')	? minutes_text			: 'Minutes',
			secondsLabel	: (seconds_text != '')	? seconds_text			: 'Seconds',
			daysWrapper		: '.ce-days .ce-flip-back',
			hoursWrapper	: '.ce-hours .ce-flip-back',
			minutesWrapper	: '.ce-minutes .ce-flip-back',
			secondsWrapper	: '.ce-seconds .ce-flip-back',
			wrapDigits		: false,
			onComplete: function() {
				dcdt_timer_over( product_id );
			},
			onChange: function() {
				dcdt_animate_timer_cfsf($('.dcdt-clock .ce-col > div'), this);
			}
		});

		/* Fallback for Internet Explorer */
		if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
			$('html').addClass('internet-explorer');
		}
	});
});

/* Timer Animation */
function dcdt_animate_timer_cfsf($el, data) {
	$el.each( function(index) {
		var $this = jQuery(this),
			$flipFront = $this.find('.ce-flip-front'),
			$flipBack = $this.find('.ce-flip-back'),
			field = $flipBack.text(),
			fieldOld = $this.attr('data-old');
		if (typeof fieldOld === 'undefined') {
			$this.attr('data-old', field);
		}
		if (field != fieldOld) {
			$this.addClass('ce-animate');
			window.setTimeout(function() {
				$flipFront.text(field);
				$this
					.removeClass('ce-animate')
					.attr('data-old', field);
			}, 800);
		}
	});
}

/* Simple Clock Animation */
function dcdt_simple_animate_timer($el) {
	$el.each( function(index) {
		var $this		= jQuery(this),
			fieldText	= $this.text(),
			fieldData	= $this.attr('data-value'),
			fieldOld	= $this.attr('data-old');

		if (typeof fieldOld === 'undefined') {
			$this.attr('data-old', fieldText);
		}

		if (fieldText != fieldData) {

			$this
				.attr('data-value', fieldText)
				.attr('data-old', fieldData)
				.addClass('ce-animate');

			window.setTimeout(function() {
				$this
					.removeClass('ce-animate')
					.attr('data-old', fieldText);
			}, 300);
		}
	});
}

// Timer over then  remove sale price and timer and progress 
function dcdt_timer_over( product_id ) {
	
	if( product_id ){

		var data 	= {
				'action'	: 'ibwpl_dcdt_on_time_done',
				'post_id'	: product_id
			};

		jQuery.post( ibwp_ajaxurl, data, function(response) {
			if( response.success ) {
					location.reload();
			} 
		});
	}	
}