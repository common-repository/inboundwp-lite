jQuery( document ).ready(function( $ ) {

	/* Tooltip */
	ibwpl_tooltip();

	/* Media Uploader */
	$( document ).on( 'click', '.ibwp-image-upload', function() {

		var imgfield,sizefield,showfield;
		imgfield = jQuery(this).prev('input').attr('id');
		sizefield = jQuery(this).attr('data-image-size');
		showfield = jQuery(this).closest('td').find('.ibwp-img-view');

		if(typeof wp == "undefined" || IBWPLAdmin.new_ui != '1' ){ /* Check for media uploader */

			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			
			window.original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html) {
				
				if(imgfield) {
					
					var mediaurl = $('img',html).attr('src');
					$('#'+imgfield).val(mediaurl);
					showfield.html('<img src="'+mediaurl+'" />');
					tb_remove();
					imgfield = '';
					
				} else {
					
					window.original_send_to_editor(html);
					
				}
			};
			return false;
			
			  
		} else {
			
			var file_frame;
			
			/* new media uploader */
			var button = jQuery(this);        
			/* If the media frame already exists, reopen it. */
			if ( file_frame ) {
				file_frame.open();
			  return;
			}
	
			/* Create the media frame. */
			file_frame = wp.media.frames.file_frame = wp.media({
				frame: 'post',
				state: 'insert',
				title: button.data( 'uploader-title' ),
				button: {
					text: button.data( 'uploader-button-text' ),
				},
				multiple: false  /* Set to true to allow multiple files to be selected */
			});
	
			file_frame.on( 'menu:render:default', function(view) {
				/* Store our views in an object. */
				var views = {};
	
				/* Unset default menu items */
				view.unset('library-separator');
				view.unset('gallery');
				view.unset('featured-image');
				view.unset('embed');
	
				/* Initialize the views in our view object. */
				view.set(views);
			});
	
			/* When an image is selected, run a callback. */
			file_frame.on( 'insert', function() {
	
				/* Get selected size from media uploader */
				if( typeof sizefield != "undefined" ) {
					var selected_size = sizefield;
				} else {
					var selected_size = $('.attachment-display-settings .size').val();
				}
				
				var selection = file_frame.state().get('selection');
				selection.each( function( attachment, index ) {
					attachment = attachment.toJSON();
					
					/* Selected attachment url from media uploader */
					var attachment_url = attachment.sizes[selected_size].url;

					if(index == 0){
						/* place first attachment in field */
						$('#'+imgfield).val(attachment_url);
						showfield.html('<img src="'+attachment_url+'" />');
						
					} else{
						$('#'+imgfield).val(attachment_url);
						showfield.html('<img src="'+attachment_url+'" />');
					}
				});
			});
	
			/* Finally, open the modal */
			file_frame.open();
		}
	});
	
	/* Clear Media */
	$( document ).on( 'click', '.ibwp-image-clear', function() {
		$(this).closest('td').find('.ibwp-img-upload-input').val('');
		$(this).closest('td').find('.ibwp-img-view').html('');
	});

	/* Toggle Settings Boxes */
	$(".ibwp-sett-wrap .hndle, .ibwp-sett-wrap .handlediv").click(function() {
		$(this).closest('.postbox:not(.ibwp-no-toggle)').toggleClass('closed');
	});

	$(".ibwp-dashboard-wrap .ibwp-module-check").click( function() {

		var cls_ele = $(this).closest('.ibwp-site-module-wrap');

		if( $(this).is(':checked') ) {
			cls_ele.addClass('ibwp-site-module-active');
		} else {
			cls_ele.removeClass('ibwp-site-module-active');
		}
		cls_ele.find('.ibwp-site-module-conf-wrap').slideToggle();
	});

	/* Show save notice */
	$('.ibwp-dashboard-wrap .ibwp-module-cnt-wrp').find('input:not(.ibwp-no-chage), select:not(.ibwp-no-chage), textarea:not(.ibwp-no-chage), checkbox:not(.ibwp-no-chage)').bind('keydown change', function(){

		var anim_bottom = '50px';
		if( IBWPLAdmin.is_mobile == 1 ) {
			anim_bottom = 0;
		}

		$('.ibwp-save-info-wrap').show().animate({bottom: anim_bottom}, 500);
		$('.ibwp-save-info-wrap .ibwp-save-notify-btn').focus();
	});

	/* Hide save notice */
	$(document).on('click', '.ibwp-save-info-wrap .ibwp-save-info-close', function(){
		$(this).closest('.ibwp-save-info-wrap').fadeOut( "slow", function() {
			$(this).css({bottom:''});
		});
	});

	/* Search Toggle */
	$(document).on('click', '.ibwp-dashboard-search-icon', function(e) {
		e.preventDefault();
		var cls_ele = $(this).closest('.ibwp-dashboard-header');

		cls_ele.find('.ibwp-dashboard-search-wrap').stop().slideToggle();
		cls_ele.find('.ibwp-dashboard-search').val('').focus().trigger('keyup');

		$('.ibwp-no-module-search').hide();
	});

	/* Esc key press */
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {

			var sort_cat_val = $('.ibwp-module-sort-cat').val();

			$('.ibwp-no-module-search').hide();
			$('.ibwp-dashboard-header .ibwp-dashboard-search-wrap').slideUp();

			if( sort_cat_val ) {
				$('.ibwp-site-modules-wrap .ibwp-site-module-'+sort_cat_val).fadeIn();
			} else {
				$('.ibwp-site-modules-wrap .ibwp-site-module-wrap').fadeIn();
			}

			/* Hide popup box */
			ibwpl_hide_popup();
			ibwpl_hide_popup_modal();
		}
	});

	/* Open search with key event */
	$(window).on('keydown', function (event) {
		if ( (event.ctrlKey || event.metaKey) && (String.fromCharCode(event.which).toLowerCase() == 'f') && $('.ibwp-dashboard-wrap').length ) {
			if( $('.ibwp-dashboard-header .ibwp-dashboard-search-wrap').is(':visible') ) {
				$('.ibwp-dashboard-search-icon').trigger('click');                
			} else {
				$('.ibwp-dashboard-search-icon').trigger('click');
				return false;
			}
		}
	});

	var timer;
	var timeOut = 300; /* delay after last keypress to execute filter */

	/* Module Search */
	$('.ibwp-dashboard-search').keyup(function(event) {

		/* If element is focused and esc key is pressed */
		if (event.keyCode == 27) {
			return true;
		}

		clearTimeout(timer); /* if we pressed the key, it will clear the previous timer and wait again */
		timer = setTimeout(function() {

			var search_value    = $('.ibwp-dashboard-search').val().toLowerCase();
			var sort_cat_val    = $('.ibwp-module-sort-cat').val();
			var loop_part       = $('.ibwp-site-modules-wrap .ibwp-site-module-wrap');
			var zebra = 'odd';

			if( sort_cat_val ) {
				loop_part = $('.ibwp-site-modules-wrap .ibwp-site-module-'+sort_cat_val);
			}

			loop_part.each(function(index) {

				var contents = $(this).find('.ibwp-site-module-title span').html().toLowerCase();
				var desc_cnt = $(this).find('.ibwp-site-module-desc').html().toLowerCase();

				if (contents.indexOf(search_value) !== -1 || desc_cnt.indexOf(search_value) !== -1) {
					$(this).fadeIn('slow');

					if (zebra == 'odd') {
						zebra = 'even';
					} else {
						zebra = 'odd';
					}
				} else {
					$(this).hide();
				}
			});

			if( $('.ibwp-site-modules-wrap .ibwp-site-module-wrap:visible').length <= 0 ) {
				$('.ibwp-no-module-search').fadeIn();
			} else {
				$('.ibwp-no-module-search').hide();
			}

			/* Modifying page URL so search param will be there */
			if( search_value ) {
				search_url  = IBWPLAdmin.module_search_url+'&search='+encodeURIComponent(search_value);
				window.history.pushState( null, null, search_url );
			} else {
				window.history.pushState( null, null, IBWPLAdmin.module_search_url );
			}

		}, timeOut);
	});

	/* Vertical Tab */
	$( document ).on( "click", ".ibwp-vtab-nav a", function() {

		$(".ibwp-vtab-nav").removeClass('ibwp-active-vtab');
		$(this).parent('.ibwp-vtab-nav').addClass("ibwp-active-vtab");

		var selected_tab = $(this).attr("href");
		$('.ibwp-vtab-cnt').hide();

		/* Show the selected tab content */
		$(selected_tab).show();

		/* Pass selected tab */
		$('.ibwp-selected-tab').val(selected_tab);
		return false;
	});

	/* Horizontal Tab (Work For WordPress Tab Also) */
	$( document ).on( "click", ".ibwp-htab-nav a", function() {

		var tab_type        = $(this).closest('.ibwp-htab-nav').attr('data-tab');
		var tab_active_cls  = ( tab_type == 'wp' ) ? 'nav-tab-active' : 'ibwp-htab-active';

		$(".ibwp-htab-nav").removeClass( tab_active_cls );
		$(".ibwp-htab-nav a").removeClass( tab_active_cls );

		if( tab_type == 'wp' ) {
			 $(this).addClass( tab_active_cls );
		} else {
			$(this).parent('.ibwp-htab-nav').addClass( tab_active_cls );
		}

		$(".ibwp-htab-cnt").hide();

		var selected_tab = $(this).attr("href");
		$(selected_tab).show();

		$('.ibwp-selected-tab').val(selected_tab);
		return false;
	});

	/* Remain selected tab for user */
	if( $('.ibwp-selected-tab').length > 0 ) {
		
		var sel_tab = $('.ibwp-selected-tab').val();
		
		if( typeof(sel_tab) !== 'undefined' && sel_tab != '' && $(sel_tab).length > 0 ) {
			$('.ibwp-vtab-nav [href="'+sel_tab+'"]').click();
			$('.ibwp-htab-nav [href="'+sel_tab+'"]').click();
		} else {
			$('.ibwp-vtab-nav:first-child a').click();
			$('.ibwp-htab-nav:first-child a').click();
		}
	}

	/* Module category filter */
	$( document ).on( 'change', '.ibwp-module-sort-cat', function() {
		var ele_val = $(this).val();

		$('.ibwp-dashboard-search').val('');
		$('.ibwp-no-module-search').hide();

		/* MixItUp plugin */
		var filter_val = ele_val ? '.ibwp-site-module-'+ele_val : '.ibwp-site-module-wrap';
		if( $(filter_val).length > 0 ) {
			$('.ibwp-site-modules-inr-wrap').mixItUp('filter', filter_val);
		}
	});

	/* MixItUp plugin */
	if( $('.ibwp-site-modules-inr-wrap').length > 0 ) {
		$('.ibwp-site-modules-inr-wrap').mixItUp({
			selectors: {
				target: '.ibwp-site-module-wrap',
			}
		});
	}

	/* On change of checkbox */
	$( document ).on( 'change', '.ibwp-show-hide', function() {

		var prefix		= $(this).attr('data-prefix');
		var inp_type	= $(this).attr('type');
		var showlabel	= $(this).attr('data-label');

		if(typeof(showlabel) == 'undefined' || showlabel == '' ) {
			showlabel = $(this).val();
		}

		if( prefix ) {
			showlabel = prefix +'-'+ showlabel;
			$('.ibwp-show-hide-row-'+prefix).hide();
			$('.ibwp-show-for-all-'+prefix).show();
		} else {
			$('.ibwp-show-hide-row').hide();
			$('.ibwp-show-for-all').show();
		}

		$('.ibwp-show-if-'+showlabel).hide();
		$('.ibwp-hide-if-'+showlabel).hide();

		if( inp_type == 'checkbox' || inp_type == 'radio' ) {
			if( $(this).is(":checked") ) {
				$('.ibwp-show-if-'+showlabel).show();
			} else {
				$('.ibwp-hide-if-'+showlabel).show();
			}
		} else {
			$('.ibwp-show-if-'+showlabel).show();
		}
	});

	/* Reset Settings Button */
	$( document ).on( 'click', '.ibwp-reset-sett', function() {
		var ans;
		ans = confirm(IBWPLAdmin.reset_msg);

		if(ans) {
			return true;
		} else {
			return false;
		}
	});

	/* Comman cofirm alert box */
	$(document).on('click', '.ibwp-confirm', function(e) {
		
		var msg	= $(this).attr('data-msg');
		msg 	= msg ? msg : IBWPLAdmin.cofirm_msg;
		
		var ans = confirm(msg);

		if(ans) {
			return true;
		} else {
			return false;
		}
	});

	/* Color Picker */
	if( $('.ibwp-colorpicker').length > 0 ) {
		$('.ibwp-colorpicker').wpColorPicker();
	}

	/* Initialize Datetimepicker */
	if( $('.ibwp-datetime').length > 0 ) {
		$('.ibwp-datetime').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'HH:mm:ss',
			minDate: 0,
			changeMonth: true,
			changeYear: true,
		});
	}

	/* Initialize DatePicker */
	if( $('.ibwp-date').length > 0 ) {
		$('.ibwp-date').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	}

	/* Click to Copy the Text */
	$(document).on('click', '.ibwp-copy-clipboard', function() {
		var copyText = $(this);
		copyText.select();
		document.execCommand("copy");
	});

	$(document).on('keypress', '.ibwp-number-input', function(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	});

	/* Report Setting Custom Date Range JS */
    $(document).on('change', '.ibwp-date-range-filter', function() {
        var selected_date = $(this).val();

        $('.ibwp-date-range-field').hide();
        $('.ibwp-report-form .ibwp-date-field').val('');

        if( selected_date == 'other' ) {
            $('.ibwp-date-range-field').show();
        }
    });

    /* Close Popup */
	$(document).on('click', '.ibwp-popup-close', function() {
		ibwpl_hide_popup();
		ibwpl_hide_popup_modal();
	});

	/* Process Entries Export */
	$(document).on('submit', '.ibwp-tools-form', function(e) {

		e.preventDefault();

		var obj_ele			= $(this);
		var submitbutton	= obj_ele.find( 'input[type="submit"]' );

		if ( ! submitbutton.hasClass( 'button-disabled' ) ) {

			submitbutton.addClass( 'button-disabled' );

			obj_ele.find('.notice-wrap').remove();
			obj_ele.append( '<div class="notice-wrap"><span class="spinner is-active"></span><div class="ibwp-progress"><div></div></div></div>' );

			obj_ele.find('.ibwp-progress-wrap').show();
			obj_ele.find('.ibwp-progress-wrap .ibwp-progress-strip').css('width', 0);

			ibwpl_export_entries( null, obj_ele );
		}
		return false;
	});

	/* Show Preview Popup Modal - Start */
	$(document).on('click', '.ibwp-show-popup-modal', function() {

		var curr_ele	= $(this);
		var preview		= $(this).attr('data-preview');
		var main_ele	= $('.ibwp-popup-modal');
		main_ele.find('.ibwp-popup-modal-loader').show();

		$('.ibwp-popup-modal').show();
		$('.ibwp-popup-modal-overlay').show();
		$('body').addClass('ibwp-no-overflow');

		if( preview == 1 ) {

			if( typeof(tinyMCE) != 'undefined' ) {
				tinyMCE.triggerSave();
			}

			var form_data 				= $('form#post').serialize();
			var preview_frame_data_src	= main_ele.find('.ibwp-preview-frame').attr('data-src');
			var preview_frame_src		= main_ele.find('.ibwp-preview-frame').attr('src');

			if( preview_frame_src != preview_frame_data_src ) {
				main_ele.find('.ibwp-preview-frame').attr('src', preview_frame_data_src);
			}

			$('body').append('<form action="'+preview_frame_data_src+'" method="post" class="ibwp-preview-form" id="ibwp-preview-form" target="ibwp_preview_frame"></form>');
			$('#ibwp-preview-form').append('<input type="hidden" name="ibwp_preview_form_data" value="'+form_data+'" />');
			$('#ibwp-preview-form').submit();
			$('#ibwp-preview-form').remove();

		} else {
			main_ele.find('.ibwp-popup-modal-loader').fadeOut();
		}

		return false;
	});

	$('.ibwp-popup-modal').find('.ibwp-preview-frame').load(function () {
		$('.ibwp-popup-modal').find('.ibwp-popup-modal-loader').fadeOut();
	});
	/* Show Preview Popup Modal - End */

	/* Tweak - To display preview link in admin bar menu */
	if( $('.ibwp-module-preview-btn').length > 0 ) {

		var curr_ele	= $('.ibwp-module-preview-btn');
		var preview		= curr_ele.attr('data-preview');
		var btn_text	= curr_ele.text();

		if( preview == 1 ) {
			$('#wpadminbar').find('#wp-admin-bar-ibwp-menu').after('<li id="wp-admin-bar-ibwp-preview-menu" class="ibwp-show-popup-modal" data-preview="1"><div class="ab-item ab-empty-item">'+btn_text+'</div></li>');
		}
	}
});

