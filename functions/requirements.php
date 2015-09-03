<?php
add_action( 'admin_notices', function () {
	global $todomvc;
	$todomvc->requirements = $requirements = is_plugin_active( 'wp-intercooler/intercooler.php' ) && is_plugin_active( 'wp-routes/wp-routes.php' );
	if ( ! $requirements ) {
		?>
		<div class="error">
			<p>The TodoMVC theme requires <a href="https://github.com/lucatume/wp-intercooler" title="wp-intercooler">wp-intercooler</a>
				and
				<a href="https://github.com/lucatume/wp-routes">wp-routes</a> to work: install and/or activate them.</p>
		</div>
		<?php
	}
} );
