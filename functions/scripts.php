<?php
add_action( 'wp_enqueue_scripts', function () {
	$assets = get_template_directory_uri() . '/assets/';
	wp_enqueue_style( 'base-css', $assets . 'css/base.css' );
	wp_enqueue_style( 'index-css', $assets . 'css/index.css' );
	wp_enqueue_script( 'todomvc-js', $assets . 'js/todomvc.js', [ 'jquery' ] );
} );
