/*global jQuery:false */
jQuery( document ).ready( function ( $ ) {
	'use strict';

	$( 'body' )
		.on( 'todomvc/new-task-added', function () {
			$( 'input[name="task-title"]' ).val( '' );
			$( '#todo-list' ).show();
		} )
		.on( 'todomvc/hide', function () {
			$( '#todo-list' ).hide();
		} );

	Intercooler.defaultTransition( 'none' );
} );
