<?php
add_action( 'init', function () {
	register_post_type( 'todo' );
	register_post_status( 'active' );
	register_post_status( 'completed' );
} );
