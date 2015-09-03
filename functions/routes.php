<?php
add_action( 'wp-routes/register_routes', function () {
	// Add a new todo
	respond( 'POST', '/tasks', function ( $request, $response ) {
		if ( empty( $_REQUEST['task-title'] ) ) {
			return;
		}
		$id = wp_insert_post( [
			'post_title'  => $_REQUEST['task-title'],
			'post_type'   => 'task',
			'post_status' => 'active'
		] );

		if ( empty( $id ) ) {
			return;
		}
		$response->header( 'X-IC-Trigger', 'todomvc/new-task-added' );
		todomvc_the_list();
	} );
} );
