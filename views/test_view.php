<!DOCTYPE html>
<html lang="hr">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $this->var_check($this->title); ?></title>
	<style type="text/css">
		* { padding: 0; margin: 0; }
		body {
			width: 100%;
			color: #19353B;
			background-color: #C7D6D9;
			font-family: Helvetica, Arial, sans-serif;
		}

		.center { text-align: center; }
		.bold { font-weight: bold; }

		.main-title { padding-bottom: 2%; }
		h3 { font-size: 1.5em; margin-bottom: 15px; }
		a {
			padding: .2% .8%;
			margin: 10px .2%;
			text-decoration: none;
			background-color: #19353B;
			color: #ffffff;
			-moz-box-shadow: .1em .1em .3em #74797A;
			-webkit-box-shadow: .1em .1em .3em #74797A;
			box-shadow: .1em .1em .3em #74797A;
		}

		a:hover {
			background-color: #cccccc;
			color: #ffffff;
		}

		#wrapper {
			width: 90%;
			max-width: 1024px;
			margin: 0 auto;
			padding: 1%;
			background-color: #ffffff;
			-moz-box-shadow: .1em .1em 1em #74797A;
			-webkit-box-shadow: .1em .1em 1em #74797A;
			box-shadow: .1em .1em 1em #74797A;
		}

		.section {
			margin: .5em .2em;
			padding: 2%;
			-moz-box-shadow:inset .1em .1em 3em #74797A;
			-webkit-box-shadow:inset .1em .1em 3em #74797A;
			box-shadow:inset .1em .1em .3em #74797A;
		}

		.error { color: red; }
		.success { color: green; }

	</style>
</head>
<body>

	<div id="wrapper">

		<h1 class="center"><?php echo $this->var_check($this->title); ?></h1>
		<h2 class="center main-title">Stiiv-MVC</h2>
		<p class="center"><?php echo $this->var_check($lang_nav); ?></p>

		<section class="section">
			<p class="<?php echo $this->var_check($class); ?> bold">
				<?php echo $this->var_check($change_db); ?>
			</p>
		</section>

		<section class="section">
			<p class="bold">
				DEFAULT CONTROLLER: <span class="success"><?php echo DEFAULT_CONTROLLER; ?></span>
			</p>
		</section>

		<section class="section">
			<h3>Paths:</h3>

			<p class="bold">
				BASE URL: <span class="success"><?php echo BASE_URL; ?></span>
			</p>

			<p class="bold">
				CONTROLLERS: <span class="success"><?php echo CONTROLLERS; ?></span>
			</p>

			<p class="bold">
				MODELS: <span class="success"><?php echo MODELS; ?></span>
			</p>

			<p class="bold">
				VIEWS: <span class="success"><?php echo VIEWS; ?></span>
			</p>

			<br />

			<p class="bold">
				INCLUDES: <span class="success"><?php echo INCLUDES; ?></span>
			</p>

			<p class="bold">
				TEMPLATES: <span class="success"><?php echo TEMPLATES; ?></span>
			</p>

			<p class="bold">
				HEADER: <span class="success"><?php echo HEADER; ?></span>
			</p>

			<p class="bold">
				FOOTER: <span class="success"><?php echo FOOTER; ?></span>
			</p>

			<br />

			<p class="bold">
				CSS: <span class="success"><?php echo CSS; ?></span>
			</p>

			<p class="bold">
				JS: <span class="success"><?php echo JS; ?></span>
			</p>

			<p class="bold">
				JS: <span class="success"><?php echo IMAGES; ?></span>
			</p>
		</section>

	</div>

</body>
</html>