/* Function to hide popup */
function ibwpl_hide_popup() {
	jQuery('.ibwp-popup-data-wrp').hide();
	jQuery('.ibwp-popup-overlay').hide();
	jQuery('body').removeClass('ibwp-no-overflow');

	if( jQuery('.ibwp-popup-data-wrp').attr('data-flush') ) {
		jQuery('.ibwp-popup-data-wrp .ibwp-popup-body-wrp').html('');
	}
}

/* Function to hide preview popup modal */
function ibwpl_hide_popup_modal() {
	jQuery('.ibwp-popup-modal').hide();
	jQuery('.ibwp-popup-modal-overlay').hide();
	jQuery('body').removeClass('ibwp-no-overflow');
}

(function($) {
	/* When Page is fully loaded */
	$( window ).load(function() {

		setTimeout(function() {
			var module_search = ibwpl_get_url_parameter('search');
			if( typeof(module_search) !== 'undefined' && module_search != '' ) {
				$('.ibwp-dashboard-search-icon').trigger('click');
				$('.ibwp-dashboard-search').val(module_search).trigger('keyup');
			}
		}, 610);

		/* Initialize Select 2 */
		if( $('.ibwp-select2').length > 0 ) {

			$('.ibwp-select2').select2({
			});

			/* Ajax suggest post title based on post type */
			$('.ibwp-post-title-sugg').each(function() {

				var cls_ele	= $(this).closest('.ibwp-report-form-wrp');
				var meta_data		= $(this).attr('data-meta');
				var nonce			= $(this).attr('data-nonce');
				var post_type_attr	= $(this).attr('data-post-type');
				var predefined		= $(this).attr('data-predefined');

				$(this).select2({
					ajax: {
						url				: ajaxurl,
						dataType		: 'json',
						delay			: 500,
						data			: function ( params ) {
											var search_term	= $.trim( params.term );
											var post_type	= post_type_attr ? post_type_attr : cls_ele.find('.ibwp-post-type-sugg').val();

											delay: 0;

											return {
												action		: 'ibwpl_post_title_sugg',
												search		: search_term,
												post_type	: post_type,
												meta_data	: meta_data,
												nonce		: nonce
											};
										},
						processResults	: function( data ) {
											var options = [];

											if( predefined ) {
												options = JSON.parse( predefined );
												options = $.makeArray(options);
											}

											if ( data ) {
												$.each( data, function( index, text ) {
													options.push( { id: text[0], text: text[1]  } );
												});
											}
											return {
												results: options
											};
										},
						cache			: true
					},
					minimumInputLength	: 1,
					allowClear: true,
				});
			});
		}

		/* WP Code Editor */
		if( IBWPLAdmin.syntax_highlighting == 1 ) {
			jQuery('.ibwp-code-editor').each( function() {
				
				var cur_ele		= jQuery(this);
				var data_mode	= cur_ele.attr('data-mode');
				data_mode		= data_mode ? data_mode : 'css';

				var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
				editorSettings.codemirror = _.extend(
					{},
					editorSettings.codemirror,
					{
						indentUnit: 2,
						tabSize: 2,
						mode: data_mode,
					}
				);
				var editor = wp.codeEditor.initialize( cur_ele, editorSettings );

				editor.codemirror.on( 'change', function( codemirror ) {
					cur_ele.val( codemirror.getValue() ).trigger( 'change' );
				});

				/* When post metabox is toggle */
				$(document).on('postbox-toggled', function( event, ele ) {
					if( $(ele).hasClass('closed') ) {
						return;
					}

					if( $(ele).find('.ibwp-code-editor').length > 0 ) {
						editor.codemirror.refresh();
					}
				});

				/* When setting tab is opened */
				$(document).on('click', '.ibwp-vtab-nav a', function() {

					var selected_tab = $(this).attr("href");

					if( $(selected_tab).find('.ibwp-code-editor').length > 0 ) {
						editor.codemirror.refresh();
					}
				});
			});
		}

		/* Save Dat on Ctrl + S - Start */
		if( adminpage == 'post-php' ) {
			var save_btn = $('#publish');
		} else {
			var save_btn = $('.ibwp-sett-submit');
		}

		if( save_btn.length > 0 ) {
			$(window).on('keydown', function(event) {
				if ( (event.ctrlKey || event.metaKey) && (String.fromCharCode(event.which).toLowerCase() == 's') ) {

					event.preventDefault();
					save_btn.trigger('click');
					return false;
				}
			});
		}
		/* Save Dat on Ctrl + S - End */
	});
})(jQuery);

