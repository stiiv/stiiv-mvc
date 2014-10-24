<!DOCTYPE html>
<html lang="hr">
<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>style.css" />
	<title>Default template<title>
</head>

<body>

	<header>
		<h1>This is the header of the page</h1>
	</header>

	<nav>
		<ul>
			<li>Home</li>
			<li>About</li>
			<li>Contact</li>
		</ul>
	</nav>

	<main>
		<section>
			<article></article>
		</section>
	</main>

	<aside>
		Side bar
	</aside>

	<footer>
		<p>Stiiv &copy; <?php echo date('Y'); ?></p>
	</footer>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/mustache.js/0.8.1/mustache.min.js"></script>
    <script src="<?php echo JS; ?>main.js"></script>
</body>
</html>