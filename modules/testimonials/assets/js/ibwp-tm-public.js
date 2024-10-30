jQuery( document ).ready(function($) {
	
	/* Testimonial Slider */
	$( '.ibwp-tm-slidelist' ).each(function( index ) {

		var slider_id			= $(this).attr('id');
		var testimonial_conf	= $.parseJSON( $(this).closest('.ibwp-tm-slider-wrp').attr('data-conf'));

		if( typeof( slider_id ) != 'undefined' && slider_id != '' ) {
			
			jQuery('#'+slider_id).slick({
				
				infinite		: true,
				dots			: (testimonial_conf.dots)			== "true"	? true	: false,
				arrows			: (testimonial_conf.arrows)			== "true"	? true	: false,
				autoplay		: (testimonial_conf.autoplay)		== "true"	? true	: false,
				speed			: parseInt(testimonial_conf.speed),
				autoplaySpeed	: parseInt(testimonial_conf.autoplay_interval),
				slidesToShow	: parseInt(testimonial_conf.slides_column),
				slidesToScroll	: parseInt(testimonial_conf.slides_scroll),
				responsive		: [
								{
									breakpoint	: 1023,
									settings	: {
													slidesToShow	: ( parseInt( testimonial_conf.slides_column ) > 3 ) ? 3 : parseInt( testimonial_conf.slides_column ),
													slidesToScroll	: 1
												}
								},
								{
									breakpoint	: 767,
									settings	: {
													slidesToShow	: ( parseInt( testimonial_conf.slides_column ) > 2 ) ? 2 : parseInt( testimonial_conf.slides_column ),
													slidesToScroll	: 1
												}
								},
								{
									breakpoint	: 480,
									settings	: {
													slidesToShow	: 1,
													slidesToScroll	: 1
												}
								},
								{
									breakpoint	: 319,
									settings	: {
													slidesToShow	: 1,
													slidesToScroll	: 1
												}
								}]
			});
		}
	});

	/* Testimonial Widget */
	$( '.ibwp-tm-slide-widget' ).each(function( index ) {

		var slider_id   		= $(this).attr('id');
		var testimonial_conf 	= $.parseJSON( $(this).closest('.ibwp-tm-slider-wrp').attr('data-conf'));

		if( typeof( slider_id ) != 'undefined' && slider_id != '' ) {
			
			jQuery('#'+slider_id).slick({
				
				infinite		: true,
				dots			: (testimonial_conf.dots)				== "true"	? true	: false,
				arrows			: (testimonial_conf.arrows)				== "true"	? true	: false,
				autoplay		: (testimonial_conf.autoplay)			== "true"	? true	: false,
				autoplaySpeed	: parseInt(testimonial_conf.autoplay_interval),
				slidesToShow	: parseInt(testimonial_conf.slides_column),
				slidesToScroll	: parseInt(testimonial_conf.slides_scroll),
				responsive		: [
								{
									breakpoint	: 1023,
									settings	: {
													slidesToShow	: ( parseInt( testimonial_conf.slides_column ) > 3 ) ? 3 : parseInt( testimonial_conf.slides_column ),
													slidesToScroll	: 1
												}
								},
								{
									breakpoint	: 767,
									settings	: {
													slidesToShow	: ( parseInt( testimonial_conf.slides_column ) > 2 ) ? 2 : parseInt( testimonial_conf.slides_column ),
													slidesToScroll	: 1
												}
								},
								{
									breakpoint	: 480,
									settings	: {
													slidesToShow	: 1,
													slidesToScroll	: 1
												}
								},
								{
									breakpoint	: 319,
									settings	: {
													slidesToShow	: 1,
													slidesToScroll	: 1
												}
								}]
			});
		}
	});
});