<html lang="en" data-framework="intercoolerjs">
<head>
	<meta charset="utf-8">
	<title>intercooler.js + WP • TodoMVC</title>
	<?php wp_head() ?>
	<link rel="stylesheet" href="/assets/css/base.css">
	<link rel="stylesheet" href="/assets/css/index.css">
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
	<header class="header">
		<h1>todos</h1>
		<input class="new-todo" placeholder="What needs to be done?" autofocus="">
	</header>
	<section class="main">
		<input class="toggle-all" type="checkbox">
		<label for="toggle-all">Mark all as complete</label>
		<ul class="todo-list">
			<li>
				<div class="view">
					<input class="toggle" type="checkbox">
					<label>Something</label>
					<button class="destroy"></button>
				</div>
				<input class="edit" value="Something">
			</li>
			<li class="completed">
				<div class="view">
					<input class="toggle" type="checkbox" checked="">
					<label>Something else</label>
					<button class="destroy"></button>
				</div>
				<input class="edit" value="Something else">
			</li>
		</ul>
	</section>
	<footer class="footer">
		<span class="todo-count"><strong>1</strong> item left</span>
		<ul class="filters">
			<li>
				<a class="selected" href="#/">All</a>
			</li>
			<li>
				<a href="#/active">Active</a>
			</li>
			<li>
				<a href="#/completed">Completed</a>
			</li>
		</ul>

		<button class="clear-completed">Clear completed</button>

	</footer>
</section>
<footer class="info">
	<p>Double-click to edit a todo</p>

	<p>Written by <a href="https://github.com/addyosmani">Addy Osmani</a></p>

	<p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
</footer>
</body>
<div></div>
</html>

