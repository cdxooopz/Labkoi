
<?php
## Table ##
define("DB_PREFIX"			, "22e2e");
define("DB_VIEW" , "2e2e");
define("PAGEADMIN"			, "backoffice.php");
define("WEB_PROJECT"		, "2222");

## Path ##
define("SYSTEM_PATH"		,BASE_PATH		. DS . SYSTEM_DIR);
define("PLUNGIN_PATH"		,SYSTEM_PATH 	. DS . "ck_plugin");
define("LIBRARIES_PATH"		,PLUNGIN_PATH 	. DS . "libraries");
define("CONFIG_PATH"		,PLUNGIN_PATH 	. DS . "config");
define("LOG_PATH"			,SYSTEM_PATH 	. DS . "ck.logs");
define("TEMPLATES_PATH"		,PLUNGIN_PATH 	. DS . "templates");
define("CONTROLLER"		,SYSTEM_PATH 	. DS . "controller");
define("VIEW"		,SYSTEM_PATH 	. DS . "views");
define("BACKOFFICE"		,CONTROLLER 	. DS . "backoffice");
define("MODEL"		,  SYSTEM_PATH 	. DS . "model");

## URL ##
define("BASE_URL", "2");
ini_set("log_errors" , "1");
ini_set("error_log" , LOG_PATH . DS . "log-php-".date("Y-m-d").".txt");

require SYSTEM_PATH . DS . "general" . EXT;
require LIBRARIES_PATH . DS . "class.database" . EXT;
require LIBRARIES_PATH . DS . "class.db" . EXT;
require LIBRARIES_PATH . DS . "class.password.generate" . EXT;
require LIBRARIES_PATH . DS . "class.ssp" . EXT;
require LIBRARIES_PATH . DS . "class.upload" . EXT;
require LIBRARIES_PATH . DS . "barcodeAPI" .DS ."Unirest" . EXT;
require LIBRARIES_PATH . DS . "barcode" .DS ."BarcodeGenerator" . EXT;
require LIBRARIES_PATH . DS . "barcode" .DS ."BarcodeGeneratorHTML" . EXT;

## Define Variable ##
define("IS_SPADMIN"		,  ($_SESSION["LOGIN"]["LEVEL"] == 2?true:false));
define("ADMINNAME"		,  $_SESSION["LOGIN"]["USER"]);
define("ADMINID"		,  $_SESSION["LOGIN"]["ID"]);
define("USERDEPERTMENT"		,  $_SESSION["LOGIN"]["DEPERTMENT"]);
$aaa = explode("/", $_SERVER["REQUEST_URI"]);
array_pop($aaa);
$jsCSSPath = end($aaa);
define("PATHPAGE"		,  $jsCSSPath . "Controller");
// $db	= new DB();
$permissionCheck = new Permission;

require(MODEL . DS . "Menu.php");
require(MODEL . DS . "Admin.php");
require(MODEL . DS . "Setting.php");
require(MODEL . DS . "AdminPermission.php");
require(MODEL . DS . "Logging.php");