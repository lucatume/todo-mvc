<?php
function todomvc_the_list( $status = [ 'active', 'completed' ] ) {
	$todos         = todomvc_get_todos( $status );
	$all_completed = todomvc_get_all_completed( $todos );
	?>
	<section class="main">
		<input class="toggle-all" type="checkbox"
		       ic-put-to="/tasks?status-all=<?php echo $all_completed ? 'active' : 'completed' ?>"
		       ic-target="#todo-list" <?php checked( $all_completed ) ?>>
		<label for="toggle-all">Mark all as complete</label>
		<ul class="todo-list">
			<?php foreach ( $todos as $todo ): ?>
				<?php $class = $todo->post_status == 'active' ? '' : 'class = "completed"'; ?>
				<li <?php echo $class ?>>
					<div class="view">
						<input class="toggle" type="checkbox"
						       ic-put-to="/tasks/<?php echo $todo->ID ?>" <?php checked( 'completed', $todo->post_status ) ?>
						       ic-target="#todo-list">
						<label><?php echo $todo->post_title ?></label>
						<button class="destroy" ic-delete-from="/tasks/<?php echo $todo->ID ?>"
						        ic-target="#todo-list"></button>
					</div>
					<input class="edit" value="<?php echo $todo->post_title ?>">
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<footer class="footer">
		<?php $all_left = array_sum( array_map( function ( $todo ) {
			return $todo->post_status == 'active';
		}, $todos ) ) ?>
		<span
			class="todo-count"><strong><?php echo $all_left ?></strong> <?php echo _n( 'item', 'items', $all_left ? $all_left : 2 ) ?>
			left</span>
		<ul class="filters">
			<li>
				<a <?php echo $status == [ 'active', 'completed' ] || empty( $status ) ? 'class="selected"' : '' ?>
					ic-get-from="/tasks" ic-target="#todo-list" href="#">All</a>
			</li>
			<li>
				<a <?php echo $status == [ 'active' ] ? 'class="selected"' : '' ?> ic-get-from="/tasks?status=active"
				                                                                   ic-target="#todo-list" href="#">Active</a>
			</li>
			<li>
				<a <?php echo $status == [ 'completed' ] ? 'class="selected"' : '' ?>
					ic-get-from="/tasks?status=completed" ic-target="#todo-list" href="#">Completed</a>
			</li>
		</ul>

		<button class="clear-completed" ic-delete-from="/tasks?status=completed" ic-target="#todo-list">Clear
			completed
		</button>
	</footer>
	<?php
}

/**
 * @param $status
 */
function todomvc_get_display( $status=['active','completed'] ) {
	$todos                                  = todomvc_get_todos( $status );
	$all_completed                          = todomvc_get_all_completed( $todos );
	$count                                  = count( $todos );
	$looking_for_active_but_no_active       = $status == [ 'active' ] && $count == $all_completed;
	$looking_for_completed_but_no_completed = $status == [ 'completed' ] && $all_completed == 0;

	return $count == 0 || $looking_for_active_but_no_active || $looking_for_completed_but_no_completed ? 'style="display:none"' : '';
}

/**
 * @param $todos
 *
 * @return number
 */
function todomvc_get_all_completed( $todos ) {
	$all_completed = array_sum( array_map( function ( $post ) {
		return $post->post_status == 'completed';
	}, $todos ) );

	return $all_completed;
}

/**
 * @param $status
 *
 * @return array
 */
function todomvc_get_todos( $status ) {
	$todos = get_posts( [
		'post_type'   => 'task',
		'post_status' => $status,
		'nopaging'    => true
	] );

	return $todos;
}
