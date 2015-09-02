<?php
global $todomvc;
$todomvc = new stdClass();

add_action( 'wp_enqueue_scripts', function () {
	$assets = get_template_directory_uri() . '/assets/';
	wp_enqueue_style( 'base-css', $assets . 'css/base.css' );
	wp_enqueue_style( 'index-css', $assets . 'css/index.css' );
} );

// Let's bug the user about the required plugins
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

add_action( 'wp-routes/register_routes', function () {
	// no required plugins? no party.
	global $todomvc;
	if ( ! $todomvc->requirements ) {
		return;
	}
} );
