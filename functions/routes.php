<?php
/**
 * @param $response
 */
function todomvc_maybe_hide( $response ) {
	if ( empty( get_posts( [
		'fields'      => 'ids',
		'post_type'   => 'task',
		'post_status' => [ 'active', 'completed' ]
	] ) )
	) {
		$response->header( 'X-IC-Trigger', 'todomvc/hide' );
	}
}

add_action( 'wp-routes/register_routes', function () {
	// All the tasks
	respond( 'GET', '/tasks', function ( $request, $response ) {
		if ( ! isset( $_REQUEST['status'] ) ) {
			$_REQUEST['status'] = [ 'active', 'completed' ];
		} else {
			$_REQUEST['status'] = is_array( $_REQUEST['status'] ) ? $_REQUEST['status'] : [ $_REQUEST['status'] ];
		}

		$status = array_intersect( $_REQUEST['status'], [ 'active', 'completed' ] );

		todomvc_the_list();
	} );

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

	// Change a todo status
	respond( 'PUT', '/tasks/[i:id]', function ( $request ) {
		if ( ! get_post( $request->id ) ) {
			return;
		}
		$post = get_post( $request->id );
		if ( ! $post ) {
			return;
		}
		$new_status = $post->post_status == 'completed' ? 'active' : 'completed';
		$id         = wp_update_post( [ 'ID' => $request->id, 'post_status' => $new_status ] );
		if ( $id === false ) {
			return;
		}

		clean_post_cache( $request->ID );
		todomvc_the_list();
	} );

	// Mark all
	respond( 'PUT', '/tasks', function () {
		if ( ! isset( $_REQUEST['status-all'] ) || ! in_array( $_REQUEST['status-all'], [ 'active', 'completed' ] ) ) {
			return;
		}
		/** @var \wpdb $wpdb */
		global $wpdb;
		$ok = $wpdb->update( $wpdb->posts, [ 'post_status' => $_REQUEST['status-all'] ], [ 'post_type' => 'task' ] );
		if ( ! $ok ) {
			return;
		}
		todomvc_the_list();
	} );

	// Delete a todo
	respond( 'DELETE', '/tasks/[i:id]', function ( $request, $response ) {
		if ( ! get_post( $request->id ) ) {
			return;
		}
		$id = wp_delete_post( $request->id );
		if ( $id === false ) {
			return;
		}


		todomvc_maybe_hide( $response );
		todomvc_the_list();
	} );

	// Delete all tasks
	respond( 'DELETE', '/tasks', function ( $request, $response ) {
		$status = isset( $_REQUEST['status'] ) && in_array( $_REQUEST['status'], [ 'active', 'completed' ] );
		if ( ! $status ) {
			return;
		}
		$status = $_REQUEST['status'];
		/** @var \wpdb $wpdb */
		global $wpdb;
		$ok = $wpdb->delete( $wpdb->posts, [ 'post_type' => 'task', 'post_status' => $status ] );
		// Either an error or no tasks removed
		if ( ! $ok ) {
			return;
		}

		todomvc_maybe_hide( $response );
		todomvc_the_list();
	} );
} );
