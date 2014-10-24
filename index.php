<?php

// automatically include all files inside folder
foreach(glob("includes/*.php") as $file) {
    require $file;
}

function __autoload($class) {

	// directories to include __autoload
	$dirs = array(
		"libs".DS,
		"helpers".DS
	);

	foreach($dirs as $dir) {
		$dir_class = $dir.$class.".php";

		if(file_exists($dir_class)) {
			require_once($dir_class);
			return;
		}
	}
}

$app = new Bootstrap();