/* Tooltip */
function ibwpl_tooltip() {
	if( jQuery('.ibwp-tooltip').length > 0 ) {
		jQuery('.ibwp-tooltip').each( function( attachment, index ) {

			if( jQuery(this).hasClass('tooltipstered') ) {
				return;
			}

			var tooltip_cnt			= jQuery(this).attr('data-tooltip-content');
			var tooltip_theme		= jQuery(this).attr('data-tooltip-theme');
			var tooltip_side		= jQuery(this).attr('data-tooltip-side');
			var tooltip_min_width	= jQuery(this).attr('data-tooltip-min-width');
			
			tooltip_cnt			= ( jQuery(tooltip_cnt).length > 0 ) ? jQuery(tooltip_cnt) : null;
			tooltip_theme		= tooltip_theme     ? tooltip_theme     : 'ibwp-tooltipster tooltipster-punk';
			tooltip_side		= tooltip_side      ? tooltip_side      : 'top';
			tooltip_min_width	= tooltip_min_width ? tooltip_min_width : false;

			jQuery(this).tooltipster({
				maxWidth: 500,
				content: tooltip_cnt,
				contentCloning: true,
				animation: 'grow',
				theme: tooltip_theme,
				interactive: true,
				repositionOnScroll: true,
				minWidth: tooltip_min_width,
				side:tooltip_side,
				trigger: (IBWPLAdmin.is_mobile == 1) ? 'click' : 'hover',
			});
		});
	}
}

