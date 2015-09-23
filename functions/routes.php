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

/**
 * @return mixed|void
 */
function todomvc_current_view() {
	return get_option( 'todomvc_view_status', [ 'active', 'completed' ] );
}

add_action( 'wp-routes/register_routes', function () {
	// All the tasks
	respond( 'GET', '/tasks', function ( $request, $response ) {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'todo-mvc' ) ) {
			return;
		}
		if ( ! isset( $_REQUEST['status'] ) ) {
			$_REQUEST['status'] = [ 'active', 'completed' ];
		} else {
			$_REQUEST['status'] = is_array( $_REQUEST['status'] ) ? $_REQUEST['status'] : [ $_REQUEST['status'] ];
		}

		$status = array_intersect( $_REQUEST['status'], [ 'active', 'completed' ] );

		update_option( 'todomvc_view_status', $status );

		todomvc_the_list( $status );
	} );

	// Add a new todo
	respond( 'POST', '/tasks', function ( $request, $response ) {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'todo-mvc' ) ) {
			return;
		}
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

		todomvc_the_list( todomvc_current_view() );
	} );

	// Change a todo status or title
	respond( 'PUT', '/tasks/[i:id]', function ( $request ) {
		parse_str( file_get_contents( 'php://input' ), $request_vars );
		if ( ! wp_verify_nonce( $request_vars['_wpnonce'], 'todo-mvc' ) ) {
			return;
		}
		if ( ! get_post( $request->id ) ) {
			return;
		}
		$post = get_post( $request->id );
		if ( ! $post ) {
			return;
		}
		if ( isset( $request_vars['new-task-title'] ) ) {
			if ( empty( $request_vars['new-task-title'] ) ) {
				return;
			}
			$id = wp_update_post( [
				'ID'         => $request->id,
				'post_title' => filter_var( $request_vars['new-task-title'], FILTER_SANITIZE_STRING )
			] );
		} else {
			$new_status = $post->post_status == 'completed' ? 'active' : 'completed';
			$id         = wp_update_post( [ 'ID' => $request->id, 'post_status' => $new_status ] );
		}
		if ( $id === false ) {
			return;
		}

		clean_post_cache( $request->id );
		todomvc_the_list( todomvc_current_view() );
	} );

	// Mark all
	respond( 'PUT', '/tasks', function () {
		parse_str( file_get_contents( 'php://input' ), $request_vars );
		if ( ! wp_verify_nonce( $request_vars['_wpnonce'], 'todo-mvc' ) ) {
			return;
		}
		if ( ! isset( $_REQUEST['status-all'] ) || ! in_array( $_REQUEST['status-all'], [ 'active', 'completed' ] ) ) {
			return;
		}
		/** @var \wpdb $wpdb */
		global $wpdb;
		$ok = $wpdb->update( $wpdb->posts, [ 'post_status' => $_REQUEST['status-all'] ], [ 'post_type' => 'task' ] );
		if ( ! $ok ) {
			return;
		}
		todomvc_the_list( todomvc_current_view() );
	} );

	// Delete a todo
	respond( 'DELETE', '/tasks/[i:id]', function ( $request, $response ) {
		parse_str( file_get_contents( 'php://input' ), $request_vars );
		if ( ! wp_verify_nonce( $request_vars['_wpnonce'], 'todo-mvc' ) ) {
			return;
		}
		if ( ! get_post( $request->id ) ) {
			return;
		}
		$id = wp_delete_post( $request->id );
		if ( $id === false ) {
			return;
		}

		todomvc_maybe_hide( $response );
		todomvc_the_list( todomvc_current_view() );
	} );

	// Delete all tasks
	respond( 'DELETE', '/tasks', function ( $request, $response ) {
		parse_str( file_get_contents( 'php://input' ), $request_vars );
		if ( ! wp_verify_nonce( $request_vars['_wpnonce'], 'todo-mvc' ) ) {
			return;
		}
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
		todomvc_the_list( todomvc_current_view() );
	} );
} );
