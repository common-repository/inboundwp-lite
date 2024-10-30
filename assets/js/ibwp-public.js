/* Create Cookie */
function ibwpl_create_cookie(name, value, time_val, type) {
	var date, expires;

	time_val	= time_val	? time_val	: false;
	type		= type		? type		: 'day';

	if( type == 'hour' ) {
		expire_time = (time_val * 60 * 60 * 1000);

	} else if( type == 'minutes' ) {
		expire_time = (time_val * 60 * 1000);

	} else {
		expire_time = (time_val * 24 * 60 * 60 * 1000);
	}

	if ( time_val ) {
		date = new Date();
		date.setTime( date.getTime() + expire_time );
		expires = "; expires="+date.toGMTString();
	} else {
		expires = "";
	}
	document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

/* Check Valid Email */
function ibwpl_check_email( email ) {

	var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
	return pattern.test( email );
}