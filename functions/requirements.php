<?php
function todomvc_has_requirements() {
	$has_requirements = true;
	$plugins          = [ 'wp-intercooler/intercooler.php', 'wp-routes/wp-routes.php' ];
	foreach ( $plugins as $plugin ) {
		$has_requirements &= in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
	}

	return $has_requirements;
}

function todomvc_add_notice() {
	add_action( 'admin_notices', function () {
		global $todomvc;
		if ( ! $todomvc->requirements ) {
			?>
			<div class="error">
				<p>The TodoMVC theme requires <a href="https://github.com/lucatume/wp-intercooler"
				                                 title="wp-intercooler">wp-intercooler</a>
					and
					<a href="https://github.com/lucatume/wp-routes">wp-routes</a> to work: install and/or activate them.
				</p>
			</div>
			<?php
		}
	} );
}
