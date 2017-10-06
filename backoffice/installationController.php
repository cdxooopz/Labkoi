<?php
class cCompile{
	function __construct($db){
		$this->db = $db;
	}
	public function FirstStep(){		
		
		$txts = array();
		$FileDefine = fopen(SYSTEM_PATH . DS . 'ck.define' . EXT, "w") or die("Unable to open file!");
		$_SESSION['installation']['DB_PREFIX'] = p_string('db_prefix');
		$_SESSION['installation']['DB_VIEW'] = p_string('db_view');
		$_SESSION['installation']['WEB_PROJECT'] = p_string('web_project');
		$_SESSION['installation']['BASE_URL'] = p_string('base_url');
		$txts[] = '
<?php';
		$txts[] = '
## Table ##';
		$txts[] = '
define("DB_PREFIX"			, "' . p_string('db_prefix'). '");';
		$txts[] = '
define("DB_VIEW" , "' . p_string('db_view'). '");';
		$txts[] = '
define("PAGEADMIN"			, "backoffice.php");';
		$txts[] = '
define("WEB_PROJECT"		, "' . p_string('web_project'). '");';
		$txts[] = '
';
		$txts[] = '
## Path ##';
		$txts[] = '
define("SYSTEM_PATH"		,BASE_PATH		. DS . SYSTEM_DIR);';
		$txts[] = '
define("PLUNGIN_PATH"		,SYSTEM_PATH 	. DS . "ck_plugin");';
		$txts[] = '
define("LIBRARIES_PATH"		,PLUNGIN_PATH 	. DS . "libraries");';
		$txts[] = '
define("CONFIG_PATH"		,PLUNGIN_PATH 	. DS . "config");';
		$txts[] = '
define("LOG_PATH"			,SYSTEM_PATH 	. DS . "ck.logs");';
		$txts[] = '
define("TEMPLATES_PATH"		,PLUNGIN_PATH 	. DS . "templates");';
		$txts[] = '
define("CONTROLLER"		,SYSTEM_PATH 	. DS . "controller");';
		$txts[] = '
define("VIEW"		,SYSTEM_PATH 	. DS . "views");';
		$txts[] = '
define("BACKOFFICE"		,CONTROLLER 	. DS . "backoffice");';
		$txts[] = '
define("MODEL"		,  SYSTEM_PATH 	. DS . "model");';
		$txts[] = '
';
		$txts[] = '
## URL ##';
		$txts[] = '
define("BASE_URL", "' . p_string('base_url'). '");';
		$txts[] = '
ini_set("log_errors" , "1");';
		$txts[] = '
ini_set("error_log" , LOG_PATH . DS . "log-php-".date("Y-m-d").".txt");';
		$txts[] = '
';
		$txts[] = '
require SYSTEM_PATH . DS . "general" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "class.database" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "class.db" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "class.password.generate" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "class.ssp" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "class.upload" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "barcodeAPI" .DS ."Unirest" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "barcode" .DS ."BarcodeGenerator" . EXT;';
		$txts[] = '
require LIBRARIES_PATH . DS . "barcode" .DS ."BarcodeGeneratorHTML" . EXT;';
		$txts[] = '
';
		$txts[] = '
## Define Variable ##';
		$txts[] = '
define("IS_SPADMIN"		,  ($_SESSION["LOGIN"]["LEVEL"] == 2?true:false));';
		$txts[] = '
define("ADMINNAME"		,  $_SESSION["LOGIN"]["USER"]);';
		$txts[] = '
define("ADMINID"		,  $_SESSION["LOGIN"]["ID"]);';
		$txts[] = '
define("USERDEPERTMENT"		,  $_SESSION["LOGIN"]["DEPERTMENT"]);';
		$txts[] = '
$aaa = explode("/", $_SERVER["REQUEST_URI"]);';
		$txts[] = '
array_pop($aaa);';
		$txts[] = '
$jsCSSPath = end($aaa);';
		$txts[] = '
define("PATHPAGE"		,  $jsCSSPath . "Controller");';
		$txts[] = '
$db	= new DB();';
		$txts[] = '
';
		$txts[] = '
require(MODEL . DS . "Menu.php");';
		$txts[] = '
require(MODEL . DS . "Admin.php");';
		$txts[] = '
require(MODEL . DS . "Setting.php");';
		$txts[] = '
require(MODEL . DS . "AdminPermission.php");';
		$txts[] = '
require(MODEL . DS . "Logging.php");';
		fwrite($FileDefine, implode('', $txts));
		fclose($FileDefine);
		$status = array('STATUS' => 'COMPLETE');
		echo 'COMPLETE';
	}
	public function SecondStep(){
		$txts = array();
		$FileDefine = fopen(CONFIG_PATH . DS . 'settings.ini' . EXT, "w") or die("Unable to open file!");
		
		$_SESSION['installation']['host'] = p_string('host');
		$_SESSION['installation']['user'] = p_string('username');
		$_SESSION['installation']['password'] = p_string('password');
		$_SESSION['installation']['dbname'] = p_string('database');
		
		$txts[] = ';<?php return; ?>
[SQL]
host = ' . p_string('host') . '
user = ' . p_string('username') . '
password = ' . p_string('password') . '
dbname = ' . p_string('database');
		fwrite($FileDefine, implode('', $txts));
		fclose($FileDefine);
		$status = array('STATUS' => 'COMPLETE');
		echo 'COMPLETE';
	}
	public function ThirdStep(){
		$db_prefix = $_SESSION['installation']['DB_PREFIX'];
		$sqlLevelStructure = "CREATE TABLE `{$db_prefix}admin_level` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level_permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level_permission_each` text COLLATE utf8_unicode_ci,
  `level_status` int(11) NOT NULL,
  `level_sort` int(11) DEFAULT '99',
  `level_type` enum('S','C') COLLATE utf8_unicode_ci DEFAULT 'S'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
		$this->db->query($sqlLevelStructure);
		$sqlLevel = "INSERT INTO `{$db_prefix}admin_level` VALUES(2, 'Admin / IT', 'on:on:on:on:on:on:on:','{\"index\":{\"see\":\"on\"},\"admin\":{\"see\":\"on\",\"show\":\"on\",\"insert\":\"on\",\"edit\":\"on\"}}', 1, 0, 'S');";
		
(2, 'Admin / IT', 'on:on:on:on:on:on:on:on:on:', '{"index":{"see":"on"},"admin":{"see":"on","show":"on","insert":"on","edit":"on"}}', 1, 0, 'S'),
		$this->db->query($sqlLevel);
		$sqlLogStructure = "CREATE TABLE `{$db_prefix}logging` (
  `logging_id` int(11) NOT NULL,
  `logging_date` date NOT NULL,
  `logging_time` time NOT NULL,
  `logging_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logging_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `logging_ref_member` int(11) DEFAULT NULL,
  `logging_ref_staff` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($sqlLogStructure);
		$sqlLog = "INSERT INTO `{$db_prefix}logging` (`logging_id`, `logging_date`, `logging_time`, `logging_type`, `logging_description`, `logging_ref_member`, `logging_ref_staff`) VALUES (1, '" . date('Y-m-d') . "', '" . date('H:i:s') . "', 'Installation', 'Installation Lab-Koi Frameworks', '1', '1');";
		$this->db->query($sqlLog);
		$sqlMenuStructure = "CREATE TABLE `{$db_prefix}menu` (
  `menu_id` int(11) NOT NULL,
  `menu_component` varchar(50) NOT NULL DEFAULT '',
  `menu_name` varchar(200) NOT NULL,
  `ref_menu_id` int(11) NOT NULL DEFAULT '0',
  `menu_sort` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `menu_link` varchar(200) NOT NULL,
  `menu_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `menu_admin_create` int(11) DEFAULT NULL,
  `menu_admin_update` int(11) DEFAULT NULL,
  `menu_date_create` int(11) DEFAULT NULL,
  `menu_date_update` int(11) DEFAULT NULL,
  `menu_icon` varchar(255) DEFAULT 'fa fa-circle-o'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$this->db->query($sqlMenuStructure);
		$sqlMenu = "INSERT INTO `{$db_prefix}menu` VALUES(1, 'menu', 'จัดการเมนู', 0, 1, 'menu', 'Y', 2, 2, 1340431517, 1495016361, 'fa fa-list');";
		$this->db->query($sqlMenu);
		$sqlMenu = "INSERT INTO `{$db_prefix}menu` VALUES(2, 'admin', 'จัดการพนักงาน', 0, 1, 'admin', 'Y', 2, 2, 1340431544, 1494840457, 'fa fa-user-secret');";
		$this->db->query($sqlMenu);
		$sqlMenu = "INSERT INTO `{$db_prefix}menu` VALUES(48, 'index', 'รายการหลัก', 0, 0, 'index', 'Y', NULL, 2, NULL, 1495707845, 'fa fa-dashboard');";
		$this->db->query($sqlMenu);

		$sqlUserStructure = "CREATE TABLE `{$db_prefix}user_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(25) NOT NULL DEFAULT '',
  `admin_pass` varchar(255) NOT NULL DEFAULT '',
  `admin_name` varchar(100) NOT NULL,
  `admin_surname` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_tel` varchar(30) NOT NULL DEFAULT '',
  `admin_active` enum('Y','N') DEFAULT 'Y',
  `admin_ip_login` varchar(15) NOT NULL DEFAULT '',
  `admin_admin_create` int(11) DEFAULT NULL,
  `admin_admin_update` int(11) DEFAULT NULL,
  `admin_date_create` int(11) DEFAULT NULL,
  `admin_date_update` int(11) DEFAULT NULL,
  `admin_date_login` int(11) DEFAULT NULL,
  `admin_level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$this->db->query($sqlUserStructure);

		$sqlUser = 'INSERT INTO `' . $db_prefix . 'user_admin` VALUES(2, "admin", "$2y$10$moR8r7tsVH6F9PKjoSwlCu/K0buWURr7oATpRUGN7NRWeNwuCQFh.", "Orange", "Technology Solution", "contact@orange-thailand.com", "02-281-0931", "Y", "::1", 0, 2, 0, 0, 0, 2);';
		$this->db->query($sqlUser);


		$sqlAdditional = "ALTER TABLE `{$db_prefix}admin_level` ADD PRIMARY KEY (`level_id`);";
		$this->db->query($sqlAdditional);
		$sqlAdditional = "ALTER TABLE `{$db_prefix}logging` ADD PRIMARY KEY (`logging_id`);";
		$this->db->query($sqlAdditional);
		$sqlAdditional = "ALTER TABLE `{$db_prefix}menu` ADD PRIMARY KEY (`menu_id`);";
		$this->db->query($sqlAdditional);
		$sqlAdditional = "ALTER TABLE `{$db_prefix}user_admin` ADD PRIMARY KEY (`admin_id`);";
		$this->db->query($sqlAdditional);

		$sqlAdditional = "ALTER TABLE `{$db_prefix}admin_level` MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
		$this->db->query($sqlAdditional);
		$sqlAdditional = "ALTER TABLE `{$db_prefix}logging` MODIFY `logging_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
		$this->db->query($sqlAdditional);
		$sqlAdditional = "ALTER TABLE `{$db_prefix}menu` MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;";
		$this->db->query($sqlAdditional);
		$sqlAdditional = "ALTER TABLE `{$db_prefix}user_admin` MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
		$this->db->query($sqlAdditional);
		$_SESSION['installation']['admin'] = 'admin';
		$_SESSION['installation']['adminPassword'] = "157'0";
		$status = array(
			'STATUS' => 'COMPLETE',
			'DATA' => $_SESSION['installation']
		);
		echo 'COMPLETE';

	}
}
?>