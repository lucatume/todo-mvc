<?php
/**
 * Requirements
 */
include 'functions/requirements.php';

/**
 * Check requirements or bail
 */
if ( ! todomvc_has_requirements() ) {
	todomvc_add_notice();

	return;
}

/**
 * Post type and status
 */
include 'functions/post-type.php';

/**
 *  Scripts
 */
include 'functions/scripts.php';

/**
 * Routes
 */
include 'functions/routes.php';

/**
 * Output
 */
include 'functions/output.php';
