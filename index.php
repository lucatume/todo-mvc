<html lang="en" data-framework="intercoolerjs">
<head>
	<meta charset="utf-8">
	<title>intercooler.js + WP • TodoMVC</title>
	<?php wp_head() ?>
</head>
<body class="learn-bar">
<aside class="learn">
	<header>
		<h3>Intercooler.js and WordPress</h3>
		<span class="source-links">
			<h5>intercooler.js</h5>
			<a href="http://intercoolerjs.org/">Homepage</a>,
			<a href="https://github.com/LeadDyno/intercooler-js">Source</a>
			<h5>WordPress</h5>
			<a href="http://wordpress.org">Homepage</a>,
			<a href="https://github.com/wordpress/wordpress">Source</a>
		</span>
	</header>
	<hr>
	<blockquote class="quote speech-bubble"><p>Making AJAX simple as simple as anchor tags</p>
		<footer><a href="http://intercoolerjs.org">intercooler.js</a></footer>
	</blockquote>
	<hr>
	<h4>Official Resources</h4>
	<ul>
		<li><a href="http://intercoolerjs.org/docs">intercooler.js Docs</a></li>
		<li><a href="http://intercoolerjs.org/attributes/all">intercooler.js attributes</a></li>
	</ul>
	<footer>
		<hr>
		<em>If you have other helpful links to share, or find any of the links above no longer work, please <a
				href="https://github.com/tastejs/todomvc/issues">let us know</a>.</em></footer>
</aside>
<section class="todoapp">
	<?php wp_nonce_field( 'todo-mvc' ) ?>
	<header class="header">
		<h1>todos</h1>
		<input class="new-todo" placeholder="What needs to be done?" autofocus="" ic-post-to="/tasks" name="task-title"
		       ic-target="#todo-list">
	</header>
	<div id="todo-list" <?php echo todomvc_get_display() ?>>
		<?php todomvc_the_list() ?>
	</div>
</section>
<footer class="info">
	<p>Double-click to edit a todo</p>

	<p>Written by <a href="https://github.com/addyosmani">Addy Osmani</a></p>

	<p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
</footer>
<?php wp_footer() ?>
</body>
<div></div>
</html>

