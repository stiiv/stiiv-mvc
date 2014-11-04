<?php

/****************************
 *                          *
 * DATABASE CONFIGURATION   *
 *                          *
 ****************************/
$db_host = "localhost";
$db_user = "";
$db_pass = "";
$db_name = "";


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
define("HEADER", "includes".DS.TEMPLATES."header.php");
define("FOOTER", "includes".DS.TEMPLATES."footer.php");
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
// DEFAULT CONTROLLER
define( "DEFAULT_CONTROLLER", strtolower($controller) );
// Database configuration
define("DB_HOST", $db_host);
define("DB_USER", $db_user);
define("DB_PASS", $db_pass);
define("DB_NAME", $db_name);

