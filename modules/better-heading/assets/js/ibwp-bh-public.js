jQuery( document ).ready(function($) {

	var click_flag = ibwpl_bh_check_click_data( IBWPL_BH_Public.post_id );

	if( IBWPL_BH_Public.post_id != 0 && ! click_flag ) {

		var data = {
			action		: 'ibwpl_bh_process_title_click',
			post_id 	: IBWPL_BH_Public.post_id,
			post_type 	: IBWPL_BH_Public.post_type
		};

		jQuery.post(ibwp_ajaxurl, data, function(response) {

			if( response.success == 1 ) {
				ibwpl_bh_store_click_data( IBWPL_BH_Public.post_id );
			}
		});
	}
});

/* Function to store post click data in browser */
function ibwpl_bh_store_click_data( post_id = 0 ) {

	/* Check browser support */
	if (typeof(Storage) !== "undefined") {

		var stored_data	= '';
		var stored_obj	= {};
		var post_ids	= sessionStorage.getItem('ibwp_bh_posts_clicks');

		if( typeof(post_ids) != 'undefined' && post_ids != null ) {
			stored_obj = JSON.parse( post_ids );
		}

		stored_obj[post_id] = post_id;
		stored_data = JSON.stringify( stored_obj );

		sessionStorage.setItem( 'ibwp_bh_posts_clicks', stored_data );
	}
}

/* Function to check post click data */
function ibwpl_bh_check_click_data( post_id = 0 ) {
	
	/* Check browser support */
	if (typeof(Storage) !== "undefined") {

		var stored_obj	= {};
		var post_ids	= sessionStorage.getItem('ibwp_bh_posts_clicks');

		if( typeof(post_ids) != 'undefined' && post_ids != null ) {
			stored_obj = JSON.parse( post_ids );
		}
	}

	if ( stored_obj.hasOwnProperty( post_id ) ) {
		return true;
	}

	return false;
}