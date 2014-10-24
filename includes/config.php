<?php

/****************************
 *                          *
 * DATABASE CONFIGURATION   *
 *                          *
 ****************************/

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "granaroot");
define("DB_NAME", "kolekcija");

/*************************
 *                       *
 * DEFAULT CONTROLLER    *
 *                       *
 *************************/
$controller = "test";


/**************************
 *                        *
 * PATHS                  *
 *                        *
 **************************/

// general
define("DS", DIRECTORY_SEPARATOR);
define("BASE_URL", str_replace('index.php', '', $_SERVER["PHP_SELF"]));

define("CONTROLLERS", "controllers".DS);
define("MODELS", "models".DS);
define("VIEWS", "views".DS);
define("INCLUDES", "includes".DS);
//TEMPLATES
define("TEMPLATES", "templates".DS);
define("HEADER", "public".DS.TEMPLATES."header.php");
define("FOOTER", "public".DS.TEMPLATES."footer.php");
//HTML <head> paths
define("CSS", "public".DS."css".DS);
define("JS", "public".DS."js".DS);
define("IMAGES", "public".DS."images".DS);




/**************************
 *                        *
 * CONSTANTS              *
 *                        *
 **************************/

// SUBMIT FORM
define("FORM_SUBMIT", $_SERVER['REQUEST_METHOD']);
define( "DEFAULT_CONTROLLER", strtolower($controller) );