/* Initialize WP_Editor */
function ibwpl_init_wp_editor() {

	jQuery('.ibwp-wp-editor').each(function() {

		var media_btn	= jQuery( this ).attr('data-media-button');
		var editor_id	= jQuery( this ).attr('id')+'-'+(Math.floor((Math.random() * 99999) + 1))+'-'+jQuery.now();
		jQuery( this ).attr( 'id', editor_id );
		jQuery( this ).removeClass( 'ibwp-wp-editor' );

		wp.editor.initialize( editor_id, {
				tinymce: {
					wpautop     : true,
					plugins     : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview fullscreen',
					toolbar1    : 'formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link unlink wp_more',
					toolbar2    : 'strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help'
				},
				quicktags: {
					buttons: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close'
				},
				mediaButtons: media_btn ? true : false
		});
	});
}

function ibwpl_get_url_parameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		result,
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			result = sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			return result.replace(/\+/g, ' ');
		}
	}
}

/* Common alert message function */
function ibwpl_confirm( msg ) {
	var msg = msg ? msg : IBWPLAdmin.cofirm_msg;
	var ans	= confirm(msg);

	if( ans ) {
		return true;
	} else {
		return false;
	}
}

/* Function to generate CSV for form entries */
function ibwpl_export_entries( data, obj_ele ) {

	if( ! data ) {
		var form_data	= obj_ele.serialize();
		var data		= {
			action			: 'ibwpl_do_export_action',
			form_data		: form_data,
			page			: 1,
			is_ajax			: 1,
		};
	}

	jQuery.post(ajaxurl, data, function(result) {

		var notice_wrap = obj_ele.find('.notice-wrap');

		if( result.status == 0 ) {

			notice_wrap.html('<div class="updated error"><p>' + result.message + '</p></div>');
			obj_ele.find('.button-disabled').removeClass('button-disabled');

		} else {

			jQuery('.ibwp-progress div').animate({
				width: result.percentage + '%',
			}, 50, function() {

			});

			/* If data is there then process again */
			if( result.data_process != 0 && ( result.data_process < result.total_count ) ) {
				data['page']            = result.page;
				data['total_count']     = result.total_count;
				data['data_process']    = result.data_process;
				ibwpl_export_entries( data, obj_ele );
			}

			/* If process is done */
			if( result.data_process >= result.total_count ) {

				notice_wrap.html('<div id="ibwp-batch-success" class="updated notice"><p>' + result.message + '</p></div>');
				obj_ele.find('.button-disabled').removeClass('button-disabled');

				if( result.url ) {
					window.location = result.url;
				}
			}
		}
	});
}