<?php
add_action( 'wp-routes/register_routes', function () {
	// no required plugins? no party.
	global $todomvc;
	if ( ! $todomvc->requirements ) {
		return;
	}
} );
