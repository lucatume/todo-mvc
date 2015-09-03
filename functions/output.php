<?php
function todomvc_the_list( $status = [ 'active', 'completed' ] ) {
	$todos = get_posts( [
		'post_type'   => 'task',
		'post_status' => $status,
		'nopaging'    => true
	] );
	?>
	<section class="main">
		<input class="toggle-all" type="checkbox">
		<label for="toggle-all">Mark all as complete</label>
		<ul class="todo-list">
			<?php foreach ( $todos as $todo ): ?>
				<?php $status = $todo->post_status == 'active' ? '' : 'class = "completed"'; ?>
				<li <?php echo $status ?>>
					<div class="view">
						<input class="toggle" type="checkbox">
						<label><?php echo $todo->post_title ?></label>
						<button class="destroy"></button>
					</div>
					<input class="edit" value="<?php echo $todo->post_title ?>">
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<footer class="footer">
		<span class="todo-count"><strong>1</strong> item left</span>
		<ul class="filters">
			<li>
				<a class="selected" href="#/">All</a>
			</li>
			<li>
				<a href="#/active">Active</a>
			</li>
			<li>
				<a href="#/completed">Completed</a>
			</li>
		</ul>

		<button class="clear-completed">Clear completed</button>
	</footer>
	<?php
}
