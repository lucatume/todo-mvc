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

	$( 'ul.todo-list li label' ).on( 'dblclick', function () {
		var $label = $( this ),
			$li = $( this ).closest( 'li' ),
			$input = $li.find( 'input.edit' ).first();
		$li.addClass( 'editing' );
		$input.focus();
		$( document ).on( 'keyup', function ( e ) {
			if ( e.keyCode === 27 ) {
				$li.removeClass( 'editing' );
				$input.val = $label.val();
			}
		} );
	} );
} );
