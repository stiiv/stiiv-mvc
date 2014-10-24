<?php

// automatically include all files inside folder
foreach(glob("includes/*.php") as $file) {
    require $file;
}

function __autoload($class) {
    require_once "libs".DS.$class.".php";
}

$app = new Bootstrap();
//echo '<pre>';
//print_r($_SERVER);
//echo '</pre>';
