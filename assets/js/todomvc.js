/*global jQuery:false */
jQuery( document ).ready( function ( $ ) {
	'use strict';

	$( 'body' ).on( 'todomvc/new-task-added', function () {
		$( 'input[name="task-title"]' ).val( '' );
	} );
} );
